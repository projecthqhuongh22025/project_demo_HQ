<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Tài khoản chưa tồn tại'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Tài khoản chưa được kích hoạt'], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 401);
        }

        if ($user->role === 'admin') {
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'message' => 'Đăng nhập thành công với quyền quản trị',
                'role' => 'admin',
                'token' => $token,
                'user' => $user,
            ]);
        } 
        elseif ($user->role === 'user') {
            $token = $user->createToken('api-token')->plainTextToken;
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
}