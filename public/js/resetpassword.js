
function forgotPassword() {
    const data = {
        email: $('#email').val(),
    };

    $.ajax({
        url: "/api/forgot-password",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
            document.getElementById('content-forgot').style.display = 'none';
            document.getElementById('verify-page_forgot').style.display = 'block';
            document.getElementById('userEmail').textContent = $('#email').val();
            countdownTime = 300;
            startCountdown();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 403) {
                alert('tài khoản chưa kích hoạt.');
            }
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            }
            else {
                
            }
        }
    });
}

function showResetPasword(email) {
    $.ajax({
        url: '/api/show-reset-pasword',
        method: 'GET',
        data: {
            email: email
        },
        success: function (data) {
            console.log(data);
            console.log(data.user);
            if (data.is_active === 1) {
                clearInterval(interval);
                alert("Cảm ơn bạn đã xác minh. Bạn đã có thể thay đổi mật khẩu!");
            }
        },
        error: function (xhr, status, error) {
            console.error('Error checking activation:', error);
        }
    });
}

function resetPassword() {
    const data = {
        email: $('#email').val(),
        token: $('#token').val(),
        password: $('#password').val(),
        password_confirmation: $('#confirmPassword').val(),
    };

    $.ajax({
        url: "/api/reset-password",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
            alert('Mật khẩu đã được thay đổi thành công. Vui lòng đăng nhập lại.');
            window.location.href = '/login';
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            }
            else {
                
            }
        }
    });
}

$(document).on('click', '#forgot-btn', function (event) {
    event.preventDefault();
    $('.error').text('');
    forgotPassword();
});

$(document).on('click', '#resetpassword-btn', function (event) {
    event.preventDefault();
    $('.error').text('');
    resetPassword();
});