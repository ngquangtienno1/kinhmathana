@extends('client.layouts.app')

@section('title', 'Thống kê đơn hàng của tôi')
@section('content')
    <style>
        body {
            background: #f8f9fa;
        }
        .dashboard-container {
            display: flex;
            min-height: 80vh;
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            border-radius: 10px;
        }
        .sidebar {
            width: 250px;
            background: #fff;
            border-right: 1px solid #e9ecef;
            padding: 2rem 0 2rem 0;
        }
        .sidebar-nav ul { list-style: none; padding-left: 0; }
        .nav-item { margin-bottom: 0.5rem; }
        .nav-link {
            display: block;
            padding: 1.1rem 2rem;
            color: #111;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
            border-radius: 0 20px 20px 0;
            transition: background 0.2s, color 0.2s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .nav-link:hover {
            background: #f3f3f3;
            color: #111;
            border-left-color: #222;
        }
        .nav-item.active .nav-link, .nav-link.active {
            color: #111;
            background: #f3f3f3;
            border-left-color: #222;
            font-weight: 900;
        }
        .nav-item.special .nav-link {
            color: #111;
            font-weight: 900;
        }
        .main-content { flex: 1; padding: 2.5rem 2rem; }
        .content-wrapper { max-width: 900px; margin: 0 auto; }
        .welcome-section { margin-bottom: 1.5rem; }
        .welcome-text {
            font-size: 1.6rem;
            font-weight: 700;
            color: #232323;
            letter-spacing: 0.1px;
            text-transform: none;
        }
        .welcome-text strong {
            font-weight: 700;
            text-transform: uppercase;
        }
        .logout-link {
            color: #232323;
            text-decoration: underline;
            font-weight: 600;
        }
        .logout-link:hover { text-decoration: underline; }
        .dashboard-description {
            margin-bottom: 2rem;
            color: #666;
            font-size: 1.08rem;
            line-height: 1.7;
            font-weight: 400;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2rem;
            margin-bottom: 2.2rem;
        }
        .action-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            text-align: center;
            padding: 1.3rem 1rem 1.1rem 1rem;
            transition: box-shadow 0.2s;
        }
        .action-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .action-icon {
            font-size: 2.2rem;
            margin-bottom: 0.7rem;
            color: #232323;
        }
        .action-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #232323;
            font-size: 1.13rem;
            letter-spacing: 0.1px;
            text-transform: none;
        }
        .action-desc {
            font-size: 1rem;
            color: #888;
            font-weight: 400;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 1.7rem 1rem 1.3rem 1rem;
            transition: box-shadow 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .stat-number {
            font-size: 1.3rem;
            font-weight: 600;
            color: #232323;
            margin-bottom: 0.3rem;
            letter-spacing: 0.5px;
            text-transform: none;
        }
        .stat-label {
            font-size: 1.05rem;
            color: #888;
            text-transform: none;
            letter-spacing: 0.1px;
            font-weight: 400;
        }
        .recent-section { margin-top: 2.5rem; }
        .recent-section h3 {
            font-size: 1.18rem;
            margin-bottom: 1.2rem;
            color: #232323;
            font-weight: 700;
            letter-spacing: 0.1px;
            text-transform: none;
        }
        .orders-table { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .orders-table table { width: 100%; border-collapse: collapse; }
        .orders-table th, .orders-table td { padding: 0.9rem 1rem; text-align: left; border-bottom: 1px solid #e9ecef; }
        .orders-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #232323;
            font-size: 1.05rem;
            text-transform: none;
            letter-spacing: 0.1px;
        }
        .orders-table td {
            color: #232323;
            font-size: 1.05rem;
            font-weight: 400;
        }
        .orders-table tr:hover { background-color: #f3f3f3; }
        .status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: none;
            background: #ededed;
            color: #232323;
        }
        .status-completed, .status-pending, .status-processing {
            background-color: #ededed;
            color: #232323;
        }
        .btn-view {
            color: #232323;
            text-decoration: underline;
            font-weight: 600;
            font-size: 1.05rem;
        }
        .btn-view:hover { text-decoration: underline; }
        .no-orders {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 2rem;
            font-weight: 400;
        }
        @media (max-width: 900px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid #e9ecef; padding: 1rem 0; }
            .sidebar-nav ul { display: flex; overflow-x: auto; padding: 0 1rem; }
            .nav-item { margin-bottom: 0; margin-right: 0.5rem; white-space: nowrap; }
            .nav-link { padding: 0.75rem 1rem; border-left: none; border-bottom: 3px solid transparent; border-radius: 0; }
            .nav-link:hover, .nav-item.active .nav-link { border-left: none; border-bottom-color: #222; }
            .main-content { padding: 1rem; }
            .stats-grid { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; }
            .stat-card { padding: 1.2rem; }
            .stat-number { font-size: 1.5rem; }
            .orders-table { overflow-x: auto; }
            .orders-table table { min-width: 600px; }
        }
    </style>

    <div class="dashboard-container" style="margin-top: 50px; margin-bottom: 50px; ">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item active">
                        <a href="#" class="nav-link">BẢNG ĐIỀU KHIỂN</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">ĐƠN HÀNG</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">TẢI VỀ</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">ĐỊA CHỈ</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">THÔNG TIN TÀI KHOẢN</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">ĐĂNG XUẤT</a>
                    </li>
                    <li class="nav-item special">
                        <a href="#" class="nav-link">THỐNG KÊ ĐƠN HÀNG</a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="content-wrapper">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h2 class="welcome-text">
                        Xin chào <strong>{{ strtoupper(Auth::user() ? Auth::user()->name : 'Khách') }}</strong> (không phải bạn? <a href="#" class="logout-link">Đăng xuất</a>)
                    </h2>
                </div>
                <!-- Description -->
                <div class="dashboard-description">
                    <p>
                        Từ bảng điều khiển tài khoản, bạn có thể xem đơn hàng gần đây, quản lý địa chỉ giao hàng và thanh toán, thay đổi mật khẩu và thông tin tài khoản.
                    </p>
                </div>
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="action-card">
                        <div class="action-icon"><i class="fas fa-box"></i></div>
                        <div class="action-title">Xem đơn hàng</div>
                        <div class="action-desc">Kiểm tra lịch sử và trạng thái đơn hàng</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="action-title">Quản lý địa chỉ</div>
                        <div class="action-desc">Cập nhật địa chỉ giao hàng và thanh toán</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon"><i class="fas fa-user"></i></div>
                        <div class="action-title">Thông tin tài khoản</div>
                        <div class="action-desc">Chỉnh sửa hồ sơ và mật khẩu</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon"><i class="fas fa-save"></i></div>
                        <div class="action-title">Tải về</div>
                        <div class="action-desc">Truy cập các sản phẩm kỹ thuật số</div>
                    </div>
                </div>
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                        <div class="stat-label">Tổng đơn hàng</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
                        <div class="stat-label">Đơn chờ xử lý</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ isset($totalSpent) ? number_format($totalSpent, 0, ',', '.') . '₫' : '0₫' }}</div>
                        <div class="stat-label">Tổng chi tiêu</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $downloads ?? 0 }}</div>
                        <div class="stat-label">Tải về</div>
                    </div>
                </div>
                <!-- Recent Orders Section -->
                <div class="recent-section">
                    <h3>Đơn hàng gần đây</h3>
                    <div class="orders-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Ngày</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentOrders) && count($recentOrders))
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="status status-{{ $order->status }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                                            <td><a href="{{ route('client.orders.show', $order->id) }}" class="btn-view">Xem</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="no-orders">Chưa có đơn hàng nào gần đây.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
