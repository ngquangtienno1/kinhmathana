@extends('admin.layouts')
@section('title', 'Chi tiết thanh toán #' . $payment->payment_number)
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.payments.index') }}">Thanh toán</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết thanh toán #{{ $payment->transaction_code }}</li>
@endsection

<div class="mb-9">
    <h2 class="mb-0">Thanh toán #{{ $payment->transaction_code }}</h2>
    <div class="d-sm-flex flex-between-center mb-3">
        <p class="text-body-secondary lh-sm mb-0 mt-2 mt-sm-0">
            Mã đơn hàng: <a class="fw-bold"
                href="{{ route('admin.orders.show', $payment->order_id) }}">#{{ $payment->order->order_number }}</a>
        </p>

        <p class="text-body-secondary lh-sm mb-0 mt-2 mt-sm-0">
            Khách hàng:
            <a class="fw-bold" href="#">
                {{ $payment->order->user->name ?? 'Khách vãng lai' }}
            </a>
        </p>

    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title mb-4">Thông tin thanh toán</h3>
            <div class="mb-3">
                <strong>Số tiền:</strong> {{ number_format($payment->amount) }}đ
            </div>
            <div class="mb-3">
                <strong>Phương thức:</strong>
                {{ $payment->payment_method_id ? $payment->paymentMethod->name : 'Chưa xác định' }}
            </div>
            <div class="mb-3">
                <strong>Ngày thanh toán:</strong>
                {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : 'Chưa thanh toán' }}
            </div>
            <div class="mb-3">
                <strong>Ghi chú:</strong> {{ $payment->note ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Trạng thái thanh toán:</strong>
                @php
                    $statusLabels = [
                        'đang chờ thanh toán' => 'Chờ xử lý',
                        'đã hoàn thành' => 'Hoàn thành',
                        'thất bại' => 'Thất bại',
                        'đã hủy' => 'Đã hủy',
                    ];
                    $statusColors = [
                        'đang chờ thanh toán' => 'warning',
                        'đã hoàn thành' => 'success',
                        'thất bại' => 'danger',
                        'đã hủy' => 'secondary',
                    ];
                    $status = $payment->status;
                @endphp
                <span
                    class="badge bg-{{ $statusColors[$status] ?? 'secondary' }}">{{ $statusLabels[$status] ?? $status }}</span>
            </div>
            <div class="mb-3">
                <strong>Người thanh toán:</strong>
                @if ($payment->user)
                    <ul class="mb-0">
                        <li><strong>Họ tên:</strong> {{ $payment->user->name }}</li>
                        <li><strong>Email:</strong> {{ $payment->user->email }}</li>
                        <li><strong>Số điện thoại:</strong> {{ $payment->user->phone ?? 'Không có' }}</li>
                        <li><strong>Địa chỉ:</strong> {{ $payment->user->address ?? 'Không có' }}</li>

                    </ul>
                @else
                    <span class="text-muted">Chưa xác định</span>
                @endif
            </div>

        </div>
    </div>

    <!-- Tổng quan -->
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title mb-4">Tổng quan thanh toán</h3>
            <p><strong>Tổng tiền đơn hàng:</strong> {{ number_format($payment->order->total_amount) }}đ</p>
            <p><strong>Số tiền đã thanh toán:</strong> {{ number_format($payment->order->total_paid) }}đ</p>
            <p><strong>Còn lại:</strong> {{ number_format($payment->order->remaining_amount) }}đ</p>


        </div>
    </div>

    <!-- Cập nhật trạng thái thanh toán -->
    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-4">Cập nhật trạng thái thanh toán</h3>
            @php
                $statusTransitions = [
                    'đang chờ thanh toán' => ['đã hoàn thành', 'thất bại', 'đã hủy'],
                    'đã hoàn thành' => [],
                    'thất bại' => ['đã hủy'],
                    'đã hủy' => [],
                ];
                $current = $payment->status;
                $canUpdate = count($statusTransitions[$current]) > 0;
                $adminCancellationReasons = \App\Models\CancellationReason::where('type', 'admin')
                    ->where('is_active', true)
                    ->get();
            @endphp

            <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST"
                id="payment-status-form">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="payment-status-select" class="form-label">Trạng thái</label>
                    <select name="status" id="payment-status-select" class="form-select"
                        {{ !$canUpdate ? 'disabled' : '' }}>
                        <option value="{{ $current }}">{{ $statusLabels[$current] ?? $current }}</option>
                        @foreach ($statusTransitions[$current] as $next)
                            <option value="{{ $next }}">{{ $statusLabels[$next] ?? $next }}</option>
                        @endforeach
                    </select>
                    @if (!$canUpdate)
                        <small class="text-danger">Trạng thái cuối, không thể cập nhật nữa.</small>
                    @endif
                </div>
                <input type="hidden" name="cancellation_reason_id" id="cancellation_reason_id" value="">
                <button type="submit" class="btn btn-primary w-100" id="payment-status-submit"
                    {{ !$canUpdate ? 'disabled' : '' }}>
                    Cập nhật trạng thái
                </button>
            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('payment-status-select');
        const cancellationReasonModal = new bootstrap.Modal(document.getElementById('cancellationReasonModal'));
        const cancellationReasonSelect = document.getElementById('cancellation_reason_select');
        const cancellationReasonOther = document.getElementById('cancellation_reason_other');
        const cancellationReasonIdInput = document.getElementById('cancellation_reason_id');
        const paymentStatusForm = document.getElementById('payment-status-form');
        const paymentStatusSubmit = document.getElementById('payment-status-submit');

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

        statusSelect.addEventListener('change', function() {
            if (this.value === 'cancelled') {
                cancellationReasonModal.show();
                paymentStatusSubmit.disabled = true;
            } else {
                cancellationReasonIdInput.value = '';
                paymentStatusSubmit.disabled = false;
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
                cancellationReasonIdInput.value = 'other:' + cancellationReasonOther.value.trim();
            } else {
                cancellationReasonOther.classList.remove('is-invalid');
                cancellationReasonIdInput.value = selectedReason;
            }
            cancellationReasonModal.hide();
            paymentStatusSubmit.disabled = false;
        });

        paymentStatusForm.addEventListener('submit', function(e) {
            if (statusSelect.value === 'cancelled' && !cancellationReasonIdInput.value) {
                e.preventDefault();
                cancellationReasonModal.show();
                paymentStatusSubmit.disabled = true;
            }
        });
    });
</script>

@endsection
