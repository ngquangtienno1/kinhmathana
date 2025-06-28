@extends('client.layouts.app')
@section('title', 'Thanh toán đơn hàng')
@section('content')
<section class="pt-5 pb-9">
    <div class="container-small">
        <nav class="mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.cart.index') }}">Giỏ hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
            </ol>
        </nav>
        <h2 class="mb-5">Thanh toán</h2>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
     
        <div class="row justify-content-between">
            <div class="col-lg-6 col-xl-6">
                <form action="{{ route('client.cart.checkout') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-end mb-3">
                        <h3 class="mb-0 me-3">Thông tin giao hàng</h3>
                    </div>
                    <table class="table table-borderless mt-4">
                        <tbody>
                            <tr>
                                <td class="py-2 ps-0">
                                    <div class="d-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fs-3 me-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <h5 class="lh-sm me-4">Họ tên người nhận</h5>
                                    </div>
                                </td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="text" name="receiver_name" class="form-control @error('receiver_name') is-invalid @enderror" value="{{ old('receiver_name', auth()->user()->name) }}">
                                    @error('receiver_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 ps-0">
                                    <div class="d-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home fs-3 me-2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                        <h5 class="lh-sm me-4">Địa chỉ nhận hàng</h5>
                                    </div>
                                </td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="text" name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" value="{{ old('shipping_address', auth()->user()->address) }}">
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 ps-0">
                                    <div class="d-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone fs-3 me-2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <h5 class="lh-sm me-4">Số điện thoại</h5>
                                    </div>
                                </td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="text" name="receiver_phone" class="form-control @error('receiver_phone') is-invalid @enderror" value="{{ old('receiver_phone', auth()->user()->phone) }}">
                                    @error('receiver_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 ps-0">
                                    <div class="d-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fs-3 me-2"><path d="M4 4h16v16H4z" fill="none"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <h5 class="lh-sm me-4">Email</h5>
                                    </div>
                                </td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="email" name="receiver_email" class="form-control @error('receiver_email') is-invalid @enderror" value="{{ old('receiver_email', auth()->user()->email) }}">
                                    @error('receiver_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="my-6">
                    <h3>Thông tin người đặt</h3>
                    <table class="table table-borderless mt-4">
                        <tbody>
                            <tr>
                                <td class="py-2 ps-0">Họ tên người đặt</td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', auth()->user()->name) }}">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 ps-0">Số điện thoại</td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone', auth()->user()->phone) }}">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 ps-0">Email</td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email', auth()->user()->email) }}">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 ps-0">Địa chỉ</td>
                                <td class="py-2 fw-bold lh-sm">:</td>
                                <td class="py-2 px-3">
                                    <input type="text" name="customer_address" class="form-control @error('customer_address') is-invalid @enderror" value="{{ old('customer_address', auth()->user()->address) }}">
                                    @error('customer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="my-6">
                    <h3 class="mb-5">Mã giảm giá</h3>
                    <div class="row g-4 mb-7">
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-grow-1">
                                    <input type="text" id="voucher_code" name="voucher_code" class="form-control" placeholder="Nhập mã giảm giá" value="{{ old('voucher_code') }}">
                                    <input type="hidden" id="applied_voucher" name="applied_voucher" value="">
                                </div>
                                <button type="button" id="apply_voucher_btn" class="btn btn-primary">Áp dụng</button>
                            </div>
                            <div id="voucher_message" class="mt-2"></div>
                        </div>
                        
                        @if($promotions->count() > 0)
                        <div class="col-12">
                            <h6 class="mb-3">Voucher có sẵn:</h6>
                            <div class="row g-3">
                                @foreach($promotions as $promotion)
                                <div class="col-12 col-md-6">
                                    <div class="card border-dashed">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">{{ $promotion->name }}</h6>
                                                    <p class="text-body-tertiary fs-8 mb-0">{{ $promotion->description }}</p>
                                                </div>
                                                <span class="badge badge-phoenix badge-phoenix-success">{{ $promotion->code }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-success fw-bold">
                                                    @if($promotion->discount_type === 'percentage')
                                                        Giảm {{ $promotion->discount_value }}%
                                                    @else
                                                        Giảm {{ number_format($promotion->discount_value, 0, ',', '.') }}₫
                                                    @endif
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-primary use-voucher" 
                                                        data-code="{{ $promotion->code }}"
                                                        data-name="{{ $promotion->name }}"
                                                        data-discount-type="{{ $promotion->discount_type }}"
                                                        data-discount-value="{{ $promotion->discount_value }}">
                                                    Sử dụng
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-body-tertiary">
                                                    Đơn tối thiểu: {{ number_format($promotion->minimum_purchase, 0, ',', '.') }}₫
                                                    @if($promotion->usage_limit)
                                                        • Còn {{ $promotion->usage_limit - $promotion->used_count }} lượt
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <hr class="my-6">
                    <h3 class="mb-5">Phương thức vận chuyển</h3>
                    <div class="row gy-6">
                        <div class="col-12 col-md-6">
                            <div class="d-flex flex-wrap align-items-center mb-3">
                                <div class="form-check mb-0">
                                    <input class="form-check-input @error('shipping_method') is-invalid @enderror" type="radio" name="shipping_method" id="free_shipping" value="free" {{ old('shipping_method') == 'free' ? 'checked' : '' }}>
                                    <label class="form-check-label fs-8 text-body" for="free_shipping">Miễn phí vận chuyển</label>
                                </div>
                                <span class="d-inline-block text-body-emphasis fw-bold ms-2">0₫</span>
                            </div>
                            <div class="ps-4">
                                <h6 class="text-body-tertiary mb-2">Dự kiến giao hàng: 3-5 ngày</h6>
                                <h6 class="text-info lh-base mb-0">Giao hàng miễn phí cho đơn hàng từ 500.000₫!</h6>
                            </div>
                        </div>
                        @error('shipping_method')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @foreach($shippingProviders as $provider)
                        <div class="col-12 col-md-6">
                            <div class="d-flex flex-wrap align-items-center mb-3">
                                <div class="form-check mb-0">
                                    <input class="form-check-input @error('shipping_method') is-invalid @enderror" type="radio" name="shipping_method" id="provider_{{ $provider->id }}" value="{{ $provider->code }}" {{ old('shipping_method') == $provider->code ? 'checked' : '' }}>
                                    <label class="form-check-label fs-8 text-body" for="provider_{{ $provider->id }}">{{ $provider->name }}</label>
                                </div>
                                <span class="d-inline-block text-body-emphasis fw-bold ms-2">
                                    @if($provider->shippingFees->count() > 0)
                                        {{ number_format($provider->shippingFees->first()->base_fee, 0, ',', '.') }}₫
                                    @else
                                        30.000₫
                                    @endif
                                </span>
                                @if($provider->code === 'GHN')
                                    <span class="badge badge-phoenix badge-phoenix-warning ms-2 ms-lg-4 ms-xl-2">Phổ biến</span>
                                @endif
                            </div>
                            <div class="ps-4">
                                <h6 class="text-body-tertiary mb-2">
                                    @if($provider->code === 'GHTK')
                                        Dự kiến giao hàng: 2-3 ngày
                                    @elseif($provider->code === 'VNPOST')
                                        Dự kiến giao hàng: 3-5 ngày
                                    @elseif($provider->code === 'GHN')
                                        Dự kiến giao hàng: 1-2 ngày
                                    @else
                                        Dự kiến giao hàng: 2-4 ngày
                                    @endif
                                </h6>
                                <h6 class="text-info lh-base mb-0">{{ $provider->description }}</h6>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr class="my-6">
                    <h3 class="mb-5">Phương thức thanh toán</h3>
                    <div class="row g-4 mb-7">
                        <div class="col-12">
                            <div class="row gx-lg-11">
                                @foreach($paymentMethods as $method)
                                <div class="col-12 col-md-auto">
                                    <div class="form-check">
                                        <input class="form-check-input @error('payment_method') is-invalid @enderror" id="payment_{{ $method->id }}" type="radio" name="payment_method" value="{{ $method->code }}" {{ old('payment_method') == $method->code ? 'checked' : '' }}>
                                        <label class="form-check-label fs-8 text-body" for="payment_{{ $method->id }}">
                                            @if($method->logo)
                                                <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" class="me-2" style="height: 20px;">
                                            @endif
                                            {{ $method->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" id="save_payment" type="checkbox" name="save_payment_info">
                                <label class="form-check-label text-body-emphasis fs-8" for="save_payment">Lưu thông tin thanh toán cho lần sau</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Ghi chú</label>
                        <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                    </div>
                    <div class="row g-2 mb-5 mb-lg-0">
                        <div class="col-md-8 col-lg-9 d-grid">
                            <button class="btn btn-primary" type="submit">Đặt hàng</button>
                        </div>
                        <div class="col-md-4 col-lg-3 d-grid">
                            <a href="{{ route('client.cart.index') }}" class="btn btn-phoenix-secondary text-nowrap">Quay lại giỏ hàng</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 col-xl-6">
                <div class="card mt-3 mt-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="mb-0">Tóm tắt đơn hàng</h3>
                            <a class="btn btn-link pe-0" href="{{ route('client.cart.index') }}">Chỉnh sửa giỏ hàng</a>
                        </div>
                        <div class="border-dashed border-bottom border-translucent mt-4">
                            <div class="ms-n2">
                                @foreach($cartItems as $item)
                                <div class="row align-items-center mb-2 g-3">
                                    <div class="col-8 col-md-7 col-lg-8">
                                        <div class="d-flex align-items-center">
                                            <img class="me-2 ms-1" src="{{ $item->variation->product->images->first() ? asset('storage/'.$item->variation->product->images->first()->image_path) : '/assets/img/products/1.png' }}" width="40" alt="">
                                            <h6 class="fw-semibold text-body-highlight lh-base">{{ $item->variation->product->name ?? '' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-3 col-lg-2">
                                        <h6 class="fs-10 mb-0">x{{ (int)$item->quantity }}</h6>
                                    </div>
                                    <div class="col-2 ps-0">
                                        <h5 class="mb-0 fw-semibold text-end">{{ number_format($item->variation->price * (int)$item->quantity, 0, ',', '.') }}₫</h5>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="border-dashed border-bottom border-translucent mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="text-body fw-semibold">Tạm tính: </h5>
                                <h5 class="text-body fw-semibold">{{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int)$item->quantity), 0, ',', '.') }}₫</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="text-body fw-semibold mb-0">Giảm giá:</h5>
                                <div class="text-end">
                                    <h5 class="text-danger fw-semibold discount-amount mb-0">-0₫</h5>
                                    <div class="voucher-detail text-body-tertiary small"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="text-body fw-semibold">Thuế: </h5>
                                <h5 class="text-body fw-semibold">0₫</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="text-body fw-semibold">Tạm tính </h5>
                                <h5 class="text-body fw-semibold">{{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int)$item->quantity), 0, ',', '.') }}₫</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="text-body fw-semibold mb-0">Phí vận chuyển</h5>
                                <div class="text-end">
                                    <h5 class="text-body fw-semibold shipping-cost mb-0">0₫</h5>
                                    <div class="shipping-voucher-detail text-body-tertiary small"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between border-dashed-y pt-3">
                            <h4 class="mb-0">Tổng cộng :</h4>
                            <h4 class="mb-0 text-danger total-amount">{{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int)$item->quantity), 0, ',', '.') }}₫</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end of .container-->
</section>

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
    
    const subtotal = {{ $cartItems->sum(fn($item) => $item->variation->price * (int)$item->quantity) }};
    let appliedVoucher = null;
    let discountAmount = 0;
    
    // Tạo object chứa phí vận chuyển từ database
    const shippingCosts = {
        'free': 0
    };
    
    // Thêm phí vận chuyển từ các provider
    @foreach($shippingProviders as $provider)
        @if($provider->shippingFees->count() > 0)
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
        fetch('{{ route("client.cart.apply-voucher") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
            let detail = `<div><b>${appliedVoucher.name}</b> <span class="badge bg-success">${appliedVoucher.code}</span></div>`;
            if (appliedVoucher.description) {
                detail += `<div>${appliedVoucher.description}</div>`;
            }
            if (appliedVoucher.code === 'FREESHIP') {
                // Hiển thị ở phí vận chuyển
                shippingVoucherDetail.innerHTML = detail + `<div>Đã trừ: -${appliedVoucher.discount_amount.toLocaleString('vi-VN')}₫ vào phí vận chuyển</div>`;
            } else {
                // Hiển thị ở giảm giá tổng đơn
                voucherDetail.innerHTML = detail + `<div>Đã trừ: -${appliedVoucher.discount_amount.toLocaleString('vi-VN')}₫ vào tổng đơn</div>`;
            }
        }
    }
});
</script>
@endsection 