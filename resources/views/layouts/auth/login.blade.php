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
                    <div class="error" id="name-error"></div>
                </div>
                <div class="input-group" id="phoneNumber" style="display: none;">
                    <label>Số điện thoại</label>
                    <input id="phone" type="text" required />
                    <div class="error" id="phone-error"></div>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input id="email" type="email" required />
                    <div class="error" id="email-error"></div>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input id="password" type="password" required />
                    <div class="error" id="password-error"></div>
                </div>
                <div class="input-group" id="confirm-password-group" style="display: none;">
                    <label>Xác nhận mật khẩu</label>
                    <input id="confirmPassword" type="password" />
                    <div class="error" id="password_confirmation-error"></div>
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
                <h2 id="resendText">📩 Xác minh email</h2>
                <p>Chúng tôi đã gửi email xác minh đến <span id="userEmail"></span></p>
                <p>Vui lòng kiểm tra email để kích hoạt tài khoản.</p>
                <div class="countdown-box" id="countdownBox">
                    ⏳ Gửi lại sau: <span id="countdown">5:00</span>
                </div>
                <button id="resendBtn" style="display: none;">Gửi lại</button>
            </div>
        </div>

        <div id="resendModalLogin" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>⏰ Tài khoản chưa kích hoạt</h2>
                <p>Vui lòng kích hoạt tài khoản.</p>
                <button id="activateBtn">Kích hoạt</button>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/login.js?v={{ time() }}"></script>
    <script src="/js/register.js"></script>


    <script>
        let countdownTime = 60; // 5 phút
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
                    document.getElementById('countdownBox').style.display = 'none';
                    document.getElementById('resendBtn').style.display = 'inline-block';
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
                    if (data.is_active === 1) {
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

        function resendEmail() {
            $.ajax({
                url: '/api/resend-activation',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: emailToCheck
                }),
                success: function(res) {
                    setTimeout(() => {
                        document.getElementById('resendBtn').style.display = 'none';
                        countdownTime = 60;
                        document.getElementById('countdownBox').style.display = 'inline-block';
                        document.getElementById('resendText').textContent = '📩 Đã gửi lại email';
                        startCountdown();
                    }, 2000);
                },
                error: function(xhr) {

                }
            });
        }
        
        document.getElementById('activateBtn').addEventListener('click', () => {
            document.getElementById('resendModalLogin').style.display = 'none';
            document.getElementById('activationModal').style.display = 'flex';
            resendEmail();
        });
        document.getElementById('resendBtn').addEventListener('click', () => {
            resendEmail();
        });
    </script>
</body>

</html>