<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Auth Form</title>
    <link rel="stylesheet" href="/css/login.css" />
</head>

<body>
    <div class="container">
        <div class="form-box">
            <h2 id="form-title">Đăng Nhập</h2>
            <form id="auth-form">
                <div class="input-group" id="fullName" style="display: none;">
                    <label>Họ Tên</label>
                    <input id="name" type="text" required />
                    <div class="error-text" id="nameError"></div>
                </div>
                <div class="input-group" id="phoneNumber" style="display: none;">
                    <label>Số điện thoại</label>
                    <input id="phone" type="text" required />
                    <div class="error-text" id="phoneError"></div>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input id="email" type="email" required />
                    <div class="error-text" id="emailError"></div>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input id="password" type="password" required />
                    <div class="error-text" id="passwordError"></div>
                </div>
                <div class="input-group" id="confirm-password-group" style="display: none;">
                    <label>Xác nhận mật khẩu</label>
                    <input id="confirmPassword" type="password" />
                    <div class="error-text" id="confirmPasswordError"></div>
                </div>
                <button id="loginBtn" type="button" class="login-btn btn">Đăng nhập</button>
                <button id="registerBtn" type="button" class="register-btn btn" style="display: none;">Đăng ký</button>
                <p class="toggle-text">
                    Bạn chưa có tài khoản?
                    <a href="#" id="toggle-form">Đăng ký ngay</a>
                </p>
            </form>
        </div>

        <div id="activationModal" class="modal" style="display:none;">
            <div class="modal-content">
                <h2>📩 Xác minh email</h2>
                <p>Chúng tôi đã gửi email xác minh đến <span id="userEmail"></span></p>
                <p>Vui lòng kiểm tra email để kích hoạt tài khoản.</p>
                <div class="countdown-box">
                    ⏳ Thời gian còn lại: <span id="countdown">1:00</span>
                </div>
            </div>
        </div>

        <div id="resendModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>⏰ Hết thời gian xác minh</h2>
                <p>Liên kết xác minh của bạn đã hết hạn. Bạn có thể yêu cầu gửi lại email xác minh.</p>
                <button id="resendEmailBtn">Gửi lại</button>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let countdownTime = 300; // 5 phút
        let interval;
        let emailToCheck = "";

        function showActivationModal(email) {
            document.getElementById('userEmail').textContent = email;
            document.getElementById('activationModal').style.display = 'flex';
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
                    document.getElementById('activationModal').style.display = 'none';
                    document.getElementById('resendModal').style.display = 'flex';
                }
            }, 1000);
        }

        function checkActivationStatus(email) {
            $.ajax({
                url: '/api/check-activation',
                method: 'GET',
                data: {
                    email: email
                },
                success: function(data) {
                    if (data.activated) {
                        clearInterval(interval);
                        alert("Tài khoản đã được kích hoạt. Đi đến trang đăng nhập!");
                        window.location.href = "/login";
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking activation:', error);
                }
            });
        }

        function updateCountdownDisplay(seconds) {
            const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
            const sec = (seconds % 60).toString().padStart(2, '0');
            document.getElementById('countdown').textContent = `${minutes}:${sec}`;
        }

        document.getElementById('resendEmailBtn').addEventListener('click', () => {
            $.ajax({
                url: '/api/resend-activation',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: emailToCheck
                }),
                success: function(res) {
                    setTimeout(() => {
                        document.getElementById('resendModal').style.display = 'none';
                        countdownTime = 300;
                        document.getElementById('activationModal').style.display = 'flex';
                        startCountdown();
                    }, 2000);
                },
                error: function(xhr) {
                    document.getElementById('resendMessage').textContent = "Gửi lại thất bại.";
                    document.getElementById('resendMessage').style.color = 'red';
                }
            });
        });
    </script>

    <script>
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
            registerBtn.style.display = isLogin ? "none" : "inline-block";
            loginBtn.style.display = isLogin ? "inline_block" : "none";
        });
    </script>

    <script type="text/javascript">
        function register() {

            const data = {
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#confirmPassword').val(),
            };

            $.ajax({
                url: "http://localhost:8000/api/register",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    showActivationModal($('#email').val());
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        function login() {
            const data = {
                email: $('#email').val(),
                password: $('#password').val(),
            };


            $.ajax({
                url: "http://localhost:8000/api/login",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    window.location.href = "/home";
                },
                error: function(xhr, status, error) {
                    console.log(status);
                    if(xhr.status === 403) {
                        document.getElementById('resendModal').style.display = 'flex';
                    }else{
                        alert(xhr.responseJSON.message);
                    }
                }
            });
        }

        $(document).ready(function() {

            $('#name').on('input blur', function() {
                const name = $(this).val().trim();
                $('#nameError').text(name ? '' : 'Vui lòng nhập họ tên.');
            });

            $('#phone').on('input blur', function() {
                const phone = $(this).val().trim();
                const phoneRegex = /^[0-9]{9,11}$/; // Ví dụ: từ 9 đến 11 chữ số

                if (phone === '') {
                    $('#phoneError').text('Số điện thoại không được để trống');
                } else if (!phoneRegex.test(phone)) {
                    $('#phoneError').text('Số điện thoại không hợp lệ (chỉ chứa số, từ 9–11 chữ số)');
                } else {
                    $('#phoneError').text('');
                }
            });

            $('#email').on('input blur', function() {
                const email = $(this).val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!email) {
                    $('#emailError').text('Vui lòng nhập email.');
                } else if (!emailRegex.test(email)) {
                    $('#emailError').text('Email không hợp lệ.');
                } else {
                    $('#emailError').text('');
                }
            });

            $('#password').on('input blur', function() {
                const password = $(this).val();
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/;

                if (!password) {
                    $('#passwordError').text('Vui lòng nhập mật khẩu.');
                } else if (!passwordRegex.test(password)) {
                    $('#passwordError').text('Mật khẩu bao gồm ít nhất 8 ký tự, gồm chữ hoa, thường, số, ký tự đặc biệt.');
                } else {
                    $('#passwordError').text('');
                }
            });

            $('#confirmPassword').on('input blur', function() {
                const confirmPassword = $(this).val();
                const password = $('#password').val();

                $('#confirmPasswordError').text(
                    confirmPassword !== password ? 'Mật khẩu xác nhận không khớp.' : ''
                );
            });
            //gọi hàm đăng ký
            $(document).on('click', '.register-btn', function(event) {
                event.preventDefault();
                register();
            });

            $(document).on('click', '.login-btn', function(event) {
                event.preventDefault();
                login();
            });
        });
    </script>
</body>

</html>