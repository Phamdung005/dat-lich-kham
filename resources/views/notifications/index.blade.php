@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Thông báo của bạn</h4>

    @if($notifications->isEmpty())
        <div class="alert alert-info">Bạn chưa có thông báo nào.</div>
    @else
        <ul class="list-group">
            @foreach ($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $notification->message }}</span>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
