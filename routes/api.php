<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\TwoFactorController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/resend-activation', [RegisterController::class, 'resendActivation']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotController::class, 'resetPassword']);
Route::get('/check-activation', [ActivateAccountController::class, 'checkActivation']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/2fa/setup', [TwoFactorController::class, 'showQRCode']);
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);
});

//routes admin quản trị
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/update-user/{id}', [UserController::class, 'updateUser']);
    Route::put('/lock-user/{id}', [UserController::class, 'LockAccount']);
    Route::delete('/delete-user/{id}', [UserController::class, 'RemoveUser']);
    Route::get('/show-log', [UserController::class, 'showLog']);
});