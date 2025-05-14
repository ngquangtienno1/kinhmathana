@extends('admin.layouts')

@section('title', 'Sửa thương hiệu')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thương hiệu</a>
    </li>
    <li class="breadcrumb-item active">Sửa thương hiệu</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa thương hiệu</h2>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="name">Tên thương hiệu <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" type="text" value="{{ old('name', $brand->name) }}" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $brand->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="image">Hình ảnh</label>
                            <input class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" type="file" accept="image/*" />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($brand->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                        class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                    value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a class="btn btn-phoenix-secondary" href="{{ route('admin.brands.index') }}">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
