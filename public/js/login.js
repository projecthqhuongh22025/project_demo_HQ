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
            console.log(xhr.status);
            const res = xhr.responseJSON;
            if (xhr.status === 403) {
                emailToCheck = $('#email').val();
                document.getElementById('content-login_form').style.display = 'none';
                document.getElementById('resendModalLogin').style.display = 'block';
            } 
            else if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            }
            else if (xhr.status === 401) {
                alert(res.message);
            }
            else if (xhr.status === 423) {
                alert(xhr.responseJSON.message);
            }

            //Quá nhiều lần đăng nhập sai (429)
            else if (xhr.status === 429) {
                console.log("bbbb")
                document.getElementById('block_login-modal').style.display = 'block';
                document.getElementById('content-login_form').style.display = 'none';
                startCountdown();
            }
        }
    });
}

let loginLockTime = 60;

function startCountdown() {
    updateCountdownDisplay(loginLockTime);
    interval = setInterval(() => {
        loginLockTime--;
        updateCountdownDisplay(loginLockTime);

        if (loginLockTime <= 0) {
            clearInterval(interval);
            document.getElementById('block_login-modal').style.display = 'none';
                document.getElementById('content-login_form').style.display = 'block';

        }
    }, 1000);
}

function updateCountdownDisplay(seconds) {
    const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
    const sec = (seconds % 60).toString().padStart(2, '0');
    document.getElementById('countdown').textContent = `${minutes}:${sec}`;
}


$(document).on('click', '#login-btn', function (event) {
    console.log("aaaaa");
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