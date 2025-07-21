@extends('client.layouts.app')
@section('title', 'Thanh toán đơn hàng')
@section('content')
    <div
        class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid">
                <h1 class="qodef-m-title entry-title">
                    Thanh toán </h1>
                <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                        href="../index.html"><span itemprop="title">Trang chủ</span></a><span
                        class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                        class="qodef-breadcrumbs-current">Thanh toán</span></div>
            </div>
        </div>
    </div>
    <div class="checkout-page-wrapper">

        <div class="checkout-main-flex">

            <!-- Left: Customer Form -->
            <div class="checkout-form-col">

                @if (session('success'))
                    <div class="alert alert-success"
                        style="margin-bottom: 16px; padding: 12px 16px; background: #e8f8f5; color: #148f77; border: 1.5px solid #1abc9c; border-radius: 6px;">
                        {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger"
                        style="margin-bottom: 16px; padding: 12px 16px; background: #ffeaea; color: #c0392b; border: 1.5px solid #e74c3c; border-radius: 6px;">
                        {{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger"
                        style="margin-bottom: 16px; padding: 12px 16px; background: #ffeaea; color: #c0392b; border: 1.5px solid #e74c3c; border-radius: 6px;">
                        <ul style="margin-bottom:0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form name="checkout" method="post" class="checkout-form" action="{{ route('client.cart.checkout') }}"
                    enctype="multipart/form-data" novalidate="novalidate" id="checkout-form">
                    @csrf
                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size:1.2rem; font-weight:600; margin-bottom:12px;">Thông tin người nhận</h3>
                        <div class="checkout-form-group">
                            <label for="receiver_name">Họ và tên người nhận <span class="required">*</span></label>
                            <input type="text" class="checkout-input" name="receiver_name" id="receiver_name"
                                placeholder="Họ và tên người nhận"
                                value="{{ old('receiver_name', auth()->user()->name ?? '') }}">
                        </div>
                        <div class="checkout-form-group">
                            <label for="receiver_phone">Số điện thoại người nhận <span class="required">*</span></label>
                            <input type="text" class="checkout-input" name="receiver_phone" id="receiver_phone"
                                placeholder="Số điện thoại người nhận"
                                value="{{ old('receiver_phone', auth()->user()->phone ?? '') }}">
                        </div>
                        <div class="checkout-form-group">
                            <label for="receiver_email">Email người nhận <span class="required">*</span></label>
                            <input type="email" class="checkout-input" name="receiver_email" id="receiver_email"
                                placeholder="Email người nhận"
                                value="{{ old('receiver_email', auth()->user()->email ?? '') }}">
                        </div>
                        <div class="checkout-form-group">
                            <label for="address">Địa chỉ chi tiết <span class="required">*</span></label>
                            <input type="text" class="checkout-input" name="address" id="address"
                                placeholder="Địa chỉ chi tiết" value="{{ old('address', auth()->user()->address ?? '') }}">
                        </div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="note">Thông tin bổ sung :</label>
                        <textarea name="note" class="checkout-input" id="note" placeholder="Thông tin bổ sung" rows="3">{{ old('note') }}</textarea>
                    </div>
                    <div class="checkout-form-group">
                        <label class="checkout-label">Phương thức thanh toán</label>
                        <div class="checkout-radio-group">
                            @foreach ($paymentMethods as $method)
                                <label class="checkout-radio">
                                    <input type="radio" name="payment_method" value="{{ $method->code }}"
                                        {{ $loop->first ? 'checked' : '' }}>
                                    @if ($method->logo)
                                        <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}"
                                            style="height: 20px; margin-right: 6px;">
                                    @endif
                                    <span>{{ $method->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="checkout-form-group">
                        <label class="checkout-label">Phương thức vận chuyển</label>
                        <div class="checkout-radio-group">
                            @foreach ($shippingProviders as $provider)
                                <label class="checkout-radio"
                                    style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px; font-size: 1rem; font-weight: 400; padding: 2px 0;">
                                    <input type="radio" name="shipping_method" value="{{ $provider->code }}"
                                        data-fee="{{ $provider->shippingFees->count() > 0 ? $provider->shippingFees->first()->base_fee : 30000 }}"
                                        {{ $loop->first ? 'checked' : '' }} style="margin-right: 6px;">
                                    @if ($provider->logo)
                                        <img src="{{ asset('storage/' . $provider->logo) }}" alt="{{ $provider->name }}"
                                            style="height: 20px; margin-right: 6px;">
                                    @endif
                                    <span>{{ $provider->name }}</span>
                                    <span
                                        style="color:#26b6c6; font-weight:600; margin-left:6px; min-width:70px; display:inline-block;">
                                        @if ($provider->shippingFees->count() > 0)
                                            {{ number_format($provider->shippingFees->first()->base_fee, 0, ',', '.') }}đ
                                        @else
                                            30.000đ
                                        @endif
                                    </span>
                                    @if ($provider->code === 'GHN')
                                        <span
                                            style="background:#ffe082; color:#b26a00; border-radius:4px; padding:2px 6px; font-size:12px; margin-left:8px;">Phổ
                                            biến</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="checkout-form-group">
                        <button type="submit" class="checkout-btn" id="checkout-btn">Đặt hàng</button>
                        <button type="button" id="momo-btn" class="checkout-btn"
                            style="background:#a50064;display:none;margin-top:10px;">Thanh toán MoMo</button>
                    </div>
                    <div class="checkout-privacy">
                        Thông tin cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng và cho các mục đích cụ thể khác đã được
                        mô tả trong chính sách riêng tư của chúng tôi.
                    </div>
                    <input type="hidden" name="applied_voucher" id="applied_voucher_hidden" value="">
                </form>
            </div>
            <!-- Right: Order Summary -->
            <div class="checkout-summary-col">
                <div class="checkout-summary-box">
                    <div class="checkout-voucher-row">
                        <label for="voucher_code" class="checkout-voucher-label">Nhập mã giảm giá</label>
                        <div class="checkout-voucher-flex">
                            <input type="text" id="voucher_code" class="checkout-input"
                                placeholder="Nhập mã giảm giá">
                            <button type="button" class="checkout-voucher-btn">Áp dụng</button>
                        </div>
                    </div>
                    <div id="voucher_message" style="margin-top:10px;"></div>
                    <div class="checkout-summary-list">
                        <div class="checkout-summary-header">
                            <span>Sản phẩm</span>
                            <span class="checkout-summary-price-label">Thành tiền</span>
                        </div>
                        @foreach ($checkoutItems as $item)
                            @php
                                $product = $item->variation ? $item->variation->product : $item->product ?? null;
                                $images = $product && isset($product->images) ? $product->images : collect();
                                $featuredImage = $images->where('is_featured', true)->first() ?? $images->first();
                                $imagePath = $featuredImage
                                    ? asset('storage/' . $featuredImage->image_path)
                                    : asset('/path/to/default.jpg');
                                $price = $item->variation
                                    ? $item->variation->sale_price ?? ($item->variation->price ?? 0)
                                    : $product->sale_price ?? ($product->price ?? 0);
                            @endphp
                            <div class="checkout-summary-item">
                                <div class="checkout-summary-img-wrap">
                                    <img src="{{ $imagePath }}" alt="{{ $product->name ?? 'Sản phẩm đã xóa' }}">
                                </div>
                                <div class="checkout-summary-info">
                                    <div class="checkout-summary-name">{{ $product->name ?? 'Sản phẩm đã xóa' }}</div>
                                    @if ($item->variation && $item->variation->name)
                                        <div class="checkout-summary-variant">Màu sắc: {{ $item->variation->name }}</div>
                                    @endif
                                </div>
                                <div class="checkout-summary-qty">x{{ $item->quantity }}</div>
                                <div class="checkout-summary-price">
                                    {{ number_format($price * $item->quantity, 0, ',', '.') }}đ</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="checkout-summary-totals">
                        <div class="checkout-summary-total-row">
                            <span>Tạm tính</span>
                            <span>{{ number_format($checkoutItems->sum(function ($item) {$product = $item->variation ? $item->variation->product : $item->product ?? null;$price = $item->variation ? $item->variation->sale_price ?? ($item->variation->price ?? 0) : $product->sale_price ?? ($product->price ?? 0);return $price * $item->quantity;}),0,',','.') }}đ</span>
                        </div>
                        <div class="checkout-summary-total-row">
                            <span>Phí vận chuyển</span>
                            <span>30.000đ</span>
                        </div>
                        <div class="checkout-summary-total-row">
                            <span>Giảm</span>
                            <span>0đ</span>
                        </div>
                        <div class="checkout-summary-total-row checkout-summary-grand">
                            <span>Tổng cộng</span>
                            <span
                                class="checkout-summary-grand-total">{{ number_format($checkoutItems->sum(function ($item) {$product = $item->variation ? $item->variation->product : $item->product ?? null;$price = $item->variation ? $item->variation->sale_price ?? ($item->variation->price ?? 0) : $product->sale_price ?? ($product->price ?? 0);return $price * $item->quantity;}) + 30000,0,',','.') }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .checkout-page-wrapper {
            max-width: 1700px;
            margin: 0 auto;
            padding: 32px 0 48px 0;
            display: flex;
            justify-content: center;
        }

        .checkout-main-flex {
            display: flex;
            gap: 32px;
            align-items: flex-start;
        }

        .checkout-form-col {
            flex: 1 1 0;
            background: #fff;
            border-radius: 8px;
            padding: 32px 32px 24px 32px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .checkout-title {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }

        .checkout-form-group {
            margin-bottom: 18px;
        }

        .checkout-label {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
        }

        .checkout-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            background: #fafbfc;
            transition: border 0.2s;
            margin-top: 4px;
        }

        .checkout-input:focus {
            border-color: #111;
            outline: none;
            background: #fff;
        }

        .required {
            color: #e74c3c;
        }

        .checkout-radio-group {
            margin-top: 8px;
        }

        .checkout-radio {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
        }

        .checkout-btn {
            width: 100%;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px 0;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .checkout-btn:hover {
            background: #26b6c6;
        }

        .checkout-privacy {
            font-size: 0.95rem;
            color: #888;
            margin-top: 18px;
        }

        .checkout-summary-col {
            flex: 1 1 0;
            min-width: 340px;
            max-width: 800px;
        }

        .checkout-summary-box {
            background: #f7f7f7;
            border-radius: 8px;
            padding: 28px 24px 24px 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .checkout-voucher-row {
            margin-bottom: 18px;
        }

        .checkout-voucher-label {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
        }

        .checkout-voucher-flex {
            display: flex;
            gap: 10px;
        }

        .checkout-voucher-flex .checkout-input {
            flex: 1 1 0;
            height: 48px;
            border-radius: 8px 0 0 8px;
            font-size: 1rem;
            margin: 0;
        }

        .checkout-voucher-btn {
            background: #111;
            color: #fff;
            border: none;
            border-radius: 0 8px 8px 0;
            padding: 0 28px;
            neoocular-core.min0899.css?ver=6.8.1 font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .checkout-voucher-btn:hover {
            background: #333;
        }

        .checkout-summary-list {
            margin-bottom: 18px;
        }

        .checkout-summary-header {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            font-size: 1.08rem;
            margin-bottom: 10px;
        }

        .checkout-summary-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #ececec;
        }

        .checkout-summary-img-wrap {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkout-summary-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .checkout-summary-info {
            flex: 1 1 0;
        }

        .checkout-summary-name {
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 2px;
        }

        .checkout-summary-variant {
            font-size: 0.95rem;
            color: #888;
        }

        .checkout-summary-qty {
            font-size: 1.05rem;
            font-weight: 500;
            margin: 0 8px;
        }

        .checkout-summary-price {
            font-size: 1.08rem;
            font-weight: 600;
            color: #222;
            min-width: 90px;
            text-align: right;
        }

        .checkout-summary-totals {
            border-top: 1px solid #e0e0e0;
            padding-top: 14px;
        }

        .checkout-summary-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.05rem;
            margin-bottom: 8px;
        }

        .checkout-summary-grand {
            font-weight: 700;
            font-size: 1.13rem;
            color: #222;
        }

        .checkout-summary-grand-total {
            color: #26b6c6;
            font-size: 1.18rem;
            font-weight: 700;
        }

        /* .checkout-radio span {
                                                                                                                                        font-weight:600; margin-left:6px; min-width:70px; display:inline-block;
                                                                                                                                    } */

        @media (max-width: 900px) {
            .checkout-main-flex {
                flex-direction: column;
                gap: 18px;
            }

            .checkout-form-col,
            .checkout-summary-col {
                max-width: 100%;
                min-width: 0;
                padding: 16px 8px;
            }

            .checkout-summary-box {
                padding: 18px 8px 16px 8px;
            }
        }
    </style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const voucherInput = document.getElementById('voucher_code');
        const applyBtn = document.querySelector('.checkout-voucher-btn');
        const voucherMessage = document.getElementById('voucher_message');
        const appliedVoucherHidden = document.getElementById('applied_voucher_hidden');
        const discountRow = document.querySelector(
            '.checkout-summary-totals .checkout-summary-total-row:nth-child(3) span:last-child');
        const totalRow = document.querySelector('.checkout-summary-grand-total');
        const subtotal = Number(document.querySelector(
                '.checkout-summary-totals .checkout-summary-total-row:nth-child(1) span:last-child')
            .innerText.replace(/\D/g, ''));
        const shipping = Number(document.querySelector(
                '.checkout-summary-totals .checkout-summary-total-row:nth-child(2) span:last-child')
            .innerText.replace(/\D/g, ''));
        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const shippingRow = document.querySelector(
            '.checkout-summary-totals .checkout-summary-total-row:nth-child(2) span:last-child');

        applyBtn.addEventListener('click', function() {
            const code = voucherInput.value.trim();
            if (!code) {
                showVoucherMessage('Vui lòng nhập mã giảm giá!', 'danger');
                return;
            }
            fetch("{{ route('client.cart.apply-voucher') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        voucher_code: code
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showVoucherMessage(data.message, 'success');
                        appliedVoucherHidden.value = JSON.stringify(data.voucher);
                        // Cập nhật số tiền giảm và tổng cộng
                        if (discountRow && totalRow) {
                            discountRow.innerText = '-' + formatCurrency(data.voucher
                                .discount_amount);
                            const newTotal = Math.max(0, subtotal + shipping - data
                                .voucher //Tuấn Anh
                                .discount_amount);
                            totalRow.innerText = formatCurrency(newTotal);
                        }
                    } else {
                        showVoucherMessage(data.message, 'danger');
                        appliedVoucherHidden.value = '';
                        if (discountRow && totalRow) {
                            discountRow.innerText = '0đ';
                            totalRow.innerText = formatCurrency(subtotal + shipping);
                        }
                    }
                })
                .catch(() => {
                    showVoucherMessage('Có lỗi xảy ra, vui lòng thử lại!', 'danger');
                });
        });

        shippingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                let fee = Number(this.dataset.fee || 0);
                let discount = 0;
                if (discountRow) {
                    discount = Number(discountRow.innerText.replace(/\D/g, ''));
                }
                if (shippingRow && totalRow) {
                    shippingRow.innerText = formatCurrency(fee);
                    totalRow.innerText = formatCurrency(Math.max(0, subtotal + fee - discount));
                }
            });
        });
        // Khi load trang, cập nhật phí ship và tổng cộng đúng với radio đang chọn
        const checkedRadio = document.querySelector('input[name="shipping_method"]:checked');
        if (checkedRadio) {
            let fee = Number(checkedRadio.dataset.fee || 0);
            let discount = 0;
            if (discountRow) {
                discount = Number(discountRow.innerText.replace(/\D/g, ''));
            }
            if (shippingRow && totalRow) {
                shippingRow.innerText = formatCurrency(fee);
                totalRow.innerText = formatCurrency(subtotal + fee - discount);
            }
        }

        function showVoucherMessage(msg, type) {
            voucherMessage.innerHTML =
                `<div style="padding:10px 16px;border-radius:6px;font-size:1rem;font-weight:500;${type==='success'?'background:#e8f8f5;color:#148f77;border:1.5px solid #1abc9c;':'background:#ffeaea;color:#c0392b;border:1.5px solid #e74c3c;'};margin-bottom:8px;">${msg}</div>`;
        }

        function formatCurrency(num) {
            return Math.round(Number(num)).toLocaleString('vi-VN') + 'đ';
        }

        const momoBtn = document.getElementById('momo-btn');
        const checkoutBtn = document.getElementById('checkout-btn');
        const form = document.getElementById('checkout-form');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');

        function toggleMomoBtn() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            if (selected && selected.value === 'momo') {
                momoBtn.style.display = 'block';
                checkoutBtn.style.display = 'none';
            } else {
                momoBtn.style.display = 'none';
                checkoutBtn.style.display = 'block';
            }
        }
        paymentRadios.forEach(r => r.addEventListener('change', toggleMomoBtn));
        toggleMomoBtn();

        momoBtn.addEventListener('click', function() {
            form.action = "{{ route('client.cart.momo-payment') }}";
            form.submit();
        });

        const vnpayBtn = document.createElement('button');
        vnpayBtn.type = 'button';
        vnpayBtn.id = 'vnpay-btn';
        vnpayBtn.className = 'checkout-btn';
        vnpayBtn.style = 'background:#0064d2;display:none;margin-top:10px;';
        vnpayBtn.innerText = 'Thanh toán VNPAY';
        checkoutBtn.parentNode.insertBefore(vnpayBtn, momoBtn.nextSibling);

        function togglePaymentBtns() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            if (selected && selected.value === 'momo') {
                momoBtn.style.display = 'block';
                vnpayBtn.style.display = 'none';
                checkoutBtn.style.display = 'none';
            } else if (selected && selected.value === 'vnpay') {
                momoBtn.style.display = 'none';
                vnpayBtn.style.display = 'block';
                checkoutBtn.style.display = 'none';
            } else {
                momoBtn.style.display = 'none';
                vnpayBtn.style.display = 'none';
                checkoutBtn.style.display = 'block';
            }
        }
        paymentRadios.forEach(r => r.addEventListener('change', togglePaymentBtns));
        togglePaymentBtns();

        vnpayBtn.addEventListener('click', function() {
            form.action = "{{ route('client.cart.vnpay-payment') }}";
            form.submit();
        });
    });
</script>
