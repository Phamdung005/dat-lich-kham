@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa lịch hẹn</h2>

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
            <input type="time" class="form-control" id="appointment_time" name="appointment_time" 
                   value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Ghi chú</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
