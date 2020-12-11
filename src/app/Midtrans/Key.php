<?php

namespace Aditamairhamdev\MidtransCore\App\Midtrans;

trait Key
{
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function setProduction()
    {
        return config("midtranscore.is_production");
    }

    /**
     * server key midtrans
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function setServerKey()
    {
        $isProduction = static::setProduction();
        if ($isProduction === true) {
            $serverKey = config("midtranscore.server_key_prod");
        } else {
            $serverKey = config("midtranscore.server_key_dev");
        }

        return $serverKey;
    }

    /**
     * client key midtrans
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function setClientKey()
    {
        $isProduction = static::setProduction();
        if ($isProduction === true) {
            $clientKey = config("midtranscore.client_key_prod");
        } else {
            $clientKey = config("midtranscore.client_key_dev");
        }

        return $clientKey;
    }

    /**
     * charge link midtrans
     * @return string
     */
    public static function setChargeLink()
    {
        $isProduction = static::setProduction();
        if ($isProduction === true) {
            $chargeLink = "https://api.midtrans.com/v2/charge";
        } else {
            $chargeLink = "https://api.sandbox.midtrans.com/v2/charge";
        }

        return $chargeLink;
    }

    /**
     * token link midtrans credit card
     * @return string
     */
    public static function setTokenLinkCreditCard()
    {
        $isProduction = static::setProduction();
        if ($isProduction === true) {
            $tokenLink = "https://api.midtrans.com/v2/token";
        }else{
            $tokenLink = "https://api.sandbox.midtrans.com/v2/token";
        }

        return $tokenLink;
    }
}
