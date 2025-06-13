<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lịch</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    @include('navigation.nav')
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
                        <th>Ghi chú</th>
                        <th>Hành động</th> 
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

</body>
</html>
