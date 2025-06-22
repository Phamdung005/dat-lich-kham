<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đăng ký - Đặt lịch khám</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow">
        <div class="container mx-auto px-4 flex justify-between items-center py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold hover:text-blue-300">Phòng Khám Sức Khỏe Minh Dũng</a>
            <div class="space-x-4">
                <a href="{{ url('/') }}" class="hover:text-blue-300 font-semibold">Trang chủ</a>
                <a href="{{ route('login') }}" class="hover:text-blue-300 font-semibold">Đăng nhập</a>
                <a href="{{ route('register') }}" class="hover:text-blue-300 font-semibold underline decoration-white decoration-2">Đăng ký</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Tạo tài khoản</h2>

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <input
                        type="text"
                        name="name"
                        placeholder="Họ và tên"
                        required
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                    />
                </div>

                <div class="mb-4">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        required
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                    />
                </div>

                <div class="mb-4">
                    <input
                        type="password"
                        name="password"
                        placeholder="Mật khẩu"
                        required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                    />
                </div>

                <div class="mb-6">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Xác nhận mật khẩu"
                        required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                    />
                </div>

                <input type="hidden" name="role" value="patient" />

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition"
                >
                    Đăng ký
                </button>
            </form>

            <div class="text-center mt-4">
                <h6>
                    Đã có tài khoản? 
                    <a href="{{ url('/login') }}" class="text-blue-500 hover:underline text-sm">Đăng nhập</a>
                </h6>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 pt-12 pb-8 mt-auto w-full">
        <div class="container mx-auto px-6">

            <div class="flex flex-col md:flex-row justify-between items-center md:items-start mb-8">
                <div class="flex items-start gap-4 mb-6 md:mb-0">
                    <img src="/icons/benhvien.svg" alt="Logo" class="w-12 h-12 object-contain" />
                    <div>
                        <h2 class="text-lg font-semibold text-white">Phòng Khám Minh Dũng</h2>
                        <p class="text-sm text-gray-400 mt-1">Khám - Chữa bệnh - Chăm sóc sức khỏe</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="#" class="hover:text-white">
                        <img src="/icons/facebook.svg" alt="Facebook" class="w-10 h-10" />
                    </a>
                    <a href="#" class="hover:text-white">
                        <img src="/icons/youtube.svg" alt="YouTube" class="w-10 h-10" />
                    </a>
                    <a href="#" class="hover:text-white">
                        <img src="/icons/tiktok.svg" alt="Tiktok" class="w-10 h-10" />
                    </a>
                </div>
            </div>

            <div class="border-t border-white/20 my-6"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 text-sm">
                <div>
                    <h3 class="font-semibold text-white mb-3">Dịch vụ</h3>
                    <ul class="space-y-1">
                        <li>Khám chữa bệnh</li>
                        <li>Chạy thận nhân tạo</li>
                        <li>Phẫu thuật nội soi</li>
                        <li>Xét nghiệm máu</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-3 invisible">Dịch vụ</h3>
                    <ul class="space-y-1">
                        <li>Khám tim mạch định kỳ</li>
                        <li>Điều trị tăng huyết áp</li>
                        <li>Chăm sóc da liễu</li>
                        <li>Phục hồi sau lăn kim, laser</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-3">Cơ sở</h3>
                    <ul class="space-y-1">
                        <li>CS1: P. Nguyễn Trác, Yên Nghĩa, Hà Đông, Hà Nội</li>
                        <li>CS2: Số 123 Đường ABC, Quận XYZ, Hà Nội</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-3">Liên hệ</h3>
                    <p>Hotline: <a href="tel:0384868888" class="text-blue-400 hover:underline">0384 868 888</a></p>
                    <p>Email: <a href="mailto:info@minhdungclinic.vn" class="text-blue-400 hover:underline">info@minhdungclinic.vn</a></p>
                </div>
            </div>

            <div class="mt-10 text-center text-gray-500 text-xs">
                &copy; {{ date('Y') }} Phòng Khám Minh Dũng. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
