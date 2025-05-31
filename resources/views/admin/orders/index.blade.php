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
                                id="order-search-input" placeholder="Nhập mã đơn hàng hoặc tên khách hàng"
                                value="{{ request('search') }}" aria-label="Search"
                                style="min-width: 300px; height: 40px;" />
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
                                Trạng thái thanh toán <span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'paid'])) }}">Đã
                                        thanh toán</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'pending'])) }}">Đang
                                        chờ</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'failed'])) }}">Thất
                                        bại</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'refunded'])) }}">Đã
                                        hoàn tiền</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'cancelled'])) }}">Đã
                                        hủy</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'partially_paid'])) }}">Thanh
                                        toán một phần</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('payment_status'), ['payment_status' => 'disputed'])) }}">Đang
                                        tranh chấp</a></li>
                            </ul>
                        </div>
                        <!-- Order status -->
                        <div class="btn-group position-static text-nowrap" role="group">
                            <button class="btn btn-phoenix-secondary px-7 py-2 border-end" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent" style="height: 40px;">
                                Trạng thái đơn hàng <span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}">Đang
                                        chờ xử lý</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'confirmed'])) }}">Đã
                                        xác nhận</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'processing'])) }}">Đang
                                        xử lý</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'shipping'])) }}">Đang
                                        vận chuyển</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'delivered'])) }}">Đã
                                        giao hàng</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'returned'])) }}">Khách
                                        trả hàng</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'processing_return'])) }}">Đang
                                        xử lý trả hàng</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'cancelled'])) }}">Đã
                                        huỷ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Export và Add order -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-link text-body px-0 d-flex align-items-center"
                        style="height: 40px;">
                        <span class="fa-solid fa-file-export fs-9 me-2"></span>Export
                    </a>

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
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="order"
                                style="width:90px;">Mã đơn hàng</th>
                            <th class="sort align-middle text-end px-3" scope="col" data-sort="total"
                                style="width:110px;">Tổng số tiền</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="customer"
                                style="width:180px;">Khách hàng</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="payment_status"
                                style="width:130px;">Trạng thái thanh toán</th>
                            <th class="sort align-middle text-center px-3" scope="col"
                                data-sort="fulfilment_status" style="width:150px;">Trạng thái đơn hàng</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="delivery_type"
                                style="width:180px;">Phương thức vận chuyển</th>
                            <th class="sort align-middle text-center px-3 white-space-nowrap" scope="col"
                                data-sort="date" style="width:120px;">Ngày đặt hàng</th>
                            <th class="sort text-center align-middle px-3" scope="col" style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="order-table-body">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="fs-9 align-middle px-0 py-3">
                                    <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                            type="checkbox" /></div>
                                </td>
                                <td class="order align-middle text-center white-space-nowrap py-0"><a
                                        class="fw-semibold"
                                        href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->order_number }}</a>
                                </td>
                                <td class="total align-middle text-end fw-semibold text-body-highlight px-3"
                                    style="white-space:nowrap;">{{ number_format($order->total_amount, 2) }} <span
                                        class="text-muted ms-1">VND</span></td>
                                <td class="customer align-middle text-center white-space-nowrap px-3">
                                    {{ $order->user->name ?? 'Khách hàng ẩn danh' }}</td>
                                <td
                                    class="payment_status align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
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
                                    class="fulfilment_status align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
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
                                <td
                                    class="delivery_type align-middle text-center white-space-nowrap text-body fs-9 px-3">
                                    @if ($order->shippingProvider)
                                        <span
                                            class="badge bg-primary-subtle text-primary fw-semibold fs-9">{{ $order->shippingProvider->name }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary fw-semibold fs-9"
                                            style="width: 100px;">Chưa
                                            chọn</span>
                                    @endif
                                </td>
                                <td
                                    class="date align-middle text-center white-space-nowrap text-body-tertiary fs-9 px-3">
                                    {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="align-middle text-center white-space-nowrap px-3 btn-reveal-trigger">
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        Tổng: {{ $orders->count() }} đơn hàng
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả <span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn <span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
