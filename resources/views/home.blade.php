<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Đặt lịch khám bệnh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-blue-600 text-white py-4 shadow">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-2xl font-bold">Phòng Khám Sức Khỏe MD</h1>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-20 text-center bg-white shadow-inner">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Đặt Lịch Khám Nhanh Chóng & Dễ Dàng</h2>
            <p class="text-lg text-gray-600 mb-8">Chăm sóc sức khỏe chủ động cùng đội ngũ bác sĩ hàng đầu.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition duration-200">
                    Đăng nhập
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition duration-200">
                    Đăng ký
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-20 text-center text-gray-500 py-6 text-sm">
        &copy; {{ date('Y') }} Phòng Khám MD. All rights reserved.
    </footer>

</body>
</html>
