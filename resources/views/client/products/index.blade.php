@extends('client.layouts.app')

@section('content')
    <style>
        .product-fixed-img {
            width: 319.98px !important;
            height: 229.84px !important;
            object-fit: cover !important;
            background: #fff;
            display: block;
            margin: 0 auto;
        }
    </style>
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Sản phẩm </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="{{ route('client.home') }}"><span itemprop="title">Trang chủ</span></a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">Sản phẩm</span></div>
                </div>
            </div>
        </div>


        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content"
                class="qodef-grid qodef-layout--template qodef--no-bottom-space qodef-gutter--medium" role="main">
                <div class="qodef-grid-inner clear">
                    <div id="qodef-woo-page"
                        class="qodef-grid-item qodef-page-content-section qodef-col--9 qodef-col-push--3 qodef--list">
                        <header class="woocommerce-products-header">

                        </header>
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="qodef-woo-results">
                            <p class="woocommerce-result-count">
                                Hiển thị {{ $products->firstItem() ?? 0 }}&ndash;{{ $products->lastItem() ?? 0 }} trên
                                {{ $products->total() }} kết quả
                            </p>
                            <form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="Shop order"
                                    onchange="this.form.submit()">
                                    <option value="menu_order" {{ request('orderby') == 'menu_order' ? 'selected' : '' }}>
                                        Sắp xếp theo mặc định</option>
                                    <option value="popularity" {{ request('orderby') == 'popularity' ? 'selected' : '' }}>
                                        Sắp xếp theo phổ biến</option>
                                    <option value="rating" {{ request('orderby') == 'rating' ? 'selected' : '' }}>
                                        Sắp xếp theo đánh giá trung bình</option>
                                    <option value="date" {{ request('orderby') == 'date' ? 'selected' : '' }}>Sắp xếp theo
                                        mới nhất</option>
                                    <option value="price" {{ request('orderby') == 'price' ? 'selected' : '' }}>Sắp xếp
                                        theo
                                        giá: thấp đến cao</option>
                                    <option value="price-desc" {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>
                                        Sắp xếp theo giá: cao đến thấp</option>
                                </select>
                                @foreach (request()->except('orderby') as $key => $value)
                                    @if (is_array($value))
                                        @foreach ($value as $v)
                                            <input type="hidden" name="{{ $key }}[]"
                                                value="{{ $v }}" />
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                                    @endif
                                @endforeach
                            </form>
                        </div>
                        <div class="qodef-woo-product-list qodef-item-layout--info-below qodef-gutter--medium">
                            <ul class="products columns-3">
                                @forelse($products as $product)
                                    <li
                                        class="product type-product post-{{ $product->id }} status-publish {{ $product->stock_quantity > 0 ? 'instock' : 'outofstock' }} has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <a href="{{ route('client.products.show', $product->slug) }}"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                <div class="qodef-woo-product-image">
                                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                                        <span class="qodef-woo-product-mark qodef-woo-onsale">sale</span>
                                                    @endif
                                                    @php
                                                        // Ưu tiên ảnh từ biến thể nếu có
                                                        $featuredImage = null;
                                                        if ($product->variations && $product->variations->count() > 0) {
                                                            $firstVariation = $product->variations->first();
                                                            if (
                                                                $firstVariation->images &&
                                                                $firstVariation->images->count() > 0
                                                            ) {
                                                                $featuredImage =
                                                                    $firstVariation->images
                                                                        ->where('is_featured', true)
                                                                        ->first() ?? $firstVariation->images->first();
                                                            }
                                                        }

                                                        // Nếu không có ảnh biến thể, lấy ảnh sản phẩm chính
                                                        if (!$featuredImage && $product->images->isNotEmpty()) {
                                                            $featuredImage =
                                                                $product->images->where('is_featured', true)->first() ??
                                                                $product->images->first();
                                                        }

                                                        $imagePath = $featuredImage
                                                            ? asset('storage/' . $featuredImage->image_path)
                                                            : asset(
                                                                'v1/wp-content/uploads/2021/07/Shop-Single-02-img-600x431.jpg',
                                                            );
                                                    @endphp
                                                    <img loading="lazy" width="600" height="431"
                                                        src="{{ $imagePath }}"
                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail product-fixed-img"
                                                        alt="{{ $product->name }}" decoding="async" />
                                                </div>
                                                <div class="qodef-woo-product-content">
                                                    <h6 class="qodef-woo-product-title woocommerce-loop-product__title">
                                                        {{ $product->name }}
                                                    </h6>
                                                    <div class="qodef-woo-product-categories qodef-e-info">
                                                        @if ($product->categories->isNotEmpty())
                                                            @foreach ($product->categories as $index => $category)
                                                                <a href="{{ route('client.products.index', ['category_id' => $category->id]) }}"
                                                                    rel="tag">
                                                                    {{ $category->name }}
                                                                </a>
                                                                @if ($index < $product->categories->count() - 1)
                                                                    <span class="qodef-info-separator-single"></span>
                                                                @endif
                                                            @endforeach
                                                            <div class="qodef-info-separator-end"></div>
                                                        @endif
                                                    </div>
                                                    <span class="price">
                                                        @php
                                                            // Nếu sản phẩm có biến thể, lấy giá từ biến thể
                                                            if (
                                                                $product->variations &&
                                                                $product->variations->count() > 0
                                                            ) {
                                                                $minPrice = $product->variations->min('price');
                                                                $minSalePrice = $product->variations
                                                                    ->where('sale_price', '>', 0)
                                                                    ->min('sale_price');

                                                                // Nếu có giá khuyến mãi thấp hơn giá gốc
                                                                if ($minSalePrice && $minSalePrice < $minPrice) {
                                                                    $displayPrice = $minSalePrice;
                                                                    $originalPrice = $minPrice;
                                                                    $hasSale = true;
                                                                } else {
                                                                    $displayPrice = $minPrice;
                                                                    $originalPrice = $minPrice;
                                                                    $hasSale = false;
                                                                }
                                                            } else {
                                                                // Sản phẩm không có biến thể, dùng giá sản phẩm cha
                                                                $displayPrice =
                                                                    $product->sale_price &&
                                                                    $product->sale_price < $product->price
                                                                        ? $product->sale_price
                                                                        : $product->price;
                                                                $originalPrice = $product->price;
                                                                $hasSale =
                                                                    $product->sale_price &&
                                                                    $product->sale_price < $product->price;
                                                            }
                                                        @endphp

                                                        @if ($hasSale)
                                                            <del aria-hidden="true">
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <bdi>{{ number_format($originalPrice, 0, ',', '.') }}đ</bdi>
                                                                </span>
                                                            </del>
                                                            <span class="screen-reader-text">Giá gốc:
                                                                {{ number_format($originalPrice, 0, ',', '.') }}đ.</span>
                                                            <ins aria-hidden="true">
                                                                <span class="woocommerce-Price-amount amount"
                                                                    style="color: #dc3545; font-weight: bold;">
                                                                    <bdi>{{ number_format($displayPrice, 0, ',', '.') }}đ</bdi>
                                                                </span>
                                                            </ins>
                                                            <span class="screen-reader-text">Giá khuyến mãi:
                                                                {{ number_format($displayPrice, 0, ',', '.') }}đ.</span>
                                                        @else
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format($displayPrice, 0, ',', '.') }}đ</bdi>
                                                            </span>
                                                        @endif
                                                    </span>
                                            </a>
                                        </div>
                                        <a href="{{ route('client.products.show', $product->slug) }}"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </li>
                                @empty
                                    <li class="product">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title">Không có sản phẩm nào</h6>
                                            </div>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <nav class="woocommerce-pagination">
                            @php
                                // Lấy thông tin pagination
                                $currentPage = $products->currentPage();
                                $lastPage = $products->lastPage();

                                // Tạo danh sách trang hiển thị
                                $pages = collect();

                                // Luôn hiển thị trang 1, 2
                                $pages = $pages->merge(range(1, min(2, $lastPage)));

                                // Hiển thị 2 trang trước/sau trang hiện tại
                                $startPage = max(3, $currentPage - 2);
                                $endPage = min($lastPage - 2, $currentPage + 2);
                                if ($startPage <= $endPage) {
                                    $pages = $pages->merge(range($startPage, $endPage));
                                }

                                // Luôn hiển thị trang cuối và áp chót
                                $pages = $pages->merge(range(max($lastPage - 1, 1), $lastPage));

                                // Loại bỏ trùng lặp và sắp xếp
                                $pages = $pages->unique()->sort()->values();

                                // Giữ lại tất cả tham số query hiện tại
                                $queryParams = request()->query();
                            @endphp

                            @php $prev = 0; @endphp
                            @foreach ($pages as $pageNumber)
                                @if ($prev && $pageNumber - $prev > 1)
                                    <span class="page-numbers dots">...</span>
                                @endif

                                @if ($pageNumber == $currentPage)
                                    <span aria-current="page" class="page-numbers current">
                                        {{ str_pad($pageNumber, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                @else
                                    @php
                                        $queryParams['page'] = $pageNumber;
                                    @endphp
                                    <a class="page-numbers" href="{{ route('client.products.index', $queryParams) }}">
                                        {{ str_pad($pageNumber, 2, '0', STR_PAD_LEFT) }}
                                    </a>
                                @endif

                                @php $prev = $pageNumber; @endphp
                            @endforeach

                            @if ($currentPage < $lastPage)
                                @php
                                    $queryParams['page'] = $currentPage + 1;
                                @endphp
                                <a class="next page-numbers" href="{{ route('client.products.index', $queryParams) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6.344px" height="10.906px"
                                        viewBox="0 0 6.344 10.906">
                                        <g>
                                            <path
                                                d="M0.496,9.465l3.953-3.996L0.496,1.473c-0.344-0.315-0.352-0.63-0.021-0.945 c0.329-0.315,0.651-0.315,0.967,0L5.91,4.996c0.143,0.115,0.215,0.272,0.215,0.473c0,0.201-0.072,0.358-0.215,0.473L1.441,10.41 c-0.315,0.315-0.638,0.315-0.967,0C0.145,10.095,0.152,9.78,0.496,9.465z" />
                                        </g>
                                    </svg>
                                </a>
                            @endif
                        </nav>
                    </div>
                    <div class="qodef-grid-item qodef-page-sidebar-section qodef-col--3 qodef-col-pull--9">
                        <aside id="qodef-page-sidebar" role="complementary">
                            <div class="widget widget_block" data-area="shop-sidebar">
                                <div data-block-name="woocommerce/product-search" data-label=""
                                    data-form-id="wc-block-product-search-0"
                                    class="wc-block-product-search wp-block-woocommerce-product-search">
                                    <form role="search" method="get" action="{{ route('client.products.index') }}">
                                        <label for="wc-block-search__input-1"
                                            class="wc-block-product-search__label"></label>
                                        <div class="wc-block-product-search__fields">
                                            <input type="search" id="wc-block-search__input-1"
                                                class="wc-block-product-search__field" placeholder="Tìm kiếm sản phẩm..."
                                                name="s" value="{{ request('s') }}" />
                                            <button type="submit" class="wc-block-product-search__button"
                                                aria-label="Tìm kiếm">
                                                <svg aria-hidden="true" role="img" focusable="false"
                                                    class="dashicon dashicons-arrow-right-alt2"
                                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20">
                                                    <path d="M6 15l5-5-5-5 1-2 7 7-7 7z" />
                                                </svg>
                                            </button>
                                            <input type="hidden" name="post_type" value="product" />
                                            @foreach (request()->except(['s', 'post_type']) as $key => $value)
                                                @if (is_array($value))
                                                    @foreach ($value as $v)
                                                        <input type="hidden" name="{{ $key }}[]"
                                                            value="{{ $v }}" />
                                                    @endforeach
                                                @else
                                                    <input type="hidden" name="{{ $key }}"
                                                        value="{{ $value }}" />
                                                @endif
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="widget woocommerce widget_product_categories" data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Danh mục sản phẩm</h5>
                                <ul class="product-categories">
                                    @foreach ($categories as $category)
                                        <li class="cat-item cat-item-{{ $category->id }}">
                                            <a
                                                href="{{ route('client.products.index', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                                            <span class="count">({{ $category->products_count }})</span>
                                            @if ($category->children && $category->children->count())
                                                <ul class='children'>
                                                    @foreach ($category->children as $child)
                                                        <li class="cat-item cat-item-{{ $child->id }}">
                                                            <a
                                                                href="{{ route('client.products.index', ['category_id' => $child->id]) }}">{{ $child->name }}</a>
                                                            <span class="count">({{ $child->products_count }})</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_price_filter" data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo giá</h5>
                                <form method="get" action="{{ route('client.products.index') }}">
                                    <div class="price_slider_wrapper">
                                        <div class="price_slider" style="display:none;"></div>
                                        <div class="price_slider_amount" data-step="1000">
                                            <label class="screen-reader-text" for="min_price">Giá thấp nhất</label>
                                            <input type="text" id="min_price" name="min_price"
                                                value="{{ request('min_price') }}" placeholder="Từ..." />
                                            <label class="screen-reader-text" for="max_price">Giá cao nhất</label>
                                            <input type="text" id="max_price" name="max_price"
                                                value="{{ request('max_price') }}" placeholder="Đến..." />
                                            <button type="submit" class="button">Lọc</button>
                                            <div class="price_label" style="display:none;">
                                                Giá: <span class="from"></span> &mdash; <span class="to"></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        @foreach (request()->except(['min_price', 'max_price']) as $key => $value)
                                            @if (is_array($value))
                                                @foreach ($value as $v)
                                                    <input type="hidden" name="{{ $key }}[]"
                                                        value="{{ $v }}" />
                                                @endforeach
                                            @else
                                                <input type="hidden" name="{{ $key }}"
                                                    value="{{ $value }}" />
                                            @endif
                                        @endforeach
                                    </div>
                                </form>

                            </div>

                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo màu sắc</h5>
                                <form method="get" action="{{ route('client.products.index') }}"
                                    class="auto-submit-on-change">
                                    <ul class="woocommerce-widget-layered-nav-list">
                                        @foreach ($colors as $color)
                                            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ">
                                                <label style="cursor:pointer;">
                                                    <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                                        {{ in_array($color->id, (array) request('colors', [])) ? 'checked' : '' }}>
                                                    {{ $color->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @foreach (request()->except(['colors']) as $key => $value)
                                        @if (is_array($value))
                                            @foreach ($value as $v)
                                                <input type="hidden" name="{{ $key }}[]"
                                                    value="{{ $v }}" />
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}"
                                                value="{{ $value }}" />
                                        @endif
                                    @endforeach
                                    <!-- Bỏ nút lọc màu -->
                                </form>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo kích cỡ</h5>
                                <form method="get" action="{{ route('client.products.index') }}"
                                    class="auto-submit-on-change">
                                    <ul class="woocommerce-widget-layered-nav-list">
                                        @foreach ($sizes as $size)
                                            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ">
                                                <label style="cursor:pointer;">
                                                    <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                        {{ in_array($size->id, (array) request('sizes', [])) ? 'checked' : '' }}>
                                                    {{ $size->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @foreach (request()->except(['sizes']) as $key => $value)
                                        @if (is_array($value))
                                            @foreach ($value as $v)
                                                <input type="hidden" name="{{ $key }}[]"
                                                    value="{{ $v }}" />
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}"
                                                value="{{ $value }}" />
                                        @endif
                                    @endforeach
                                    <!-- Bỏ nút lọc cỡ -->
                                </form>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo độ cận</h5>
                                <form method="get" action="{{ route('client.products.index') }}"
                                    class="auto-submit-on-change">
                                    <ul class="woocommerce-widget-layered-nav-list">
                                        @foreach ($sphericals as $spherical)
                                            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ">
                                                <label style="cursor:pointer;">
                                                    <input type="checkbox" name="sphericals[]"
                                                        value="{{ $spherical->id }}"
                                                        {{ in_array($spherical->id, (array) request('sphericals', [])) ? 'checked' : '' }}>
                                                    {{ $spherical->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @foreach (request()->except(['sphericals']) as $key => $value)
                                        @if (is_array($value))
                                            @foreach ($value as $v)
                                                <input type="hidden" name="{{ $key }}[]"
                                                    value="{{ $v }}" />
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}"
                                                value="{{ $value }}" />
                                        @endif
                                    @endforeach
                                </form>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo độ loạn</h5>
                                <form method="get" action="{{ route('client.products.index') }}"
                                    class="auto-submit-on-change">
                                    <ul class="woocommerce-widget-layered-nav-list">
                                        @foreach ($cylindricals as $cylindrical)
                                            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ">
                                                <label style="cursor:pointer;">
                                                    <input type="checkbox" name="cylindricals[]"
                                                        value="{{ $cylindrical->id }}"
                                                        {{ in_array($cylindrical->id, (array) request('cylindricals', [])) ? 'checked' : '' }}>
                                                    {{ $cylindrical->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @foreach (request()->except(['cylindricals']) as $key => $value)
                                        @if (is_array($value))
                                            @foreach ($value as $v)
                                                <input type="hidden" name="{{ $key }}[]"
                                                    value="{{ $v }}" />
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}"
                                                value="{{ $value }}" />
                                        @endif
                                    @endforeach
                                </form>
                            </div>

                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo thương hiệu</h5>
                                <form method="get" action="{{ route('client.products.index') }}"
                                    class="auto-submit-on-change">
                                    <ul class="woocommerce-widget-layered-nav-list">
                                        @foreach ($brands as $brand)
                                            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ">
                                                <label style="cursor:pointer;">
                                                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                                        {{ in_array($brand->id, (array) request('brands', [])) ? 'checked' : '' }}>
                                                    {{ $brand->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @foreach (request()->except(['brands']) as $key => $value)
                                        @if (is_array($value))
                                            @foreach ($value as $v)
                                                <input type="hidden" name="{{ $key }}[]"
                                                    value="{{ $v }}" />
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}"
                                                value="{{ $value }}" />
                                        @endif
                                    @endforeach
                                </form>
                            </div>
                            <div class="widget widget_block widget_media_image" data-area="shop-sidebar">
                                <figure class="wp-block-image size-large"><a href="../vouchers/index.html"><img
                                            fetchpriority="high" fetchpriority="high" decoding="async" width="1024"
                                            height="690" src="../wp-content/uploads/2021/08/shop-banner-1024x690.jpg"
                                            alt="" class="wp-image-7903"
                                            srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-1024x690.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-600x404.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-800x539.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-300x202.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-768x517.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner.jpg 1100w"
                                            sizes="(max-width: 1024px) 100vw, 1024px" /></a></figure>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.auto-submit-on-change input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
