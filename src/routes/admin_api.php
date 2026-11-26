<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/register', [AdminAuthController::class, 'register']);

Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin/me', [AdminAuthController::class, 'user']);
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

    Route::get('/admin/dashboard-stats', [AdminDashboardController::class, 'stats']);
    Route::get('/admin/orders', [AdminDashboardController::class, 'orders']);
    Route::get('/admin/menu', [AdminDashboardController::class, 'menu']);
    Route::post('/admin/products', [AdminDashboardController::class, 'createProduct']);
    Route::patch('/admin/products/{id}', [AdminDashboardController::class, 'updateProduct']);
    Route::post('/admin/products/{id}', [AdminDashboardController::class, 'updateProduct']);
    Route::post('/admin/products/{id}/image', [AdminDashboardController::class, 'updateProduct']);
    Route::delete('/admin/products/{id}', [AdminDashboardController::class, 'deleteProduct']);
    Route::patch('/admin/orders/{id}/status', [AdminDashboardController::class, 'updateOrder']);
    Route::patch('/admin/payments/{id}/status', [AdminDashboardController::class, 'updatePayment']);
    Route::post('/admin/drivers/{id}/settle-cod', [AdminDashboardController::class, 'settleDriver']);
    Route::post('/admin/restaurants/{id}/payout', [AdminDashboardController::class, 'markPayout']);
    Route::patch('/admin/restaurants/{id}/toggle', [AdminDashboardController::class, 'toggleRestaurant']);
    Route::patch('/admin/products/{id}/toggle', [AdminDashboardController::class, 'toggleProduct']);
    Route::post('/admin/complaints/{id}/resolve', [AdminDashboardController::class, 'resolveComplaint']);
});

Route::get('/menu', [AdminDashboardController::class, 'menu']);
Route::get('/products', [AdminDashboardController::class, 'publicProducts']);
