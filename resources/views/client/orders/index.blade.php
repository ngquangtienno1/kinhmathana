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
                            {{-- Tabs trạng thái đơn hàng Shopee style --}}
                            <nav class="mb-4">
                                <ul class="nav nav-tabs border-0" style="gap: 17px;">
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
                                    @foreach ($tabs as $tab)
                                        <li class="nav-item">
                                            <a class="nav-link {{ ($status ?? null) === $tab['status'] ? 'active' : '' }}"
                                                href="{{ route('client.orders.index', array_filter(['status' => $tab['status'], 'q' => request('q')])) }}">
                                                {{ $tab['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                            {{-- Thanh tìm kiếm --}}
                            <div>
                                <form method="get" action="{{ route('client.orders.index') }}">
                                    <div style="display: flex; align-items: center;">
                                        <input style="margin-bottom:4px " type="text" name="q" value="{{ request('q') }}" placeholder="Tìm theo Shop, ID đơn hàng hoặc Sản phẩm">
                                        <button type="submit" style="margin-left: 8px; margin-bottom:5px; ">Tìm kiếm</button>
                                    </div>
                                    @if (request('status'))
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                    @endif
                                </form>
                            </div>

                            @forelse($orders as $order)
                                <div class="order-card mb-4 shadow-sm rounded-3 border">
                                    <div
                                        class="order-header d-flex justify-content-between align-items-center bg-light px-4 py-3 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                        </div>
                                        <div
                                            style="display: flex; align-items: center; width: 100%; justify-content: space-between;">
                                            <span style="margin: 0 16px; color: #555;">Mã đơn hàng: <b>{{ $order->order_number  }}</b></span>

                                            <span style="color: #888; font-size: 15px;">Ngày đặt: {{ $order->created_at ? $order->created_at->format('d/m/Y') : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="order-products bg-white">
                                        @php $priceColWidth = '200px'; @endphp
                                        @foreach ($order->items as $item)
                                            <div
                                                style="display: flex; align-items: center; padding: 16px 0; border-bottom: 1px solid #eee;">
                                                <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_path) : '/assets/img/products/1.png' }}"
                                                    width="60" height="60" style="margin-right: 16px;">
                                                <div style="flex: 1; display: flex; flex-direction: column;">
                                                    <div style="font-weight: bold;">{{ $item->product_name }}</div>
                                                    <div style="color: #888; display: flex; align-items: center;">
                                                        Số lượng: {{ $item->quantity }}

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div
                                        class="order-footer d-flex justify-content-between align-items-center bg-light px-4 py-3 border-top">
                                        <div
                                            style="display: flex; justify-content: flex-end; align-items: center; width: 100%;">
                                            <a href="{{ route('client.orders.show', $order->id) }}"
                                                style="background:#222; color:#fff; border:none; padding:6px 24px; border-radius:4px; text-decoration:none; font-weight:500; margin-right: 16px;">Xem
                                                chi tiết</a>
                                            @if ($order->status == 'delivered')
                                                <form action="{{ route('client.orders.confirm-received', $order->id) }}"
                                                    method="POST" class="d-inline" style="margin:0;">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        style="background:#222; color:#fff; border:none; padding:10.5px 24px; border-radius:4px; font-weight:500;"
                                                        onclick="return confirm('Bạn xác nhận đã nhận hàng?')">
                                                        <i class="fas fa-check"></i> Đã nhận hàng
                                                    </button>
                                                </form>
                                            @endif
                                            <div
                                                style="width: {{ $priceColWidth }}; text-align: right; font-weight: bold; margin-left: auto;">
                                                Tổng: <span class="total-amount">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
                            @endforelse
                            <div class="mt-4">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <style>
        .order-tabs .nav-link {
            border-radius: 20px;
            color: #222;
            background: #f5f5f5;
            margin-right: 8px;
            font-weight: 500;
            transition: background .2s, color .2s;
        }

        .order-tabs .nav-link.active {
            background: #222;
            color: #fff;
        }

        .order-card {
            border: 1.5px solid #e0e0e0 !important;
            border-radius: 12px !important;
            background: #fff !important;
            margin-bottom: 32px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04) !important;
            overflow: hidden;
            transition: box-shadow .2s, border-color .2s;
        }

        .order-card:hover {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08) !important;
            border-color: #222 !important;
        }

        .order-card .order-header,
        .order-card .order-footer {
            background: #fafafa !important;
            padding: 18px 32px !important;
            border-bottom: 1px solid #e0e0e0 !important;
        }

        .order-card .order-footer {
            border-top: 1px solid #e0e0e0 !important;
            border-bottom: none !important;
        }

        .order-card .badge {
            background: #222 !important;
            color: #fff !important;
            font-weight: 500;
            border-radius: 4px;
            font-size: 0.95rem;
        }

        .order-card .btn {
            border-radius: 20px !important;
            font-size: 1rem;
            padding: 6px 24px;
            margin-right: 8px;
            border-width: 1.5px;
        }

        .order-card .btn:last-child {
            margin-right: 0;
        }

        .order-card .fw-bold.fs-5 {
            font-size: 1.25rem !important;
        }

        .order-card .order-product {
            padding: 16px 32px !important;
            border-bottom: 1px solid #e0e0e0 !important;
            display: flex;
            align-items: center;
            min-height: 70px;
        }

        .order-card .order-product:last-child {
            border-bottom: none !important;
        }

        .order-card .order-product img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
            margin-right: 16px;
        }

        .order-card .order-product .fw-semibold {
            font-size: 1.05rem;
        }

        .nav-tabs {
            display: flex !important;
            flex-wrap: wrap;
            gap: 8px;
            background: none;
            list-style: none;
            padding-left: 0;
        }

        .nav-tabs .nav-link {
            border: none !important;
            border-bottom: 2px solid transparent !important;
            background: none !important;
            color: #222 !important;
            font-weight: 500;
            margin-bottom: -1px;
            border-radius: 0 !important;
            transition: border-color .2s, color .2s;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-link:focus,
        .nav-tabs .nav-link:hover {
            border-bottom: 2.5px solid #222 !important;
            color: #222 !important;
            background: none !important;
        }

        /* Bo góc về 0 cho toàn bộ thành phần chính */
        .order-card,
        .order-card .order-header,
        .order-card .order-footer,
        .order-card .order-product img,
        .order-card .btn,
        .order-card .badge,
        .nav-tabs,
        .nav-tabs .nav-link,
        .input-group-text,
        .form-control {
            border-radius: 0 !important;
        }

        /* Nếu có border-radius riêng cho các thành phần khác, cũng set về 0 */
        .rounded,
        .rounded-3,
        .rounded-4,
        .rounded-pill {
            border-radius: 0 !important;
        }

        * {
            border-radius: 0 !important;
        }

        .input-group {
            display: flex !important;
            flex-wrap: nowrap !important;
        }

        .input-group .form-control,
        .input-group .input-group-text,
        .input-group .btn {
            width: auto !important;
            flex: 1 1 auto !important;
        }

        .input-group .btn {
            flex: 0 0 auto !important;
        }
    </style>
@endsection
