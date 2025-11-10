<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'name' => 'Dashboard Store API',
        'version' => '1.0.0',
        'description' => 'Admin dashboard for a modular e-commerce store built with Laravel 10',
        'features' => [
            'Multiple payment gateways (Stripe, PayPal)',
            'Firebase notifications',
            'Excel/PDF exports',
            'S3 storage',
            'Extensible modules',
        ],
    ]);
});
