@extends('admin.layouts')
@section('title', 'Thêm sản phẩm')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
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
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="product-info-tab" data-bs-toggle="tab"
                        data-bs-target="#product-info" type="button" role="tab" aria-controls="product-info"
                        aria-selected="true">Thông tin sản phẩm</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="product-data-tab" data-bs-toggle="tab" data-bs-target="#product-data"
                        type="button" role="tab" aria-controls="product-data" aria-selected="false">Dữ liệu sản phẩm</button>
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
                                        {{ old('product_type', 'simple') == 'simple' ? 'selected' : '' }}>Sản phẩm đơn giản</option>
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
                                    <label class="form-label">Mã sản phẩm</label>
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
                                    <input type="number" class="form-control" name="quantity" value="{{ old('quantity', 0) }}"
                                        min="0" placeholder="Nhập số lượng">
                                    @error('quantity')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Slug sản phẩm</label>
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
                                    <label class="form-label">Mã sản phẩm</label>
                                    <input type="text" class="form-control" name="sku" id="variable_sku"
                                        value="{{ old('sku') }}" readonly>
                                    @error('sku')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Slug sản phẩm</label>
                                    <input type="text" class="form-control" name="slug" id="variable_slug"
                                        value="{{ old('slug') }}" readonly>
                                    @error('slug')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Thuộc tính biến thể</label>
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
                                                                <span class="tag">
                                                                    {{ $value }}
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
                                                                    @php $val = number_format((float)$spherical->value, 2, '.', ''); @endphp
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
                                                                    @php $val = number_format((float)$cylindrical->value, 2, '.', ''); @endphp
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
                                        <button type="button" id="set-variations-quantity"
                                            class="btn btn-primary btn-sm" style="display: none">Đặt số lượng cho tất cả biến thể</button>
                                    </div>
                                </div>
                                <div id="variations-container" class="mt-3"
                                    style="{{ old('variations') && count(old('variations', [])) > 0 ? '' : 'display: none' }}">
                                    @foreach (old('variations', []) as $index => $variation)
                                        <div class="variation-row row g-2 mb-2">
                                            <div class="col-md-2">
                                                <input type="text" name="variations[{{ $index }}][name]"
                                                    value="{{ $variation['name'] ?? '' }}" class="form-control"
                                                    placeholder="Tên biến thể" readonly>
                                                @if (isset($variation['color_id']))
                                                    <input type="hidden" name="variations[{{ $index }}][color_id]"
                                                        value="{{ $variation['color_id'] }}">
                                                @endif
                                                @if (isset($variation['size_id']))
                                                    <input type="hidden" name="variations[{{ $index }}][size_id]"
                                                        value="{{ $variation['size_id'] }}">
                                                @endif
                                                @if (isset($variation['spherical_id']))
                                                    <input type="hidden" name="variations[{{ $index }}][spherical_id]"
                                                        value="{{ $variation['spherical_id'] }}">
                                                @endif
                                                @if (isset($variation['cylindrical_id']))
                                                    <input type="hidden" name="variations[{{ $index }}][cylindrical_id]"
                                                        value="{{ $variation['cylindrical_id'] }}">
                                                @endif
                                                @error("variations.$index.name")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="variations[{{ $index }}][sku]"
                                                    value="{{ $variation['sku'] ?? '' }}" class="form-control"
                                                    placeholder="Mã sản phẩm">
                                                @error("variations.$index.sku")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control price-input"
                                                    name="variations[{{ $index }}][price]"
                                                    value="{{ $variation['price'] ?? '' }}"
                                                    placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                                                @error("variations.$index.price")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control price-input"
                                                    name="variations[{{ $index }}][sale_price]"
                                                    value="{{ $variation['sale_price'] ?? '' }}"
                                                    placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                                                @error("variations.$index.sale_price")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <input type="number" class="form-control"
                                                    name="variations[{{ $index }}][quantity]"
                                                    value="{{ $variation['quantity'] ?? 0 }}" min="0"
                                                    placeholder="Nhập số lượng">
                                                @error("variations.$index.quantity")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="file" name="variations[{{ $index }}][image]"
                                                    class="form-control variation-image-input">
                                                <!-- Hiển thị tên file đã chọn trước đó (nếu có) -->
                                                @if (session('temp_variation_images') && isset(session('temp_variation_images')[$index]))
                                                    <small class="text-muted">Đã chọn: {{ session('temp_variation_images')[$index] }}</small>
                                                @endif
                                                @error("variations.$index.image")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-variation">Xóa</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Bảng hiển thị danh sách biến thể -->
                                <div id="variations-table-container" class="mt-3"
                                    style="{{ old('variations') && count(old('variations', [])) > 0 ? '' : 'display: none' }}">
                                    <h5>Danh sách biến thể</h5>
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
                                                </tr>
                                            </thead>
                                            <tbody id="variations-table-body">
                                                @foreach (old('variations', []) as $index => $variation)
                                                    <tr>
                                                        <td>{{ $variation['name'] ?? '' }}</td>
                                                        <td>{{ $variation['sku'] ?? '' }}</td>
                                                        <td>{{ $variation['price'] ? number_format($variation['price'], 0, ',', '.') : '0' }} VNĐ</td>
                                                        <td>{{ $variation['sale_price'] ? number_format($variation['sale_price'], 0, ',', '.') : '0' }} VNĐ</td>
                                                        <td>{{ $variation['quantity'] ?? 0 }}</td>
                                                        <td>
                                                            @if (session('temp_variation_images') && isset(session('temp_variation_images')[$index]))
                                                                <small>{{ session('temp_variation_images')[$index] }}</small>
                                                            @else
                                                                Không có ảnh
                                                            @endif
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
                                <label class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="featured_image" accept="image/*">
                                <!-- Hiển thị tên file đã chọn trước đó (nếu có) -->
                                @if (session('temp_featured_image'))
                                    <small class="text-muted">Đã chọn: {{ session('temp_featured_image') }}</small>
                                @endif
                                @error('featured_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Album ảnh <span class="text-danger"></span></label>
                                <input type="file" class="form-control" name="gallery_images[]" multiple
                                    accept="image/*">
                                <!-- Hiển thị danh sách tên file đã chọn trước đó (nếu có) -->
                                @if (session('temp_gallery_images'))
                                    <div class="mt-2">
                                        <small class="text-muted">Đã chọn:</small>
                                        <ul>
                                            @foreach (session('temp_gallery_images') as $fileName)
                                                <li>{{ $fileName }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @error('gallery_images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @error('gallery_images.*')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Video sản phẩm</label>
                                <input type="file" class="form-control" name="video_path"
                                    accept="video/mp4,video/webm,video/ogg">
                                @if (session('temp_video_path'))
                                    <small class="text-muted">Đã chọn: {{ session('temp_video_path') }}</small>
                                @endif
                                <small class="text-muted">Hỗ trợ định dạng: MP4, WebM, Ogg. Kích thước tối đa: 50MB</small>
                                @error('video_path')
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

    #variations-table-container table {
        width: 100%;
        margin-top: 10px;
    }

    #variations-table-container th,
    #variations-table-container td {
        padding: 8px;
        text-align: left;
        vertical-align: middle;
    }

    .variation-image {
        max-width: 50px;
        max-height: 50px;
        object-fit: cover;
        border-radius: 4px;
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
