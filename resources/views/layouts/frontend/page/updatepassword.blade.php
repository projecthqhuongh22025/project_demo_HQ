@extends('layouts.frontend.master')
@section('content')
<div id="content-forgot" class="login-form">
    <form class="form" id="kt_login_forgot_form" action="">
        <div id="form-reset_password">
            <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Đổi mật khẩu</h3>
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Mật khẩu hiện tại</label> <label
                    style="color: red;">*</label>
                <input id="current_password" type="password"
                    class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Mật khẩu hiện tại" value="" />
                <div class="error" id="current_password-error"></div>
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Mật khẩu mới</label> <label
                    style="color: red;">*</label>
                <input id="new_password" type="password"
                    class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Mật khẩu mới" value="" />
                <div class="error" id="new_password-error"></div>
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Xác nhận mật khẩu</label> <label
                    style="color: red;">*</label>
                <input id="new_password_confirmation" type="password"
                    class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Xác nhận mật khẩu" value="" />
                <div class="error" id="new_password_confirmation-error"></div>
            </div>
        </div>
        <!--begin::Form group-->
        <div style="display: flex; padding-top: 22.75px;">
            <button id="resetpassword-btn" type="button"
                style="color: #FFFFFF;
                    background-color: #187DE4;
                    font-size: 1.175rem;
                    font-weight: 600;
                    border: none;
                    padding: 13px 26px;
                    border-radius: 0.42rem;">
                Cập nhật
            </button>
        </div>
        <!--end::Form group-->
    </form>
</div>

<style>
    .error {
        color: red;
        font-size: 0.9em;
        margin-top: 3px;
    }
</style>

@endsection