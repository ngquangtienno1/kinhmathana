@extends('client.layouts.app')

@section('content')
    <div class="pt-5 pb-9">
        <section class="py-0">
            <div class="container-small">
                <nav class="mb-3" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">
                                @if ($product->categories->first())
                                    {{ $product->categories->first()->name }}
                                @else
                                    Sản phẩm
                                @endif
                            </a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
                <div class="row g-5 mb-5 mb-lg-8" data-product-details="data-product-details">
                    <div class="col-12 col-lg-6">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-2 col-lg-12 col-xl-2">
                                <!-- Thumbnails -->
                                @php
                                    $allImages = collect();
                                    if (
                                        (request()->has('variant') || request()->has('size')) &&
                                        $selectedVariation &&
                                        $selectedVariation->images->count()
                                    ) {
                                        $allImages = $selectedVariation->images;
                                    } elseif ($product->images->count()) {
                                        $allImages = $product->images;
                                    }
                                @endphp
                                <div class="swiper-products-thumb swiper swiper theme-slider overflow-visible"
                                    id="swiper-products-thumb" style="height: 400px; max-width: 80px;">
                                    <div class="swiper-wrapper">
                                        @foreach ($allImages as $img)
                                            <div class="swiper-slide"
                                                style="height: 80px; width: 70px; margin-bottom: 8px;">
                                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                                    class="img-fluid rounded-2" alt="{{ $product->name }}"
                                                    style="object-fit:cover; height: 100%; width: 100%;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        if (window.Swiper) {
                                            // Khởi tạo Swiper thumbnail
                                            window.thumbSwiper = new Swiper('#swiper-products-thumb', {
                                                direction: 'vertical',
                                                slidesPerView: 4,
                                                spaceBetween: 8,
                                                watchSlidesProgress: true,
                                                freeMode: false,
                                                mousewheel: false,
                                                allowTouchMove: false,
                                            });
                                            // Khởi tạo Swiper chính và liên kết với thumbnail
                                            window.mainSwiper = new Swiper('.theme-slider[data-thumb-target="swiper-products-thumb"]', {
                                                slidesPerView: 1,
                                                spaceBetween: 16,
                                                thumbs: {
                                                    swiper: window.thumbSwiper
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </div>
                            <div class="col-12 col-md-10 col-lg-12 col-xl-10">
                                <!-- Main Image -->
                                <div
                                    class="d-flex align-items-center border border-translucent rounded-3 text-center p-5 h-100">
                                    <div class="swiper swiper theme-slider" data-thumb-target="swiper-products-thumb"
                                        data-products-swiper='{"slidesPerView":1,"spaceBetween":16,"thumbsEl":".swiper-products-thumb"}'>
                                        <div class="swiper-wrapper">
                                            @foreach ($allImages as $img)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                                        class="img-fluid rounded-3" alt="{{ $product->name }}">
                                    </div>
                                            @endforeach
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button
                                class="btn btn-lg btn-outline-warning rounded-pill w-100 me-3 px-2 px-sm-4 fs-9 fs-sm-8"><span
                                    class="me-2 far fa-heart"></span>Thêm vào yêu thích</button>
                            <button class="btn btn-lg btn-warning rounded-pill w-100 fs-9 fs-sm-8"><span
                                    class="fas fa-shopping-cart me-2"></span>Thêm vào giỏ</button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div>
                                <div class="d-flex flex-wrap">
                                    <div class="me-2">
                                        @php $avgRating = $product->reviews->avg('rating'); @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $avgRating)
                                                <span class="fa fa-star text-warning"></span>
                                            @else
                                                <span class="fa-regular fa-star text-warning-light"
                                                    data-bs-theme="light"></span>
                                            @endif
                                        @endfor
                                </div>
                                    <p class="text-primary fw-semibold mb-2">{{ $product->reviews->count() }} lượt đánh giá
                                    </p>
                                </div>
                                <h3 class="mb-3 lh-sm">{{ $product->name }}</h3>
                                <div class="d-flex flex-wrap align-items-start mb-3">
                                    @if ($product->is_featured)
                                        <span class="badge text-bg-success fs-9 rounded-pill me-2 fw-semibold">Nổi
                                            bật</span>
                                    @endif
                                    <a class="fw-semibold" href="#">
                                        @if ($product->brand)
                                            {{ $product->brand->name }}
                                        @endif
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap align-items-center mb-2">
                                    <h1 class="me-3 mb-0" data-product-price>
                                        {{ number_format($selectedVariation && $selectedVariation->sale_price ? $selectedVariation->sale_price : ($selectedVariation ? $selectedVariation->price : $product->sale_price ?? $product->price)) }} VNĐ
                                    </h1>
                                    @if($selectedVariation && $selectedVariation->sale_price && $selectedVariation->sale_price < $selectedVariation->price)
                                        <p class="text-body-quaternary text-decoration-line-through fs-6 mb-0 me-3">
                                            {{ number_format($selectedVariation->price) }} VNĐ
                                        </p>
                                        <p class="text-warning fw-bolder fs-6 mb-0">
                                            {{ round(100 - ($selectedVariation->sale_price / $selectedVariation->price) * 100) }}% giảm
                                        </p>
                                    @endif
                                </div>
                                <p data-product-stock
                                    class="{{ ($selectedVariation && $selectedVariation->stock_quantity > 0) || $product->stock_quantity > 0 ? 'text-success' : 'text-danger-dark' }} fw-semibold fs-7 mb-2">
                                    {{ ($selectedVariation && $selectedVariation->stock_quantity > 0) || $product->stock_quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                </p>
                                <p class="mb-2 text-body-secondary">{{ $product->description_short }}</p>
                            </div>
                            <div>
                                <!-- Color Variants -->
                                @php
                                    $colors = $product->variations->pluck('color')->unique('id')->filter();
                                @endphp
                                @if ($colors->count())
                                <div class="mb-3">
                                        <p class="fw-semibold mb-2 text-body">Màu sắc :</p>
                                        <div class="d-flex product-color-variants" data-product-color-variants="data-product-color-variants">
                                            @foreach ($colors as $color)
                                                @php
                                                    $variationOfColor = $product->variations
                                                        ->where('color_id', $color->id)
                                                        ->first();
                                                    $thumb =
                                                        $variationOfColor && $variationOfColor->images->count()
                                                            ? $variationOfColor->images->first()->image_path
                                                            : null;
                                                @endphp
                                                <div class="rounded-1 border border-translucent me-2 color-swatch @if ($selectedVariation && $selectedVariation->color_id == $color->id) active @endif"
                                                    data-color-id="{{ $color->id }}"
                                                    style="cursor:pointer; width:38px; height:38px; background:#fff; align-items:center; justify-content:center; overflow:hidden;"
                                                    title="{{ $color->name }}">
                                                    @if ($thumb)
                                                        <img src="{{ asset('storage/' . $thumb) }}"
                                                            alt="{{ $color->name }}"
                                                            style="width:100%;height:100%;object-fit:cover;">
                                                    @else
                                                        <span
                                                            style="display:block;width:100%;height:100%;background:{{ $color->code ?? '#eee' }};"></span>
                                                    @endif
                                    </div>
                                            @endforeach
                                </div>
                                    </div>
                                    <!-- Kích thước và số lượng cùng 1 hàng -->
                                    <div class="d-flex align-items-center mb-3">
                                        <!-- Kích thước -->
                                        @php
                                            $sizes = $product->variations->pluck('size')->unique('id')->filter();
                                        @endphp
                                        <div class="me-4">
                                            <p class="fw-semibold mb-2 text-body">Kích thước :</p>
                                            <select class="form-select w-auto" id="size-select">
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        @if ($selectedVariation && $selectedVariation->size_id == $size->id) selected @endif>
                                                        {{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                        <!-- Số lượng -->
                                        <div>
                                            <p class="fw-semibold mb-2 text-body">Số lượng :</p>
                                        <div class="d-flex justify-content-between align-items-end">
                                                <div class="d-flex flex-between-center" data-quantity="data-quantity">
                                                    <button class="btn btn-phoenix-primary px-3" data-type="minus"><span
                                                            class="fas fa-minus"></span></button>
                                                    <input
                                                    class="form-control text-center input-spin-none bg-transparent border-0 outline-none"
                                                        style="width:50px;" type="number" min="1" value="1" />
                                                    <button class="btn btn-phoenix-primary px-3" data-type="plus"><span
                                                            class="fas fa-plus"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of .container-->
        </section><!-- <section> close ============================-->
        <!-- ============================================-->



        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-0">
            <div class="container-small">
                <ul class="nav nav-underline fs-9 mb-4" id="productTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description"
                            aria-selected="true">Mô tả</a></li>
                    <li class="nav-item"><a class="nav-link" id="specification-tab" data-bs-toggle="tab"
                            href="#tab-specification" role="tab" aria-controls="tab-specification"
                            aria-selected="false">Thông tin sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#tab-reviews"
                            role="tab" aria-controls="tab-reviews" aria-selected="false">Đánh giá & nhận xét</a>
                    </li>
                </ul>
                <div class="row gx-3 gy-7">
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="tab-content" id="productTabContent">
                            <div class="tab-pane pe-lg-6 pe-xl-12 fade show active text-body-emphasis"
                                id="tab-description" role="tabpanel" aria-labelledby="description-tab">
                                <h4 class="mb-3">Mô tả sản phẩm</h4>
                                <p class="mb-4">{!! $product->description_long ?? $product->description ?? $product->description_short !!}</p>
                            </div>
                            <div class="tab-pane pe-lg-6 pe-xl-12 fade" id="tab-specification" role="tabpanel"
                                aria-labelledby="specification-tab">
                                <h3 class="mb-0 ms-4 fw-bold">Thông tin sản phẩm</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%"></th>
                                            <th style="width: 60%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Tên sản phẩm</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Mã sản phẩm</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->sku ?? 'Không xác định' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Loại sản phẩm</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->product_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Số lượng tồn kho</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->stock_quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Thương hiệu</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->brand->name ?? 'Không xác định' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Trạng thái</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->status ?? 'Không xác định' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Đặc biệt</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->is_featured ? 'Có' : 'Không' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Lượt xem</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->views }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Ngày tạo</h6>
                                            </td>
                                            <td class="px-5 mb-0">{{ $product->created_at ? $product->created_at->format('d/m/Y H:i') : 'Không xác định' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="bg-body-emphasis rounded-3 p-4 border border-translucent">
                                    <div class="row g-3 justify-content-between mb-4">
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <h2 class="fw-bolder me-3">{{ number_format($product->reviews->avg('rating'), 1) }}<span class="fs-8 text-body-quaternary fw-bold">/5</span></h2>
                                                <div class="me-3">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($product->reviews->avg('rating')))
                                                            <span class="fa fa-star text-warning fs-6"></span>
                                                        @else
                                                            <span class="fa fa-star text-secondary fs-6"></span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="text-body mb-0 fw-semibold fs-7">{{ $product->reviews->count() }} đánh giá</p>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#reviewModal">Đánh giá sản phẩm</button>
                                            <!-- Modal đánh giá sản phẩm -->
                                            <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content p-4">
                                                        <div class="d-flex flex-between-center mb-2">
                                                            <h5 class="modal-title fs-8 mb-0">Đánh giá của bạn</h5>
                                                        </div>
                                                        <div class="mb-3" id="rater" data-rater='{"starSize":32,"step":0.5}'></div>
                                                        <div class="mb-3">
                                                            <h5 class="text-body-highlight mb-3">Nhận xét của bạn</h5>
                                                            <textarea class="form-control" id="reviewTextarea" rows="5" placeholder="Viết nhận xét"></textarea>
                                                        </div>
                                                        <div class="dropzone dropzone-multiple p-0 mb-3" id="my-awesome-dropzone" data-dropzone>
                                                            <div class="fallback"><input name="file" type="file" multiple></div>
                                                            <div class="dz-preview d-flex flex-wrap"></div>
                                                            <div class="dz-message text-body-tertiary text-opacity-85 fw-bold fs-9 p-4" data-dz-message>
                                                                Kéo ảnh vào đây <span class="text-body-secondary">hoặc </span>
                                                                <button class="btn btn-link p-0">Chọn từ thiết bị</button><br>
                                                                <img class="mt-3 me-2" src="{{ asset('v1/assets/img/icons/image-icon.png') }}" width="24" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="d-sm-flex flex-between-center">
                                                            <div class="form-check flex-1">
                                                                <input class="form-check-input" id="reviewAnonymously" type="checkbox" value="" checked>
                                                                <label class="form-check-label mb-0 text-body-emphasis fw-semibold" for="reviewAnonymously">Ẩn danh</label>
                                                            </div>
                                                            <button class="btn ps-0" data-bs-dismiss="modal">Đóng</button>
                                                            <button class="btn btn-primary rounded-pill" id="submitReviewBtn">Gửi đánh giá</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($product->reviews as $review)
                                    <div class="mb-4 hover-actions-trigger btn-reveal-trigger">
                                        <div class="d-flex justify-content-between">
                                                <h5 class="mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <span class="fa fa-star text-warning"></span>
                                                        @else
                                                            <span class="fa fa-star text-secondary"></span>
                                                        @endif
                                                    @endfor
                                                    <span class="text-body-secondary ms-1"> by</span> {{ $review->user->name ?? 'Ẩn danh' }}
                                                </h5>
                                            </div>
                                            <p class="text-body-tertiary fs-9 mb-1">{{ $review->created_at->diffForHumans() }}</p>
                                            <p class="text-body-highlight mb-3">{{ $review->description }}</p>
                                        </div>
                                    @endforeach
                                    @if($product->reviews->isEmpty())
                                        <p class="text-center text-body-tertiary">Chưa có đánh giá nào cho sản phẩm này.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-body-emphasis">Usually Bought Together</h5>
                                <div class="w-75">
                                    <p class="text-body-tertiary fs-9 fw-bold line-clamp-1">with 24" iMac® with Retina 4.5K
                                        display - Apple M1 8GB Memory - 256GB SSD - w/Touch ID (Latest Model) - Blue</p>
                                </div>
                                <div class="border-dashed border-y border-translucent py-4">
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="form-check mb-0"><input class="form-check-input" type="checkbox"
                                                checked="checked" /><label class="form-check-label"></label></div><a
                                            href="product-details.html"> <img class="border border-translucent rounded"
                                                src="../../../assets/img/products/2.png" width="53"
                                                alt="" /></a>
                                        <div class="ms-2"><a class="fs-9 fw-bold line-clamp-2 mb-2"
                                                href="product-details.html"> iPhone 13 pro max-Pacific Blue- 128GB</a>
                                            <h5>$899.99</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="form-check mb-0"><input class="form-check-input" type="checkbox"
                                                checked="checked" /><label class="form-check-label"></label></div><a
                                            href="product-details.html"> <img class="border border-translucent rounded"
                                                src="../../../assets/img/products/16.png" width="53"
                                                alt="" /></a>
                                        <div class="ms-2"><a class="fs-9 fw-bold line-clamp-2 mb-2"
                                                href="product-details.html">Apple AirPods Pro</a>
                                            <h5>$59.00</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <div class="form-check mb-0"><input class="form-check-input"
                                                type="checkbox" /><label class="form-check-label"></label></div><a
                                            href="product-details.html"> <img class="border border-translucent rounded"
                                                src="../../../assets/img/products/10.png" width="53"
                                                alt="" /></a>
                                        <div class="ms-2"><a class="fs-9 fw-bold line-clamp-2 mb-2"
                                                href="product-details.html">Apple Magic Mouse (Wireless, Rechargable) -
                                                Silver, Worst mouse ever</a>
                                            <h5>$89.00</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between pt-3">
                                    <div>
                                        <h5 class="mb-2 text-body-tertiary text-opacity-85">Total</h5>
                                        <h4 class="mb-0 text-body-emphasis">$958.99</h4>
                                    </div>
                                    <div class="btn btn-outline-warning">Add 3 items to cart<span
                                            class="fas fa-shopping-cart ms-2"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="py-0 mb-9">
        <div class="container">
            <div class="d-flex flex-between-center mb-3">
                <div>
                    <h3>Sản phẩm liên quan</h3>
                    <p class="mb-0 text-body-tertiary fw-semibold">Quan tâm đến sản phẩm này</p>
                </div>
                <button class="btn btn-sm btn-phoenix-primary">Xem tất cả</button>
            </div>
            <div class="swiper-theme-container products-slider">
                <div class="swiper swiper theme-slider" data-swiper='{"slidesPerView":1,"spaceBetween":16,"breakpoints":{"450":{"slidesPerView":2,"spaceBetween":16},"768":{"slidesPerView":3,"spaceBetween":16},"992":{"slidesPerView":4,"spaceBetween":16},"1200":{"slidesPerView":5,"spaceBetween":16},"1540":{"slidesPerView":6,"spaceBetween":16}}}'>
                    <div class="swiper-wrapper">
                        @forelse($related_products as $related)
                        <div class="swiper-slide">
                            <div class="position-relative text-decoration-none product-card h-100">
                                <div class="d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <div class="border border-1 border-translucent rounded-3 position-relative mb-3">
                                                <img class="img-fluid" src="{{ $related->images->first() ? asset('storage/' . $related->images->first()->image_path) : asset('v1/assets/img/products/1.png') }}" alt="{{ $related->name }}" />
                                            </div>
                                            <a class="stretched-link" href="{{ route('client.products.show', $related->slug) }}">
                                                <h6 class="mb-2 lh-sm line-clamp-3 product-name">{{ $related->name }}</h6>
                                            </a>
                                            <p class="fs-9">
                                                @php $avg = $related->reviews->avg('rating'); @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($avg))
                                                        <span class="fa fa-star text-warning"></span>
                                                    @else
                                                        <span class="fa fa-star text-secondary"></span>
                                                    @endif
                                                @endfor
                                                <span class="text-body-quaternary fw-semibold ms-1">({{ $related->reviews->count() }} đánh giá)</span>
                                            </p>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                                @if($related->sale_price && $related->sale_price < $related->price)
                                                    <p class="me-2 text-body text-decoration-line-through mb-0">{{ number_format($related->price) }} VNĐ</p>
                                                    <h3 class="text-body-emphasis mb-0">{{ number_format($related->sale_price) }} VNĐ</h3>
                                                @else
                                                    <h3 class="text-body-emphasis mb-0">{{ number_format($related->price) }} VNĐ</h3>
                                                @endif
                                        </div>
                                            @if($related->variations->count())
                                                <p class="text-body-tertiary fw-semibold fs-9 lh-1 mb-0">{{ $related->variations->unique('color_id')->count() }} màu</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="swiper-slide">
                                <div class="text-center text-body-tertiary py-5">Không có sản phẩm liên quan.</div>
                            </div>
                        @endforelse
                </div>
                <div class="swiper-nav">
                    <div class="swiper-button-next"><span class="fas fa-chevron-right nav-icon"></span></div>
                    <div class="swiper-button-prev"><span class="fas fa-chevron-left nav-icon"></span></div>
                    </div>
                </div>
            </div>
        </div><!-- end of .container-->
    </section>
@endsection

<script id="all-variations-data" type="application/json">
{!! $product->variations->mapWithKeys(function($v) {
    return [ $v->color_id . '-' . $v->size_id => [
        'images' => $v->images->map(fn($img) => asset('storage/' . $img->image_path)),
        'price' => $v->sale_price ?? $v->price,
        'stock' => $v->stock_quantity,
        'name' => $v->name,
    ]];
})->toJson() !!}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.Swiper) {
            // Khởi tạo Swiper thumbnail
            window.thumbSwiper = new Swiper('#swiper-products-thumb', {
                direction: 'vertical',
                slidesPerView: 6,
                spaceBetween: 8,
                watchSlidesProgress: true,
                freeMode: false,
                mousewheel: false,
                allowTouchMove: false,
            });
            // Khởi tạo Swiper chính và liên kết với thumbnail
            window.mainSwiper = new Swiper('.theme-slider[data-thumb-target="swiper-products-thumb"]', {
                slidesPerView: 1,
                spaceBetween: 16,
                thumbs: {
                    swiper: window.thumbSwiper
                }
            });
        }

        document.querySelectorAll('.color-swatch').forEach(function(el) {
            el.addEventListener('click', function() {
                let colorId = this.getAttribute('data-color-id');
                let sizeId = document.getElementById('size-select').value;
                fetchVariation(colorId, sizeId);
                document.querySelectorAll('.color-swatch').forEach(e => e.classList.remove('active'));
                this.classList.add('active');
            });
        });
        document.getElementById('size-select').addEventListener('change', function() {
            let sizeId = this.value;
            let colorId = document.querySelector('.color-swatch.active')?.getAttribute('data-color-id');
            fetchVariation(colorId, sizeId);
        });
        function fetchVariation(colorId, sizeId) {
            const data = JSON.parse(document.getElementById('all-variations-data').textContent);
            const key = colorId + '-' + sizeId;
            if (!data[key]) return;
            // Cập nhật ảnh gallery
            let images = data[key].images;
            let thumbHtml = '', mainHtml = '';
            images.forEach(img => {
                thumbHtml += `<div class=\"swiper-slide\" style=\"height: 80px; width: 70px; margin-bottom: 8px;\"><img src=\"${img}\" class=\"img-fluid rounded-2\" style=\"object-fit:cover; height: 100%; width: 100%;\"></div>`;
                mainHtml += `<div class=\"swiper-slide\"><img src=\"${img}\" class=\"img-fluid rounded-3\"></div>`;
            });
            document.querySelector('#swiper-products-thumb .swiper-wrapper').innerHTML = thumbHtml;
            document.querySelector('.theme-slider[data-thumb-target="swiper-products-thumb"] .swiper-wrapper').innerHTML = mainHtml;
            // Cập nhật giá
            let priceEl = document.querySelector('[data-product-price]');
            if (priceEl) priceEl.textContent = Number(data[key].price).toLocaleString() + ' VNĐ';
            // Cập nhật tồn kho
            let stockEl = document.querySelector('[data-product-stock]');
            if (stockEl) {
                stockEl.textContent = data[key].stock > 0 ? 'Còn hàng' : 'Hết hàng';
                stockEl.className = data[key].stock > 0 ? 'text-success fw-semibold fs-7 mb-2' : 'text-danger-dark fw-semibold fs-7 mb-2';
            }
            // Update lại Swiper instance
            if (window.thumbSwiper) window.thumbSwiper.update();
            if (window.mainSwiper) window.mainSwiper.update();
            // Đồng bộ lại thumbs
            if (window.mainSwiper && window.thumbSwiper) {
                window.mainSwiper.thumbs.swiper = window.thumbSwiper;
                window.mainSwiper.thumbs.init();
                window.mainSwiper.thumbs.update();
            }
        }
    });
</script>

<style>
    /* Hiệu ứng active cho ảnh nhỏ Swiper thumbnail */
    #swiper-products-thumb .swiper-slide-thumb-active {
        border: 2px solid #ff9800;
        box-shadow: 0 0 0 2px #fff, 0 0 8px 2px #ff980033;
        border-radius: 8px;
        transition: border 0.2s, box-shadow 0.2s;
    }
</style>
