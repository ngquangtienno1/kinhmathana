@extends('client.layouts.app')

@section('content')
<div class="login-container">
    <h2>Quên mật khẩu</h2>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
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
    <form method="POST" action="{{ route('client.password.email') }}">
        @csrf
        <label for="email">Nhập email của bạn để nhận link đặt lại mật khẩu:</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required>
        <button type="submit" class="btn btn-primary" style="margin-top:16px;">Gửi email xác nhận</button>
    </form>
    <div style="margin-top:18px;">
        <a href="{{ route('client.login') }}">Quay lại đăng nhập</a>
    </div>
</div>
@endsection
