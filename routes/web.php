<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SuperAdminAccess;
use App\Http\Controllers\Auth\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[AuthController::class,'loginFrom'])->name('login');
Route::get('/register',[AuthController::class,'registerFrom'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware([SuperAdminAccess::class])->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
