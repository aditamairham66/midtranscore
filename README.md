# midtranscore
fetch data from midtrans without the need for too much configuration on classes, helpers and others

### Install Command
``composer require aditamairhamdev/midtranscore``

## Installation
1. Open the terminal, navigate to your laravel project directory.
```php
$ composer require aditamairhamdev/midtranscore
```

2. Setting the database configuration, open .env file at project root directory
```
DB_DATABASE=**your_db_name**
DB_USERNAME=**your_db_user**
DB_PASSWORD=**password**
```

3. Run the following command at the terminal
```php
$ php artisan vendor:publish --provider="Aditamairhamdev\MidtransCore\MidtransCoreServiceProvider"
```

#### midtranscore api base
for the midtranscore midtrans fire endpoint there are three endpoints:
- {project_base}/midtrans/credit-card `--METHOD = POST`
- {project_base}/midtrans/gopay `--METHOD = POST`
- {project_base}/midtrans/bank-transfer `--METHOD = POST`

#### midtranscore : api [Credit Card]
To retrieve a response from a credit card it is necessary to enter the following parameters
``` bash
{
    "card_number": "5211 1111 1111 1117", // example card number
    "card_exp_month": "12", // example month
    "card_exp_year": "2021", // example year
    "card_cvv": "123", // example cvv
    "with_3ds": true, // add if you want to use 3ds authentication
    "transaction_details": {
        "order_id": "order-qwerty-{{$timestamp}}",
        "gross_amount": 10000
    },
    "customer_details": {
        "first_name": "Udin",
        "last_name": "Cecep",
        "email": "cecep@gmail.com",
        "phone": "081230189469"
    },
    "item_details": [{
        "id" : 1,
        "price": 10000,
        "quantity": 1,
        "name": "order"
    }]
}
```
you will get a response from midtrans
```
{
    "status_code": "201",
    "status_message": "Success, Credit Card transaction is successful",
    "bank": "cimb",
    "transaction_id": "a7f91127-caca-42bb-b020-b1d5d00c86d8",
    "order_id": "order-qwerty-1607744911",
    "redirect_url": "https://api.sandbox.veritrans.co.id/v2/token/rba/redirect/521111-1117-a7f91127-caca-42bb-b020-b1d5d00c86d8",
    "merchant_id": "G328968496",
    "gross_amount": "10000.00",
    "currency": "IDR",
    "payment_type": "credit_card",
    "transaction_time": "2020-12-12 10:48:25",
    "transaction_status": "pending",
    "fraud_status": "accept",
    "masked_card": "521111-1117",
    "card_type": "debit"
}
```
#### midtranscore : api [Gopay]
To retrieve a response from a gopay it is necessary to enter the following parameters
```
{
    "callback_url": "", // if it uses its own url callback
    "transaction_details": {
        "order_id": "order-qwerty-{{$timestamp}}",
        "gross_amount": 10000
    },
    "customer_details": {
        "first_name": "Udin",
        "last_name": "Cecep",
        "email": "cecep@gmail.com",
        "phone": "081230189469"
    },
    "item_details": [{
        "id" : 1,
        "price": 10000,
        "quantity": 1,
        "name": "order"
    }]
}
```
you will get a response from midtrans
```
{
    "status_code": "201",
    "status_message": "GoPay transaction is created",
    "transaction_id": "a8d71cfa-969f-4d62-aa95-b54f747b28fd",
    "order_id": "order-qwerty-1607745365",
    "merchant_id": "G328968496",
    "gross_amount": "10000.00",
    "currency": "IDR",
    "payment_type": "gopay",
    "transaction_time": "2020-12-12 10:55:51",
    "transaction_status": "pending",
    "fraud_status": "accept",
    "actions": [
        {
            "name": "generate-qr-code",
            "method": "GET",
            "url": "https://api.sandbox.veritrans.co.id/v2/gopay/a8d71cfa-969f-4d62-aa95-b54f747b28fd/qr-code"
        },
        {
            "name": "deeplink-redirect",
            "method": "GET",
            "url": "https://simulator.sandbox.midtrans.com/gopay/partner/app/payment-pin?id=01166610-fa15-4ff8-b0f9-001f250dc931"
        },
        {
            "name": "get-status",
            "method": "GET",
            "url": "https://api.sandbox.veritrans.co.id/v2/a8d71cfa-969f-4d62-aa95-b54f747b28fd/status"
        },
        {
            "name": "cancel",
            "method": "POST",
            "url": "https://api.sandbox.veritrans.co.id/v2/a8d71cfa-969f-4d62-aa95-b54f747b28fd/cancel"
        }
    ]
}
```
#### midtranscore : api [Bank Transfer]
To retrieve a response from a bank transfer it is necessary to enter the following parameters
```
{
    "bank_name": "BNI",
    "transaction_details": {
        "order_id": "order-qwerty-{{$timestamp}}",
        "gross_amount": 10000
    },
    "customer_details": {
        "first_name": "Udin",
        "last_name": "Cecep",
        "email": "cecep@gmail.com",
        "phone": "081230189469"
    },
    "item_details": [{
        "id" : 1,
        "price": 10000,
        "quantity": 1,
        "name": "order"
    }]
}
```
you will get a response from midtrans
```
{
    "status_code": "201",
    "status_message": "Success, Bank Transfer transaction is created",
    "transaction_id": "00a5027e-be4c-44bd-8880-16e780e7ad76",
    "order_id": "order-qwerty-1607746147",
    "merchant_id": "G328968496",
    "gross_amount": "10000.00",
    "currency": "IDR",
    "payment_type": "bank_transfer",
    "transaction_time": "2020-12-12 11:08:52",
    "transaction_status": "pending",
    "va_numbers": [
        {
            "bank": "bni",
            "va_number": "9886849634055039"
        }
    ],
    "fraud_status": "accept"
}
```
in a bank transfer there is a list of banks that can be processed, among others
```
'BCA', 'Permata', 'BNI', 'Mandiri'
```
