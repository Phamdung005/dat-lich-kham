<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê Admin</title>
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h5 class="fw-bold mb-4 text-center text-primary">Admin</h5>
            <ul class="nav flex-column text-start">
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('admin.statistics') }}">
                        <i class="fa-solid fa-chart-line me-1"></i> Thống kê
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-user-doctor me-1"></i> Quản lý bác sĩ
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('admin.rooms.index') }}">
                        <i class="fa-solid fa-door-open me-1"></i> Quản lý phòng
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('users.index') }}">
                        <i class="fa-solid fa-users me-1"></i> Quản lý người dùng
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <h3 class="mb-4 text-primary">Thống kê hệ thống</h3>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tổng số bác sĩ</h5>
                            <p class="display-5 text-primary">{{ $totalDoctors }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tổng số bệnh nhân</h5>
                            <p class="display-5 text-success">{{ $totalPatients }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tổng số phòng khám hiện có</h5>
                            <p class="display-5 text-success">{{ $totalRooms }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tổng số lịch hẹn</h5>
                            <p class="display-5">{{ $totalAppointments }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Lịch hẹn hôm nay</h5>
                            <p class="display-6 text-info">{{ $appointmentsToday }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Lịch hẹn 7 ngày qua</h5>
                            <p class="display-6 text-warning">{{ $appointmentsThisWeek }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Lịch hẹn trong tháng</h5>
                            <p class="display-6 text-secondary">{{ $appointmentsThisMonth }}</p>
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
