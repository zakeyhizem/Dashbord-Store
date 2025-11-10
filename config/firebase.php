<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Firebase Cloud Messaging and other Firebase services.
    |
    */

    'credentials' => env('FIREBASE_CREDENTIALS'),

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL'),
    ],

    'project_id' => env('FIREBASE_PROJECT_ID'),

    'server_key' => env('FIREBASE_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Cloud Messaging Configuration
    |--------------------------------------------------------------------------
    */

    'messaging' => [
        'enabled' => env('FIREBASE_MESSAGING_ENABLED', true),
    ],

];
