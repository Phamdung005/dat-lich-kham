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
    <title>Thông báo của bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <nav class="navbar navbar-light bg-light px-4 shadow-sm">
        <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <h5 class="fw-bold mb-4 text-center text-primary">Bệnh Nhân</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('patient.dashboard') }}">🏠 Trang chủ</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('patient.profile.show') }}">👤 Hồ sơ cá nhân</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('patient.appointments') ? 'active' : '' }}" href="{{ route('patient.appointments') }}">
                            📅 Lịch hẹn đã đặt
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('patient.appointments.history') ? 'active' : '' }}" href="{{ route('patient.appointments.history') }}">
                            📜 Lịch sử khám bệnh
                        </a>
                    </li>
                    <li class="nav-item mb-2 position-relative">
                        <a class="nav-link active" href="{{ route('patient.notifications') }}">
                            🔔 Thông báo
                            @if($unreadCount > 0)
                                <span class="badge bg-danger rounded-pill notification-badge">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm w-100">🚪 Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="col-md-10 content-wrapper">
                <h3 class="mb-4">🔔 Thông báo của bạn</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($notifications->isEmpty())
                    <div class="alert alert-info">Bạn chưa có thông báo nào.</div>
                @else
                    <form method="POST" action="{{ route('patient.notifications.deleteAll') }}" onsubmit="return confirm('Bạn có chắc muốn xóa tất cả thông báo?')" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa tất cả thông báo</button>
                    </form>
                    <ul class="list-group shadow-sm">
                        @foreach($notifications as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-start {{ $notification->is_read ? '' : 'bg-light' }}">
                                <div class="me-auto">
                                    <strong class="text-primary">{{ $notification->title }}</strong>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
