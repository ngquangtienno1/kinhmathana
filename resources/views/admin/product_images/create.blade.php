@extends('admin.layouts')
@section('title', 'Thêm ảnh sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
       <a href="{{ route('admin.product_images.index', $product->id) }}">Quản lý ảnh sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Thêm ảnh</li>
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $hasThumbnail = $product->images()->where('is_thumbnail', true)->exists();
@endphp

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thêm ảnh cho: {{ $product->name }}</h2>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.product_images.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="images" class="form-label">Chọn ảnh (có thể chọn nhiều)</label>
                    <input class="form-control" type="file" name="images[]" id="images" multiple required>
                </div>

                @if (!$hasThumbnail)
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Chọn ảnh thumbnail</label>
                        <select name="thumbnail" class="form-control">
                            <option value="">-- Chưa chọn --</option>
                            <option value="0">Ảnh đầu tiên</option>
                            <option value="1">Ảnh thứ hai</option>
                            <option value="2">Ảnh thứ ba</option>
                            <option value="3">Ảnh thứ tư</option>
                        </select>
                        <small class="text-muted">Tuỳ chọn index tương ứng với ảnh upload</small>
                    </div>
                @else
                    <div class="alert alert-info">
                        Sản phẩm này đã có ảnh đại diện. Các ảnh mới sẽ được thêm vào danh sách ảnh nhưng không thể đặt làm thumbnail.
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('admin.product_images.index', $product->id) }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>

@endsection
