@extends('client.layouts.app')

@section('content')
<style>
.info-wrapper {
    display: flex;
    gap: 32px;
    max-width: 1200px;
    margin: 40px auto 60px auto;
}
.info-sidebar {
    flex: 0 0 320px;
    background: #fff;
    border-radius: 20px;
    padding: 36px 24px 32px 24px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.info-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #f2f2f2;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.info-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.info-divider {
    width: 100%;
    height: 1px;
    background: #eee;
    margin: 18px 0 18px 0;
}
.info-menu {
    width: 100%;
    margin-top: 18px;
}
.info-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.info-menu li {
    margin-bottom: 16px;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-menu li.active a, .info-menu li a:hover {
    color: #1ccfcf;
    font-weight: 700;
}
.info-menu li a {
    color: #222;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.info-menu li .icon {
    font-size: 1.2rem;
}
.info-content {
    flex: 1 1 0%;
    background: #fff;
    border-radius: 20px;
    padding: 36px 32px 32px 32px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
}
.info-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 24px;
    color: #222;
}
.info-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px 48px;
    align-items: start;
    position: relative;
}
/* Đưa avatar ra giữa form, nằm trên 2 cột */
.info-form-avatar-center {
    grid-column: 1 / span 2;
    display: flex;
    justify-content: center;
    margin-bottom: 18px;
}
.info-avatar-upload .avatar-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f2f2f2;
    object-fit: cover;
    margin-bottom: 8px;
    border: 2px solid #ececec;
    position: relative;
    display: block;
}
/* Căn input thẳng hàng */
.info-form-left > div,
.info-form-right > div {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.info-form input[type="text"],
.info-form input[type="email"],
.info-form input[type="password"] {
    width: 100%;
    padding: 16px 24px;
    
    background:rgb(0, 0, 0); /* ✅ CHỈNH Ở ĐÂY */
    border-radius: 18px;
    font-size: 1.08rem;
    color: #222;
    margin-bottom: 0;
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    transition: background 0.2s, box-shadow 0.2s;
    min-height: 48px;
    box-sizing: border-box;
    display: block;
}

.info-form input:focus {
    outline: 2px solid rgb(0, 0, 0);
    background: #fff;
}
.info-form-actions {
    grid-column: 1 / span 2;
    display: flex;
    justify-content: flex-end;
    gap: 16px;
    margin-top: 24px;
}
.info-form-actions .btn-cancel {
    background: #f7fafd;
    color: #1ccfcf;
    border: none;
    border-radius: 16px;
    font-size: 1.1rem;
    font-weight: 700;
    padding: 13px 36px;
    transition: background 0.2s;
    min-width: 120px;
}
.info-form-actions .btn-save {
    background: #7de3e7;
    color: #fff;
    border: none;
    border-radius: 16px;
    font-size: 1.1rem;
    font-weight: 700;
    padding: 13px 36px;
    transition: background 0.2s;
    min-width: 160px;
}
.info-form-actions .btn-save:hover {
    background: #1ccfcf;
}
@media (max-width: 900px) {
    .info-wrapper {
        flex-direction: column;
        gap: 18px;
    }
    .info-sidebar, .info-content {
        max-width: 100%;
        border-radius: 12px;
        padding: 18px 8px 18px 8px;
    }
    .info-content {
        padding: 18px 8px 18px 8px;
    }
    .info-form {
        grid-template-columns: 1fr;
        gap: 0;
    }
    .info-form-avatar-center {
        grid-column: 1;
        margin-bottom: 12px;
    }
    .info-form-left, .info-form-right {
        gap: 18px;
    }
    .info-form-actions {
        grid-column: 1;
    }
}
</style>
<div class="info-wrapper">
    <div class="info-sidebar">
        <div class="info-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ececec&color=7de3e7&size=90" alt="Avatar">
        </div>
        <div class="info-divider"></div>
        <nav class="info-menu">
            <ul>
               <li >@include('client.components.icons.cart')<a href="{{ route('client.users.index') }}">Danh sách sản phẩm</a></li>
                <li class="active">@include('client.components.icons.user')<a href="#">Thông tin tài khoản</a></li>
                <li>@include('client.components.icons.map') <a href="#">Thông tin địa chỉ</a></li>
                 <li>@include('client.components.icons.logout')<a href="{{ route('client.logout') }}">Đăng xuất</a></li>
            </ul>
        </nav>
    </div>
    <div class="info-content">
        <div class="info-title">Thông tin tài khoản</div>
        <form class="info-form" method="POST" action="{{ route('client.users.information.update') }}" enctype="multipart/form-data">
            @csrf
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="info-form-avatar-center">
                <div class="info-avatar-upload">
                    <div style="position:relative;">
                        <img class="avatar-img" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ececec&color=7de3e7&size=120" alt="Avatar">
                        <label class="avatar-upload-btn" title="Đổi ảnh đại diện">
                            <input type="file" name="avatar" accept="image/*" style="display:none;">
                            <span style="font-size:1.2rem;">&#128247;</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="info-form-left">
                <div>
                    <label for="name">Tên hiển thị <span style="color:#e74c3c">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Tên hiển thị" value="{{ $user->name ?? $user->name }}">
                </div>
                <div>
                    <label for="email">Địa chỉ email <span style="color:#e74c3c">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Địa chỉ email" value="{{ $user->email }}">
                </div>
                <div>
                    <label for="phone">Số điện thoại <span style="color:#e74c3c">*</span></label>
                    <input type="text" id="phone" name="phone" placeholder="Số điện thoại" value="{{ $user->phone ?? '' }}">
                </div>
            </div>
            <div class="info-form-right">
                <div>
                    <label for="current_password">Mật khẩu hiện tại</label>
                    <div style="position:relative;">
                        <input type="password" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại" style="padding-right:40px;">
                        <button type="button" onclick="togglePassword('current_password', this)" style="position:absolute;top:50%;right:10px;transform:translateY(-50%);background:transparent;border:none;outline:none;cursor:pointer;padding:0;">
                            <svg id="icon-current_password" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Mật khẩu mới">
                </div>
                <div>
                    <label for="new_password_confirmation">Nhập lại mật khẩu</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Nhập lại mật khẩu">
                </div>
            </div>
            <div class="info-form-actions">
                <button type="button" class="btn-cancel">Hủy</button>
                <button type="submit" class="btn-save">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-6.06M1 1l22 22"/><circle cx="12" cy="12" r="3"/></svg>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    }
}
</script>
@endsection
