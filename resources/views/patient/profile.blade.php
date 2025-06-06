@extends('layouts.app')

@section('content')
<h2>Hồ sơ cá nhân</h2>
<p>Họ tên: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
@endsection
