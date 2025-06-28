<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lich hẹn của bác sĩ</title>
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
        <div class="col-md-10 p-4">
            <h2 class="mb-4">Lịch hẹn của bác sĩ</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($appointments->isEmpty())
                <p>Hiện tại bạn chưa có lịch hẹn nào.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bệnh nhân</th>
                            <th>Ngày khám</th>
                            <th>Thời gian khám</th>
                            <th>Số phòng</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name ?? 'không' }}</td>
                            @php
                                $startTime = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i');
                            @endphp
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y') }}</td>
                            <td>{{ $slotDisplayMap[$startTime] ?? $startTime }}</td>
                            <td>
                                <form method="POST" action="{{ route('appointments.assignRoom', $appointment) }}">
                                    @csrf
                                    <select name="room_number" class="form-select" onchange="this.form.submit()">
                                        <option value="">Chọn phòng</option>
                                            @foreach($rooms as $room)
                                                @php
                                                    $roomIsTaken = $appointments->contains(function ($a) use ($appointment, $room) {
                                                        return $a->id !== $appointment->id &&
                                                            $a->room_number === $room->room_number &&
                                                            \Carbon\Carbon::parse($a->appointment_time)->toDateString() === \Carbon\Carbon::parse($appointment->appointment_time)->toDateString() &&
                                                            \Carbon\Carbon::parse($a->appointment_time)->format('H:i') === \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') &&
                                                            in_array($a->status, ['pending', 'confirmed']);
                                                    });
                                                @endphp

                                                <option value="{{ $room->room_number }}"
                                                    @if($appointment->room_number === $room->room_number) selected @endif
                                                    @if($roomIsTaken && $appointment->room_number !== $room->room_number) disabled @endif>
                                                    {{ $room->room_number }}
                                                    @if($roomIsTaken && $appointment->room_number !== $room->room_number)
                                                        (Đã được đặt)
                                                    @endif
                                                </option>
                                            @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>{{ $appointment->notes }}</td>
                            <td>
                                @if($appointment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                @elseif($appointment->status == 'confirmed')
                                    <span class="badge bg-success">Đã xác nhận</span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-primary">Đã khám xong</span>
                                @endif
                            </td>
                            <td>
                                @if($appointment->status == 'pending')
                                    <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Xác nhận</button>
                                    </form>
                                    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Hủy</button>
                                    </form>
                                @elseif($appointment->status == 'confirmed')
                                    <form action="{{ route('appointments.complete', $appointment) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Đã khám xong</button>
                                    </form>
                                @else
                                    <span class="text-muted">Không khả dụng</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>