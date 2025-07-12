@extends('client.layouts.app')

@section('content')
@if(session('status'))
<div id="toast-success" class="toast-custom toast-success toast-animate">
    <span class="toast-icon">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#388e3c" stroke-width="2"><circle cx="12" cy="12" r="10" fill="#e8f5e9"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12.5l2.5 2.5 5-5"/></svg>
    </span>
    <span class="toast-content">{{ session('status') }}</span>
    <span class="toast-close" onclick="document.getElementById('toast-success').remove()">&times;</span>
</div>
<script>
    setTimeout(function(){
        var el = document.getElementById('toast-success');
        if(el) el.style.opacity = 0;
    }, 3500);
    setTimeout(function(){
        var el = document.getElementById('toast-success');
        if(el) el.remove();
    }, 4000);
</script>
@endif

@if($errors->any())
<div id="toast-error" class="toast-custom toast-error toast-animate">
    <span class="toast-icon">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#d32f2f" stroke-width="2"><circle cx="12" cy="12" r="10" fill="#ffebee"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6"/></svg>
    </span>
    <span class="toast-content">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </span>
    <span class="toast-close" onclick="document.getElementById('toast-error').remove()">&times;</span>
</div>
<script>
    setTimeout(function(){
        var el = document.getElementById('toast-error');
        if(el) el.style.opacity = 0;
    }, 3500);
    setTimeout(function(){
        var el = document.getElementById('toast-error');
        if(el) el.remove();
    }, 4000);
</script>
@endif
<style>
    .toast-animate {
        opacity: 0;
        transform: translateY(-30px) scale(0.98);
        animation: toastIn 0.5s cubic-bezier(.4,0,.2,1) forwards;
    }
    @keyframes toastIn {
        0% {
            opacity: 0;
            transform: translateY(-30px) scale(0.98);
        }
        60% {
            opacity: 1;
            transform: translateY(4px) scale(1.01);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .toast-custom {
        position: fixed;
        top: 32px;
        right: 32px;
        z-index: 9999;
        width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 24px;
        margin-top: 90px;
        margin-left: 15px;

        font-size: 0.9rem;
        font-weight: 500;
        box-shadow: 0 4px 24px 0 rgba(0,0,0,0.12);
        opacity: 1;
        transition: opacity 0.5s;
        letter-spacing: 0.2px;
        border-bottom: 4px solid;
    }
    .toast-success {
        background: #e8f5e9;
        color: #388e3c;
        border-bottom-color: #388e3c;
    }
    .toast-error {
        background: #ffebee;
        color: #d32f2f;
        border-bottom-color: #d32f2f;
    }
    .toast-icon {
        display: flex;
        align-items: center;
        margin-right: 2px;
    }
    .toast-content {
        flex: 1;
        line-height: 1.5;
    }
    .toast-close {
        cursor: pointer;
        font-size: 1.3rem;
        font-weight: 700;
        color: #888;
        margin-left: 8px;
        transition: color 0.2s;
    }
    .toast-close:hover {
        color: #222;
    }
</style>
<div class="login-wrapper">
    <div class="login-section" style="max-width:420px;margin:auto;">
        <div class="login-title" style="font-weight: 600; color: black; font-size: 35px; margin-top: 14px;">Quên mật khẩu</div>
        
        
        <form method="POST" action="{{ route('client.password.email') }}">
            @csrf
            <label class="form-label" style="color: black; margin-top: 10px;" for="email">Nhập email để nhận link đặt lại mật khẩu:</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required>
            <button type="submit" class="btn btn-primary" style="margin-top:16px;width:100%;">Gửi email xác nhận</button>
        </form>
<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('client.login') }}"
       style="
           color: #000000ff;
           font-weight: 600;
           text-decoration: underline;
           text-underline-offset: 4px;
           display: inline-flex;
           align-items: center;
           transition: all 0.3s ease;
       "
       onmouseover="this.style.color='#1ccfcf'; this.style.transform='translateX(-2px)'"
       onmouseout="this.style.color='#000000ff'; this.style.transform='translateX(0)'"
    >
        <svg style="margin-right: 6px;" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Quay lại đăng nhập
    </a>
</div>





    </div>
</div>
@endsection
