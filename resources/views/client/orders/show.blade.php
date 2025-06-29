@extends('client.layouts.app')
@section('title', 'Chi tiết đơn hàng')
@section('content')
<div class="container py-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <span class="fs-5 fw-bold">Đơn hàng #{{ $order->order_number }}</span>
                <span class="badge bg-{{ $order->status_color }} ms-2">{{ $order->status_label }}</span>
            </div>
            <div>
                <span class="me-3"><i class="fas fa-calendar-alt"></i> {{ $order->created_at->format('d/m/Y H:i') }}</span>
                <span>
                    <i class="fas fa-money-bill-wave"></i>
                    {{ $order->paymentMethod->name ?? 'Chưa chọn' }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-5">
                    <div class="mb-3">
                        <div class="fw-bold mb-1"><i class="fas fa-map-marker-alt me-1"></i> Địa chỉ nhận hàng</div>
                        <div>{{ $order->receiver_name }} | {{ $order->receiver_phone }}</div>
                        <div>{{ $order->shipping_address }}</div>
                        @if($order->shippingProvider)
                            <div class="mt-1 text-body-tertiary">Đơn vị vận chuyển: {{ $order->shippingProvider->name }}</div>
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold mb-1"><i class="fas fa-user me-1"></i> Người đặt hàng</div>
                        <div>{{ $order->customer_name }} | {{ $order->customer_phone }}</div>
                        <div>{{ $order->customer_address }}</div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="fw-bold mb-2"><i class="fas fa-box"></i> Sản phẩm</div>
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-center border-bottom py-2">
                            <img src="{{ $item->product->images->first() ? asset('storage/'.$item->product->images->first()->image_path) : '/assets/img/products/1.png' }}" width="60" class="rounded border me-3">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item->product_name }}</div>
                                <div class="text-body-tertiary small">
                                    @if($item->product_options)
                                        @php $opts = json_decode($item->product_options, true); @endphp
                                        @if(!empty($opts['color'])) Màu: {{ $opts['color'] }} @endif
                                        @if(!empty($opts['size'])) | Size: {{ $opts['size'] }} @endif
                                    @endif
                                </div>
                                <div class="small">x{{ $item->quantity }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ number_format($item->price, 0, ',', '.') }}₫</div>
                                <div class="fw-bold text-danger">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</div>
                                @if($order->status == 'completed' && !\App\Models\Review::where('user_id', auth()->id())->where('product_id', $item->product_id)->where('order_id', $order->id)->exists())
                                    <a href="{{ route('client.orders.review.form', [$order->id, $item->id]) }}" class="btn btn-sm btn-warning mt-1">Đánh giá</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-5"></div>
                <div class="col-md-7">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                        </div>
                        @if($order->promotion)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Giảm giá ({{ $order->promotion->code }}):</span>
                            <span class="text-danger">-{{ number_format($order->promotion_amount, 0, ',', '.') }}₫</span>
                        </div>
                        @else
                        <div class="d-flex justify-content-between mb-2">
                            <span>Giảm giá:</span>
                            <span class="text-danger">-{{ number_format($order->promotion_amount, 0, ',', '.') }}₫</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Thuế:</span>
                            <span>{{ number_format(($order->subtotal - $order->promotion_amount) * 0.1, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2 mt-2">
                            <span class="fw-bold fs-5">Tổng cộng:</span>
                            <span class="fw-bold fs-5 text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                        </div>
                        <div>Phương thức thanh toán: <b>{{ $order->paymentMethod->name ?? 'Chưa chọn' }}</b></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('client.orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
                @if($order->status == 'pending')
                    <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger">Hủy đơn</button>
                    </form>
                @endif
                @if($order->status == 'delivered')
                    <form action="{{ route('client.orders.confirm-received', $order->id) }}" method="POST" onsubmit="return confirm('Bạn xác nhận đã nhận hàng?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Xác nhận đã nhận hàng
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 