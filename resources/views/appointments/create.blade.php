@php
    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lịch khám</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f8fb;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #fff;
            border-right: 1px solid #ddd;
            padding: 1.5rem 1rem;
        }
        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
        .container-custom {
            max-width: 600px;
        }
        .time-button.active {
            background-color: #0d6efd;
            color: white;
        }
        .notification-badge {
            font-size: 0.75rem;
            position: absolute;
            top: 0;
            right: -10px;
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
                    <a class="nav-link" href="{{ route('appointments.index') }}">📅 Lịch hẹn đã đặt</a>
                </li>
                <li class="nav-item mb-2 position-relative">
                    <a class="nav-link active" href="{{ route('appointment.create') }}">
                        📋 Đặt lịch khám
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
        <div class="col-md-10 d-flex justify-content-center align-items-start py-4">
            <div class="container bg-white p-4 rounded shadow container-custom">
                <h2 class="mb-4 text-center">Đặt lịch khám</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('appointment.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Bác sĩ:</label>
                        <select class="form-select" name="doctor_id" id="doctor_id" required>
                            <option value="">-- Chọn bác sĩ --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ (isset($doctorId) && $doctorId == $doctor->id) ? 'selected' : '' }}>
                                    {{ $doctor->name }} - {{ $doctor->specialty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Chọn ngày khám:</label>
                        <input type="date" class="form-control" name="appointment_date" id="appointment_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chọn giờ khám:</label>
                        <div id="time-slots" class="d-flex flex-wrap gap-2">
                            <p class="text-muted">Vui lòng chọn ngày khám</p>
                        </div>
                        <input type="hidden" name="appointment_time" id="selected_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú:</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Triệu chứng, yêu cầu..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Xác nhận đặt lịch</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('appointment_date').addEventListener('change', fetchAvailableTimes);
    document.getElementById('doctor_id').addEventListener('change', fetchAvailableTimes);

    function fetchAvailableTimes() {
        let doctorId = document.getElementById('doctor_id').value;
        let date = document.getElementById('appointment_date').value;
        let container = document.getElementById('time-slots');

        if (!doctorId || !date) {
            container.innerHTML = '<p class="text-muted">Vui lòng chọn bác sĩ và ngày để xem giờ rảnh.</p>';
            return;
        }

        fetch(`/api/available-times?doctor_id=${doctorId}&date=${date}`)
            .then(res => res.json())
            .then(times => {
                container.innerHTML = '';

                if (times.length === 0) {
                    container.innerHTML = '<p class="text-danger">Không còn giờ trống trong ngày này.</p>';
                    return;
                }
                const allSlots = ['08:00 - 09:30', '09:30 - 11:00', '11:00 - 12:30', '12:30 - 14:00', '14:00 - 15:30', '15:30 - 17:00', '17:00 - 18:30'];
                const slotMap = {
                    '08:00 - 09:30': '08:00',
                    '09:30 - 11:00': '09:30',
                    '11:00 - 12:30': '11:00',
                    '12:30 - 14:00': '12:30',
                    '14:00 - 15:30': '14:00',
                    '15:30 - 17:00': '15:30',
                    '17:00 - 18:30': '17:00'
                };
                allSlots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn btn-outline-primary time-button';
                    btn.textContent = slot;
                    btn.style.minWidth = '120px';

                    if (times.includes(slot)) {
                        btn.onclick = function () {
                            document.querySelectorAll('.time-button').forEach(b => b.classList.remove('active'));
                            btn.classList.add('active');
                            document.getElementById('selected_time').value = slotMap[slot];
                        };
                    } else {
                        btn.disabled = true;
                        btn.classList.add('btn-secondary');
                        btn.title = 'Giờ này đã được đặt';
                    }

                    container.appendChild(btn);
                });
            })
            .catch(() => {
                container.innerHTML = '<p class="text-danger">Lỗi khi tải giờ khám. Vui lòng thử lại.</p>';
            });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
