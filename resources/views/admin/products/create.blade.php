@extends('admin.layouts')
@section('title', 'Thêm sản phẩm')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Thêm sản phẩm</li>
@endsection

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
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content" id="productTabsContent">
                        <!-- Tab Thông tin sản phẩm -->
                        <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                            aria-labelledby="product-info-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description_long') is-invalid @enderror" name="description_long"
                                        id="description_long">{{ old('description_long') }}</textarea>
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
                                        <option value="simple"
                                            {{ old('product_type', 'simple') == 'simple' ? 'selected' : '' }}>Sản phẩm đơn
                                            giản</option>
                                        <option value="variable" {{ old('product_type') == 'variable' ? 'selected' : '' }}>
                                            Sản phẩm có biến thể</option>
                                    </select>
                                    @error('product_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sản phẩm đơn giản -->
                                <div id="simple-product" class="product-type-content"
                                    style="{{ old('product_type') == 'variable' ? 'display:none' : '' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="sku" id="simple_sku"
                                            value="{{ old('sku') }}">
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá gốc <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control price-input" name="price"
                                            value="{{ old('price') }}" placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Giá khuyến mãi</label>
                                        <input type="text" class="form-control price-input" name="sale_price"
                                            value="{{ old('sale_price') }}"
                                            placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                        @error('sale_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ old('quantity', 0) }}" min="0" placeholder="Nhập số lượng">
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="slug" id="simple_slug"
                                            value="{{ old('slug') }}">
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sản phẩm có biến thể -->
                                <div id="variable-product" class="product-type-content"
                                    style="{{ old('product_type') == 'variable' ? '' : 'display:none' }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="sku" id="variable_sku"
                                            value="{{ old('sku') }}" readonly>
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Slug sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="slug" id="variable_slug"
                                            value="{{ old('slug') }}" readonly>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Thuộc tính biến thể <span
                                                class="text-danger">*</span></label>
                                        <button type="button" id="add-attribute"
                                            class="btn btn-primary btn-sm mb-2">Thêm thuộc tính</button>
                                        <div id="attributes-container">
                                            @foreach (old('attributes', []) as $index => $attribute)
                                                <div class="attribute-row row g-2 mb-2">
                                                    <div class="col-md-3">
                                                        <select name="attributes[{{ $index }}][type]"
                                                            class="form-select attribute-type"
                                                            data-index="{{ $index }}">
                                                            <option value="color"
                                                                {{ isset($attribute['type']) && $attribute['type'] == 'color' ? 'selected' : '' }}>
                                                                Màu sắc</option>
                                                            <option value="size"
                                                                {{ isset($attribute['type']) && $attribute['type'] == 'size' ? 'selected' : '' }}>
                                                                Kích thước</option>
                                                            <option value="spherical"
                                                                {{ isset($attribute['type']) && $attribute['type'] == 'spherical' ? 'selected' : '' }}>
                                                                Độ cận</option>
                                                            <option value="cylindrical"
                                                                {{ isset($attribute['type']) && $attribute['type'] == 'cylindrical' ? 'selected' : '' }}>
                                                                Độ loạn</option>
                                                        </select>
                                                        @error("attributes.$index.type")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="attribute-values-tags">
                                                            @if (isset($attribute['values']))
                                                                @foreach ((array) $attribute['values'] as $value)
                                                                    @php
                                                                        $displayValue = $value; // Default là ID nếu không tìm thấy
                                                                        if ($attribute['type'] == 'color') {
                                                                            $displayValue =
                                                                                $colors->firstWhere('id', $value)
                                                                                    ?->name ?? $value;
                                                                        } elseif ($attribute['type'] == 'size') {
                                                                            $displayValue =
                                                                                $sizes->firstWhere('id', $value)
                                                                                    ?->name ?? $value;
                                                                        } elseif ($attribute['type'] == 'spherical') {
                                                                            $sphericalName =
                                                                                $sphericals->firstWhere('id', $value)
                                                                                    ?->name ?? $value;
                                                                            $displayValue = number_format(
                                                                                (float) $sphericalName,
                                                                                2,
                                                                                '.',
                                                                                '',
                                                                            );
                                                                        } elseif ($attribute['type'] == 'cylindrical') {
                                                                            $cylindricalName =
                                                                                $cylindricals->firstWhere('id', $value)
                                                                                    ?->name ?? $value;
                                                                            $displayValue = number_format(
                                                                                (float) $cylindricalName,
                                                                                2,
                                                                                '.',
                                                                                '',
                                                                            );
                                                                        }
                                                                    @endphp
                                                                    <span class="tag">
                                                                        {{ $displayValue }}
                                                                        <input type="hidden"
                                                                            name="attributes[{{ $index }}][values][]"
                                                                            value="{{ $value }}">
                                                                        <button type="button" class="remove-tag"
                                                                            data-value="{{ $value }}">×</button>
                                                                    </span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="border rounded p-3 attribute-values-container"
                                                            style="max-height: 200px; overflow-y: auto;">
                                                            @if (isset($attribute['type']))
                                                                @if ($attribute['type'] == 'color')
                                                                    @foreach ($colors as $color)
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input attribute-value-checkbox"
                                                                                name="attributes[{{ $index }}][values][]"
                                                                                value="{{ $color->id }}"
                                                                                data-index="{{ $index }}"
                                                                                {{ in_array($color->id, (array) ($attribute['values'] ?? [])) ? 'checked' : '' }}>
                                                                            <label
                                                                                class="form-check-label">{{ $color->name }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                @elseif ($attribute['type'] == 'size')
                                                                    @foreach ($sizes as $size)
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input attribute-value-checkbox"
                                                                                name="attributes[{{ $index }}][values][]"
                                                                                value="{{ $size->id }}"
                                                                                data-index="{{ $index }}"
                                                                                {{ in_array($size->id, (array) ($attribute['values'] ?? [])) ? 'checked' : '' }}>
                                                                            <label
                                                                                class="form-check-label">{{ $size->name }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                @elseif ($attribute['type'] == 'spherical')
                                                                    @foreach ($sphericals as $spherical)
                                                                        @php $val = number_format((float) $spherical->name, 2, '.', ''); @endphp
                                                                        <!-- Sửa: dùng $spherical->name thay vì value -->
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input attribute-value-checkbox"
                                                                                name="attributes[{{ $index }}][values][]"
                                                                                value="{{ $spherical->id }}"
                                                                                data-index="{{ $index }}"
                                                                                {{ in_array($spherical->id, (array) ($attribute['values'] ?? [])) ? 'checked' : '' }}>
                                                                            <label
                                                                                class="form-check-label">{{ $val }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                @elseif ($attribute['type'] == 'cylindrical')
                                                                    @foreach ($cylindricals as $cylindrical)
                                                                        @php $val = number_format((float) $cylindrical->name, 2, '.', ''); @endphp
                                                                        <!-- Sửa: dùng $cylindrical->name thay vì value -->
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input attribute-value-checkbox"
                                                                                name="attributes[{{ $index }}][values][]"
                                                                                value="{{ $cylindrical->id }}"
                                                                                data-index="{{ $index }}"
                                                                                {{ in_array($cylindrical->id, (array) ($attribute['values'] ?? [])) ? 'checked' : '' }}>
                                                                            <label
                                                                                class="form-check-label">{{ $val }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </div>
                                                        @error("attributes.$index.values")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="d-flex gap-2 align-items-center mb-2">
                                            <button type="button" id="generate-variations"
                                                class="btn btn-primary btn-sm">Tạo biến thể</button>
                                            <!-- Ẩn nút này đi -->
                                            <!-- <button type="button" id="set-variations-quantity"
                                                                                                                class="btn btn-primary btn-sm" style="display: none">Đặt số lượng cho tất
                                                                                                                cả biến thể</button> -->
                                        </div>
                                    </div>
                                    <div id="variations-container" class="mt-3"
                                        style="{{ old('variations') && count(old('variations', [])) > 0 ? '' : 'display: none' }}">
                                        <!-- Bảng hiển thị biến thể với thead -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tên biến thể <span class="text-danger">*</span></th>
                                                        <th>Mã sản phẩm <span class="text-danger">*</span></th>
                                                        <th>Giá gốc <span class="text-danger">*</span></th>
                                                        <th>Giá khuyến mãi</th>
                                                        <th>Số lượng <span class="text-danger">*</span></th>
                                                        <th>Ảnh</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="variations-table-body">
                                                    @foreach (old('variations', []) as $index => $variation)
                                                        <tr>
                                                            <td>
                                                                <input type="text"
                                                                    name="variations[{{ $index }}][name]"
                                                                    value="{{ $variation['name'] ?? '' }}"
                                                                    class="form-control" placeholder="Tên biến thể"
                                                                    readonly>
                                                                @if (isset($variation['color_id']))
                                                                    <input type="hidden"
                                                                        name="variations[{{ $index }}][color_id]"
                                                                        value="{{ $variation['color_id'] }}">
                                                                @endif
                                                                @if (isset($variation['size_id']))
                                                                    <input type="hidden"
                                                                        name="variations[{{ $index }}][size_id]"
                                                                        value="{{ $variation['size_id'] }}">
                                                                @endif
                                                                @if (isset($variation['spherical_id']))
                                                                    <input type="hidden"
                                                                        name="variations[{{ $index }}][spherical_id]"
                                                                        value="{{ $variation['spherical_id'] }}">
                                                                @endif
                                                                @if (isset($variation['cylindrical_id']))
                                                                    <input type="hidden"
                                                                        name="variations[{{ $index }}][cylindrical_id]"
                                                                        value="{{ $variation['cylindrical_id'] }}">
                                                                @endif
                                                                @error("variations.$index.name")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="variations[{{ $index }}][sku]"
                                                                    value="{{ $variation['sku'] ?? '' }}"
                                                                    class="form-control" placeholder="Mã sản phẩm">
                                                                @error("variations.$index.sku")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control price-input"
                                                                    name="variations[{{ $index }}][price]"
                                                                    value="{{ $variation['price'] ?? '' }}"
                                                                    placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                                                @error("variations.$index.price")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control price-input"
                                                                    name="variations[{{ $index }}][sale_price]"
                                                                    value="{{ $variation['sale_price'] ?? '' }}"
                                                                    placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                                                @error("variations.$index.sale_price")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="variations[{{ $index }}][quantity]"
                                                                    value="{{ $variation['quantity'] ?? 0 }}"
                                                                    min="0" placeholder="Nhập số lượng">
                                                                @error("variations.$index.quantity")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="file"
                                                                    name="variations[{{ $index }}][image]"
                                                                    class="form-control variation-image-input">
                                                                @error("variations.$index.image")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-variation">Xóa</button>
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
                                    <textarea class="form-control" name="description_short">{{ old('description_short') }}</textarea>
                                    @error('description_short')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tab Ảnh sản phẩm -->
                        <div class="tab-pane fade" id="product-images" role="tabpanel"
                            aria-labelledby="product-images-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" name="featured_image" accept="image/*">
                                    @error('featured_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Album ảnh</label>
                                    <input type="file" class="form-control" name="gallery_images[]" multiple
                                        accept="image/*">
                                    @error('gallery_images')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('gallery_images.*')
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
                                @include('admin.partials.category-checkboxes', [
                                    'categories' => $categories,
                                    'selected' => old('categories', []),
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
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                <strong>Thông tin:</strong> Các giá trị này sẽ được áp dụng cho tất cả biến thể. Bạn có thể
                                chỉnh sửa từng biến thể riêng lẻ sau khi tạo.
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

        .ck-editor__editable {
            min-height: 300px;
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

        .variation-image-preview {
            display: inline-block;
            margin-top: 5px;
        }

        .variation-image-preview img {
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

    @push('styles')
        <style>
            input[name="quantity"] {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        </style>
    @endpush

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

    @vite(['resources/js/admin/products-create.js'])
@endsection
