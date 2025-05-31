@extends('admin.layouts')
@section('title', 'Thêm sản phẩm')

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Thêm sản phẩm</h2>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="product-info-tab" data-bs-toggle="tab" data-bs-target="#product-info" type="button" role="tab" aria-controls="product-info" aria-selected="true">Thông tin sản phẩm</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="product-data-tab" data-bs-toggle="tab" data-bs-target="#product-data" type="button" role="tab" aria-controls="product-data" aria-selected="false">Dữ liệu sản phẩm</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="product-excerpt-tab" data-bs-toggle="tab" data-bs-target="#product-excerpt" type="button" role="tab" aria-controls="product-excerpt" aria-selected="false">Mô tả ngắn</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf
                    <div class="tab-content" id="productTabsContent">
                        <!-- Tab Thông tin sản phẩm -->
                        <div class="tab-pane fade show active" id="product-info" role="tabpanel" aria-labelledby="product-info-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description_long" id="description_long">{{ old('description_long') }}</textarea>
                                    @error('description_long')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tab Dữ liệu sản phẩm -->
                        <div class="tab-pane fade" id="product-data" role="tabpanel" aria-labelledby="product-data-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Loại sản phẩm</label>
                                    <select class="form-select" name="product_type" id="product_type">
                                        <option value="simple" {{ old('product_type', 'simple') == 'simple' ? 'selected' : '' }}>Sản phẩm đơn giản</option>
                                        <option value="variable" {{ old('product_type') == 'variable' ? 'selected' : '' }}>Sản phẩm có biến thể</option>
                                    </select>
                                    @error('product_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sản phẩm đơn giản -->
                                <div id="simple-product" class="product-type-content" style="{{ old('product_type') == 'variable' ? 'display:none' : '' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" id="simple_sku" value="{{ old('sku') }}">
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="stock_quantity" id="simple_stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required>
                                        @error('stock_quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control price-input" name="price" value="{{ old('price') }}" placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá khuyến mãi</label>
                                        <input type="text" class="form-control price-input" name="sale_price" value="{{ old('sale_price') }}" placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                        @error('sale_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm</label>
                                        <input type="text" class="form-control" name="slug" id="simple_slug" value="{{ old('slug') }}">
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sản phẩm có biến thể -->
                                <div id="variable-product" class="product-type-content" style="{{ old('product_type') == 'variable' ? '' : 'display:none' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" id="variable_sku" value="{{ old('sku') }}" readonly>
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm</label>
                                        <input type="text" class="form-control" name="slug" id="variable_slug" value="{{ old('slug') }}" readonly>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Thuộc tính biến thể</label>
                                        <button type="button" id="add-attribute" class="btn btn-primary btn-sm mb-2">Thêm thuộc tính</button>
                                        <div id="attributes-container">
                                            @foreach (old('attributes', []) as $index => $attribute)
                                                <div class="attribute-row row g-2 mb-2">
                                                    <div class="col-md-3">
                                                        <select name="attributes[{{ $index }}][type]" class="form-select attribute-type" data-index="{{ $index }}">
                                                            <option value="color" {{ isset($attribute['type']) && $attribute['type'] == 'color' ? 'selected' : '' }}>Màu sắc</option>
                                                            <option value="size" {{ isset($attribute['type']) && $attribute['type'] == 'size' ? 'selected' : '' }}>Kích thước</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="attribute-values-tags">
                                                            @if (isset($attribute['values']))
                                                                @foreach ((array) $attribute['values'] as $value)
                                                                    <span class="tag">
                                                                        {{ $value }}
                                                                        <input type="hidden" name="attributes[{{ $index }}][values][]" value="{{ $value }}">
                                                                        <button type="button" class="remove-tag" data-value="{{ $value }}">×</button>
                                                                    </span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <select class="form-select attribute-values" multiple>
                                                            @if (isset($attribute['type']) && $attribute['type'] == 'color')
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->name }}">{{ $color->name }}</option>
                                                                @endforeach
                                                            @elseif (isset($attribute['type']) && $attribute['type'] == 'size')
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->name }}">{{ $size->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="generate-variations" class="btn btn-primary btn-sm mt-2" style="{{ old('attributes') && count(old('attributes', [])) > 0 ? '' : 'display: none' }}">Tạo biến thể</button>
                                    </div>
                                    <div id="variations-container" class="mt-3" style="{{ old('variations') && count(old('variations', [])) > 0 ? '' : 'display: none' }}">
                                        @foreach (old('variations', []) as $index => $variation)
                                            <div class="variation-row row g-2 mb-2">
                                                <div class="col-md-2">
                                                    <input type="text" name="variations[{{ $index }}][name]" value="{{ $variation['name'] }}" class="form-control" placeholder="Tên biến thể" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="variations[{{ $index }}][sku]" value="{{ $variation['sku'] }}" class="form-control" placeholder="Mã sản phẩm">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control price-input" name="variations[{{ $index }}][price]" value="{{ $variation['price'] ?? '' }}" placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control price-input" name="variations[{{ $index }}][sale_price]" value="{{ $variation['sale_price'] ?? '' }}" placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" name="variations[{{ $index }}][stock_quantity]" value="{{ $variation['stock_quantity'] ?? 0 }}" class="form-control" placeholder="Tồn kho" min="0" required>
                                                </div>
                                                <div class="col-md-1">
                                                    <select name="variations[{{ $index }}][status]" class="form-select">
                                                        <option value="in_stock" {{ $variation['status'] ?? 'in_stock' == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                                                        <option value="out_of_stock" {{ $variation['status'] ?? 'in_stock' == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                                                        <option value="hidden" {{ $variation['status'] ?? 'in_stock' == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-variation">Xóa</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Mô tả ngắn -->
                        <div class="tab-pane fade" id="product-excerpt" role="tabpanel" aria-labelledby="product-excerpt-tab">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả ngắn <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description_short">{{ old('description_short') }}</textarea>
                                    @error('description_short')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phần phân loại -->
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @include('admin.partials.category-checkboxes', ['categories' => $categories, 'selected' => old('categories', [])])
                            </div>
                            @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                            <select class="form-select" name="brand_id">
                                <option value="">Chọn thương hiệu</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Xuất bản</button>
                            <a href="{{ route('admin.products.list') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .tag {
            display: inline-block;
            background-color: #e9ecef;
            padding: 5px 10px;
            margin: 5px 5px 0 0;
            border-radius: 5px;
            font-size: 14px;
        }
        .remove-tag {
            margin-left: 5px;
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-weight: bold;
            padding: 0;
        }
        .attribute-values {
            margin-top: 5px;
        }
    </style>
    <script>
        window.colors = @json($colors->pluck('name')); // Lấy danh sách tên màu sắc
        window.sizes = @json($sizes->pluck('name'));   // Lấy danh sách tên kích thước
    </script>
    @vite(['resources/js/admin/products.js'])
@endsection
