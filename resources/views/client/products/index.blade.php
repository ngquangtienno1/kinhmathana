@extends('client.layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .product-filter-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .product-card-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            max-width: 100%;
        }
        .product-card-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .product-card {
            padding: 20px;
            min-height: 450px;
        }
        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .product-card h6 {
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .product-card .fs-9 {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 10px;
        }
        .product-card .text-body-emphasis {
            font-size: 1.3rem;
            font-weight: 600;
            color: #e74c3c;
            margin-bottom: 8px;
        }
        .product-card .text-decoration-line-through {
            font-size: 0.95rem;
            color: #999;
            margin-right: 10px;
        }
        .product-card .text-body-highlight {
            font-size: 0.85rem;
            color: #e74c3c;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .product-card .btn-wish {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: 10px;
            transition: background 0.3s;
        }
        .product-card .btn-wish:hover {
            background: rgba(255, 255, 255, 1);
        }
        @media (max-width: 768px) {
            .product-card {
                min-height: 400px;
                padding: 15px;
            }
            .product-card img {
                height: 200px;
            }
            .product-card h6 {
                font-size: 1rem;
            }
            .product-card .text-body-emphasis {
                font-size: 1.1rem;
            }
            .product-card .text-decoration-line-through {
                font-size: 0.85rem;
            }
        }
    </style>

    <section class="pt-5 pb-9">
        <div class="product-filter-container">
            <button class="btn btn-sm btn-phoenix-secondary text-body-tertiary mb-5 d-lg-none" data-phoenix-toggle="offcanvas" data-phoenix-target="#productFilterColumn">
                <span class="fa-solid fa-filter me-2"></span>Filter
            </button>
            <div class="row">
                <div class="col-lg-3 col-xxl-2 ps-2 ps-xl-3">
                    <div class="phoenix-offcanvas-filter bg-light scrollbar phoenix-offcanvas phoenix-offcanvas-fixed" id="productFilterColumn" style="top: 92px" data-breakpoint="lg">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Bộ lọc</h3>
                            <button class="btn d-lg-none p-0" data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-8"></span></button>
                        </div>
                        <form id="filterForm" method="GET" action="{{ route('client.products.index') }}">
                            <!-- Availability -->
                            <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseAvailability" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="fs-8 text-body-highlight">Sẵn có</div>
                                    <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
                                </div>
                            </a>
                            <div class="collapse show" id="collapseAvailability">
                                <div class="mb-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input mt-0" id="inStockInput" type="checkbox" name="availability[]" value="in_stock" {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0" for="inStockInput">Còn hàng</label>
                                    </div>
                                    <div class="form-check mb-0">
                                        <input class="form-check-input mt-0" id="outOfStockInput" type="checkbox" name="availability[]" value="out_of_stock" {{ in_array('out_of_stock', request('availability', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0" for="outOfStockInput">Hết hàng</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Color Family -->
                            <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseColorFamily" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="fs-8 text-body-highlight">Màu sắc</div>
                                    <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
                                </div>
                            </a>
                            <div class="collapse show" id="collapseColorFamily">
                                <div class="mb-2">
                                    @foreach ($colors as $color)
                                        <div class="form-check mb-0">
                                            <input class="form-check-input mt-0" id="color{{ $color->id }}" type="checkbox" name="colors[]" value="{{ $color->id }}" {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0" for="color{{ $color->id }}">{{ $color->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Brands -->
                            <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseBrands" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="fs-8 text-body-highlight">Thương hiệu</div>
                                    <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
                                </div>
                            </a>
                            <div class="collapse show" id="collapseBrands">
                                <div class="mb-2">
                                    @foreach ($brands as $brand)
                                        <div class="form-check mb-0">
                                            <input class="form-check-input mt-0" id="brand{{ $brand->id }}" type="checkbox" name="brands[]" value="{{ $brand->id }}" {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label d-block lh-sm fs-8 text-body fw-normal mb-0" for="brand{{ $brand->id }}">{{ $brand->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Range -->
                            <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapsePriceRange" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="fs-8 text-body-highlight">Khoảng giá</div>
                                    <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
                                </div>
                            </a>
                            <div class="collapse show" id="collapsePriceRange">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="input-group me-2">
                                        <input class="form-control" type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                                        <input class="form-control" type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
                                    </div>
                                    <button class="btn btn-phoenix-primary px-3" type="submit">Go</button>
                                </div>
                            </div>

                            <!-- Rating -->
                            <a class="btn px-0 d-block collapse-indicator" data-bs-toggle="collapse" href="#collapseRating" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="fs-8 text-body-highlight">Đánh giá</div>
                                    <span class="fa-solid fa-angle-down toggle-icon text-body-quaternary"></span>
                                </div>
                            </a>
                            <div class="collapse show" id="collapseRating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <div class="d-flex align-items-center mb-1">
                                        <input class="form-check-input me-3" id="rating{{ $i }}" type="radio" name="rating" value="{{ $i }}" {{ request('rating') == $i ? 'checked' : '' }}>
                                        @for ($j = 1; $j <= 5; $j++)
                                            <span class="fa {{ $j <= $i ? 'fa-star text-warning' : 'fa-regular fa-star text-warning-light' }} fs-9 me-1" data-bs-theme="light"></span>
                                        @endfor
                                        <p class="ms-1 mb-0">& above</p>
                                    </div>
                                @endfor
                            </div>

                            <!-- Reset Filters -->
                            <div class="mt-3">
                                <a href="{{ route('client.products.index') }}" class="btn btn-outline-secondary">Xóa bộ lọc</a>
                                <button type="submit" class="btn btn-primary">Áp dụng bộ lọc</button>
                            </div>
                        </form>
                    </div>
                    <div class="phoenix-offcanvas-backdrop d-lg-none" data-phoenix-backdrop style="top: 92px"></div>
                </div>
                <div class="col-lg-9 col-xxl-10">
                    <div class="row gx-3 gy-6 mb-8">
                        @foreach ($products as $product)
                            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                                <a href="{{ route('client.products.show', $product->slug) }}" class="text-decoration-none">
                                    <div class="product-card-container h-100">
                                        <div class="position-relative product-card h-100">
                                            <div class="d-flex flex-column justify-content-between h-100">
                                                <div>
                                                    <div class="border border-1 border-translucent rounded-3 position-relative mb-3">
                                                        <button class="btn btn-wish btn-wish-primary z-2 d-toggle-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Thêm vào danh sách yêu thích">
                                                            <span class="fas fa-heart d-block-hover" data-fa-transform="down-1"></span>
                                                            <span class="far fa-heart d-none-hover" data-fa-transform="down-1"></span>
                                                        </button>
                                                        @php
                                                            $featuredMedia = $product->getFeaturedMedia();
                                                            $imagePath = $featuredMedia ? Storage::url($featuredMedia->path) : '/path/to/default-image.jpg'; // Thay bằng đường dẫn ảnh mặc định thực tế
                                                        @endphp
                                                        <img class="img-fluid" src="{{ $imagePath }}" alt="{{ $product->name }}" />
                                                    </div>
                                                    <h6 class="mb-2 lh-sm line-clamp-3 product-name">{{ $product->name }}</h6>
                                                    <p class="fs-9">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span class="fa {{ $i <= floor($product->reviews->avg('rating') ?? 0) ? 'fa-star text-warning' : 'fa-regular fa-star text-warning-light' }} fs-9 me-1" data-bs-theme="light"></span>
                                                        @endfor
                                                        <span class="text-body-quaternary fw-semibold ms-1">({{ $product->reviews->count() }} đánh giá)</span>
                                                    </p>
                                                </div>
                                                <div>
                                                    @if ($product->total_stock_quantity <= 0)
                                                        <p class="fs-8 text-danger fw-bold mb-2">Hết hàng</p>
                                                    @elseif ($product->total_stock_quantity < 10)
                                                        <p class="fs-8 text-warning fw-bold mb-2">Số lượng có hạn</p>
                                                    @endif
                                                    <div class="d-flex align-items-center mb-1 flex-wrap">
                                                        @if ($product->minimum_price < $product->price && $product->minimum_price > 0)
                                                            <p class="me-2 text-body text-decoration-line-through mb-0">{{ number_format($product->price, 2) }}đ</p>
                                                            <h3 class="text-body-emphasis mb-0">{{ number_format($product->minimum_price, 2) }}đ</h3>
                                                        @else
                                                            <h3 class="text-body-emphasis mb-0">{{ number_format($product->minimum_price, 2) }}đ</h3>
                                                        @endif
                                                    </div>
                                                    <p class="text-body-tertiary fw-semibold fs-0 lh-sm mb-0">{{ $product->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        @if ($products->isEmpty())
                            <div class="col-12 text-center">
                                <p class="fs-8 text-body-tertiary">Không tìm thấy sản phẩm.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Phân trang -->
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Auto-submit form when checkboxes/radio inputs change
        document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm input[type="radio"]').forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
@endsection
