<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // chữ thường
                'regex:/[A-Z]/',      // chữ hoa
                'regex:/[0-9]/',      // số
                'regex:/[@$!%*#?&]/'  // ký tự đặc biệt
            ],
        ],[
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ thường, một chữ hoa, một số và một ký tự đặc biệt',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->checkTooManyAttempts($request);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Tài khoản chưa tồn tại'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Tài khoản chưa được kích hoạt'], 403);
        }
        
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($this->throttleKey($request), 60); // khóa 60 giây nếu vượt giới hạn
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }

        if ($user->is_locked) {
            return response()->json([
                'message' => 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.'
            ], 423);
        }

        if ($user->role === 'admin') {
            RateLimiter::clear($this->throttleKey($request));
            $token = $user->createToken('api-token')->plainTextToken;
            session(['token' => $token]);
            return response()->json([
                'message' => 'Đăng nhập thành công với quyền quản trị',
                'role' => 'admin',
                'token' => $token,
                'user' => $user,
            ]);
        } 
        elseif ($user->role === 'user') {
            RateLimiter::clear($this->throttleKey($request));
            $token = $user->createToken('api-token')->plainTextToken;
            session(['token' => $token]);
            return response()->json([
                'message' => 'Đăng nhập thành công với quyền người dùng',
                'role' => 'user',
                'token' => $token,
                'user' => $user,
            ]);
        } 
        else {
            return response()->json(['message' => 'Quyền truy cập không hợp lệ']);
        }

    }

    protected function checkTooManyAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        $maxAttempts = 6;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts - 1)) {
            $seconds = RateLimiter::availableIn($key);
            throw new HttpResponseException(response()->json([
                'message' => "Tài khoản bị khóa tạm thời. Vui lòng thử lại sau {$seconds} giây.",
            ], 429));
        }
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }
}