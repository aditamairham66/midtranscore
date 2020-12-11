<?php

namespace Aditamairhamdev\MidtransCore\App\Midtrans;

use Aditamairhamdev\MidtransCore\App\Midtrans\Key;
use Aditamairhamdev\MidtransCore\App\Repositories\MidtransCorePaymentRepository;

class Gopay
{
    use Key;

    public $transaction_details;
    public $customer_details;
    public $item_details;
    public $callback_url;

    public $message;

    function Gopay()
    {
        // midtrans authorization
        $serverKey = static::setServerKey();
        $chargeLink = static::setChargeLink();

        // generate authorization token
        $Authorization = "Basic ".base64_encode($serverKey);

        $req['payment_type'] = "gopay";
        $req['transaction_details'] = $this->transaction_details;
        $req['customer_details'] =  $this->customer_details;
        $req['item_details'] = $this->item_details;
        $req['gopay'] = array(
            'enable_callback' => ($this->callback_url !== '' ? true : false),
            // deeplink redirect gopay
            'callback_url' => $this->callback_url,
        );
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
