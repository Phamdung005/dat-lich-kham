<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav')

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary">Quản lý Bác sĩ</h2>

        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 mb-5">
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
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">+ Thêm Bác sĩ</a>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
        </form>

        @foreach($allSpecialties as $specialty)
            @php
                $filteredDoctors = $doctors->where('specialty_id', $specialty->id);
            @endphp
            @if($filteredDoctors->count())
                <div class="mb-5">
                    <h4 class="text-primary border-bottom pb-2 mb-4">{{ $specialty->name }}</h4>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($filteredDoctors as $doctor)
                            <div class="col">
                                <div class="card h-100 shadow-sm border border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $doctor->name }}</h5>
                                        <p class="card-text">Email: {{ $doctor->email }}</p>
                                        <p class="card-text">Chuyên khoa: {{ $specialty->name }}</p>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-success">Sửa</a>

                                            <form action="{{ route('admin.doctor.delete', $doctor->id) }}" method="POST" onsubmit="return confirm('Xóa bác sĩ này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if($doctors->isEmpty())
            <p class="text-center text-muted">Không có bác sĩ nào phù hợp.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
