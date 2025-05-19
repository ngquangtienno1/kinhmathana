@extends('admin.layouts')
@section('title', 'Thêm size')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.sizes.index') }}">Size</a>
    </li>
    <li class="breadcrumb-item active">Thêm size</li>
@endsection

<div class="mb-4">
    <h2 class="mb-0">Thêm size mới</h2>
</div>



<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.sizes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên size</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả (tuùy chọn)</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="sort_order" class="form-label">Thứ tự sắp xếp</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection
