function login() {
    const data = {
        email: $('#email').val(),
        password: $('#password').val(),
    };

    $.ajax({
        url: "/api/login",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
            sessionStorage.setItem('token', response.token);
            if (response.role === 'admin') {
                window.location.href = '/showqr';
            } else if (response.role === 'user') {
                window.location.href = '/showqr';
            } else {
                alert('Bạn không có quyền truy cập vào hệ thống này.');
            }

        },
        error: function (xhr, status, error) {
            const res = xhr.responseJSON;
            if (xhr.status === 403) {
                emailToCheck = $('#email').val();
                document.getElementById('content-login_form').style.display = 'none';
                document.getElementById('resendModalLogin').style.display = 'block';
            } if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            }
            if (xhr.status === 401) {
                alert(res.message);
                return;
            }
            if (xhr.status === 423) {
                alert(res.message);
            }

            //Quá nhiều lần đăng nhập sai (429)
            if (xhr.status === 429) {
                const res = xhr.responseJSON;
                alert(res.message);
            }
            else { 
            }
        }
    });
}

function showQRcode(){

}

$(document).on('click', '#login-btn', function (event) {
    event.preventDefault();
    $('.error').text('');
    login();
});

$(document).on('click', '#activateBtn', function (event) {
    event.preventDefault();
    document.getElementById('resendModalLogin').style.display = 'none';
    document.getElementById('activationModal').style.display = 'block';
    resendEmail();
});