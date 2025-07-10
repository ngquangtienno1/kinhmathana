@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Giỏ hàng </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="../index.html"><span itemprop="title">Trang chủ</span></a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">Giỏ hàng</span></div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div class="woocommerce">
                            <div id="qodef-woo-page" class="qodef--cart">
                                <div class="woocommerce-notices-wrapper"></div>
                                <form class="woocommerce-cart-form" action="https://neoocular.qodeinteractive.com/cart/"
                                    method="post">

                                    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="screen-reader-text">Remove
                                                        item</span></th>
                                                <th class="product-thumbnail"><span class="screen-reader-text">Thumbnail
                                                        image</span></th>
                                                <th class="product-name">Sản phẩm</th>
                                                <th class="product-price">Đơn giá</th>
                                                <th class="product-quantity">Số lượng</th>
                                                <th class="product-subtotal">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $rowIndex = 0; @endphp
                                            @forelse($cartItems as $item)
                                                @php
                                                    $cartProduct = $item->variation
                                                        ? $item->variation->product
                                                        : $item->product;
                                                    $featuredImage =
                                                        $cartProduct->images->where('is_featured', true)->first() ??
                                                        $cartProduct->images->first();
                                                    $imagePath = $featuredImage
                                                        ? asset('storage/' . $featuredImage->image_path)
                                                        : asset('/path/to/default.jpg');
                                                    $maxQty = $item->variation
                                                        ? $item->variation->stock_quantity
                                                        : $cartProduct->total_stock_quantity;
                                                @endphp
                                                <tr class="woocommerce-cart-form__cart-item cart_item">
                                                    <td class="product-remove">
                                                        <button type="button" class="remove btn-remove-cart-item"
                                                            data-form-id="remove-cart-item-{{ $item->id }}"
                                                            aria-label="Xóa {{ $cartProduct->name }} khỏi giỏ hàng"
                                                            data-product_id="{{ $item->id }}"
                                                            style="background:none;border:none;padding:0;margin:0;font-size:22px;line-height:1;color:#d00;cursor:pointer;">
                                                            &times;
                                                        </button>
                                                    </td>
                                                    <td class="product-thumbnail">
                                                        <a href="{{ route('client.products.show', $cartProduct->slug) }}">
                                                            <img src="{{ $imagePath }}" width="80"
                                                                alt="{{ $cartProduct->name }}">
                                                        </a>
                                                    </td>
                                                    <td class="product-name" data-title="Sản phẩm">
                                                        <a href="{{ route('client.products.show', $cartProduct->slug) }}">
                                                            {{ $cartProduct->name }}
                                                        </a>
                                                        <div>
                                                            @if ($item->variation && $item->variation->name)
                                                                <small>Phân loại: {{ $item->variation->name }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="product-price" data-title="Đơn giá">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>{{ number_format($item->variation ? $item->variation->sale_price ?? $item->variation->price : $cartProduct->sale_price ?? $cartProduct->price, 0, ',', '.') }}₫</bdi>
                                                        </span>
                                                    </td>
                                                    <td class="product-quantity" data-title="Số lượng">
                                                        <div class="qodef-quantity-buttons quantity"
                                                            data-id="{{ $item->id }}">
                                                            <label class="screen-reader-text"
                                                                for="quantity_{{ $item->id }}">
                                                                {{ $cartProduct->name }} số lượng
                                                            </label>
                                                            <span class="qodef-quantity-minus"></span>
                                                            <input type="text" id="quantity_{{ $item->id }}"
                                                                class="input-text qty text qodef-quantity-input"
                                                                data-step="1" data-min="1"
                                                                data-max="{{ $maxQty }}" name="quantity"
                                                                value="{{ $item->quantity }}" title="Số lượng"
                                                                size="4" placeholder="" inputmode="numeric">
                                                            <span class="qodef-quantity-plus"></span>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal" data-title="Thành tiền">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>{{ number_format(($item->variation ? $item->variation->sale_price ?? $item->variation->price : $cartProduct->sale_price ?? $cartProduct->price) * $item->quantity, 0, ',', '.') }}₫</bdi>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">Giỏ hàng của bạn đang trống.</td>
                                                </tr>
                                            @endforelse

                                            <tr>
                                                <td colspan="6" class="actions">
                                                    <div class="coupon" style="position:relative;">
                                                        <label for="coupon_code" class="screen-reader-text">Mã giảm
                                                            giá:</label>
                                                        <input type="text" name="coupon_code" class="input-text"
                                                            id="coupon_code" value="" placeholder="Nhập mã giảm giá"
                                                            autocomplete="off" />
                                                        <ul id="coupon-suggestions"
                                                            style="display:none;position:absolute;top:100%;left:0;right:0;z-index:10;background:#fff;border:1px solid #ddd;list-style:none;padding:0;margin:5px 0 0 0;max-height:180px;overflow:auto;">
                                                            @foreach ($promotions as $promo)
                                                                <li class="coupon-suggestion-item"
                                                                    data-code="{{ $promo->code }}"
                                                                    style="padding:6px 12px;cursor:pointer;">
                                                                    {{ $promo->code }} - {{ $promo->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="button" id="apply-coupon-btn"
                                                            name="apply_coupon" value="Áp dụng">Áp dụng</button>
                                                    </div>
                                                    <button type="submit" class="button" name="update_cart"
                                                        value="Cập nhật giỏ hàng">Cập nhật giỏ hàng</button>
                                                    <input type="hidden" id="woocommerce-cart-nonce"
                                                        name="woocommerce-cart-nonce" value="665c378ca6" />
                                                    <input type="hidden" name="_wp_http_referer" value="/cart/" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>

                                <!-- Render các form xóa ẩn ngoài form lớn -->
                                @foreach ($cartItems as $item)
                                    <form id="remove-cart-item-{{ $item->id }}"
                                        action="{{ route('client.cart.remove', $item->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endforeach

                                <div class="cart-collaterals">
                                    <div class="cart_totals ">


                                        <h2>Tổng giỏ hàng</h2>

                                        <table cellspacing="0" class="shop_table shop_table_responsive">
                                            @php
                                                $subtotal = $cartItems->sum(function ($item) {
                                                    $cartProduct = $item->variation
                                                        ? $item->variation->product
                                                        : $item->product;
                                                    return ($item->variation
                                                        ? $item->variation->sale_price ?? $item->variation->price
                                                        : $cartProduct->sale_price ?? $cartProduct->price) *
                                                        $item->quantity;
                                                });
                                            @endphp
                                            <tr class="cart-subtotal">
                                                <th>Tạm tính</th>
                                                <td data-title="Tạm tính"><span
                                                        class="woocommerce-Price-amount amount"><bdi>{{ number_format($subtotal, 0, ',', '.') }}₫</bdi></span>
                                                </td>
                                            </tr>
                                            <tr class="cart-discount" style="display:none;">
                                                <th>Giảm giá</th>
                                                <td data-title="Giảm giá"><span
                                                        class="woocommerce-Price-amount amount"><bdi
                                                            id="discount-amount">0₫</bdi></span></td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Tổng cộng</th>
                                                <td data-title="Tổng cộng"><strong><span
                                                            class="woocommerce-Price-amount amount"><bdi>{{ number_format($subtotal, 0, ',', '.') }}₫</bdi></span></strong>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="wc-proceed-to-checkout">

                                            <a href="{{ route('client.cart.checkout') }}"
                                                class="checkout-button button alt wc-forward">
                                                Thanh toán</a>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div><!-- close #qodef-page-inner div from header.php -->
    </div>
@endsection

@push('scripts')
    <style>
        .custom-quantity-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .custom-quantity-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #ddd;
            background: #fff;
            color: #222;
            font-size: 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .custom-quantity-btn:hover {
            background: #222;
            color: #fff;
            border: 1px solid #222;
        }

        .custom-quantity-input {
            width: 48px;
            height: 32px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            margin: 0 2px;
        }

        #coupon-suggestions,
        .coupon-list {
            max-width: 385px;
            width: 100%;
            margin: 0;
            padding: 8px 16px;
            border-radius: 6px;
            box-sizing: border-box;
            background: #fff;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.qodef-quantity-buttons').forEach(function(group) {
                const minus = group.querySelector('.qodef-quantity-minus');
                const plus = group.querySelector('.qodef-quantity-plus');
                const input = group.querySelector('input');
                const id = group.getAttribute('data-id');
                let max = input.getAttribute('data-max');
                max = max ? parseInt(max) : null;

                if (minus) {
                    minus.addEventListener('click', function() {
                        let val = parseInt(input.value) || 1;
                        if (val > 1) {
                            input.value = val - 1;
                            updateCart(id, input.value, group);
                        }
                    });
                }
                if (plus) {
                    plus.addEventListener('click', function() {
                        let val = parseInt(input.value) || 1;
                        if (max && val >= max) {
                            showCartAlert('Số lượng đã đạt tối đa tồn kho!', 'danger');
                            input.value = max;
                            return;
                        }
                        input.value = val + 1;
                        updateCart(id, input.value, group);
                    });
                }
                input.addEventListener('change', function() {
                    let val = parseInt(input.value) || 1;
                    if (val < 1) val = 1;
                    if (max && val > max) {
                        showCartAlert('Số lượng đã đạt tối đa tồn kho!', 'danger');
                        val = max;
                    }
                    input.value = val;
                    updateCart(id, val, group);
                });
            });

            // Hàm hiển thị alert-danger trên trang giỏ hàng
            function showCartAlert(message, type) {
                // Xóa alert cũ nếu có
                let old = document.querySelector('.cart-alert');
                if (old) old.remove();
                let alert = document.createElement('div');
                alert.className = 'alert alert-' + type + ' cart-alert';
                alert.style =
                    'position: fixed; top: 100px; right: 20px; z-index: 9999; background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb;';
                alert.innerHTML = message +
                    '<button type="button" class="close" onclick="this.parentElement.style.display=\'none\'" style="background: none; border: none; font-size: 20px; margin-left: 10px; cursor: pointer;">&times;</button>';
                document.body.appendChild(alert);
                setTimeout(function() {
                    if (alert) alert.style.display = 'none';
                }, 3000);
            }

            function updateCart(id, qty, group) {
                fetch("{{ url('client/cart/update') }}/" + id, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: qty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            group.closest('tr').querySelector('.product-subtotal bdi').innerText = data
                                .item_total + '₫';
                            document.querySelectorAll('.cart-subtotal bdi, .order-total bdi').forEach(function(
                                el) {
                                el.innerText = data.cart_total + '₫';
                            });
                        } else {
                            alert(data.message || 'Có lỗi xảy ra!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra!'));
            }

            document.querySelectorAll('.btn-remove-cart-item').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var formId = btn.getAttribute('data-form-id');
                    var form = document.getElementById(formId);
                    if (form) form.submit();
                });
            });

            // Gợi ý mã giảm giá
            const input = document.getElementById('coupon_code');
            const suggestionBox = document.getElementById('coupon-suggestions');
            const suggestionItems = suggestionBox ? suggestionBox.querySelectorAll('.coupon-suggestion-item') : [];

            if (input && suggestionBox) {
                input.addEventListener('focus', function() {
                    suggestionBox.style.display = 'block';
                });
                input.addEventListener('input', function() {
                    const val = input.value.toLowerCase();
                    suggestionItems.forEach(function(item) {
                        if (item.dataset.code.toLowerCase().includes(val)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    suggestionBox.style.display = 'block';
                });
                document.addEventListener('click', function(e) {
                    if (!suggestionBox.contains(e.target) && e.target !== input) {
                        suggestionBox.style.display = 'none';
                    }
                });
                suggestionItems.forEach(function(item) {
                    item.addEventListener('click', function() {
                        input.value = item.dataset.code;
                        suggestionBox.style.display = 'none';
                    });
                });
            }

            // Áp dụng mã giảm giá
            document.getElementById('apply-coupon-btn').addEventListener('click', function() {
                const code = input.value.trim();
                if (!code) {
                    alert('Vui lòng nhập mã giảm giá!');
                    return;
                }
                fetch("{{ route('client.cart.apply-voucher') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            voucher_code: code
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Áp dụng mã giảm giá thành công!');
                            let discount = data.voucher.discount_amount || 0;
                            let subtotal = parseInt(document.querySelector('.cart-subtotal bdi')
                                .innerText.replace(/[^0-9]/g, '')) || 0;
                            let total = subtotal - discount;
                            if (total < 0) total = 0;
                            document.querySelector('.cart-discount').style.display = '';
                            document.getElementById('discount-amount').innerText = discount
                                .toLocaleString('vi-VN') + '₫';
                            document.querySelector('.order-total bdi').innerText = total.toLocaleString(
                                'vi-VN') + '₫';
                        } else {
                            alert(data.message || 'Mã giảm giá không hợp lệ!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra!'));
            });

            var alertBox = document.querySelector('.alert-success');
            if (alertBox) {
                setTimeout(function() {
                    alertBox.style.display = 'none';
                }, 3000); // 3 giây
            }
        });
    </script>
@endpush
