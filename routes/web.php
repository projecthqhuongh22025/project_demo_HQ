<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ActivateAccountController;

Route::get('/login', function () {
    return view('layouts.auth.login');
});

Route::get('/activate/{token}', [ActivateAccountController::class, 'activate'])->name('user.activate');

Route::get('/home', function () {
    return view('layouts.frontend.home');
});

Route::get('/dashboard', function () {
    return view('layouts.admin.dashboard');
});

Route::get('/verified-success', function () {
    return view('layouts.auth.verified-success');
});
