@extends('admin.layouts')
@section('title', 'Chỉnh sửa Độ cận')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.sphericals.index') }}">Độ cận</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa Độ cận</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chỉnh sửa Độ cận: {{ $spherical->name }}</h2>
        </div>
    </div>

    <form action="{{ route('admin.sphericals.update', $spherical->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Giá trị Độ cận</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $spherical->name) }}" required>
            @error('name')
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
