@extends('admin.layouts')
@section('title', 'Chi tiết sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết sản phẩm</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.products.list') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ảnh sản phẩm</h5>
        <a href="{{ route('admin.product_images.index', ['product' => $product->id]) }}" class="btn btn-sm btn-primary">
    Quản lý ảnh
</a>
    </div>
    <div class="card-body">
        <div class="row">
            @forelse ($product->images as $image)
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top rounded" style="height: 180px; object-fit: cover;">
                        <div class="card-body text-center p-2">
                            @if ($image->is_thumbnail)
                                <span class="badge bg-success">Thumbnail</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">Chưa có ảnh cho sản phẩm này.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin cơ bản</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Tên sản phẩm</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Giá gốc</th>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                    </tr>
                                    <tr>
                                        <th>Giá nhập</th>
                                        <td>{{ number_format($product->import_price, 0, ',', '.') }}đ</td>
                                    </tr>
                                    <tr>
                                        <th>Giá bán</th>
                                        <td>{{ number_format($product->sale_price, 0, ',', '.') }}đ</td>
                                    </tr>
                                    <tr>
                                        <th>Danh mục</th>
                                        <td>{{ optional($product->category)->name ?? 'Không có' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Thương hiệu</th>
                                        <td>{{ optional($product->brand)->name ?? 'Không có' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả ngắn</th>
                                        <td>{{ $product->description_short ?? 'Không có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả chi tiết</th>
                                        <td>{{ $product->description_long ?? 'Không có mô tả chi tiết' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nổi bật</th>
                                        <td>
                                            <span class="badge {{ $product->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_featured ? 'Có' : 'Không' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span class="badge {{ $product->status === 'Hoạt động' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->status ?? 'Không xác định' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
