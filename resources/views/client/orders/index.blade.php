@extends('client.layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Đơn hàng của tôi</h2>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link {{ !$status ? 'active' : '' }}" href="{{ route('client.orders.index') }}">Tất cả</a></li>
        <li class="nav-item"><a class="nav-link {{ $status=='pending' ? 'active' : '' }}" href="?status=pending">Chờ xác nhận</a></li>
        <li class="nav-item"><a class="nav-link {{ $status=='shipping' ? 'active' : '' }}" href="?status=shipping">Đang giao</a></li>
        <li class="nav-item"><a class="nav-link {{ $status=='delivered' ? 'active' : '' }}" href="?status=delivered">Đã giao</a></li>
        <li class="nav-item"><a class="nav-link {{ $status=='completed' ? 'active' : '' }}" href="?status=completed">Đã hoàn thành</a></li>
        <li class="nav-item"><a class="nav-link {{ $status=='cancelled_by_customer' ? 'active' : '' }}" href="?status=cancelled_by_customer">Đã hủy</a></li>
    </ul>
    @forelse($orders as $order)
        <div class="card mb-3 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold">Mã đơn: #{{ $order->order_number }}</span>
                    <span class="ms-3 text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span>
            </div>
            <div class="card-body p-3">
                @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $item->product->images->first() ? asset('storage/'.$item->product->images->first()->image_path) : '/assets/img/products/1.png' }}" width="60" class="me-3 rounded border">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item->product_name }}</div>
                            <div class="text-muted small">Số lượng: {{ $item->quantity }}</div>
                        </div>
                        <div class="fw-bold text-danger ms-3">{{ number_format($item->price, 0, ',', '.') }}₫</div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                        @if($order->status == 'pending')
                            <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn hủy đơn này?')">Hủy đơn</button>
                            </form>
                        @endif
                        @if($order->status == 'delivered')
                            <form action="{{ route('client.orders.confirm-received', $order->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn xác nhận đã nhận hàng?')">
                                    <i class="fas fa-check"></i> Xác nhận nhận hàng
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="fw-bold fs-5">Tổng: <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span></div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @endforelse
    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection 