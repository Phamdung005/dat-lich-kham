<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa lịch hẹn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f8fb;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

@include('navigation.nav')

@extends('layouts.app')
@section('content')

<div class="container bg-white p-4 rounded shadow">
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
@endsection
</body>
</html>
