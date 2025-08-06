<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    //lấy danh sách người dùng đã kích hoạt
    public function getUser(){
        $user = User::all();
        return response()->json($user);
    }

    //lấy người dùng thoe id
    public function getUserById($id) {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    //thêm người dùng(role = admin)
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string|in:user,admin',
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
            'role' => $request->role,
            'is_active' => true,
        ]);

        AdminLog::create([
            'admin_id'    => Auth::id(),
            'action'      => 'Create User',
            'target_type' => 'User',
            'target_id'   => $user->id,
            'data'        => $user,
            'ip'          => $request->ip(),
        ]);

        return response()->json([
            'message' => 'Thêm người dùng mới thành công.',
            'user' => $user
        ], 200);
    }

    //chỉnh sửa thông tin
    public function updateUser(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:user,admin',
            'phone' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'name.required' => 'Vui lòng nhập tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);
        $user -> update([
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        AdminLog::create([
            'admin_id'    => Auth::id(),
            'action'      => 'Update User',
            'target_type' => 'User',
            'target_id'   => $user->id,
            'data'        => $user,
            'ip'          => $request->ip(),
        ]);
        return response()->json([
            'message' => 'Cập nhật thông tin người dùng thành công',
            'user' => $user
        ]);
    }

    //khóa tài khoản người dùng
    public function LockAccount($id, Request $request){
        $user = User::findOrFail($id);
        
        $user->is_locked = !$user->is_locked;

        $user->save();

        return response()->json([
            'message' => $user->is_locked ? 'Tài khoản đã bị khóa' : 'Tài khoản đã được mở khóa',
            'is_locked' => $user->is_locked,
        ]);

        AdminLog::create([
            'admin_id'    => Auth::id(),
            'action'      => 'Lock/Unlock User',
            'target_type' => 'User',
            'target_id'   => $user->id,
            'data'        => $user,
            'ip'          => $request->ip(),
        ]);
        return response()->json([
            'message' => 'Khóa tài khoản thành công',
            'user' => $user
        ]);
    }

    //xóa tài khoản
    public function RemoveUser($id, Request $request){
        $user =User::findOrFail($id);
        $user->delete();
        AdminLog::create([
            'admin_id'    => Auth::id(),
            'action'      => 'Delete User',
            'target_type' => 'User',
            'target_id'   => $user->id,
            'data'        => $user,
            'ip'          => $request->ip(),
        ]);
        return response()->json([
            'message' =>'Xóa người dùng thành công'
        ]);
    }

    //show log admin
    public function showLog(){
        $logs = AdminLog::with('admin:id,name,email,role')
            ->whereHas('admin', function ($query) {
                $query->where('role', 'ADMIN');
            })
            ->latest()
            ->paginate(20);

        return response()->json($logs);
    }
}
