<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lịch khám</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        select, input, textarea, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Đặt lịch khám</h2>

    <form method="POST" action="{{ route('appointment.store') }}">
        @csrf
        <label>Bác sĩ:</label>
        <select name="doctor_id" required>
            <option value="">-- Chọn bác sĩ --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ (isset($doctorId) && $doctorId == $doctor->id) ? 'selected' : '' }}>
                        {{ $doctor->name }} - {{ $doctor->specialty }}
                    </option>
                @endforeach
        </select>

        <label>Thời gian khám:</label>
        <input type="datetime-local" name="appointment_time" required>

        <label>Ghi chú:</label>
        <textarea name="notes" placeholder="Triệu chứng, yêu cầu..."></textarea>

        <button type="submit">Xác nhận đặt lịch</button>
    </form>
</div>
</body>
</html>
