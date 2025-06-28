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
    <title>Lịch sử khám bệnh</title>
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
                    <a class="nav-link" href="{{ route('patient.appointments') }}">📅 Lịch hẹn đã đặt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('patient.appointments.history') }}">
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

        <!-- Content -->
        <div class="col-md-10 content-wrapper">
            <h2 class="mb-4">📜 Lịch sử khám bệnh</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($appointments->isEmpty())
                <p>Không có lịch sử khám bệnh nào.</p>
            @else
                <form method="POST" action="{{ route('patient.appointments.history.deleteAll') }}" onsubmit="return confirm('Xác nhận xoá toàn bộ lịch sử khám?')" class="mb-3">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Xoá toàn bộ lịch sử</button>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bác sĩ</th>
                            <th>Chuyên khoa</th>
                            <th>Ngày khám</th>
                            <th>Giờ khám</th>
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
                                <td>
                                    @if($appointment->status == 'completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $appointment->notes }}</td>
                                <td>
                                    <form method="POST" action="{{ route('patient.appointments.history.delete', $appointment->id) }}" onsubmit="return confirm('Xác nhận xoá lịch sử này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
