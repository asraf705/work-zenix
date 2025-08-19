<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SecureUserSession;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([SecureUserSession::class])->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
