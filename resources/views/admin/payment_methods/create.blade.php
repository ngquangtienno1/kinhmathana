@extends('admin.layouts')

@section('title', 'Thêm phương thức thanh toán')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.payment_methods.index') }}">Phương thức thanh toán</a>
    </li>
    <li class="breadcrumb-item active">Thêm phương thức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thêm phương thức thanh toán</h2>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('admin.payment_methods.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Tên phương thức <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" type="text" value="{{ old('name') }}" required maxlength="125" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="code">Mã phương thức <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" type="text" value="{{ old('code') }}" required maxlength="50" />
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="logo">Biểu tượng</label>
                            <input class="form-control @error('logo') is-invalid @enderror" id="logo"
                                name="logo" type="file" accept="image/*" />
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="api_key">API Key</label>
                            <input class="form-control @error('api_key') is-invalid @enderror" id="api_key"
                                name="api_key" type="text" value="{{ old('api_key') }}" maxlength="255" />
                            @error('api_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="api_secret">API Secret</label>
                            <input class="form-control @error('api_secret') is-invalid @enderror" id="api_secret"
                                name="api_secret" type="text" value="{{ old('api_secret') }}" maxlength="255" />
                            @error('api_secret')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="api_endpoint">API Endpoint</label>
                            <input class="form-control @error('api_endpoint') is-invalid @enderror" id="api_endpoint"
                                name="api_endpoint" type="url" value="{{ old('api_endpoint') }}" maxlength="255" />
                            @error('api_endpoint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="api_settings">API Settings (JSON)</label>
                            <textarea class="form-control @error('api_settings') is-invalid @enderror" id="api_settings" name="api_settings"
                                rows="3">{{ old('api_settings') }}</textarea>
                            @error('api_settings')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="sort_order">Thứ tự hiển thị</label>
                            <input class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                name="sort_order" type="number" value="{{ old('sort_order', 0) }}"
                                min="0" />
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                    value="1" {{ old('is_active', true) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Lưu</button>
                            <a class="btn btn-phoenix-secondary"
                                href="{{ route('admin.payment_methods.index') }}">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Preview image before upload
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.style.display = 'block';
                    preview.querySelector('img').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Validate JSON in api_settings
        document.getElementById('api_settings').addEventListener('change', function(e) {
            try {
                if (this.value) {
                    JSON.parse(this.value);
                    this.classList.remove('is-invalid');
                }
            } catch (error) {
                this.classList.add('is-invalid');
                this.setCustomValidity('Invalid JSON format');
            }
        });
    </script>
@endpush

@endsection
