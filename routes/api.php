<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\Auth\ForgotController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/resend-activation', [RegisterController::class, 'resendActivation']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotController::class, 'resetPassword']);
Route::get('/check-activation', [ActivateAccountController::class, 'checkActivation']);