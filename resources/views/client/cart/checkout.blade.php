@extends('client.layouts.app')
@section('title', 'Thanh toán đơn hàng')
@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid  ">
                    <h1 class="qodef-m-title entry-title">
                        Thanh toán </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                        <a itemprop="url" class="qodef-breadcrumbs-link" href="/">
                            <span itemprop="title">Trang chủ</span>
                        </a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Thanh toán</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div class="woocommerce">
                            <div class="woocommerce-notices-wrapper"></div>
                            <div id="qodef-woo-page" class="qodef--checkout">
                                <div class="woocommerce-form-coupon-toggle">
                                    <div class="woocommerce-info">
                                        Bạn có mã giảm giá?
                                    </div>
                                    <!-- Form mã giảm giá chuyển sang đây -->
                                    <form class="checkout_coupon woocommerce-form-coupon mt-4" method="post"
                                        style="display:block;">
                                        <p class="form-row form-row-first">
                                            <label for="voucher_code" class="screen-reader-text">Mã giảm giá:</label>
                                            <input type="text" name="voucher_code" class="input-text"
                                                placeholder="Nhập mã giảm giá" id="voucher_code" value="">
                                            <input type="hidden" id="applied_voucher" name="applied_voucher"
                                                value="">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <button type="button" class="button" id="apply_voucher_btn">Áp dụng</button>
                                        </p>
                                        <div id="voucher_message" class="mt-2"></div>
                                        <div>
                                            @if (isset($promotions) && $promotions->count())
                                                <div class="voucher-label">Voucher có sẵn:</div>
                                                <div class="voucher-suggestion-list">
                                                    @foreach ($promotions as $promotion)
                                                        <span class="voucher-suggestion-item use-voucher"
                                                            data-code="{{ $promotion->code }}">
                                                            <i class="fa fa-ticket-alt"></i>{{ $promotion->code }} -
                                                            {{ $promotion->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="clear"></div>
                                    </form>
                                </div>
                                <div class="row">
                                    <!-- Bên trái: Thông tin người nhận, địa chỉ, ghi chú, vận chuyển, thanh toán -->
                                    <div class="col-12 col-md-6 order-md-1 mb-4">
                                        <form name="checkout" method="post" class="checkout woocommerce-checkout"
                                            action="{{ route('client.cart.checkout') }}" enctype="multipart/form-data"
                                            novalidate="novalidate">
                                            @csrf
                                            <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                                            <input type="hidden" name="customer_phone" value="{{ auth()->user()->phone }}">
                                            <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                                            <input type="hidden" name="customer_address"
                                                value="{{ auth()->user()->address }}">
                                            <input type="hidden" name="shipping_address"
                                                value="{{ old('receiver_address', auth()->user()->address) }}">
                                            <input type="hidden" name="applied_voucher" id="applied_voucher_hidden"
                                                value="">
                                            <input type="hidden" name="note" id="order_note_hidden" value="">
                                            <h3>Thông tin người nhận</h3>
                                            <div class="woocommerce-billing-fields__field-wrapper">
                                                <p class="form-row form-row-first validate-required">
                                                    <label for="receiver_name">Họ tên người nhận <abbr class="required"
                                                            title="required">*</abbr></label>
                                                    <span class="woocommerce-input-wrapper">
                                                        <input type="text" class="input-text" name="receiver_name"
                                                            id="receiver_name" placeholder=""
                                                            value="{{ old('receiver_name', auth()->user()->name) }}">
                                                    </span>
                                                </p>
                                                <p class="form-row form-row-last validate-required">
                                                    <label for="receiver_phone">Số điện thoại <abbr class="required"
                                                            title="required">*</abbr></label>
                                                    <span class="woocommerce-input-wrapper">
                                                        <input type="text" class="input-text" name="receiver_phone"
                                                            id="receiver_phone" placeholder=""
                                                            value="{{ old('receiver_phone', auth()->user()->phone) }}">
                                                    </span>
                                                </p>
                                                <p class="form-row form-row-wide validate-required">
                                                    <label for="receiver_address">Địa chỉ nhận hàng <abbr class="required"
                                                            title="required">*</abbr></label>
                                                    <span class="woocommerce-input-wrapper">
                                                        <input type="text" class="input-text" name="receiver_address"
                                                            id="receiver_address" placeholder=""
                                                            value="{{ old('receiver_address', auth()->user()->address) }}">
                                                    </span>
                                                </p>
                                                <p class="form-row form-row-wide">
                                                    <label for="receiver_email">Email</label>
                                                    <span class="woocommerce-input-wrapper">
                                                        <input type="email" class="input-text" name="receiver_email"
                                                            id="receiver_email" placeholder=""
                                                            value="{{ old('receiver_email', auth()->user()->email) }}">
                                                    </span>
                                                </p>
                                                <p class="form-row notes" id="order_comments_field">
                                                    <label for="order_comments">Ghi chú đơn hàng <span
                                                            class="optional">(tùy chọn)</span></label>
                                                    <span class="woocommerce-input-wrapper">
                                                        <textarea name="note" class="input-text" id="order_comments" placeholder="" rows="2" cols="5">{{ old('note') }}</textarea>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="shipping-methods-box" style="margin-bottom:24px;">
                                                <h3 class="mb-5">Phương thức vận chuyển</h3>
                                                <div class="row g-3">
                                                    <div class="col-12 col-md-12">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="shipping-method-card"
                                                                    style="border:1px solid #eee;  padding:12px; min-width:0;">
                                                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                                                        <div class="form-check mb-0">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="shipping_method" id="free_shipping"
                                                                                value="free" checked>
                                                                            <label class="form-check-label fs-8 text-body"
                                                                                for="free_shipping">Miễn phí vận
                                                                                chuyển</label>
                                                                        </div>
                                                                        <span
                                                                            class="d-inline-block text-body-emphasis fw-bold ms-2">0₫</span>
                                                                    </div>
                                                                    <div class="ps-2">
                                                                        <h6 class="text-body-tertiary mb-2">Dự kiến giao
                                                                            hàng: 3-5 ngày</h6>
                                                                        <h6 class="text-info lh-base mb-0">Giao hàng miễn
                                                                            phí cho đơn hàng từ 500.000₫!</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @foreach ($shippingProviders as $provider)
                                                                <div class="col-12 col-md-6">
                                                                    <div class="shipping-method-card"
                                                                        style="border:1px solid #eee;  padding:12px; min-width:0;">
                                                                        <div
                                                                            class="d-flex flex-wrap align-items-center mb-2">
                                                                            <div class="form-check mb-0">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="shipping_method"
                                                                                    id="provider_{{ $provider->id }}"
                                                                                    value="{{ $provider->code }}">
                                                                                <label
                                                                                    class="form-check-label fs-8 text-body"
                                                                                    for="provider_{{ $provider->id }}">{{ $provider->name }}</label>
                                                                            </div>
                                                                            <span
                                                                                class="d-inline-block text-body-emphasis fw-bold ms-2">
                                                                                @if ($provider->shippingFees->count() > 0)
                                                                                    {{ number_format($provider->shippingFees->first()->base_fee, 0, ',', '.') }}₫
                                                                                @else
                                                                                    30.000₫
                                                                                @endif
                                                                            </span>
                                                                            @if ($provider->code === 'GHN')
                                                                                <span
                                                                                    class="badge badge-phoenix badge-phoenix-warning ms-2 ms-lg-4 ms-xl-2">Phổ
                                                                                    biến</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="ps-2">
                                                                            <h6 class="text-body-tertiary mb-2">
                                                                                @if ($provider->code === 'GHTK')
                                                                                    Dự kiến giao hàng: 2-3 ngày
                                                                                @elseif($provider->code === 'VNPOST')
                                                                                    Dự kiến giao hàng: 3-5 ngày
                                                                                @elseif($provider->code === 'GHN')
                                                                                    Dự kiến giao hàng: 1-2 ngày
                                                                                @else
                                                                                    Dự kiến giao hàng: 2-4 ngày
                                                                                @endif
                                                                            </h6>
                                                                            <h6 class="text-info lh-base mb-0">
                                                                                {{ $provider->description }}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="payment" class="woocommerce-checkout-payment">
                                                <h3 class="mb-5">Phương thức thanh toán</h3>
                                                <div class="row g-4 mb-4">
                                                    @foreach ($paymentMethods as $method)
                                                        <div class="col-12 col-md-6">
                                                            <div class="payment-method-card"
                                                                style="border:1px solid #eee;  padding:12px; min-width:0;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                        id="payment_{{ $method->id }}" type="radio"
                                                                        name="payment_method" value="{{ $method->code }}"
                                                                        {{ old('payment_method') == $method->code ? 'checked' : '' }}>
                                                                    <label class="form-check-label fs-8 text-body"
                                                                        for="payment_{{ $method->id }}">
                                                                        @if ($method->logo)
                                                                            <img src="{{ asset('storage/' . $method->logo) }}"
                                                                                alt="{{ $method->name }}" class="me-2"
                                                                                style="height: 20px;">
                                                                        @endif
                                                                        {{ $method->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-row place-order">
                                                    <button type="submit" class="button alt">Đặt hàng</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Bên phải: Thông tin đơn hàng, tổng tiền, mã giảm giá -->
                                    <div class="col-12 col-md-6 order-md-2 mb-4">
                                        <h3 id="order_review_heading">Đơn hàng của bạn</h3>
                                        <div id="order_review" class="woocommerce-checkout-review-order">
                                            <table class="table table-hover align-middle text-center table-order">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Ảnh</th>
                                                        <th>Sản phẩm</th>
                                                        <th>Số lượng</th>
                                                        <th>Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cartItems as $item)
                                                        @php
                                                            $product = $item->variation
                                                                ? $item->variation->product
                                                                : $item->product ?? null;
                                                            $images =
                                                                $product && isset($product->images)
                                                                    ? $product->images
                                                                    : collect();
                                                            $featuredImage =
                                                                $images->where('is_featured', true)->first() ??
                                                                $images->first();
                                                            $imagePath = $featuredImage
                                                                ? asset('storage/' . $featuredImage->image_path)
                                                                : asset('/path/to/default.jpg');
                                                            $price = $item->variation
                                                                ? $item->variation->sale_price ??
                                                                    ($item->variation->price ?? 0)
                                                                : $product->sale_price ?? ($product->price ?? 0);
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <img src="{{ $imagePath }}"
                                                                    alt="{{ $product->name ?? 'Sản phẩm đã xóa' }}"
                                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                            </td>
                                                            <td class="text-start">
                                                                <strong>{{ $product->name ?? 'Sản phẩm đã xóa' }}</strong>
                                                                @if ($item->variation && $item->variation->name)
                                                                    <div class="text-muted small">
                                                                        ({{ $item->variation->name }})
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ number_format($price * $item->quantity, 0, ',', '.') }}₫
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <th colspan="2" class="text-end">Tạm tính</th>
                                                        <td>{{ number_format(
                                                            $cartItems->sum(function ($item) {
                                                                $product = $item->variation ? $item->variation->product : $item->product ?? null;
                                                                $price = $item->variation
                                                                    ? $item->variation->sale_price ?? ($item->variation->price ?? 0)
                                                                    : $product->sale_price ?? ($product->price ?? 0);
                                                                return $price * $item->quantity;
                                                            }),
                                                            0,
                                                            ',',
                                                            '.',
                                                        ) }}₫
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <th colspan="2" class="text-end">Giảm giá</th>
                                                        <td><span class="discount-amount">-0₫</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <th colspan="2" class="text-end">Phí vận chuyển</th>
                                                        <td><span class="shipping-cost">0₫</span></td>
                                                    </tr>
                                                    <tr class="fw-bold">
                                                        <td></td>
                                                        <th colspan="2" class="text-end">Tổng cộng</th>
                                                        <td><span
                                                                class="total-amount">{{ number_format(
                                                                    $cartItems->sum(function ($item) {
                                                                        $product = $item->variation ? $item->variation->product : $item->product ?? null;
                                                                        $price = $item->variation
                                                                            ? $item->variation->sale_price ?? ($item->variation->price ?? 0)
                                                                            : $product->sale_price ?? ($product->price ?? 0);
                                                                        return $price * $item->quantity;
                                                                    }),
                                                                    0,
                                                                    ',',
                                                                    '.',
                                                                ) }}₫</span>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <style>
        .voucher-label {
            font-weight: bold;
            color: black;
            margin-bottom: 10px;
        }

        .voucher-suggestion-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .voucher-suggestion-item {
            background-color: #2c2c2c;
            /* màu nền tối */
            color: #fff;
            border: 1px solid #444;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .voucher-suggestion-item i {
            color: #f1c40f;
            /* màu vàng nổi bật cho icon */
        }

        .voucher-suggestion-item:hover {
            background-color: #3a3a3a;
            border-color: #f1c40f;
            box-shadow: 0 0 10px rgba(241, 196, 15, 0.3);
            transform: translateY(-2px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
            const shippingCostElement = document.querySelector('.shipping-cost');
            const totalAmountElement = document.querySelector('.total-amount');
            const discountAmountElement = document.querySelector('.discount-amount');
            const voucherCodeInput = document.getElementById('voucher_code');
            const applyVoucherBtn = document.getElementById('apply_voucher_btn');
            const voucherMessage = document.getElementById('voucher_message');
            const appliedVoucherInput = document.getElementById('applied_voucher');
            const useVoucherBtns = document.querySelectorAll('.use-voucher');

            @php
                $subtotal = $cartItems->sum(function ($item) {
                    $product = $item->variation ? $item->variation->product : $item->product ?? null;
                    $price = $item->variation ? $item->variation->sale_price ?? ($item->variation->price ?? 0) : $product->sale_price ?? ($product->price ?? 0);
                    return $price * $item->quantity;
                });
            @endphp
            const subtotal = {{ $subtotal }};
            let appliedVoucher = null;
            let discountAmount = 0;

            // Tạo object chứa phí vận chuyển từ database
            const shippingCosts = {
                'free': 0
            };

            // Thêm phí vận chuyển từ các provider
            @foreach ($shippingProviders as $provider)
                @if ($provider->shippingFees->count() > 0)
                    shippingCosts['{{ $provider->code }}'] = {{ $provider->shippingFees->first()->base_fee }};
                @else
                    shippingCosts['{{ $provider->code }}'] = 30000; // Giá mặc định nếu không có phí
                @endif
            @endforeach

            // Xử lý nút áp dụng voucher
            applyVoucherBtn.addEventListener('click', function() {
                const voucherCode = voucherCodeInput.value.trim();
                if (!voucherCode) {
                    showVoucherMessage('Vui lòng nhập mã voucher!', 'danger');
                    return;
                }

                applyVoucher(voucherCode);
            });

            // Xử lý nút sử dụng voucher có sẵn
            useVoucherBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const voucherCode = this.dataset.code;
                    voucherCodeInput.value = voucherCode;
                    applyVoucher(voucherCode);
                });
            });

            // Hàm áp dụng voucher
            function applyVoucher(voucherCode) {
                fetch('{{ route('client.cart.apply-voucher') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            voucher_code: voucherCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            appliedVoucher = data.voucher;
                            appliedVoucherInput.value = JSON.stringify(appliedVoucher);
                            // Cập nhật input hidden trong form đặt hàng:
                            var voucherHidden = document.getElementById('applied_voucher_hidden');
                            if (voucherHidden) voucherHidden.value = JSON.stringify(appliedVoucher);
                            discountAmount = data.voucher.discount_amount;
                            showVoucherMessage(data.message, 'success');
                            updateTotals();
                        } else {
                            showVoucherMessage(data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showVoucherMessage('Có lỗi xảy ra khi áp dụng voucher!', 'danger');
                    });
            }

            // Hàm hiển thị thông báo voucher
            function showVoucherMessage(message, type) {
                voucherMessage.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                </div>`;
            }

            function updateTotals() {
                const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
                let shippingCost = selectedShipping ? shippingCosts[selectedShipping.value] : 0;
                let discount = discountAmount;

                // Nếu là voucher giảm phí ship
                if (appliedVoucher && appliedVoucher.code === 'FREESHIP') {
                    // Trừ vào phí ship, không để âm
                    const shipDiscount = Math.min(shippingCost, appliedVoucher.discount_amount);
                    shippingCost = Math.max(0, shippingCost - shipDiscount);
                    // discount vẫn là 0 (không trừ vào hàng hóa)
                    discount = 0;
                }

                const total = subtotal + shippingCost - discount;

                shippingCostElement.textContent = shippingCost.toLocaleString('vi-VN') + '₫';
                discountAmountElement.textContent = '-' + Math.abs(discount).toLocaleString('vi-VN') + '₫';
                totalAmountElement.textContent = total.toLocaleString('vi-VN') + '₫';
            }

            shippingRadios.forEach(radio => {
                radio.addEventListener('change', updateTotals);
            });

            // Initialize totals
            updateTotals();

            function updateVoucherDetail() {
                const voucherDetail = document.querySelector('.voucher-detail');
                const shippingVoucherDetail = document.querySelector('.shipping-voucher-detail');
                voucherDetail.innerHTML = '';
                shippingVoucherDetail.innerHTML = '';

                if (appliedVoucher) {
                    let detail =
                        `<div><b>${appliedVoucher.name}</b> <span class="badge bg-success">${appliedVoucher.code}</span></div>`;
                    if (appliedVoucher.description) {
                        detail += `<div>${appliedVoucher.description}</div>`;
                    }
                    if (appliedVoucher.code === 'FREESHIP') {
                        // Hiển thị ở phí vận chuyển
                        shippingVoucherDetail.innerHTML = detail +
                            `<div>Đã trừ: -${appliedVoucher.discount_amount.toLocaleString('vi-VN')}₫ vào phí vận chuyển</div>`;
                    } else {
                        // Hiển thị ở giảm giá tổng đơn
                        voucherDetail.innerHTML = detail +
                            `<div>Đã trừ: -${appliedVoucher.discount_amount.toLocaleString('vi-VN')}₫ vào tổng đơn</div>`;
                    }
                }
            }
        });
    </script>

@endsection
