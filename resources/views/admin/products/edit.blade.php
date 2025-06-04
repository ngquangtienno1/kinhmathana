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
                <h2 class="mb-0">Sửa sản phẩm: {{ $product->name }}</h2>
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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="product-images-tab" data-bs-toggle="tab" data-bs-target="#product-images" type="button" role="tab" aria-controls="product-images" aria-selected="false">Ảnh/Video sản phẩm</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="tab-content" id="productTabsContent">
                        <!-- Tab Thông tin sản phẩm -->
                        <div class="tab-pane fade show active" id="product-info" role="tabpanel" aria-labelledby="product-info-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status">
                                        <option value="Hoạt động" {{ old('status', $product->status) === 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="Không hoạt động" {{ old('status', $product->status) === 'Không hoạt động' ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nổi bật</label>
                                    <select class="form-select" name="is_featured">
                                        <option value="1" {{ old('is_featured', $product->is_featured) === 1 ? 'selected' : '' }}>Có</option>
                                        <option value="0" {{ old('is_featured', $product->is_featured) === 0 ? 'selected' : '' }}>Không</option>
                                    </select>
                                    @error('is_featured')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description_long') is-invalid @enderror" name="description_long" id="description_long">{{ old('description_long', $product->description_long) }}</textarea>
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
                                    <select class="form-select" name="product_type" id="product_type" disabled>
                                        <option value="simple" {{ $product->product_type == 'simple' ? 'selected' : '' }}>Sản phẩm đơn giản</option>
                                        <option value="variable" {{ $product->product_type == 'variable' ? 'selected' : '' }}>Sản phẩm có biến thể</option>
                                    </select>
                                    @error('product_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sản phẩm đơn giản -->
                                <div id="simple-product" class="product-type-content" style="{{ $product->product_type == 'variable' ? 'display:none' : '' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}">
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="stock_quantity" id="simple_stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) ?? 0 }}" min="0" required>
                                        @error('stock_quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control price-input" name="price" value="{{ old('price', $product->price ?? 0) }}" placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá khuyến mãi</label>
                                        <input type="text" class="form-control price-input" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                        @error('sale_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm</label>
                                        <input type="text" class="form-control" name="slug" value="{{ old('slug', $product->slug) }}" readonly>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sản phẩm có biến thể -->
                                <div id="variable-product" class="product-type-content" style="{{ $product->product_type == 'simple' ? 'display:none' : '' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}">
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Theo dõi tồn kho</label>
                                        <input type="number" class="form-control" name="stock_quantity" id="variable_stock_quantity" value="{{ old('stock_quantity', $product->total_stock) }}" min="0" readonly>
                                        @error('stock_quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm</label>
                                        <input type="text" class="form-control" name="slug" value="{{ old('slug', $product->slug) }}" readonly>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Thuộc tính biến thể -->
                                    <div class="col-md-12">
                                        <label class="form-label">Thuộc tính biến thể</label>
                                        <div id="attributes-container">
                                            @php
                                                // Nhóm các thuộc tính theo loại (color/size)
                                                $attributeGroups = [
                                                    'color' => [],
                                                    'size' => [],
                                                ];
                                                foreach ($product->variations as $variation) {
                                                    if ($variation->color) {
                                                        $attributeGroups['color'][] = $variation->color->name;
                                                    }
                                                    if ($variation->size) {
                                                        $attributeGroups['size'][] = $variation->size->name;
                                                    }
                                                }
                                                $attributeGroups['color'] = array_unique($attributeGroups['color']);
                                                $attributeGroups['size'] = array_unique($attributeGroups['size']);
                                                $attributeIndex = 0;
                                            @endphp

                                            @if (!empty($attributeGroups['color']))
                                                <div class="attribute-row row g-2 mb-2" data-index="{{ $attributeIndex }}">
                                                    <div class="col-md-3">
                                                        <select name="attributes[{{ $attributeIndex }}][type]" class="form-select attribute-type">
                                                            <option value="color" selected>Màu sắc</option>
                                                            <option value="size">Kích thước</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="attribute-values-tags">
                                                            @foreach ($attributeGroups['color'] as $colorValue)
                                                                <span class="tag">{{ $colorValue }}<input type="hidden" name="attributes[{{ $attributeIndex }}][values][]" value="{{ $colorValue }}"><button type="button" class="remove-tag" data-value="{{ $colorValue }}">×</button></span>
                                                            @endforeach
                                                        </div>
                                                        <select class="form-select attribute-values" multiple>
                                                            @foreach ($colors as $color)
                                                                <option value="{{ $color->name }}" {{ in_array($color->name, $attributeGroups['color']) ? 'selected' : '' }}>{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                                                    </div>
                                                </div>
                                                @php $attributeIndex++; @endphp
                                            @endif

                                            @if (!empty($attributeGroups['size']))
                                                <div class="attribute-row row g-2 mb-2" data-index="{{ $attributeIndex }}">
                                                    <div class="col-md-3">
                                                        <select name="attributes[{{ $attributeIndex }}][type]" class="form-select attribute-type">
                                                            <option value="color">Màu sắc</option>
                                                            <option value="size" selected>Kích thước</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="attribute-values-tags">
                                                            @foreach ($attributeGroups['size'] as $sizeValue)
                                                                <span class="tag">{{ $sizeValue }}<input type="hidden" name="attributes[{{ $attributeIndex }}][values][]" value="{{ $sizeValue }}"><button type="button" class="remove-tag" data-value="{{ $sizeValue }}">×</button></span>
                                                            @endforeach
                                                        </div>
                                                        <select class="form-select attribute-values" multiple>
                                                            @foreach ($sizes as $size)
                                                                <option value="{{ $size->name }}" {{ in_array($size->name, $attributeGroups['size']) ? 'selected' : '' }}>{{ $size->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                                                    </div>
                                                </div>
                                                @php $attributeIndex++; @endphp
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" id="add-attribute">Thêm thuộc tính</button>
                                    </div>

                                    <!-- Biến thể -->
                                    <div id="variations-container" class="mt-3">
                                        @foreach ($product->variations as $index => $variation)
                                            <div class="variation-row row g-2 mb-2">
                                                <input type="hidden" name="variations[{{ $index }}][id]" value="{{ $variation->id }}">
                                                <div class="col-md-2">
                                                    <input type="text" name="variations[{{ $index }}][name]" value="{{ $variation->name }}" class="form-control" placeholder="Tên biến thể" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="variations[{{ $index }}][sku]" value="{{ $variation->sku }}" class="form-control" placeholder="Mã sản phẩm">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control price-input" name="variations[{{ $index }}][price]" value="{{ $variation->price ?? '' }}" placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control price-input" name="variations[{{ $index }}][sale_price]" value="{{ $variation->sale_price ?? '' }}" placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                                    @error("variations.$index.sale_price")
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" name="variations[{{ $index }}][stock_quantity]" value="{{ old("variations.$index.stock_quantity", $variation->stock_quantity) ?? 0 }}" class="form-control" placeholder="Tồn kho" min="0" required>
                                                    @error("variations.$index.stock_quantity")
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-1">
                                                    <select name="variations[{{ $index }}][status]" class="form-select">
                                                        <option value="in_stock" {{ old("variations.$index.status", $variation->status) == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                                                        <option value="out_of_stock" {{ old("variations.$index.status", $variation->status) == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                                                        <option value="hidden" {{ old("variations.$index.status", $variation->status) == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                                                    </select>
                                                    @error("variations.$index.status")
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="form-label">Ảnh biến thể</label>
                                                    <input type="file" name="variations[{{ $index }}][image]" class="form-control">
                                                    @if (!is_null($variation->images) && $variation->images->isNotEmpty())
                                                        <img src="{{ Storage::url($variation->images->first()->image_path) }}" alt="Variation Image" style="width: 50px; height: 50px;">
                                                    @endif
                                                    @error("variations.$index.image")
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                                    <textarea class="form-control" name="description_short">{{ old('description_short', $product->description_short) }}</textarea>
                                    @error('description_short')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tab Ảnh/Video sản phẩm -->
                        <div class="tab-pane fade" id="product-images" role="tabpanel" aria-labelledby="product-images-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" name="featured_image">
                                    @error('featured_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if ($product->images->where('is_featured', true)->first())
                                        <img src="{{ Storage::url($product->images->where('is_featured', true)->first()->image_path) }}" alt="Featured Image" style="max-width: 200px; margin-top: 10px;">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Album ảnh</label>
                                    <input type="file" class="form-control" name="gallery_images[]" multiple>
                                    @error('gallery_images')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('gallery_images.*')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-3">
                                        @foreach ($product->images->where('is_featured', false) as $image)
                                            <img src="{{ Storage::url($image->image_path) }}" alt="Gallery Image" style="max-width: 100px; margin-right: 10px; margin-bottom: 10px;">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Video sản phẩm</label>
                                    <input type="file" class="form-control" name="video_path" accept="video/mp4,video/webm,video/ogg">
                                    <small class="text-muted">Hỗ trợ định dạng: MP4, WebM, Ogg. Kích thước tối đa: 50MB</small>
                                    @error('video_path')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if ($product->video_path)
                                        <div class="video-container mt-2">
                                            <video class="product-video" controls style="max-width: 400px;">
                                                <source src="{{ asset('storage/' . $product->video_path) }}" type="video/mp4">
                                                Trình duyệt của bạn không hỗ trợ thẻ video.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phần phân loại -->
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @include('admin.partials.category-checkboxes', ['categories' => $categories, 'selected' => old('categories', $product->categories->pluck('id')->toArray())])
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
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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
        /* Style cho CKEditor */
        .ck-editor__editable {
            min-height: 200px !important;
            max-height: 400px !important;
        }
        .ck.ck-editor {
            width: 100%;
        }
        .ck.ck-content {
            font-size: 14px;
            line-height: 1.5;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let attributeIndex = {{ $attributeIndex }};

            // Thêm thuộc tính mới
            document.getElementById('add-attribute').addEventListener('click', function () {
                const container = document.getElementById('attributes-container');
                const row = document.createElement('div');
                row.className = 'attribute-row row g-2 mb-2';
                row.setAttribute('data-index', attributeIndex);
                row.innerHTML = `
                    <div class="col-md-3">
                        <select name="attributes[${attributeIndex}][type]" class="form-select attribute-type">
                            <option value="color">Màu sắc</option>
                            <option value="size">Kích thước</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="attribute-values-tags"></div>
                        <select class="form-select attribute-values" multiple>
                            <option value="">Chọn giá trị</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                    </div>
                `;
                container.appendChild(row);
                updateAttributeValues(row.querySelector('.attribute-type'), row.querySelector('.attribute-values'));
                attributeIndex++;
            });

            // Xóa thuộc tính
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-attribute')) {
                    e.target.closest('.attribute-row').remove();
                }
            });

            // Cập nhật giá trị của select dựa trên loại thuộc tính
            function updateAttributeValues(typeSelect, valuesSelect) {
                const type = typeSelect.value;
                const colors = @json($colors->pluck('name'));
                const sizes = @json($sizes->pluck('name'));
                valuesSelect.innerHTML = '';
                const options = type === 'color' ? colors : sizes;
                options.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.textContent = option;
                    valuesSelect.appendChild(opt);
                });
            }

            // Xử lý thay đổi loại thuộc tính
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('attribute-type')) {
                    const row = e.target.closest('.attribute-row');
                    const valuesSelect = row.querySelector('.attribute-values');
                    const tagsContainer = row.querySelector('.attribute-values-tags');
                    tagsContainer.innerHTML = '';
                    updateAttributeValues(e.target, valuesSelect);
                }
            });

            // Xử lý thêm/xóa tag khi chọn giá trị
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('attribute-values')) {
                    const row = e.target.closest('.attribute-row');
                    const tagsContainer = row.querySelector('.attribute-values-tags');
                    const selectedValues = Array.from(e.target.selectedOptions).map(opt => opt.value);
                    tagsContainer.innerHTML = '';
                    selectedValues.forEach(value => {
                        if (value) {
                            tagsContainer.innerHTML += `
                                <span class="tag">${value}<input type="hidden" name="attributes[${row.getAttribute('data-index')}][values][]" value="${value}"><button type="button" class="remove-tag" data-value="${value}">×</button></span>
                            `;
                        }
                    });
                }
            });

            // Xóa tag
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-tag')) {
                    const tag = e.target.closest('.tag');
                    const value = e.target.getAttribute('data-value');
                    const row = e.target.closest('.attribute-row');
                    const valuesSelect = row.querySelector('.attribute-values');
                    const option = valuesSelect.querySelector(`option[value="${value}"]`);
                    if (option) option.selected = false;
                    tag.remove();
                }
            });

            // Khởi tạo giá trị ban đầu cho các select
            document.querySelectorAll('.attribute-type').forEach(typeSelect => {
                const row = typeSelect.closest('.attribute-row');
                const valuesSelect = row.querySelector('.attribute-values');
                updateAttributeValues(typeSelect, valuesSelect);
            });
        });
    </script>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description_long'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush

    @vite(['resources/js/admin/products.js'])
@endsection
