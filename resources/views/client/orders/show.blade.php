@extends('client.layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
    <div class="container py-4" style="max-width: 1000px; margin: 0 auto;">
        {{-- Thanh trạng thái đơn hàng giống admin --}}
        @php
            $steps = [
                ['label' => 'Chờ xác nhận', 'key' => 'pending', 'icon' => 'fa-file-alt'],
                ['label' => 'Đã xác nhận', 'key' => 'confirmed', 'icon' => 'fa-money-check-alt'],
                ['label' => 'Đang chuẩn bị', 'key' => 'awaiting_pickup', 'icon' => 'fa-truck-loading'],
                ['label' => 'Đang giao', 'key' => 'shipping', 'icon' => 'fa-shipping-fast'],
                ['label' => 'Đã giao hàng', 'key' => 'delivered', 'icon' => 'fa-box-open'],
                ['label' => 'Hoàn thành', 'key' => 'completed', 'icon' => 'fa-star'],
            ];
            $currentOrderStatus = $order->status;
            $currentIndex = collect($steps)->search(fn($step) => $step['key'] === $currentOrderStatus);
            if ($currentIndex === false) {
                $currentIndex = 0;
            }
        @endphp
        <div class="order-progress-bar mb-4">
            <div class="order-progress-steps d-flex align-items-center">
                @foreach ($steps as $i => $step)
                    <div class="order-step text-center flex-fill {{ $i <= $currentIndex ? 'completed' : '' }}">
                        <div class="order-step-circle mx-auto mb-1">
                            @if ($i < $currentIndex || ($i == $currentIndex && $step['key'] === 'completed'))
                                <span class="fa fa-check"></span>
                            @else
                                <span class="fa {{ $step['icon'] }}"></span>
                            @endif
                        </div>
                        <div class="order-step-label">{{ $step['label'] }}</div>
                    </div>
                    @if ($i < count($steps) - 1)
                        <div
                            class="order-step-line flex-grow-1
                            {{ $i < $currentIndex ? 'completed' : '' }}
                            {{ $i === $currentIndex && $currentIndex < count($steps) - 1 ? 'animated' : '' }}
                        ">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <style>
            .order-progress-bar {
                margin-bottom: 32px;
            }

            .order-progress-steps {
                display: flex;
                align-items: center;
            }

            .order-step {
                text-align: center;
                flex: 1;
            }

            .order-step-circle {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #eee;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: #bbb;
            }

            .order-step.completed .order-step-circle {
                background: #0d6efd;
                color: #fff;
            }

            .order-step-label {
                font-size: 14px;
                margin-top: 4px;
                color: #888;
            }

            .order-step.completed .order-step-label {
                color: #0d6efd;
                font-weight: bold;
            }

            .order-step-line {
                height: 4px;
                background: #eee;
                flex: 1;
                margin: 0 2px;
                border-radius: 2px;
                position: relative;
                overflow: hidden;
            }

            .order-step-line.completed {
                background: #0d6efd;
            }

            .order-step-line.animated {
                background: #0d6efd;
            }

            .order-step-line.animated::after {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 100%;
                background: linear-gradient(90deg, #0d6efd 0%, #fff 50%, #0d6efd 100%);
                background-size: 200% 100%;
                animation: progress-bar-stripes 1.2s linear infinite;
                opacity: 0.5;
            }

            @keyframes progress-bar-stripes {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }

            .order-progress-note {
                font-size: 14px;
                color: #666;
                text-align: center;
            }
        </style>

        {{-- Header: Mã đơn hàng, trạng thái, nút thao tác --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1">Mã Đơn Hàng: <strong>#{{ $order->order_number ?? $order->id }}</strong></h5>
                <small class="text-muted">Ngày tạo:
                    {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</small>
            </div>
            <span class="badge bg-dark text-white text-capitalize"
                style="font-size: 16px;">{{ $order->status_label }}</span>
        </div>

        @php
            $statusLabels = [
                'pending' => 'Chờ xác nhận',
                'confirmed' => 'Đã xác nhận',
                'awaiting_pickup' => 'Đang chuẩn bị',
                'shipping' => 'Đang giao',
                'delivered' => 'Đã giao hàng',
                'completed' => 'Hoàn thành',
                'cancelled_by_customer' => 'Khách hủy đơn',
                'cancelled_by_admin' => 'Admin hủy đơn',
                'delivery_failed' => 'Giao thất bại',
            ];
        @endphp
        <div class="card mb-4">
            <div class="card-body row">
                <!-- Địa chỉ nhận hàng -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-2">Địa chỉ nhận hàng</h6>
                    <div><b>Họ và tên:</b> {{ $order->receiver_name }}</div>
                    <div><b>Số điện thoại:</b> {{ $order->receiver_phone }}</div>
                    <div><b>Địa chỉ giao hàng:</b> {{ $order->shipping_address }}</div>
                </div>
                <!-- Lịch sử trạng thái dạng timeline -->
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2">Lịch sử trạng thái</h6>
                    <ul class="order-timeline list-unstyled mb-0">
                        @foreach ($order->statusHistories->sortByDesc('created_at') as $i => $history)
                            <li class="d-flex align-items-start mb-3">
                                <span class="timeline-dot {{ $i == 0 ? 'active' : '' }}">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                                <div class="ms-2">
                                    <div class="fw-bold {{ $i == 0 ? 'text-success' : 'text-muted' }}">
                                        {{ $statusLabels[$history->new_status] ?? $history->new_status }}
                                    </div>
                                    <div class="small text-muted">{{ $history->created_at->format('H:i d/m/Y') }}</div>
                                    @if ($history->note)
                                        <div class="small text-muted">{{ $history->note }}</div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <style>
            .order-timeline {
                border-left: 2px solid #eee;
                margin-left: 10px;
                padding-left: 15px;
            }

            .order-timeline .timeline-dot {
                width: 18px;
                height: 18px;
                border-radius: 50%;
                background: #eee;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #bbb;
                margin-right: 6px;
                margin-top: 2px;
                font-size: 16px;
            }

            .order-timeline .timeline-dot.active {
                background: #4caf50;
                color: #fff;
            }
        </style>

        {{-- Sản phẩm trong đơn hàng --}}
        <div class="card mb-4">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            @if ($order->status == 'completed')
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_path) : '/assets/img/products/1.png' }}"
                                        alt=""
                                        style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->product_name }}</div>
                                    @if ($item->variation_name)
                                        <div class="text-muted small">Phân loại: {{ $item->variation_name }}</div>
                                    @endif
                                </td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-danger fw-bold">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                                @if ($order->status == 'completed')
                                    <td>
                                        @php
                                            $reviewed = \App\Models\Review::where('user_id', auth()->id())
                                                ->where('product_id', $item->product_id)
                                                ->where('order_id', $order->id)
                                                ->exists();
                                        @endphp
                                        @if (!$reviewed)
                                            <a href="{{ route('client.orders.review.form', [$order->id, $item->id]) }}"
                                                class="btn btn-sm btn-outline-primary">Đánh giá</a>
                                        @else
                                            <span class="text-success">Đã đánh giá</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tổng kết đơn hàng --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Phí vận chuyển:</span>
                    <span>{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Khuyến mại:</span>
                    <span class="text-danger">-{{ number_format($order->promotion_amount, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2 fw-bold fs-5">
                    <span>Thành tiền:</span>
                    <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                </div>
            </div>
        </div>

        {{-- Nút thao tác --}}
        <div class="d-flex gap-2 justify-content-end mb-4">
            @if ($order->status == 'delivered')
                <form action="{{ route('client.orders.confirm-received', $order->id) }}" method="POST"
                    onsubmit="return confirm('Bạn xác nhận đã nhận hàng?')" style="display:inline;">
                    @csrf @method('PATCH')
                    <button class="btn btn-success">Đã Nhận Hàng</button>
                </form>
            @endif

            {{-- Ẩn nút Đánh giá tổng đơn hàng ở dưới cùng --}}
            {{--
            @if ($order->status == 'completed')
                <a href="{{ route('client.orders.review', $order->id) }}" class="btn btn-outline-primary">Đánh giá</a>
            @else
                <a href="{{ route('client.orders.review', $order->id) }}" class="btn btn-outline-primary">Yêu Cầu Trả Hàng/Hoàn Tiền</a>
            @endif
            --}}

            <a href="#" class="btn btn-outline-secondary">Liên Hệ Người Bán</a>
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('client.orders.index') }}" class="btn btn-outline-dark">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection
