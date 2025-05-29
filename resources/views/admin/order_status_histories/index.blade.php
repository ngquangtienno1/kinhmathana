@extends('admin.layouts')

@section('title', 'Lịch sử cập nhật trạng thái đơn hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
    </li>
    <li class="breadcrumb-item active">Lịch sử cập nhật trạng thái</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Lịch sử cập nhật trạng thái đơn hàng</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link active" href="#">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $histories->total() }})</span>
            </a>
        </li>
    </ul>
    <div id="order-status-histories" data-list='{"valueNames":["order_code","customer","old_status","new_status","updated_at","updated_by"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.orders.status_histories.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm mã đơn hàng hoặc tên khách hàng" value="{{ request('search') }}" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
            </div>
        </div>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">#</th>
                            <th class="sort white-space-nowrap align-middle ps-4">Mã đơn hàng</th>
                            <th class="sort align-middle ps-4">Khách hàng</th>
                            <th class="sort align-middle ps-4">Trạng thái cũ</th>
                            <th class="sort align-middle ps-4">Trạng thái mới</th>
                            <th class="sort align-middle ps-4">Thời gian cập nhật</th>
                            <th class="sort align-middle ps-4">Người cập nhật</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="order-status-histories-table-body">
                        @forelse ($histories as $history)
                            <tr class="position-static">
                                <td class="align-middle ps-0">{{ ($histories->currentPage() - 1) * $histories->perPage() + $loop->iteration }}</td>
                                <td class="align-middle ps-4 order_code">{{ $history->order->code ?? $history->order_id }}</td>
                                <td class="align-middle ps-4 customer">{{ $history->order->user->name ?? '-' }}</td>
                                <td class="align-middle ps-4 old_status">{{ $history->old_status }}</td>
                                <td class="align-middle ps-4 new_status">{{ $history->new_status }}</td>
                                <td class="align-middle ps-4 updated_at">{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td class="align-middle ps-4 updated_by">{{ $history->user->name ?? '-' }}</td>
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
                        Tổng: {{ $histories->total() }} bản ghi
                    </p>
                </div>
                <div class="col-auto d-flex">
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 