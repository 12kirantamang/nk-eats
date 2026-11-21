<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripeCheckoutController;

Route::get('/', function () {
    $html = file_get_contents(resource_path('views/nk-eats.blade.php'));

    $documentStart = strpos($html, '<!DOCTYPE html>', strpos($html, '<!DOCTYPE html>') + 1);

    if ($documentStart === false) {
        $documentStart = strpos($html, '<!DOCTYPE html>');
    }

    if ($documentStart !== false) {
        $html = substr($html, $documentStart);
        $documentEnd = strpos($html, '</html>');

        if ($documentEnd !== false) {
            $html = substr($html, 0, $documentEnd + 7);
        }
    }

    return response($html)->header('Content-Type', 'text/html');
});

Route::get('/auth/status', [AuthController::class, 'status']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/admin', function () {
    return view('admin.panel');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [StripeCheckoutController::class, 'show']);
    Route::post('/checkout', [StripeCheckoutController::class, 'checkout']);
    Route::get('/checkout/success', [StripeCheckoutController::class, 'success']);
});
