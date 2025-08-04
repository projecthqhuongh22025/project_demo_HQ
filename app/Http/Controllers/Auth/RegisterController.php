<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ActivateAccountMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Log;
use App\Events\UserProfileUpdated;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'phone' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ thường, một chữ hoa, một số và một ký tự đặc biệt',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'name.required' => 'Vui lòng nhập tên',
            'email.unique' => 'Email đã được sử dụng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
            'is_active' => false,
            'is_locked' => false,
        ]);

        $token = $user->id . Str::random(64);
        $activationToken = md5($token);

        $user->update([
            'activation_token' => $activationToken,
            'activation_token_expires_at' => now()->addMinutes(5),
        ]);

        $activationUrl = route('user.activate', ['token' => $token]);

        event(new UserRegistered($user, $activationUrl));

        return response()->json(['message' => 'Vui lòng kiểm tra email để kích hoạt tài khoản.']);
    }

    public function resendActivation(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->is_active) {
            return response()->json(['message' => 'Tài khoản đã được kích hoạt.'], 400);
        }

        $token = $user->id . Str::random(64);
        $activationToken = md5($token);
        $expiresAt = now()->addMinutes(5);

        $user->activation_token = $activationToken;
        $user->activation_token_expires_at = $expiresAt;
        $user->save();

        $activationUrl = route('user.activate', ['token' => $token]);

        event(new UserRegistered($user, $activationUrl));

        return response()->json(['message' => 'Đã gửi lại email kích hoạt. Vui lòng kiểm tra hộp thư.']);
    }


}
