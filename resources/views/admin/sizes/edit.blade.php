@extends('admin.layouts')
@section('title', 'Chỉnh sửa kích thước')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thuộc tính</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa kích thước</li>
@endsection

<div class="container mt-4">
    <h4>Chỉnh sửa kích thước</h4>


    <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên kích thước</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $size->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $size->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="sort_order" class="form-label">Thứ tự sắp xếp</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                value="{{ old('sort_order', $size->sort_order) }}">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
