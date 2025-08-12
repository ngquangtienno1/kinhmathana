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
            color: #2c3e50;
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

        /* Table Styles */
        .table-section {
            margin-top: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .account-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .account-table th {
            background: #f8f9fa;
            padding: 1.25rem 1rem;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
            border-bottom: 2px solid #e9ecef;
        }

        .account-table td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #f1f3f4;
            color: #495057;
            font-size: 0.95rem;
        }

        .account-table tr:hover {
            background: #f8f9fa;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 100px;
        }

        .status-cancelled_by_customer {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-shipping {
            background: #dbeafe;
            color: #2563eb;
        }

        .status-delivered {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-confirmed {
            background: #e9d5ff;
            color: #7c3aed;
        }

        .status-default {
            background: #f3f4f6;
            color: #6b7280;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
        }

        .btn-action:hover {
            background: #000;
            color: #fff;
            border-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-cancel {
            border-color: #ef4444;
            color: #ef4444;
        }

        .btn-cancel:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        /* No Orders State */
        .no-orders {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
            font-style: italic;
            font-size: 1.1rem;
        }

        /* Pagination */
        .pagination {
            display: flex !important;
            justify-content: center;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 2rem 0 0 0;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            background: #f8f9fa;
            color: #495057;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            min-width: 40px;
            text-align: center;
        }

        .pagination li.active span,
        .pagination li a:hover {
            background: #000;
            color: #fff;
            border-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .pagination li.disabled span {
            color: #9ca3af;
            background: #f3f4f6;
            border-color: #e5e7eb;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            min-width: 400px;
            max-width: 90vw;
            max-height: 90vh;
            overflow: auto;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #000;
        }

        .modal h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
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
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ececec&color=7de3e7&size=90"
                            alt="Avatar">
                    </div>
                    <div class="user-name">{{$user->name}}</div>
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
                            <a href="{{ route('client.users.index') }}" class="nav-link active">
                                <i class="fas fa-shopping-cart"></i>
                                Danh sách đơn hàng
                            </a>
                        </li>
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

            <div class="account-content">
                <div class="page-header">
                    <h1 class="page-title">Danh sách đơn hàng</h1>
                    <p class="page-subtitle">Quản lý đơn hàng và theo dõi lịch sử mua hàng của bạn</p>
                </div>

                <div class="account-stats">
                    <div class="account-stat">
                        <span class="stat-number">{{ $totalOrders }}</span>
                        <div class="stat-label">Tổng số đơn đã đặt</div>
                    </div>
                    <div class="account-stat">
                        <span class="stat-number">{{ number_format($totalSpent, 0, ',', '.') }}₫</span>
                        <div class="stat-label">Tổng tiền đã mua</div>
                    </div>
                </div>

                <div class="table-section">
                    <h3 class="section-title">Sản phẩm đã mua</h3>
                    <table class="account-table">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Tổng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->count() > 0)
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td style="text-align:center;">{{ $order->items_count }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>
                                        <td style="text-align:right;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td>
                                            <div class="action-group">
                                                <a href="#" class="view-order-detail btn-action" data-order='@json($order)'
                                                    title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                @if ($order->status === 'pending')
                                                    <button class="cancel-order-btn btn-action btn-cancel" data-id="{{ $order->id }}"
                                                        title="Hủy đơn">
                                                        <i class="fas fa-times-circle"></i> Hủy
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="no-orders">Chưa có đơn hàng nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{-- PHÂN TRANG --}}
                    @if (method_exists($orders, 'links'))
                        <div style="margin-top:18px;text-align:center;">
                            {{ $orders->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Popup chi tiết đơn hàng -->
    <div id="orderDetailModal" class="modal" style="display:none;">
        <div class="modal-content">
            <button id="closeOrderDetail" class="modal-close">&times;</button>
            <h4>Chi tiết đơn hàng</h4>
            <div id="orderDetailContent">Đang tải...</div>
        </div>
    </div>

    <!-- Popup chọn lý do hủy đơn hàng -->
    <div id="cancelOrderModal" class="modal" style="display:none;">
        <div class="modal-content">
            <button id="closeCancelOrder" class="modal-close">&times;</button>
            <h4>Chọn lý do hủy đơn hàng</h4>
            <div style="margin-bottom:12px;">
                <label for="cancelReasonSelect"><b>Lý do hủy <span style='color:red'>*</span></b></label>
                <select id="cancelReasonSelect" style="width:100%;padding:6px 8px;margin-top:6px;">
                    <option value="">-- Chọn lý do --</option>
                </select>
            </div>
            <div id="otherReasonBox" style="display:none;margin-bottom:12px;">
                <input type="text" id="otherReasonInput" style="width:100%;padding:6px 8px;"
                    placeholder="Nhập lý do hủy mới">
            </div>
            <div style="text-align:right;">
                <button id="cancelCancelOrder" style="margin-right:8px;padding:6px 18px;">Đóng</button>
                <button id="confirmCancelOrder"
                    style="background:#000;color:#fff;padding:6px 18px;border:none;border-radius:4px;">Xác nhận</button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.view-order-detail').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const orderId = JSON.parse(this.getAttribute('data-order')).id;
                document.getElementById('orderDetailContent').innerHTML = 'Đang tải...';
                document.getElementById('orderDetailModal').style.display = 'flex';
                fetch(`/client/order-detail/${orderId}`)
                    .then(res => res.json())
                    .then(order => {
                        let html = `<div style='margin-bottom:10px;'><b>Mã đơn:</b> ${order.order_number}</div>`;
                        html += `<div style='margin-bottom:10px;'><b>Trạng thái:</b> ${order.status_label}</div>`;
                        html += `<div style='margin-bottom:10px;'><b>Trạng thái thanh toán:</b> ${order.payment_status_label}</div>`;
                        html += `<div style='margin-bottom:10px;'><b>Ngày đặt:</b> ${order.created_at}</div>`;
                        html += `<div style='margin-bottom:10px;'><b>Người nhận:</b> ${order.receiver_name} - ${order.receiver_phone} - ${order.receiver_email}</div>`;
                        html += `<div style='margin-bottom:10px;'><b>Địa chỉ nhận:</b> ${order.shipping_address}</div>`;
                        html += `<div style='margin-bottom:10px;'><b>Tổng tiền:</b> ${order.total_amount.toLocaleString('vi-VN')}₫</div>`;
                        html += `<h5 style='margin:16px 0 8px 0;'>Sản phẩm</h5>`;
                        html += `<table style='width:100%;border-collapse:collapse;'>`;
                        html += `<thead><tr><th style='text-align:left;'>Tên sản phẩm</th><th>SKU</th><th>SL</th><th>Giá</th><th>Tổng</th><th>Ảnh</th></tr></thead><tbody>`;
                        order.items.forEach(item => {
                            html += `<tr>`;
                            html += `<td>${item.product_name}</td>`;
                            html += `<td>${item.product_sku}</td>`;
                            html += `<td style='text-align:center;'>${item.quantity}</td>`;
                            html += `<td style='text-align:right;'>${item.price.toLocaleString('vi-VN')}₫</td>`;
                            html += `<td style='text-align:right;'>${item.subtotal.toLocaleString('vi-VN')}₫</td>`;
                            html += `<td>${item.thumbnail ? `<img src='${item.thumbnail}' style='width:40px;height:40px;object-fit:cover;border-radius:4px;'/>` : ''}</td>`;
                            html += `</tr>`;
                        });
                        html += `</tbody></table>`;
                        document.getElementById('orderDetailContent').innerHTML = html;
                    })
                    .catch(() => {
                        document.getElementById('orderDetailContent').innerHTML = '<span style="color:red;">Không lấy được chi tiết đơn hàng.</span>';
                    });
            });
        });

        document.getElementById('closeOrderDetail').onclick = function () {
            document.getElementById('orderDetailModal').style.display = 'none';
        };

        let cancelOrderId = null;

        // Mở popup chọn lý do khi bấm Hủy
        const cancelBtns = document.querySelectorAll('.cancel-order-btn');
        cancelBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                cancelOrderId = this.getAttribute('data-id');
                document.getElementById('cancelReasonSelect').innerHTML = '<option value="">-- Chọn lý do --</option>';
                document.getElementById('otherReasonBox').style.display = 'none';
                document.getElementById('otherReasonInput').value = '';
                document.getElementById('cancelOrderModal').style.display = 'flex';

                // Lấy danh sách lý do
                fetch('/client/order-cancel-reasons')
                    .then(res => res.json())
                    .then(list => {
                        list.forEach(r => {
                            const opt = document.createElement('option');
                            opt.value = r.id;
                            opt.textContent = r.reason;
                            document.getElementById('cancelReasonSelect').appendChild(opt);
                        });

                        // Thêm option khác
                        const opt = document.createElement('option');
                        opt.value = 'other';
                        opt.textContent = '-- Khác (Nhập lý do mới) --';
                        document.getElementById('cancelReasonSelect').appendChild(opt);
                    });
            });
        });

        document.getElementById('cancelReasonSelect').onchange = function () {
            if (this.value === 'other') {
                document.getElementById('otherReasonBox').style.display = 'block';
            } else {
                document.getElementById('otherReasonBox').style.display = 'none';
            }
        };

        document.getElementById('closeCancelOrder').onclick = document.getElementById('cancelCancelOrder').onclick = function () {
            document.getElementById('cancelOrderModal').style.display = 'none';
        };

        document.getElementById('confirmCancelOrder').onclick = function () {
            const select = document.getElementById('cancelReasonSelect');
            let reasonVal = select.value;
            if (!reasonVal) {
                alert('Vui lòng chọn lý do hủy!');
                return;
            }
            if (reasonVal === 'other') {
                const other = document.getElementById('otherReasonInput').value.trim();
                if (!other) {
                    alert('Vui lòng nhập lý do hủy mới!');
                    return;
                }
                reasonVal = 'other:' + other;
            }
            if (!cancelOrderId) return;

            console.log('Sending cancel request:', { orderId: cancelOrderId, reason: reasonVal });

            // Lấy CSRF token
            let csrfToken = '';
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                csrfToken = metaTag.getAttribute('content');
            } else {
                // Fallback: lấy từ input hidden nếu có
                const csrfInput = document.querySelector('input[name="_token"]');
                if (csrfInput) {
                    csrfToken = csrfInput.value;
                }
            }

            fetch(`/client/orders/${cancelOrderId}/cancel`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cancellation_reason_id: reasonVal
                })
            })
                .then(res => {
                    console.log('Response status:', res.status);
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert('Đã gửi yêu cầu hủy đơn hàng!');
                        location.reload();
                    } else {
                        alert(data.message || 'Không thể hủy đơn hàng. Có thể đơn đã được duyệt hoặc đã thay đổi trạng thái.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                });

            document.getElementById('cancelOrderModal').style.display = 'none';
        };

        // Add smooth hover effects for nav items
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.account-menu a');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function () {
                    if (!this.parentElement.classList.contains('active')) {
                        this.style.transform = 'translateX(5px)';
                    }
                });
                link.addEventListener('mouseleave', function () {
                    if (!this.parentElement.classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                    }
                });
            });
        });
    </script>

@endsection