<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ bác sĩ</title>
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
                    <a class="nav-link active" href="{{ route('doctor.appointmentdr') }}"><i class="fa-solid fa-calendar-check"></i> Lịch hẹn hiện tại</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('doctor.historyapp') }}"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử cuộc hẹn</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href=" {{ route('doctor.notificationdr') }}"><i class="fa-solid fa-bell"></i> Thông báo</a>
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
        <div class="col-md-10 content-wrapper">
            <div class="container mt-4">
                <h3 class="mb-4 text-primary">🔔 Thông báo của bạn</h3>
                
                @if ($notifications->isEmpty())
                    <div class="alert alert-info">Bạn chưa có thông báo nào.</div>
                @else
                    <form action="{{ route('doctor.notifications.deleteAll') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn xoá tất cả thông báo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xoá tất cả</button>
                    </form>
                    <ul class="list-group shawdow-sm">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-start {{ $notification->is_read ? '' : 'bg-light' }}">
                                <div class="me-auto">
                                    <strong class="fw-bold">{{ $notification->title }}</strong>
                                    <p class="mb-1">{{ $notification->message }}</p>
                                    <small class="text-muted">{{ $notification->created_at->format('H:i d/m/Y') }}</small>
                                </div>
                                <div class="text-end">
                                    @if(!$notification->is_read)
                                        <span class="badge bg-success mb-2">Mới</span>
                                    @endif
                                    <form method="POST" action="{{ route('patient.notifications.delete', $notification->id) }}" onsubmit="return confirm('Xóa thông báo này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">Xóa</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

