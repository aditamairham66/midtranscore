<?php


namespace Aditamairhamdev\MidtransCore\app\Repositories;

use Aditamairhamdev\MidtransCore\App\Models\MidtranscorePayment;

class MidtransCorePaymentRepository
{
    public static function save($data)
    {
        $save['code_payment'] = (!empty($data['order_id']) ? $data['order_id'] : null);
        $save['method_payment'] = (!empty($data['payment_type']) ? $data['payment_type'] : null);
        $save['ammount_payment'] = (!empty($data['gross_amount']) ? $data['gross_amount'] : null);
        $save['status_payment'] = (!empty($data['transaction_status']) ? $data['transaction_status'] : null);
        $save['created_at'] = date('Y-m-d H:i:s');
        MidtranscorePayment::insert($save);
    }
}
