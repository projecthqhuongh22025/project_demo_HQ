<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // chữ thường
                'regex:/[A-Z]/',      // chữ hoa
                'regex:/[0-9]/',      // số
                'regex:/[@$!%*#?&]/'  // ký tự đặc biệt
            ],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Tài khoản chưa được kích hoạt'], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 401);
        }

        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Đăng nhập thành công với quyền quản trị',
                'role' => 'admin',
                'user' => $user,
            ]);
        } 
        elseif ($user->role === 'user') {
            return response()->json([
                'message' => 'Đăng nhập thành công với quyền người dùng',
                'role' => 'user',
                'user' => $user,
            ]);
        } 
        else {
            return response()->json(['message' => 'Quyền truy cập không hợp lệ'], 403);
        }

    }
}