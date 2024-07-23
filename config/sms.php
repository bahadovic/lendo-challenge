<?php

return [

    'SmsA' => [
        'endpoint' => env('SMS_A_END_POINT', ''),
        'username' => env('SMS_A_USERNAME', ''),
        'password' => env('SMS_A_PASSWORD', ''),
    ],
    'SmsB' => [
        'endpoint' => env('SMS_B_END_POINT', ''),
        'username' => env('SMS_B_USERNAME', ''),
        'password' => env('SMS_B_PASSWORD', ''),
    ],
    'SmsC' => [
        'endpoint' => env('SMS_C_END_POINT', ''),
        'username' => env('SMS_C_USERNAME', ''),
        'password' => env('SMS_C_PASSWORD', ''),
    ]

];
