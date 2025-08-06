<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ShowInfoController extends Controller
{
    //lấy thông tin người dùng
    public function getUser(Request $request){
        $userId = $request -> user()->id;
        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            return redirect('/login');
        }
        
        return response()->json($user);
    }

    //người dùng chỉnh sửa thông tin
    public function updateInfo(Request $request){
        $user = $request->user();
        $userId = $user->id;

        // So sánh email gửi lên với email hiện tại
        $newEmail = $request->input('email');
        $currentEmail = $user->email;

        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ];

        // Nếu email được gửi lên và khác với email hiện tại → thêm rule unique
        if ($newEmail && $newEmail !== $currentEmail) {
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId) // bỏ qua email của chính mình
            ];
        }

        $validator = Validator::make($request->all(), $rules, [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'name.required' => 'Vui lòng nhập tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cập nhật
        $user->update([
            'email' => $newEmail ?? $currentEmail,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);

        return response()->json([
            'message' => 'Cập nhật thông tin thành công',
            'user' => $user,
        ]);
    }
}
