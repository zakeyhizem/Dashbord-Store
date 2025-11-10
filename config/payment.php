<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Gateways Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for all payment gateways supported
    | by the admin dashboard. Each gateway has its own configuration section.
    |
    */

    'default' => env('PAYMENT_GATEWAY', 'stripe'),

    'gateways' => [

        'stripe' => [
            'enabled' => env('STRIPE_ENABLED', true),
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            'currency' => env('STRIPE_CURRENCY', 'usd'),
        ],

        'paypal' => [
            'enabled' => env('PAYPAL_ENABLED', true),
            'mode' => env('PAYPAL_MODE', 'sandbox'),
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'secret' => env('PAYPAL_SECRET'),
            'currency' => env('PAYPAL_CURRENCY', 'USD'),
        ],

    ],

];
