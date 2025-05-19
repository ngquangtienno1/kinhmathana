@extends('admin.layouts')
@section('title', 'Thêm ảnh biến thể')
@section('content')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.variations.index') }}">Biến thể</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.variation_images.index', $variation->id) }}">Ảnh biến thể</a></li>
    <li class="breadcrumb-item active">Thêm ảnh</li>
@endsection

<div class="mb-4">
    <h2 class="mb-0">Thêm ảnh cho: {{ $variation->name }}</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.variation_images.store', $variation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Chọn ảnh</label>
                <input type="file" name="images[]" multiple class="form-control @error('images.*') is-invalid @enderror">
                @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" type="submit">Lưu</button>
                <a href="{{ route('admin.variation_images.index', $variation->id) }}" class="btn btn-secondary">Huỷ</a>
            </div>
        </form>
    </div>
</div>
@endsection
