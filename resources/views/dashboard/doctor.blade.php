<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9db1097153.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f4f8fb;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #ddd;
            padding: 1rem;
        }
        .sidebar h4 {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar text-center text-white bg-light">
            <div class="card shadow-sm mb-4" style="max-width: 400px;">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="{{ asset('default-avatar.png') }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif

                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    
                    <div class="mt-2">
                        <div class="mb-2">
                            <span class="fw-bold">Email:</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div>
                            <span class="fw-bold">SĐT:</span>
                            <span>{{ $user->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav flex-column text-start" >
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('doctor.dashboard') }}"><i class="fa-solid fa-house"></i> Trang chủ</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('doctor.appointmentdr') }}"><i class="fa-solid fa-calendar-check"></i> Lịch hẹn</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('doctor.profileDoctor.show') }}"><i class="fa-solid fa-user"></i> Hồ sơ cá nhân</a>
                </li>
                <li class="nav-item mb-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-md-10 p-4">
            <h2 class="mb-4">Thống kê lịch hẹn</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-secondary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Tất cả</h5>
                            <p class="card-text fs-4">{{ $totalAppointments }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Chờ xác nhận</h5>
                            <p class="card-text fs-4">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Đã xác nhận</h5>
                            <p class="card-text fs-4">{{ $confirmedCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Đã hủy</h5>
                            <p class="card-text fs-4">{{ $cancelledCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Đã hoàn thành</h5>
                            <p class="card-text fs-4">{{ $completedCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
