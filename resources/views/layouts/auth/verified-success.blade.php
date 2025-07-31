<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kích hoạt thành công</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .thank-you-box {
      background-color: #fff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 400px;
      width: 100%;
    }

    .thank-you-box h2 {
      color: #333;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .thank-you-box p {
      color: #555;
      margin-bottom: 25px;
    }

    .btn-login {
      background-color: #4a90e2;
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-login:hover {
      background-color: #357ab7;
    }

    .checkmark {
      font-size: 50px;
      color: #4CAF50;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="thank-you-box">
    <div class="checkmark">✅</div>
    <h2>Kích hoạt tài khoản thành công!</h2>
    <p>Cảm ơn bạn đã xác minh email. Bây giờ bạn có thể đăng nhập và bắt đầu sử dụng hệ thống.</p>
  </div>
</body>
</html>
