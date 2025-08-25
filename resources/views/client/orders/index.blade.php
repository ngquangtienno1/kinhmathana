@extends('client.layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">Đơn hàng của tôi</h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                        <a itemprop="url" class="qodef-breadcrumbs-link" href="/">
                            <span itemprop="title">Trang chủ</span>
                        </a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Đơn hàng của tôi</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template" role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div class="container py-4">
                            <div class="order-header-flex">
                                <nav class="order-tabs">
                                    @foreach ($tabs as $tab)
                                        @php
                                            $isActive = ($status ?? null) === $tab['status'];
                                            $query = array_filter(['status' => $tab['status'], 'q' => request('q')]);
                                        @endphp
                                        <a href="{{ route('client.orders.index', $query) }}"
                                            class="{{ $isActive ? 'active' : '' }}">
                                            {{ $tab['label'] }}
                                        </a>
                                    @endforeach
                                </nav>
                                <div class="order-search"
                                    style="display: flex; align-items: center; justify-content: flex-end; position: relative;">
                                    <span id="show-search-btn"
                                        style="display: inline-flex; align-items: center; cursor: pointer; font-size: 22px; color: #222;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8" />
                                            <path d="M21 21l-4.35-4.35" />
                                        </svg>
                                    </span>
                                    <form id="order-search-form" method="get" action="{{ route('client.orders.index') }}"
                                        style="display: none; position: absolute; right: 0; top: 120%; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 6px; padding: 8px 12px; z-index: 10; min-width: 260px;">
                                        <input type="text" name="q" value="{{ request('q') }}"
                                            placeholder="Tìm theo Mã đơn hàng hoặc Sản phẩm"
                                            style="width: 160px; height: 36px; padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
                                        <button type="submit"
                                            style="height: 36px; padding: 0 14px; background: #222; color: #fff; border: none; border-radius: 4px; margin-left: 6px;">Tìm</button>
                                        @if (request('status'))
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                        @endif
                                    </form>
                                </div>
                            </div>
                            @forelse($orders as $order)
                                <div class="order-card-shopee">
                                    <div class="order-card-header">
                                        <div class="order-number-header">
                                            <b>Mã đơn hàng: #{{ $order->order_number }}</b>
                                        </div>
                                        <div class="order-status">
                                            <span
                                                class="status-label status-{{ $order->status }}">{{ $order->status_label }}</span>
                                        </div>
                                    </div>
                                    <div class="order-card-products">
                                        @foreach ($order->items as $item)
                                            @php
                                                $product = $item->variation
                                                    ? $item->variation->product
                                                    : $item->product ?? null;
                                                if ($item->variation && $item->variation->images->count()) {
                                                    $featuredImage =
                                                        $item->variation->images->where('is_featured', true)->first() ??
                                                        $item->variation->images->first();
                                                } else {
                                                    $featuredImage =
                                                        $product && isset($product->images)
                                                            ? $product->images->where('is_featured', true)->first() ??
                                                                $product->images->first()
                                                            : null;
                                                }
                                                $imagePath = $featuredImage
                                                    ? asset('storage/' . $featuredImage->image_path)
                                                    : asset('/assets/img/products/1.png');
                                            @endphp
                                            <div class="order-product-row">
                                                <a href="{{ route('client.orders.show', $order->id) }}"
                                                    style="display: flex; align-items: center; text-decoration: none; color: inherit; flex: 1;">
                                                    <img src="{{ $imagePath }}"
                                                        alt="{{ $product->name ?? 'Sản phẩm đã xóa' }}">
                                                    <div class="product-info">
                                                        <div class="product-name">{{ $item->product_name }}</div>
                                                        @php
                                                            $options = [];
                                                            if (is_string($item->product_options)) {
                                                                $options = json_decode($item->product_options, true);
                                                            } elseif (is_array($item->product_options)) {
                                                                $options = $item->product_options;
                                                            }
                                                            $optionTexts = [];
                                                            if (!empty($options)) {
                                                                if (array_key_exists('color', $options)) {
                                                                    $optionTexts[] = trim($options['color']);
                                                                }
                                                                if (array_key_exists('size', $options)) {
                                                                    $optionTexts[] = trim($options['size']);
                                                                }
                                                                if (array_key_exists('spherical', $options)) {
                                                                    $optionTexts[] = trim($options['spherical']);
                                                                }
                                                                if (array_key_exists('cylindrical', $options)) {
                                                                    $optionTexts[] = trim($options['cylindrical']);
                                                                }
                                                            }
                                                            $optionTexts = array_filter($optionTexts, function ($v) {
                                                                return $v !== null && $v !== '' && $v !== '-';
                                                            });
                                                        @endphp
                                                        @if (!empty($optionTexts))
                                                            <div class="product-variation">Phân loại:
                                                                {{ implode(' - ', $optionTexts) }}</div>
                                                        @elseif (isset($item->variation_name) && $item->variation_name)
                                                            <div class="product-variation">Phân loại:
                                                                {{ $item->variation_name }}</div>
                                                        @endif
                                                        <div class="product-qty">x{{ $item->quantity }}</div>
                                                    </div>
                                                </a>
                                                <div class="product-price">{{ number_format($item->price, 0, ',', '.') }}₫
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="order-card-footer">
                                        <div class="order-footer-right">
                                            <div class="order-total">
                                                Thành tiền: <span
                                                    class="total-amount">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                                            </div>
                                            <div class="order-actions">
                                                @if ($order->status == 'delivered')
                                                    <form
                                                        action="{{ route('client.orders.confirm-received', $order->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn xác nhận đã nhận hàng?')"
                                                        style="display:inline;">
                                                        @csrf @method('PATCH')
                                                        <button>Đã Nhận Hàng</button>
                                                    </form>
                                                @endif
                                                <div class="order-action-buttons">
                                                    @if ($order->status == 'completed')
                                                        <form action="{{ route('client.orders.reorder', $order->id) }}"
                                                            method="POST" style="display:inline; margin:0;">
                                                            @csrf
                                                            <button type="submit" class="btn">Mua lại</button>
                                                        </form>
                                                    @endif
                                                    @if (in_array($order->status, ['pending', 'confirmed', 'awaiting_pickup']))
                                                        <button type="button" class="btn btn-black btn-cancel-order"
                                                            data-order-id="{{ $order->id }}">Huỷ đơn hàng</button>
                                                        <form id="cancel-order-form-{{ $order->id }}"
                                                            action="{{ route('client.orders.cancel', $order->id) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="cancellation_reason_id"
                                                                value="">
                                                        </form>
                                                    @endif
                                                    <button class="btn btn-outline-black">Liên Hệ Người Bán</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div> Bạn chưa có đơn hàng nào. </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @php
        $cancelReasons = \App\Models\CancellationReason::where([
            'type' => 'admin',
            'is_active' => true,
        ])->orderByDesc('is_default')->get(['id', 'reason']);
    @endphp
    <!-- Modal chọn lý do huỷ -->
    <div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReasonModalLabel">Chọn lý do huỷ đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancel-reason-select" class="form-label">Lý do huỷ <span
                                class="text-danger">*</span></label>
                        <select class="form-select" id="cancel-reason-select">
                            <option value="">-- Chọn lý do huỷ --</option>
                            @foreach ($cancelReasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                            @endforeach
                            <option value="other">-- Khác (Nhập lý do mới) --</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="cancel-reason-other"
                            placeholder="Nhập lý do huỷ mới">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="confirm-cancel-reason">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            let currentCancelOrderId = null;
            document.addEventListener('DOMContentLoaded', function() {
                // Lấy lý do huỷ khi mở modal
                document.querySelectorAll('.btn-cancel-order').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        currentCancelOrderId = this.getAttribute('data-order-id');
                        // Reset select và input mỗi lần mở popup
                        let select = document.getElementById('cancel-reason-select');
                        select.value = '';
                        document.getElementById('cancel-reason-other').classList.add('d-none');
                        document.getElementById('cancel-reason-other').value = '';
                        var modal = new bootstrap.Modal(document.getElementById('cancelReasonModal'));
                        modal.show();
                    });
                });
                // Hiện ô nhập lý do mới nếu chọn "other"
                document.getElementById('cancel-reason-select').addEventListener('change', function() {
                    if (this.value === 'other') {
                        document.getElementById('cancel-reason-other').classList.remove('d-none');
                    } else {
                        document.getElementById('cancel-reason-other').classList.add('d-none');
                    }
                });
                // Xác nhận lý do huỷ
                document.getElementById('confirm-cancel-reason').addEventListener('click', function() {
                    let select = document.getElementById('cancel-reason-select');
                    let other = document.getElementById('cancel-reason-other');
                    let value = select.value;
                    if (!value) {
                        select.classList.add('is-invalid');
                        return;
                    }
                    select.classList.remove('is-invalid');
                    let reasonValue = value;
                    if (value === 'other') {
                        if (!other.value.trim()) {
                            other.classList.add('is-invalid');
                            return;
                        }
                        other.classList.remove('is-invalid');
                        reasonValue = 'other:' + other.value.trim();
                    }
                    // Submit form
                    let form = document.getElementById('cancel-order-form-' + currentCancelOrderId);
                    form.querySelector('input[name="cancellation_reason_id"]').value = reasonValue;
                    form.submit();
                });
            });
        </script>
    @endpush

@endsection
<style>
    /* Tabs trạng thái */
    .order-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 2px;
    }

    .order-header-flex .order-tabs {
        margin-bottom: 0;
        flex: 1 1 auto;
        min-width: 0;
    }

    .order-header-flex .order-search {
        margin-bottom: 0;
        min-width: 220px;
        max-width: 320px;
        width: 100%;
        margin-top: 6px;
        /* Thấp xuống một chút */
    }

    .order-header-flex .order-search form {
        width: 100%;
    }

    .order-tabs {
        display: flex;
        gap: 24px;
        /* border-bottom: 2px solid #f0f0f0; */
        margin-bottom: 0;
        overflow-x: auto;
    }

    .order-tabs a {
        padding: 10px 0;
        font-size: 15px;
        color: #555;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .order-tabs a:hover {
        color: #222;
    }

    .order-tabs a.active {
        color: #222;
        font-weight: 600;
        border-bottom: 2px solid #222;
    }

    /* Tìm kiếm */
    .order-search {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
    }

    .order-search input[type="text"] {
        flex: 1;
        height: 40px;
        padding: 8px 12px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }


    .order-search button {
        height: 40px;
        padding: 0 16px;
        background-color: #222;
        color: white;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 0 6px 6px 0;
        cursor: pointer;
        display: inline-block;
        vertical-align: middle;
        align-items: center
    }

    .order-search button:hover {
        background-color: #222;
    }

    /* Shopee style order card - tone trắng đen */
    .order-card-shopee {
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        margin-bottom: 24px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .order-card-header,
    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
        padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-card-footer {
        border-top: 1px solid #f0f0f0;
        border-bottom: none;
    }

    .shop-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-chat,
    .btn-view-shop {
        background: #fff;
        border: 1px solid #222;
        color: #222;
        border-radius: 4px;
        padding: 2px 10px;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .btn-chat:hover,
    .btn-view-shop:hover {
        background: #222;
        color: #fff;
    }

    .status-label {
        font-weight: 700;
        font-size: 15px;
        border-radius: 4px;
        padding: 4px 16px;
        display: inline-block;
        border: 1px solid transparent;
        margin-bottom: 2px;
    }

    .status-label.status-completed,
    .status-label.status-confirmed,
    .status-label.status-pending,
    .status-label.status-awaiting_pickup,
    .status-label.status-shipping,
    .status-label.status-delivered {
        background: #e6f9ed;
        color: #219150;
        border: 1px solid #219150;
        box-shadow: 0 1px 4px rgba(33, 145, 80, 0.08);
    }

    .status-label.status-cancelled_by_customer,
    .status-label.status-cancelled_by_admin,
    .status-label.status-delivery_failed {
        background: #ffeaea;
        color: #e53935;
        border: 1px solid #e53935;
        box-shadow: 0 1px 4px rgba(229, 57, 53, 0.08);
    }

    .order-card-products {
        padding: 0 16px;
    }

    .order-product-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        padding: 16px 0;
    }

    .order-product-row:last-child {
        border-bottom: none;
    }

    .order-product-row img {
        width: 60px;
        height: 60px;
        border-radius: 4px;
        margin-right: 16px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 500;
        color: #222;
    }

    .product-variation {
        color: #888;
        font-size: 13px;
    }

    .product-qty {
        color: #888;
        font-size: 13px;
    }

    .product-price {
        min-width: 100px;
        text-align: right;
        color: #222;
        font-weight: 600;
    }

    .order-total {
        font-weight: 500;
        color: #222;
        margin: 18px 0 18px 0;
        /* Tăng khoảng cách trên dưới */
        font-size: 18px;
    }

    .total-amount {
        color: #e53935;
        font-size: 22px;
        font-weight: 800;
        margin-left: 8px;
        vertical-align: middle;
    }

    .order-actions button {
        background: #222;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 6px 16px;
        margin-left: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s, color 0.2s;
    }

    .order-actions button:hover {
        background: #111;
        color: #fff;
    }

    .order-actions button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    .order-footer-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        width: 100%;
    }

    .order-total {
        font-weight: 500;
        color: #222;
    }

    .order-actions {
        display: flex;
        gap: 8px;
    }

    .btn-black,
    .btn-outline-black {
        background: #222 !important;
        color: #fff !important;
        border: 1px solid #222 !important;
        border-radius: 4px;
        padding: 6px 18px;
        font-size: 14px;
        font-weight: 600;
        min-width: 120px;
        text-align: center;
        line-height: 1.2;
        letter-spacing: 0;
        text-transform: none;
        margin-right: 8px;
    }

    .btn-outline-black {
        background: #fff !important;
        color: #222 !important;
    }

    .btn-black:hover,
    .btn-outline-black:hover {
        background: #111 !important;
        color: #fff !important;
    }

    .order-action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-action-buttons form {
        display: inline;
        margin: 0;
    }
</style>
