<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class ActivateAccountController extends Controller
{
    public function activate($token)
    {
        $hashToken = md5($token);
        $user = User::where('activation_token', $hashToken)
            ->where('activation_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Liên kết kích hoạt không hợp lệ hoặc đã hết hạn.');
        }

        $user->update([
            'is_active' => true,
            'activation_token' => null,
            'activation_token_expires_at' => null,
        ]);

        $user->email_verified_at = now();
        $user->save();

        return redirect('/verified-success')->with('success', 'Tài khoản của bạn đã được kích hoạt. Vui lòng đăng nhập!');
    }

    public function checkActivation(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }
        if ($user->is_active === 0) {
            return response()->json(['message' => 'Tài khoản chưa được kích hoạt'], 403);
        }
        if ($user->is_active === 1) {
            return response()->json(['message' => 'Tài khoản đã được kích hoạt'], 200);
        }
    }
}
