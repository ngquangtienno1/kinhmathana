@extends('client.layouts.app')

@section('content')
    <style>
        .register-wrapper {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 48px;
            max-width: 1400px;
            margin: 48px auto 64px auto;
        }

        .register-image {
            margin-top: 100px;
    flex: 1 1 50%;
    border-radius: 32px;
    overflow: hidden;
    height: 550px;
    padding: 0; /* loại bỏ padding nếu có */
        }

        .register-image img {
           width: 100%;
    height: 100%;
    display: block;
    border-radius: 32px;
    object-fit: cover;
        }

        .btn-primary:hover {
            background: #1ccfcf;
        }

        .login-link {
            color: #000000ff;
            text-decoration: underline;
            font-weight: 600;
            font-size: 1rem;
        }

        .login-link:hover {
            color: #0b8b8b;
        }

        .register-section {
            flex: 1 1 50%;
            background: #fff;
            border-radius: 0;
            box-shadow: none;
            border: none;
            padding: 36px 32px 28px;
            font-family: 'Quicksand', 'Segoe UI', Arial, sans-serif;
            min-width: 340px;
           
        }

        .register-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: left;
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        .register-desc {
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
            border: 2.5px solid #222;
            border-radius: 10px;
            font-size: 1.08rem;
            color: #222;
            background: #fff;
            margin-bottom: 18px;
            transition: border 0.2s;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #111;
            outline: none;
        }

        .form-info {
            font-size: 1rem;
            color: #222;
            margin-bottom: 18px;
        }

        .form-info .policy-link {
            color: #b97a3c;
            font-weight: 600;
            text-decoration: underline;
        }

        .btn-primary {
            display: block;
            margin: 0 auto 18px auto;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 13px 0;
            width: 100%;
            transition: background 0.2s;
            box-shadow: none;
            text-align: center;
            letter-spacing: 2px;
        }

        .btn-primary:hover {
            background: #222;
        }

        .or-divider {
            text-align: center;
            font-size: 1.1rem;
            color: #222;
            margin: 18px 0 10px 0;
            font-weight: 600;
        }

        .google-btn  {
            display: flex;
            align-items: center;
            background: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 13px 18px;
            width: 100%;
            margin-top: 0;
            margin-bottom: 0;
            font-size: 1.08rem;
            font-weight: 600;
            color: #222;
            transition: box-shadow 0.2s;
            cursor: pointer;
            justify-content: flex-start;
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

        .register-bottom-text {
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
            .register-wrapper {
                flex-direction: column;
                align-items: center;
                gap: 24px;
            }

            .register-image,
            .register-section {
                max-width: 100%;
                min-width: 0;
            }

            .register-section {
                padding: 24px 8px 18px;
            }
        }

        @media (max-width: 600px) {
            .register-wrapper {
                gap: 12px;
                margin: 16px 0;
            }

            .register-image {
                border-radius: 16px;
            }

            .register-section {
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
    <div class="register-wrapper">
        <div class="register-image">
            <img src="{{ asset('uploads/avatars/Pic1.jpg') }}" alt="Register" />
        </div>
        <div class="register-section">
            <div class="register-title">Đăng ký email</div>
            <div class="register-desc">Hãy đăng ký để được hưởng nhiều đặc quyền riêng dành cho bạn</div>
            <form action="{{ route('client.postRegister') }}" method="POST">
                @csrf
                <label class="form-label" for="username">Họ và tên<span class="required">*</span></label>
                <input class="form-control" name="name" id="name" type="text" placeholder="Nhập tên của bạn"
                    value="{{ old('name') }}" />
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <label class="form-label" for="email">Email<span class="required">*</span></label>
                <input class="form-control" id="email" name="email" type="email" placeholder="Nhập email"
                    value="{{ old('email') }}" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <label class="form-label" for="password">Mật khẩu<span class="required">*</span></label>
                <input class="form-control" id="password" name="password" type="password" placeholder="Nhập mật khẩu" />
                @error('password')
                    @if (!str_contains($message, 'xác nhận'))
                        <small class="text-danger">{{ $message }}</small>
                    @endif
                @enderror
                <label class="form-label" for="confirmPassword">Xác nhận mật khẩu<span class="required">*</span></label>
                <div class="position-relative" data-password="data-password">
                    <input class="form-control" id="confirmPassword" type="password" name="password_confirmation"
                        placeholder="Xác nhận mật khẩu" value="{{ old('password_confirmation') }}" />
                </div>
                @if ($errors->has('password') && str_contains($errors->first('password'), 'xác nhận'))
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                @endif
                <div class="form-info">
                    Thông tin của bạn sẽ được bảo mật theo <a class="policy-link" href="#">chính sách riêng tư</a> của
                    chúng tôi
                </div>
                <button class="btn btn-primary" type="submit">Đăng ký ngay</button>
                <div class="or-divider">Hoặc</div>
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
                          Đăng nhập bằng <b>&nbsp;Google</b>
                </button>
            </form>
            <div class="register-bottom-text">
                Bạn chưa có tài khoản Anna ?<br>
                <a class="login-link" href="{{ route('client.login') }}">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
@endsection
