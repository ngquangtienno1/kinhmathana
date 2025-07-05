@extends('client.layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
{{-- Breadcrumb và tiêu đề trang --}}
<div class="qodef-page-title qodef-m qodef-title--breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image mb-4">
    <div class="qodef-m-inner">
        <div class="qodef-m-content qodef-content-grid">
            <h1 class="qodef-m-title entry-title">Đơn hàng của tôi</h1>
            <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                <a itemprop="url" class="qodef-breadcrumbs-link" href="/">
                    <span itemprop="title">Trang chủ</span>
                </a>
                <span class="qodef-breadcrumbs-separator"></span>
                <span itemprop="title" class="qodef-breadcrumbs-current">Chi tiết đơn hàng</span>
            </div>
        </div>
    </div>
</div>

{{-- Thân chi tiết đơn hàng --}}
<div class="container py-4">
    <div class="card shadow-sm border rounded-0 p-4" style="max-width: 900px; margin: 0 auto; background: white;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1">Đơn hàng: <strong>#{{ $order->order_number ?? $order->id }}</strong></h5>
                <small class="text-muted">Ngày tạo: {{ $order->created_at ? $order->created_at->format('d/m/Y') : '' }}</small>
            </div>
            <span class="badge bg-dark text-white text-capitalize">{{ $order->status_label }}</span>
        </div>

        {{-- Trạng thái --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="fw-bold">Trạng thái thanh toán</h6>
                <p class="{{ $order->payment_status == 'paid' ? 'text-success' : 'text-danger' }} mb-0">
                    {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Trạng thái vận chuyển</h6>
                <p class="text-muted mb-0">{{ $order->status_label }}</p>
            </div>
        </div>

        {{-- Thông tin giao hàng, thanh toán, ghi chú --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="border rounded-0 p-3">
                    <h6 class="fw-bold mb-2">Địa chỉ giao hàng</h6>
                    <p class="mb-0"><strong>{{ $order->receiver_name }}</strong></p>
                    <p class="mb-0">{{ $order->shipping_address }}</p>
                    <p class="mb-0">{{ $order->receiver_phone }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded-0 p-3">
                    <h6 class="fw-bold mb-2">Thanh toán</h6>
                    <p class="mb-0">{{ $order->paymentMethod->name ?? 'Chưa chọn' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded-0 p-3">
                    <h6 class="fw-bold mb-2">Ghi chú</h6>
                    <p class="mb-0">{{ $order->note ?? 'Không có ghi chú' }}</p>
                </div>
            </div>
        </div>

        {{-- Sản phẩm --}}
        <div class="table-responsive border rounded-0 mb-4">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_path) : '/assets/img/products/1.png' }}"
                                         alt="" >
                                    <div class="ms-3">
                                        <div class="fw-bold">{{ $item->product_name }}</div>
                                        <div class="text-muted small">
                                            @if ($item->product_options)
                                                @php $opts = json_decode($item->product_options, true); @endphp
                                                @if (!empty($opts['sku']))
                                                    Mã SP: {{ $opts['sku'] }} |
                                                @endif
                                                @if (!empty($opts['color']))
                                                    Màu: {{ $opts['color'] }}
                                                @endif
                                                @if (!empty($opts['size']))
                                                    | Size: {{ $opts['size'] }}
                                                @endif
                                            @endif
                                        </div>
                                        @if (!\App\Models\Review::where('user_id', auth()->id())->where('product_id', $item->product_id)->where('order_id', $order->id)->exists())
                                            <div class="mt-2">
                                                <a href="{{ route('client.orders.review.form', [$order->id, $item->id]) }}" class="btn btn-sm" style="background:#222; color:#fff; border-radius:0; padding:7px 24px; font-weight:500;">Đánh giá</a>
                                            </div>
                                        @else
                                            <span class="text-success">Đã đánh giá</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-danger fw-bold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tổng kết --}}
        <div class="border-top pt-3 mt-3">
            <div class="d-flex justify-content-between">
                <span>Tạm tính:</span>
                <span>{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Phí vận chuyển:</span>
                <span>{{ number_format($order->shipping_fee, 0, ',', '.') }}₫ <span class="text-muted small">@if($order->shippingProvider)({{ $order->shippingProvider->name }})@endif</span></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Khuyến mại:</span>
                <span class="text-danger">-{{ number_format($order->promotion_amount, 0, ',', '.') }}₫</span>
            </div>
            <div class="d-flex justify-content-between border-top pt-2 mt-2 fw-bold fs-5">
                <span>Tổng cộng:</span>
                <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('client.orders.index') }}" class="btn btn-outline-secondary">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">



@endsection
