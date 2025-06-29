@extends('client.layouts.app')

@section('content')
    <div class="pt-5 pb-9">

        <section class="py-0">
            <div class="container-small">
                <div class="row g-5 mb-5 mb-lg-8" data-product-details="data-product-details">
                    <div class="col-12 col-lg-6">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-2 col-lg-12 col-xl-2">
                                <div class="swiper-products-thumb swiper swiper theme-slider overflow-visible" id="swiper-products-thumb">
                                    <div class="swiper-wrapper">
                                        @php
                                            $selectedColorId = request()->has('variant') ? request()->input('variant') : ($product->variations->first()->color_id ?? null);
                                            $selectedSizeId = request()->has('size') ? request()->input('size') : ($product->variations->first()->size_id ?? null);
                                            $selectedSphericalId = request()->has('spherical') ? request()->input('spherical') : ($product->variations->first()->spherical_id ?? null);

                                            $selectedVariation = $product->variations
                                                ->where('color_id', $selectedColorId)
                        ->when($selectedSizeId, fn($query) => $query->where('size_id', $selectedSizeId))
                        ->when($selectedSphericalId, fn($query) => $query->where('spherical_id', $selectedSphericalId))
                        ->first() ?? $product->variations->first();

                                            $activeColor = $selectedVariation ? ($selectedVariation->color->name ?? 'Blue') : 'Blue';
                                            $featuredImage = $selectedVariation && $selectedVariation->images ? $selectedVariation->images->where('is_featured', true)->first() : ($product->images->where('is_featured', true)->first() ?? null);
                                            if ($featuredImage) {
                                                echo '<div class="swiper-slide"><img src="' . Storage::url($featuredImage->image_path) . '" alt="' . $product->name . '" width="38"></div>';
                                            }
                                            if ($selectedVariation && $selectedVariation->images) {
                                                foreach ($selectedVariation->images as $index => $image) {
                                                    if (!$image->is_featured) {
                                                        echo '<div class="swiper-slide"><img src="' . Storage::url($image->image_path) . '" alt="' . $product->name . '" width="38"></div>';
                                                    }
                                                }
                                            }
                                        @endphp
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-10 col-lg-12 col-xl-10">
                                <div class="d-flex align-items-center border border-translucent rounded-3 text-center p-5 h-100">
                                    <div class="swiper swiper theme-slider" data-thumb-target="swiper-products-thumb" data-products-swiper='{"slidesPerView":1,"spaceBetween":16,"thumbsEl":".swiper-products-thumb"}'>
                                        <div class="swiper-wrapper">
                                            @php
                                                if ($featuredImage) {
                                                    echo '<div class="swiper-slide"><img src="' . Storage::url($featuredImage->image_path) . '" alt="' . $product->name . '" class="img-fluid"></div>';
                                                }
                                                if ($selectedVariation && $selectedVariation->images) {
                                                    foreach ($selectedVariation->images as $index => $image) {
                                                        if (!$image->is_featured) {
                                                            echo '<div class="swiper-slide"><img src="' . Storage::url($image->image_path) . '" alt="' . $product->name . '" class="img-fluid"></div>';
                                                        }
                                                    }
                                                }
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-lg btn-outline-warning rounded-pill w-100 me-3 px-2 px-sm-4 fs-9 fs-sm-8">
                                <span class="me-2 far fa-heart"></span>Add to wishlist
                            </button>
                            <button class="btn btn-lg btn-warning rounded-pill w-100 fs-9 fs-sm-8">
                                <span class="fas fa-shopping-cart me-2"></span>Add to cart
                            </button>
                        </div>
                    </div>
                   <div class="col-12 col-lg-6">
    <div class="d-flex flex-column justify-content-between h-100">
        <div>
            <div class="d-flex flex-wrap">
                <div class="me-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="fa {{ $i <= floor($product->reviews->avg('rating') ?? 0) ? 'fa-star text-warning' : 'fa-regular fa-star text-warning-light' }}"></span>
                    @endfor
                </div>
                <p class="text-primary fw-semibold mb-2">{{ $product->reviews->count() }} People rated and reviewed</p>
            </div>
            <h3 class="mb-3 lh-sm">{{ $product->name }}</h3>
            <div class="d-flex flex-wrap align-items-start mb-3">
                @if ($product->views > 150)
                    <span class="badge text-bg-success fs-9 rounded-pill me-2 fw-semibold">Đạt sản phẩm được xem nhiều nhất</span>
                @endif
                <a class="fw-semibold" href="#!">{{ $product->views }} lượt xem</a>
            </div>
            <div class="d-flex flex-wrap align-items-center">
                @if ($selectedVariation && $selectedVariation->sale_price > 0 && $selectedVariation->sale_price < $selectedVariation->price)
                    <h1 class="me-3 text-success">{{ number_format($selectedVariation->sale_price, 2) }}đ</h1>
                    <p class="text-body-quaternary text-decoration-line-through fs-6 mb-0 me-3">{{ number_format($selectedVariation->price, 2) }}đ</p>
                @elseif ($selectedVariation)
                    <h1 class="me-3">{{ number_format($selectedVariation->price, 2) }}đ</h1>
                    @if ($product->sale_price > 0 && $product->sale_price < $product->price)
                        <p class="text-body-quaternary text-decoration-line-through fs-6 mb-0 me-3">{{ number_format($product->price, 2) }}đ</p>
                    @endif
                @else
                    <h1 class="me-3">{{ number_format($product->price ?? 0, 2) }}đ</h1> <!-- Fallback nếu không có biến thể -->
                @endif
            </div>
            <p class="text-success fw-semibold fs-7 mb-2">
                @if ($product->total_stock_quantity <= 0)
                    Hết hàng
                @else
                    Còn hàng
                @endif
            </p>
            <p class="mb-2 text-body-secondary">{!! $product->description_short !!}</p>
        </div>
        <div>
            <div class="mb-3">
                <p class="fw-semibold mb-2 text-body">Color : <span class="text-body-emphasis" data-product-color="data-product-color">
                    {{ $activeColor }}
                </span></p>
                <div class="d-flex product-color-variants" data-product-color-variants="data-product-color-variants">
                    @foreach ($product->variations->unique('color_id') as $variation)
                        @if ($variation->color)
                            <a href="{{ route('client.products.show', ['slug' => $product->slug, 'variant' => $variation->color_id, 'size' => $selectedVariation->size_id ?? $variation->size_id, 'spherical' => $selectedVariation->spherical_id ?? $variation->spherical_id]) }}"
                               class="rounded-1 border border-translucent me-2 {{ $variation->color->name === $activeColor ? 'active' : '' }}">
                                <img src="{{ $variation->images && $variation->images->first() ? Storage::url($variation->images->first()->image_path) : '/v1/assets/img/products/details/blue_front.png' }}" alt="" width="38" />
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="row g-3 g-sm-5 align-items-end">
                <div class="col-12 col-sm-auto">
                    <p class="fw-semibold mb-2 text-body">Size : </p>
                    <div class="d-flex align-items-center">
                        <select name="size" class="form-select w-auto" onchange="window.location.href='{{ route('client.products.show', $product->slug) }}?variant={{ $selectedVariation->color_id ?? $product->variations->first()->color_id ?? '' }}&size=' + this.value + '&spherical={{ $selectedVariation->spherical_id ?? $product->variations->first()->spherical_id ?? '' }}'">
                            @foreach ($product->variations->unique('size_id') as $variation)
                                @if ($variation->size)
                                    <option value="{{ $variation->size->id }}" {{ $selectedVariation && $selectedVariation->size_id == $variation->size_id ? 'selected' : '' }}>
                                        {{ $variation->size->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($product->variations->whereNotNull('spherical_id')->count() > 0)
                    <div class="mb-3">
                        <p class="fw-semibold mb-2 text-body">Độ cận :</p>
                        <div class="d-flex align-items-center">
                            <select name="spherical" class="form-select w-auto" onchange="window.location.href='{{ route('client.products.show', $product->slug) }}?variant={{ $selectedVariation->color_id ?? $product->variations->first()->color_id ?? '' }}&size={{ $selectedVariation->size_id ?? $product->variations->first()->size_id ?? '' }}&spherical=' + this.value">
                                @foreach ($product->variations->unique('spherical_id') as $variation)
                                    @if ($variation->spherical)
                                        <option value="{{ $variation->spherical->id }}" {{ $selectedVariation && $selectedVariation->spherical_id == $variation->spherical_id ? 'selected' : '' }}>
                                            {{ $variation->spherical->name ?? 'Không xác định' }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                @if ($product->variations->whereNotNull('cylindrical_id')->count() > 0)
                    <div class="mb-3">
                        <p class="fw-semibold mb-2 text-body">Độ loạn :</p>
                        <div class="d-flex align-items-center">
                            <select class="form-select w-auto">
                                @foreach ($product->variations->unique('cylindrical_id') as $variation)
                                    @if ($variation->cylindrical)
                                        <option value="{{ $variation->cylindrical->id }}" {{ $selectedVariation && $selectedVariation->cylindrical_id == $variation->cylindrical_id ? 'selected' : '' }}>
                                            {{ $variation->cylindrical->name ?? 'Không xác định' }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-12 col-sm">
                    <p class="fw-semibold mb-2 text-body">Quantity : </p>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="d-flex flex-between-center" data-quantity="data-quantity">
                            <button class="btn btn-phoenix-primary px-3" data-type="minus"><span class="fas fa-minus"></span></button>
                            <input class="form-control text-center input-spin-none bg-transparent border-0 outline-none" style="width:50px;" type="number" min="1" value="1" />
                            <button class="btn btn-phoenix-primary px-3" data-type="plus"><span class="fas fa-plus"></span></button>
                        </div>
                        <button class="btn btn-phoenix-primary px-3 border-0"><span class="fas fa-share-alt fs-7"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div><!-- end of .container-->
        </section><!-- <section> close ============================-->

        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-0">
            <div class="container-small">
                <ul class="nav nav-underline fs-9 mb-4" id="productTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a></li>
                    <li class="nav-item"><a class="nav-link" id="specification-tab" data-bs-toggle="tab" href="#tab-specification" role="tab" aria-controls="tab-specification" aria-selected="false">Specification</a></li>
                    <li class="nav-item"><a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">Ratings & reviews</a></li>
                </ul>
                <div class="row gx-3 gy-7">
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="tab-content" id="productTabContent">
                            <div class="tab-pane pe-lg-6 pe-xl-12 fade show active text-body-emphasis" id="tab-description" role="tabpanel" aria-labelledby="description-tab">
                                <p class="mb-5">{!! $product->description_long !!}</p>
                                @if ($product->images && $product->images->count() > 0)
                                    <a href="{{ Storage::url($product->images->first()->image_path) }}" data-gallery="gallery-description">
                                        <img class="img-fluid mb-5 rounded-3" src="{{ Storage::url($product->images->first()->image_path) }}" alt="">
                                    </a>
                                @endif
                            </div>
                            <div class="tab-pane pe-lg-6 pe-xl-12 fade" id="tab-specification" role="tabpanel" aria-labelledby="specification-tab">
                                <h3 class="mb-0 ms-4 fw-bold">Processor/Chipset</h3>
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
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Chip name</h6>
                                            </td>
                                            <td class="px-5 mb-0">Apple M1 chip</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Cpu core</h6>
                                            </td>
                                            <td class="px-5 mb-0">8 (4 performance and 4 efficiency)</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Gpu core</h6>
                                            </td>
                                            <td class="px-5 mb-0">7</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-body-highlight align-middle">
                                                <h6 class="mb-0 text-body text-uppercase fw-bolder px-4 fs-9 lh-sm">Neural engine</h6>
                                            </td>
                                            <td class="px-5 mb-0">16 cores</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="bg-body-emphasis rounded-3 p-4 border border-translucent">
                                    <div class="row g-3 justify-content-between mb-4">
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <h2 class="fw-bolder me-3">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }}<span class="fs-8 text-body-quaternary fw-bold">/5</span></h2>
                                                <div class="me-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="fa {{ $i <= floor($product->reviews->avg('rating') ?? 0) ? 'fa-star text-warning fs-6' : 'fa-regular fa-star text-warning-light fs-6' }}"></span>
                                                    @endfor
                                                </div>
                                                <p class="text-body mb-0 fw-semibold fs-7">{{ $product->reviews->count() }} ratings and {{ $product->reviews->count() }} reviews</p>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#reviewModal">Rate this product</button>
                                            <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content p-4">
                                                        <div class="d-flex flex-between-center mb-2">
                                                            <h5 class="modal-title fs-8 mb-0">Your rating</h5><button class="btn p-0 fs-10">Clear</button>
                                                        </div>
                                                        <div class="mb-3" data-rater='{"starSize":32,"step":0.5}'></div>
                                                        <div class="mb-3">
                                                            <h5 class="text-body-highlight mb-3">Your review</h5>
                                                            <textarea class="form-control" id="reviewTextarea" rows="5" placeholder="Write your review"></textarea>
                                                        </div>
                                                        <div class="dropzone dropzone-multiple p-0 mb-3" id="my-awesome-dropzone" data-dropzone>
                                                            <div class="fallback"><input name="file" type="file" multiple></div>
                                                            <div class="dz-preview d-flex flex-wrap">
                                                            </div>
                                                            <div class="dz-message text-body-tertiary text-opacity-85 fw-bold fs-9 p-4" data-dz-message>Drag your photo here <span class="text-body-secondary">or </span><button class="btn btn-link p-0">Browse from device </button><br><img class="mt-3 me-2" src="{{ asset('v1/assets/img/illustrations/1.png') }}" width="24" alt=""></div>
                                                        </div>
                                                        <div class="d-sm-flex flex-between-center">
                                                            <div class="form-check flex-1"><input class="form-check-input" id="reviewAnonymously" type="checkbox" value="" checked=""><label class="form-check-label mb-0 text-body-emphasis fw-semibold" for="reviewAnonymously">Review anonymously</label></div><button class="btn ps-0" data-bs-dismiss="modal">Close</button><button class="btn btn-primary rounded-pill">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($product->reviews as $review)
                                        <div class="mb-4 hover-actions-trigger btn-reveal-trigger">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="fa {{ $i <= $review->rating ? 'fa-star text-warning' : 'fa-regular fa-star text-warning-light' }}"></span>
                                                    @endfor
                                                    <span class="text-body-secondary ms-1"> by</span> {{ $review->user->name ?? 'Anonymous' }}
                                                </h5>
                                                <div class="btn-reveal-trigger position-static">
                                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                                        <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-body-tertiary fs-9 mb-1">{{ $review->created_at->format('d M, H:i A') }}</p>
                                            <p class="text-body-highlight mb-1">{{ $review->description }}</p>
                                            @if ($review->images && $review->images->count() > 0)
                                                <div class="row g-2 mb-2">
                                                    @foreach ($review->images as $image)
                                                        <div class="col-auto"><a href="{{ Storage::url($image->path) }}" data-gallery="gallery-{{ $loop->index }}"><img src="{{ Storage::url($image->path) }}" alt="" height="164" /></a></div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="hover-actions top-0">
                                                <button class="btn btn-sm btn-phoenix-secondary me-2"><span class="fas fa-thumbs-up"></span></button>
                                                <button class="btn btn-sm btn-phoenix-secondary me-1"><span class="fas fa-thumbs-down"></span></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="d-flex justify-content-center">
                                        <nav>
                                            <ul class="pagination mb-0">
                                                <li class="page-item"><a class="page-link" href="#!"><span class="fas fa-chevron-left"></span></a></li>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li class="page-item {{ $i == 4 ? 'active' : '' }}"><a class="page-link" href="#!">{{ $i }}</a></li>
                                                @endfor
                                                <li class="page-item"><a class="page-link" href="#!"><span class="fas fa-chevron-right"></span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-body-emphasis">Usually Bought Together</h5>
                                <div class="w-75">
                                    <p class="text-body-tertiary fs-9 fw-bold line-clamp-1">with {{ $product->name }}</p>
                                </div>
                               <!-- Trong phần "Usually Bought Together" -->
<div class="border-dashed border-y border-translucent py-4">
    @php
        $relatedProducts = $related_products->take(3);
    @endphp
    @foreach ($relatedProducts as $related)
        <div class="d-flex align-items-center mb-5">
            <div class="form-check mb-0"><input class="form-check-input" type="checkbox" checked="checked" /><label class="form-check-label"></label></div>
            <a href="{{ route('client.products.show', $related->slug) }}">
                <img class="border border-translucent rounded" src="{{ $related->images && $related->images->first() ? Storage::url($related->images->first()->image_path) : asset('v1/assets/img/products/15.png') }}" width="53" alt="" />
            </a>
            <div class="ms-2">
                <a class="fs-9 fw-bold line-clamp-2 mb-2" href="{{ route('client.products.show', $related->slug) }}">{{ $related->name }}</a>
                @php
                    $relatedVariation = $related->variations->first(); // Lấy biến thể đầu tiên
                @endphp
                @if ($relatedVariation && $relatedVariation->sale_price > 0 && $relatedVariation->sale_price < $relatedVariation->price)
                    <h5 class="text-success">{{ number_format($relatedVariation->sale_price, 2) }}đ</h5>
                    <p class="text-body-quaternary text-decoration-line-through fs-6 mb-0">{{ number_format($relatedVariation->price, 2) }}đ</p>
                @elseif ($relatedVariation)
                    <h5>{{ number_format($relatedVariation->price, 2) }}đ</h5>
                @else
                    <h5>{{ number_format($related->price ?? 0, 2) }}đ</h5> <!-- Fallback nếu không có biến thể -->
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Trong phần "Sản phẩm liên quan" -->
@foreach ($relatedProducts as $related)
    <div class="swiper-slide">
        <a href="{{ route('client.products.show', $related->slug) }}" class="position-relative text-decoration-none product-card h-100">
            <div class="d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="border border-1 border-translucent rounded-3 position-relative mb-3">
                        <button class="btn btn-wish btn-wish-primary z-2 d-toggle-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist">
                            <span class="fas fa-heart d-block-hover" data-fa-transform="down-1"></span>
                            <span class="far fa-heart d-none-hover" data-fa-transform="down-1"></span>
                        </button>
                        <img class="img-fluid" src="{{ $related->images && $related->images->first() ? Storage::url($related->images->first()->image_path) : asset('v1/assets/img/products/1.png') }}" alt="" />
                    </div>
                    <h6 class="mb-2 lh-sm line-clamp-3 product-name">{{ $related->name }}</h6>
                    <p class="fs-9">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="fa {{ $i <= floor($related->reviews->avg('rating') ?? 0) ? 'fa-star text-warning' : 'fa-regular fa-star text-warning-light' }}"></span>
                        @endfor
                        <span class="text-body-quaternary fw-semibold ms-1">({{ $related->reviews->count() }} people rated)</span>
                    </p>
                    <div class="d-flex align-items-center mb-1">
                        @php
                            $relatedVariation = $related->variations->first();
                        @endphp
                        @if ($relatedVariation && $relatedVariation->sale_price > 0 && $relatedVariation->sale_price < $relatedVariation->price)
                            <p class="me-2 text-body text-decoration-line-through mb-0">{{ number_format($relatedVariation->price, 2) }}đ</p>
                            <h3 class="text-body-emphasis mb-0 text-success">{{ number_format($relatedVariation->sale_price, 2) }}đ</h3>
                        @elseif ($relatedVariation)
                            <h3 class="text-body-emphasis mb-0">{{ number_format($relatedVariation->price, 2) }}đ</h3>
                        @else
                            <h3 class="text-body-emphasis mb-0">{{ number_format($related->price ?? 0, 2) }}đ</h3>
                        @endif
                    </div>
                    <p class="text-body-tertiary fw-semibold fs-9 lh-1 mb-0">{{ $related->variations->unique('color_id')->count() }} colors</p>
                </div>
            </div>
        </a>
    </div>
@endforeach
                                <div class="d-flex align-items-end justify-content-between pt-3">
                                    <div>
                                        <h5 class="mb-2 text-body-tertiary text-opacity-85">Total</h5>
                                        <h4 class="mb-0 text-body-emphasis">
                                            {{ number_format($relatedProducts->sum(function ($product) {
                                                return $product->sale_price > 0 && $product->sale_price < $product->price ? $product->sale_price : $product->price;
                                            }), 2) }}đ
                                        </h4>
                                    </div>
                                    <div class="btn btn-outline-warning">Add {{ $relatedProducts->count() }} items to cart<span class="fas fa-shopping-cart ms-2"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of .container-->
        </section><!-- <section> close ============================-->

    </div>
    <section class="py-0 mb-9">
        <div class="container">
            <div class="d-flex flex-between-center mb-3">
                <div>
                    <h3>Sản phẩm liên quan</h3>
                    <p class="mb-0 text-body-tertiary fw-semibold">Thiết yếu cho một cuộc sống tốt đẹp hơn</p>
                </div>
                <button class="btn btn-sm btn-phoenix-primary">Xem tất cả</button>
            </div>
            <div class="swiper-theme-container products-slider">
                <div class="swiper swiper theme-slider" data-swiper='{"slidesPerView":1,"spaceBetween":16,"breakpoints":{"450":{"slidesPerView":2,"spaceBetween":16},"768":{"slidesPerView":3,"spaceBetween":16},"992":{"slidesPerView":4,"spaceBetween":16},"1200":{"slidesPerView":5,"spaceBetween":16},"1540":{"slidesPerView":6,"spaceBetween":16}}}'>
                    <div class="swiper-wrapper">
                        @php
                            $categoryIds = $product->categories->pluck('id')->toArray();
                            $brandId = $product->brand_id ?? null;
                            $relatedProducts = \App\Models\Product::with(['images', 'reviews', 'variations.color'])
                                ->active()
                                ->where(function ($query) use ($categoryIds, $brandId) {
                                    if (!empty($categoryIds)) {
                                        $query->whereHas('categories', function ($q) use ($categoryIds) {
                                            $q->whereIn('categories.id', $categoryIds);
                                        });
                                    }
                                    if ($brandId) {
                                        $query->orWhere('brand_id', $brandId);
                                    }
                                })
                                ->where('id', '!=', $product->id)
                                ->take(6)
                                ->get();
                        @endphp
                        @foreach ($relatedProducts as $related)
                            <div class="swiper-slide">
                                <a href="{{ route('client.products.show', $related->slug) }}" class="position-relative text-decoration-none product-card h-100">
                                    <div class="d-flex flex-column justify-content-between h-100">
                                        <div>
                                            <div class="border border-1 border-translucent rounded-3 position-relative mb-3">
                                                <button class="btn btn-wish btn-wish-primary z-2 d-toggle-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist">
                                                    <span class="fas fa-heart d-block-hover" data-fa-transform="down-1"></span>
                                                    <span class="far fa-heart d-none-hover" data-fa-transform="down-1"></span>
                                                </button>
                                                <img class="img-fluid" src="{{ $related->images && $related->images->first() ? Storage::url($related->images->first()->image_path) : asset('v1/assets/img/products/1.png') }}" alt="" />
                                            </div>
                                            <h6 class="mb-2 lh-sm line-clamp-3 product-name">{{ $related->name }}</h6>
                                            <p class="fs-9">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="fa {{ $i <= floor($related->reviews->avg('rating') ?? 0) ? 'fa-star text-warning' : 'fa-regular fa-star text-warning-light' }}"></span>
                                                @endfor
                                                <span class="text-body-quaternary fw-semibold ms-1">({{ $related->reviews->count() }} people rated)</span>
                                            </p>
                                            <div class="d-flex align-items-center mb-1">
                                                @if ($related->sale_price > 0 && $related->sale_price < $related->price)
                                                    <p class="me-2 text-body text-decoration-line-through mb-0">{{ number_format($related->price, 2) }}đ</p>
                                                    <h3 class="text-body-emphasis mb-0 text-success">{{ number_format($related->sale_price, 2) }}đ</h3>
                                                @else
                                                    <h3 class="text-body-emphasis mb-0">{{ number_format($related->price, 2) }}đ</h3>
                                                @endif
                                            </div>
                                            <p class="text-body-tertiary fw-semibold fs-9 lh-1 mb-0">{{ $related->variations->unique('color_id')->count() }} colors</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-nav">
                    <div class="swiper-button-next"><span class="fas fa-chevron-right nav-icon"></span></div>
                    <div class="swiper-button-prev"><span class="fas fa-chevron-left nav-icon"></span></div>
                </div>
            </div>
        </div><!-- end of .container-->
    </section>
@endsection
