@extends('admin.layouts')

@section('title', 'Chỉnh sửa khuyến mãi')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.promotions.index') }}">Khuyến mãi</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa khuyến mãi</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Chỉnh sửa khuyến mãi</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-phoenix-secondary">
                        <span class="fas fa-arrow-left me-2"></span>Quay lại
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Thông tin khuyến mãi</h4>
                            <div class="mb-4">
                                <label class="form-label" for="name">Tên khuyến mãi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $promotion->name) }}" required placeholder="Nhập tên khuyến mãi">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="description">Mô tả</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3" placeholder="Nhập mô tả khuyến mãi">{{ old('description', $promotion->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="code">Mã khuyến mãi <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="code" id="code"
                                        class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code', $promotion->code) }}" required
                                        placeholder="Nhập mã khuyến mãi">
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
                                            {{ old('discount_type', $promotion->discount_type) == 'percentage' ? 'selected' : '' }}>
                                            Phần trăm (%)</option>
                                        <option value="fixed"
                                            {{ old('discount_type', $promotion->discount_type) == 'fixed' ? 'selected' : '' }}>
                                            Số tiền cố định</option>
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
                                            value="{{ old('discount_value', $promotion->discount_value ? number_format($promotion->discount_value, 0, '.', '') : '') }}" step="1"
                                            min="0" required>
                                        <span class="input-group-text"
                                            id="discount-symbol">{{ $promotion->discount_type === 'percentage' ? '%' : 'đ' }}</span>
                                    </div>
                                    @error('discount_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="minimum_purchase">Giá trị đơn tối thiểu</label>
                                    <input type="number" name="minimum_purchase" id="minimum_purchase"
                                        class="form-control @error('minimum_purchase') is-invalid @enderror"
                                        value="{{ old('minimum_purchase', $promotion->minimum_purchase ? number_format($promotion->minimum_purchase, 0, '.', '') : '') }}" step="1"
                                        min="0" placeholder="0">
                                    @error('minimum_purchase')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="maximum_purchase">Giá trị đơn tối đa</label>
                                    <input type="number" name="maximum_purchase" id="maximum_purchase"
                                        class="form-control @error('maximum_purchase') is-invalid @enderror"
                                        value="{{ old('maximum_purchase', $promotion->maximum_purchase ? number_format($promotion->maximum_purchase, 0, '.', '') : '') }}" step="1"
                                        min="0" placeholder="Không giới hạn">
                                    @error('maximum_purchase')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="usage_limit">Giới hạn lượt dùng</label>
                                    <input type="number" name="usage_limit" id="usage_limit"
                                        class="form-control @error('usage_limit') is-invalid @enderror"
                                        value="{{ old('usage_limit', $promotion->usage_limit) }}" min="1"
                                        placeholder="Không giới hạn">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="start_date">Ngày bắt đầu <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="start_date" id="start_date"
                                            class="form-control flatpickr-input @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date', $promotion->start_date) }}"
                                            placeholder="YYYY-MM-DD HH:MM" required data-enable-time="true"
                                            data-date-format="Y-m-d H:i">
                                        <button type="button" class="btn btn-phoenix-secondary" id="start_date_button">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="end_date">Ngày kết thúc <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="end_date" id="end_date"
                                            class="form-control flatpickr-input @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date', $promotion->end_date) }}"
                                            placeholder="YYYY-MM-DD HH:MM" required data-enable-time="true"
                                            data-date-format="Y-m-d H:i">
                                        <button type="button" class="btn btn-phoenix-secondary" id="end_date_button">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Điều kiện áp dụng</h4>
                            @if ($categories->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label" for="categories">Áp dụng cho danh mục</label>
                                    <select name="categories[]" id="categories"
                                        class="form-select select2 @error('categories') is-invalid @enderror" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ in_array($category->id, old('categories', $promotion->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Nếu không chọn danh mục, khuyến mãi sẽ áp dụng cho
                                        tất cả danh mục</small>
                                    @error('categories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            @if ($products->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label" for="products">Áp dụng cho sản phẩm cụ thể</label>
                                    <select name="products[]" id="products"
                                        class="form-select select2 @error('products') is-invalid @enderror" multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ in_array($product->id, old('products', $promotion->products->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Nếu đã chọn danh mục, chỉ cần chọn sản phẩm cụ thể
                                        nếu muốn giới hạn thêm</small>
                                    @error('products')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label" for="is_active">Trạng thái</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1"
                                        {{ old('is_active', $promotion->is_active) == '1' ? 'selected' : '' }}>Hoạt động
                                    </option>
                                    <option value="0"
                                        {{ old('is_active', $promotion->is_active) == '0' ? 'selected' : '' }}>Không hoạt
                                        động</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fas fa-save me-2"></span>Cập nhật khuyến mãi
                                </button>
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
    <link rel="stylesheet" href="{{ asset('v1/vendors/flatpickr/flatpickr.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('v1/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for both products and categories
            $('.select2').select2({
                placeholder: 'Chọn danh mục hoặc sản phẩm',
                width: '100%'
            });

            // Initialize Flatpickr datepickers
            const startDatePicker = flatpickr("#start_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                allowInput: true
            });

            const endDatePicker = flatpickr("#end_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                allowInput: true
            });

            // Connect button to open date picker
            $("#start_date_button").on("click", function() {
                startDatePicker.open();
            });

            $("#end_date_button").on("click", function() {
                endDatePicker.open();
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
