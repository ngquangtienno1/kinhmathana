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
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template" role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div class="container py-4">
                            {{-- Tabs trạng thái --}}
                            @php
                                $tabs = [
                                    ['label' => 'Tất cả', 'status' => null],
                                    ['label' => 'Chờ xác nhận', 'status' => 'pending'],
                                    ['label' => 'Đã xác nhận', 'status' => 'confirmed'],
                                    ['label' => 'Chờ lấy hàng', 'status' => 'awaiting_pickup'],
                                    ['label' => 'Đang giao', 'status' => 'shipping'],
                                    ['label' => 'Đã giao hàng', 'status' => 'delivered'],
                                    ['label' => 'Đã hoàn thành', 'status' => 'completed'],
                                    ['label' => 'Đã hủy', 'status' => 'cancelled'],
                                ];
                            @endphp

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

                            {{-- Tìm kiếm --}}
                            <div class="order-search">
                                <form method="get" action="{{ route('client.orders.index') }}"
                                    style="display: flex; width: 100%;">
                                    <input type="text" name="q" value="{{ request('q') }}"
                                        placeholder="Tìm theo Mã đơn hàng hoặc Sản phẩm">
                                    <button type="submit">Tìm kiếm</button>
                                    @if (request('status'))
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                    @endif
                                </form>
                            </div>
                            @forelse($orders as $order)
                                <div class="order-card">
                                    <div class="order-header">
                                        <span>Mã đơn hàng: <b>{{ $order->order_number }}</b></span>
                                        <span>Ngày đặt:
                                            {{ $order->created_at ? $order->created_at->format('d/m/Y') : '' }}</span>
                                    </div>

                                    <div class="order-items">
                                        @foreach ($order->items as $item)
                                            <div class="order-item">
                                                <img
                                                    src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_path) : '/assets/img/products/1.png' }}">
                                                <div class="order-item-details">
                                                    <div class="name">{{ $item->product_name }}</div>
                                                    <div style="color: #888;">Số lượng: {{ $item->quantity }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="order-footer">
                                        <div class="total">Tổng: {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                        </div>
                                        <div class="actions">
                                            <a href="{{ route('client.orders.show', $order->id) }}">Xem chi tiết</a>
                                            @if ($order->status == 'delivered')
                                                <form action="{{ route('client.orders.confirm-received', $order->id) }}"
                                                    method="POST" onsubmit="return confirm('Bạn xác nhận đã nhận hàng?')"
                                                    style="display:inline;">
                                                    @csrf @method('PATCH')
                                                    <button type="submit">Đã nhận hàng</button>
                                                </form>
                                            @endif
                                            @if ($order->status == 'pending')
                                                <form action="{{ route('client.orders.cancel', $order->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')"
                                                    style="display:inline;">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="btn-cancel-order">Hủy đơn hàng</button>
                                                </form>
                                            @endif
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

@endsection
<style>
    /* Tabs trạng thái */
    .order-tabs {
        display: flex;
        gap: 24px;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 20px;
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

    .order-card {
        border: 1px solid #e5e5e5;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        background-color: #fff;
    }

    .order-header {
        background-color: #f7f7f7;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        border-bottom: 1px solid #e5e5e5;
    }

    .order-items {
        padding: 0 16px;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item img {
        width: 60px;
        height: 60px;
        border-radius: 4px;
        margin-right: 16px;
        object-fit: cover;
    }

    .order-item-details {
        flex: 1;
    }

    .order-item-details .name {
        font-weight: 500;
        margin-bottom: 4px;
    }

    .order-footer {
        background-color: #fafafa;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e5e5e5;
    }

    .order-footer .total {
        font-weight: bold;
        color: #333;
    }

    .order-footer .actions {
        display: flex;
        gap: 10px;
    }

    .order-footer .actions button {
        text-transform: none;
        font-family: Heebo, sans-serif;
        /* hoặc font khác so với nút còn lại */
    }

    .order-footer .actions button:nth-child(2) {
        text-transform: none;
        font-family: Heebo, sans-serif;
        /* hoặc font khác so với nút còn lại */
    }

    .btn-cancel-order {
    background-color: #222;
    color: white;
    padding: 8px 16px;
    border: none;
    
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}


.btn-cancel-order:hover {
    background-color: #ee4d2d;
}


    .order-footer .actions a,
    .order-footer .actions button {
        padding: 6px 12px;
        border: none;
        background-color: #222;
        color: white;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .order-footer .actions button:hover,
    .order-footer .actions a:hover {
        background-color: #d94426;
    }

    .order-footer .actions button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
</style>
