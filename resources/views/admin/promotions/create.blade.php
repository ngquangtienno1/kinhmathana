@extends('admin.layouts')

@section('title', 'Thêm khuyến mãi')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.promotions.index') }}">Khuyến mãi</a>
    </li>
    <li class="breadcrumb-item active">Thêm khuyến mãi</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Thêm khuyến mãi mới</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-phoenix-secondary">
                        <span class="fas fa-arrow-left me-2"></span>Quay lại
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.promotions.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Thông tin khuyến mãi</h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label" for="name">Tên khuyến mãi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required placeholder="Nhập tên khuyến mãi">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3" placeholder="Nhập mô tả khuyến mãi">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="code">Mã khuyến mãi <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="code" id="code"
                                        class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}"
                                        required placeholder="Nhập mã khuyến mãi">
                                    <button type="button" id="generate-code" class="btn btn-phoenix-secondary">Tạo
                                        mã</button>
                                </div>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="discount_type">Loại giảm giá <span
                                            class="text-danger">*</span></label>
                                    <select name="discount_type" id="discount_type"
                                        class="form-select @error('discount_type') is-invalid @enderror" required>
                                        <option value="percentage"
                                            {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm (%)
                                        </option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Số
                                            tiền cố định</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="discount_value">Giá trị giảm <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="discount_value" id="discount_value"
                                            class="form-control @error('discount_value') is-invalid @enderror"
                                            value="{{ old('discount_value') }}" step="0.01" min="0" required>
                                        <span class="input-group-text" id="discount-symbol">%</span>
                                    </div>
                                    @error('discount_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="start_date">Ngày bắt đầu <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" name="start_date" id="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="end_date">Ngày kết thúc <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" name="end_date" id="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Hiển thị các mục đã chọn --}}
                            @if(old('categories', []) || old('products', []))
                                <div class="mb-3 p-2" style="background: #d4ffb2; border-radius: 5px;">
                                    <strong>Đã chọn:</strong>
                                    @foreach($categories as $category)
                                        @if(in_array($category->id, old('categories', [])))
                                            <span class="badge bg-success">
                                                {{ $category->name }}
                                                <a href="#" class="text-white ms-1 remove-selected" data-type="category" data-id="{{ $category->id }}">×</a>
                                            </span>
                                        @endif
                                    @endforeach
                                    @foreach($products as $product)
                                        @if(in_array($product->id, old('products', [])))
                                            <span class="badge bg-info">
                                                {{ $product->name }}
                                                <a href="#" class="text-white ms-1 remove-selected" data-type="product" data-id="{{ $product->id }}">×</a>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label" for="categories">Chọn danh mục</label>
                                <select name="categories[]" id="categories" class="form-select select2" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="products">Chọn sản phẩm</label>
                                <select name="products[]" id="products" class="form-select select2" multiple>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Điều kiện áp dụng</h4>

                            <div class="mb-4">
                                <label class="form-label" for="minimum_purchase">Giá trị đơn tối thiểu</label>
                                <input type="number" name="minimum_purchase" id="minimum_purchase"
                                    class="form-control @error('minimum_purchase') is-invalid @enderror"
                                    value="{{ old('minimum_purchase', '0') }}" step="0.01" min="0"
                                    placeholder="0">
                                @error('minimum_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="maximum_purchase">Giá trị đơn tối đa</label>
                                <input type="number" name="maximum_purchase" id="maximum_purchase"
                                    class="form-control @error('maximum_purchase') is-invalid @enderror"
                                    value="{{ old('maximum_purchase', '0') }}" step="0.01" min="0"
                                    placeholder="0">
                                @error('maximum_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="usage_limit">Giới hạn lượt dùng</label>
                                <input type="number" name="usage_limit" id="usage_limit"
                                    class="form-control @error('usage_limit') is-invalid @enderror"
                                    value="{{ old('usage_limit') }}" min="1" placeholder="Không giới hạn">
                                @error('usage_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="is_active">Trạng thái</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Hoạt động
                                    </option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Không hoạt động
                                    </option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Tạo khuyến mãi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <style>
        .badge { font-size: 1em; margin-right: 5px; }
        .remove-selected { cursor: pointer; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: 'Chọn mục...',
                allowClear: true
            });
            // Xóa mục đã chọn
            $(document).on('click', '.remove-selected', function(e){
                e.preventDefault();
                let type = $(this).data('type');
                let id = $(this).data('id').toString();
                let select = (type === 'category') ? '#categories' : '#products';
                let values = $(select).val() || [];
                values = values.filter(v => v != id);
                $(select).val(values).trigger('change');
                $(this).parent().remove();
            });

            // Change discount symbol based on discount type
            $('#discount_type').change(function() {
                if ($(this).val() === 'percentage') {
                    $('#discount-symbol').text('%');
                } else {
                    $('#discount-symbol').text('đ');
                }
            });

            // Generate promotion code
            $('#generate-code').click(function() {
                $.ajax({
                    url: "{{ route('admin.promotions.generate-code') }}",
                    type: "GET",
                    success: function(response) {
                        $('#code').val(response.code);
                    }
                });
            });
        });
    </script>
@endsection
