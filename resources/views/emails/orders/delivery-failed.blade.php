<!DOCTYPE html>
<html>
<head>
    <title>[Hana Eyewear] Giao hàng không thành công - Đơn hàng #{{ $order->order_number }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .order-info {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .order-items th, .order-items td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        .order-items th {
            background: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }
        .contact-info {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #e9ecef;
        }
        .signature {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .text-right {
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            background: #dc3545;
            color: white;
            font-size: 14px;
        }
        .alert-box {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .order-items th, .order-items td {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Hana Eyewear" class="logo">
            <h2>Xin chào {{ $order->user->name }},</h2>
            <p>Rất tiếc! Đơn hàng của bạn chưa thể giao thành công.</p>
            <div class="status-badge" style="background: #dc3545;">Giao hàng thất bại</div>
        </div>

        <div class="order-info">
            <h3>📦 Thông tin đơn hàng #{{ $order->order_number }}</h3>
            <p><strong>Thời gian giao hàng:</strong> {{ $order->last_delivery_attempt->format('H:i d/m/Y') }}</p>
            
            <table class="order-items">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th class="text-right">Số lượng</th>
                        <th class="text-right">Đơn giá</th>
                        <th class="text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price) }}đ</td>
                        <td class="text-right">{{ number_format($item->subtotal) }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Tạm tính:</strong></td>
                        <td class="text-right">{{ number_format($order->subtotal) }}đ</td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr>
                        <td colspan="3" class="text-right"><strong>Giảm giá:</strong></td>
                        <td class="text-right">-{{ number_format($order->discount_amount) }}đ</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-right"><strong>Phí vận chuyển:</strong></td>
                        <td class="text-right">{{ number_format($order->shipping_fee) }}đ</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                        <td class="text-right"><strong>{{ number_format($order->total_amount) }}đ</strong></td>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 20px;">
                <h4>📍 Thông tin người mua:</h4>
                <p>
                    <strong>Họ tên:</strong> {{ $order->user->name }}<br>
                    <strong>Email:</strong> {{ $order->user->email }}<br>
                    <strong>Số điện thoại:</strong> {{ $order->user->phone }}<br>
                    <strong>Địa chỉ:</strong> {{ $order->user->address }}
                </p>
            </div>
        </div>

        <div class="next-steps" style="background: #fff3cd; border: 1px solid #ffeeba; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h4>⚠️ Lý do giao hàng thất bại</h4>
            <p>{{ $order->delivery_failure_reason }}</p>
            <h4>👉 Các bước tiếp theo</h4>
            <p>
                1. Chúng tôi sẽ liên hệ lại với bạn để xác nhận thông tin<br>
                2. Đơn hàng sẽ được giao lại trong 1-2 ngày tới<br>
                3. Vui lòng đảm bảo có người nhận hàng theo thông tin ở trên
            </p>
        </div>

        <div class="contact-info">
            <h4>📞 Thông tin liên hệ</h4>
            <p>Nếu bạn có bất kỳ thắc mắc nào về đơn hàng, vui lòng liên hệ với chúng tôi qua:</p>
            <p>
                ☎️ Hotline: 0909.123.456<br>
                📧 Email: support@hanaeyewear.vn<br>
                🌐 Website: <a href="https://hanaeyewear.vn">hanaeyewear.vn</a><br>
                🏪 Cửa hàng: Hà Nội 
            </p>
        </div>

        <div class="signature">
            <p>Trân trọng,</p>
            <p>
                <strong>{{ config('app.name') }}</strong><br>
                <em>Bộ phận giao hàng</em>
            </p>
        </div>

        <div class="footer">
            <p style="color: #6c757d; font-size: 12px;">Email này được gửi tự động, vui lòng không trả lời email này.</p>
        </div>
    </div>
</body>
</html> 