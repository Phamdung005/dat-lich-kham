@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
@php
    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();
@endphp
<nav class="navbar navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar bg-white border-end py-4">
            <h5 class="fw-bold mb-4 text-center text-primary">Bệnh Nhân</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" href="{{ route('patient.dashboard') }}">
                        🏠 Trang chủ
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.profile.show') ? 'active' : '' }}" href="{{ route('patient.profile.show') }}">
                        👤 Hồ sơ cá nhân
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.appointments') ? 'active' : '' }}" href="{{ route('patient.appointments') }}">
                        📅 Lịch hẹn đã đặt
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('patient.appointments.history') ? 'active' : '' }}" href="{{ route('patient.appointments.history') }}">
                        📜 Lịch sử khám bệnh
                    </a>
                </li>
                <li class="nav-item mb-2 position-relative">
                    <a class="nav-link {{ request()->routeIs('patient.notifications') ? 'active' : '' }}" href="{{ route('patient.notifications') }}">
                        🔔 Thông báo
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">🚪 Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-10 content-wrapper p-4">
            <h2 class="mb-4 text-center">Hồ sơ cá nhân</h2>

            <p><strong>Họ tên:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Mật khẩu:</strong> Đã thiết lập</p>

            <hr>

            <button class="btn btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#editForm" aria-expanded="false" aria-controls="editForm">
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
                        <input
                            type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            id="current_password"
                            name="current_password"
                            required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input
                            type="password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password"
                            name="new_password"
                            required>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                        <input
                            type="password"
                            class="form-control @error('new_password_confirmation') is-invalid @enderror"
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            required>
                        @error('new_password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <a href="{{ route('patient.profile.show') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f4f8fb;
    }
    .sidebar {
        min-height: 100vh;
        background-color: #fff;
        border-right: 1px solid #ddd;
        padding: 1.5rem 1rem;
    }
    .nav-link.active {
        font-weight: bold;
        color: #0d6efd !important;
    }
    .notification-badge {
        font-size: 0.75rem;
        position: absolute;
        top: 0;
        right: -10px;
    }
    .content-wrapper {
        padding: 2rem;
        background-color: #fff;
        min-height: 100vh;
    }
    .profile-container {
        max-width: 600px;
        margin: 0 auto;
    }
</style>
@endpush
