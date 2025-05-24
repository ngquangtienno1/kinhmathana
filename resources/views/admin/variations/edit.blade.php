@extends('admin.layouts')
@section('title', 'Sửa biến thể sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.variations.index') }}">Biến thể</a>
    </li>
    <li class="breadcrumb-item active">Sửa biến thể sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa biến thể</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.variations.update', $variation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Sản phẩm cha <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">-- Chọn sản phẩm cha --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $variation->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tên biến thể <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $variation->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $variation->sku) }}">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $variation->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá nhập <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="import_price" class="form-control @error('import_price') is-invalid @enderror" value="{{ old('import_price', $variation->import_price) }}" required>
                        @error('import_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $variation->sale_price) }}" required>
                        @error('sale_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tồn kho</label>
                        <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity', $variation->stock_quantity) }}">
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Màu sắc --}}
                    <div class="col-6">
                        <label class="form-label">Màu sắc</label>
                        <select name="color_id" class="form-select @error('color_id') is-invalid @enderror">
                            <option value="">-- Chọn màu --</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}"
                                    {{ old('color_id', optional($variation->variationDetails->first())->color_id) == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('color_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kích thước --}}
                    <div class="col-6">
                        <label class="form-label">Kích thước</label>
                        <select name="size_id" class="form-select @error('size_id') is-invalid @enderror">
                            <option value="">-- Chọn kích thước --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}"
                                    {{ old('size_id', optional($variation->variationDetails->first())->size_id) == $size->id ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('size_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a href="{{ route('admin.variations.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
