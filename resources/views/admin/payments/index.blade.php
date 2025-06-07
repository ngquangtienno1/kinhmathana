@extends('admin.layouts')
@section('title', 'Thanh Toán')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thanh Toán</a>
    </li>
    <li class="breadcrumb-item active">Quản lý thanh toán</li>
@endsection

<div class="mb-9">
    <div id="paymentSummary"
        data-list='{"valueNames":["paymentId","customerName","amount","status","paymentDate","action"],"page":10,"pagination":true}'>
        <div class="row mb-4 gx-6 gy-3 align-items-center">
            <div class="col-auto">
                <h2 class="mb-0">Quản lý thanh toán</h2>
            </div>
            {{-- <div class="col-auto">
                <a class="btn btn-primary px-5" href="{{ route('admin.payments.create') }}"><i
                        class="fa-solid fa-plus me-2"></i>Thêm thanh toán mới</a>
            </div> --}}
        </div>

        <div class="row g-3 justify-content-between align-items-end mb-4">
            <div class="col-12 col-sm-auto">
                <ul class="nav nav-links mx-n2">
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == null ? 'active' : '' }}"
                            href="{{ route('admin.payments.index') }}">
                            <span>Tất cả</span>
                            <span class="text-body-tertiary fw-semibold">({{ $tatca }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'đã hoàn thành' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'đã hoàn thành']) }}">
                            <span>Đã thanh toán</span>
                            <span class="text-body-tertiary fw-semibold">({{ $dathanhtoan }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'đang chờ thanh toán' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'đang chờ thanh toán']) }}">
                            <span>Đang chờ thanh toán</span>
                            <span class="text-body-tertiary fw-semibold">({{ $dangchothanhtoan }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'đã hủy' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'đã hủy']) }}">
                            <span>Đã hủy</span>
                            <span class="text-body-tertiary fw-semibold">({{ $huy }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'thất bại' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'thất bại']) }}">
                            <span>Thất bại</span>
                            <span class="text-body-tertiary fw-semibold">({{ $thatbai }})</span>
                        </a>
                    </li>
                </ul>
            </div>
            {{-- <div class="col-12 col-sm-auto">
                <div class="d-flex align-items-center">
                    <div class="search-box me-3">
                        <form method="GET" action="{{ route('admin.payments.index') }}" class="position-relative">
                            <input value="{{ request('search') }}" class="form-control search-input search"
                                name="search" type="search" placeholder="Tìm kiếm theo mã thanh toán"
                                aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>

                    </div>
                </div>
            </div> --}}
        </div>

        <div class="table-responsive scrollbar">
            <table class="table fs-9 mb-0 border-top border-translucent">
                <thead>
                    <tr>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="paymentId"
                            style="width:20%;">ID</th>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="paymentId"
                            style="width:20%;">MÃ THANH TOÁN</th>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="paymentId"
                            style="width:20%;">ĐƠN HÀNG ID</th>

                        <th class="sort align-middle ps-3" scope="col" data-sort="amount" style="width:15%;">SỐ TIỀN
                        </th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="status" style="width:15%;">TRẠNG
                            THÁI</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="paymentDate" style="width:15%;">
                            NGÀY THANH TOÁN</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="paymentDate" style="width:15%;">
                            PHƯƠNG THỨC THANH TOÁN</th>
                        <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                    </tr>
                </thead>
                <tbody class="list" id="payment-list-table-body">
                    @php
                        $statusMap = [
                            'đã thanh toán' => ['badge-phoenix-success', 'check'],
                            'đang chờ thanh toán' => ['badge-phoenix-warning', 'clock'],
                            'đã hủy' => ['badge-phoenix-secondary', 'x'],
                            'thất bại' => ['badge-phoenix-danger', 'x'],
                        ];
                    @endphp
                    @foreach ($payments as $payment)
                        @php
                            $status = $payment->status === 'đã hoàn thành' ? 'đã thanh toán' : $payment->status;
                            $map = $statusMap[$status] ?? ['badge-phoenix-secondary', 'info'];
                        @endphp
                        <tr>
                            <td class="align-middle text-center white-space-nowrap py-0 paymentId">
                                <a class="fw-semibold" href="#">{{ $payment->id }}</a>
                            </td>
                            <td class="align-middle text-center white-space-nowrap py-0 paymentId">
                                <a class="fw-semibold" href="#">{{ $payment->transaction_code }}</a>
                            </td>
                            <td class="align-middle text-center white-space-nowrap py-0">
                                @if ($payment->order)
                                    <a href="{{ route('admin.orders.show', $payment->order->id) }}">
                                        {{ $payment->order->order_number ?? 'Không có số đơn' }}
                                    </a>
                                @else
                                    Không có
                                @endif
                            </td>
                            <td class="align-middle text-end fw-semibold text-body-highlight px-3">
                                {{ number_format($payment->amount, 0, ',', '.') }} VND
                            </td>
                            <td class="align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
                                <span class="badge badge-phoenix fs-10 {{ $map[0] }}">
                                    <span class="badge-label">{{ $status }}</span>
                                    <span class="ms-1" data-feather="{{ $map[1] }}"
                                        style="height:12.8px;width:12.8px;"></span>
                                </span>
                            </td>
                            <td class="align-middle text-center white-space-nowrap text-body-tertiary fs-9 px-3">
                                {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') : ($payment->created_at ? $payment->created_at->format('d/m/Y H:i') : '') }}
                            </td>
                            <td class="align-middle text-center white-space-nowrap text-body fs-9 px-3">
                                {{ $payment->paymentMethod->name ?? 'Không xác định' }}
                            </td>
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
                                            href="{{ route('admin.payments.show', $payment->id) }}">Xem chi tiết</a>
                                        <form action="{{ route('admin.payments.destroy', $payment->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa thanh toán này?')">Xóa</button>
                                        </form>
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
                    Tổng: {{ $payments->count() }} đơn hàng
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


@endsection
