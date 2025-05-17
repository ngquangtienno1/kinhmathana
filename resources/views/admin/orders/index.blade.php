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
            <h2 class="mb-0">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Đơn hàng</font>
                </font>
            </h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Tất cả </font>
                    </font>
                </span><span class="text-body-tertiary fw-semibold">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">(68817)</font>
                    </font>
                </span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Đang chờ thanh toán </font>
                    </font>
                </span><span class="text-body-tertiary fw-semibold">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">(6)</font>
                    </font>
                </span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Chưa hoàn thành </font>
                    </font>
                </span><span class="text-body-tertiary fw-semibold">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">(17)</font>
                    </font>
                </span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Đã hoàn thành </font>
                    </font>
                </span><span class="text-body-tertiary fw-semibold">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">(6.810)</font>
                    </font>
                </span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Đã hoàn lại </font>
                    </font>
                </span><span class="text-body-tertiary fw-semibold">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">(8)</font>
                    </font>
                </span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Thất bại </font>
                    </font>
                </span><span class="text-body-tertiary fw-semibold">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">(2)</font>
                    </font>
                </span></a></li>
    </ul>
    <div id="orderTable"
        data-list="{&quot;valueNames&quot;:[&quot;order&quot;,&quot;total&quot;,&quot;customer&quot;,&quot;payment_status&quot;,&quot;fulfilment_status&quot;,&quot;delivery_type&quot;,&quot;date&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
      {{-- filepath: c:\laragon\www\DOANTOTNGHIEP\kinhmathana\resources\views\admin\orders\index.blade.php --}}
<div class="mb-4">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Nhập mã đơn hàng hoặc tên khách hàng" value="{{ request('search') }}">
        </div>
       
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
        </div>
    </form>
</div>
        {{-- <div class="mb-4">
            <div class="row g-3">
                <div class="col-auto">
                    <div class="search-box">
                        <form class="position-relative"><input class="form-control search-input search" type="search"
                                placeholder="Tìm kiếm đơn hàng" aria-label="Tìm kiếm">
                            <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                </path>
                            </svg><!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->
                        </form>
                    </div>
                </div>
                <div class="col-auto scrollbar overflow-hidden-y flex-grow-1">
                    <div class="btn-group position-static" role="group">
                        <div class="btn-group position-static text-nowrap" role="group"><button
                                class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Trạng thái thanh toán</font>
                                </font><svg class="svg-inline--fa fa-angle-down ms-2" aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="angle-down" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z">
                                    </path>
                                </svg><!-- <span class="fas fa-angle-down ms-2"></span> Font Awesome fontawesome.com -->
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Hoạt động</font>
                                        </font>
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Một hành động khác</font>
                                        </font>
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Có điều gì khác ở đây</font>
                                        </font>
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Liên kết tách biệt</font>
                                        </font>
                                    </a></li>
                            </ul>
                        </div>
                        <div class="btn-group position-static text-nowrap" role="group"><button
                                class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Trạng thái hoàn thành</font>
                                </font><svg class="svg-inline--fa fa-angle-down ms-2" aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="angle-down" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z">
                                    </path>
                                </svg><!-- <span class="fas fa-angle-down ms-2"></span> Font Awesome fontawesome.com -->
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Hoạt động</font>
                                        </font>
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Một hành động khác</font>
                                        </font>
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Có điều gì khác ở đây</font>
                                        </font>
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Liên kết tách biệt</font>
                                        </font>
                                    </a></li>
                            </ul>
                        </div><button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Thêm bộ lọc</font>
                            </font>
                        </button>
                    </div>
                </div>
                <div class="col-auto"><button class="btn btn-link text-body me-4 px-0"><svg
                            class="svg-inline--fa fa-file-export fs-9 me-2" aria-hidden="true" focusable="false"
                            data-prefix="fas" data-icon="file-export" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V288H216c-13.3 0-24 10.7-24 24s10.7 24 24 24H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM384 336V288H494.1l-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39H384zm0-208H256V0L384 128z">
                            </path>
                        </svg><!-- <span class="fa-solid fa-file-export fs-9 me-2"></span> Font Awesome fontawesome.com -->
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Xuất khẩu</font>
                        </font>
                    </button><button class="btn btn-primary"><svg class="svg-inline--fa fa-plus me-2"
                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z">
                            </path>
                        </svg><!-- <span class="fas fa-plus me-2"></span> Font Awesome fontawesome.com -->
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Thêm đơn hàng</font>
                        </font>
                    </button></div>
            </div>
        </div> --}}
        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table table-sm fs-9 mb-0">
                    <thead>
                        <tr>

                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order"
                                style="width:5%;">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Mã đơn hàng</font>
                                </font>
                            </th>
                            <th class="sort align-middle text-end" scope="col" data-sort="total"
                                style="width:6%;">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Tổng số tiền</font>
                                </font>
                            </th>
                            <th class="sort align-middle ps-8" scope="col" data-sort="customer"
                                style="width:28%; min-width: 250px;">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Khách hàng</font>
                                </font>
                            </th>
                            <th class="sort align-middle pe-3" scope="col" data-sort="payment_status"
                                style="width:10%;">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Trạng thái thanh toán</font>
                                </font>
                            </th>
                            <th class="sort align-middle text-start pe-3" scope="col"
                                data-sort="fulfilment_status" style="width:12%; min-width: 200px;">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Trạng thái đơn hàng</font>
                                </font>
                            </th>
                            <th class="sort align-middle text-start" scope="col" data-sort="delivery_type"
                                style="width:30%;">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Phương thức vận chuyển</font>
                                </font>
                            </th>
                            <th class="sort align-middle text-end pe-0" scope="col" data-sort="date">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Ngày đặt hàng</font>
                                </font>
                            </th>
                            <th class="sort align-middle text-end pe-0" scope="col" data-sort="date">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Thao tác</font>
                                </font>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="order-table-body">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td> <!-- Mã đơn hàng -->
                                <td class="text-end">{{ number_format($order->total_amount, 2) }} VND</td>
                                <!-- Tổng số tiền -->
                                <td>{{ $order->user->name ?? 'Khách hàng ẩn danh' }}</td> <!-- Tên khách hàng -->
                                <td>
                                    @if ($order->payment_status === 'paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @elseif ($order->payment_status === 'pending')
                                        <span class="badge bg-warning">Đang chờ</span>
                                    @elseif ($order->payment_status === 'failed')
                                        <span class="badge bg-danger">Thất bại</span>
                                    @elseif ($order->payment_status === 'refunded')
                                        <span class="badge bg-info">Đã hoàn tiền</span>
                                    @elseif ($order->payment_status === 'cancelled')
                                        <span class="badge bg-secondary">Đã hủy</span>
                                    @elseif ($order->payment_status === 'partially_paid')
                                        <span class="badge bg-primary">Thanh toán một phần</span>
                                    @elseif ($order->payment_status === 'disputed')
                                        <span class="badge bg-dark">Đang tranh chấp</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                    @endif
                                </td> <!-- Trạng thái thanh toán -->
                                <td>
                                    @if ($order->status === 'pending')
                                        <span class="badge bg-warning">Đang chờ xử lý</span>
                                    @elseif ($order->status === 'awaiting_payment')
                                        <span class="badge bg-info">Chờ thanh toán</span>
                                    @elseif ($order->status === 'confirmed')
                                        <span class="badge bg-primary">Đã xác nhận</span>
                                    @elseif ($order->status === 'processing')
                                        <span class="badge bg-secondary">Đang xử lý</span>
                                    @elseif ($order->status === 'shipping')
                                        <span class="badge bg-dark">Đang vận chuyển</span>
                                    @elseif ($order->status === 'delivered')
                                        <span class="badge bg-success">Đã giao hàng</span>
                                    @elseif ($order->status === 'returned')
                                        <span class="badge bg-danger">Khách trả hàng</span>
                                    @elseif ($order->status === 'processing_return')
                                        <span class="badge bg-warning">Đang xử lý trả hàng</span>
                                    @elseif ($order->status === 'refunded')
                                        <span class="badge bg-info">Đã hoàn tiền</span>
                                 @elseif ($order->status === 'cancelled')
                                        <span class="badge bg-info">Đã huỷ</span>
                                    @endif
                                </td> <!-- Trạng thái đơn hàng -->
                                <td>
                                    @if ($order->shipping)
                                        {{ $order->shipping->shipping_provider }}
                                        ({{ $order->shipping->tracking_code }})
                                    @else
                                        Không có thông tin vận chuyển
                                    @endif
                                </td> <!-- Phương thức vận chuyển -->
                                <td class="text-end">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <!-- Ngày đặt hàng -->
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fas fa-sort"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-eye me-2"></i> Chi tiết
                                            </a>
                                            @if ($order->status == 'cancelled')
                                                <a href="#" class="dropdown-item text-danger"
                                                    onclick="event.preventDefault(); 
                                               if(confirm('Bạn có chắc muốn xóa đơn hàng này?')) {
                                                   document.getElementById('delete-order-{{ $order->id }}').submit();
                                               }">
                                                    <i class="fas fa-trash me-2"></i> Xóa đơn hàng
                                                </a>
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
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">1 đến 10 </font>
                        </font><span class="text-body-tertiary">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">mục trong tổng số</font>
                            </font>
                        </span>
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;"> 15</font>
                        </font>
                    </p><a class="fw-semibold" href="#!" data-list-view="*">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Xem tất cả</font>
                        </font><svg class="svg-inline--fa fa-angle-right ms-1" data-fa-transform="down-1"
                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right"
                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""
                            style="transform-origin: 0.3125em 0.5625em;">
                            <g transform="translate(160 256)">
                                <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                    <path fill="currentColor"
                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"
                                        transform="translate(-160 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                    </a><a class="fw-semibold d-none" href="#!" data-list-view="less">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Xem ít hơn</font>
                        </font><svg class="svg-inline--fa fa-angle-right ms-1" data-fa-transform="down-1"
                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right"
                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""
                            style="transform-origin: 0.3125em 0.5625em;">
                            <g transform="translate(160 256)">
                                <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                    <path fill="currentColor"
                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"
                                        transform="translate(-160 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                    </a>
                </div>
                <div class="col-auto d-flex"><button class="page-link disabled" data-list-pagination="prev"
                        disabled=""><svg class="svg-inline--fa fa-chevron-left" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="chevron-left" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z">
                            </path>
                        </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                    <ul class="mb-0 pagination">
                        <li class="active"><button class="page" type="button" data-i="1" data-page="10">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">1</font>
                                </font>
                            </button></li>
                        <li><button class="page" type="button" data-i="2" data-page="10">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">2</font>
                                </font>
                            </button></li>
                    </ul><button class="page-link pe-0" data-list-pagination="next"><svg
                            class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false"
                            data-prefix="fas" data-icon="chevron-right" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z">
                            </path>
                        </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
