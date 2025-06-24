@extends('layouts.app')

@section('title', 'Lịch hẹn của bạn')

@section('content')
<div class="container">
    <h2>Danh sách lịch hẹn đã đặt</h2>

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
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th>Hành động</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                @php
                    $startTime = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i');
                @endphp
                <tr>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->doctor->specialty->name ?? 'Chưa có' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y') }}</td>
                    <td>{{ $slotDisplayMap[$startTime] ?? $startTime }}</td>
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
                            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này?');">
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
@endsection
