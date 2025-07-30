<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

Route::post('/register', [RegisterController::class, 'register']);
Route::get('/activate/{token}', [RegisterController::class, 'activate']);
Route::post('/resend-activation', [RegisterController::class, 'resendActivation']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/check-activation', function(Request $request) {
    $user = \App\Models\User::where('email', $request->email)->first();
    return response()->json(['activated' => $user && $user->is_active]);
});