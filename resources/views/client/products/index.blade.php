@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Sản phẩm </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="{{ route('client.home') }}"><span itemprop="title">Home</span></a><span
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
                        class="qodef-grid-item qodef-pag e-content-section qodef-col--9 qodef-col-push--3 qodef--list">
                        <header class="woocommerce-products-header">
                        </header>
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="qodef-woo-results">
                            <p class="woocommerce-result-count">
                                Showing 1–{{ $products->count() }} of {{ $products->total() }} results</p>
                            <form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="Shop order">
                                    <option value="menu_order" {{ request('orderby') == 'menu_order' ? 'selected' : '' }}>
                                        Default sorting</option>
                                    <option value="popularity" {{ request('orderby') == 'popularity' ? 'selected' : '' }}>
                                        Sort by popularity</option>
                                    <option value="rating" {{ request('orderby') == 'rating' ? 'selected' : '' }}>Sort by
                                        average rating</option>
                                    <option value="date" {{ request('orderby') == 'date' ? 'selected' : '' }}>Sort by
                                        latest</option>
                                    <option value="price" {{ request('orderby') == 'price' ? 'selected' : '' }}>Sort by
                                        price: low to high</option>
                                    <option value="price-desc" {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>
                                        Sort by price: high to low</option>
                                </select>
                                @foreach (request()->query() as $key => $value)
                                    @if ($key !== 'orderby')
                                        <input type="hidden" name="{{ $key }}"
                                            value="{{ is_array($value) ? implode(',', $value) : $value }}" />
                                    @endif
                                @endforeach
                            </form>
                        </div>
                        <div class="qodef-woo-product-list qodef-item-layout--info-below qodef-gutter--medium">
                            <ul class="products columns-3">
                                @foreach ($products as $product)
                                    <li
                                        class="product type-product post-{{ $product->id }} status-publish {{ $product->total_stock_quantity > 0 ? 'instock' : 'outofstock' }} {{ implode(' ', $product->categories->pluck('slug')->map(fn($slug) => 'product_cat-' . $slug)->toArray()) }} has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-image">
                                                @php
                                                    $featuredImage = $product->images
                                                        ->where('is_featured', true)
                                                        ->first();
                                                    $imagePath = $featuredImage
                                                        ? asset('storage/' . $featuredImage->image_path)
                                                        : asset('storage/sample/default.jpg');
                                                @endphp
                                                <img loading="lazy" width="600" height="431" src="{{ $imagePath }}"
                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                    alt="{{ $product->name }}" decoding="async" />
                                                @if ($product->total_stock_quantity == 0)
                                                    <span class="qodef-woo-product-mark qodef-out-of-stock">Hết hàng</span>
                                                @endif
                                                <div class="qodef-woo-product-hover">
                                                    <a href="{{ route('client.cart.add', $product->id) }}"
                                                        class="qodef-woo-product-icon qodef-add-to-cart"
                                                        data-bs-toggle="tooltip" title="Thêm vào giỏ hàng">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>
                                                    <a href="#" class="qodef-woo-product-icon qodef-add-to-wishlist"
                                                        data-bs-toggle="tooltip" title="Thêm vào yêu thích">
                                                        <i class="fas fa-heart"></i>
                                                    </a>
                                                    <a href="{{ route('client.products.show', $product->slug) }}"
                                                        class="qodef-woo-product-icon qodef-quick-view"
                                                        data-bs-toggle="tooltip" title="Xem nhanh">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__title">
                                                    <a href="{{ route('client.products.show', $product->slug) }}"
                                                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link">{{ $product->name }}</a>
                                                </h6>
                                                <div class="qodef-woo-product-categories qodef-e-info">
                                                    @foreach ($product->categories as $category)
                                                        <a href="{{ route('client.products.index', ['category_id' => $category->id]) }}"
                                                            rel="tag">{{ $category->name }}</a>
                                                        @if (!$loop->last)
                                                            <span class="qodef-info-separator-single"></span>
                                                        @endif
                                                    @endforeach
                                                    <div class="qodef-info-separator-end"></div>
                                                </div>
                                                <span class="price">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi><span
                                                                class="woocommerce-Price-currencySymbol">$</span>{{ number_format($product->minimum_price, 2) }}</bdi>
                                                    </span>
                                                </span>
                                            </div>
                                            <a href="{{ route('client.products.show', $product->slug) }}"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- <nav class="woocommerce-pagination">

                            </nav> -->
                    </div>
                    <div class="qodef-grid-item qodef-page-sidebar-section qodef-col--3 qodef-col-pull--9">
                        <aside id="qodef-page-sidebar" role="complementary">
                            <div class="widget woocommerce widget_product_categories" data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Danh mục sản phẩm</h5>
                                <ul class="product-categories">
                                    @foreach ($categories as $category)
                                        <li class="cat-item cat-item-{{ $category->id }}"><a
                                                href="{{ route('client.products.index', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_price_filter" data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo giá</h5>
                                <form method="get" action="{{ route('client.products.index') }}">
                                    <div class="price_slider_wrapper">
                                        <div class="price_slider" style="display:none;"></div>
                                        <div class="price_slider_amount" data-step="10">
                                            <label class="screen-reader-text" for="min_price">Min price</label>
                                            <input type="text" id="min_price" name="min_price"
                                                value="{{ request('min_price', 110) }}" data-min="110"
                                                placeholder="Min price" />
                                            <label class="screen-reader-text" for="max_price">Max price</label>
                                            <input type="text" id="max_price" name="max_price"
                                                value="{{ request('max_price', 520) }}" data-max="520"
                                                placeholder="Max price" />
                                            <button type="submit" class="button">Filter</button>
                                            <div class="price_label" style="display:none;">
                                                Price: <span class="from"></span> — <span class="to"></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    @foreach (request()->query() as $key => $value)
                                        @if ($key !== 'min_price' && $key !== 'max_price')
                                            <input type="hidden" name="{{ $key }}"
                                                value="{{ is_array($value) ? implode(',', $value) : $value }}" />
                                        @endif
                                    @endforeach
                                </form>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo màu sắc</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    @foreach ($colors as $color)
                                        <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term">
                                            <a rel="nofollow"
                                                href="{{ route('client.products.index', ['colors' => [$color->id]]) }}">{{ $color->name }}</a>
                                            <span
                                                class="count">({{ $products->getCollection()->flatMap->variations->where('color_id', $color->id)->count() }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo kích thước</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    @php
                                        $sizes = $products
                                            ->getCollection()
                                            ->flatMap->variations->pluck('size')
                                            ->unique();
                                    @endphp
                                    @foreach ($sizes as $size)
                                        <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term">
                                            <a rel="nofollow"
                                                href="{{ route('client.products.index', ['size' => $size->name ?? $size]) }}">{{ $size->name ?? $size }}</a>
                                            <span
                                                class="count">({{ $products->getCollection()->flatMap->variations->where('size_id', $size->id ?? null)->count() }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="widget widget_block" data-area="shop-sidebar">
                                <div data-block-name="woocommerce/product-search" data-label=""
                                    data-form-id="wc-block-product-search-0"
                                    class="wc-block-product-search wp-block-woocommerce-product-search">
                                    <form role="search" method="get" action="{{ route('client.products.index') }}">
                                        <label for="wc-block-search__input-1"
                                            class="wc-block-product-search__label"></label>
                                        <div class="wc-block-product-search__fields">
                                            <input type="search" id="wc-block-search__input-1"
                                                class="wc-block-product-search__field" placeholder="Search products…"
                                                name="s" value="{{ request('s') }}" />
                                            <button type="submit" class="wc-block-product-search__button"
                                                aria-label="Search">
                                                <svg aria-hidden="true" role="img" focusable="false"
                                                    class="dashicon dashicons-arrow-right-alt2"
                                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20">
                                                    <path d="M6 15l5-5-5-5 1-2 7 7-7 7z" />
                                                </svg>
                                            </button>
                                            <input type="hidden" name="post_type" value="product" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="widget widget_block widget_media_image" data-area="shop-sidebar">
                                <figure class="wp-block-image size-large"><a href="#"><img fetchpriority="high"
                                            fetchpriority="high" decoding="async" width="1024" height="690"
                                            src="{{ asset('storage/sample/shop-banner.jpg') }}" alt=""
                                            class="wp-image-7903" /></a></figure>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
        </div><!-- close #qodef-page-inner div from header.php -->
    </div><!-- close #qodef-page-outer div from header.php -->
@endsection
