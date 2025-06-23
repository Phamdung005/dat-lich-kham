<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Thông Tin Bác Sĩ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav')

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary">Chỉnh sửa thông tin bác sĩ</h2>

        <form action="{{ route('admin.doctor.update', $doctor->id) }}" method="POST" class="mx-auto" style="max-width: 600px;">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Họ tên</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="specialty_id" class="form-label">Chuyên khoa</label>
                <select name="specialty_id" class="form-select" required>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->id }}" {{ $doctor->specialty_id == $specialty->id ? 'selected' : '' }}>
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
