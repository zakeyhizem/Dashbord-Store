<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the modular architecture of the
    | admin dashboard. Modules can be enabled/disabled and configured here.
    |
    */

    'modules_path' => app_path('Modules'),

    'enabled_modules' => [
        'Products',
        'Orders',
        'Customers',
        'Payments',
        'Reports',
        'Notifications',
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Auto-Discovery
    |--------------------------------------------------------------------------
    |
    | When enabled, the system will automatically discover and load modules
    | from the modules path.
    |
    */

    'auto_discover' => env('MODULES_AUTO_DISCOVER', true),

];
