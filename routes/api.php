<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ActivateAccountController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/resend-activation', [RegisterController::class, 'resendActivation']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/check-activation', [ActivateAccountController::class, 'checkActivation']);