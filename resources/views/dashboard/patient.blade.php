@php
    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .content-wrapper {
            padding: 2rem;
        }
    </style>
</head>
<body>

<!-- Navbar thương hiệu -->
<nav class="navbar navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
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
        <div class="col-md-10 content-wrapper">
            <h2 class="text-center mb-4">Chào mừng {{ $user->name }} đến với hệ thống đặt lịch khám</h2>
            <p class="text-center text-muted mb-5">Đặt lịch nhanh chóng, dễ dàng, theo dõi lịch sử khám bệnh tiện lợi</p>

            <form method="GET" action="{{ route('patient.dashboard') }}" class="row g-3 mb-5">
                <div class="col-md-6">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm theo tên bác sĩ">
                </div>
                <div class="col-md-4">
                    <select name="specialty_id" class="form-select">
                        <option value="">Tất cả chuyên khoa</option>
                        @foreach($allSpecialties as $item)
                            <option value="{{ $item->id }}" {{ request('specialty_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
            </form>

            @foreach($specialties as $specialty)
                <div class="mb-5">
                    <h4 class="text-primary border-bottom pb-2 mb-4">{{ $specialty->name }}</h4>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($specialty->doctors as $doctor)
                            <div class="col">
                                <div class="card h-100 shadow-sm text-center" style="border: 2px solid #000;">
                                    <div class="card-body">
                                        @if($doctor->user->avatar)
                                            <img src="{{ asset('storage/' . $doctor->user->avatar) }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('default-avatar.png') }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                        @endif
                                        <h5 class="card-title text-primary">{{ $doctor->name }}</h5>
                                        <p class="card-text text-muted mb-1">Email: {{ $doctor->email }}</p>
                                        <p class="card-text text-muted mb-1">SĐT: {{ $doctor->user->phone }}</p>
                                        <p class="card-text text-muted">Chuyên khoa: {{ $specialty->name }}</p>
                                        <form action="{{ route('appointment.create') }}" method="GET">
                                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Đặt lịch khám</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
