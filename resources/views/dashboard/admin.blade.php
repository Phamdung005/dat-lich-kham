<h2>Admin Dashboard</h2>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" >Đăng xuất</button>
</form>