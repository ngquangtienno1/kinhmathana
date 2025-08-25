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
                    <button class="nav-link" id="product-reviews-tab" data-bs-toggle="tab"
                        data-bs-target="#product-reviews" type="button" role="tab" aria-controls="product-reviews"
                        aria-selected="false">Bình luận và đánh giá</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="product-orders-tab" data-bs-toggle="tab"
                        data-bs-target="#product-orders" type="button" role="tab" aria-controls="product-orders"
                        aria-selected="false">Đơn hàng ({{ $product->orderItems()->count() }})</button>
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
                                        @if ($product->brand)
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-primary">
                                                <span class="badge-label">{{ $product->brand->name }}</span>
                                                <span class="ms-1" data-feather="award"
                                                    style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        @else
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">
                                                <span class="badge-label">N/A</span>
                                                <span class="ms-1" data-feather="info"
                                                    style="height:12.8px;width:12.8px;"></span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>
                                        @if ($product->categories->count())
                                            @foreach ($product->categories as $cat)
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-info mb-1">
                                                    <span class="badge-label">{{ $cat->name }}</span>
                                                    <span class="ms-1" data-feather="tag"
                                                        style="height:12.8px;width:12.8px;"></span>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">
                                                <span class="badge-label">N/A</span>
                                                <span class="ms-1" data-feather="info"
                                                    style="height:12.8px;width:12.8px;"></span>
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
                                    <td>{{ number_format($product->total_stock_quantity ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @if ($product->product_type === 'simple')
                                    <tr>
                                        <th>Giá gốc</th>
                                        <td>{{ number_format($product->price ?? 0, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <th>Giá khuyến mãi</th>
                                        <td>{{ number_format($product->sale_price ?? 0, 0, ',', '.') }} VNĐ</td>
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
                                                    {{ $variation->name }} (Tồn kho:
                                                    {{ number_format($variation->quantity ?? 0, 0, ',', '.') }})
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
                                                            <td>{{ number_format($variation->price ?? 0, 0, ',', '.') }}
                                                                VNĐ
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Giá khuyến mãi</th>
                                                            <td>{{ number_format($variation->sale_price ?? 0, 0, ',', '.') }}
                                                                VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tồn kho</th>
                                                            <td>{{ number_format($variation->quantity ?? 0, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Trạng thái</th>
                                                            <td>{{ $variation->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                                            </td>
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
                                    @if ($review->reply)
                                        <div
                                            class="admin-reply mt-3 p-3 bg-light border-start border-primary border-3">
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

                <!-- Tab Đơn hàng -->
                <div class="tab-pane fade" id="product-orders" role="tabpanel" aria-labelledby="product-orders-tab">
                    <div class="mb-4">
                        <h5 class="mb-0">Danh sách đơn hàng chứa sản phẩm này</h5>
                    </div>

                    @php
                        $orderItems = $product
                            ->orderItems()
                            ->with(['order.user'])
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp

                    @if ($orderItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm fs-9 mb-0">
                                <thead>
                                    <tr>
                                        <th class="sort align-middle text-center px-3" scope="col"
                                            style="width:90px;">Mã đơn hàng</th>
                                        <th class="sort align-middle text-end px-3" scope="col"
                                            style="width:110px;">Tổng số tiền</th>
                                        <th class="sort align-middle text-center px-3" scope="col"
                                            style="width:180px;">Khách hàng</th>
                                        <th class="sort align-middle text-center px-3" scope="col"
                                            style="width:130px;">Trạng thái thanh toán</th>
                                        <th class="sort align-middle text-center px-3" scope="col"
                                            style="width:150px;">Trạng thái đơn hàng</th>
                                        <th class="sort align-middle text-center px-3" scope="col"
                                            style="width:180px;">Phương thức vận chuyển</th>
                                        <th class="sort align-middle text-center px-3 white-space-nowrap"
                                            scope="col" style="width:120px;">Ngày đặt hàng</th>
                                        <th class="sort text-center align-middle px-3" scope="col"
                                            style="width:90px;"></th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td class="order align-middle text-center white-space-nowrap py-0">
                                                <a class="fw-semibold"
                                                    href="{{ route('admin.orders.show', $item->order->id) }}">
                                                    #{{ $item->order->order_number ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="total align-middle text-end fw-semibold text-body-highlight px-3"
                                                style="white-space:nowrap;">
                                                {{ number_format($item->order->total_amount, 0, ',', '.') }} <span
                                                    class="text-muted ms-1">VND</span>
                                            </td>
                                            <td class="customer align-middle text-center white-space-nowrap px-3">
                                                @if ($item->order->user)
                                                    <div>
                                                        <strong>{{ $item->order->user->name ?? 'N/A' }}</strong><br>
                                                        <small
                                                            class="text-muted">{{ $item->order->user->email ?? 'N/A' }}</small>
                                                    </div>
                                                @elseif ($item->order->customer_name)
                                                    <div>
                                                        <strong>{{ $item->order->customer_name ?? 'N/A' }}</strong><br>
                                                        <small
                                                            class="text-muted">{{ $item->order->customer_phone ?? 'N/A' }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Khách hàng ẩn danh</span>
                                                @endif
                                            </td>
                                            <td
                                                class="payment_status align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
                                                @php
                                                    $paymentStatusMap = [
                                                        'unpaid' => [
                                                            'Chưa thanh toán',
                                                            'badge-phoenix-warning',
                                                            'clock',
                                                        ],
                                                        'paid' => ['Đã thanh toán', 'badge-phoenix-success', 'check'],
                                                        'failed' => [
                                                            'Thanh toán thất bại',
                                                            'badge-phoenix-danger',
                                                            'x',
                                                        ],
                                                    ];
                                                    $ps = $paymentStatusMap[$item->order->payment_status] ?? [
                                                        ucfirst($item->order->payment_status),
                                                        'badge-phoenix-secondary',
                                                        'info',
                                                    ];
                                                @endphp
                                                <span class="badge badge-phoenix fs-10 {{ $ps[1] }}">
                                                    <span class="badge-label">{{ $ps[0] }}</span>
                                                    <span class="ms-1" data-feather="{{ $ps[2] }}"
                                                        style="height:12.8px;width:12.8px;"></span>
                                                </span>
                                            </td>
                                            <td
                                                class="fulfilment_status align-middle text-center white-space-nowrap fw-bold text-body-tertiary px-3">
                                                @php
                                                    $orderStatusMap = [
                                                        'pending' => ['Chờ xác nhận', 'badge-phoenix-warning', 'clock'],
                                                        'confirmed' => [
                                                            'Đã xác nhận',
                                                            'badge-phoenix-primary',
                                                            'check-circle',
                                                        ],
                                                        'awaiting_pickup' => [
                                                            'Chờ lấy hàng',
                                                            'badge-phoenix-info',
                                                            'package',
                                                        ],
                                                        'shipping' => ['Đang giao', 'badge-phoenix-dark', 'truck'],
                                                        'delivered' => [
                                                            'Đã giao hàng',
                                                            'badge-phoenix-success',
                                                            'check',
                                                        ],
                                                        'completed' => [
                                                            'Đã hoàn thành',
                                                            'badge-phoenix-primary',
                                                            'award',
                                                        ],
                                                        'cancelled_by_customer' => [
                                                            'Khách hủy đơn',
                                                            'badge-phoenix-danger',
                                                            'x',
                                                        ],
                                                        'cancelled_by_admin' => [
                                                            'Admin hủy đơn',
                                                            'badge-phoenix-danger',
                                                            'x',
                                                        ],
                                                        'delivery_failed' => [
                                                            'Giao thất bại',
                                                            'badge-phoenix-danger',
                                                            'x',
                                                        ],
                                                    ];
                                                    $os = $orderStatusMap[$item->order->status] ?? [
                                                        ucfirst($item->order->status),
                                                        'badge-phoenix-secondary',
                                                        'info',
                                                    ];
                                                @endphp
                                                <span class="badge badge-phoenix fs-10 {{ $os[1] }}">
                                                    <span class="badge-label">{{ $os[0] }}</span>
                                                    <span class="ms-1" data-feather="{{ $os[2] }}"
                                                        style="height:12.8px;width:12.8px;"></span>
                                                </span>
                                            </td>
                                            <td
                                                class="delivery_type align-middle text-center white-space-nowrap text-body fs-9 px-3">
                                                @if ($item->order->shippingProvider)
                                                    <span
                                                        class="badge bg-primary-subtle text-primary fw-semibold fs-9">{{ $item->order->shippingProvider->name }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary fw-semibold fs-9"
                                                        style="width: 100px;">Chưa chọn</span>
                                                @endif
                                            </td>
                                            <td
                                                class="date align-middle text-center white-space-nowrap text-body-tertiary fs-9 px-3">
                                                {{ $item->order->created_at ? $item->order->created_at->format('d/m/Y H:i') : 'N/A' }}
                                            </td>
                                            <td
                                                class="align-middle text-center white-space-nowrap px-3 btn-reveal-trigger">
                                                <div class="btn-reveal-trigger position-static">
                                                    <button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-boundary="window" aria-haspopup="true"
                                                        aria-expanded="false" data-bs-reference="parent">
                                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.orders.show', $item->order->id) }}">Chi
                                                            tiết</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9 mt-3">
                            <div class="col-auto d-flex">
                                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                                    Tổng: {{ $orderItems->count() }} đơn hàng chứa sản phẩm này
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Sản phẩm này chưa có trong đơn hàng nào. Bạn có thể xóa sản phẩm này một cách an toàn.
                        </div>
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
