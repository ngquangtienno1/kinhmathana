@extends('admin.layouts')

@section('title', 'Sửa phương thức thanh toán')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.payment_methods.index') }}">Phương thức thanh toán</a>
    </li>
    <li class="breadcrumb-item active">Sửa phương thức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa phương thức thanh toán</h2>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('admin.payment_methods.update', $paymentMethod->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="name">Tên phương thức <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" type="text" value="{{ old('name', $paymentMethod->name) }}" required
                                maxlength="125" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="code">Mã phương thức <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" type="text" value="{{ old('code', $paymentMethod->code) }}" required
                                maxlength="50" />
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $paymentMethod->description) }}</textarea>
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
                            @if ($paymentMethod->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $paymentMethod->logo) }}" alt="Current logo"
                                        class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="api_key">API Key</label>
                            <input class="form-control @error('api_key') is-invalid @enderror" id="api_key"
                                name="api_key" type="text" value="{{ old('api_key', $paymentMethod->api_key) }}"
                                maxlength="255" />
                            @error('api_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="api_secret">API Secret</label>
                            <input class="form-control @error('api_secret') is-invalid @enderror" id="api_secret"
                                name="api_secret" type="text"
                                value="{{ old('api_secret', $paymentMethod->api_secret) }}" maxlength="255" />
                            @error('api_secret')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="api_endpoint">API Endpoint</label>
                            <input class="form-control @error('api_endpoint') is-invalid @enderror" id="api_endpoint"
                                name="api_endpoint" type="url"
                                value="{{ old('api_endpoint', $paymentMethod->api_endpoint) }}" maxlength="255" />
                            @error('api_endpoint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="api_settings">API Settings (JSON)</label>
                            <textarea class="form-control @error('api_settings') is-invalid @enderror" id="api_settings" name="api_settings"
                                rows="3">{{ old('api_settings', $paymentMethod->api_settings) }}</textarea>
                            @error('api_settings')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sort_order">Thứ tự hiển thị</label>
                            <input class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                name="sort_order" type="number"
                                value="{{ old('sort_order', $paymentMethod->sort_order) }}" min="0" />
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                    value="1"
                                    {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a class="btn btn-phoenix-secondary"
                                href="{{ route('admin.payment_methods.index') }}">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
