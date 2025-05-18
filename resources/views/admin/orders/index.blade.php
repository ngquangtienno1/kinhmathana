@extends('admin.layouts')
@section('title', 'Đơn hàng')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Đơn hàng</a>
    </li>
    <li class="breadcrumb-item active">Tất cả đơn hàng</li>
@endsection
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Đơn hàng</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link{{ request('status') ? '' : ' active' }}" aria-current="page"
                href="{{ route('admin.orders.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $countAll }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('payment_status') == 'pending' ? ' active' : '' }}"
                href="?payment_status=pending"><span>Đang chờ thanh toán </span><span
                    class="text-body-tertiary fw-semibold">({{ $countPending }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'pending' ? ' active' : '' }}"
                href="?status=pending"><span>Chưa hoàn thành </span><span
                    class="text-body-tertiary fw-semibold">({{ $countUnfulfilled }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'delivered' ? ' active' : '' }}"
                href="?status=delivered"><span>Đã hoàn thành </span><span
                    class="text-body-tertiary fw-semibold">({{ $countCompleted }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('payment_status') == 'refunded' ? ' active' : '' }}"
                href="?payment_status=refunded"><span>Đã hoàn lại </span><span
                    class="text-body-tertiary fw-semibold">({{ $countRefunded }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('payment_status') == 'failed' ? ' active' : '' }}"
                href="?payment_status=failed"><span>Thất bại </span><span
                    class="text-body-tertiary fw-semibold">({{ $countFailed }})</span></a></li>
    </ul>

    <div id="orderTable"
        data-list='{"valueNames":["order","total","customer","payment_status","fulfilment_status","delivery_type","date"],"page":10,"pagination":true}'>

        <div class="mb-4">
            <div class="row g-3 align-items-center">
                <!-- Ô tìm kiếm -->
                <div class="col-auto">
                    <div class="search-box">
                        <form class="position-relative">
                            <input class="form-control search-input search" type="search" name="search"
                                id="order-search-input" placeholder="Enter order code or customer name"
                                value="{{ request('search') }}" aria-label="Search"
                                style="min-width: 320px; height: 40px;" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                    </div>
                </div>
                <!-- Các filter dropdown -->
                <div class="col">
                    <div class="d-flex align-items-center gap-0">
                        <!-- Payment status -->
                        <div class="btn-group position-static text-nowrap" role="group">
                            <button class="btn btn-phoenix-secondary px-7 py-2 border-end" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent" style="border-radius: 8px 0 0 8px; height: 40px;">
                                Payment status <span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?payment_status=paid">Đã thanh toán</a></li>
                                <li><a class="dropdown-item" href="?payment_status=pending">Đang chờ</a></li>
                                <li><a class="dropdown-item" href="?payment_status=failed">Thất bại</a></li>
                                <li><a class="dropdown-item" href="?payment_status=refunded">Đã hoàn tiền</a></li>
                                <li><a class="dropdown-item" href="?payment_status=cancelled">Đã hủy</a></li>
                                <li><a class="dropdown-item" href="?payment_status=partially_paid">Thanh toán một
                                        phần</a></li>
                                <li><a class="dropdown-item" href="?payment_status=disputed">Đang tranh chấp</a></li>
                            </ul>
                        </div>
                        <!-- Order status -->
                        <div class="btn-group position-static text-nowrap" role="group">
                            <button class="btn btn-phoenix-secondary px-7 py-2 border-end" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent" style="height: 40px;">
                                Order status <span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?status=pending">Đang chờ xử lý</a></li>
                                <li><a class="dropdown-item" href="?status=awaiting_payment">Chờ thanh toán</a></li>
                                <li><a class="dropdown-item" href="?status=confirmed">Đã xác nhận</a></li>
                                <li><a class="dropdown-item" href="?status=processing">Đang xử lý</a></li>
                                <li><a class="dropdown-item" href="?status=shipping">Đang vận chuyển</a></li>
                                <li><a class="dropdown-item" href="?status=delivered">Đã giao hàng</a></li>
                                <li><a class="dropdown-item" href="?status=returned">Khách trả hàng</a></li>
                                <li><a class="dropdown-item" href="?status=processing_return">Đang xử lý trả hàng</a>
                                </li>
                                <li><a class="dropdown-item" href="?status=refunded">Đã hoàn tiền</a></li>
                                <li><a class="dropdown-item" href="?status=cancelled">Đã huỷ</a></li>
                            </ul>
                        </div>
                        <!-- More filters -->
                        <div class="btn-group position-static text-nowrap" role="group">
                            <button class="btn btn-phoenix-secondary px-7 py-2" type="button"
                                style="border-radius: 0 8px 8px 0; height: 40px;">
                                More filters
                        </button>
                        </div>
                    </div>
                </div>
                <!-- Export và Add order -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-link text-body px-0 d-flex align-items-center"
                        style="height: 40px;">
                        <span class="fa-solid fa-file-export fs-9 me-2"></span>Export
                    </a>
                    <button class="btn btn-primary d-flex align-items-center" style="height: 40px;">
                        <span class="fas fa-plus me-2"></span>Add order
                    </button>
                </div>
            </div>
        </div>


        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table table-sm fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                                <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                        id="checkbox-bulk-order-select" type="checkbox"
                                        data-bulk-select='{"body":"order-table-body"}' /></div>
                            </th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order"
                                style="width:5%;">Mã đơn hàng</th>
                            <th class="sort align-middle text-end" scope="col" data-sort="total"
                                style="width:6%;">
                                Tổng số tiền</th>
                            <th class="sort align-middle ps-8" scope="col" data-sort="customer"
                                style="width:28%; min-width: 250px;">Khách hàng</th>
                            <th class="sort align-middle pe-3" scope="col" data-sort="payment_status"
                                style="width:10%;">Trạng thái thanh toán</th>
                            <th class="sort align-middle text-start pe-3" scope="col"
                                data-sort="fulfilment_status" style="width:12%; min-width: 200px;">Trạng thái đơn hàng
                            </th>
                            <th class="sort align-middle text-start" scope="col" data-sort="delivery_type"
                                style="width:30%;">Phương thức vận chuyển</th>
                            <th class="sort align-middle text-end pe-0" scope="col" data-sort="date">Ngày đặt hàng
                            </th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="order-table-body">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="fs-9 align-middle px-0 py-3">
                                    <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                            type="checkbox" />
                                    </div>
                                </td>
                                <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold"
                                        href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->order_number }}</a>
                                </td>
                                <td class="total align-middle text-end fw-semibold text-body-highlight"
                                    style="white-space:nowrap;">
                                    {{ number_format($order->total_amount, 2) }} <span
                                        class="text-muted ms-1">VND</span>
                                </td>
                                <td class="customer align-middle white-space-nowrap ps-8">
                                    {{ $order->user->name ?? 'Khách hàng ẩn danh' }}</td>
                                <td
                                    class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">
                                    @php
                                        $paymentStatusMap = [
                                            'paid' => ['Đã thanh toán', 'badge-phoenix-success', 'check'],
                                            'pending' => ['Đang chờ', 'badge-phoenix-warning', 'clock'],
                                            'failed' => ['Thất bại', 'badge-phoenix-danger', 'x'],
                                            'refunded' => ['Đã hoàn tiền', 'badge-phoenix-info', 'refresh-cw'],
                                            'cancelled' => ['Đã hủy', 'badge-phoenix-secondary', 'x'],
                                            'partially_paid' => [
                                                'Thanh toán một phần',
                                                'badge-phoenix-primary',
                                                'percent',
                                            ],
                                            'disputed' => ['Đang tranh chấp', 'badge-phoenix-dark', 'alert-triangle'],
                                        ];
                                        $ps = $paymentStatusMap[$order->payment_status] ?? [
                                            ucfirst($order->payment_status),
                                            'badge-phoenix-secondary',
                                            'info',
                                        ];
                                    @endphp
                                    <span class="badge badge-phoenix fs-10 {{ $ps[1] }}">
                                        <span class="badge-label">{{ $ps[0] }}</span>
                                        <span class="ms-1" data-feather="{{ $ps[2] }}"
                                            style="height:12.8px;width:12.8px;"></span>
                                    </span>
                                </td>
                                <td
                                    class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">
                                    @php
                                        $orderStatusMap = [
                                            'pending' => ['Đang chờ xử lý', 'badge-phoenix-warning', 'clock'],
                                            'awaiting_payment' => ['Chờ thanh toán', 'badge-phoenix-info', 'clock'],
                                            'confirmed' => ['Đã xác nhận', 'badge-phoenix-primary', 'check'],
                                            'processing' => ['Đang xử lý', 'badge-phoenix-secondary', 'refresh-cw'],
                                            'shipping' => ['Đang vận chuyển', 'badge-phoenix-dark', 'truck'],
                                            'delivered' => ['Đã giao hàng', 'badge-phoenix-success', 'check'],
                                            'returned' => ['Khách trả hàng', 'badge-phoenix-danger', 'corner-up-left'],
                                            'processing_return' => [
                                                'Đang xử lý trả hàng',
                                                'badge-phoenix-warning',
                                                'refresh-cw',
                                            ],
                                            'refunded' => ['Đã hoàn tiền', 'badge-phoenix-info', 'refresh-cw'],
                                            'cancelled' => ['Đã huỷ', 'badge-phoenix-secondary', 'x'],
                                        ];
                                        $os = $orderStatusMap[$order->status] ?? [
                                            ucfirst($order->status),
                                            'badge-phoenix-secondary',
                                            'info',
                                        ];
                                    @endphp
                                    <span class="badge badge-phoenix fs-10 {{ $os[1] }}">
                                        <span class="badge-label">{{ $os[0] }}</span>
                                        <span class="ms-1" data-feather="{{ $os[2] }}"
                                            style="height:12.8px;width:12.8px;"></span>
                                    </span>
                                </td>
                                <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">
                                    @if ($order->shipping)
                                        {{ $order->shipping->shipping_provider }}
                                        ({{ $order->shipping->tracking_code }})
                                    @else
                                        Không có thông tin vận chuyển
                                    @endif
                                </td>
                                <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">
                                    {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.orders.show', $order->id) }}">Chi tiết</a>
                                            @if ($order->status == 'cancelled')
                                                <a href="#" class="dropdown-item text-danger"
                                                    onclick="event.preventDefault(); if(confirm('Bạn có chắc muốn xóa đơn hàng này?')) { document.getElementById('delete-order-{{ $order->id }}').submit(); }">Xóa
                                                    đơn hàng</a>
                                                <form id="delete-order-{{ $order->id }}"
                                                    action="{{ route('admin.orders.destroy', $order->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        {{ $orders->firstItem() }} đến {{ $orders->lastItem() }} <span class="text-body-tertiary">mục
                            trong tổng số</span> {{ $orders->total() }}
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả <span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn <span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <nav>
                    <ul class="mb-0 pagination">
                            {{-- Phân trang Laravel custom giống Phoenix --}}
                            @if ($orders->onFirstPage())
                                <li class="page-item disabled"><span class="page-link"><span
                                            class="fas fa-chevron-left"></span></span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $orders->previousPageUrl() }}"><span
                                            class="fas fa-chevron-left"></span></a></li>
                            @endif
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                <li class="page-item{{ $page == $orders->currentPage() ? ' active' : '' }}"><a
                                        class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endforeach
                            @if ($orders->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $orders->nextPageUrl() }}"><span
                                            class="fas fa-chevron-right"></span></a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link"><span
                                            class="fas fa-chevron-right"></span></span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let timer = null;
    const input = document.getElementById('order-search-input');
    const form = document.getElementById('order-search-form');
    input.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            const params = new URLSearchParams(new FormData(form)).toString();
            fetch(form.action + '?' + params, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    // Tìm tbody mới trong response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTbody = doc.querySelector('#order-table-body');
                    const newInfo = doc.querySelector('[data-list-info]');
                    if (newTbody) {
                        document.getElementById('order-table-body').innerHTML = newTbody.innerHTML;
                    }
                    if (newInfo) {
                        document.querySelector('[data-list-info]').innerHTML = newInfo.innerHTML;
                    }
                });
        }, 400);
    });
</script>
@endpush
