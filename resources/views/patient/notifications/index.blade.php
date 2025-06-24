@extends('layouts.app') {{-- nếu bạn có layout riêng --}}
@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Thông báo của bạn</h3>

    @if($notifications->isEmpty())
        <p>Không có thông báo nào.</p>
    @else
        <ul class="list-group">
            @foreach($notifications as $noti)
                <li class="list-group-item {{ $noti->is_read ? '' : 'bg-light' }}">
                    <strong>{{ $noti->title }}</strong><br>
                    <span class="text-muted">{{ $noti->message }}</span><br>
                    <small class="text-muted">{{ $noti->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
