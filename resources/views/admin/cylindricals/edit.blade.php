@extends('admin.layouts')
@section('title', 'Chỉnh sửa Độ loạn')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.cylindricals.index') }}">Độ loạn</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa Độ loạn</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chỉnh sửa Độ loạn: {{ $cylindrical->name }}</h2>
        </div>
    </div>

    <form action="{{ route('admin.cylindricals.update', $cylindrical->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Giá trị Độ loạn</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $cylindrical->name) }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                value="{{ old('sort_order', $cylindrical->sort_order) }}">
            @error('sort_order')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.cylindricals.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

@endsection
