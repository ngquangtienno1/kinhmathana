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
                                name="name" type="text" value="{{ old('name') }}" required />
                            @error('name')
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
                            <label class="form-label" for="logo_url">Biểu tượng</label>
                            <input class="form-control @error('logo_url') is-invalid @enderror" id="logo_url"
                                name="logo_url" type="file" accept="image/*" />
                            @error('logo_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
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

@endsection
