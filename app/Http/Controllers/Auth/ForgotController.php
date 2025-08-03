<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Events\ForgotPassword;

class ForgotController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }
        if ($user && $user->is_active === 0) {
            return response()->json(
                [
                    'message' => 'Tài khoản chưa được kích hoạt',
                    'is_active' => $user->is_active,
                    'user' => $user
                ],
                403
            );
        }
        if ($user && $user->is_active === 1) {
            $token = $user->id . Str::random(64);
            $resetPasswordToken = md5($token);
            $user->update([
                'activation_token' => $resetPasswordToken,
                'activation_token_expires_at' => now()->addMinutes(5),
            ]);

            $activationUrl = route('user.showResetPassword', ['token' => $token]);

            event(new ForgotPassword($user, $activationUrl));

            return response()->json(['message' => 'Vui lòng kiểm tra email để đặt lại mật khẩu.']);
        }

    }

    public function showresetPassword($token, Request $request)
    {
        $hashToken = md5($token);
        $user = User::where('activation_token', $hashToken)
            ->where('activation_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Liên kết đã hết hạn.');
        }

        return redirect('/reset-password')->with('success', 'Tài khoản của bạn đã được kích hoạt. Vui lòng đăng nhập!');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'confirmed', // cần có password_confirmation
                'min:8',
                'regex:/[a-z]/',      // chữ thường
                'regex:/[A-Z]/',      // chữ hoa
                'regex:/[0-9]/',      // số
                'regex:/[@$!%*#?&]/'  // ký tự đặc biệt
            ],
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ thường, một chữ hoa, một số và một ký tự đặc biệt',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::where('email', $request->email)
            ->where('activation_token', md5($request->token))
            ->where('activation_token_expires_at', '>', now())
            ->first();
        $user ->update([
            'password' => Hash::make($request->password),
            'activation_token' => null,
            'activation_token_expires_at' => null,
        ]);

        return response()->json(['message' => 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.']);

    }
}
