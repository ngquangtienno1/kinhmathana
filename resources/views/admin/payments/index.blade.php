@extends('admin.layouts')

@section('title', 'Thanh Toán')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.payments.index') }}">Thanh Toán</a>
    </li>
    <li class="breadcrumb-item active">Danh sách thanh toán</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thanh Toán</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.payments.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $tatca }})</span></a></li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.payments.index', ['status' => 'đã hoàn thành']) }}"><span>Đã thanh toán
                </span><span class="text-body-tertiary fw-semibold">({{ $dathanhtoan }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.payments.index', ['status' => 'đang chờ thanh toán']) }}"><span>Đang chờ thanh
                    toán </span><span class="text-body-tertiary fw-semibold">({{ $dangchothanhtoan }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.payments.index', ['status' => 'đã hủy']) }}"><span>Đã hủy </span><span
                    class="text-body-tertiary fw-semibold">({{ $huy }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.payments.index', ['status' => 'thất bại']) }}"><span>Thất bại </span><span
                    class="text-body-tertiary fw-semibold">({{ $thatbai }})</span></a>
        </li>
    </ul>
    <div id="payments"
        data-list='{"valueNames":["id","transaction_code","order_id","amount","status","payment_date","payment_method"],"page":10,"pagination":true,"search":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <div class="position-relative">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm thanh toán" value="{{ request('search') }}" aria-label="Search"
                            data-list-search />
                        <span class="fas fa-search search-box-icon"></span>
                    </div>
                </div>

            </div>
        </div>
        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>

                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.payments.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;"
                                data-sort="transaction_code">MÃ THANH TOÁN</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;"
                                data-sort="order_id">ĐƠN HÀNG</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="amount" style="width:120px;">SỐ
                                TIỀN</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="status" style="width:120px;">
                                TRẠNG THÁI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="payment_date"
                                style="width:150px;">NGÀY THANH TOÁN</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="payment_method"
                                style="width:150px;">PHƯƠNG THỨC</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="payments-table-body">
                        @php
                            $statusMap = [
                                'đã thanh toán' => 'badge-phoenix-success',
                                'đang chờ thanh toán' => 'badge-phoenix-warning',
                                'đã hủy' => 'badge-phoenix-secondary',
                                'thất bại' => 'badge-phoenix-danger',
                            ];
                        @endphp
                        @forelse ($payments as $payment)
                            @php
                                $status = $payment->status === 'đã hoàn thành' ? 'đã thanh toán' : $payment->status;
                                $statusClass = $statusMap[$status] ?? 'badge-phoenix-secondary';
                            @endphp
                            <tr class="position-static">

                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $payment->id }}</span>
                                </td>
                                <td class="transaction_code align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0"
                                        href="{{ route('admin.payments.show', $payment->id) }}">{{ $payment->transaction_code }}</a>
                                </td>
                                <td class="order_id align-middle ps-4">
                                    @if ($payment->order)
                                        <a class="fw-semibold"
                                            href="{{ route('admin.orders.show', $payment->order->id) }}">
                                            {{ $payment->order->order_number ?? 'Không có số đơn' }}
                                        </a>
                                    @else
                                        <span class="text-body-tertiary">Không có</span>
                                    @endif
                                </td>
                                <td class="amount align-middle ps-4">
                                    <span class="fw-semibold text-body-highlight">
                                        {{ number_format($payment->amount, 0, ',', '.') }} VND
                                    </span>
                                </td>
                                <td class="status align-middle ps-4">
                                    <span class="badge badge-phoenix fs-10 {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="payment_date align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') : ($payment->created_at ? $payment->created_at->format('d/m/Y H:i') : '') }}
                                </td>
                                <td class="payment_method align-middle ps-4">
                                    <span
                                        class="text-body-tertiary">{{ $payment->paymentMethod->name ?? 'Không xác định' }}</span>
                                </td>
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
                                                href="{{ route('admin.payments.show', $payment->id) }}">Xem chi
                                                tiết</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Không có thanh toán nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info>
                        Tổng: {{ $payments->count() }} thanh toán
                    </p>
                    <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả <span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn <span
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
