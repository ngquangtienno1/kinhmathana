@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Vận đơn #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, 'DejaVu Sans', sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .label-hana {
            width: 148mm;
            height: 210mm;
            min-height: 210mm;
            margin: 0 auto;
            border: 2px dashed #222;
            background: #fff;
            padding: 0;
            box-sizing: border-box;
            font-size: 12px;
            display: flex;
            flex-direction: column;
        }

        .hana-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px dashed #aaa;
            padding: 8px 8px 4px 8px;
        }

        .hana-header img {
            height: 32px;
        }

        .hana-barcode {
            text-align: right;
        }

        .hana-barcode img {
            height: 32px;
        }

        .hana-row {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            margin-top: 2px;
            font-size: 12px;
        }

        .hana-col-sep {
            border-left: 1.5px dashed #e67e22;
            height: 100%;
            margin: 0 8px;
        }

        .hana-block {
            border-bottom: 1px dashed #aaa;
            padding: 6px 8px 6px 8px;
        }

        .hana-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 8px 0 4px 0;
            letter-spacing: 2px;
        }

        .hana-section-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 2px;
        }

        .hana-info-table {
            width: 100%;
            font-size: 12px;
        }

        .hana-info-table td {
            padding: 1px 2px;
            vertical-align: top;
        }

        .hana-products-list {
            margin: 0;
            padding-left: 16px;
        }

        .hana-products-list li {
            margin-bottom: 2px;
        }

        .hana-qr {
            text-align: right;
        }

        .hana-footer {
            font-size: 11px;
            margin-top: 8px;
            border-top: 1px dashed #aaa;
            padding: 4px 8px 8px 8px;
        }

        .hana-highlight {
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .hana-cod {
            font-size: 16px;
            font-weight: bold;
            color: #e74c3c;
        }

        .hana-warning {
            background: #fff6e5;
            color: #e67e22;
            border: 1px solid #f5c16c;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 11px;
            margin: 6px 8px 0 8px;
        }

        .hana-hotline {
            color: #e74c3c;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            margin-top: 4px;
        }

        .hana-label {
            color: #e67e22;
            font-weight: bold;
            font-size: 13px;
        }

        .hana-barcode-img {
            margin-top: 2px;
        }

        @media print {
            @page {
                size: A5 portrait;
                margin: 0;
            }

            body {
                background: #fff;
                margin: 0;
            }

            .label-hana {
                width: 148mm;
                height: 210mm;
                min-height: 210mm;
                margin: 0;
                box-shadow: none;
                border: 2px dashed #222;
                padding: 0;
            }

            button {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="label-hana">
        <div class="hana-header">
            <img src="{{ getLogoUrl() }}" alt="{{ getSetting('website_name') }}" style="margin-left: 10px;height: 52px;">
            <div class="hana-barcode">
                {{-- Barcode mã vận đơn (dùng Google Chart API, bạn có thể thay bằng package barcode nếu muốn) --}}
                <img class="hana-barcode-img"
                    src="https://barcode.tec-it.com/barcode.ashx?data={{ $order->order_number }}&code=Code128&translate-esc=false"
                    alt="Barcode" />
            </div>
        </div>
        <div class="hana-block hana-row" style="padding-bottom:2px;">
            <div style="width: 49%;">
                <div class="hana-label">Từ:</div>
                <div><strong>{{ $order->user->name }}</strong></div>
                <div>Email: {{ $order->user->email }}</div>
                <div>SDT: {{ $order->user->phone ?? 'Chưa cập nhật' }}</div>
                <div>Địa chỉ: {{ $order->user->address ?? (getSetting('company_address') ?? 'Chưa cập nhật') }}</div>
                <div>MST: {{ getSetting('company_taxcode') }}</div>
            </div>
            <div class="hana-col-sep"></div>
            <div style="width: 49%;">
                <div class="hana-label">Đến:</div>
                <div><strong>{{ $order->receiver_name }}</strong></div>
                <div>Email: {{ $order->receiver_email ?? '---' }}</div>
                <div>SDT: {{ $order->receiver_phone }}</div>
                <div>Địa chỉ: {{ $order->shipping_address }}</div>
            </div>
        </div>
        <div class="hana-block" style="padding: 4px 8px 4px 8px;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>Mã vận đơn: <span class="hana-highlight">{{ $order->order_number }}</span></div>
                <div>Mã đơn hàng: <span class="hana-highlight">{{ $order->order_number }}</span></div>
            </div>
        </div>
        <div class="hana-title" style="margin-bottom:0;">{{ $order->order_number }}</div>
        <div class="hana-block hana-row" style="align-items: flex-start;">
            <div style="width: 65%; border-right: 1.5px dashed #bbb; padding-right: 10px;">
                <div class="hana-section-title">Nội dung hàng (Tổng SL sản phẩm:
                    {{ $order->items->sum('quantity') }})</div>
                <ol class="hana-products-list">
                    @foreach ($order->items as $item)
                        <li>{{ $item->product_name }} ({{ $item->product_sku }}) x {{ $item->quantity }}</li>
                    @endforeach
                </ol>
            </div>
            <div class="hana-qr"
                style="width: 35%; padding-left: 10px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                {!! QrCode::size(80)->generate($order->order_number) !!}
                <div style="font-size:11px;text-align:center;margin-top:2px;">{{ $order->order_number }}</div>
            </div>
        </div>
        <div class="hana-block hana-row">
            <div style="width: 49%;">
                <div>Ngày đặt hàng:</div>
                <div class="hana-highlight">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="hana-col-sep"></div>
            <div style="width: 49%;">
                <div>Khối lượng ước tính:</div>
                <div class="hana-highlight">{{ $order->weight ?? '---' }}g</div>
            </div>
        </div>
        <div class="hana-block hana-row">
            <div style="width: 49%;">
                <div>Tiền thu người nhận:</div>
                <div class="hana-cod">{{ number_format($order->total_amount) }}đ</div>
            </div>
            <div class="hana-col-sep"></div>
            <div style="width: 49%;">
                <div>Ghi chú:</div>
                <div>{{ $order->note ?? '---' }}</div>
            </div>
        </div>
        <div class="hana-warning">
            Kiểm tra sản phẩm và đối chiếu mã vận đơn/Mã đơn hàng trước khi nhận hàng. Lưu ý: Mở kiện hàng khi có sự
            đồng ý của người giao hàng.
        </div>
        <div class="hana-footer">
            <div>Chữ ký người nhận: __________________________</div>
        </div>
        <div class="hana-hotline">
            Tuyến dụng Tài xế/Điều phối kho Hana - Thu nhập 8-20 triệu - Gọi 1900 6677
        </div>
        <button onclick="window.print()"
            style="margin-top:12px;width:100%;font-size:1.1em;padding:8px 0;background:#e67e22;color:#fff;border:none;border-radius:6px;cursor:pointer;">In
            vận đơn</button>
    </div>
</body>

</html>
