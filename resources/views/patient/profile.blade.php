<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navigation.nav');

    @extends('layouts.app')
    @section('content')
    <h2>Hồ sơ cá nhân</h2>
    <p>Họ tên: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    @endsection
</body>
</html>

