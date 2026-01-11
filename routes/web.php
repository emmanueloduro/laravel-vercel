<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
Route::get('/test', function () {
    return 'Laravel is working! Server time: ' . now();
});
Route::get('/', [PaymentController::class, 'index'])->name('home');

// Payment Routes
Route::prefix('payment')->group(function () {
    Route::get('/card', [PaymentController::class, 'cardPayment'])->name('payment.card');
    Route::post('/process/card', [PaymentController::class, 'processCard'])->name('payment.process.card');
    Route::get('/callback', [PaymentController::class, 'callback'])->name('payment.callback'); // ADD THIS
    Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/failed', [PaymentController::class, 'failed'])->name('payment.failed');
});
