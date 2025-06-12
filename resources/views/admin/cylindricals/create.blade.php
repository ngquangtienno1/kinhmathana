@extends('admin.layouts')
@section('title', 'Thêm Độ loạn mới')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.cylindricals.index') }}">Độ loạn</a>
    </li>
    <li class="breadcrumb-item active">Thêm Độ loạn mới</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thêm Độ loạn mới</h2>
        </div>
</div>

<form action="{{ route('admin.cylindricals.store') }}" method="POST">
    @csrf

    <div class="mb-3">
            <label for="name" class="form-label">Giá trị Độ loạn</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ old('name') }}" required>
            @error('name')
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
</div>
@endsection
