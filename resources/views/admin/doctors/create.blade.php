<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thêm Bác Sĩ Mới</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h5 class="fw-bold mb-4 text-center text-primary">Admin</h5>
            <ul class="nav flex-column text-start">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.statistics') }}">
                        <i class="fa-solid fa-chart-line me-1"></i> Thống kê
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-user-doctor me-1"></i> Quản lý bác sĩ
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.rooms.index') }}">
                        <i class="fa-solid fa-door-open me-1"></i> Quản lý phòng
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fa-solid fa-users me-1"></i> Quản lý người dùng
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main content -->
        <div class="col-md-10 p-4">
            <h3 class="mb-4 text-primary">Thêm Bác Sĩ Mới</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Vui lòng kiểm tra lại dữ liệu:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.doctors.store') }}" method="POST" style="max-width: 600px;">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Tên bác sĩ</label>
                    <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email bác sĩ</label>
                    <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="specialty_id" class="form-label">Chuyên khoa</label>
                    <select id="specialty_id" name="specialty_id" class="form-select" required>
                        <option value="" disabled {{ old('specialty_id') ? '' : 'selected' }}>-- Chọn chuyên khoa --</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                {{ $specialty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-success">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
