@extends('admin.layouts')
@section('title', 'Chỉnh sửa Độ cận')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.sphericals.index') }}">Thuộc tính</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa Độ cận</li>
@endsection

<div class="container mt-4">
    <h4>Chỉnh sửa Độ cận: {{ $spherical->value }}</h4>

    <form action="{{ route('admin.sphericals.update', $spherical->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="value" class="form-label">Giá trị Độ cận</label>
            <input type="number" step="0.01" name="value" id="value" class="form-control"
                value="{{ old('value', $spherical->value) }}" required>
            @error('value')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                value="{{ old('sort_order', $spherical->sort_order) }}">
            @error('sort_order')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.sphericals.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

@endsection
