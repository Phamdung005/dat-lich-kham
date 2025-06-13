<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav');

    <div class="container mt-5">
        <h2 class="text-center mb-4">Chào mừng {{ $user->name }} đến với hệ thống đặt lịch khám</h2>
        <p class="text-center text-muted mb-5">Đặt lịch nhanh chóng, dễ dàng, theo dõi lịch sử khám bệnh tiện lợi</p>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($specialties as $specialty)
                @foreach($specialty->doctors as $doctor)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $doctor->name }}</h5>
                                <p class="card-text text-muted mb-1">Email: {{ $doctor->email }}</p>
                                <p class="card-text text-muted">Chuyên khoa: {{ $specialty->name }}</p>
                                <form action="{{ route('appointment.create') }}" method="GET">
                                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Đặt lịch khám</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

</body>
</html>
