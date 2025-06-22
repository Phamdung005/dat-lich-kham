<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lịch khám</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f8fb;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .time-button.active {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
    @include('navigation.nav')
    <div class="container bg-white p-4 rounded shadow">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            tooltipTriggerList.forEach(function (el) {
                new bootstrap.Tooltip(el);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
