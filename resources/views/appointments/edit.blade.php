@php
    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trang chủ Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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

<!-- Navbar thương hiệu -->
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
                    <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" href="{{ route('patient.dashboard') }}">
                        🏠 Trang chủ
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.profile.show') ? 'active' : '' }}" href="{{ route('patient.profile.show') }}">
                        👤 Hồ sơ cá nhân
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                        📅 Lịch hẹn đã đặt
                    </a>
                </li>
                <li class="nav-item mb-2 position-relative">
                    <a class="nav-link {{ request()->routeIs('patient.notifications') ? 'active' : '' }}" href="{{ route('patient.notifications') }}">
                        🔔 Thông báo
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill notification-badge">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">
                            🚪 Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-10 content-wrapper">
            <div class="container bg-white p-4 rounded shadow" style="max-width: 600px; background-color: #f4f8fb;">
                <h2 class="mb-4 text-center">Chỉnh sửa lịch hẹn</h2>

                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Ngày khám</label>
                        <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                            value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Giờ khám</label>
                        <select class="form-select" id="appointment_time" name="appointment_time" required>
                            @foreach($allSlots as $label => $time)
                                <option value="{{ $time }}"
                                    @if($time == \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) selected @endif
                                    @if(!in_array($time, $availableSlots)) disabled @endif
                                >
                                    {{ $label }} @if(!in_array($time, $availableSlots)) (Đã có hẹn) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Triệu chứng, yêu cầu...">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
