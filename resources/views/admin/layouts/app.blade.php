<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Kinh Mắt Hana</title>

    <!-- Theme CSS từ thư mục gốc -->
    <link href="{{ asset('v1/assets/css/theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('v1/assets/css/line.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Additional CSS -->
    @yield('styles')

    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .sidebar a:hover {
            color: white;
        }

        .content {
            padding: 20px;
        }

        .nav-link.active {
            background-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="p-3">
                    <h3 class="text-center">Kinh Mắt Hana</h3>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="/admin">
                                <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
                                href="/admin/products">
                                <i class="fas fa-box"></i> Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
                                href="/admin/categories">
                                <i class="fas fa-list"></i> Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}"
                                href="/admin/orders">
                                <i class="fas fa-shopping-cart"></i> Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/promotions*') ? 'active' : '' }}"
                                href="/admin/promotions">
                                <i class="fas fa-tag"></i> Khuyến mãi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="/admin/users">
                                <i class="fas fa-users"></i> Người dùng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}"
                                href="/admin/settings">
                                <i class="fas fa-cog"></i> Cài đặt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>@yield('title', 'Dashboard')</h2>
                    <div>
                        <span class="me-3">Admin</span>
                        <a href="/logout" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme JS từ thư mục gốc -->
    <script src="{{ asset('v1/assets/js/config.js') }}"></script>
    <script src="{{ asset('v1/assets/js/phoenix.js') }}"></script>

    <!-- Additional Scripts -->
    @yield('scripts')
</body>

</html>
