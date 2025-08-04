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
            if (response.role === 'admin') {
                window.location.href = '/dashboard';
            } else if (response.role === 'user') {
                window.location.href = '/home';
            } else {
                alert('Bạn không có quyền truy cập vào hệ thống này.');
            }

        },
        error: function (xhr, status, error) {
            if (xhr.status === 403) {
                emailToCheck = $('#email').val();
                document.getElementById('content-login_form').style.display = 'none';
                document.getElementById('resendModalLogin').style.display = 'block';
            } if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            } else {
            }
        }
    });
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