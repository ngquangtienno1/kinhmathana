@extends('admin.layouts')

@section('title', 'Promotions')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="#">Promotions</a>
</li>
<li class="breadcrumb-item active">Chi tiết khuyến mãi</li>
@endsection

@section('content')
<div class="row g-3 flex-between-end mb-5">
    <div class="col-auto">
        <h2 class="mb-2">Chi tiết khuyến mãi</h2>
        <h5 class="text-body-tertiary fw-semibold">Thông tin chi tiết về khuyến mãi</h5>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0">Quay lại</a>
        <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-primary mb-2 mb-sm-0">Chỉnh sửa</a>
    </div>
</div>

<div class="row g-5">
    <div class="col-12 col-xl-8">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="mb-3">Thông tin khuyến mãi</h4>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Tên khuyến mãi:</h5>
                            <span class="text-body-highlight">{{ $promotion->name }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Mã khuyến mãi:</h5>
                            <span class="text-body-highlight">{{ $promotion->code }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Mô tả:</h5>
                            <span class="text-body-highlight">{{ $promotion->description ?: 'Không có mô tả' }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Loại giảm giá:</h5>
                            <span class="text-body-highlight">
                                {{ $promotion->discount_type === 'percentage' ? 'Phần trăm (%)' : 'Số tiền cố định' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Giá trị giảm:</h5>
                            <span class="text-body-highlight">
                                {{ $promotion->discount_value }}
                                {{ $promotion->discount_type === 'percentage' ? '%' : '$' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Giá trị đơn tối thiểu:</h5>
                            <span class="text-body-highlight">
                                {{ $promotion->minimum_purchase ? number_format($promotion->minimum_purchase, 2) . '$' : 'Không có' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Giới hạn lượt dùng:</h5>
                            <span class="text-body-highlight">
                                {{ $promotion->usage_limit ?: 'Không giới hạn' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Ngày bắt đầu:</h5>
                            <span class="text-body-highlight">{{ $promotion->start_date }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="mb-0 me-2">Ngày kết thúc:</h5>
                            <span class="text-body-highlight">{{ $promotion->end_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($promotion->products->count() > 0)
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Sản phẩm áp dụng</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotion->products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }}$</td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Thông tin khác</h4>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="mb-0 me-2">Trạng thái:</h5>
                        <span class="badge {{ $promotion->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $promotion->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="mb-0 me-2">Ngày tạo:</h5>
                        <span class="text-body-highlight">{{ $promotion->created_at }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="mb-0 me-2">Cập nhật lần cuối:</h5>
                        <span class="text-body-highlight">{{ $promotion->updated_at }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 