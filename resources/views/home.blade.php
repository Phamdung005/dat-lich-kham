<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Đặt lịch khám bệnh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            padding: 20px;
            color: white;
            text-align: center;
        }
        .hero {
            padding: 60px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }
        .hero p {
            font-size: 18px;
            color: #555;
        }
        .buttons {
            margin-top: 30px;
        }
        .buttons a {
            text-decoration: none;
            padding: 12px 25px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 2);
        }
        .buttons a:hover {
            background-color: #0056b3;
        }
        footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <h2>Phòng Khám Sức Khỏe MD</h2>
</header>

<div class="hero">
    <h1>Đặt Lịch Khám Nhanh Chóng & Dễ Dàng</h1>
    <p>Chăm sóc sức khỏe chủ động cùng đội ngũ bác sĩ hàng đầu.</p>
    <div class="buttons">
        <a href="{{ route('login') }}">Đăng nhập</a>
        <a href="{{ route('register') }}">Đăng ký</a>
    </div>
</div>

<footer>
    &copy; {{ date('Y') }} Phòng khám MD. All rights reserved.
</footer>

</body>
</html>
