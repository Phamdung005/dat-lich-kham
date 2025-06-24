<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav')
    @extends('layouts.app') 

    @section('content')
    <div class="container mt-4">
        <h3 class="mb-4">🔔 Thông báo của bạn</h3>

        @if($notifications->isEmpty())
            <div class="alert alert-info">Bạn chưa có thông báo nào.</div>
        @else
            <ul class="list-group shadow-sm">
                @foreach($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-start {{ $notification->is_read ? '' : 'bg-light' }}">
                        <div class="me-auto">
                            <strong class="text-primary">{{ $notification->title }}</strong>
                            <p class="mb-1">{{ $notification->message }}</p>
                            <small class="text-muted">{{ $notification->created_at->format('H:i d/m/Y') }}</small>
                        </div>
                        @if(!$notification->is_read)
                            <span class="badge bg-success mt-1">Mới</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    @endsection

</body>
</html>
