@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách lịch hẹn đã đặt</h2>

    {{-- Nút quay lại --}}
    <a href="{{ route('patient.dashboard') }}" class="btn btn-secondary mb-3">← Quay lại Dashboard</a>

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
                    <th>Hành động</th> {{-- Cột mới --}}
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
                    <td>{{ $appointment->notes }}</td>
                    <td>
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-primary">Sửa</a>

                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xoá lịch hẹn này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
