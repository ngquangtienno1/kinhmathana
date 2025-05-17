@extends('admin.layouts')
@section('title', 'Sửa sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Sửa sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa sản phẩm</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Giá gốc</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                        @error('price')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Giá nhập</label>
                        <input type="number" step="0.01" name="import_price" class="form-control" value="{{ old('import_price', $product->import_price) }}">
                        @error('import_price')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Giá bán</label>
                        <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                        @error('sale_price')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                            @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Thương hiệu</label>
                        <select name="brand_id" class="form-control">
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                            @error('brand_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="Hoạt động" {{ old('status', $product->status) === 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="Không hoạt động" {{ old('status', $product->status) === 'Không hoạt động' ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="description_short" class="form-control" rows="2">{{ old('description_short', $product->description_short) }}</textarea>
                        @error('description_short')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea name="description_long" class="form-control" rows="4">{{ old('description_long', $product->description_long) }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_featured" value="0">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Sản phẩm nổi bật</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a href="{{ route('admin.products.list') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
