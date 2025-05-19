<!-- resources/views/admin/colors/create.blade.php -->
@extends('admin.layouts')
@section('title', 'Thêm màu mới')
@section('content')

<div class="mb-4">
    <h4>Thêm màu mới</h4>
</div>

<form action="{{ route('admin.colors.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Tên màu</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="hex_code" class="form-label">Mã màu (HEX)</label>
        <input type="text" class="form-control" id="hex_code" name="hex_code" value="{{ old('hex_code') }}" required>
    </div>

    <div class="mb-3">
        <label for="image_url" class="form-label">Link ảnh (nếu có)</label>
        <input type="url" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}">
    </div>

    <div class="mb-3">
        <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
    </div>

    <button type="submit" class="btn btn-success">Lưu màu</button>
    <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
