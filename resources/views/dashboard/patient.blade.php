<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: linear-gradient(135deg, #d0f0ff, #ffffff);
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: center;
        }
        .hero h2 {
            font-weight: bold;
        }
        .service-card {
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <a class="navbar-brand fw-bold text-primary" href="#">DŨNG MINH</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a href="{{ route('patient.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('patient.profile') }}" class="nav-link">Hồ sơ cá nhân</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('appointments.index') }}" class="nav-link">Lịch hẹn đã đặt</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Tùy chọn khác</a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm ms-2" type="submit">Đăng xuất</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="hero">
        <h2>Chào mừng bạn đến với Hệ thống Đặt lịch Khám bệnh</h2>
        <p>Đặt lịch nhanh chóng, dễ dàng, theo dõi lịch sử khám bệnh tiện lợi</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($specialties as $specialty)
            <div class="col">
                <div class="card service-card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $specialty->name }}</h5>
                        <ul class="list-unstyled">
                            @foreach($specialty->doctors as $doctor)
                                <li class="mb-3">
                                    <strong>{{ $doctor->name }}</strong><br>
                                    <small>{{ $doctor->email }}</small>
                                    <form action="{{ route('appointment.create') }}" method="GET" class="mt-1">
                                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary mt-1">Đặt lịch khám</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
