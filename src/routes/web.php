<?php

Route::group(['namespace' => 'Aditamairhamdev\MidtransCore\App\Http\Controllers'], function ()
{
    Route::post('midtrans/credit-card', 'MidtransCoreController@postIndexCreditCard');
    Route::post('midtrans/gopay', 'MidtransCoreController@postIndexGopay');
    Route::post('midtrans/bank-transfer', 'MidtransCoreController@postIndexBankTransfer');
});
