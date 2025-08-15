@extends('admin.layouts')

@section('title', 'Sửa khuyến mãi')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.promotions.index') }}">Khuyến mãi</a>
    </li>
    <li class="breadcrumb-item active">Sửa khuyến mãi</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Sửa khuyến mãi: {{ $promotion->name }}</h2>
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
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading mb-2">Có lỗi xảy ra, vui lòng kiểm tra lại:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" id="promotion-form">
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
                                    value="{{ old('name', $promotion->name) }}" required
                                    placeholder="Nhập tên khuyến mãi">
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
                                            {{ old('discount_type', $promotion->discount_type) == 'percentage' ? 'selected' : '' }}>Phần trăm (%)
                                        </option>
                                        <option value="fixed" {{ old('discount_type', $promotion->discount_type) == 'fixed' ? 'selected' : '' }}>Số
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
                                            value="{{ old('discount_value', $promotion->discount_value ? number_format($promotion->discount_value, 0, '.', '') : '') }}" step="1"
                                            min="0" max="100" required>
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
                                    <label class="form-label" for="start_date">Ngày bắt đầu <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" name="start_date" id="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date', $promotion->start_date ? $promotion->start_date->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label" for="end_date">Ngày kết thúc <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" name="end_date" id="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date', $promotion->end_date ? $promotion->end_date->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Hiển thị các mục đã chọn --}}
                            <div id="selected-items-display" class="mb-3 p-3" style="background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6; display: none;">
                                <h6 class="mb-2 text-success">
                                    <i class="fas fa-check-circle me-2"></i>Đã chọn:
                                </h6>
                                <div id="selected-categories" class="mb-2"></div>
                                <div id="selected-products"></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="categories">Chọn danh mục</label>
                                <select name="categories[]" id="categories" class="form-select select2" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array($category->id, old('categories', $promotion->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                                            {{ in_array($product->id, old('products', $promotion->products->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                                    value="{{ old('minimum_purchase', $promotion->minimum_purchase) }}" step="1" min="0"
                                    placeholder="0">
                                @error('minimum_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="maximum_purchase">Giá trị đơn tối đa</label>
                                <input type="number" name="maximum_purchase" id="maximum_purchase"
                                    class="form-control @error('maximum_purchase') is-invalid @enderror"
                                    value="{{ old('maximum_purchase', $promotion->maximum_purchase) }}" step="1" min="0"
                                    placeholder="Không giới hạn">
                                @error('maximum_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="usage_limit">Giới hạn lượt dùng</label>
                                <input type="number" name="usage_limit" id="usage_limit"
                                    class="form-control @error('usage_limit') is-invalid @enderror"
                                    value="{{ old('usage_limit', $promotion->usage_limit) }}" min="1" placeholder="Không giới hạn">
                                @error('usage_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="is_active">Trạng thái</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1" {{ old('is_active', $promotion->is_active) == '1' ? 'selected' : '' }}>Hoạt động
                                    </option>
                                    <option value="0" {{ old('is_active', $promotion->is_active) == '0' ? 'selected' : '' }}>Không hoạt động
                                    </option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="submit-spinner"></span>
                                    Cập nhật khuyến mãi
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
    <style>
        .badge { 
            font-size: 0.9em; 
            margin-right: 8px; 
            margin-bottom: 5px;
            padding: 6px 10px;
        }
        .remove-selected { 
            cursor: pointer; 
            margin-left: 5px;
            font-weight: bold;
        }
        .remove-selected:hover {
            opacity: 0.8;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .form-select.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }
        .alert-danger .btn-close {
            filter: invert(1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Khởi tạo Select2
            $('.select2').select2({
                width: '100%',
                placeholder: 'Chọn danh mục hoặc sản phẩm',
                allowClear: true
            });
            
            // Khôi phục trạng thái ban đầu dựa trên old values
            restoreFormState();
            
            // Set initial max value based on current discount type
            updateDiscountField();
            
            // Xóa mục đã chọn
            $(document).on('click', '.remove-selected', function(e){
                e.preventDefault();
                let type = $(this).data('type');
                let id = $(this).data('id').toString();
                let select = (type === 'category') ? '#categories' : '#products';
                let values = $(select).val() || [];
                values = values.filter(v => v != id);
                $(select).val(values).trigger('change');
                updateSelectedItemsDisplay();
            });

            // Change discount symbol and max value based on discount type
            $('#discount_type').change(function() {
                updateDiscountField();
            });

            // Update categories and products display when selection changes
            $('#categories, #products').on('change', function() {
                updateSelectedItemsDisplay();
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

            // Form submission handling
            $('#promotion-form').on('submit', function() {
                $('#submit-btn').prop('disabled', true);
                $('#submit-spinner').removeClass('d-none');
                
                // Lưu form state vào localStorage trước khi submit
                saveFormState();
            });

            // Auto-save form state khi user thay đổi
            $('input, select, textarea').on('change keyup', function() {
                saveFormState();
            });

            // Khôi phục form state từ localStorage nếu có
            function restoreFormState() {
                const savedState = localStorage.getItem('promotion_edit_form_state');
                if (savedState) {
                    try {
                        const state = JSON.parse(savedState);
                        
                        // Khôi phục các trường cơ bản
                        if (state.name) $('#name').val(state.name);
                        if (state.description) $('#description').val(state.description);
                        if (state.code) $('#code').val(state.code);
                        if (state.discount_type) $('#discount_type').val(state.discount_type);
                        if (state.discount_value) $('#discount_value').val(state.discount_value);
                        if (state.start_date) $('#start_date').val(state.start_date);
                        if (state.end_date) $('#end_date').val(state.end_date);
                        if (state.minimum_purchase) $('#minimum_purchase').val(state.minimum_purchase);
                        if (state.maximum_purchase) $('#maximum_purchase').val(state.maximum_purchase);
                        if (state.usage_limit) $('#usage_limit').val(state.usage_limit);
                        if (state.is_active) $('#is_active').val(state.is_active);
                        
                        // Khôi phục categories và products
                        if (state.categories && state.categories.length > 0) {
                            $('#categories').val(state.categories).trigger('change');
                        }
                        if (state.products && state.products.length > 0) {
                            $('#products').val(state.products).trigger('change');
                        }
                        
                        // Cập nhật hiển thị
                        updateDiscountField();
                        updateSelectedItemsDisplay();
                        
                    } catch (e) {
                        console.error('Error restoring form state:', e);
                    }
                }
            }

            // Lưu form state vào localStorage
            function saveFormState() {
                const state = {
                    name: $('#name').val(),
                    description: $('#description').val(),
                    code: $('#code').val(),
                    discount_type: $('#discount_type').val(),
                    discount_value: $('#discount_value').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    minimum_purchase: $('#minimum_purchase').val(),
                    maximum_purchase: $('#maximum_purchase').val(),
                    usage_limit: $('#usage_limit').val(),
                    is_active: $('#is_active').val(),
                    categories: $('#categories').val() || [],
                    products: $('#products').val() || []
                };
                
                localStorage.setItem('promotion_edit_form_state', JSON.stringify(state));
            }

            // Cập nhật trường discount dựa trên loại
            function updateDiscountField() {
                if ($('#discount_type').val() === 'percentage') {
                    $('#discount-symbol').text('%');
                    $('#discount_value').attr('max', '100');
                } else {
                    $('#discount-symbol').text('đ');
                    $('#discount_value').removeAttr('max');
                }
            }

            // Cập nhật hiển thị các mục đã chọn
            function updateSelectedItemsDisplay() {
                const categories = $('#categories').val() || [];
                const products = $('#products').val() || [];
                
                if (categories.length === 0 && products.length === 0) {
                    $('#selected-items-display').hide();
                    return;
                }
                
                $('#selected-items-display').show();
                
                // Hiển thị categories
                let categoriesHtml = '';
                if (categories.length > 0) {
                    categoriesHtml = '<div class="mb-2"><strong class="text-primary">Danh mục:</strong><br>';
                    categories.forEach(function(catId) {
                        const catName = $('#categories option[value="' + catId + '"]').text();
                        categoriesHtml += `<span class="badge bg-primary">
                            ${catName}
                            <a href="#" class="text-white remove-selected" data-type="category" data-id="${catId}">×</a>
                        </span>`;
                    });
                    categoriesHtml += '</div>';
                }
                $('#selected-categories').html(categoriesHtml);
                
                // Hiển thị products
                let productsHtml = '';
                if (products.length > 0) {
                    productsHtml = '<div><strong class="text-info">Sản phẩm:</strong><br>';
                    products.forEach(function(prodId) {
                        const prodName = $('#products option[value="' + prodId + '"]').text();
                        productsHtml += `<span class="badge bg-info">
                            ${prodName}
                            <a href="#" class="text-white remove-selected" data-type="product" data-id="${prodId}">×</a>
                        </span>`;
                    });
                    productsHtml += '</div>';
                }
                $('#selected-products').html(productsHtml);
            }

            // Xóa form state khi thành công
            function clearFormState() {
                localStorage.removeItem('promotion_edit_form_state');
            }

            // Nếu form submit thành công, xóa state
            @if(session('success'))
                clearFormState();
            @endif
        });
    </script>
@endsection
