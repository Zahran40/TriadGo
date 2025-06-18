<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans payment gateway integration
    |
    */

    /**
     * Your merchant id
     */
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    /**
     * Your client key
     */
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    /**
     * Your server key
     */
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    /**
     * Set to false for sandbox mode (testing), true for production mode (live)
     */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /**
     * Set sanitization to true if you want to remove null, empty string, and empty array from the result
     */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /**
     * Set 3DS to true if you want to enable 3D Secure
     */
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
