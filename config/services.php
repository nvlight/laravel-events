<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'events' => [
        'paginate_number' => 15
    ],

    'shorturl' => [
        'char_number' => 7,
        'paginate_number' => 15
    ],

    'documents' => [
        'path2save' => 'ev_documents'
    ],

    'cbr' => [
        'path2save' => 'exchange_rate',
        'url_json' =>  env('EVENTO_EXCHANGE_RATE_URL', 'http://www.cbr-xml-daily.ru/daily_json.js'),
        'timeout' => 3,
        'filename' => 'cbr-xml-daily.json_decoded',
        'white_list' => ['933','840',826,978,156,980],
        'active_days' => 2
    ],

    'sts' => [ // simple test system
        'test_start_session_key' => 'test_start',
    ],

];
