@extends('client.layouts.app')

@section('content')
<style>
.account-wrapper {
    display: flex;
    gap: 32px;
    max-width: 1200px;
    margin: 40px auto 60px auto;
}
.account-sidebar {
    flex: 0 0 320px;
    background: #fff;
    border-radius: 20px;
    padding: 36px 24px 32px 24px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.account-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #f2f2f2;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.account-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.account-menu {
    width: 100%;
    margin-top: 18px;
}
.account-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.account-menu li {
    margin-bottom: 16px;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.account-menu li.active a, .account-menu li a:hover {
    color: #1ccfcf;
    font-weight: 700;
}
.account-menu li a {
    color: #222;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.account-menu li .icon {
    font-size: 1.2rem;
    color: inherit; /* 🔁 Dùng màu chữ mặc định */
}

.account-divider {
    width: 100%;
    height: 1px;
    background: #eee;
    margin: 18px 0 18px 0;
}
.account-content {
    flex: 1 1 0%;
    background: #fff;
    border-radius: 20px;
    padding: 36px 32px 32px 32px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
}
.account-stats {
    display: flex;
    gap: 32px;
    margin-bottom: 28px;
}
.account-stat {
    flex: 1 1 0%;
    background: #f7fafd;
    border-radius: 16px;
    padding: 18px 0 12px 0;
    text-align: center;
    box-shadow: 0 1px 6px rgba(0,0,0,0.03);
}
.account-stat .icon {
    font-size: 2.1rem;
    /* Xoá màu để dùng màu mặc định theo ngữ cảnh */
    color: inherit;
}

.account-stat .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1ccfcf;
}
.account-stat .stat-label {
    font-size: 1.08rem;
    color: #555;
}
.account-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 18px;
}
.account-table th, .account-table td {
    padding: 12px 8px;
    text-align: left;
    font-size: 1.08rem;
}
.account-table th {
    color: #333;
    font-weight: 700;
    border-bottom: 2px solid #eee;
}
.account-table td {
    color: #222;
    border-bottom: 1px solid #f3f3f3;
}
@media (max-width: 900px) {
    .account-wrapper {
        flex-direction: column;
        gap: 18px;
    }
    .account-sidebar, .account-content {
        max-width: 100%;
        border-radius: 12px;
        padding: 18px 8px 18px 8px;
    }
    .account-content {
        padding: 18px 8px 18px 8px;
    }
}
</style>
<div class="account-wrapper">
    <div class="account-sidebar">
        <div class="account-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ececec&color=7de3e7&size=90" alt="Avatar">
        </div>
        <div class="account-divider"></div>
        <nav class="account-menu">
            <ul>
                <li class="active">@include('client.components.icons.cart')<a href="#">Danh sách sản phẩm</a></li>
                <li>@include('client.components.icons.user')<a href="{{ route('client.users.information') }}">Thông tin tài khoản</a></li>
                <li>@include('client.components.icons.map') <a href="#">Thông tin địa chỉ</a></li>
                <li>@include('client.components.icons.logout')<a href="{{ route('client.logout') }}">Đăng xuất</a></li>
            </ul>
        </nav>
    </div>
    <div class="account-content">
        <div class="account-stats">
            <div class="account-stat">
                <span class="icon">&#128722;</span>
                <span class="stat-number">0</span>
                <div class="stat-label">Sản phẩm đã mua</div>
            </div>
            <div class="account-stat">
                <span class="icon">&#128176;</span>
                <span class="stat-number">0</span>
                <div class="stat-label">Sản phẩm yêu thích</div>
            </div>
        </div>
        <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:18px;">Sản phẩm đã mua</h3>
        <table class="account-table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" style="text-align:center;color:#aaa;">Chưa có đơn hàng nào</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
