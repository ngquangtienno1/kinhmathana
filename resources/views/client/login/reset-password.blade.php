@extends('client.layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="login-section" style="max-width:420px;margin:auto;">
        <div class="login-title">Đặt lại mật khẩu mới</div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('client.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required>
            <label class="form-label" for="password">Mật khẩu mới</label>
            <input type="password" id="password" name="password" class="form-control" required>
            <label class="form-label" for="password_confirmation">Nhập lại mật khẩu mới</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            <button type="submit" class="btn btn-primary" style="margin-top:16px;width:100%;">Đặt lại mật khẩu</button>
        </form>
        <div style="margin-top:18px;">
            <a href="{{ route('client.login') }}">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
@endsection
