@extends('layouts.frontend.master')
@section('content')
<div class="container mt-5">
    <h2>Xác thực hai yếu tố (2FA)</h2>

    <div id="qr-section" style="display: none;">
        <p>Quét mã QR dưới đây bằng ứng dụng Google Authenticator:</p>
        <img id="qr-image" src="" alt="QR Code" />
    </div>

    <div id="otp-section" class="mt-4">
        <div class="form-group mb-2">
            <label for="otp">Nhập mã OTP:</label>
            <input type="text" id="otp-input" class="form-control" required>
        </div>
        <button id="btn-verify" type="button" class="btn btn-primary mt-2">Xác minh</button>

        <div id="otp-message" class="mt-3"></div>
    </div>
</div>

@endsection