<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="col-md-2 sidebar text-center">
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
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('doctor.dashboard') }}">Trang chủ</a>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('doctor.profileDoctor.show') }}">Hồ sơ cá nhân</a>
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
            <form action="{{ route('doctor.profileDoctor.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>










