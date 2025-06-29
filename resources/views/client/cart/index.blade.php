@extends('client.layouts.app')
@section('title', 'Giỏ hàng của bạn')
@section('content')

    <section class="{{ $cartItems->isEmpty() ? 'py-4' : 'pt-5 pb-9' }}">
        <div class="container-small cart">
            <nav class="mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                </ol>
            </nav>
            <h2 class="mb-6">Giỏ hàng</h2>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($cartItems->isEmpty())
                <div class="alert alert-info my-4">Giỏ hàng của bạn đang trống.</div>
            @else
                <div class="row g-5">
                    <div class="col-12 col-lg-8">
                        <div id="cartTable"
                            data-list='{"valueNames":["products","color","size","price","quantity","total"],"page":10}'>
                            <div class="table-responsive scrollbar mx-n1 px-1">
                                <table class="table fs-9 mb-0 border-top border-translucent">
                                    <thead>
                                        <tr>
                                            <th class="sort white-space-nowrap align-middle fs-10" scope="col"></th>
                                            <th class="sort white-space-nowrap align-middle" scope="col"
                                                style="min-width:250px;">SẢN PHẨM</th>
                                            <th class="sort align-middle" scope="col" style="width:80px;">MÀU</th>
                                            <th class="sort align-middle" scope="col" style="width:150px;">KÍCH THƯỚC
                                            </th>
                                            <th class="sort align-middle text-end" scope="col" style="width:150px;">GIÁ
                                            </th>
                                            <th class="sort align-middle ps-5" scope="col" style="width:120px;">SỐ LƯỢNG
                                            </th>
                                            <th class="sort align-middle text-end" scope="col" style="width:150px;">TỔNG
                                            </th>
                                            <th class="sort text-end align-middle pe-0" scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="cart-table-body">
                                        @foreach ($cartItems as $item)
                                            <tr class="cart-table-row btn-reveal-trigger">
                                                <td class="align-middle white-space-nowrap py-0">
                                                    <a class="d-block border border-translucent rounded-2" href="#">
                                                        <img src="{{ $item->variation->product->images->first() ? asset('storage/' . $item->variation->product->images->first()->image_path) : '/assets/img/products/1.png' }}"
                                                            alt="" width="53">
                                                    </a>
                                                </td>
                                                <td class="products align-middle">
                                                    <a class="fw-semibold mb-0 line-clamp-2" href="#">
                                                        {{ $item->variation->product->name ?? '' }}
                                                    </a>
                                                </td>
                                                <td class="color align-middle white-space-nowrap fs-9 text-body">
                                                    {{ $item->variation->color->name ?? 'Không có' }}
                                                </td>
                                                <td
                                                    class="size align-middle white-space-nowrap text-body-tertiary fs-9 fw-semibold">
                                                    {{ $item->variation->size->name ?? 'Không có' }}
                                                </td>
                                                <td class="price align-middle text-body fs-9 fw-semibold text-end">
                                                    {{ number_format($item->variation->price, 0, ',', '.') }}₫
                                                </td>
                                                <td class="quantity align-middle fs-8 ps-5">
                                                    <div class="input-group input-group-sm flex-nowrap"
                                                        data-quantity="data-quantity">
                                                        <button class="btn btn-sm px-2 quantity-btn" data-type="minus"
                                                            data-id="{{ $item->id }}">-</button>
                                                        <input
                                                            class="form-control text-center input-spin-none bg-transparent border-0 px-0 quantity-input"
                                                            type="number" min="1"
                                                            value="{{ (int) $item->quantity }}"
                                                            data-id="{{ $item->id }}" aria-label="Số lượng"
                                                            style="width: 40px; background: transparent; border: none; box-shadow: none; outline: none;" />
                                                        <button class="btn btn-sm px-2 quantity-btn" data-type="plus"
                                                            data-id="{{ $item->id }}">+</button>
                                                    </div>
                                                </td>
                                                <td class="total align-middle fw-bold text-body-highlight text-end">
                                                    {{ number_format($item->variation->price * (int) $item->quantity, 0, ',', '.') }}₫
                                                </td>
                                                <td class="align-middle white-space-nowrap text-end pe-0 ps-3">
                                                    <form action="{{ route('client.cart.remove', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')"
                                                        style="display: inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm text-body-tertiary text-opacity-85 text-body-tertiary-hover me-2">
                                                            <span class="fas fa-trash"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="cart-table-row btn-reveal-trigger">
                                            <td class="text-body-emphasis fw-semibold ps-0 fs-8" colspan="6">Tổng tiền
                                                hàng :</td>
                                            <td class="text-body-emphasis fw-bold text-end fs-8 cart-total">
                                                {{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int) $item->quantity), 0, ',', '.') }}₫
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-between-center mb-3">
                                    <h3 class="card-title mb-0">Tóm tắt</h3><a class="btn btn-link p-0"
                                        href="{{ route('client.cart.index') }}">Chỉnh sửa giỏ hàng</a>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Tổng tiền hàng :</p>
                                        <p class="text-body-emphasis fw-semibold summary-subtotal">
                                            {{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int) $item->quantity), 0, ',', '.') }}₫
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Giảm giá :</p>
                                        <p class="text-danger fw-semibold summary-discount">
                                            -{{ number_format(0, 0, ',', '.') }}₫</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-body fw-semibold">Tạm tính :</p>
                                        <p class="text-body-emphasis fw-semibold summary-temp">
                                            {{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int) $item->quantity), 0, ',', '.') }}₫
                                        </p>
                                    </div>
                                </div>
                                <div class="input-group mb-3"><input class="form-control" type="text"
                                        placeholder="Mã giảm giá" id="voucherInput" autocomplete="off"><button
                                        class="btn btn-phoenix-primary px-5 apply-voucher-btn">Áp dụng</button></div>
                                <div class="d-flex justify-content-between border-y border-dashed py-3 mb-4">
                                    <h4 class="mb-0">Tổng cộng :</h4>
                                    <h4 class="mb-0 summary-total">
                                        {{ number_format($cartItems->sum(fn($item) => $item->variation->price * (int) $item->quantity), 0, ',', '.') }}₫
                                    </h4>
                                </div>
                                <a href="{{ route('client.cart.checkout.form') }}" class="btn btn-primary w-100">
                                    Tiến hành thanh toán
                                    <span class="fas fa-chevron-right ms-1 fs-10"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div><!-- end of .container-->
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove all old event listeners if any
            document.querySelectorAll('.quantity-btn').forEach(function(btn) {
                btn.onclick = null;
            });
            document.querySelectorAll('.quantity-input').forEach(function(input) {
                input.onchange = null;
            });

            // Add new event listeners
            document.querySelectorAll('.quantity-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var input = this.parentElement.querySelector('.quantity-input');
                    var currentValue = parseInt(input.value);
                    var type = this.dataset.type;
                    var newValue = currentValue;
                    if (type === 'plus') {
                        newValue = currentValue + 0;
                    } else if (type === 'minus' && currentValue > 1) {
                        newValue = currentValue - 0;
                    }
                    input.value = newValue;
                    updateQuantity(input.dataset.id, newValue, input);
                });
            });

            document.querySelectorAll('.quantity-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    updateQuantity(this.dataset.id, this.value, this);
                });
            });

            function updateQuantity(id, quantity, inputEl) {
                fetch('/client/cart/update/' + id, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update row total
                            if (data.item_total) {
                                let totalTd = inputEl.closest('tr').querySelector('.total');
                                if (totalTd) totalTd.textContent = data.item_total + '₫';
                            }
                            // Update cart total (dưới bảng)
                            document.querySelectorAll('.cart-total').forEach(function(el) {
                                el.textContent = data.cart_total + '₫';
                            });
                            // Update summary total (phần tóm tắt)
                            document.querySelectorAll('.summary-total').forEach(function(el) {
                                el.textContent = data.cart_total + '₫';
                            });
                            // Update summary subtotal (tổng tiền hàng ở tóm tắt)
                            document.querySelectorAll('.summary-subtotal').forEach(function(el) {
                                el.textContent = data.cart_total + '₫';
                            });
                            // Update summary temp (tạm tính ở tóm tắt)
                            document.querySelectorAll('.summary-temp').forEach(function(el) {
                                el.textContent = data.cart_total + '₫';
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            const voucherInput = document.getElementById('voucherInput');
            const voucherDropdown = document.getElementById('voucherDropdown');

            voucherInput.addEventListener('focus', function() {
                voucherDropdown.classList.add('show');
            });

            voucherInput.addEventListener('input', function() {
                const val = this.value.toLowerCase();
                voucherDropdown.querySelectorAll('.dropdown-item').forEach(function(item) {
                    const code = item.dataset.code.toLowerCase();
                    if (code.includes(val)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
                voucherDropdown.classList.add('show');
            });

            voucherDropdown.querySelectorAll('.dropdown-item').forEach(function(item) {
                item.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    voucherInput.value = this.dataset.code;
                    voucherDropdown.classList.remove('show');
                });
            });

            document.addEventListener('mousedown', function(e) {
                if (!voucherInput.contains(e.target) && !voucherDropdown.contains(e.target)) {
                    voucherDropdown.classList.remove('show');
                }
            });

            const applyBtn = document.querySelector('.apply-voucher-btn');
            const discountElement = document.querySelector('.summary-discount');
            const totalElement = document.querySelector('.summary-total');
            const subtotal = {{ $cartItems->sum(fn($item) => $item->variation->price * (int) $item->quantity) }};

            applyBtn.addEventListener('click', function() {
                const code = voucherInput.value.trim();
                if (!code) return;

                fetch('/client/cart/apply-voucher', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            voucher_code: code
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật giảm giá và tổng cộng
                            const discount = data.voucher.discount_amount;
                            discountElement.textContent = '-' + Math.abs(discount).toLocaleString(
                                'vi-VN') + '₫';
                            totalElement.textContent = (subtotal - discount).toLocaleString('vi-VN') +
                                '₫';
                        } else {
                            discountElement.textContent = '-0₫';
                            totalElement.textContent = subtotal.toLocaleString('vi-VN') + '₫';
                            // Có thể hiện thông báo lỗi
                        }
                    });
            });
        });
    </script>
@endpush
