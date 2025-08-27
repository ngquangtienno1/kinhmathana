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

        /* Sidebar Styles - Same as page 1 */
        .account-sidebar {
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
            margin-bottom: 1rem;
        }

        .account-divider {
            height: 1px;
            background: #e9ecef;
            margin: 2rem 0;
        }

        .account-menu {
            list-style: none;
        }

        .account-menu li {
            margin-bottom: 0.5rem;
        }

        .account-menu li a {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: #6c757d;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .account-menu li a:hover {
            background: #f8f9fa;
            color: #495057;
            transform: translateX(5px);
        }

        .account-menu li.active a {
            background: #000;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .account-menu li .icon {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .account-content {
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
            color: #000;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Stats Cards */
        .account-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .account-stat {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .account-stat:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-label {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 500;
        }













        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-menu {
            list-style: none;
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



        /* Responsive Design */
        @media (max-width: 1024px) {
            .account-wrapper {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .account-sidebar {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .account-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .account-table {
                font-size: 0.875rem;
            }

            .account-table th,
            .account-table td {
                padding: 0.75rem 0.5rem;
            }

            .action-group {
                flex-direction: column;
                gap: 0.25rem;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="container">
        <div class="account-wrapper">
            <div class="account-sidebar">
                <div class="user-profile">
                    <div class="account-avatar">
                        @php
                            $avatarSrc = null;
                            if(!empty($user->avatar)){
                                $a = $user->avatar;
                                if(stripos($a, 'http://') === 0 || stripos($a, 'https://') === 0){
                                    $avatarSrc = $a;
                                } elseif(strpos($a, 'uploads/avatars') !== false || strpos($a, 'uploads\\avatars') !== false){
                                    $avatarSrc = asset($a);
                                } else {
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

                <div class="account-divider"></div>

                <nav>
                    <ul class="nav-menu">
                        
                        <li class="nav-item">
                            <a href="{{ route('client.users.information') }}" class="nav-link ">
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

            
        </div>
    </div>



    <script>
        // Add smooth hover effects for nav items
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-menu a');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    if (!this.parentElement.classList.contains('active')) {
                        this.style.transform = 'translateX(5px)';
                    }
                });
                link.addEventListener('mouseleave', function() {
                    if (!this.parentElement.classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                    }
                });
            });
        });
    </script>

@endsection
