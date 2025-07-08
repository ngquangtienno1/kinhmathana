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
                                {{-- <div class="woocommerce-form-coupon-toggle">
                                    <div class="woocommerce-info">
                                        Bạn có mã giảm giá? <a href="#" class="showcoupon">Nhấn vào đây để nhập mã</a>
                                    </div>
                                </div> --}}
                                <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:block;">
                                    <p>Nếu bạn có mã giảm giá, hãy nhập vào bên dưới.</p>
                                    <p class="form-row form-row-first">
                                        <label for="voucher_code" class="screen-reader-text">Mã giảm giá:</label>
                                        <input type="text" name="voucher_code" class="input-text"
                                            placeholder="Nhập mã giảm giá" id="voucher_code" value="">
                                        <input type="hidden" id="applied_voucher" name="applied_voucher" value="">
                                    </p>
                                    <p class="form-row form-row-last">
                                        <button type="button" class="button" id="apply_voucher_btn">Áp dụng</button>
                                    </p>
                                    <div id="voucher_message" class="mt-2"></div>
                                    <div class="clear"></div>
                                </form>
                                <div class="woocommerce-notices-wrapper"></div>
                                <form name="checkout" method="post" class="checkout woocommerce-checkout"
                                    action="{{ route('client.cart.checkout') }}" enctype="multipart/form-data"
                                    novalidate="novalidate">
                                    @csrf
                                    <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                                    <input type="hidden" name="customer_phone" value="{{ auth()->user()->phone }}">
                                    <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                                    <input type="hidden" name="customer_address" value="{{ auth()->user()->address }}">
                                    <input type="hidden" name="shipping_address"
                                        value="{{ old('receiver_address', auth()->user()->address) }}">
                                    <input type="hidden" name="applied_voucher" id="applied_voucher_hidden" value="">
                                    <input type="hidden" name="note" id="order_note_hidden" value="">
                                    <div class="col2-set" id="customer_details">
                                        <div class="col-1">
                                            <div class="woocommerce-billing-fields">
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
                                                        <label for="receiver_address">Địa chỉ nhận hàng <abbr
                                                                class="required" title="required">*</abbr></label>
                                                        <span class="woocommerce-input-wrapper">
                                                            <input type="text" class="input-text"
                                                                name="receiver_address" id="receiver_address"
                                                                placeholder=""
                                                                value="{{ old('receiver_address', auth()->user()->address) }}">
                                                        </span>
                                                    </p>
                                                    <p class="form-row form-row-wide">
                                                        <label for="receiver_email">Email</label>
                                                        <span class="woocommerce-input-wrapper">
                                                            <input type="email" class="input-text"
                                                                name="receiver_email" id="receiver_email" placeholder=""
                                                                value="{{ old('receiver_email', auth()->user()->email) }}">
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="woocommerce-shipping-fields"></div>
                                            <div class="woocommerce-additional-fields">
                                                <h3>Thông tin thêm</h3>
                                                <div class="woocommerce-additional-fields__field-wrapper">
                                                    <p class="form-row notes" id="order_comments_field">
                                                        <label for="order_comments">Ghi chú đơn hàng <span
                                                                class="optional">(tùy chọn)</span></label>
                                                        <span class="woocommerce-input-wrapper">
                                                            <textarea name="note" class="input-text" id="order_comments" placeholder="" rows="2" cols="5">{{ old('note') }}</textarea>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shipping-methods-box" style="margin-bottom:24px;">
                                        <h3 class="mb-5">Phương thức vận chuyển</h3>
                                        <div class="row g-3">
                                            <div class="col-12 col-md-3">
                                                <div class="shipping-method-card"
                                                    style="border:1px solid #eee;  padding:12px; min-width:0;">
                                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="radio"
                                                                name="shipping_method" id="free_shipping" value="free"
                                                                checked>
                                                            <label class="form-check-label fs-8 text-body"
                                                                for="free_shipping">Miễn phí vận chuyển</label>
                                                        </div>
                                                        <span
                                                            class="d-inline-block text-body-emphasis fw-bold ms-2">0₫</span>
                                                    </div>
                                                    <div class="ps-2">
                                                        <h6 class="text-body-tertiary mb-2">Dự kiến giao hàng: 3-5 ngày
                                                        </h6>
                                                        <h6 class="text-info lh-base mb-0">Giao hàng miễn phí cho đơn hàng
                                                            từ 500.000₫!</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($shippingProviders as $provider)
                                                <div class="col-12 col-md-3">
                                                    <div class="shipping-method-card"
                                                        style="border:1px solid #eee;  padding:12px; min-width:0;">
                                                        <div class="d-flex flex-wrap align-items-center mb-2">
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input" type="radio"
                                                                    name="shipping_method"
                                                                    id="provider_{{ $provider->id }}"
                                                                    value="{{ $provider->code }}">
                                                                <label class="form-check-label fs-8 text-body"
                                                                    for="provider_{{ $provider->id }}">{{ $provider->name }}</label>
                                                            </div>
                                                            <span class="d-inline-block text-body-emphasis fw-bold ms-2">
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
                                    <h3 id="order_review_heading">Đơn hàng của bạn</h3>
                                    <div id="order_review" class="woocommerce-checkout-review-order">
                                        <table class="shop_table woocommerce-checkout-review-order-table">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Sản phẩm</th>
                                                    <th class="product-quantity">Số lượng</th>
                                                    <th class="product-total">Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cartItems as $item)
                                                    <tr class="cart_item">
                                                        <td class="product-name">
                                                            {{ $item->variation ? $item->variation->product->name ?? '' : $item->product->name ?? '' }}
                                                            @if ($item->variation && $item->variation->name)
                                                                <span
                                                                    class="text-muted">({{ $item->variation->name }})</span>
                                                            @endif
                                                        </td>
                                                        <td class="product-quantity">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ $item->quantity }}</bdi>
                                                            </span>
                                                        </td>
                                                        <td class="product-total">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format(($item->variation ? $item->variation->sale_price ?? $item->variation->price : $item->product->sale_price ?? $item->product->price) * $item->quantity, 0, ',', '.') }}₫</bdi>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="cart-subtotal">
                                                    <th>Tạm tính</th>
                                                    <td></td>
                                                    <td><span
                                                            class="woocommerce-Price-amount amount"><bdi>{{ number_format($cartItems->sum(fn($item) => ($item->variation ? $item->variation->sale_price ?? $item->variation->price : $item->product->sale_price ?? $item->product->price) * $item->quantity), 0, ',', '.') }}₫</bdi></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Giảm giá</th>
                                                    <td></td>
                                                    <td><span class="discount-amount">-0₫</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Phí vận chuyển</th>
                                                    <td></td>
                                                    <td><span class="shipping-cost">0₫</span></td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>Tổng cộng</th>
                                                    <td></td>
                                                    <td><strong><span
                                                                class="total-amount">{{ number_format($cartItems->sum(fn($item) => ($item->variation ? $item->variation->sale_price ?? $item->variation->price : $item->product->sale_price ?? $item->product->price) * $item->quantity), 0, ',', '.') }}₫</span></strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div id="payment" class="woocommerce-checkout-payment">
                                        <h3 class="mb-5">Phương thức thanh toán</h3>
                                        <div class="row g-4 mb-4">
                                            @foreach ($paymentMethods as $method)
                                                <div class="col-12 col-md-3">
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
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

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

            const subtotal =
                {{ $cartItems->sum(fn($item) => ($item->variation ? $item->variation->sale_price ?? $item->variation->price : $item->product->sale_price ?? $item->product->price) * (int) $item->quantity) }};
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
