@extends('admin.layouts')

@section('title', 'Chi tiết khuyến mãi')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.promotions.index') }}">Khuyến mãi</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết khuyến mãi</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Chi tiết khuyến mãi</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-phoenix-primary">
                        <span class="fas fa-edit me-2"></span>Sửa
                    </a>
                    <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-phoenix-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')">
                            <span class="fas fa-trash me-2"></span>Xóa
                        </button>
                    </form>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-phoenix-secondary">
                        <span class="fas fa-arrow-left me-2"></span>Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">Thông tin khuyến mãi</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Tên khuyến mãi</th>
                                        <td>{{ $promotion->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mã khuyến mãi</th>
                                        <td><code>{{ $promotion->code }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả</th>
                                        <td>{{ $promotion->description ?: 'Không có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Loại giảm giá</th>
                                        <td>
                                            {{ $promotion->discount_type === 'percentage' ? 'Phần trăm (%)' : 'Số tiền cố định' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Giá trị giảm</th>
                                        <td>
                                            @if ($promotion->discount_type === 'percentage')
                                                {{ (int) $promotion->discount_value }}%
                                            @else
                                                {{ number_format($promotion->discount_value, 0, ',', '.') }}₫
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Giá trị đơn tối thiểu</th>
                                        <td>
                                            {{ $promotion->minimum_purchase ? number_format($promotion->minimum_purchase, 0, ',', '.') . 'đ' : 'Không có' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Giới hạn lượt dùng</th>
                                        <td>
                                            {{ $promotion->usage_limit ? $promotion->used_count . ' / ' . $promotion->usage_limit : 'Không giới hạn' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày bắt đầu</th>
                                        <td>{{ $promotion->start_date->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày kết thúc</th>
                                        <td>{{ $promotion->end_date->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span class="badge {{ $promotion->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $promotion->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $promotion->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $promotion->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">Điều kiện áp dụng</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 250px;">Giá trị đơn hàng tối thiểu</th>
                                        <td>
                                            @if ($promotion->minimum_purchase > 0)
                                                {{ number_format($promotion->minimum_purchase, 0, ',', '.') }}đ
                                            @else
                                                Không yêu cầu
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Danh mục áp dụng</th>
                                        <td>
                                            @if ($promotion->categories->count() > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($promotion->categories as $category)
                                                        <li>{{ $category->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Áp dụng cho tất cả danh mục
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sản phẩm áp dụng</th>
                                        <td>
                                            @if ($promotion->products->count() > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($promotion->products as $product)
                                                        <li>{{ $product->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Áp dụng cho tất cả sản phẩm
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
