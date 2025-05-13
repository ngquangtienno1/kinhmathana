@extends('admin.layouts')

@section('title', 'Bảng điều khiển')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="pb-5">
    <div class="row g-4">
        <div class="col-12 col-xxl-6">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Đơn hàng mới <span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-10 ms-2">0.0%</span></h5>
                                    <h6 class="text-700">Trong 7 ngày qua</h6>
                                </div>
                                <h4>0</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="text-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-8 text-warning">0</span>
                                    </div>
                                    <p class="mb-0 mt-2 fs-9 text-800 fw-semi-bold"><span class="text-warning">⟹</span> Đơn hàng chờ xử lý</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center px-4 pb-4">
                                <a class="btn btn-link btn-sm px-0 fw-medium" href="{{ url('/admin/orders') }}">Xem chi tiết<span class="fas fa-chevron-right ms-1 fs-11"></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Doanh thu</h5>
                                    <h6 class="text-700">Trong 7 ngày qua</h6>
                                </div>
                                <h4>0₫</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="text-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-8 text-success">0%</span>
                                    </div>
                                    <p class="mb-0 mt-2 fs-9 text-800 fw-semi-bold"><span class="text-success">⟰</span> So với tuần trước</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center px-4 pb-4">
                                <a class="btn btn-link btn-sm px-0 fw-medium" href="{{ url('/admin/orders') }}">Xem chi tiết<span class="fas fa-chevron-right ms-1 fs-11"></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Khuyến mãi đang hoạt động</h5>
                                    <h6 class="text-700">Tổng số</h6>
                                </div>
                                <h4>0</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="text-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-8 text-info">0</span>
                                    </div>
                                    <p class="mb-0 mt-2 fs-9 text-800 fw-semi-bold">Khuyến mãi đang sử dụng</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center px-4 pb-4">
                                <a class="btn btn-link btn-sm px-0 fw-medium" href="{{ url('/admin/promotions') }}">Xem chi tiết<span class="fas fa-chevron-right ms-1 fs-11"></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Sản phẩm</h5>
                                    <h6 class="text-700">Tổng số</h6>
                                </div>
                                <h4>0</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="text-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-8 text-danger">0</span>
                                    </div>
                                    <p class="mb-0 mt-2 fs-9 text-800 fw-semi-bold">Sản phẩm hết hàng</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center px-4 pb-4">
                                <a class="btn btn-link btn-sm px-0 fw-medium" href="{{ url('/admin/products') }}">Xem chi tiết<span class="fas fa-chevron-right ms-1 fs-11"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xxl-6">
            <div class="card h-100">
                <div class="card-header bg-light d-flex flex-between-center py-2">
                    <h6 class="mb-0">Hoạt động gần đây</h6>
                </div>
                <div class="card-body scrollbar">
                    <div class="text-center py-5">
                        <div class="avatar avatar-xl">
                            <div class="avatar-emoji rounded-circle"><span role="img" aria-label="Emoji">🤔</span></div>
                        </div>
                        <h6 class="mt-3">Chưa có hoạt động nào</h6>
                        <p class="fs-9 mb-0 text-700">Các hoạt động trong hệ thống sẽ được hiển thị tại đây</p>
                    </div>
                </div>
                <div class="card-footer bg-light py-2">
                    <div class="text-center fs-9 fw-semibold text-700">
                        <a class="text-700" href="{{ url('/admin/activities') }}">Xem tất cả hoạt động</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card h-100">
                <div class="card-header border-bottom border-300 py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h6 class="mb-0">Biểu đồ doanh thu</h6>
                        </div>
                        <div class="col-auto d-none d-sm-block">
                            <select class="form-select form-select-sm" id="select-revenue-chart-month">
                                <option value="tháng này">Tháng này</option>
                                <option value="tháng trước">Tháng trước</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pb-4 d-flex justify-content-center">
                        <div class="text-center">
                            <div class="avatar avatar-xl">
                                <div class="avatar-emoji rounded-circle"><span role="img" aria-label="Emoji">📊</span></div>
                            </div>
                            <h6 class="mt-3">Chưa có dữ liệu thống kê</h6>
                            <p class="fs-9 mb-0 text-700">Biểu đồ doanh thu sẽ được hiển thị khi có đơn hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection