<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải chứa chữ thường, chữ hoa, số và ký tự đặc biệt',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ipKey = $this->ipThrottleKey($request);
        $emailKey = $this->emailThrottleKey($request);
        $maxAttempts = 5;
        $decaySeconds = 60;

        $user = User::where('email', $request->email)->first();

        // TH1: Tài khoản không tồn tại → dùng IP key
        if (!$user) {
            $this->checkTooManyAttempts($ipKey, $maxAttempts);
            $this->incrementAttempts($ipKey, $maxAttempts, $decaySeconds);
            return response()->json(['message' => 'Tài khoản chưa tồn tại'], 401);
        }

        // TH2: Tài khoản tồn tại → kiểm tra bằng email + IP key
        $this->checkTooManyAttempts($emailKey, $maxAttempts);

        if (!$user->is_active) {
            $this->incrementAttempts($emailKey, $maxAttempts, $decaySeconds);
            return response()->json(['message' => 'Tài khoản chưa được kích hoạt'], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->incrementAttempts($emailKey, $maxAttempts, $decaySeconds);
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }

        if ($user->is_locked) {
            $this->incrementAttempts($emailKey, $maxAttempts, $decaySeconds);
            return response()->json([
                'message' => 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.'
            ], 423);
        }

        // Đúng -> Xóa throttle key
        RateLimiter::clear($ipKey);
        RateLimiter::clear($emailKey);

        $token = $user->createToken('api-token')->plainTextToken;
        session(['token' => $token]);

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'role' => $user->role,
            'token' => $token,
            'user' => $user,
        ]);
    }

    protected function checkTooManyAttempts(string $key, int $maxAttempts)
    {
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            throw new HttpResponseException(response()->json([
                'message' => "Bạn đã đăng nhập sai quá nhiều lần. Vui lòng thử lại sau {$seconds} giây."
            ], 429));
        }
    }

    protected function incrementAttempts(string $key, int $maxAttempts, int $seconds)
    {
        if (RateLimiter::attempts($key) >= $maxAttempts) {
            RateLimiter::clear($key);
            RateLimiter::hit($key, now()->addSeconds($seconds));
        } else {
            RateLimiter::hit($key);
        }
    }

    protected function ipThrottleKey(Request $request): string
    {
        return 'login:ip:' . $request->ip();
    }

    protected function emailThrottleKey(Request $request): string
    {
        return 'login:email:' . strtolower($request->email) . '|ip:' . $request->ip();
    }
}
