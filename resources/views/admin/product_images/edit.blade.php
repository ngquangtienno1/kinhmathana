@extends('admin.layouts')
@section('title', 'Chỉnh sửa ảnh sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('product_images.index', $product->id) }}">Ảnh sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa ảnh</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chỉnh sửa ảnh sản phẩm</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('product_images.update', [$product->id, $image->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Ảnh hiện tại</label><br>
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" style="max-height: 200px;">
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="image">Thay ảnh mới (tùy chọn)</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_thumbnail" id="is_thumbnail" value="1" {{ $image->is_thumbnail ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_thumbnail">Đặt làm ảnh thumbnail</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('product_images.index', $product->id) }}" class="btn btn-light">Quay lại</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
