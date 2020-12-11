<?php

namespace Aditamairhamdev\MidtransCore\App\Midtrans;

use Aditamairhamdev\MidtransCore\App\Midtrans\Key;
use Aditamairhamdev\MidtransCore\App\Repositories\MidtransCorePaymentRepository;

class CreditCard
{
    use Key;

    public $card_number;
    public $card_exp_month;
    public $card_exp_year;
    public $card_cvv;

    public $transaction_details;
    public $customer_details;
    public $item_details;
    public $with_3ds;

    public $message;
    private static $token;
    private static $msg_token;

    function CreditCard()
    {
        // midtrans authorization
        $serverKey = static::setServerKey();
        $chargeLink = static::setChargeLink();

        // generate authorization token
        $Authorization = "Basic ".base64_encode($serverKey);
        // get token for credit card
        $tokenCard = static::getTokenCreditCard($this->card_number, $this->card_exp_month, $this->card_exp_year, $this->card_cvv);
        if (static::$token === false) {
            return $this->message = static::$msg_token;
        }

        $req['payment_type'] = "credit_card";
        $req['transaction_details'] = $this->transaction_details;
        $req['customer_details'] =  $this->customer_details;
        $req['item_details'] = $this->item_details;
        $req['credit_card'] = array(
            'token_id' => static::$token,
            // jika pake 3ds credit card
            'authentication' => ($this->with_3ds ? true :false),
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

    public static function getTokenCreditCard($cardNumber, $cardMonth, $cardYear, $cardCvv)
    {
        // midtrans authorization
        $clientKey = static::setClientKey();
        $tokenLink = static::setTokenLinkCreditCard();

        // request data token card
        $card_number = str_replace(' ', '', $cardNumber);
        $card_exp_month = str_replace(' ', '', $cardMonth);
        $card_exp_year = str_replace(' ', '', $cardYear);
        $card_cvv = str_replace(' ', '', $cardCvv);
        // format to parameters
        $req = '?client_key='.$clientKey.'&card_number='.$card_number.'&card_exp_month='.$card_exp_month.'&card_exp_year='.$card_exp_year.'&card_cvv='.$card_cvv;
        // set curl
        $curl = curl_init();
        // setting curl
        curl_setopt_array($curl, array(
            CURLOPT_URL => $tokenLink.$req,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json"
            ),
        ));
        // execute from curl
        $response = curl_exec($curl);
        // return response from curl
        $response = json_decode($response, true);
        if (!empty($response['token_id'])) {
            return static::$token = $response['token_id'];
        }else{
            static::$msg_token = $response;
            return static::$token = false;
        }
    }
}
