@extends('admin.layouts')
@section('title', 'Chi tiết biến thể sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.variations.index') }}">Biến thể</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết biến thể</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết biến thể</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.variations.edit', $variation->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.variations.destroy', $variation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger" onclick="return confirm('Xóa biến thể này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.variations.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mt-4" id="variationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                type="button" role="tab" aria-controls="info" aria-selected="true">Thông tin</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images"
                type="button" role="tab" aria-controls="images" aria-selected="false">Ảnh biến thể</button>
        </li>
    </ul>

    <div class="tab-content pt-3" id="variationTabsContent">
        {{-- Tab: Thông tin --}}
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">Thông tin cơ bản</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th width="200px">Tên biến thể</th><td>{{ $variation->name }}</td></tr>
                                <tr><th>SKU</th><td>{{ $variation->sku }}</td></tr>
                                <tr><th>Giá gốc</th><td>{{ number_format($variation->price, 0, ',', '.') }}đ</td></tr>
                                <tr><th>Giá nhập</th><td>{{ number_format($variation->import_price, 0, ',', '.') }}đ</td></tr>
                                <tr><th>Giá bán</th><td>{{ number_format($variation->sale_price, 0, ',', '.') }}đ</td></tr>
                                <tr><th>Tồn kho</th><td>{{ $variation->stock_quantity }}</td></tr>
                                <tr><th>Sản phẩm cha</th><td>{{ optional($variation->product)->name ?? 'Không có' }}</td></tr>
                                <tr><th>Màu sắc</th><td>{{ optional(optional($variation->variationDetails->first())->color)->name ?? '-' }}</td></tr>
                                <tr><th>Kích thước</th><td>{{ optional(optional($variation->variationDetails->first())->size)->name ?? '-' }}</td></tr>
                                <tr><th>Ngày tạo</th><td>{{ $variation->created_at->format('d/m/Y H:i') }}</td></tr>
                                <tr><th>Ngày cập nhật</th><td>{{ $variation->updated_at ? $variation->updated_at->format('d/m/Y H:i') : 'Chưa cập nhật' }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab: Ảnh --}}
        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ảnh biến thể</h5>
                    <a href="{{ route('admin.variation_images.index', $variation->id) }}" class="btn btn-sm btn-primary">
                        Quản lý ảnh
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($variation->images as $image)
                            <div class="col-md-3 mb-3">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         class="card-img-top rounded"
                                         style="height: 180px; object-fit: cover;">
                                    <div class="card-body text-center p-2">
                                        @if ($image->is_thumbnail)
                                            <span class="badge bg-success">Thumbnail</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Chưa có ảnh nào cho biến thể này.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
