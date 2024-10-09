<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customers', CustomerController::class);
Route::delete('customers/{id}/force-delete', [CustomerController::class, 'forceDelete']);
Route::post('customers/{id}/restore', [CustomerController::class, 'restore']);
Route::get('customers/{id}/orders', [CustomerController::class, 'getCustomerOrders']);
Route::get('customers/{id}/latest-payment', [CustomerController::class, 'getLatestPayment']);
Route::get('customers/{id}/oldest-payment', [CustomerController::class, 'getOldestPayment']);
Route::get('customers/{id}/highest-payment', [CustomerController::class, 'getHighestPayment']);
Route::get('customers/{id}/lowest-payment', [CustomerController::class, 'getLowestPayment']);



Route::apiResource('orders', OrderController::class);
Route::delete('orders/{id}/force-delete', [OrderController::class, 'forceDelete']);
Route::post('orders/{id}/restore', [OrderController::class, 'restore']);

Route::apiResource('payments', PaymentController::class);
Route::delete('payments/{id}/force-delete', [PaymentController::class, 'forceDelete']);
Route::post('payments/{id}/restore', [PaymentController::class, 'restore']);
