<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary" href="#">ĐẶT LỊCH KHÁM</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ route('patient.dashboard') }}">Trang chủ</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ route('patient.profile') }}">Hồ sơ cá nhân</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ route('appointments.index') }}">Lịch hẹn đã đặt</a>
            </li>
            <li class="nav-item mx-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">Đăng xuất</button>
                </form>
            </li>
        </ul>
    </div>
</nav>


<div class="container mt-5">
    <h2 class="text-center mb-4">Chào mừng {{ $user->name }} đến với hệ thống đặt lịch khám</h2>
    <p class="text-center text-muted mb-5">Đặt lịch nhanh chóng, dễ dàng, theo dõi lịch sử khám bệnh tiện lợi</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($specialties as $specialty)
            @foreach($specialty->doctors as $doctor)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $doctor->name }}</h5>
                            <p class="card-text text-muted mb-1">Email: {{ $doctor->email }}</p>
                            <p class="card-text text-muted">Chuyên khoa: {{ $specialty->name }}</p>
                            <form action="{{ route('appointment.create') }}" method="GET">
                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Đặt lịch khám</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
