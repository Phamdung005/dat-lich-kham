<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-primary" href="#">ĐẶT LỊCH KHÁM</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ url('/') }}">Trang chủ</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ url('/register') }}">Đăng ký</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link" href="{{ url('/login') }}">Đăng nhập</a>
            </li>
        </ul>
    </div>

    
</nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>