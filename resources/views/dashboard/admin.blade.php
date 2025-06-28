<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
                    <a class="nav-link" href="{{ route('admin.statistics') }}">
                        <i class="fa-solid fa-chart-line me-1"></i> Thống kê
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-user-doctor me-1"></i> Quản lý bác sĩ</a>
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
            <h3 class="mb-4 text-primary">Quản lý Bác sĩ</h3>

            <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 mb-4">
                <div class="col-md-5">
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
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    <a href="{{ route('admin.doctors.create') }}" class="btn btn-success w-100">+ Thêm Bác sĩ</a>
                </div>
            </form>
            @foreach($allSpecialties as $specialty)
                @php
                    $filteredDoctors = $doctors->where('specialty_id', $specialty->id);
                @endphp
                @if($filteredDoctors->count())
                    <div class="mb-5">
                        <h5 class="text-primary border-bottom pb-2 mb-3">{{ $specialty->name }}</h5>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($filteredDoctors as $doctor)
                                <div class="col">
                                    <div class="card h-100 shadow-sm border border-primary">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $doctor->name }}</h5>
                                            <p class="card-text">Email: {{ $doctor->email }}</p>
                                            <p class="card-text">Chuyên khoa: {{ $specialty->name }}</p>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-success">Sửa</a>
                                                <form action="{{ route('admin.doctor.delete', $doctor->id) }}" method="POST" onsubmit="return confirm('Xóa bác sĩ này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @if($doctors->isEmpty())
                <p class="text-center text-muted">Không có bác sĩ nào phù hợp.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
