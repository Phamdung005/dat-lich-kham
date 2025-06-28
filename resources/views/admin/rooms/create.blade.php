
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm phòng khám</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9db1097153.js" crossorigin="anonymous"></script>
    <style>
        body { background-color: #f4f8fb; }
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
                        <button class="btn btn-outline-danger btn-sm w-100">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-md-10 p-4">
            <h3 class="mb-4 text-primary">Thêm Phòng Khám Mới</h3>
            <form method="POST" action="{{ route('admin.rooms.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="room_number" class="form-label">Số phòng</label>
                    <input type="text" id="room_number" name="room_number" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
