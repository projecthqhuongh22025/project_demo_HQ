<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('layouts.login');
});

Route::get('/home', function () {
    return view('layouts.frontend.home');
});

Route::get('/verified-success', function () {
    return view('layouts.frontend.verified-success');
});
