<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ActivateAccountMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller {
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'confirmed', // cần có password_confirmation
                'min:8',
                'regex:/[a-z]/',      // chữ thường
                'regex:/[A-Z]/',      // chữ hoa
                'regex:/[0-9]/',      // số
                'regex:/[@$!%*#?&]/'  // ký tự đặc biệt
            ],
            'phone' => 'nullable|string',
        ]);

        $token = Str::random(64);
        $expiresAt = now()->addMinutes(5);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
            'is_active' => false,
            'activation_token' => $token,
            'activation_token_expires_at' => $expiresAt,
        ]);

        $activationUrl = url("/api/activate/{$token}");
        Mail::to($user->email)->send(new ActivateAccountMail($activationUrl));

        return response()->json(['message' => 'Vui lòng kiểm tra email để kích hoạt tài khoản.']);
    }

    public function activate($token) {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect('/verified-success')->with('message', 'Token không hợp lệ');
        }

        if ($user->activation_token_expires_at < now()) {
            return redirect('/verified-fails')->with('message', 'Token đã hết hạn');
        }

        $user->is_active = true;
        $user->activation_token = null;
        $user->activation_token_expires_at = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect('/verified-success')->with('message', 'Tài khoản đã được kích hoạt. Vui lòng đăng nhập.');
    }

    public function resendActivation(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->is_active) {
            return response()->json(['message' => 'Tài khoản đã được kích hoạt.'], 400);
        }

        $token = Str::random(64);
        $expiresAt = now()->addMinutes(5);

        $user->activation_token = $token;
        $user->activation_token_expires_at = $expiresAt;
        $user->save();

        $activationUrl = url("/api/activate/{$token}");
        Mail::to($user->email)->send(new ActivateAccountMail($activationUrl));

        return response()->json(['message' => 'Đã gửi lại email kích hoạt. Vui lòng kiểm tra hộp thư.']);
    }

}
