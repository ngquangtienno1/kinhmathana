@extends('admin.layouts')

@section('title', 'Thêm sản phẩm')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Products</a>
    </li>
    <li class="breadcrumb-item active">Thêm sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thêm sản phẩm</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá nhập <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="import_price" value="{{ old('import_price') }}" class="form-control @error('import_price') is-invalid @enderror" required>
                        @error('import_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" class="form-control @error('sale_price') is-invalid @enderror" required>
                        @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                          @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Thương hiệu</label>
                        <select name="brand_id" class="form-control">
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                           @error('brand_id')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="Hoạt động" {{ old('status') == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="Không hoạt động" {{ old('status') == 'Không hoạt động' ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                         @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Mô tả ngắn<span class="text-danger">*</span></label>
                        <textarea name="description_short" class="form-control" rows="2">{{ old('description_short') }}</textarea>
                          @error('description_short')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea name="description_long" class="form-control" rows="4">{{ old('description_long') }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Sản phẩm nổi bật</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('admin.products.list') }}" class="btn btn-light">Hủy</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
