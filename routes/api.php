<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Frontend\ResetPasswordController;
use App\Http\Controllers\Frontend\ShowInfoController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/resend-activation', [RegisterController::class, 'resendActivation']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotController::class, 'resetPassword']);
Route::get('/check-activation', [ActivateAccountController::class, 'checkActivation']);

//routes auth
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/2fa/setup', [TwoFactorController::class, 'showQRCode']);
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);
});

//routes frontend
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/showinfo', [ShowInfoController::class, 'getUser']);
    Route::put('/update-info', [ShowInfoController::class, 'updateInfo']);
    Route::post('/update-password', [ResetPasswordController::class, 'resetPasswordUser']);
    Route::get('/showqr', [TwoFactorController::class, 'showQRCodeView'])->name('2fa.qr');
});

//routes admin quản trị
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/get-user', [UserController::class, 'getUser']);
    Route::get('/get-user-id/{id}', [UserController::class, 'getUserById']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/update-user/{id}', [UserController::class, 'updateUser']);
    Route::put('/lock-user/{id}', [UserController::class, 'LockAccount']);
    Route::delete('/delete-user/{id}', [UserController::class, 'RemoveUser']);
    Route::get('/show-log', [UserController::class, 'showLog']);
});