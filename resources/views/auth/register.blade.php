<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Đặt lịch khám</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="text-xl font-bold text-blue-600">
                <a href="{{ url('/') }}">ĐẶT LỊCH KHÁM</a>
            </div>
            <div>
                <button class="text-gray-600 hover:text-gray-800 focus:outline-none md:hidden">
                    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                        <path d="M4 5h16M4 12h16M4 19h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <div class="flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Tạo tài khoản</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <input type="text" name="name" placeholder="Họ và tên" required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                </div>

                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                </div>

                <div class="mb-4">
                    <input type="password" name="password" placeholder="Mật khẩu" required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                </div>

                <div class="mb-4">
                    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                </div>

                <div class="mb-6">
                    <input type="hidden" name="role" value="patient">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition">
                    Đăng ký
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-blue-500 hover:underline text-sm">← Về trang chủ</a>
            </div>
        </div>
    </div>

</body>
</html>
