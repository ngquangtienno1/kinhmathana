@extends('admin.layouts')
@section('title', 'Sửa sản phẩm')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Sửa sản phẩm</li>
@endsection

@section('content')
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
                        <button class="nav-link active" id="product-info-tab" data-bs-toggle="tab"
                            data-bs-target="#product-info" type="button" role="tab" aria-controls="product-info"
                            aria-selected="true">Thông tin sản phẩm</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="product-data-tab" data-bs-toggle="tab" data-bs-target="#product-data"
                            type="button" role="tab" aria-controls="product-data" aria-selected="false">Dữ liệu sản
                            phẩm</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="product-excerpt-tab" data-bs-toggle="tab"
                            data-bs-target="#product-excerpt" type="button" role="tab" aria-controls="product-excerpt"
                            aria-selected="false">Mô tả ngắn</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="product-images-tab" data-bs-toggle="tab"
                            data-bs-target="#product-images" type="button" role="tab" aria-controls="product-images"
                            aria-selected="false">Ảnh/Video sản phẩm</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="tab-content" id="productTabsContent">
                        <!-- Tab Thông tin sản phẩm -->
                        <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                            aria-labelledby="product-info-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $product->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status">
                                        <option value="Hoạt động"
                                            {{ old('status', $product->status) === 'Hoạt động' ? 'selected' : '' }}>Hoạt
                                            động</option>
                                        <option value="Không hoạt động"
                                            {{ old('status', $product->status) === 'Không hoạt động' ? 'selected' : '' }}>
                                            Không hoạt động</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nổi bật</label>
                                    <select class="form-select" name="is_featured">
                                        <option value="1"
                                            {{ old('is_featured', $product->is_featured) === 1 ? 'selected' : '' }}>Có
                                        </option>
                                        <option value="0"
                                            {{ old('is_featured', $product->is_featured) === 0 ? 'selected' : '' }}>Không
                                        </option>
                                    </select>
                                    @error('is_featured')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description_long') is-invalid @enderror" name="description_long"
                                        id="description_long">{{ old('description_long', $product->description_long) }}</textarea>
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
                                        <option value="simple" {{ $product->product_type == 'simple' ? 'selected' : '' }}>
                                            Sản phẩm đơn giản</option>
                                        <option value="variable"
                                            {{ $product->product_type == 'variable' ? 'selected' : '' }}>Sản phẩm có biến
                                            thể</option>
                                    </select>
                                    @error('product_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sản phẩm đơn giản -->
                                <div id="simple-product" class="product-type-content"
                                    style="{{ $product->product_type == 'variable' ? 'display:none' : '' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" id="simple_sku"
                                            value="{{ old('sku', $product->sku) }}">
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control price-input" name="price"
                                            value="{{ old('price', $product->price ?? 0) }}"
                                            placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá khuyến mãi</label>
                                        <input type="text" class="form-control price-input" name="sale_price"
                                            value="{{ old('sale_price', $product->sale_price ?? '') }}"
                                            placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                        @error('sale_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ old('quantity', $product->quantity ?? 0) }}" min="0"
                                            placeholder="Nhập số lượng">
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm</label>
                                        <input type="text" class="form-control" name="slug" id="simple_slug"
                                            value="{{ old('slug', $product->slug) }}" readonly>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sản phẩm có biến thể -->
                                <div id="variable-product" class="product-type-content"
                                    style="{{ $product->product_type == 'simple' ? 'display:none' : '' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" name="sku" id="variable_sku"
                                            value="{{ old('sku', $product->sku) }}" readonly>
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm</label>
                                        <input type="text" class="form-control" name="slug" id="variable_slug"
                                            value="{{ old('slug', $product->slug) }}" readonly>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Thuộc tính biến thể -->
                                    <div class="col-md-12">
                                        <label class="form-label">Thuộc tính biến thể</label>
                                        <button type="button" id="add-attribute"
                                            class="btn btn-primary btn-sm mb-2">Thêm thuộc tính</button>
                                        <div id="attributes-container">
                                            @php
                                                $attributeGroups = [
                                                    'color' => [],
                                                    'size' => [],
                                                    'spherical' => [],
                                                    'cylindrical' => [],
                                                ];
                                                foreach ($product->variations as $variation) {
                                                    if ($variation->color && $variation->color->id) {
                                                        $attributeGroups['color'][] = (string) $variation->color->id;
                                                    }
                                                    if ($variation->size && $variation->size->id) {
                                                        $attributeGroups['size'][] = (string) $variation->size->id;
                                                    }
                                                    if ($variation->spherical && $variation->spherical->id) {
                                                        $attributeGroups['spherical'][] =
                                                            (string) $variation->spherical->id;
                                                    }
                                                    if ($variation->cylindrical && $variation->cylindrical->id) {
                                                        $attributeGroups['cylindrical'][] =
                                                            (string) $variation->cylindrical->id;
                                                    }
                                                }
                                                $attributeGroups['color'] = array_unique($attributeGroups['color']);
                                                $attributeGroups['size'] = array_unique($attributeGroups['size']);
                                                $attributeGroups['spherical'] = array_unique(
                                                    $attributeGroups['spherical'],
                                                );
                                                $attributeGroups['cylindrical'] = array_unique(
                                                    $attributeGroups['cylindrical'],
                                                );
                                                $usedTypes = array_keys(
                                                    array_filter($attributeGroups, fn($values) => !empty($values)),
                                                );
                                                $attributeIndex = 0;
                                            @endphp

                                            @php
                                                $oldAttributes = old('attributes');
                                            @endphp
                                            @foreach ($usedTypes as $type)
                                                @php
                                                    if (
                                                        $oldAttributes &&
                                                        isset($oldAttributes[$attributeIndex]['type']) &&
                                                        $oldAttributes[$attributeIndex]['type'] === $type
                                                    ) {
                                                        $selectedValues =
                                                            $oldAttributes[$attributeIndex]['values'] ?? [];
                                                    } else {
                                                        $selectedValues = $attributeGroups[$type] ?? [];
                                                    }
                                                @endphp
                                                <div class="attribute-row row g-2 mb-2"
                                                    data-index="{{ $attributeIndex }}">
                                                    <div class="col-md-3">
                                                        <select name="attributes[{{ $attributeIndex }}][type]"
                                                            class="form-select attribute-type"
                                                            data-index="{{ $attributeIndex }}" disabled>
                                                            <option value="color"
                                                                {{ $type == 'color' ? 'selected' : '' }}>Màu sắc</option>
                                                            <option value="size"
                                                                {{ $type == 'size' ? 'selected' : '' }}>Kích thước</option>
                                                            <option value="spherical"
                                                                {{ $type == 'spherical' ? 'selected' : '' }}>Độ cận
                                                            </option>
                                                            <option value="cylindrical"
                                                                {{ $type == 'cylindrical' ? 'selected' : '' }}>Độ loạn
                                                            </option>
                                                        </select>
                                                        @if ($errors->has("attributes.{$attributeIndex}.type"))
                                                            <div class="text-danger">
                                                                {{ $errors->first("attributes.{$attributeIndex}.type") }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="attribute-values-tags">
                                                            @foreach ($selectedValues as $value)
                                                                @php
                                                                    $displayName = $value;
                                                                    if ($type == 'color') {
                                                                        $color = $colors->firstWhere('id', $value);
                                                                        $displayName = $color ? $color->name : $value;
                                                                    } elseif ($type == 'size') {
                                                                        $size = $sizes->firstWhere('id', $value);
                                                                        $displayName = $size ? $size->name : $value;
                                                                    } elseif ($type == 'spherical') {
                                                                        $spherical = $sphericals->firstWhere(
                                                                            'id',
                                                                            $value,
                                                                        );
                                                                        $displayName = $spherical
                                                                            ? $spherical->name
                                                                            : $value;
                                                                    } elseif ($type == 'cylindrical') {
                                                                        $cylindrical = $cylindricals->firstWhere(
                                                                            'id',
                                                                            $value,
                                                                        );
                                                                        $displayName = $cylindrical
                                                                            ? $cylindrical->name
                                                                            : $value;
                                                                    }
                                                                @endphp
                                                                <span class="tag">{{ $displayName }}<input
                                                                        type="hidden"
                                                                        name="attributes[{{ $attributeIndex }}][values][]"
                                                                        value="{{ $value }}"><button
                                                                        type="button" class="remove-tag"
                                                                        data-value="{{ $value }}">×</button></span>
                                                            @endforeach
                                                        </div>
                                                        <div class="border rounded p-3 attribute-values-container"
                                                            style="max-height: 200px; overflow-y: auto;">
                                                            @if ($type == 'color')
                                                                @foreach ($colors as $color)
                                                                    <div class="form-check">
                                                                        <input type="checkbox"
                                                                            class="form-check-input attribute-value-checkbox"
                                                                            name="attributes[{{ $attributeIndex }}][values][]"
                                                                            value="{{ $color->id }}"
                                                                            data-index="{{ $attributeIndex }}"
                                                                            {{ in_array((string) $color->id, $selectedValues) ? 'checked' : '' }}>
                                                                        <label
                                                                            class="form-check-label">{{ $color->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            @elseif ($type == 'size')
                                                                @foreach ($sizes as $size)
                                                                    <div class="form-check">
                                                                        <input type="checkbox"
                                                                            class="form-check-input attribute-value-checkbox"
                                                                            name="attributes[{{ $attributeIndex }}][values][]"
                                                                            value="{{ $size->id }}"
                                                                            data-index="{{ $attributeIndex }}"
                                                                            {{ in_array((string) $size->id, $selectedValues) ? 'checked' : '' }}>
                                                                        <label
                                                                            class="form-check-label">{{ $size->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            @elseif ($type == 'spherical')
                                                                @foreach ($sphericals as $spherical)
                                                                    <div class="form-check">
                                                                        <input type="checkbox"
                                                                            class="form-check-input attribute-value-checkbox"
                                                                            name="attributes[{{ $attributeIndex }}][values][]"
                                                                            value="{{ $spherical->id }}"
                                                                            data-index="{{ $attributeIndex }}"
                                                                            {{ in_array((string) $spherical->id, $selectedValues) ? 'checked' : '' }}>
                                                                        <label
                                                                            class="form-check-label">{{ $spherical->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            @elseif ($type == 'cylindrical')
                                                                @foreach ($cylindricals as $cylindrical)
                                                                    <div class="form-check">
                                                                        <input type="checkbox"
                                                                            class="form-check-input attribute-value-checkbox"
                                                                            name="attributes[{{ $attributeIndex }}][values][]"
                                                                            value="{{ $cylindrical->id }}"
                                                                            data-index="{{ $attributeIndex }}"
                                                                            {{ in_array((string) $cylindrical->id, $selectedValues) ? 'checked' : '' }}>
                                                                        <label
                                                                            class="form-check-label">{{ $cylindrical->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        @if ($errors->has("attributes.{$attributeIndex}.values"))
                                                            <div class="text-danger">
                                                                {{ $errors->first("attributes.{$attributeIndex}.values") }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                                                    </div>
                                                </div>
                                                @php $attributeIndex++; @endphp
                                            @endforeach
                                        </div>
                                        <button type="button" id="generate-variations"
                                            class="btn btn-primary btn-sm mt-2"
                                            style="{{ $product->variations->isNotEmpty() ? '' : 'display: none' }}">Tạo
                                            biến thể</button>
                                    </div>

                                    <!-- Biến thể -->
                                    @php
                                        $variations = old('variations');
                                        if (!$variations) {
                                            $variations = $product->variations
                                                ->map(function ($v) {
                                                    $arr = $v->toArray();
                                                    $arr['images'] = $v->images->toArray();
                                                    return $arr;
                                                })
                                                ->toArray();
                                        }
                                    @endphp
                                    <div id="variations-container" class="mt-3">
                                        <!-- Bảng hiển thị biến thể với thead -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tên biến thể</th>
                                                        <th>Mã sản phẩm</th>
                                                        <th>Giá gốc</th>
                                                        <th>Giá khuyến mãi</th>
                                                        <th>Số lượng</th>
                                                        <th>Ảnh</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="variations-table-body">
                                                    @foreach ($variations as $index => $variation)
                                                        <tr data-variation-id="{{ $variation['id'] ?? '' }}">
                                                            <input type="hidden"
                                                                name="variations[{{ $index }}][id]"
                                                                value="{{ $variation['id'] ?? '' }}">
                                                            <td>
                                                                <input type="text"
                                                                    name="variations[{{ $index }}][name]"
                                                                    value="{{ $variation['name'] ?? '' }}"
                                                                    class="form-control" placeholder="Tên biến thể"
                                                                    readonly>
                                                                <input type="hidden"
                                                                    name="variations[{{ $index }}][color_id]"
                                                                    value="{{ $variation['color_id'] ?? '' }}">
                                                                <input type="hidden"
                                                                    name="variations[{{ $index }}][size_id]"
                                                                    value="{{ $variation['size_id'] ?? '' }}">
                                                                <input type="hidden"
                                                                    name="variations[{{ $index }}][spherical_id]"
                                                                    value="{{ $variation['spherical_id'] ?? '' }}">
                                                                <input type="hidden"
                                                                    name="variations[{{ $index }}][cylindrical_id]"
                                                                    value="{{ $variation['cylindrical_id'] ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="variations[{{ $index }}][sku]"
                                                                    value="{{ $variation['sku'] ?? '' }}"
                                                                    class="form-control" placeholder="Mã sản phẩm">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control price-input"
                                                                    name="variations[{{ $index }}][price]"
                                                                    value="{{ isset($variation['price']) ? (int) $variation['price'] : '' }}"
                                                                    placeholder="Nhập giá (VD: 1000)">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control price-input"
                                                                    name="variations[{{ $index }}][sale_price]"
                                                                    value="{{ isset($variation['sale_price']) ? (int) $variation['sale_price'] : '' }}"
                                                                    placeholder="Nhập giá (VD: 900)">
                                                                @error("variations.$index.sale_price")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="variations[{{ $index }}][quantity]"
                                                                    value="{{ $variation['quantity'] ?? 0 }}"
                                                                    min="0" placeholder="Nhập số lượng">
                                                            </td>
                                                            <td>
                                                                <input type="file"
                                                                    name="variations[{{ $index }}][image]"
                                                                    class="form-control variation-image-input"
                                                                    data-image-url="{{ !empty($variation['images']) && is_array($variation['images']) && count($variation['images']) ? Storage::url($variation['images'][0]['image_path']) : '' }}">
                                                                @if (!empty($variation['images']) && is_array($variation['images']) && count($variation['images']))
                                                                    <div class="mt-2">
                                                                        <img src="{{ Storage::url($variation['images'][0]['image_path']) }}"
                                                                            alt="Variation Image" class="variation-image"
                                                                            style="max-width: 50px; max-height: 50px; object-fit: cover; border-radius: 4px;">
                                                                    </div>
                                                                @endif
                                                                @error("variations.$index.image")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-variation"
                                                                    data-variation-id="{{ $variation['id'] ?? '' }}">Xóa</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Mô tả ngắn -->
                        <div class="tab-pane fade" id="product-excerpt" role="tabpanel"
                            aria-labelledby="product-excerpt-tab">
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
                        <div class="tab-pane fade" id="product-images" role="tabpanel"
                            aria-labelledby="product-images-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" name="featured_image"
                                        accept="image/jpeg,image/png,image/gif,image/webp,image/tiff">
                                    @error('featured_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if ($product->images->where('is_featured', true)->first())
                                        <img src="{{ Storage::url($product->images->where('is_featured', true)->first()->image_path) }}"
                                            alt="Featured Image" style="max-width: 200px; margin-top: 10px;">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Album ảnh</label>
                                    <input type="file" class="form-control" name="gallery_images[]" multiple
                                        accept="image/jpeg,image/png,image/gif,image/webp,image/tiff">
                                    @error('gallery_images')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('gallery_images.*')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-3 d-flex flex-wrap">
                                        @foreach ($product->images->where('is_featured', false) as $image)
                                            <div class="position-relative me-3 mb-3">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Gallery Image"
                                                    style="max-width: 100px;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Phần phân loại -->
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @include('admin.partials.category-checkboxes', [
                                    'categories' => $categories,
                                    'selected' => old('categories', $product->categories->pluck('id')->toArray()),
                                ])
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
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
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

    <!-- Modal nhập giá và số lượng cho tất cả biến thể -->
    <div class="modal fade" id="variationsModal" tabindex="-1" aria-labelledby="variationsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variationsModalLabel">Nhập thông tin cho tất cả biến thể</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Giá gốc cho tất cả biến thể <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modalBasePrice"
                                placeholder="VD: 1000 hoặc 1.234,56">
                            <div class="form-text">Nhập giá gốc chung cho tất cả biến thể</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Giá khuyến mãi cho tất cả biến thể</label>
                            <input type="text" class="form-control" id="modalSalePrice"
                                placeholder="VD: 900 hoặc 1.234,56">
                            <div class="form-text">Có thể để trống nếu không có khuyến mãi</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số lượng cho tất cả biến thể <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="modalQuantity" placeholder="VD: 100"
                                min="1">
                            <div class="form-text">Nhập số lượng chung cho tất cả biến thể</div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Thông tin:</strong> Sau khi nhấn "Áp dụng", bạn sẽ được hỏi muốn áp dụng cho tất cả
                                biến thể hay chỉ biến thể mới. Bạn có thể chỉnh sửa từng biến thể riêng lẻ sau khi tạo.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="applyVariationsSettings">Áp dụng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận áp dụng giá trị -->
    <div class="modal fade" id="confirmApplyModal" tabindex="-1" aria-labelledby="confirmApplyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmApplyModalLabel">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        Xác nhận áp dụng giá trị
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-info-circle text-info" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-center mb-0">
                        <strong>Bạn có muốn áp dụng giá trị này cho TẤT CẢ biến thể?</strong>
                    </p>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="card-title">Áp dụng cho tất cả</h6>
                                    <p class="card-text small">Cả biến thể cũ và mới</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <i class="fas fa-plus-circle text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="card-title">Chỉ biến thể mới</h6>
                                    <p class="card-text small">Giữ nguyên biến thể cũ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .remove-attribute {
            display: none;
        }

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

        #variations-container table {
            width: 100%;
            margin-top: 10px;
        }

        #variations-container th,
        #variations-container td {
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        #variations-container .form-control {
            border: none;
            background: transparent;
            padding: 0;
            margin: 0;
            box-shadow: none;
        }

        #variations-container .form-control:focus {
            border: 1px solid #007bff;
            background: white;
            padding: 0.375rem 0.75rem;
        }

        .variation-image {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* CSS cho modal xác nhận */
        #confirmApplyModal .card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        #confirmApplyModal .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #confirmApplyModal .card.border-primary:hover {
            border-color: #0056b3 !important;
            background-color: #f8f9ff;
        }

        #confirmApplyModal .card.border-warning:hover {
            border-color: #e0a800 !important;
            background-color: #fffbf0;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#description_long'))
                .catch(error => {
                    console.error(error);
                });
            window.colors = @json($colors->map(fn($c) => ['id' => (string) $c->id, 'name' => $c->name])->values());
            window.sizes = @json($sizes->map(fn($s) => ['id' => (string) $s->id, 'name' => $s->name])->values());
            window.spherical_values = @json($sphericals->map(fn($s) => ['id' => (string) $s->id, 'name' => $s->name])->values());
            window.cylindrical_values = @json($cylindricals->map(fn($c) => ['id' => (string) $c->id, 'name' => $c->name])->values());
        </script>
    @endpush

    @vite(['resources/js/admin/products-edit.js'])
@endsection
