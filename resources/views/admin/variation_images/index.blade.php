@extends('admin.layouts')
@section('title', 'Quản lý ảnh biến thể')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.variations.index') }}">Biến thể</a>
    </li>
    <li class="breadcrumb-item active">Ảnh biến thể</li>
@endsection

<div class="mb-4 d-flex justify-content-between">
    <h2 class="mb-0">Ảnh của: {{ $variation->name }}</h2>
    <a href="{{ route('admin.variation_images.create', $variation->id) }}" class="btn btn-primary">
        <span class="fas fa-plus me-2"></span>Thêm ảnh
    </a>
</div>

<div class="row">
    @forelse ($images as $image)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                
                <div class="card-footer text-center">
                    <form method="POST" action="{{ route('admin.variation_images.destroy', [$variation->id, $image->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Xoá ảnh này?')">
                            Xoá
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Chưa có ảnh nào cho biến thể này.</p>
    @endforelse

</div>
<a href="{{ route('admin.variations.show', $variation->id) }}" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại chi tiết sản phẩm
</a>
@endsection



