@extends('client.layouts.app')

@section('content')
<<<<<<< HEAD
<style>
.login-wrapper {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 48px;
    max-width: 1100px;
    margin: 48px auto 64px auto;
}
.login-image {
    flex: 1 1 50%;
    min-width: 340px;
    max-width: 520px;
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
}
.login-image img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 32px;
    object-fit: cover;
}
.login-section {
    flex: 1 1 50%;
    background: #fff;
    border-radius: 0;
    box-shadow: none;
    border: none;
    padding: 36px 32px 28px;
    font-family: 'Quicksand', 'Segoe UI', Arial, sans-serif;
    min-width: 340px;
    max-width: 480px;
}
.login-title {
    font-size: 2rem;
    font-weight: 700;
    text-align: left;
    margin-bottom: 6px;
    letter-spacing: 0.01em;
}
.login-desc {
    text-align: left;
    font-size: 1rem;
    color: #222;
    margin-bottom: 28px;
}
.form-label {
    font-weight: 700;
    font-size: 1.08rem;
    margin-bottom: 7px;
    color: #222;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    display: block;
}
.form-label .required {
    color: #e74c3c;
    margin-left: 2px;
}
.form-control {
    width: 100%;
    padding: 13px 18px;
    border: 2.5px solid #7de3e7;
    border-radius: 10px;
    font-size: 1.08rem;
    color: #222;
    background: #fff;
    margin-bottom: 18px;
    transition: border 0.2s;
    font-family: inherit;
}
.form-control:focus {
    border-color: #1ccfcf;
    outline: none;
}
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 18px;
}
.form-check-input {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    accent-color: #1ccfcf;
}
.form-check-label {
    font-size: 1rem;
    color: #222;
    font-weight: 500;
}
.btn-primary {
    display: block;
    margin: 0 auto 18px auto;
    background: #7de3e7;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 700;
    padding: 13px 0;
    width: 70%;
    transition: background 0.2s;
    box-shadow: none;
    text-align: center;
}
.btn-primary:hover {
    background: #1ccfcf;
}
.login-link {
    color: #1ccfcf;
    text-decoration: underline;
    font-weight: 600;
    font-size: 1rem;
}
.login-link:hover {
    color: #0b8b8b;
}
.google-btn {
    display: flex;
    align-items: center;
    background: #fff;
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    padding: 13px 18px;
    width: 100%;
    margin-top: 18px;
    margin-bottom: 0;
    font-size: 1.08rem;
    font-weight: 600;
    color: #222;
    transition: box-shadow 0.2s;
    cursor: pointer;
}
.google-btn:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
}
.google-btn .google-icon {
    width: 24px;
    height: 24px;
    margin-right: 12px;
    display: inline-block;
}
.login-bottom-text {
    text-align: center;
    margin-top: 22px;
    font-size: 1rem;
    color: #222;
}
.text-danger {
    color: #e74c3c;
    font-size: 0.98rem;
    margin-top: -12px;
    margin-bottom: 10px;
    display: block;
}
@media (max-width: 1024px) {
    .login-wrapper {
        flex-direction: column;
        align-items: center;
        gap: 24px;
    }
    .login-image, .login-section {
        max-width: 100%;
        min-width: 0;
    }
    .login-section {
        padding: 24px 8px 18px;
    }
}
@media (max-width: 600px) {
    .login-wrapper {
        gap: 12px;
        margin: 16px 0;
    }
    .login-image {
        border-radius: 16px;
    }
    .login-section {
        border-radius: 0;
        padding: 12px 2px 8px;
    }
    .btn-primary, .google-btn {
        font-size: 1rem;
        padding: 11px 0;
    }
    .form-control {
        font-size: 1rem;
        padding: 11px 12px;
    }
}
</style>
<div class="login-wrapper">
    <div class="login-image">
        <img src="/path/to/your/login-image.jpg" alt="Login" />
    </div>
    <div class="login-section">
        <div class="login-title">Đăng nhập</div>
        <div class="login-desc">Hãy đăng nhập để được hưởng đặc quyền riêng dành cho bạn</div>
        <form action="{{ route('postLogin') }}" method="POST">
            @csrf
            <label class="form-label" for="email">Tài khoản<span class="required">*</span></label>
            <input class="form-control" id="email" name="email" type="text" placeholder="Nhập tài khoản" value="{{ old('email') }}" />
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="form-label" for="password">Mật khẩu<span class="required">*</span></label>
            <div style="position:relative;display:flex;align-items:center;">
                <input class="form-control" id="password" name="password" type="password" placeholder="Nhập mật khẩu" style="padding-right:40px;" />
                <button type="button" onclick="togglePassword('password', this)" style="position:absolute;right:10px;top:-6px;bottom:0;height:100%;display:flex;align-items:center;background:transparent;border:none;outline:none;cursor:pointer;padding:0;">
                    <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="form-check">
                <input class="form-check-input" id="basic-checkbox" type="checkbox" />
                <label class="form-check-label mb-0" for="basic-checkbox">Lưu tài khoản</label>
            </div>
            <button class="btn btn-primary" type="submit">Đăng nhập</button>
            <div style="margin-bottom: 12px;"><a class="login-link" href="{{ route('client.password.request') }}">Quên mật khẩu ?</a></div>
            <button type="button" class="google-btn" onclick="location.href='{{ route('login.google') }}'">
                <span class="google-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><g><path fill="#4285F4" d="M43.6 20.5h-1.9V20H24v8h11.3c-1.6 4.3-5.7 7-11.3 7-6.6 0-12-5.4-12-12s5.4-12 12-12c2.7 0 5.2.9 7.2 2.4l6-6C36.1 5.1 30.4 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21c10.5 0 20-7.7 20-21 0-1.4-.2-2.7-.4-3.5z"/><path fill="#34A853" d="M6.3 14.7l6.6 4.8C14.5 16.1 18.8 13 24 13c2.7 0 5.2.9 7.2 2.4l6-6C36.1 5.1 30.4 3 24 3 16.1 3 9.1 7.6 6.3 14.7z"/><path fill="#FBBC05" d="M24 45c6.2 0 11.4-2 15.2-5.4l-7-5.7C29.5 35.7 26.9 37 24 37c-5.5 0-10.1-3.7-11.7-8.7l-6.6 5.1C9.1 40.4 16.1 45 24 45z"/><path fill="#EA4335" d="M43.6 20.5h-1.9V20H24v8h11.3c-0.7 2-2.1 3.7-4.1 4.9l6.6 5.1C41.9 39.1 45 32.7 45 24c0-1.4-.2-2.7-.4-3.5z"/></g></svg></span>
                Đăng nhập bằng <b>Google</b>
            </button>
        </form>
        <div class="login-bottom-text">
            Bạn chưa có tài khoản Anna ?<br>
            <a class="login-link" href="{{ route('client.register') }}">Đăng ký ngay</a>
        </div>
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
=======
    <style>
        .login-wrapper {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 48px;
            max-width: 1100px;
            margin: 48px auto 64px auto;
        }

        .login-image {
            flex: 1 1 50%;
            min-width: 340px;
            max-width: 520px;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            background: #f7f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 32px;
            object-fit: cover;
        }

        .login-section {
            flex: 1 1 50%;
            background: #fff;
            border-radius: 0;
            box-shadow: none;
            border: none;
            padding: 36px 32px 28px;
            font-family: 'Quicksand', 'Segoe UI', Arial, sans-serif;
            min-width: 340px;
            max-width: 480px;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: left;
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        .login-desc {
            text-align: left;
            font-size: 1rem;
            color: #222;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 700;
            font-size: 1.08rem;
            margin-bottom: 7px;
            color: #222;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            display: block;
        }

        .form-label .required {
            color: #e74c3c;
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 13px 18px;
            border: 2.5px solid #7de3e7;
            border-radius: 10px;
            font-size: 1.08rem;
            color: #222;
            background: #fff;
            margin-bottom: 18px;
            transition: border 0.2s;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #1ccfcf;
            outline: none;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            accent-color: #1ccfcf;
        }

        .form-check-label {
            font-size: 1rem;
            color: #222;
            font-weight: 500;
        }

        .btn-primary {
            display: block;
            margin: 0 auto 18px auto;
            background: #7de3e7;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 13px 0;
            width: 70%;
            transition: background 0.2s;
            box-shadow: none;
            text-align: center;
        }

        .btn-primary:hover {
            background: #1ccfcf;
        }

        .login-link {
            color: #1ccfcf;
            text-decoration: underline;
            font-weight: 600;
            font-size: 1rem;
        }

        .login-link:hover {
            color: #0b8b8b;
        }

        .google-btn {
            display: flex;
            align-items: center;
            background: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 13px 18px;
            width: 100%;
            margin-top: 18px;
            margin-bottom: 0;
            font-size: 1.08rem;
            font-weight: 600;
            color: #222;
            transition: box-shadow 0.2s;
            cursor: pointer;
        }

        .google-btn:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
        }

        .google-btn .google-icon {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            display: inline-block;
        }

        .login-bottom-text {
            text-align: center;
            margin-top: 22px;
            font-size: 1rem;
            color: #222;
        }

        .text-danger {
            color: #e74c3c;
            font-size: 0.98rem;
            margin-top: -12px;
            margin-bottom: 10px;
            display: block;
        }

        @media (max-width: 1024px) {
            .login-wrapper {
                flex-direction: column;
                align-items: center;
                gap: 24px;
            }

            .login-image,
            .login-section {
                max-width: 100%;
                min-width: 0;
            }

            .login-section {
                padding: 24px 8px 18px;
            }
        }

        @media (max-width: 600px) {
            .login-wrapper {
                gap: 12px;
                margin: 16px 0;
            }

            .login-image {
                border-radius: 16px;
            }

            .login-section {
                border-radius: 0;
                padding: 12px 2px 8px;
            }

            .btn-primary,
            .google-btn {
                font-size: 1rem;
                padding: 11px 0;
            }

            .form-control {
                font-size: 1rem;
                padding: 11px 12px;
            }
        }
    </style>
    <div class="login-wrapper">
        <div class="login-image">
            <img src="/path/to/your/login-image.jpg" alt="Login" />
        </div>
        <div class="login-section">
            <div class="login-title">Đăng nhập</div>
            <div class="login-desc">Hãy đăng nhập để được hưởng đặc quyền riêng dành cho bạn</div>
            <form action="{{ route('postLogin') }}" method="POST">
                @csrf
                <label class="form-label" for="email">Tài khoản<span class="required">*</span></label>
                <input class="form-control" id="email" name="email" type="text" placeholder="Nhập tài khoản"
                    value="{{ old('email') }}" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <label class="form-label" for="password">Mật khẩu<span class="required">*</span></label>
                <input class="form-control" id="password" name="password" type="password" placeholder="Nhập mật khẩu" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-check">
                    <input class="form-check-input" id="basic-checkbox" type="checkbox" />
                    <label class="form-check-label mb-0" for="basic-checkbox">Lưu tài khoản</label>
                </div>
                <button class="btn btn-primary" type="submit">Đăng nhập</button>
                <div style="margin-bottom: 12px;"><a class="login-link" href="{{ asset('forgot-password.html') }}">Quên mật
                        khẩu ?</a></div>
                <button type="button" class="google-btn" onclick="location.href='{{ route('login.google') }}'">
                    <span class="google-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g>
                                <path fill="#4285F4"
                                    d="M43.6 20.5h-1.9V20H24v8h11.3c-1.6 4.3-5.7 7-11.3 7-6.6 0-12-5.4-12-12s5.4-12 12-12c2.7 0 5.2.9 7.2 2.4l6-6C36.1 5.1 30.4 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21c10.5 0 20-7.7 20-21 0-1.4-.2-2.7-.4-3.5z" />
                                <path fill="#34A853"
                                    d="M6.3 14.7l6.6 4.8C14.5 16.1 18.8 13 24 13c2.7 0 5.2.9 7.2 2.4l6-6C36.1 5.1 30.4 3 24 3 16.1 3 9.1 7.6 6.3 14.7z" />
                                <path fill="#FBBC05"
                                    d="M24 45c6.2 0 11.4-2 15.2-5.4l-7-5.7C29.5 35.7 26.9 37 24 37c-5.5 0-10.1-3.7-11.7-8.7l-6.6 5.1C9.1 40.4 16.1 45 24 45z" />
                                <path fill="#EA4335"
                                    d="M43.6 20.5h-1.9V20H24v8h11.3c-0.7 2-2.1 3.7-4.1 4.9l6.6 5.1C41.9 39.1 45 32.7 45 24c0-1.4-.2-2.7-.4-3.5z" />
                            </g>
                        </svg></span>
                    Đăng nhập bằng <b>Google</b>
                </button>
            </form>
            <div class="login-bottom-text">
                Bạn chưa có tài khoản Anna ?<br>
                <a class="login-link" href="{{ route('client.register') }}">Đăng ký ngay</a>
            </div>
        </div>
    </div>
@endsection
>>>>>>> 79b1bb162aabbc10017718859a748ba1c7c1e357
