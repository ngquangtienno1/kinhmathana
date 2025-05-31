@extends('admin.layouts')
@section('title', 'Chi tiết đơn hàng #' . $order->order_number)
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết đơn hàng #{{ $order->order_number }}</li>
@endsection

<div class="mb-9">
    <h2 class="mb-0">Đơn hàng #{{ $order->order_number }}</h2>
    <div class="d-sm-flex flex-between-center mb-3">
        <p class="text-body-secondary lh-sm mb-0 mt-2 mt-sm-0">
            Mã khách hàng: <a class="fw-bold" href="#!">{{ $order->user_id }}</a>
        </p>
        <div class="d-flex">
            <button class="btn btn-link pe-3 ps-0 text-body" onclick="window.print()">
                <i class="fas fa-print me-2"></i>In
            </button>
            @if ($order->status == 'cancelled')
                <button class="btn btn-link px-3 text-danger"
                    onclick="if(confirm('Bạn có chắc muốn xóa đơn hàng này?')) document.getElementById('delete-order-form').submit();">
                    <i class="fas fa-trash me-2"></i>Xóa đơn hàng
                </button>
                {{-- <form id="delete-order-form" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form> --}}
            @endif
        </div>
    </div>

    <div class="row g-5 gy-7">
        <div class="col-12 col-xl-8 col-xxl-9">
            <div class="card mb-3">
                <div class="card-body p-0">
                    <div class="table-responsive scrollbar">
                        <table class="table fs-9 mb-0 border-top border-translucent align-middle text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th class="white-space-nowrap align-middle fs-10 ps-2 pe-2" scope="col"></th>
                                    <th class="white-space-nowrap align-middle text-start ps-2 pe-2" scope="col">SẢN
                                        PHẨM</th>
                                    <th class="align-middle text-end ps-2 pe-2" scope="col">GIÁ</th>
                                    <th class="align-middle ps-2 pe-2" scope="col">SỐ LƯỢNG</th>
                                    <th class="align-middle text-end ps-2 pe-2" scope="col">TỔNG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($order->items && count($order->items) > 0)
                                    @foreach ($order->items as $item)
                                        <tr class="border-bottom">
                                            <td class="align-middle white-space-nowrap py-2 ps-2 pe-2">
                                                @if ($item->product && $item->product->thumbnail)
                                                    <img src="{{ asset($item->product->thumbnail) }}" alt=""
                                                        width="53" class="rounded border" style="object-fit:cover;">
                                                @endif
                                            </td>
                                            <td class="align-middle py-2 ps-2 pe-2 text-start">
                                                <p class="fw-semibold mb-0">{{ $item->product_name }}</p>
                                                <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                            </td>
                                            <td class="align-middle py-2 ps-2 pe-2 text-end">
                                                {{ number_format($item->price) }}đ</td>
                                            <td class="align-middle py-2 ps-2 pe-2">
                                                {{ $item->quantity }}</td>
                                            <td class="align-middle py-2 ps-2 pe-2 text-end fw-bold text-primary">
                                                {{ number_format($item->subtotal) }}đ</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-3">Không có sản phẩm nào trong đơn hàng
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row gx-4 gy-6 g-xl-7 justify-content-sm-center justify-content-xl-start mt-4">
                <!-- Thông tin người đặt hàng -->
                <div class="col-12 col-sm-6">
                    <h4 class="mb-3">Thông tin người đặt</h4>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-user me-2"></i>
                                    <h6 class="mb-0">Họ tên</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->user->name }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-envelope me-2"></i>
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->user->email }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-phone me-2"></i>
                                    <h6 class="mb-0">Điện thoại</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <h6 class="mb-0">Địa chỉ</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->user->address ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin người nhận -->
                <div class="col-12 col-sm-6">
                    <h4 class="mb-3">Thông tin người nhận</h4>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-user me-2"></i>
                                    <h6 class="mb-0">Họ tên</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->receiver_name }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-envelope me-2"></i>
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->receiver_email }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-phone me-2"></i>
                                    <h6 class="mb-0">Điện thoại</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->receiver_phone }}</p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <h6 class="mb-0">Địa chỉ</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin đơn hàng -->
                <div class="col-12">
                    <h4 class="mb-3">Chi tiết đơn hàng</h4>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-calendar me-2"></i>
                                    <h6 class="mb-0">Ngày đặt hàng</h6>
                                </div>
                                <p class="mb-0 ms-4">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-money-bill me-2"></i>
                                    <h6 class="mb-0">Phương thức thanh toán</h6>
                                </div>
                                <p class="mb-0 ms-4">
                                    @php
                                        $paymentMethodName = $order->paymentMethod->name ?? 'Chưa chọn';
                                        $paymentMethodColor = match ($paymentMethodName) {
                                            'Thanh toán khi nhận hàng (COD)' => 'secondary',
                                            'Chuyển khoản ngân hàng' => 'info',
                                            'Ví điện tử MoMo' => 'primary',
                                            'Ví điện tử VNPay' => 'primary',
                                            'Thẻ tín dụng/ghi nợ' => 'info',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $paymentMethodColor }}-subtle text-{{ $paymentMethodColor }} fw-semibold">{{ $paymentMethodName }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-truck me-2"></i>
                                    <h6 class="mb-0">Phương thức vận chuyển</h6>
                                </div>
                                <p class="mb-0 ms-4">
                                    @php
                                        $shippingProviderName = $order->shippingProvider->name ?? 'Chưa chọn';
                                        $shippingProviderColor = match ($shippingProviderName) {
                                            'Giao Hàng Nhanh' => 'info',
                                            'Giao Hàng Tiết Kiệm' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $shippingProviderColor }}-subtle text-{{ $shippingProviderColor }} fw-semibold">{{ $shippingProviderName }}</span>
                                </p>
                            </div>
                            @if ($order->promotion)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-gift me-2"></i>
                                        <h6 class="mb-0">Mã khuyến mãi</h6>
                                    </div>
                                    <p class="mb-0 ms-4">
                                        @php
                                            $promotionCode = $order->promotion->code;
                                            $promotionName = $order->promotion->name;
                                            $promotionColor = 'warning'; // Màu mặc định cho khuyến mãi
                                            if (str_contains($promotionName, 'Miễn phí vận chuyển')) {
                                                $promotionColor = 'success';
                                            }
                                        @endphp
                                        <span
                                            class="badge bg-{{ $promotionColor }}-subtle text-{{ $promotionColor }} fw-semibold">{{ $promotionCode }}
                                            ({{ $promotionName }})</span>
                                    </p>
                                </div>
                            @endif
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-box me-2"></i>
                                    <h6 class="mb-0">Trạng thái đơn hàng</h6>
                                </div>
                                <p class="mb-0 ms-4">
                                    @php
                                        $orderStatusLabel = $order->getStatusLabelAttribute(); // Sử dụng accessor từ model
                                        $orderStatusColor = $order->getStatusColorAttribute(); // Sử dụng accessor từ model
                                    @endphp
                                    <span class="badge bg-{{ $orderStatusColor }}">{{ $orderStatusLabel }}</span>
                                </p>
                            </div>
                            @if ($order->note)
                                <div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-comment me-2"></i>
                                        <h6 class="mb-0">Ghi chú</h6>
                                    </div>
                                    <p class="mb-0 ms-4">{{ $order->note }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng quan đơn hàng -->
        <div class="col-12 col-xl-4 col-xxl-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title mb-4">Tổng quan</h3>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-body fw-semibold mb-0">Tổng tiền hàng:</p>
                        <p class="text-body-emphasis fw-semibold mb-0">{{ number_format($order->subtotal) }}đ</p>
                    </div>
                    @if ($order->promotion_amount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <p class="text-body fw-semibold mb-0">Giảm giá khuyến mãi:</p>
                            <p class="text-danger fw-semibold mb-0">-{{ number_format($order->promotion_amount) }}đ
                            </p>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-body fw-semibold mb-0">Phí vận chuyển:</p>
                        <p class="text-body-emphasis fw-semibold mb-0">{{ number_format($order->shipping_fee) }}đ</p>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-3">
                        <h4 class="mb-0">Tổng thanh toán:</h4>
                        <h4 class="mb-0">{{ number_format($order->total_amount) }}đ</h4>
                    </div>
                </div>
            </div>

            <!-- Cập nhật trạng thái -->
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Cập nhật trạng thái</h3>
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Trạng thái đơn hàng</label>
                            <select name="status" class="form-select"
                                {{ $order->status == 'cancelled' ? 'disabled' : '' }}>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý
                                </option>
                                <option value="awaiting_payment"
                                    {{ $order->status == 'awaiting_payment' ? 'selected' : '' }}>Chờ thanh toán
                                </option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác
                                    nhận</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang
                                    xử lý</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang vận
                                    chuyển</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã
                                    giao hàng</option>
                                <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>Đã trả
                                    hàng</option>
                                <option value="processing_return"
                                    {{ $order->status == 'processing_return' ? 'selected' : '' }}>Đang xử lý trả hàng
                                </option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Đã hoàn
                                    tiền</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú đơn hàng</label>
                            <textarea name="admin_note" class="form-control" rows="3">{{ $order->admin_note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"
                            {{ $order->status == 'cancelled' ? 'disabled' : '' }}>
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
