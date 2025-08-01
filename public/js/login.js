document.addEventListener("DOMContentLoaded", function () {
    const toggleLink = document.getElementById("toggle-form");
    const formTitle = document.getElementById("form-title");
    const confirmGroup = document.getElementById("confirm-password-group");
    const fullNameGroup = document.getElementById("fullName");
    const phoneNumberGroup = document.getElementById("phoneNumber");
    const registerBtn = document.getElementById("registerBtn");
    const loginBtn = document.getElementById("loginBtn");
    const authForm = document.getElementById("auth-form");

    let isLogin = true;
    toggleLink.addEventListener("click", (e) => {
        e.preventDefault();
        isLogin = !isLogin;
        formTitle.textContent = isLogin ? "Đăng nhập" : "Đăng Ký";
        toggleLink.textContent = isLogin ?
            "Đăng ký ngay" :
            "Đăng nhập ngay";
        document.querySelector(".toggle-text").firstChild.textContent = isLogin ?
            "Bạn chưa có tài khoản? " :
            "Bạn đã có tài khoản? ";
        confirmGroup.style.display = isLogin ? "none" : "block";
        fullNameGroup.style.display = isLogin ? "none" : "block";
        phoneNumberGroup.style.display = isLogin ? "none" : "block";
        registerBtn.style.display = isLogin ? "none" : "block";
        loginBtn.style.display = isLogin ? "block" : "none";
    });

    function login() {
        const data = {
            email: $('#email').val(),
            password: $('#password').val(),
        };


        $.ajax({
            url: "https://huong-project.tichhop.pro/api/login",
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
                console.log(status);
                if (xhr.status === 403) {
                    emailToCheck = $('#email').val();
                    document.getElementById('resendModalLogin').style.display = 'flex';
                } if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        $(`#${key}-error`).text(messages[0]);
                    });
                } else {
                    alert(xhr.responseJSON.message);
                }
            }
        });
    }

    $(document).on('click', '.login-btn', function (event) {
        event.preventDefault();
        $('.error').text('');
        login();
    });

});
