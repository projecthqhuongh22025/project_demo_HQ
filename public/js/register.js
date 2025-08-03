document.addEventListener("DOMContentLoaded", function () {

    let countdownTime = 300; // 5 phút
    let interval;
    let emailToCheck = "";

    function showActivationModal(email) {
        document.getElementById('step-content-1').style.display = 'none';
        document.getElementById('step-content-2').style.display = 'block';
        document.getElementById('focus-step2').style.backgroundColor = '#C9F7F5';
        document.getElementById('focus-step2-span').style.color = '#1BC5BD';
        document.getElementById('focus-step1').style.backgroundColor = '#F3F6F9';
        document.getElementById('focus-step1-span').style.color = '#3F4254';
        document.getElementById('register-btn').style.display = 'none'
        document.getElementById('userEmail').textContent = email;
        emailToCheck = email;
        startCountdown();
    }

    function startCountdown() {
        updateCountdownDisplay(countdownTime);
        interval = setInterval(() => {
            countdownTime--;
            updateCountdownDisplay(countdownTime);

            if (countdownTime % 10 === 0) {
                checkActivationStatus(emailToCheck);
            }

            if (countdownTime <= 0) {
                clearInterval(interval);
                document.getElementById('countdownBox').style.display = 'none';
                document.getElementById('resendBtn').style.display = 'inline-block';
            }
        }, 1000);
    }

    function updateCountdownDisplay(seconds) {
        const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
        const sec = (seconds % 60).toString().padStart(2, '0');
        document.getElementById('countdown').textContent = `${minutes}:${sec}`;
    }

    function checkActivationStatus(email) {
        $.ajax({
            url: '/api/check-activation',
            method: 'GET',
            data: {
                email: email
            },
            success: function (data) {
                console.log(data);
                console.log(data.user);
                if (data.is_active === 1) {
                    clearInterval(interval);
                    alert("Tài khoản đã được kích hoạt. Đi đến trang đăng nhập!");
                    window.location.href = "/login";
                }
            },
            error: function (xhr, status, error) {
                console.error('Error checking activation:', error);
            }
        });
    }

    window.resendEmail = function () {
        $.ajax({
            url: '/api/resend-activation',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                email: emailToCheck
            }),
            success: function (res) {
                setTimeout(() => {
                    document.getElementById('resendBtn').style.display = 'none';
                    countdownTime = 300;
                    document.getElementById('countdownBox').style.display = 'inline-block';
                    document.getElementById('resendText').textContent = '📩 Đã gửi lại email';
                    startCountdown();
                }, 2000);
            },
            error: function (xhr) {
                console.error('Error resending email:', xhr);
            }
        });
    }

    function register() {

        const data = {
            name: $('#name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#confirmPassword').val(),
        };

        $.ajax({
            url: "/api/register",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                showActivationModal($('#email').val());
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    console.log(xhr.responseJSON);
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        if (key === "password" && messages[0].includes("Mật khẩu xác nhận không khớp")) {
                            $("#password_confirmation-error").text(messages[0]);
                        } else {
                            $(`#${key}-error`).text(messages[0]);
                        }
                    });
                }
                console.log(xhr.responseText);
            }
        });
    }

    $(document).on('click', '#register-btn', function (event) {
        event.preventDefault();
        $('.error').text('');
        register();
    });

    $(document).on('click', '#resendBtn', function (event){
        event.preventDefault();
        resendEmail();
    });

});