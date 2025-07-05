<<<<<<< HEAD
=======
@extends('client.layouts.app')

@section('content')
    <style>
        .account-info-wrapper {
            max-width: 600px;
            margin: 40px auto 60px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.04);
            padding: 36px 32px 32px 32px;
        }

        .account-info-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #1ccfcf;
            text-align: center;
        }

        .account-info-form label {
            font-weight: 600;
            color: #222;
            margin-bottom: 6px;
            display: block;
        }

        .account-info-form input[type="text"],
        .account-info-form input[type="email"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #7de3e7;
            border-radius: 10px;
            font-size: 1.08rem;
            margin-bottom: 18px;
            background: #f7fafd;
            color: #222;
            transition: border 0.2s;
        }

        .account-info-form input:focus {
            border-color: #1ccfcf;
            outline: none;
        }

        .account-info-form .btn-primary {
            background: #7de3e7;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 13px 0;
            width: 180px;
            margin: 0 auto;
            display: block;
            transition: background 0.2s;
        }

        .account-info-form .btn-primary:hover {
            background: #1ccfcf;
        }

        @media (max-width: 700px) {
            .account-info-wrapper {
                padding: 18px 8px 18px 8px;
                border-radius: 12px;
            }
        }
    </style>
    <div class="account-info-wrapper">
        <div class="account-info-title">Thông tin tài khoản</div>
        <form class="account-info-form" method="POST" action="#">
            @csrf
            <label for="name">Họ và tên</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" disabled>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" disabled>
            <!-- Có thể bổ sung thêm các trường khác như số điện thoại, địa chỉ, ... -->
            <!-- <button type="submit" class="btn-primary">Cập nhật</button> -->
        </form>
    </div>
@endsection
>>>>>>> 79b1bb162aabbc10017718859a748ba1c7c1e357
