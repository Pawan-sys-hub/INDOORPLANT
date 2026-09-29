<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'esewa' => [
        'merchant_code'   => env('ESEWA_MERCHANT_CODE', 'EPAYTEST'),
        'secret'          => env('ESEWA_SECRET', '8gBm/:&EnhH.1/q'),
        'endpoint'        => env('ESEWA_API_ENDPOINT', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form'),
        'status_endpoint' => env('ESEWA_STATUS_ENDPOINT', 'https://rc-epay.esewa.com.np/api/epay/transaction/status/'),
    ],

];
