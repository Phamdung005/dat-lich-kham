@php
    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary">Phòng Khám Sức Khỏe Minh Dũng</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ route('patient.dashboard') }}">Trang chủ</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ route('patient.profile.show') }}">Hồ sơ cá nhân</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ route('appointments.index') }}">Lịch hẹn đã đặt</a>
            </li>

            @if(Auth::check() && Auth::user()->role == 'patient')
                <li class="nav-item mx-2 position-relative">
                    <a class="nav-link p-0" href="{{ route('patient.notifications') }}">
                        <img src="{{ asset('icons/bell.svg') }}" alt="Thông báo" style="width: 24px; height: 24px;">
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </li>
            @endif

            <li class="nav-item mx-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">Đăng xuất</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
