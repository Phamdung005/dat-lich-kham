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
    <title>Lịch đã đặt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <!-- Sidebar -->
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
                    <a class="nav-link active" href="{{ route('patient.appointments') }}">📅 Lịch hẹn đã đặt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.appointments.history') ? 'active' : '' }}" href="{{ route('patient.appointments.history') }}">
                        📜 Lịch sử khám bệnh
                    </a>
                </li>
                <li class="nav-item mb-2 position-relative">
                    <a class="nav-link" href="{{ route('patient.notifications') }}">
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

        <!-- Nội dung chính -->
        <div class="col-md-10 content-wrapper">
            <h2 class="mb-4">📅 Danh sách lịch hẹn đã đặt</h2>

        @if($appointments->isEmpty())
            <p>Bạn chưa có lịch hẹn nào.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bác sĩ</th>
                        <th>Chuyên khoa</th>
                        <th>Ngày khám</th>
                        <th>Giờ khám</th>
                        <th>Số phòng</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td>{{ $appointment->doctor->specialty->name ?? 'Chưa có' }}</td>
                        @php
                            $startTime = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i');
                        @endphp
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y') }}</td>
                        <td>{{ $slotDisplayMap[$startTime] ?? $startTime }}</td>
                        <td>{{ $appointment->room_number }}</td>
                        <td>
                            @if($appointment->status == 'pending')
                                <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                            @elseif($appointment->status == 'confirmed')
                                <span class="badge bg-success">Đã xác nhận</span>
                            @elseif($appointment->status == 'cancelled')
                                <span class="badge bg-danger">Đã hủy</span>
                            @else
                                {{ $appointment->status }}
                            @endif
                        </td>
                        <td>{{ $appointment->notes }}</td>
                        <td>
                        @if($appointment->status != 'cancelled')
                            @if($appointment->status == 'pending')
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            @endif
                           <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">Hủy lịch</button>
                            </form>

                        @else
                            <span class="text-muted">Đã hủy</span>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
