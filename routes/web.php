<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\Auth\ForgotController;


Route::get('/login', function () {
    return view('layouts.auth.login');
});

Route::get('/sign-up', function () {
    return view('layouts.auth.signup');
});

Route::get('/forgot-password', function () {
    return view('layouts.auth.forgotPassword');
});

Route::get('/reset-password', function () {
    return view('layouts.auth.resetpasswordform');
});

Route::get('/verify-otp', function () {
    return view('layouts.auth.verifyOTP');
});

Route::get('/activate/{token}', [ActivateAccountController::class, 'activate'])->name('user.activate');

Route::get('/show-reset-password/{token}', [ForgotController::class, 'showresetPassword'])->name('user.showResetPassword');

Route::get('/home', function () {
    return view('layouts.frontend.home');
});

Route::get('/dashboard', function () {
    return view('layouts.admin.dashboard');
});

Route::get('/verified-success', function () {
    return view('layouts.auth.verified-success');
});

