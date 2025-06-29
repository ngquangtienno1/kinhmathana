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
        .table-responsive {
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .table .product-name {
            font-weight: 500;
            color: #333;
        }
        .table .text-body-emphasis {
            color: #e74c3c;
            font-weight: 600;
        }
    </style>

    <section class="pt-5 pb-9">
        <div class="product-filter-container">
            <button class="btn btn-sm btn-phoenix-secondary text-body-tertiary mb-5 d-lg-none" data-phoenix-toggle="offcanvas" data-phoenix-target="#productFilterColumn">
                <span class="fa-solid fa-filter me-2"></span>Filter
            </button>
            <div class="row">
                <div class="col-lg-3 col-xxl-2 ps-2 ps-xl-3">
                    <!-- Bộ lọc giống index.blade.php -->
                    <div class="phoenix-offcanvas-filter bg-light scrollbar phoenix-offcanvas phoenix-offcanvas-fixed" id="productFilterColumn" style="top: 92px" data-breakpoint="lg">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Bộ lọc</h3>
                            <button class="btn d-lg-none p-0" data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-8"></span></button>
                        </div>
                        <form id="filterForm" method="GET" action="{{ route('client.products.list') }}">
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
                                <div class="d-flex align-items-center justify-content-between w-1">
                                    <div class="fs-8 text-body-highlight">Khoảng giá trị</div>
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
                                            <span class="fa {{ $j <= i ? 'fa-star fa-solid fa-star text-warning' : 'fa-regular fa-star text-warning-light' }} fs-9 me-9" data-bs-theme="light"></span>
                                        @endfor
                                        <p class="ms-1 mb-0">&amp; trên</p>
                                    </div>
                                @endfor
                            </div>

                            <!-- Reset Filters -->
                            <div class="mt-3">
                                <a href="{{ route('client.products.list') }}" class="btn btn-outline-secondary">Xóa bộ lọc</a>
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                        </form>
                    </div>
                    <div class="phoenix-offcanvas-backdrop d-lg-none" data-phoenix-backdrop style="top: 92px"></div>
                </div>
                <div class="col-lg-9 col-md">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Tồn kho</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ $product->getFeaturedImageMedia()->path }}" alt="{{ $product->name }}" />
                                        </td>
                                        <td class="product-name"><a href="{{ route('client.products.show', $product->slug) }}">{{ $product->name }}</a></td>
                                        <td class="text-body-emphasis">
                                            @if ($product->minimum_price < $product->price && $product->minimum_price > 0)
                                                <span class="text-body text-decoration-line-through">{{ number_format($product->price, 2) }}đ</span>
                                                {{ number_format($product->minimum_price, 2) }}đ
                                            @else
                                                {{ number_format($product->minimum_price, 2) }}đ
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->total_stock_quantity <= 0)
                                                <span class="text-danger">Hết hàng</span>
                                            @elseif ($product->total_stock_quantity < 10)
                                                <span class="text-warning">{{ $product->total_stock_quantity }}</span>
                                            @else
                                                {{ $product->total_stock_quantity }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Add to cart</a>
                                        </td>
                                    </tr>
                                </td>
@endforeach
                                @if ($products->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">Không tìm thấy sản phẩm.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
