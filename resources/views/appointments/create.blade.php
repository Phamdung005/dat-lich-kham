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
            max-width: 500px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    @include('navigation.nav')
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="mb-4 text-center">Đặt lịch khám</h2>
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
                <label for="appointment_time" class="form-label">Thời gian khám:</label>
                <input type="datetime-local" class="form-control" name="appointment_time" id="appointment_time" required>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Ghi chú:</label>
                <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Triệu chứng, yêu cầu..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Xác nhận đặt lịch</button>
        </form>
    </div>
</body>
</html>
