@extends('admin.layouts')

@section('title', 'Thêm biến thể sản phẩm')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Biến thể</a>
    </li>
    <li class="breadcrumb-item active">Thêm biến thể sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thêm biến thể</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.variations.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- Sản phẩm cha --}}
                    <div class="col-6">
                        <label class="form-label">Sản phẩm cha <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tên biến thể + SKU --}}
                    <div class="col-6">
                        <label class="form-label">Tên biến thể <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Mã SKU <span class="text-danger">*</span></label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="form-control @error('sku') is-invalid @enderror">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Giá cả --}}
                    <div class="col-6">
                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                        <input type="number" name="price" step="0.01" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá nhập <span class="text-danger">*</span></label>
                        <input type="number" name="import_price" step="0.01" value="{{ old('import_price') }}" class="form-control @error('import_price') is-invalid @enderror">
                        @error('import_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <input type="number" name="sale_price" step="0.01" value="{{ old('sale_price') }}" class="form-control @error('sale_price') is-invalid @enderror">
                        @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>


                    {{-- Tồn kho --}}
                    <div class="col-6">
                        <label class="form-label">Tồn kho</label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" class="form-control @error('stock_quantity') is-invalid @enderror">
                        @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Màu sắc --}}
                    <div class="col-6">
                        <label class="form-label">Màu sắc</label>
                        <select name="color_id" class="form-control @error('color_id') is-invalid @enderror">
                            <option value="">-- Chọn màu --</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('color_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Kích thước --}}
                    <div class="col-6">
                        <label class="form-label">Kích thước</label>
                        <select name="size_id" class="form-control @error('size_id') is-invalid @enderror">
                            <option value="">-- Chọn kích thước --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('size_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('admin.variations.index') }}" class="btn btn-light">Hủy</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection
