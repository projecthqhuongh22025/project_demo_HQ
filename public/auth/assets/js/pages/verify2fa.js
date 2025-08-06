
function showqr(){
    $.ajax({
        url: '/api/2fa/setup',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (data) {
            // Luôn hiện form nhập OTP
            $('#otp-section').show();
    
            if (data.require_qr) {
                // Người dùng CHƯA có secret → cần quét QR
                $('#qr-section').show();
                $('#qr-image').attr(
                    'src',
                    'https://api.qrserver.com/v1/create-qr-code/?data=' + encodeURIComponent(data.qr_url) + '&size=200x200'
                );
                $('#qr-instruction').html('<div class="alert alert-info">📷 Quét mã QR bằng Google Authenticator, sau đó nhập mã OTP bên dưới.</div>');
            } else {
                // Người dùng đã có secret → chỉ cần nhập OTP
                $('#qr-section').hide();
                $('#qr-instruction').html('<div class="alert alert-info">' + data.message + '</div>');
            }
        },
        error: function (xhr) {
            console.error('Lỗi khi gọi API', xhr.responseText);
        }
    });

}

function verifyOtp(){
    const otp = $('#otp-input').val();

    console.log(otp);

    $.ajax({
        url: '/api/2fa/verify',
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
            'Accept': 'application/json',
        },
        data: {
            otp: otp
        },
        success: function (data) {
            alert("Xác thực đăng nhập thành công");
            console.log(data);
            if(data.role ==="admin"){
                window.location.href="/dashboard"
            }
            else{
                window.location.href="/"
            }
        },
        error: function (xhr) {
            const msg = xhr.responseJSON?.message || 'Mã OTP không hợp lệ';
            $('#otp-message').html('<div class="alert alert-danger">' + msg + '</div>');
        }
    });
}


$(document).on('click', '#btn-verify', function (event) {
    console.log("aa")
    event.preventDefault();
    $('.error').text('');
    verifyOtp();
});

$(document).ready(function () {
    if (window.location.pathname === '/showqr'){
        showqr();
    }
});