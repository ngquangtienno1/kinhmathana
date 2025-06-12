@extends('admin.layouts')
@section('title', 'Khách hàng')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Khách hàng</a>
    </li>
    <li class="breadcrumb-item active">Tất cả khách hàng</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0"> Danh sách khách hàng</h2>
        </div>
    </div>

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.customers.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $customers->count() }})</span></a></li>
    </ul>

    <div id="customerTable"
        data-list='{"valueNames":["id","name","email","phone","orders","spent","type","date"],"page":10,"pagination":true}'>

        <div class="mb-4">
            <div class="row g-3 align-items-center">
                <!-- Ô tìm kiếm -->
                <div class="col-auto">
                    <div class="search-box">
                        <form class="position-relative" action="{{ route('admin.customers.index') }}" method="GET">
                            <input class="form-control search-input search" type="search" name="search"
                                id="customer-search-input" placeholder="Nhập tên, email hoặc số điện thoại"
                                value="{{ request('search') }}" aria-label="Search"
                                style="min-width: 300px; height: 40px;" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                    </div>
                </div>
                <!-- Các filter dropdown -->
                <div class="col">
                    <div class="d-flex align-items-center gap-0">
                        <!-- Customer type -->
                        <div class="btn-group position-static text-nowrap" role="group">
                            <button class="btn btn-phoenix-secondary px-7 py-2 border-end" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent" style="border-radius: 8px 0 0 8px; height: 40px;">
                                Loại khách hàng <span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.customers.index', array_merge(request()->except('customer_type'), ['customer_type' => 'new'])) }}">Mới</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.customers.index', array_merge(request()->except('customer_type'), ['customer_type' => 'regular'])) }}">Thường</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.customers.index', array_merge(request()->except('customer_type'), ['customer_type' => 'vip'])) }}">VIP</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.customers.index', array_merge(request()->except('customer_type'), ['customer_type' => 'potential'])) }}">Tiềm
                                        năng</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Export -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <a href="{{ route('admin.customers.export', request()->query()) }}" class="btn btn-link text-body px-0 d-flex align-items-center"
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
                                        id="checkbox-bulk-customer-select" type="checkbox"
                                        data-bulk-select='{"body":"customer-table-body"}' /></div>
                            </th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="id"
                                style="width:90px;">ID</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="name"
                                style="width:180px;">Họ tên</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="email"
                                style="width:180px;">Email</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="phone"
                                style="width:130px;">Số điện thoại</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="orders"
                                style="width:110px;">Số đơn</th>
                            <th class="sort align-middle text-end px-3" scope="col" data-sort="spent"
                                style="width:130px;">Tổng chi tiêu</th>
                            <th class="sort align-middle text-center px-3" scope="col" data-sort="type"
                                style="width:130px;">Loại khách</th>
                            <th class="sort align-middle text-center px-3 white-space-nowrap" scope="col"
                                data-sort="date" style="width:120px;">Ngày đăng ký</th>
                            <th class="sort text-center align-middle px-3" scope="col" style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="customer-table-body">
                        @forelse ($customers as $customer)
                            <tr>
                                <td class="fs-9 align-middle px-0 py-3">
                                    <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                            type="checkbox" /></div>
                                </td>
                                <td class="id align-middle text-center white-space-nowrap py-0">
                                    {{ $customer->id }}
                                </td>
                                <td class="name align-middle text-center white-space-nowrap px-3">
                                    {{ $customer->user->name }}
                                </td>
                                <td class="email align-middle text-center white-space-nowrap px-3">
                                    {{ $customer->user->email }}
                                </td>
                                <td class="phone align-middle text-center white-space-nowrap px-3">
                                    {{ $customer->user->phone }}
                                </td>
                                <td class="orders align-middle text-center white-space-nowrap px-3">
                                    {{ $customer->total_orders }}
                                </td>
                                <td class="spent align-middle text-end fw-semibold text-body-highlight px-3"
                                    style="white-space:nowrap;">
                                    {{ number_format($customer->calculated_total_spent) }} <span
                                        class="text-muted ms-1">VND</span>
                                </td>
                                <td
                                    class="type align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
                                    @php
                                        $typeMap = [
                                            'vip' => ['VIP', 'badge-phoenix-danger', 'star'],
                                            'new' => ['Mới', 'badge-phoenix-success', 'user-plus'],
                                            'regular' => ['Thường', 'badge-phoenix-info', 'user'],
                                            'potential' => ['Tiềm năng', 'badge-phoenix-warning', 'trending-up'],
                                        ];
                                        $type = $typeMap[$customer->customer_type] ?? [
                                            ucfirst($customer->customer_type),
                                            'badge-phoenix-secondary',
                                            'user',
                                        ];
                                    @endphp
                                    <span class="badge badge-phoenix fs-10 {{ $type[1] }}">
                                        <span class="badge-label">{{ $type[0] }}</span>
                                        <span class="ms-1" data-feather="{{ $type[2] }}"
                                            style="height:12.8px;width:12.8px;"></span>
                                    </span>
                                </td>
                                <td
                                    class="date align-middle text-center white-space-nowrap text-body-tertiary fs-9 px-3">
                                    {{ $customer->created_at->format('d/m/Y H:i') }}
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
                                                href="{{ route('admin.customers.show', $customer) }}">Chi tiết</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editTypeModal{{ $customer->id }}">Sửa</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">Không có khách hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        Tổng: {{ $customers->count() }} khách hàng
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

@foreach ($customers as $customer)
    <!-- Modal sửa loại khách hàng -->
    <div class="modal fade" id="editTypeModal{{ $customer->id }}" tabindex="-1"
        aria-labelledby="editTypeModalLabel{{ $customer->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.customers.update-type', $customer) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTypeModalLabel{{ $customer->id }}">Cập nhật loại khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="customer_type{{ $customer->id }}" class="form-label"><strong>Loại khách hàng</strong></label>
                            <select name="customer_type" id="customer_type{{ $customer->id }}" class="form-select">
                                <option value="new" {{ $customer->customer_type == 'new' ? 'selected' : '' }}>Mới</option>
                                <option value="regular" {{ $customer->customer_type == 'regular' ? 'selected' : '' }}>Thường</option>
                                <option value="vip" {{ $customer->customer_type == 'vip' ? 'selected' : '' }}>VIP</option>
                                <option value="potential" {{ $customer->customer_type == 'potential' ? 'selected' : '' }}>Tiềm năng</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
