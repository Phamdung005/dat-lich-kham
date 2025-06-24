@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="container profile-container bg-white p-4 rounded shadow mt-5">
    <h2 class="mb-4 text-center">Hồ sơ cá nhân</h2>

    <p><strong>Họ tên:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Mật khẩu:</strong> Đã thiết lập</p>

    <hr>

    <button class="btn btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#editForm">
        Thay đổi thông tin
    </button>

    <div class="collapse" id="editForm">
        <form action="{{ route('patient.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Họ tên mới</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <hr>
            <h5 class="text-muted">Đổi mật khẩu</h5>

            <div class="mb-3">
                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <a href="{{ route('patient.profile.show') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f4f8fb;
    }
    .profile-container {
        max-width: 600px;
        margin: 50px auto;
    }
</style>
@endpush
