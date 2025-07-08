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
                                            <div class="qodef-woo-product-image">
                                                @if ($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="qodef-woo-product-mark qodef-woo-onsale">Giảm
                                                        giá</span>
                                                @endif
                                                @if ($product->images->isNotEmpty())
                                                    <img loading="lazy" width="600" height="431"
                                                        src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail product-fixed-img"
                                                        alt="{{ $product->name }}" decoding="async" />
                                                @else
                                                    <img loading="lazy" width="600" height="431"
                                                        src="{{ asset('v1/wp-content/uploads/2021/07/Shop-Single-02-img-600x431.jpg') }}"
                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail product-fixed-img"
                                                        alt="{{ $product->name }}" decoding="async" />
                                                @endif
                                            </div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__title">
                                                    <a href="{{ route('client.products.show', $product->slug) }}"
                                                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                        {{ $product->name }}
                                                    </a>
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
                                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                                        <del aria-hidden="true">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format($product->price, 0, ',', '.') }}đ</bdi>
                                                            </span>
                                                        </del>
                                                        <span class="screen-reader-text">Giá gốc:
                                                            {{ number_format($product->price, 0, ',', '.') }}đ.</span>
                                                        <ins aria-hidden="true">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format($product->sale_price, 0, ',', '.') }}đ</bdi>
                                                            </span>
                                                        </ins>
                                                        <span class="screen-reader-text">Giá khuyến mãi:
                                                            {{ number_format($product->sale_price, 0, ',', '.') }}đ.</span>
                                                    @else
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>{{ number_format($product->price, 0, ',', '.') }}đ</bdi>
                                                        </span>
                                                    @endif
                                                </span>
                                                <div class="qodef-woo-product-image-inner">
                                                    <div
                                                        class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qwfw-shortcode qwfw-m qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                            href="#" data-item-id="{{ $product->id }}"
                                                            data-original-item-id="{{ $product->id }}"
                                                            aria-label="Add to wishlist" rel="noopener noreferrer">
                                                            <span class="qwfw-m-spinner qwfw-spinner-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span class="qwfw-m-icon qwfw--predefined">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                    height="32" viewBox="0 0 32 32" fill="currentColor">
                                                                    <g>
                                                                        <path
                                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div
                                                        class="qqvfw-quick-view-button-wrapper qqvfw-position--after-add-to-cart qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qqvfw-shortcode qqvfw-m qqvfw-quick-view-button qqvfw-type--icon-with-text"
                                                            data-item-id="{{ $product->id }}"
                                                            data-quick-view-type="pop-up"
                                                            data-quick-view-type-mobile="pop-up"
                                                            href="{{ route('client.products.show', $product->slug) }}"
                                                            rel="noopener noreferrer">
                                                            <span class="qqvfw-m-spinner">
                                                                <svg class="qqvfw-svg--spinner"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                                <span class="qodef-icon-linear-icons lnr-eye lnr"></span>
                                                            </span>
                                                            <span class="qqvfw-m-text"></span>
                                                        </a>
                                                    </div>
                                                    <form method="post"
                                                        action="{{ route('client.products.add-to-cart') }}"
                                                        style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="variation_id"
                                                            value="{{ $product->variations->first()->id ?? '' }}" />
                                                        <input type="hidden" name="quantity" value="1" />
                                                        <button type="submit"
                                                            class="button product_type_simple add_to_cart_button"
                                                            data-product_id="{{ $product->id }}"
                                                            data-product_sku="{{ $product->sku }}"
                                                            aria-label="Add to cart: &ldquo;{{ $product->name }}&rdquo;"
                                                            rel="nofollow"
                                                            @if (
                                                                !$product->variations->first() ||
                                                                    ($product->variations->first() && $product->variations->first()->stock_quantity <= 0)) disabled style="opacity:0.7;pointer-events:none;" @endif>
                                                            Add to cart
                                                        </button>
                                                    </form>
                                                    <span
                                                        id="woocommerce_loop_add_to_cart_link_describedby_{{ $product->id }}"
                                                        class="screen-reader-text"></span>
                                                </div>
                                            </div>
                                            <a href="{{ route('client.products.show', $product->slug) }}"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                        </div>
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
                                $currentPage = $products->currentPage();
                                $lastPage = $products->lastPage();
                                $pages = [];
                                // Luôn hiển thị trang 1, 2
                                for ($i = 1; $i <= min(2, $lastPage); $i++) {
                                    $pages[] = $i;
                                }
                                // Hiển thị 2 trang trước/sau trang hiện tại
                                for ($i = max(3, $currentPage - 2); $i <= min($lastPage - 2, $currentPage + 2); $i++) {
                                    $pages[] = $i;
                                }
                                // Luôn hiển thị trang cuối và áp chót
                                for ($i = max($lastPage - 1, 1); $i <= $lastPage; $i++) {
                                    $pages[] = $i;
                                }
                                $pages = array_unique($pages);
                                sort($pages);
                            @endphp
                            @php $prev = 0; @endphp
                            @foreach ($pages as $i)
                                @if ($prev && $i - $prev > 1)
                                    <span class="page-numbers dots">...</span>
                                @endif
                                @if ($i == $currentPage)
                                    <span aria-current="page"
                                        class="page-numbers current">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                                @else
                                    <a class="page-numbers"
                                        href="{{ $products->url($i) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
                                @endif
                                @php $prev = $i; @endphp
                            @endforeach
                            @if ($currentPage < $lastPage)
                                <a class="next page-numbers" href="{{ $products->nextPageUrl() }}">
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
                                <h5 class="qodef-widget-title">Lọc theo giới tính</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexcfb7.html?filter_gender=unisex&amp;query_type_gender=or">Unisex</a>
                                        <span class="count">(17)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexe312.html?filter_gender=male&amp;query_type_gender=or">Male</a>
                                        <span class="count">(10)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexee24.html?filter_gender=female&amp;query_type_gender=or">Female</a>
                                        <span class="count">(20)</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo màu sắc</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index5e9e.html?filter_color=bronze&amp;query_type_color=or">Bronze</a>
                                        <span class="count">(18)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index2eb4.html?filter_color=orange&amp;query_type_color=or">Orange</a>
                                        <span class="count">(18)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index9d90.html?filter_color=purple&amp;query_type_color=or">Purple</a>
                                        <span class="count">(9)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index4ded.html?filter_color=dark-green&amp;query_type_color=or">Dark
                                            Green</a> <span class="count">(2)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexdb6c.html?filter_color=blue&amp;query_type_color=or">Blue</a>
                                        <span class="count">(1)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexd323.html?filter_color=gold&amp;query_type_color=or">Gold</a>
                                        <span class="count">(18)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexc3cf.html?filter_color=silver&amp;query_type_color=or">Silver</a>
                                        <span class="count">(16)</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Lọc theo kích cỡ</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index0513.html?filter_size=m&amp;query_type_size=or">M</a> <span
                                            class="count">(23)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index8175.html?filter_size=s&amp;query_type_size=or">S</a> <span
                                            class="count">(15)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexb129.html?filter_size=xs&amp;query_type_size=or">XS</a> <span
                                            class="count">(9)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexe712.html?filter_size=xl&amp;query_type_size=or">XL</a> <span
                                            class="count">(16)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index8160.html?filter_size=l&amp;query_type_size=or">L</a> <span
                                            class="count">(22)</span></li>
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
