<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav')

    <div class="container mt-5">
        <h2 class="text-center mb-4">Chào mừng {{ $user->name }} đến với hệ thống đặt lịch khám</h2>
        <p class="text-center text-muted mb-5">Đặt lịch nhanh chóng, dễ dàng, theo dõi lịch sử khám bệnh tiện lợi</p>

        <form method="GET" action="{{ route('patient.dashboard') }}" class="row g-3 mb-5">
    <div class="col-md-6">
        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm theo tên bác sĩ">
    </div>
    <div class="col-md-4">
        <select name="specialty_id" class="form-select">
            <option value="">Tất cả chuyên khoa</option>
            @foreach($allSpecialties as $item)
                <option value="{{ $item->id }}" {{ request('specialty_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
    </div>
</form>

    @foreach($specialties as $specialty)
        <div class="mb-5">
            <h4 class="text-primary border-bottom pb-2 mb-4">{{ $specialty->name }}</h4>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($specialty->doctors as $doctor)
                    <div class="col">
                        <div class="card h-100 shadow-sm text-center" style="border: 2px solid #000;">
                            <div class="card-body">
                                @if($doctor->user->avatar)
                                    <img src="{{ asset('storage/' . $doctor->user->avatar) }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('default-avatar.png') }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <h5 class="card-title text-primary">{{ $doctor->name }}</h5>
                                <p class="card-text text-muted mb-1">Email: {{ $doctor->email }}</p>
                                <p class="card-text text-muted mb-1">SĐT: {{ $doctor->user->phone }}</p>
                                <p class="card-text text-muted">Chuyên khoa: {{ $specialty->name }}</p>
                                <form action="{{ route('appointment.create') }}" method="GET">
                                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Đặt lịch khám</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
