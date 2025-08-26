@extends('client.layouts.app')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .account-wrapper {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
            min-height: calc(100vh - 4rem);
        }

        /* Sidebar Styles */
        .sidebar {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .user-profile {
            text-align: center;
            margin-bottom: 2rem;
        }

        .avatar-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            border: 4px solid #f8f9fa;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.05);
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .avatar-container:hover .avatar-overlay {
            opacity: 1;
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .user-status {
            background: #f8f9fa;
            color: #6c757d;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            display: inline-block;
        }

        .divider {
            height: 1px;
            background: #e9ecef;
            margin: 2rem 0;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: #6c757d;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: #f8f9fa;
            color: #495057;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: #000;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            margin-bottom: 2.5rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Avatar Upload Section */
        .avatar-upload-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .upload-avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .upload-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.10);
            border: 6px solid #fff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .avatar-upload-btn {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: #000;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            opacity: 0.85;
            transition: opacity 0.2s;
        }

        .profile-avatar-wrapper:hover .avatar-upload-btn {
            opacity: 1;
        }

        .avatar-upload-btn input[type="file"] {
            display: none;
        }

        .upload-btn {
            background: #000;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .upload-btn:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 4px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required {
            color: #e74c3c;
        }

        .input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e9ecef !important;
            border-radius: 12px !important;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
            box-sizing: border-box;
            margin-bottom: 2px;
        }

        .form-input:focus {
            outline: none;
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
        }

        .password-btn {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            color: #6c757d;
        }

        .password-btn:hover {
            border-color: #000;
            background: #f8f9fa;
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-cancel {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-cancel:hover {
            background: #e9ecef;
            color: #495057;
        }

        .btn-save {
            background: #000;
            color: #fff;
            min-width: 150px;
        }

        .btn-save:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .account-wrapper {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .sidebar {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .page-title {
                font-size: 2rem;
            }
        }

        .account-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            border: 4px solid #f8f9fa;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
            margin: 0 auto 1rem;
        }

        .account-avatar:hover {
            transform: scale(1.05);
        }

        .account-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
    <div class="container">
        <div class="account-wrapper">

            <div class="sidebar">
                <div class="user-profile">
                     <div class="account-avatar">
                        @php
                            $avatarSrc = null;
                            if(!empty($user->avatar)){
                                $a = $user->avatar;
                                // full URL provided by storage or external
                                if(stripos($a, 'http://') === 0 || stripos($a, 'https://') === 0){
                                    $avatarSrc = $a;
                                } elseif(strpos($a, 'uploads/avatars') !== false || strpos($a, 'uploads\\avatars') !== false){
                                    // already contains the uploads path
                                    $avatarSrc = asset($a);
                                } else {
                                    // plain filename
                                    $avatarSrc = asset('uploads/avatars/' . $a);
                                }
                            }
                        @endphp
                        <img src="{{ $avatarSrc ?? ('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ececec&color=7de3e7&size=90') }}" alt="Avatar">
                    </div>
                    <div class="user-name">{{ $user->name }}</div>
                    @if (isset($customerType))
                        <div class="user-status">
                            @if ($customerType === 'vip')
                                Khách hàng VIP
                            @elseif($customerType === 'potential')
                                Khách hàng tiềm năng
                            @else
                                Khách hàng thường
                            @endif
                        </div>
                    @endif
                </div>

                <div class="divider"></div>

                <nav>
                    <ul class="nav-menu">
                      
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="fas fa-user"></i>
                                Thông tin tài khoản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.orders.index') }}" class="nav-link">
                                <i class="fas fa-box"></i>
                                Đơn hàng của tôi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.logout') }}" class="nav-link">
                                <i class="fas fa-sign-out-alt"></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>


            <div class="main-content">
                <div class="page-header">
                    <h1 class="page-title">Thông tin tài khoản</h1>
                    <p class="page-subtitle">Cập nhật thông tin cá nhân và cài đặt tài khoản của bạn</p>
                </div>

                <form method="POST" action="{{ route('client.users.information.update') }}" enctype="multipart/form-data">
                    @csrf


                    @if (session('success1'))
                        <div id="toast-success" class="toast-custom toast-success toast-animate">
                            <span class="toast-icon">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#388e3c"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" fill="#e8f5e9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12.5l2.5 2.5 5-5" />
                                </svg>
                            </span>
                            <span class="toast-content">{{ session('success1') }}</span>
                            <span class="toast-close"
                                onclick="document.getElementById('toast-success').remove()">&times;</span>
                        </div>
                        <script>
                            setTimeout(function() {
                                var el = document.getElementById('toast-success');
                                if (el) el.style.opacity = 0;
                            }, 3500);
                            setTimeout(function() {
                                var el = document.getElementById('toast-success');
                                if (el) el.remove();
                            }, 4000);
                        </script>
                    @endif

                    @if ($errors->any())
                        <div id="toast-error" class="toast-custom toast-error toast-animate">
                            <span class="toast-icon">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#d32f2f"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" fill="#ffebee" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6" />
                                </svg>
                            </span>
                            <span class="toast-content">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </span>
                            <span class="toast-close"
                                onclick="document.getElementById('toast-error').remove()">&times;</span>
                        </div>
                        <script>
                            setTimeout(function() {
                                var el = document.getElementById('toast-error');
                                if (el) el.style.opacity = 0;
                            }, 3500);
                            setTimeout(function() {
                                var el = document.getElementById('toast-error');
                                if (el) el.remove();
                            }, 4000);
                        </script>
                    @endif
                    <style>
                        .toast-animate {
                            opacity: 0;
                            transform: translateY(-30px) scale(0.98);
                            animation: toastIn 0.5s cubic-bezier(.4, 0, .2, 1) forwards;
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
                            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.12);
                            opacity: 1;
                            transition: opacity 0.5s;
                            letter-spacing: 0.2px;
                            border-bottom: 4px solid;
                            border-radius: 10px;
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
                    <div class="avatar-upload-section">
                        <div class="upload-avatar-container" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.5rem;">
                            <div class="profile-avatar-wrapper" style="position:relative;display:inline-block;">
                                @php
                                    // reuse logic for preview image
                                    $previewSrc = null;
                                    if(!empty($user->avatar)){
                                        $a2 = $user->avatar;
                                        if(stripos($a2, 'http://') === 0 || stripos($a2, 'https://') === 0){
                                            $previewSrc = $a2;
                                        } elseif(strpos($a2, 'uploads/avatars') !== false || strpos($a2, 'uploads\\avatars') !== false){
                                            $previewSrc = asset($a2);
                                        } else {
                                            $previewSrc = asset('uploads/avatars/' . $a2);
                                        }
                                    }
                                @endphp
                                <img class="upload-avatar" src="{{ $previewSrc ?? ('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ececec&color=7de3e7&size=120') }}" alt="Avatar" style="width:120px;height:120px;border-radius:50%;object-fit:cover;box-shadow:0 8px 25px rgba(0,0,0,0.10);border:6px solid #fff;">
                                <label for="avatarInput" class="avatar-upload-btn" style="position:absolute;bottom:8px;right:8px;background:#000;width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.12);opacity:0.85;transition:opacity 0.2s;">
                                    <input id="avatarInput" type="file" name="avatar" accept="image/*" style="display:none;">
                                    <i class="fas fa-camera" style="color:#fff;font-size:1.2rem;"></i>
                                </label>
                            </div>
                            <div id="avatarFileName" style="font-size:0.9rem;color:#6c757d;display:none;">Chưa chọn file</div>
                        </div>
                        <p style="color: #6c757d; margin-bottom: 1rem;">Ảnh đại diện</p>
                        <button type="button" class="upload-btn" onclick="document.getElementById('avatarInput').click();"
                            style="margin-top:0.5rem;">
                            <i class="fas fa-camera"></i>
                            Thay đổi ảnh
                        </button>
                    </div>


                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Tên hiển thị <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="name" name="name" class="form-input"
                                    placeholder="Nhập tên hiển thị" value="{{ $user->name ?? $user->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Địa chỉ email <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" id="email" name="email" class="form-input"
                                    placeholder="Nhập địa chỉ email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                Số điện thoại <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text" id="phone" name="phone" class="form-input"
                                    placeholder="Nhập số điện thoại" value="{{ $user->phone ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">
                                Địa chỉ
                            </label>
                            <div class="input-container">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" id="address" name="address" class="form-input"
                                    placeholder="Nhập địa chỉ" value="{{ $user->address ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mật khẩu</label>
                            <div class="input-container">
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="password-btn" onclick="openChangePasswordModal()">
                                    Đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" id="btnCancelInfo">
                            <i class="fas fa-times"></i>
                            Hủy
                        </button>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save"></i>
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth hover effects for nav items
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateX(5px)';
                    }
                });
                link.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                    }
                });
            });

            // Form input focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Nút Hủy: reset form về giá trị ban đầu (hoặc reload lại trang)
            document.getElementById('btnCancelInfo').addEventListener('click', function(e) {
                e.preventDefault();
                // Nếu modal đổi mật khẩu đang mở thì đóng modal, ngược lại reset form
                var modal = document.getElementById('changePasswordModal');
                if (modal && modal.style.display === 'flex') {
                    modal.style.display = 'none';
                } else {
                    // Reset form về giá trị ban đầu bằng reload lại trang
                    window.location.reload();
                }
            });
        });
    </script>
    <script>
        // Avatar preview and filename display
        (function(){
            var input = document.getElementById('avatarInput');
            var img = document.querySelector('.upload-avatar');
            var nameEl = document.getElementById('avatarFileName');
            if(!input) return;
            input.addEventListener('change', function(e){
                var file = this.files && this.files[0];
                if(!file) {
                    nameEl.style.display = 'none';
                    return;
                }
                // show filename
                nameEl.textContent = file.name;
                nameEl.style.display = 'block';
                // preview
                var reader = new FileReader();
                reader.onload = function(ev){
                    img.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            });
        })();
    </script>
@include('client.users.change_password_popup')
@endsection
