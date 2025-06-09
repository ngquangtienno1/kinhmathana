@extends('admin.layouts')

@section('title', 'Lịch sử trạng thái đơn hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
    </li>
    <li class="breadcrumb-item active">Lịch sử trạng thái đơn hàng</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Lịch sử trạng thái đơn hàng</h2>
            </div>
        </div>
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    Tất cả <span class="text-body-tertiary fw-semibold">({{ $histories->total() }})</span>
                </a>
            </li>
        </ul>
        <div id="orderStatusHistoryTable"
            data-list='{"valueNames":["order_code","customer","old_status","new_status","updated_at","updated_by"],"page":10,"pagination":true}'>
            <div class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <div class="search-box">
                            <form class="position-relative">
                                <input class="form-control search-input search" type="search" name="search"
                                    id="order-status-history-search-input"
                                    placeholder="Nhập mã đơn hàng hoặc tên khách hàng" value="{{ request('search') }}"
                                    aria-label="Search" style="min-width: 300px; height: 40px;" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
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
                                            id="checkbox-bulk-history-select" type="checkbox"
                                            data-bulk-select='{"body":"order-status-histories-table-body"}' /></div>
                                </th>
                                <th class="sort align-middle text-center px-3" scope="col" data-sort="order_code"
                                    style="width:90px;">Mã đơn hàng</th>
                                <th class="sort align-middle text-center px-3" scope="col" data-sort="customer"
                                    style="width:180px;">Khách hàng</th>
                                <th class="sort align-middle text-center px-3" scope="col" data-sort="old_status"
                                    style="width:150px;">Trạng thái cũ</th>
                                <th class="sort align-middle text-center px-3" scope="col" data-sort="new_status"
                                    style="width:150px;">Trạng thái mới</th>
                                <th class="sort align-middle text-center px-3" scope="col" data-sort="updated_at"
                                    style="width:120px;">Thời gian cập nhật</th>
                                <th class="sort align-middle text-center px-3" scope="col" data-sort="updated_by"
                                    style="width:130px;">Cập nhật bởi</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="order-status-histories-table-body">
                            @forelse ($histories as $history)
                                <tr>
                                    <td class="fs-9 align-middle px-0 py-3">
                                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="order_code align-middle text-center white-space-nowrap py-0">
                                        <a class="fw-semibold" href="{{ route('admin.orders.show', $history->order_id) }}">
                                            #{{ $history->order->order_number ?? $history->order_id }}
                                        </a>
                                    </td>
                                    <td class="customer align-middle text-center white-space-nowrap px-3">
                                        {{ $history->order->user->name ?? 'Khách hàng ẩn danh' }}
                                    </td>
                                    <td
                                        class="old_status align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
                                        @php
                                            $orderStatusMap = [
                                                'pending' => ['Chờ xác nhận', 'badge-phoenix-warning', 'clock'],
                                                'confirmed' => ['Đã xác nhận', 'badge-phoenix-primary', 'check'],
                                                'awaiting_pickup' => ['Chờ lấy hàng', 'badge-phoenix-info', 'package'],
                                                'shipping' => ['Đang giao', 'badge-phoenix-primary', 'truck'],
                                                'delivered' => ['Đã giao hàng', 'badge-phoenix-success', 'check'],
                                                'completed' => ['Đã hoàn thành', 'badge-phoenix-primary', 'award'],
                                                'cancelled_by_customer' => [
                                                    'Khách hủy đơn',
                                                    'badge-phoenix-danger',
                                                    'x',
                                                ],
                                                'cancelled_by_admin' => ['Admin hủy đơn', 'badge-phoenix-danger', 'x'],
                                                'delivery_failed' => ['Giao thất bại', 'badge-phoenix-danger', 'x'],
                                            ];
                                            $os = $orderStatusMap[$history->old_status] ?? [
                                                ucfirst($history->old_status),
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
                                        class="new_status align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
                                        @php
                                            $os = $orderStatusMap[$history->new_status] ?? [
                                                ucfirst($history->new_status),
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
                                    <td class="updated_at align-middle text-center white-space-nowrap px-3">
                                        {{ $history->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="updated_by align-middle text-center white-space-nowrap px-3">
                                        {{ $history->updatedBy->name ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                            <!-- Content will be filled by List.js -->
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
