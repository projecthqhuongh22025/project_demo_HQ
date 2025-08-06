@extends('layouts.frontend.master')
@section('content')
<div id="content-forgot" class="login-form">
    <form class="form" id="kt_login_forgot_form" action="">
        <div id="form-reset_password">
            <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Thông tin cá nhân</h3>
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Họ và tên</label>
                <input id="name" type="text"
                    class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Họ và tên" value="" />
                <div class="error" id="name-error"></div>
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                <input id="email" type="email"
                    class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Email" value="" />
                <div class="error" id="email-error"></div>
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Số điện thoại</label>
                <input id="phone" type="text"
                    class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Số điện thoại" value="" />
                <div class="error" id="phone-error"></div>
            </div>
        </div>
        <!--begin::Form group-->
        <div style="display: flex; padding-top: 22.75px;">
            <button id="update-info" type="button"
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