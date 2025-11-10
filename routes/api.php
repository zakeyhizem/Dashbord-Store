<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Product routes
Route::apiResource('products', ProductController::class);

// Order routes
Route::apiResource('orders', OrderController::class);

// Payment routes
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::get('/{payment}', [PaymentController::class, 'show']);
    Route::post('/stripe', [PaymentController::class, 'createStripePayment']);
    Route::post('/paypal', [PaymentController::class, 'createPayPalPayment']);
});

// Notification routes
Route::prefix('notifications')->group(function () {
    Route::post('/send-to-device', [NotificationController::class, 'sendToDevice']);
    Route::post('/send-to-multiple-devices', [NotificationController::class, 'sendToMultipleDevices']);
    Route::post('/send-to-topic', [NotificationController::class, 'sendToTopic']);
});

// Export routes
Route::prefix('exports')->group(function () {
    Route::get('/orders/excel', [ExportController::class, 'exportOrdersToExcel']);
    Route::get('/products/excel', [ExportController::class, 'exportProductsToExcel']);
    Route::get('/orders/pdf', [ExportController::class, 'exportOrdersToPdf']);
    Route::post('/s3/upload', [ExportController::class, 'uploadToS3']);
});
