@extends('client.layouts.app')

@section('content')
    <style>
        .custom-quantity-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
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

        /* Thêm border cho bảng giỏ hàng */
        .shop_table,
        .shop_table th,
        .shop_table td {
            border-bottom: 1px solid #e0e0e0 !important;
        }

        .shop_table {
            border-collapse: collapse;
            width: 100%;
        }
    </style>
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
                                            <th class="product-remove"><span class="screen-reader-text">Remove
                                                    item</span></th>
                                            <th class="product-thumbnail"><span class="screen-reader-text">Thumbnail
                                                    image</span></th>
                                            <th class="product-name">Sản phẩm</th>
                                            <th class="product-price">Đơn giá</th>
                                            <th class="product-quantity">Số lượng</th>
                                            <th class="product-subtotal">Thành tiền</th>
                                        </thead>
                                        <tbody>
                                            {{-- ========================
                                                Hiển thị danh sách sản phẩm trong giỏ hàng
                                                ======================== --}}
                                            @php $rowIndex = 0; @endphp
                                            @forelse($cartItems as $item)
                                                {{-- Mỗi dòng là một sản phẩm trong giỏ hàng --}}
                                                <tr class="woocommerce-cart-form__cart-item cart_item">
                                                    <td class="product-remove">
                                                        {{-- Nút xóa sản phẩm khỏi giỏ hàng, submit form ẩn bên dưới --}}
                                                        <button type="button" class="remove btn-remove-cart-item"
                                                            data-form-id="remove-cart-item-{{ $item->id }}"
                                                            aria-label="Xóa {{ $item->variation->product->name }} khỏi giỏ hàng"
                                                            data-product_id="{{ $item->id }}"
                                                            style="background:none;border:none;padding:0;margin:0;font-size:22px;line-height:1;color:#d00;cursor:pointer;">
                                                            &times;
                                                        </button>
                                                    </td>
                                                    <td class="product-thumbnail">
                                                        {{-- Ảnh sản phẩm --}}
                                                        <a
                                                            href="{{ route('client.products.show', $item->variation->product->slug) }}">
                                                            <img src="{{ $item->variation->product->getFeaturedMedia()->path ?? '/path/to/default.jpg' }}"
                                                                width="80" alt="{{ $item->variation->product->name }}">
                                                        </a>
                                                    </td>
                                                    <td class="product-name" data-title="Sản phẩm">
                                                        {{-- Tên sản phẩm và phân loại (nếu có) --}}
                                                        <a
                                                            href="{{ route('client.products.show', $item->variation->product->slug) }}">
                                                            {{ $item->variation->product->name }}
                                                        </a>
                                                        <div>
                                                            @if ($item->variation && $item->variation->name)
                                                                <small>Phân loại: {{ $item->variation->name }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="product-price" data-title="Đơn giá">
                                                        {{-- Hiển thị giá bán (ưu tiên giá khuyến mãi nếu có) --}}
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>{{ number_format($item->variation ? $item->variation->sale_price ?? $item->variation->price : $cartProduct->sale_price ?? $cartProduct->price, 0, ',', '.') }}₫</bdi>
                                                        </span>
                                                    </td>
                                                    <td class="product-quantity" data-title="Số lượng">
                                                        {{-- Nhóm nút tăng/giảm và input số lượng --}}
                                                        <div class="qodef-quantity-buttons quantity"
                                                            data-id="{{ $item->id }}">
                                                            <label class="screen-reader-text"
                                                                for="quantity_{{ $item->id }}">
                                                                {{ $item->variation->product->name }} số lượng
                                                            </label>
                                                            <span class="qodef-quantity-minus"></span>
                                                            <input type="text" id="quantity_{{ $item->id }}"
                                                                class="input-text qty text qodef-quantity-input"
                                                                data-step="1" data-min="1"
                                                                data-stock="{{ $item->variation->stock }}"
                                                                name="cart[{{ $item->id }}][qty]"
                                                                value="{{ $item->quantity }}" title="Số lượng"
                                                                size="4" placeholder="" inputmode="numeric">
                                                            <span class="qodef-quantity-plus"></span>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal" data-title="Thành tiền">
                                                        {{-- Thành tiền = đơn giá * số lượng --}}
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
                                                // Tính tổng tạm tính (chưa giảm giá)
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
                                                <td data-title="Giảm giá"><span class="woocommerce-Price-amount amount"><bdi
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý tăng/giảm số lượng sản phẩm
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
                            input.value = val - 0;
                            input.dispatchEvent(new Event('change'));
                        }
                    });
                }
                if (plus) {
                    plus.addEventListener('click', function() {
                        let val = parseInt(input.value) || 1;
                        // Lấy số lượng tồn kho từ thuộc tính data-stock
                        let maxStock = parseInt(input.getAttribute('data-stock')) || 1;
                        if (val < maxStock) {
                            input.value = val + 1;
                            input.dispatchEvent(new Event('change'));
                        } else {
                            input.value = maxStock;
                            alert('Số lượng vượt quá tồn kho!');
                        }
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

            // Hàm gửi request cập nhật số lượng sản phẩm lên server
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
                            // Cập nhật lại thành tiền và tổng tiền trên giao diện
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

            // Xử lý nút xóa sản phẩm khỏi giỏ hàng
            document.querySelectorAll('.btn-remove-cart-item').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var formId = btn.getAttribute('data-form-id');
                    var form = document.getElementById(formId);
                    if (form) form.submit();
                });
            });
        });
    </script>
@endpush
