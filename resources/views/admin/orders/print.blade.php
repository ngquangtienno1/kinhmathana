<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>In đơn hàng #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .print-container {
            background: #fff;
            max-width: 800px;
            margin: 30px auto;
            padding: 32px 40px 40px 40px;
            border-radius: 12px;
            box-shadow: 0 0 16px rgba(0, 0, 0, 0.12);
            border: 1px solid #e0e0e0;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 8px;
        }

        .order-title {
            font-size: 2.1em;
            font-weight: bold;
            color: #2d8cf0;
            margin-bottom: 0;
        }

        .order-meta {
            color: #888;
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 1.15em;
            font-weight: bold;
            color: #2d8cf0;
            margin-top: 24px;
            margin-bottom: 8px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .info-table td {
            padding: 2px 0;
        }

        table.product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        table.product-table th,
        table.product-table td {
            border: 1px solid #bfc9d1;
            padding: 8px 6px;
            font-size: 1em;
        }

        table.product-table th {
            background: #eaf4ff;
            color: #2d8cf0;
            font-weight: bold;
        }

        table.product-table td {
            background: #fff;
        }

        .summary {
            margin-top: 18px;
            font-size: 1.1em;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .summary-row.total {
            font-size: 1.25em;
            font-weight: bold;
            color: #e74c3c;
            border-top: 2px solid #2d8cf0;
            padding-top: 8px;
            margin-top: 10px;
        }

        .note {
            margin-top: 18px;
            font-style: italic;
            color: #666;
        }

        @media print {
            body {
                background: #fff;
                margin: 0;
            }

            .print-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0 16mm;
                max-width: 210mm;
                page-break-after: avoid;
                page-break-inside: avoid;
            }

            button {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="print-container">
        <div class="header">
            {{-- Logo nếu có --}}
            <img src="{{ asset('logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            <div class="order-title">ĐƠN HÀNG #{{ $order->order_number }}</div>
            <div class="order-meta">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="section-title">Thông tin khách hàng</div>
        <table class="info-table">
            <tr>
                <td><strong>Họ tên:</strong></td>
                <td>{{ $order->user->name }}</td>
                <td><strong>Email:</strong></td>
                <td>{{ $order->user->email }}</td>
            </tr>
            <tr>
                <td><strong>Điện thoại:</strong></td>
                <td>{{ $order->user->phone ?? 'Chưa cập nhật' }}</td>
                <td><strong>Địa chỉ:</strong></td>
                <td>{{ $order->user->address ?? 'Chưa cập nhật' }}</td>
            </tr>
        </table>

        <div class="section-title">Thông tin người nhận</div>
        <table class="info-table">
            <tr>
                <td><strong>Họ tên:</strong></td>
                <td>{{ $order->receiver_name }}</td>
                <td><strong>Email:</strong></td>
                <td>{{ $order->receiver_email }}</td>
            </tr>
            <tr>
                <td><strong>Điện thoại:</strong></td>
                <td>{{ $order->receiver_phone }}</td>
                <td><strong>Địa chỉ:</strong></td>
                <td>{{ $order->shipping_address }}</td>
            </tr>
        </table>

        <div class="section-title">Danh sách sản phẩm</div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>SKU</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->product_sku }}</td>
                        <td>{{ number_format($item->price) }}đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal) }}đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span>Tổng tiền hàng:</span>
                <span>{{ number_format($order->subtotal) }}đ</span>
            </div>
            @if ($order->promotion_amount > 0)
                <div class="summary-row">
                    <span>Giảm giá khuyến mãi:</span>
                    <span>-{{ number_format($order->promotion_amount) }}đ</span>
                </div>
            @endif
            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span>{{ number_format($order->shipping_fee) }}đ</span>
            </div>
            <div class="summary-row total">
                <span>Tổng thanh toán:</span>
                <span>{{ number_format($order->total_amount) }}đ</span>
            </div>
        </div>

        @if ($order->note)
            <div class="note">
                <strong>Ghi chú:</strong> {{ $order->note }}
            </div>
        @endif

        <button onclick="window.print()"
            style="margin-top:32px;display:block;width:100%;font-size:1.1em;padding:10px 0;background:#2d8cf0;color:#fff;border:none;border-radius:6px;cursor:pointer;">
            In đơn hàng
        </button>
    </div>
</body>

</html>
