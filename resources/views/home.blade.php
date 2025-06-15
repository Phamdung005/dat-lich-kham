<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Đặt lịch khám bệnh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-600 text-white py-4 shadow">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-2xl font-bold">Phòng Khám Sức Khỏe Minh Dũng</h1>
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
    <footer class="bg-gray-900 text-gray-300 pt-12 pb-8 mt-auto">
        <div class="container mx-auto px-6">

            <!-- Logo & slogan + social -->
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start mb-8">
                <div class="flex items-start gap-4 mb-6 md:mb-0">
                    <!-- Logo -->
                    <img src="/icons/benhvien.svg" alt="Logo" class="w-12 h-12 object-contain">
                    <div>
                        <h2 class="text-lg font-semibold text-white">Phòng Khám Minh Dũng</h2>
                        <p class="text-sm text-gray-400 mt-1">Khám - Chữa bệnh - Chăm sóc sức khỏe</p>
                    </div>
                </div>

                <!-- Mạng xã hội -->
                <div class="flex gap-4">
                    <a href="#" class="hover:text-white">
                        <img src="/icons/facebook.svg" alt="Facebook" class="w-10 h-10">
                    </a>
                    <a href="#" class="hover:text-white">
                        <img src="/icons/youtube.svg" alt="YouTube" class="w-10 h-10">
                    </a>
                    <a href="#" class="hover:text-white">
                        <img src="/icons/tiktok.svg" alt="Tiktok" class="w-10 h-10">
                    </a>
                </div>
            </div>

            <!-- Đường kẻ trắng mờ -->
            <div class="border-t border-white/20 my-6"></div>

            <!-- Nội dung chính -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 text-sm">

                <!-- Dịch vụ cột 1 -->
                <div>
                    <h3 class="font-semibold text-white mb-3">Dịch vụ</h3>
                    <ul class="space-y-1">
                        <li>Khám chữa bệnh</li>
                        <li>Chạy thận nhân tạo</li>
                        <li>Phẫu thuật nội soi</li>
                        <li>Xét nghiệm máu</li>
                    </ul>
                </div>

                <!-- Dịch vụ cột 2 -->
                <div>
                    <h3 class="font-semibold text-white mb-3 invisible">Dịch vụ</h3>
                    <ul class="space-y-1">
                        <li>Khám tim mạch định kỳ</li>
                        <li>Điều trị tăng huyết áp</li>
                        <li>Chăm sóc da liễu</li>
                        <li>Phục hồi sau lăn kim, laser</li>
                    </ul>
                </div>

                <!-- Cơ sở -->
                <div>
                    <h3 class="font-semibold text-white mb-3">Cơ sở</h3>
                    <ul class="space-y-1">
                        <li>CS1: P. Nguyễn Trác, Yên Nghĩa, Hà Đông, Hà Nội</li>
                        <li>CS2: Số 123 Đường ABC, Quận XYZ, Hà Nội</li>
                    </ul>
                </div>

                <!-- Liên hệ -->
                <div>
                    <h3 class="font-semibold text-white mb-3">Liên hệ</h3>
                    <p>Hotline: <a href="tel:0384868888" class="text-blue-400 hover:underline">0384 868 888</a></p>
                    <p>Email: <a href="mailto:info@minhdungclinic.vn" class="text-blue-400 hover:underline">info@minhdungclinic.vn</a></p>
                </div>

            </div>

            <!-- Copyright -->
            <div class="mt-10 text-center text-gray-500 text-xs">
                &copy; {{ date('Y') }} Phòng Khám Minh Dũng. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
