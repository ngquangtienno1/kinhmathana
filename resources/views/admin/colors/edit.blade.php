@extends('admin.layouts')
@section('title', 'Chỉnh sửa màu sắc')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.colors.index') }}">Thuộc tính</a>
</li>
<li class="breadcrumb-item active">Chỉnh sửa màu</li>
@endsection

<div class="container mt-4">
    <h4>Chỉnh sửa màu: {{ $color->name }}</h4>

    <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên màu</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $color->name) }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="hex_code" class="form-label">Mã màu (#HEX)</label>
            <input type="text" name="hex_code" id="hex_code" class="form-control" value="{{ old('hex_code', $color->hex_code) }}" required>
            @error('hex_code')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Link ảnh (nếu có)</label>
            <input type="url" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $color->image_url) }}">
            @error('image_url')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $color->sort_order) }}">
            @error('sort_order')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

@endsection
