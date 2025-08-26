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

                            <th class="sort align-middle text-center px-3 white-space-nowrap" scope="col"
                                data-sort="date" style="width:120px;">Ngày đăng ký</th>
                            <th class="sort text-center align-middle px-3" scope="col" style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="customer-table-body">
                        @forelse ($customers as $customer)
                            <tr>
                                <td class="fs-9 align-middle px-0 py-3">
                                    <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" />
                                    </div>
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có khách hàng nào</td>
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



@endsection
