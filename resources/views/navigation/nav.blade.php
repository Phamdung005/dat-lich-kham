@php
    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Bệnh Nhân</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f8fb;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #ddd;
            padding: 1.5rem 1rem;
        }
        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
        .notification-badge {
            font-size: 0.75rem;
            position: absolute;
            top: 0;
            right: -10px;
        }
    </style>
</head>
<body>

<!-- Navbar brand -->
<nav class="navbar navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar dọc -->
        <div class="col-md-2 sidebar">
            <h5 class="fw-bold mb-4 text-center text-primary">Bệnh Nhân</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" href="{{ route('patient.dashboard') }}">
                        🏠 Trang chủ
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.profile.show') ? 'active' : '' }}" href="{{ route('patient.profile.show') }}">
                        👤 Hồ sơ cá nhân
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                        📅 Lịch hẹn đã đặt
                    </a>
                </li>
                <li class="nav-item mb-2 position-relative">
                    <a class="nav-link {{ request()->routeIs('patient.notifications') ? 'active' : '' }}" href="{{ route('patient.notifications') }}">
                        🔔 Thông báo
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill notification-badge">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">
                            🚪 Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="col-md-10 p-4">
            {{-- Nội dung chính của từng trang bệnh nhân sẽ được render ở đây --}}
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
