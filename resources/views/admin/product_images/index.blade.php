    @extends('admin.layouts')
    @section('title', 'Ảnh sản phẩm')
    @section('content')
    <div class="container mt-4">
        <h4>Quản lý ảnh: {{ $product->name }}</h4>
        <a href="{{ route('admin.product_images.create', $product->id) }}" class="btn btn-primary mb-3">Thêm ảnh mới</a>

       

        <div class="row">
            @forelse ($images as $image)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top">
                        <div class="card-body text-center">
                            @if($image->is_thumbnail)
                                <span class="badge bg-success">Thumbnail</span>
                            @else
                                <form action="{{ route('admin.product_images.setThumbnail', [$product->id, $image->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Đặt làm thumbnail</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.product_images.destroy', [$product->id, $image->id]) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa ảnh này?')">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>Chưa có ảnh nào.</p>
            @endforelse
        </div>
    </div>
    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại chi tiết sản phẩm
</a>
    @endsection
