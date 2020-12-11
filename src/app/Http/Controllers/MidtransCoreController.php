<?php

namespace Aditamairhamdev\MidtransCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aditamairhamdev\MidtransCore\App\Models\MidtranscorePayment;
use Aditamairhamdev\MidtransCore\App\Midtrans\CreditCard;
use Aditamairhamdev\MidtransCore\App\Midtrans\Gopay;
use Aditamairhamdev\MidtransCore\App\Midtrans\BankTransfer;
use Aditamairhamdev\MidtransCore\App\Helpers\Helper;

class MidtransCoreController extends Controller
{
    public function postIndexCreditCard(Request $request)
    {
        $validate['card_number'] = "required";
        $validate['card_exp_month'] = "required";
        $validate['card_exp_year'] = "required";
        $validate['card_cvv'] = "required";
        $validate['with_3ds'] = "required";
        $validate['transaction_details'] = "required";
        $validate['customer_details'] = "required";
        $validate['item_details'] = "required";
        Helper::Validator($validate);

        $card_number = $request->input('card_number');
        $card_exp_month = $request->input('card_exp_month');
        $card_exp_year = $request->input('card_exp_year');
        $card_cvv = $request->input('card_cvv');
        $with_3ds = $request->input('with_3ds');

        $transaction_details = $request->input('transaction_details');
        $customer_details = $request->input('customer_details');
        $item_details = $request->input('item_details');

        $midtrans = new CreditCard();
        $midtrans->card_number = $card_number;
        $midtrans->card_exp_month = $card_exp_month;
        $midtrans->card_exp_year = $card_exp_year;
        $midtrans->card_cvv = $card_cvv;
        $midtrans->with_3ds = $with_3ds;
        $midtrans->transaction_details = $transaction_details;
        $midtrans->customer_details = $customer_details;
        $midtrans->item_details = $item_details;
        $midtrans->CreditCard();
        if ($midtrans->message !== '') {
            return response()->json($midtrans->message, 200);
        } else {
            $res['status_code'] = 0;
            $res['status_message'] = "Opps, something went wrong !";
            return response()->json($res, 400);
        }

    }

    public function postIndexGopay(Request $request)
    {
        $validate['transaction_details'] = "required";
        $validate['customer_details'] = "required";
        $validate['item_details'] = "required";
        Helper::Validator($validate);

        $callback_url = $request->input('callback_url');
        $transaction_details = $request->input('transaction_details');
        $customer_details = $request->input('customer_details');
        $item_details = $request->input('item_details');

        $midtrans = new Gopay();
        $midtrans->callback_url = $callback_url;
        $midtrans->transaction_details = $transaction_details;
        $midtrans->customer_details = $customer_details;
        $midtrans->item_details = $item_details;
        $midtrans->Gopay();
        if ($midtrans->message !== '') {
            return response()->json($midtrans->message, 200);
        } else {
            $res['status_code'] = 0;
            $res['status_message'] = "Opps, something went wrong !";
            return response()->json($res, 400);
        }
    }

    public function postIndexBankTransfer(Request $request)
    {
        $validate['bank_name'] = "required";
        $validate['transaction_details'] = "required";
        $validate['customer_details'] = "required";
        $validate['item_details'] = "required";
        Helper::Validator($validate);

        $bank_name = $request->input('bank_name');
        $transaction_details = $request->input('transaction_details');
        $customer_details = $request->input('customer_details');
        $item_details = $request->input('item_details');

        if (!in_array($bank_name, config('bank_list.bank_list')))
        {
            $res['status_code'] = 0;
            $res['status_message'] = "Sorry the bank you entered is not listed in our list.";
            return response()->json($res, 400);
        }

        $midtrans = new BankTransfer();
        $midtrans->bank_name = Helper::typeBank($bank_name);
        $midtrans->transaction_details = $transaction_details;
        $midtrans->customer_details = $customer_details;
        $midtrans->item_details = $item_details;
        $midtrans->BankTransfer();
        if ($midtrans->message !== '') {
            return response()->json($midtrans->message, 200);
        } else {
            $res['status_code'] = 0;
            $res['status_message'] = "Opps, something went wrong !";
            return response()->json($res, 400);
        }
    }
}
