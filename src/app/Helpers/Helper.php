<?php

namespace Aditamairhamdev\MidtransCore\App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

class Helper
{
    /**
     * @param array $data
     */
    public static function Validator($data = [])
    {
        $validator = Validator::make(Request::all(), $data);

        if ($validator->fails()) {
            $result = array();
            $message = $validator->errors();
            $result['status_code'] = 0;
            $result['status_message'] = $message->all(':message')[0];
            $res = response()->json($result, 200);
            $res->send();
            exit;
        }
    }

    public static function typeBank($name_bank)
    {
        switch ($name_bank) {
            case 'Mandiri':
                $ret = "mandiri";
                break;

            case 'BNI':
                $ret = "bni";
                break;

            case 'Permata':
                $ret = "permata";
                break;

            case 'BCA':
                $ret = "bca";
                break;

            default:
                $ret = null;
                break;
        }

        return $ret;
    }
}
