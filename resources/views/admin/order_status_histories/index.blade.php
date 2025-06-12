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
        <div id="orderStatusHistoryTable"
            data-list='{"valueNames":["order_code","customer","old_status","new_status","updated_at","updated_by"],"page":10,"pagination":true}'>
            <div class="mb-4">
                <!-- Combined Filter Form -->
                <form action="{{ route('admin.orders.status_histories.index') }}" method="GET">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <!-- Search Input -->
                        <div class="search-box">
                                <input class="form-control search-input search" type="search" name="search"
                                placeholder="Tìm mã đơn hàng hoặc tên khách hàng" value="{{ request('search') }}"
                                aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                        </div>

                        <!-- Status Filter -->
                        <div class="scrollbar overflow-hidden-y">
                            <div class="btn-group position-static" role="group">
                                <div class="btn-group position-static text-nowrap">
                                    <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                        data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent" style="background-color:white">
                                        Trạng thái
                                        <span class="fas fa-angle-down ms-2"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ !request('status') ? 'active' : '' }}"
                                                href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['status', 'page']), ['search' => request('search')])) }}">
                                                Tất cả ({{ $histories->count() }})
                                            </a>
                                        </li>
                                        @php
                                            $statusMap = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => 'Đã xác nhận',
                                                'shipping' => 'Đang giao',
                                                'delivered' => 'Đã giao',
                                                'completed' => 'Hoàn thành',
                                                'cancelled' => 'Đã hủy',
                                            ];
                                        @endphp
                                        @foreach ($statusMap as $key => $value)
                                            <li>
                                                <a class="dropdown-item {{ request('status') == $key ? 'active' : '' }}"
                                                    href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['status', 'page']), ['status' => $key, 'search' => request('search')])) }}">
                                                    {{ $value }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="d-flex align-items-center gap-2">
                            <input type="date" class="form-control" id="startDate" name="start_date"
                                style="width: 150px;" value="{{ request('start_date') }}" placeholder="Từ ngày">
                            <span>-</span>
                            <input type="date" class="form-control" id="endDate" name="end_date" style="width: 150px;"
                                value="{{ request('end_date') }}" placeholder="Đến ngày">
                        </div>
                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{ route('admin.orders.status_histories.index') }}" class="btn btn-secondary">Xoá</a>
                        </div>
                    </div>
                </form>
            </div>

            <div
                class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                <div class="table-responsive scrollbar mx-n1 px-1">
                    <table class="table fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        ID
                                        @if (request('sort') === 'id')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'order_code', 'direction' => request('sort') === 'order_code' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        Mã đơn hàng
                                        @if (request('sort') === 'order_code')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:200px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'customer', 'direction' => request('sort') === 'customer' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        Khách hàng
                                        @if (request('sort') === 'customer')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'old_status', 'direction' => request('sort') === 'old_status' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        Trạng thái cũ
                                        @if (request('sort') === 'old_status')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'new_status', 'direction' => request('sort') === 'new_status' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        Trạng thái mới
                                        @if (request('sort') === 'new_status')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'updated_at', 'direction' => request('sort') === 'updated_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        Thời gian cập nhật
                                        @if (request('sort') === 'updated_at')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.orders.status_histories.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'updated_by', 'direction' => request('sort') === 'updated_by' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        Cập nhật bởi
                                        @if (request('sort') === 'updated_by')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list" id="order-status-histories-table-body">
                            @forelse ($histories as $history)
                                <tr>
                                    <td class="id align-middle ps-4">
                                        <span class="text-body-tertiary">{{ $history->id }}</span>
                                    </td>
                                    <td class="order_code align-middle ps-4">
                                        <a href="{{ route('admin.orders.show', $history->order_id) }}">
                                            #{{ $history->order->order_number ?? $history->order_id }}
                                        </a>
                                    </td>
                                    <td class="customer align-middle ps-4">
                                        {{ $history->order->user->name ?? 'Khách hàng ẩn danh' }}
                                    </td>
                                    <td class="old_status align-middle ps-4">
                                        @php
                                            $orderStatusMap = [
                                                'pending' => ['Chờ xác nhận', 'badge-phoenix-warning'],
                                                'confirmed' => ['Đã xác nhận', 'badge-phoenix-primary'],
                                                'awaiting_pickup' => ['Chờ lấy hàng', 'badge-phoenix-info'],
                                                'shipping' => ['Đang giao', 'badge-phoenix-primary'],
                                                'delivered' => ['Đã giao hàng', 'badge-phoenix-success'],
                                                'completed' => ['Đã hoàn thành', 'badge-phoenix-primary'],
                                                'cancelled_by_customer' => ['Khách hủy đơn', 'badge-phoenix-danger'],
                                                'cancelled_by_admin' => ['Admin hủy đơn', 'badge-phoenix-danger'],
                                                'delivery_failed' => ['Giao thất bại', 'badge-phoenix-danger'],
                                            ];
                                            $os = $orderStatusMap[$history->old_status] ?? [
                                                ucfirst($history->old_status),
                                                'badge-phoenix-secondary',
                                            ];
                                        @endphp
                                        <span class="badge badge-phoenix fs-10 {{ $os[1] }}">
                                            {{ $os[0] }}
                                        </span>
                                    </td>
                                    <td class="new_status align-middle ps-4">
                                        @php
                                            $os = $orderStatusMap[$history->new_status] ?? [
                                                ucfirst($history->new_status),
                                                'badge-phoenix-secondary',
                                            ];
                                        @endphp
                                        <span class="badge badge-phoenix fs-10 {{ $os[1] }}">
                                            {{ $os[0] }}
                                        </span>
                                    </td>
                                    <td class="updated_at align-middle ps-4">
                                        {{ $history->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="updated_by align-middle ps-4">
                                        {{ $history->updatedBy->name ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                        <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn<span
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.querySelector('form[action*="admin.orders.status_histories.index"]');
                document.querySelectorAll('select.form-select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        if (filterForm) filterForm.submit();
                    });
                });
            });
        </script>
    </div>

@endsection
