<?php

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
        'client_id'         => env('PAYPAL_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_CLIENT_SECRET', ''),
        'app_id'            => '',
    ],
    'live' => [
        'client_id'         => env('PAYPAL_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_CLIENT_SECRET', ''),
        'app_id'            => '',
    ],
    'currency'       => env('PAYPAL_CURRENCY', 'PHP'),
    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'notify_url'     => '', // Change this accordingly for your application.
    'locale'         => 'en_US',
    'validate_ssl'   => true, // Validate SSL when creating API client.
    'log' => [
        'enabled'  => env('PAYPAL_LOG_ENABLED', false),
        'level'    => env('PAYPAL_LOG_LEVEL', 'DEBUG'),
        'file'     => storage_path('logs/paypal.log'),
    ],
];
