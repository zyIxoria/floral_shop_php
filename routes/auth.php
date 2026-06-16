<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::middleware('guest')->group(function () {

    Route::get('/login',
        [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login',
        [AuthenticatedSessionController::class, 'store']);

    Route::get('/register',
        [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register',
        [RegisteredUserController::class, 'store']);

    // Quên / đổi mật khẩu
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');

    Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyCodeForm'])->name('password.verify.form');
    Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify');

    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

});

Route::post('/logout',
    [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
