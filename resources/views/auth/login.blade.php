<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Đặt lịch khám</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    @include('navigation.nav2')
    <div class="flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Đăng nhập tài khoản</h2>

            @if(session('error'))
                <div class="text-red-600 text-center mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Email" 
                        required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                    >
                </div>
                <div class="mb-6">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Mật khẩu" 
                        required
                        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition"
                >
                    Đăng nhập
                </button>
            </form>
            <div class="text-center mt-4">
                <h6>Chưa có tài khoản <a href="{{ url('/register') }}" class="text-blue-500 hover:underline text-sm"> đăng ký</a></h6>
            </div>
        </div>
    </div>

</body>
</html>
