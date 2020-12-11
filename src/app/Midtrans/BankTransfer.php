<?php

namespace Aditamairhamdev\MidtransCore\App\Midtrans;

use Aditamairhamdev\MidtransCore\App\Midtrans\Key;
use Aditamairhamdev\MidtransCore\App\Repositories\MidtransCorePaymentRepository;

class BankTransfer
{
    use Key;

    public $transaction_details;
    public $customer_details;
    public $item_details;
    public $bank_name;

    public $message;

    function BankTransfer()
    {
        // midtrans authorization
        $serverKey = static::setServerKey();
        $chargeLink = static::setChargeLink();

        // generate authorization token
        $Authorization = "Basic ".base64_encode($serverKey);

        if ($this->bank_name == 'mandiri') {
            $req['payment_type'] = "echannel";
        } else {
            $req['payment_type'] = "bank_transfer";
        }
        $req['transaction_details'] = $this->transaction_details;
        $req['customer_details'] =  $this->customer_details;
        $req['item_details'] = $this->item_details;
        if ($this->bank_name == 'mandiri') {
            $req['echannel'] = array(
                'bill_info1' => config('midtranscore.bill_info1'),
                'bill_info2' => config('midtranscore.bill_info2'),
            );
        } else {
            $req['bank_transfer'] = array(
                'bank' => $this->bank_name,
            );
        }
        // format to json encode
        $request = json_encode($req);
        $request = (string) $request;
        // set curl
        $curl = curl_init();
        // setting curl
        curl_setopt_array($curl, array(
            CURLOPT_URL => $chargeLink,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: ".$Authorization
            ),
        ));
        // execute from curl
        $response = curl_exec($curl);
        // return response from curl
        $response = json_decode($response, true);

        MidtransCorePaymentRepository::save($response);

        return $this->message = $response;
    }
}
