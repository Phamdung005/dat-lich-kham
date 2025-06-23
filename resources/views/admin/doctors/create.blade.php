<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Bác Sĩ Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav')

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary">Thêm Bác sĩ Mới</h2>

        <form action="{{ route('admin.doctors.store') }}" method="POST" class="mx-auto" style="max-width: 600px;">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Vui lòng kiểm tra lại dữ liệu:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Tên bác sĩ</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email bác sĩ</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="specialty_id" class="form-label">Chuyên khoa</label>
                <select class="form-select" id="specialty_id" name="specialty_id" required>
                    <option value="" disabled selected>-- Chọn chuyên khoa --</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
            </div>

          <div class="mb-4">
    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
    <input type="password" class="form-control" id="password" name="password" required>
</div>


            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-success">Tạo mới</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
