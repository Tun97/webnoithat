<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'ghn' => [
        'token' => env('GHN_TOKEN'),
        'base_url' => env('GHN_BASE_URL', 'https://online-gateway.ghn.vn/shiip/public-api'),
    ],

    'momo' => [
        'partner_code' => env('MOMO_PARTNER_CODE'),
        'access_key' => env('MOMO_ACCESS_KEY'),
        'secret_key' => env('MOMO_SECRET_KEY'),
        'bank_code' => env('MOMO_BANK_CODE'),
        'endpoint' => env('MOMO_END_POINT', 'https://test-payment.momo.vn/v2/gateway/api/create'),
        'complete_on_return' => env('MOMO_COMPLETE_ON_RETURN', env('APP_ENV', 'production') !== 'production'),
        'min_amount' => (int) env('MOMO_MIN_AMOUNT', 1000),
        'max_amount' => (int) env('MOMO_MAX_AMOUNT', 50000000),
        'sandbox_amount' => (int) env('MOMO_SANDBOX_AMOUNT', 10000),
    ],

    'vietqr' => [
        'bank' => env('VIETQR_BANK'),
        'account' => env('VIETQR_ACCOUNT'),
        'account_name' => env('VIETQR_ACCOUNT_NAME'),
        'template' => env('VIETQR_TEMPLATE', 'compact2'),
        'add_info_prefix' => env('VIETQR_ADD_INFO_PREFIX', 'ORDER'),
    ],

];
