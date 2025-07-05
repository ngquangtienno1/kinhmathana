@extends('client.layouts.app')

@section('content')
<style>
.account-wrapper {
    display: flex;
    gap: 32px;
    max-width: 1200px;
    margin: 40px auto 60px auto;
}
.account-sidebar {
    flex: 0 0 320px;
    background: #fff;
    border-radius: 20px;
    padding: 36px 24px 32px 24px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.account-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #f2f2f2;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.account-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.account-menu {
    width: 100%;
    margin-top: 18px;
}
.account-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.account-menu li {
    margin-bottom: 16px;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.account-menu li.active a, .account-menu li a:hover {
    color: #1ccfcf;
    font-weight: 700;
}
.account-menu li a {
    color: #222;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.account-menu li .icon {
    font-size: 1.2rem;
}
.account-divider {
    width: 100%;
    height: 1px;
    background: #eee;
    margin: 18px 0 18px 0;
}
.account-content {
    flex: 1 1 0%;
    background: #fff;
    border-radius: 20px;
    padding: 36px 32px 32px 32px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.04);
}
.account-stats {
    display: flex;
    gap: 32px;
    margin-bottom: 28px;
}
.account-stat {
    flex: 1 1 0%;
    background: #f7fafd;
    border-radius: 16px;
    padding: 18px 0 12px 0;
    text-align: center;
    box-shadow: 0 1px 6px rgba(0,0,0,0.03);
}
.account-stat .icon {
    display: block;
    margin: 0 auto 6px auto;
    font-size: 2.1rem;
    color: #8ed7d7;
}
.account-stat .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1ccfcf;
}
.account-stat .stat-label {
    font-size: 1.08rem;
    color: #555;
}
.account-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 18px;
}
.account-table th, .account-table td {
    padding: 12px 8px;
    text-align: left;
    font-size: 1.08rem;
}
.account-table th {
    color: #333;
    font-weight: 700;
    border-bottom: 2px solid #eee;
}
.account-table td {
    color: #222;
    border-bottom: 1px solid #f3f3f3;
}
@media (max-width: 900px) {
    .account-wrapper {
        flex-direction: column;
        gap: 18px;
    }
    .account-sidebar, .account-content {
        max-width: 100%;
        border-radius: 12px;
        padding: 18px 8px 18px 8px;
    }
    .account-content {
        padding: 18px 8px 18px 8px;
    }
}
</style>
<div class="account-wrapper">
    <div class="account-sidebar">
        <div class="account-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ececec&color=7de3e7&size=90" alt="Avatar">
        </div>
        @if(isset($customerType))
            <div style="margin-bottom: 10px; color: #1ccfcf; font-weight: bold; font-size: 1.08rem;">
                @if($customerType === 'vip')
                    Khách hàng VIP
                @elseif($customerType === 'potential')
                    Khách hàng tiềm năng
                @else
                    Khách hàng thường
                @endif
            </div>
        @endif
        <div class="account-divider"></div>
        <nav class="account-menu">
            <ul>
                <li class="active"><span class="icon">&#128179;</span> <a href="#">Danh sách sản phẩm</a></li>
                <li><span class="icon">&#128100;</span> <a href="#">Thông tin tài khoản</a></li>
                <li><span class="icon">&#128205;</span> <a href="#">Thông tin địa chỉ</a></li>
                <li><span class="icon">&#128682;</span> <a href="{{ route('client.logout') }}">Đăng xuất</a></li>
            </ul>
        </nav>
    </div>
    <div class="account-content">
        <div class="account-stats">
            <div class="account-stat">
                <span class="icon">&#128722;</span>
                <span class="stat-number">{{ $totalOrders }}</span>
                <div class="stat-label">Tổng số đơn đã đặt</div>
            </div>
            <div class="account-stat">
                <span class="icon">&#128176;</span>
                <span class="stat-number">{{ number_format($totalSpent, 0, ',', '.') }}₫</span>
                <div class="stat-label">Tổng tiền đã mua</div>
            </div>
        </div>
        <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:18px;">Sản phẩm đã mua</h3>
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
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->items_count }}</td>
                            <td>{{ $order->status_label }}</td>
                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                            <td>
                                <a href="#" class="view-order-detail" data-order='@json($order)' style="color:#1ccfcf;font-weight:500;">Xem</a>
                                @if($order->status === 'pending')
                                    <button class="cancel-order-btn" data-id="{{ $order->id }}" style="margin-left:8px;color:#e74c3c;background:none;border:none;cursor:pointer;">Hủy</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align:center;color:#aaa;">Chưa có đơn hàng nào</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <!-- Popup chi tiết đơn hàng -->
        <div id="orderDetailModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
            <div style="background:#fff;padding:32px 24px;border-radius:12px;min-width:340px;max-width:95vw;max-height:90vh;overflow:auto;position:relative;">
                <button id="closeOrderDetail" style="position:absolute;top:8px;right:12px;font-size:1.3rem;background:none;border:none;cursor:pointer;">&times;</button>
                <h4 style="margin-bottom:18px;">Chi tiết đơn hàng</h4>
                <div id="orderDetailContent">Đang tải...</div>
            </div>
        </div>
        <!-- Popup chọn lý do hủy đơn hàng -->
        <div id="cancelOrderModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
            <div style="background:#fff;padding:32px 24px;border-radius:12px;min-width:340px;max-width:95vw;max-height:90vh;overflow:auto;position:relative;">
                <button id="closeCancelOrder" style="position:absolute;top:8px;right:12px;font-size:1.3rem;background:none;border:none;cursor:pointer;">&times;</button>
                <h4 style="margin-bottom:18px;">Chọn lý do hủy đơn hàng</h4>
                <div style="margin-bottom:12px;">
                    <label for="cancelReasonSelect"><b>Lý do hủy <span style='color:red'>*</span></b></label>
                    <select id="cancelReasonSelect" style="width:100%;padding:6px 8px;margin-top:6px;">
                        <option value="">-- Chọn lý do --</option>
                    </select>
                </div>
                <div id="otherReasonBox" style="display:none;margin-bottom:12px;">
                    <input type="text" id="otherReasonInput" style="width:100%;padding:6px 8px;" placeholder="Nhập lý do hủy mới">
                </div>
                <div style="text-align:right;">
                    <button id="cancelCancelOrder" style="margin-right:8px;padding:6px 18px;">Đóng</button>
                    <button id="confirmCancelOrder" style="background:#1ccfcf;color:#fff;padding:6px 18px;border:none;border-radius:4px;">Xác nhận</button>
                </div>
            </div>
        </div>
        <script>
        document.querySelectorAll('.view-order-detail').forEach(btn => {
            btn.addEventListener('click', function(e) {
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
        document.getElementById('closeOrderDetail').onclick = function() {
            document.getElementById('orderDetailModal').style.display = 'none';
        };
        let cancelOrderId = null;
        // Mở popup chọn lý do khi bấm Hủy
        const cancelBtns = document.querySelectorAll('.cancel-order-btn');
        cancelBtns.forEach(btn => {
            btn.addEventListener('click', function() {
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
        document.getElementById('cancelReasonSelect').onchange = function() {
            if(this.value === 'other') {
                document.getElementById('otherReasonBox').style.display = 'block';
            } else {
                document.getElementById('otherReasonBox').style.display = 'none';
            }
        };
        document.getElementById('closeCancelOrder').onclick = document.getElementById('cancelCancelOrder').onclick = function() {
            document.getElementById('cancelOrderModal').style.display = 'none';
        };
        document.getElementById('confirmCancelOrder').onclick = function() {
            const select = document.getElementById('cancelReasonSelect');
            let reasonVal = select.value;
            if(!reasonVal) {
                alert('Vui lòng chọn lý do hủy!');
                return;
            }
            if(reasonVal === 'other') {
                const other = document.getElementById('otherReasonInput').value.trim();
                if(!other) {
                    alert('Vui lòng nhập lý do hủy mới!');
                    return;
                }
                reasonVal = 'other:' + other;
            }
            if(!cancelOrderId) return;
            fetch(`/orders/${cancelOrderId}/cancel`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cancellation_reason_id: reasonVal })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Đã gửi yêu cầu hủy đơn hàng!');
                    location.reload();
                } else {
                    alert(data.message || 'Không thể hủy đơn hàng. Có thể đơn đã được duyệt hoặc đã thay đổi trạng thái.');
                }
            })
            .catch(() => alert('Có lỗi xảy ra, vui lòng thử lại.'));
            document.getElementById('cancelOrderModal').style.display = 'none';
        };
        </script>
    </div>
</div>
@endsection
