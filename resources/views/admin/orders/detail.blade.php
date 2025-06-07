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
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank"
                class="btn btn-link pe-3 ps-0 text-body">
                <i class="fas fa-print me-2"></i>In
            </a>
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
                                        $orderStatusLabel = $order->getStatusLabelAttribute();
                                        $orderStatusColor = $order->getStatusColorAttribute();
                                    @endphp
                                    <span class="badge bg-{{ $orderStatusColor }}">{{ $orderStatusLabel }}</span>
                                    @if (in_array($order->status, ['cancelled_by_customer', 'cancelled_by_admin']))
                                        <div class="alert bg-danger-subtle border-0 d-flex align-items-start p-3 mt-2">
                                            <i class="fa-solid fa-circle-exclamation fa-lg text-danger me-3 mt-1"></i>
                                            <div>
                                                @if ($order->cancellationReason)
                                                    <div class="fw-bold text-danger mb-1">
                                                        Lý do huỷ: {{ $order->cancellationReason->reason }}
                                                    </div>
                                                @endif
                                                @php
                                                    $cancelHistory = $order
                                                        ->statusHistories()
                                                        ->whereIn('new_status', [
                                                            'cancelled_by_customer',
                                                            'cancelled_by_admin',
                                                        ])
                                                        ->latest()
                                                        ->first();
                                                @endphp
                                                @if ($cancelHistory && $cancelHistory->updatedBy)
                                                    <div class="fst-italic text-secondary small">
                                                        Huỷ bởi: {{ $cancelHistory->updatedBy->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
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
                    @php
                        $adminCancellationReasons = \App\Models\CancellationReason::where('type', 'admin')
                            ->where('is_active', true)
                            ->get();
                    @endphp
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                        id="order-status-form">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Trạng thái đơn hàng</label>
                            @php
                                $statusTransitions = [
                                    'pending' => ['confirmed', 'cancelled_by_admin'],
                                    'confirmed' => ['awaiting_pickup', 'cancelled_by_admin'],
                                    'awaiting_pickup' => ['shipping', 'cancelled_by_admin'],
                                    'shipping' => ['delivered', 'delivery_failed'],
                                    'delivered' => ['completed', 'processing_return'],
                                    'completed' => [],
                                    'processing_return' => ['refunded'],
                                    'refunded' => [],
                                    'cancelled_by_admin' => [],
                                    'delivery_failed' => ['cancelled_by_admin'],
                                    'cancelled_by_customer' => [], // Read-only status
                                    'return_rejected' => ['refunded'],
                                    'returned_requested' => ['processing_return'], // Thêm lại để tránh lỗi
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'awaiting_pickup' => 'Chờ lấy hàng',
                                    'shipping' => 'Đang giao',
                                    'delivered' => 'Đã giao hàng',
                                    'completed' => 'Đã hoàn thành',
                                    'processing_return' => 'Đang xử lý trả hàng',
                                    'refunded' => 'Đã hoàn tiền',
                                    'cancelled_by_admin' => 'Admin hủy đơn',
                                    'delivery_failed' => 'Giao thất bại',
                                    'cancelled_by_customer' => 'Khách hủy đơn',
                                    'return_rejected' => 'Trả hàng bị từ chối',
                                    'returned_requested' => 'Khách trả hàng', // Thêm lại để tránh lỗi
                                ];
                                $current = $order->status;
                                $canUpdate = count($statusTransitions[$current]) > 0;
                            @endphp
                            <select name="status" class="form-select" id="order-status-select"
                                {{ !$canUpdate ? 'disabled' : '' }}>
                                <option value="{{ $current }}">{{ $statusLabels[$current] }}</option>
                                @foreach ($statusTransitions[$current] as $next)
                                    <option value="{{ $next }}">{{ $statusLabels[$next] }}</option>
                                @endforeach
                            </select>
                            @if (!$canUpdate)
                                <div class="text-danger mt-2"><small>Đây là trạng thái cuối, không thể cập nhật
                                        nữa.</small></div>
                            @endif
                        </div>
                        <input type="hidden" name="cancellation_reason_id" id="cancellation_reason_id"
                            value="">
                        <button type="submit" class="btn btn-primary w-100" id="order-status-submit"
                            {{ !$canUpdate ? 'disabled' : '' }}>
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal chọn lý do huỷ -->
<div class="modal fade" id="cancellationReasonModal" tabindex="-1" aria-labelledby="cancellationReasonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancellationReasonModalLabel">Chọn lý do huỷ đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="cancellation_reason_select" class="form-label">Lý do huỷ <span
                            class="text-danger">*</span></label>
                    <select class="form-select" id="cancellation_reason_select">
                        <option value="">-- Chọn lý do huỷ --</option>
                        @foreach ($adminCancellationReasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                        @endforeach
                        <option value="other">-- Khác (Nhập lý do mới) --</option>
                    </select>
                    <input type="text" class="form-control mt-2 d-none" id="cancellation_reason_other"
                        placeholder="Nhập lý do huỷ mới">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="confirm-cancellation-reason">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('order-status-select');
        const cancellationReasonModal = new bootstrap.Modal(document.getElementById('cancellationReasonModal'));
        const cancellationReasonSelect = document.getElementById('cancellation_reason_select');
        const cancellationReasonOther = document.getElementById('cancellation_reason_other');
        const cancellationReasonIdInput = document.getElementById('cancellation_reason_id');
        const orderStatusForm = document.getElementById('order-status-form');
        const orderStatusSubmit = document.getElementById('order-status-submit');

        let shouldShowModal = false;

        // Hiện/ẩn input nhập lý do mới
        cancellationReasonSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                cancellationReasonOther.classList.remove('d-none');
                cancellationReasonOther.required = true;
            } else {
                cancellationReasonOther.classList.add('d-none');
                cancellationReasonOther.value = '';
                cancellationReasonOther.required = false;
            }
        });

        statusSelect.addEventListener('change', function(e) {
            if (this.value === 'cancelled_by_admin') {
                shouldShowModal = true;
                cancellationReasonModal.show();
                orderStatusSubmit.disabled = true;
            } else {
                cancellationReasonIdInput.value = '';
                orderStatusSubmit.disabled = false;
            }
        });

        document.getElementById('confirm-cancellation-reason').addEventListener('click', function() {
            const selectedReason = cancellationReasonSelect.value;
            if (!selectedReason) {
                cancellationReasonSelect.classList.add('is-invalid');
                return;
            }
            cancellationReasonSelect.classList.remove('is-invalid');
            if (selectedReason === 'other') {
                if (!cancellationReasonOther.value.trim()) {
                    cancellationReasonOther.classList.add('is-invalid');
                    return;
                }
                cancellationReasonOther.classList.remove('is-invalid');
                // Gửi lý do mới qua hidden input (có thể dùng 1 hidden input hoặc truyền qua cancellation_reason_id)
                cancellationReasonIdInput.value = 'other:' + cancellationReasonOther.value.trim();
            } else {
                cancellationReasonOther.classList.remove('is-invalid');
                cancellationReasonIdInput.value = selectedReason;
            }
            cancellationReasonModal.hide();
            orderStatusSubmit.disabled = false;
        });

        // Ngăn submit nếu chọn huỷ mà chưa chọn lý do
        orderStatusForm.addEventListener('submit', function(e) {
            if (statusSelect.value === 'cancelled_by_admin' && !cancellationReasonIdInput.value) {
                e.preventDefault();
                cancellationReasonModal.show();
                orderStatusSubmit.disabled = true;
            }
        });
    });
</script>

@endsection
