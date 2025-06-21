@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Doctor Dashboard</h2>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger mb-3">Đăng xuất</button>
    </form>

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
                    <th>Thời gian khám</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'không' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y H:i') }}</td>
                    <td>{{ $appointment->notes }}</td>
                    <td>
                        @if($appointment->status == 'pending')
                            <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge bg-success">Đã xác nhận</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
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
@endsection
