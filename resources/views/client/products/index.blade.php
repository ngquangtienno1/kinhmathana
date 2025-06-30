@extends('client.layouts.app')

@section('content')
<section class="pt-5 pb-9">
        <div class="product-filter-container">
            <button class="btn btn-sm btn-phoenix-secondary text-body-tertiary mb-5 d-lg-none" data-phoenix-toggle="offcanvas"
                data-phoenix-target="#productFilterColumn">
                <span class="fa-solid fa-filter me-2"></span>Filter
            </button>
      <div class="row">
        <div class="col-lg-3 col-xxl-2 ps-2 ps-xxl-3">
                    <div class="phoenix-offcanvas-filter bg-body scrollbar phoenix-offcanvas phoenix-offcanvas-fixed"
                        id="productFilterColumn" style="top: 92px" data-breakpoint="lg">
            <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Bộ lọc</h3>
                            <button class="btn d-lg-none p-0" data-phoenix-dismiss="offcanvas">
                                <span class="uil uil-times fs-8"></span>
                            </button>
                        </div>

                        <!-- Availability Filter -->
                        <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse"
                            href="#collapseAvailability" role="button" aria-expanded="true"
                            aria-controls="collapseAvailability">
              <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="fs-8 text-body-highlight">Trạng thái</div>
                                <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
              </div>
            </a>
            <div class="collapse show" id="collapseAvailability">
              <div class="mb-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input mt-0" id="inStockInput" type="checkbox"
                                        name="availability[]" value="in_stock"
                                        {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0"
                                        for="inStockInput">Còn hàng</label>
                                </div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input mt-0" id="outOfStockInput" type="checkbox"
                                        name="availability[]" value="out_of_stock"
                                        {{ in_array('out_of_stock', request('availability', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0"
                                        for="outOfStockInput">Hết hàng</label>
                                </div>
                            </div>
              </div>

                        <!-- Color Filter -->
                        <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseColorFamily"
                            role="button" aria-expanded="true" aria-controls="collapseColorFamily">
              <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="fs-8 text-body-highlight">Màu sắc</div>
                                <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
              </div>
            </a>
            <div class="collapse show" id="collapseColorFamily">
              <div class="mb-2">
                                @foreach ($colors as $color)
                                    <div class="form-check mb-0">
                                        <input class="form-check-input mt-0" id="color_{{ $color->id }}" type="checkbox"
                                            name="colors[]" value="{{ $color->id }}"
                                            {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0"
                                            for="color_{{ $color->id }}">{{ $color->name }}</label>
                                    </div>
                                @endforeach
                            </div>
              </div>

                        <!-- Brand Filter -->
                        <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseBrands"
                            role="button" aria-expanded="true" aria-controls="collapseBrands">
              <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="fs-8 text-body-highlight">Thương hiệu</div>
                                <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
              </div>
            </a>
            <div class="collapse show" id="collapseBrands">
              <div class="mb-2">
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-0">
                                        <input class="form-check-input mt-0" id="brand_{{ $brand->id }}" type="checkbox"
                                            name="brands[]" value="{{ $brand->id }}"
                                            {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0"
                                            for="brand_{{ $brand->id }}">{{ $brand->name }}</label>
                                    </div>
                                @endforeach
                            </div>
              </div>

                        <!-- Price Range Filter -->
                        <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapsePriceRange"
                            role="button" aria-expanded="true" aria-controls="collapsePriceRange">
              <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="fs-8 text-body-highlight">Khoảng giá</div>
                                <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
              </div>
            </a>
            <div class="collapse show" id="collapsePriceRange">
              <div class="d-flex justify-content-between mb-3">
                                <div class="input-group me-2">
                                    <input class="form-control" type="number" name="min_price" placeholder="Min"
                                        value="{{ request('min_price') }}">
                                    <input class="form-control" type="number" name="max_price" placeholder="Max"
                                        value="{{ request('max_price') }}">
                                </div>
                                <button class="btn btn-phoenix-primary px-3" type="submit">Go</button>
                            </div>
              </div>

                        <!-- Rating Filter -->
                        <a class="btn px-0 y-4 d-block collapse-indicator" data-bs-toggle="collapse"
                            href="#collapseRating" role="button" aria-expanded="true" aria-controls="collapseRating">
              <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="fs-8 text-body-highlight">Đánh giá</div>
                                <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
              </div>
            </a>
            <div class="collapse show" id="collapseRating">
                            @for ($i = 5; $i >= 1; $i--)
                                <div class="d-flex align-items-center mb-1">
                                    <input class="form-check-input me-3" id="rating_{{ $i }}" type="radio"
                                        name="rating" value="{{ $i }}"
                                        {{ request('rating') == $i ? 'checked' : '' }}>
                                    @for ($j = 1; $j <= 5; $j++)
                                        @if ($j <= $i)
                                            <span class="fa fa-star text-warning fs-9 me-1"></span>
                                        @else
                                            <span class="fa-regular fa-star text-warning-light fs-9 me-1"
                                                data-bs-theme="light"></span>
                                        @endif
                                    @endfor
                                    <p class="ms-1 mb-0">&amp; trở lên</p>
              </div>
                            @endfor
              </div>

                        <!-- Category Filter -->
                        <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseCategory"
                            role="button" aria-expanded="true" aria-controls="collapseCategory">
              <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="fs-8 text-body-highlight">Danh mục</div>
                                <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
              </div>
            </a>
                        <div class="collapse show" id="collapseCategory">
              <div class="mb-2">
                                @foreach ($categories as $category)
                                    <div class="form-check mb-0">
                                        <input class="form-check-input mt-0" id="category_{{ $category->id }}"
                                            type="radio" name="category_id" value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'checked' : '' }}>
                                        <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0"
                                            for="category_{{ $category->id }}">{{ $category->name }}</label>
              </div>
                                @endforeach
              </div>
            </div>
          </div>
          <div class="phoenix-offcanvas-backdrop d-lg-none" data-phoenix-backdrop style="top: 92px"></div>
        </div>

        <div class="col-lg-9 col-xxl-10">

                    <!-- Products Grid -->
          <div class="row gx-3 gy-6 mb-8">
                        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-xxl-2">
              <div class="product-card-container h-100">
                <div class="position-relative text-decoration-none product-card h-100">
                  <div class="d-flex flex-column justify-content-between h-100">
                    <div>
                                                <div
                                                    class="border border-1 border-translucent rounded-3 position-relative mb-3">
                                                    @if ($product->images->count() > 0)
                                                        <img class="img-fluid"
                                                            src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                                            alt="{{ $product->name }}" />
                                                    @else
                                                        <img class="img-fluid"
                                                            src="{{ asset('v1/assets/img/products/1.png') }}"
                                                            alt="{{ $product->name }}" />
                                                    @endif

                                                    @if ($product->is_featured)
                                                        <span class="badge text-bg-success fs-10 product-verified-badge">
                                                            Nổi bật<span class="fas fa-check ms-1"></span>
                                                        </span>
                                                    @endif
                    </div>

                                                <a class="stretched-link"
                                                    href="{{ route('client.products.show', $product->slug) }}">
                                                    <h6 class="mb-2 lh-sm line-clamp-3 product-name">{{ $product->name }}
                                                    </h6>
                                                </a>

                                                <!-- Rating -->
                                                @if ($product->reviews->count() > 0)
                                                    @php
                                                        $avgRating = $product->reviews->avg('rating');
                                                        $ratingCount = $product->reviews->count();
                                                    @endphp
                                                    <p class="fs-9">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $avgRating)
                                                                <span class="fa fa-star text-warning"></span>
                                                            @else
                                                                <span class="fa-regular fa-star text-warning-light"
                                                                    data-bs-theme="light"></span>
                                                            @endif
                                                        @endfor
                                                        <span
                                                            class="text-body-quaternary fw-semibold ms-1">({{ $ratingCount }}
                                                            người đánh giá)</span>
                                                    </p>
                                                @else
                                                    <p class="fs-9 text-body-quaternary">Chưa có đánh giá</p>
                                                @endif
                    </div>

                    <div>
                                                @if ($product->stock_quantity > 0)
                                                    <p class="fs-9 text-success fw-bold mb-2">Còn hàng</p>
                                                @else
                                                    <p class="fs-9 text-danger fw-bold mb-2">Hết hàng</p>
                                                @endif

                      <div class="d-flex align-items-center mb-1">
                                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                                        <p class="me-2 text-body text-decoration-line-through mb-0">
                                                            {{ number_format($product->price) }} VNĐ</p>
                                                        <h3 class="text-body-emphasis mb-0">
                                                            {{ number_format($product->sale_price) }} VNĐ</h3>
                                                    @else
                                                        <h3 class="text-body-emphasis mb-0">
                                                            {{ number_format($product->price) }} VNĐ</h3>
                                                    @endif
                      </div>

                                                @if ($product->brand)
                                                    <p class="text-body-tertiary fw-semibold fs-9 lh-1 mb-0">
                                                        {{ $product->brand->name }}</p>
                                                @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
          <div class="d-flex justify-content-end">
            <nav aria-label="Page navigation example">
              <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $products->previousPageUrl() ?? '#' }}"
                                            aria-label="Previous">
                                            <span class="fas fa-chevron-left"></span>
                  </a>
                </li>

                                    {{-- Pagination Elements --}}
                                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                                        <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                </li>
                                    @endfor

                                    {{-- Next Page Link --}}
                                    <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $products->nextPageUrl() ?? '#' }}"
                                            aria-label="Next">
                                            <span class="fas fa-chevron-right"></span>
                                        </a>
                </li>
              </ul>
            </nav>
          </div>
                    @endif
        </div>
      </div>
    </div>
  </section>
@endsection
