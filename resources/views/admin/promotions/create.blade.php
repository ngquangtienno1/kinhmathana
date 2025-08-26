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

        <form action="{{ route('admin.promotions.store') }}" method="POST" id="promotion-form">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Thông tin khuyến mãi</h4>

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
                                            {{ old('discount_type', 'percentage') == 'percentage' ? 'selected' : '' }}>Phần
                                            trăm (%)
                                        </option>
                                        <option value="fixed"
                                            {{ old('discount_type', 'percentage') == 'fixed' ? 'selected' : '' }}>Số
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
                                            value="{{ old('discount_value') }}" step="1" min="0"
                                            max="100" required>
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
                                    value="{{ old('minimum_purchase', '0') }}" step="1" min="0"
                                    placeholder="0">
                                @error('minimum_purchase')
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
                                    <option value="0" {{ old('is_active', '1') == '0' ? 'selected' : '' }}>Không hoạt
                                        động
                                    </option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="submit-spinner"></span>
                                    Tạo khuyến mãi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
                placeholder: 'Chọn mục...',
                allowClear: true
            });

            // Không còn khôi phục selections (categories/products) vì đã bỏ chọn theo yêu cầu

            // Set initial max value based on current discount type
            updateDiscountField();

            // Xóa mục đã chọn
            $(document).on('click', '.remove-selected', function(e) {
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

            // Bỏ theo dõi selections

            // Generate promotion code
            $('#generate-code').click(function() {
                const $btn = $(this);
                $btn.prop('disabled', true);
                $.ajax({
                    url: "{{ route('admin.promotions.generate-code') }}",
                    type: "GET",
                    success: function(response) {
                        if (response && response.code) {
                            $('#code').val(response.code);
                        } else {
                            alert('Không nhận được mã hợp lệ. Vui lòng thử lại.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Generate code error:', xhr.responseText || xhr
                            .statusText);
                        alert('Không thể tạo mã. Vui lòng thử lại.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
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

            // Bỏ restore selections

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
                    usage_limit: $('#usage_limit').val(),
                    is_active: $('#is_active').val()
                };

                localStorage.setItem('promotion_form_state', JSON.stringify(state));
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
            // Bỏ hiển thị selections

            // Xóa form state khi thành công
            function clearFormState() {
                localStorage.removeItem('promotion_form_state');
            }

            // Nếu form submit thành công, xóa state
            @if (session('success'))
                clearFormState();
            @endif
        });
    </script>
@endpush
