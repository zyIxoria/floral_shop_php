<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\CouponAdminController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard',
            [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products',
            ProductAdminController::class);

        Route::resource('categories',
            CategoryAdminController::class);

        Route::resource('coupons',
            CouponAdminController::class);

        Route::get('/orders',
            [OrderAdminController::class, 'index'])
            ->name('orders.index');

        Route::get('/users',
            [UserAdminController::class, 'index'])
            ->name('users.index');

});