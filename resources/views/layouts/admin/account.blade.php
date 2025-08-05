@extends('layouts.admin.master')
@section('content')
<div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Danh sách tài khoản</span>
        </h3>
        <div class="card-toolbar">
            <button id="openModalBtn" type="button" class="btn btn-info font-weight-bolder font-size-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Thêm tài khoản
            </button>

        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-0">
        
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center"
                id="kt_advance_table_widget_2">
                <thead>
                    <tr class="text-uppercase">
                        <th class="pl-0">id</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Khóa/Mở khóa</th>
                    </tr>
                </thead>
                <tbody id="content-table">
                    
                </tbody>
            </table>
        </div>

        <!--end::Table-->
    </div>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 3px;
        }
    </style>
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true" style="display:none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addUserForm">
                    <div class="modal-header">
                        <h5 class="modal-titleS" id="addUserModalLabel">Thêm tài khoản</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="error" id="name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="name" required>
                        <div class="error" id="phone-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="error" id="email-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="error" id="password-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirmPassword" name="password" required>
                        <div class="error" id="password_confirmation-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </form>
                <div class="modal-footer">
                    <button id="addUser-btn" type="button" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Body-->
</div>

@endsection