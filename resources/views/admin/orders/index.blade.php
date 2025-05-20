@extends('admin.layouts')
@section('title', 'Orders')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="#">Orders</a>
</li>
<li class="breadcrumb-item active">All Orders</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Orders</h2>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-3 mb-3">
        <div class="search-box">
            <form class="position-relative" method="GET" action="">
                <input class="form-control search-input search" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm đơn hàng" aria-label="Tìm kiếm" />
                <span class="fas fa-search search-box-icon"></span>
            </form>
        </div>
        <div class="ms-xxl-auto">
            <a href="#" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Thêm đơn hàng</a>
        </div>
    </div>
    <div class="table-responsive scrollbar mx-n1 px-1 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
        <table class="table fs-9 mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name ?? 'N/A' }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.status.history', $order) }}" class="btn btn-sm btn-info">
                            Lịch sử trạng thái
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Chưa có đơn hàng nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
        <div class="col-auto d-flex">
            <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                Hiển thị {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} trên tổng số {{ $orders->total() }} đơn hàng
            </p>
        </div>
        <div class="col-auto d-flex">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection