@extends('admin.layouts')

@section('title', 'Chi tiết khách hàng')

@section('content')
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.customers.index') }}">Khách hàng</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết khách hàng</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết khách hàng</h2>
        </div>
    </div>

    <div class="row g-3">
        <!-- Thống kê và đơn hàng -->
        <div class="col-12 col-lg-9">
            <!-- Thống kê -->
            <div class="card mb-3">
                <div class="card-header d-flex flex-between-center border-bottom border-translucent py-2">
                    <h3 class="mb-0 fs-6">Thống kê</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <div class="card bg-primary bg-opacity-10 border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1">
                                            <h5 class="mb-0 text-primary">{{ $customer->total_orders }}</h5>
                                            <p class="mb-0 fs-9 text-primary">Số đơn đã đặt</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="fas fa-shopping-cart fs-3 text-primary"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card bg-success bg-opacity-10 border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1">
                                            <h5 class="mb-0 text-success">{{ number_format($customer->total_spent) }}đ
                                            </h5>
                                            <p class="mb-0 fs-9 text-success">Tổng chi tiêu</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="fas fa-money-bill-wave fs-3 text-success"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card bg-info bg-opacity-10 border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1">
                                            <h5 class="mb-0 text-info">
                                                {{ $customer->last_order_at ? $customer->last_order_at->format('d/m/Y') : 'Chưa có' }}
                                            </h5>
                                            <p class="mb-0 fs-9 text-info">Đơn hàng gần nhất</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="fas fa-clock fs-3 text-info"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng gần đây -->
            <div class="card mb-3 shadow-sm border-0 rounded-4 bg-white">
                <div
                    class="card-header d-flex flex-between-center border-bottom border-translucent py-2 bg-white rounded-top-4">
                    <h3 class="mb-0 fs-6">Đơn hàng gần đây</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive scrollbar">
                        <table class="table table-sm fs-9 mb-0 align-middle rounded-4 overflow-hidden">
                            <thead class="bg-white text-dark fw-bold">
                                <tr>
                                    <th class="white-space-nowrap fs-9 align-middle ps-3">Mã đơn</th>
                                    <th class="white-space-nowrap fs-9 align-middle">Ngày đặt</th>
                                    <th class="white-space-nowrap fs-9 align-middle text-end">Tổng tiền</th>
                                    <th class="white-space-nowrap fs-9 align-middle text-center">Trạng thái thanh toán
                                    </th>
                                    <th class="white-space-nowrap fs-9 align-middle text-center">Trạng thái đơn hàng
                                    </th>
                                    <th class="white-space-nowrap fs-9 align-middle text-end pe-3">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customer->orders as $order)
                                    @php
                                        $paymentStatusMap = [
                                            'pending' => ['Chưa thanh toán', 'badge-phoenix-warning', 'clock'],
                                            'paid' => ['Đã thanh toán', 'badge-phoenix-success', 'check'],
                                            'cod' => ['Thanh toán khi nhận hàng', 'badge-phoenix-info', 'dollar-sign'],
                                            'disputed' => ['Đang xử lý', 'badge-phoenix-warning', 'clock'],
                                            'partially_paid' => [
                                                'Đã thanh toán một phần',
                                                'badge-phoenix-info',
                                                'dollar-sign',
                                            ],
                                            'confirmed' => [
                                                'Đã xác nhận thanh toán',
                                                'badge-phoenix-primary',
                                                'check-circle',
                                            ],
                                            'refunded' => ['Đã hoàn tiền', 'badge-phoenix-info', 'refresh-cw'],
                                            'processing_refund' => ['Đang hoàn tiền', 'badge-phoenix-warning', 'clock'],
                                            'failed' => ['Thanh toán không thành công', 'badge-phoenix-danger', 'x'],
                                        ];
                                        $ps = $paymentStatusMap[$order->payment_status] ?? [
                                            ucfirst($order->payment_status),
                                            'badge-phoenix-secondary',
                                            'info',
                                        ];

                                        $orderStatusMap = [
                                            'pending' => ['Chờ xác nhận', 'badge-phoenix-warning', 'clock'],
                                            'confirmed' => ['Đã xác nhận', 'badge-phoenix-primary', 'check-circle'],
                                            'awaiting_pickup' => ['Chờ lấy hàng', 'badge-phoenix-info', 'package'],
                                            'shipping' => ['Đang giao', 'badge-phoenix-dark', 'truck'],
                                            'delivered' => ['Đã giao hàng', 'badge-phoenix-success', 'check'],
                                            'returned' => ['Khách trả hàng', 'badge-phoenix-warning', 'corner-up-left'],
                                            'processing_return' => [
                                                'Đang xử lý trả hàng',
                                                'badge-phoenix-warning',
                                                'refresh-cw',
                                            ],
                                            'cancelled' => ['Đã hủy', 'badge-phoenix-secondary', 'x'],
                                            'returned_refunded' => [
                                                'Trả hàng / Hoàn tiền',
                                                'badge-phoenix-danger',
                                                'corner-up-left',
                                            ],
                                            'completed' => ['Đã hoàn thành', 'badge-phoenix-primary', 'award'],
                                            'refunded' => ['Đã hoàn tiền', 'badge-phoenix-info', 'refresh-cw'],
                                        ];
                                        $os = $orderStatusMap[$order->status] ?? [
                                            ucfirst($order->status),
                                            'badge-phoenix-secondary',
                                            'info',
                                        ];
                                    @endphp
                                    <tr class="order-row align-middle" style="transition: background 0.2s;">
                                        <td class="align-middle ps-3">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="fw-bold text-primary text-decoration-none order-link"
                                                style="font-size: 1.05em;">
                                                #{{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td class="align-middle">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle text-end">{{ number_format($order->total_amount) }}đ
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-phoenix fs-10 {{ $ps[1] }}">
                                                <span class="badge-label">{{ $ps[0] }}</span>
                                                <span class="ms-1" data-feather="{{ $ps[2] }}"
                                                    style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-phoenix fs-10 {{ $os[1] }}">
                                                <span class="badge-label">{{ $os[0] }}</span>
                                                <span class="ms-1" data-feather="{{ $os[2] }}"
                                                    style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        </td>
                                        <td class="align-middle text-end pe-3 btn-reveal-trigger">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.orders.show', $order) }}">Chi tiết</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Không có đơn hàng nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm hay mua -->
            @if ($frequentProducts->count() > 0)
                <div class="card shadow-sm border-0 rounded-4 bg-white mt-4">
                    <div
                        class="card-header d-flex flex-between-center border-bottom border-translucent py-2 bg-white rounded-top-4">
                        <h3 class="mb-0 fs-6">Sản phẩm hay mua</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive scrollbar">
                            <table class="table table-sm fs-9 mb-0 align-middle rounded-4 overflow-hidden">
                                <thead class="bg-white text-dark fw-bold">
                                    <tr>
                                        <th class="white-space-nowrap fs-9 align-middle ps-3">Sản phẩm</th>
                                        <th class="white-space-nowrap fs-9 align-middle text-end pe-1"
                                            style="width: 70px; min-width: 70px;">Số lần mua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($frequentProducts as $product)
                                        <tr class="align-middle" style="transition: background 0.2s;">
                                            <td class="align-middle ps-3 fw-semibold text-dark">{{ $product->name }}
                                            </td>
                                            <td class="align-middle text-end pe-1 text-primary fw-bold"
                                                style="width: 70px; min-width: 70px;">{{ $product->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Thông tin cá nhân -->
        <div class="col-12 col-lg-3">
            <div class="card h-100">
                <div class="card-header d-flex flex-between-center border-bottom border-translucent py-2">
                    <h3 class="mb-0 fs-6">Thông tin cá nhân</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input type="text" class="form-control" value="{{ $customer->user->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $customer->user->email }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" value="{{ $customer->user->phone }}"
                                readonly>
                        </div>
                        {{-- Địa chỉ mặc định - Chỉ đọc --}}
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ mặc định</label>
                            <textarea name="default_address" class="form-control" rows="3" readonly>{{ $customer->default_address }}</textarea>
                        </div>
                    </form>
                    
                    {{-- Form cập nhật chỉ Loại khách hàng --}}
                    <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Loại khách hàng</label>
                            <select name="customer_type" class="form-select">
                                <option value="new" {{ $customer->customer_type == 'new' ? 'selected' : '' }}>Mới
                                </option>
                                <option value="regular" {{ $customer->customer_type == 'regular' ? 'selected' : '' }}>
                                    Thường</option>
                                <option value="vip" {{ $customer->customer_type == 'vip' ? 'selected' : '' }}>VIP
                                </option>
                                <option value="potential"
                                    {{ $customer->customer_type == 'potential' ? 'selected' : '' }}>Tiềm năng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-phoenix-primary w-100">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-row:hover {
        background: #f5faff;
    }

    .order-link:hover {
        color: #0d6efd;
        text-decoration: underline;
    }

    .card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    }
</style>
@endsection
