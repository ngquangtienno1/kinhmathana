@extends('admin.layouts')
@section('title', 'Thêm Độ loạn mới')
@section('content')

<div class="mb-4">
    <h4>Thêm Độ loạn mới</h4>
</div>

<form action="{{ route('admin.cylindricals.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="value" class="form-label">Giá trị Độ loạn</label>
        <input type="number" step="0.01" class="form-control" id="value" name="value" value="{{ old('value') }}" required>
        @error('value')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
        <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
    </div>

    <button type="submit" class="btn btn-success">Lưu Độ loạn</button>
    <a href="{{ route('admin.cylindricals.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
