@extends('admin.layouts')
@section('title', 'Chi tiết sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết sản phẩm: {{ $product->name }}</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <a href="{{ route('admin.products.list') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
                <a href="{{ route('admin.inventory.index') }}?search={{ $product->sku }}" class="btn btn-info">
                    <span class="fas fa-history me-2"></span>Xem lịch sử kho
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="product-info-tab" data-bs-toggle="tab"
                        data-bs-target="#product-info" type="button" role="tab" aria-controls="product-info"
                        aria-selected="true">Thông tin cơ bản</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="product-images-tab" data-bs-toggle="tab"
                        data-bs-target="#product-images" type="button" role="tab" aria-controls="product-images"
                        aria-selected="false">Album ảnh</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="product-video-tab" data-bs-toggle="tab" data-bs-target="#product-video"
                        type="button" role="tab" aria-controls="product-video" aria-selected="false">Video sản
                        phẩm</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="product-reviews-tab" data-bs-toggle="tab"
                        data-bs-target="#product-reviews" type="button" role="tab" aria-controls="product-reviews"
                        aria-selected="false">Bình luận và đánh giá</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="productTabsContent">
                <!-- Tab Thông tin cơ bản -->
                <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                    aria-labelledby="product-info-tab">
                    <div class="row g-3">
                        <!-- Ảnh đại diện -->
                        @if ($product->images->where('is_featured', true)->first())
                            <div class="col-md-4">
                                <h5>Ảnh đại diện</h5>
                                <img src="{{ asset('storage/' . $product->images->where('is_featured', true)->first()->image_path) }}"
                                    alt="Ảnh đại diện" class="featured-image">
                            </div>
                        @endif

                        <!-- Thông tin sản phẩm -->
                        <div class="col-md-8">
                            <h5>Thông tin sản phẩm</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <td>{{ $product->sku }}</td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu</th>
                                    <td>
                                        @if($product->brand)
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-primary">
                                                <span class="badge-label">{{ $product->brand->name }}</span>
                                                <span class="ms-1" data-feather="award" style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        @else
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">
                                                <span class="badge-label">N/A</span>
                                                <span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>
                                        @if($product->categories->count())
                                            @foreach($product->categories as $cat)
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-info mb-1">
                                                    <span class="badge-label">{{ $cat->name }}</span>
                                                    <span class="ms-1" data-feather="tag" style="height:12.8px;width:12.8px;"></span>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">
                                                <span class="badge-label">N/A</span>
                                                <span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>{{ $product->status }}</td>
                                </tr>
                                <tr>
                                    <th>Nổi bật</th>
                                    <td>{{ $product->is_featured ? 'Có' : 'Không' }}</td>
                                </tr>
                                <tr>
                                    <th>Tổng tồn kho</th>
                                    <td>{{ $product->total_stock }}</td>
                                </tr>
                                @if ($product->product_type === 'simple')
                                    <tr>
                                        <th>Giá gốc</th>
                                        <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <th>Giá khuyến mãi</th>
                                        <td>{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Mô tả ngắn</th>
                                    <td>{{ $product->description_short }}</td>
                                </tr>
                                <tr>
                                    <th>Mô tả chi tiết</th>
                                    <td>
                                        <div class="product-description">
                                            {!! $product->description_long !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Biến thể nếu có -->
                            @if ($product->product_type === 'variable')
                                <h5>Chọn biến thể để xem ảnh</h5>
                                <div class="mb-3">
                                    <select class="form-select" id="variation-select">
                                        @foreach ($product->variations as $variation)
                                            <option value="{{ $variation->id }}"
                                                data-image="{{ $variation->images->first() ? asset('storage/' . $variation->images->first()->image_path) : '' }}">
                                                {{ $variation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="variant-image-container">
                                    @if ($product->variations->first() && $product->variations->first()->images->first())
                                        <img src="{{ asset('storage/' . $product->variations->first()->images->first()->image_path) }}"
                                            alt="Ảnh biến thể" class="variation-image" id="variant-image">
                                    @else
                                        <p>Không có ảnh</p>
                                    @endif
                                </div>

                                <h5>Biến thể sản phẩm</h5>
                                <div class="accordion" id="variationsAccordion">
                                    @foreach ($product->variations as $index => $variation)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $index }}">
                                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $index }}"
                                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                                    aria-controls="collapse{{ $index }}">
                                                    {{ $variation->name }} (Tồn kho: {{ $variation->stock_quantity }})
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $index }}"
                                                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                                aria-labelledby="heading{{ $index }}"
                                                data-bs-parent="#variationsAccordion">
                                                <div class="accordion-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Mã biến thể</th>
                                                            <td>{{ $variation->sku }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Giá gốc</th>
                                                            <td>{{ number_format($variation->price, 0, ',', '.') }} VNĐ
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Giá khuyến mãi</th>
                                                            <td>{{ number_format($variation->sale_price, 0, ',', '.') }}
                                                                VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tồn kho</th>
                                                            <td>{{ $variation->stock_quantity }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Trạng thái</th>
                                                            <td>{{ $variation->stock_quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ảnh</th>
                                                            <td>
                                                                @if ($variation->images->first())
                                                                    <img src="{{ asset('storage/' . $variation->images->first()->image_path) }}"
                                                                        alt="Ảnh biến thể" class="variation-image">
                                                                @else
                                                                    Không có ảnh
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab Album ảnh -->
                <div class="tab-pane fade" id="product-images" role="tabpanel" aria-labelledby="product-images-tab">
                    <h5>Album ảnh</h5>
                    @if ($product->images->where('is_featured', false)->count() > 0)
                        <div class="gallery-images-preview">
                            @foreach ($product->images->where('is_featured', false) as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Ảnh album">
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có ảnh trong album.</p>
                    @endif
                </div>

                <!-- Tab Video sản phẩm -->
                <div class="tab-pane fade" id="product-video" role="tabpanel" aria-labelledby="product-video-tab">
                    <h5>Video sản phẩm</h5>
                    @if ($product->video_path)
                        <div class="video-container">
                            <video class="product-video" controls>
                                <source src="{{ asset('storage/' . $product->video_path) }}" type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ thẻ video.
                            </video>
                        </div>
                    @else
                        <p class="text-muted">Chưa có video sản phẩm.</p>
                    @endif
                </div>

                <!-- Tab Bình luận và đánh giá -->
                <div class="tab-pane fade" id="product-reviews" role="tabpanel"
                    aria-labelledby="product-reviews-tab">
                    <h4>Đánh giá</h4>
                    @if ($product->reviews->count() > 0)
                        <div class="reviews-list">
                            @foreach ($product->reviews as $review)
                                <div class="review-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $review->user->name ?? 'Người dùng ẩn danh' }}</strong>
                                        <span>{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                        @endfor
                                    </div>
                                    <p class="mt-2">{{ $review->content }}</p>
                                    @if($review->reply)
                                        <div class="admin-reply mt-3 p-3 bg-light border-start border-primary border-3">
                                            <strong class="text-primary">💬 Trả lời của Admin:</strong><br>
                                            {{ $review->reply }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có đánh giá nào.</p>
                    @endif
                    <hr>
                    <h4>Bình luận</h4>
                    @if ($product->comments->count() > 0)
                        <div class="comments-list">
                            @foreach ($product->comments as $comment)
                                <div class="comment-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</strong>
                                        <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="mt-2">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có bình luận nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .featured-image {
        max-width: 300px;
        border: 2px solid #007bff;
        padding: 2px;
        border-radius: 4px;
    }

    .variation-image {
        max-width: 100px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    #variant-image-container {
        margin-bottom: 20px;
    }

    #variant-image {
        max-width: 200px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .gallery-images-preview img {
        max-width: 150px;
        margin: 10px;
        display: inline-block;
        border: 2px solid #6c757d;
        padding: 2px;
        border-radius: 4px;
    }

    .video-container {
        max-width: 800px;
        margin: 20px auto;
    }

    .product-video {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .reviews-list .review-item {
        background-color: #f9f9f9;
    }

    .rating .star {
        color: #ddd;
        font-size: 1.2rem;
    }

    .rating .star.filled {
        color: #f39c12;
    }

    .accordion-item {
        margin-bottom: 10px;
    }

    .accordion-button {
        font-weight: bold;
    }

    .product-description {
        font-size: 14px;
        line-height: 1.6;
    }

    .product-description img {
        max-width: 100%;
        height: auto;
        margin: 10px 0;
    }

    .product-description p {
        margin-bottom: 1rem;
    }

    .product-description ul,
    .product-description ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    th {
        white-space: nowrap;
        vertical-align: top;
    }
</style>

<script>
    document.getElementById('variation-select')?.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const imageUrl = selectedOption.getAttribute('data-image');
        const variantImage = document.getElementById('variant-image');
        if (imageUrl) {
            variantImage.src = imageUrl;
            variantImage.style.display = 'block';
        } else {
            variantImage.style.display = 'none';
        }
    });
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.feather) {
            window.feather.replace();
        }
    });
</script>
@endpush
@endsection
