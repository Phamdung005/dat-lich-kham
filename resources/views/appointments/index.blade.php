@extends('layouts.app')

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
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->doctor->specialty->name ?? 'Chưa có' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
