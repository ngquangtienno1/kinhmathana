@extends('client.layouts.app')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger"
            style="background: #ffeaea; border: 1.5px solid #e74c3c; color: #c0392b; font-weight: bold; display: flex; align-items: center; gap: 8px; font-size: 16px; padding: 12px 18px; border-radius: 6px; margin-bottom: 18px;">
            <span style="font-size: 22px;">&#9888;</span>
            <span>{{ session('error') }}</span>
            <button type="button" class="close" onclick="this.parentElement.style.display='none'"
                style="background: none; border: none; font-size: 20px; margin-left: 10px; cursor: pointer;">&times;</button>
        </div>
    @endif
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">Chi tiết sản phẩm</h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                        <a itemprop="url" class="qodef-breadcrumbs-link" href="{{ route('client.home') }}"><span
                                itemprop="title">Trang chủ</span></a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Chi tiết sản phẩm</span>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">{{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="qodef-page-inner" class="qodef-content-grid">
        <main id="qodef-page-content" class="qodef-grid qodef-layout--template qodef--no-bottom-space qodef-gutter--medium"
            role="main">
            <div id="add-to-cart-message"></div>
            <div class="qodef-grid-inner clear">
                <div id="qodef-woo-page"
                    class="qodef-grid-item qodef--single qodef-popup--magnific-popup qodef-magnific-popup qodef-popup-gallery">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div id="product-{{ $product->id }}"
                        class="product type-product post-{{ $product->id }} status-publish first instock {{ implode(' ', $product->categories->pluck('slug')->map(fn($slug) => 'product_cat-' . $slug)->toArray()) }} has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes">

                        <div class="qodef-woo-single-inner">
                            <div class="qodef-woo-single-image">
                                @if ($featuredImage)
                                    <img src="{{ asset('storage/' . $featuredImage->image_path) }}"
                                        alt="{{ $product->name }}" class="main-product-image"
                                        style="width:867.19px;height:623.28px;object-fit:cover;" id="main-product-image" />
                                @else
                                    <img src="{{ asset('') }}" alt="No image" class="main-product-image"
                                        style="width:867.19px;height:623.28px;object-fit:cover;" />
                                @endif
                                @php
                                    if ($product->variations->count() > 0) {
                                        // Có biến thể: lấy toàn bộ ảnh của các biến thể (không lặp lại)
                                        $allImages = $product->variations
                                            ->flatMap(function ($variation) {
                                                return $variation->images;
                                            })
                                            ->unique('image_path');
                                    } else {
                                        // Không có biến thể: lấy toàn bộ ảnh của sản phẩm cha (trừ ảnh đại diện nếu muốn)
                                        $allImages = $product->images->where('is_featured', false);
                                    }
                                @endphp
                                @if ($allImages->count() > 0)
                                    <div class="product-thumbnails"
                                        style="margin-top:24px;width:867.19px;overflow:hidden;position:relative;">
                                        <div class="thumbnail-slider"
                                            style="display:flex;width:max-content;transition:transform 0.3s ease;">
                                            @foreach ($allImages as $img)
                                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                                    alt="{{ $product->name }} thumbnail"
                                                    style="width:180px;height:130px;object-fit:cover;border:1px solid #eee;margin-right:16px;" />
                                            @endforeach
                                        </div>
                                        <button class="slider-prev"
                                            style="position:absolute;left:0;top:50%;transform:translateY(-50%);background:#fff;border:none;padding:10px;cursor:pointer;">
                                            < </button>
                                                <button class="slider-next"
                                                    style="position:absolute;right:0;top:50%;transform:translateY(-50%);background:#fff;border:none;padding:10px;cursor:pointer;">
                                                    >
                                                </button>
                                    </div>
                                @endif
                            </div>
                            <div class="summary entry-summary">
                                <h1 class="qodef-woo-product-title product_title entry-title">{{ $product->name }}</h1>
                                <div class="qodef-woo-product-short-description"
                                    style="margin-bottom: 16px; color: #555; font-size: 1.1em;">
                                    {{ $product->description_short ?? ($product->description ?? $product->description_long) }}
                                </div>
                                <p class="price">
                                    <span class="woocommerce-Price-amount amount">
                                        <bdi><span
                                                class="woocommerce-Price-currencySymbol"></span>{{ number_format($product->minimum_price, 0, ',', '.') }}
                                            <span style="font-size:0.9em;">VNĐ</span></bdi>
                                    </span>
                                </p>
                                @if (isset($selectedVariation) && $selectedVariation->stock_quantity === 0)
                                    <div style="margin-top: 15px; font-size: 1.05em; color: #222;">
                                        <strong id="variant-stock-quantity">Hết hàng</strong>
                                    </div>
                                @else
                                    <div style="margin-top: 15px; font-size: 1.05em; color: #222;">
                                        Số lượng: <strong
                                            id="variant-stock-quantity">{{ $selectedVariation->stock_quantity ?? $product->total_stock_quantity }}</strong>
                                    </div>
                                @endif
                                <div class="woocommerce-product-details__short-description">
                                    <p>{{ $product->short_description ?? Str::limit($product->description, 120) }}</p>
                                </div>
                                @if ($product->total_stock_quantity <= 0)
                                    <div style="color: red; font-weight: bold; margin-bottom: 12px;">Sản phẩm đã hết hàng
                                    </div>
                                @endif
                                @if ($product->variations->count() > 0)
                                    <div id="qvsfw-variations-form-wrapper">
                                        <form class="variations_form cart js-add-to-cart-form" method="post"
                                            action="{{ route('client.products.add-to-cart') }}"
                                            enctype="multipart/form-data" data-product-name="{{ $product->name }}">
                                            @csrf
                                            @if ($product->total_stock_quantity <= 0)
                                                <fieldset disabled style="opacity:0.7;pointer-events:none;">
                                            @endif
                                            @if ($colors->count())
                                                <div class="variation-group">
                                                    <div class="variation-label">Màu sắc:</div>
                                                    <div class="variation-options" data-type="color">
                                                        @foreach ($colors as $color)
                                                            <button type="button" class="variation-btn color-btn"
                                                                data-value="{{ $color->id }}">
                                                                {{ $color->name }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="color_id" class="variation-input"
                                                        value="">
                                                </div>
                                            @endif
                                            @if ($sizes->count())
                                                <div class="variation-group">
                                                    <div class="variation-label">Kích thước:</div>
                                                    <div class="variation-options" data-type="size">
                                                        @foreach ($sizes as $size)
                                                            <button type="button" class="variation-btn size-btn"
                                                                data-value="{{ $size->id }}">
                                                                {{ $size->name }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="size_id" class="variation-input"
                                                        value="">
                                                </div>
                                            @endif
                                            @if ($sphericals->count())
                                                <div class="variation-group">
                                                    <div class="variation-label">Độ cận:</div>
                                                    <div class="variation-options" data-type="spherical">
                                                        @foreach ($sphericals as $spherical)
                                                            <button type="button" class="variation-btn spherical-btn"
                                                                data-value="{{ $spherical->id }}">
                                                                {{ $spherical->name }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="spherical_id" class="variation-input"
                                                        value="">
                                                </div>
                                            @endif
                                            @if ($cylindricals->count())
                                                <div class="variation-group">
                                                    <div class="variation-label">Độ loạn:</div>
                                                    <div class="variation-options" data-type="cylindrical">
                                                        @foreach ($cylindricals as $cylindrical)
                                                            <button type="button" class="variation-btn cylindrical-btn"
                                                                data-value="{{ $cylindrical->id }}">
                                                                {{ $cylindrical->name }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="cylindrical_id" class="variation-input"
                                                        value="">
                                                </div>
                                            @endif
                                            <div class="single_variation_wrap">
                                                <div class="woocommerce-variation single_variation"></div>
                                                <div class="woocommerce-variation-add-to-cart variations_button">
                                                    <div class="qodef-quantity-buttons quantity">
                                                        <label class="screen-reader-text"
                                                            for="quantity_{{ $product->id }}">{{ $product->name }}
                                                            quantity</label>
                                                        <span class="qodef-quantity-minus"></span>
                                                        <input type="text" id="quantity_{{ $product->id }}"
                                                            class="input-text qty text qodef-quantity-input"
                                                            data-step="1" data-min="1" data-max="" name="quantity"
                                                            value="1" title="Qty" size="4" placeholder=""
                                                            inputmode="numeric" />
                                                        <span class="qodef-quantity-plus"></span>
                                                    </div>
                                                    <button type="submit" class="single_add_to_cart_button button alt"
                                                        @if ($product->total_stock_quantity <= 0) disabled style="opacity:0.7;pointer-events:none;" @endif>Thêm
                                                        giỏ hàng</button>
                                                    <input type="hidden" name="variation_id" class="variation_id"
                                                        value="{{ $selectedVariation->id ?? '' }}" />
                                                </div>
                                            </div>
                                            @if ($product->total_stock_quantity <= 0)
                                                </fieldset>
                                            @endif
                                        </form>
                                    </div>
                                @else
                                    <form class="cart js-add-to-cart-form" method="post"
                                        action="{{ route('client.products.add-to-cart') }}"
                                        data-product-name="{{ $product->name }}">
                                        @csrf
                                        <div class="woocommerce-variation-add-to-cart variations_button">
                                            <div class="qodef-quantity-buttons quantity">
                                                <label class="screen-reader-text" for="quantity_{{ $product->id }}">Số
                                                    lượng</label>
                                                <span class="qodef-quantity-minus"></span>
                                                <input type="text" id="quantity_{{ $product->id }}"
                                                    class="input-text qty text qodef-quantity-input" data-step="1"
                                                    data-min="1" data-max="{{ $product->total_stock_quantity ?? '' }}"
                                                    name="quantity" value="1" title="Qty" size="4"
                                                    placeholder="" inputmode="numeric"
                                                    @if ($product->total_stock_quantity <= 0) disabled style="opacity:0.7;pointer-events:none;" @endif />
                                                <span class="qodef-quantity-plus"></span>
                                            </div>
                                            <button type="submit" class="single_add_to_cart_button button alt"
                                                @if ($product->total_stock_quantity <= 0) disabled style="opacity:0.7;pointer-events:none;" @endif>Thêm
                                                giỏ hàng</button>
                                            @if ($product->product_type === 'simple')
                                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                            @else
                                                <input type="hidden" name="variation_id"
                                                    value="{{ $product->variations->first()->id ?? '' }}" />
                                            @endif
                                        </div>
                                    </form>
                                @endif
                                <div
                                    class="qwfw-add-to-wishlist-wrapper qwfw--single qwfw-position--after-add-to-cart qwfw-item-type--icon-with-text qodef-neoocular-theme">
                                    @php
                                        $inWishlist = false;
                                        if (Auth::check()) {
                                            $inWishlist = \App\Models\Wishlist::where('user_id', Auth::id())
                                                ->where('product_id', $product->id)
                                                ->exists();
                                        }
                                    @endphp
                                    @if (Auth::check())
                                        @if ($inWishlist)
                                            <button type="button"
                                                class="qwfw-shortcode qwfw-m qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon-with-text"
                                                style="background:none;border:none;padding:0;cursor:pointer;" disabled>
                                                <span class="qwfw-m-spinner qwfw-spinner-icon">
                                                    <!-- Trái tim đen fill -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                        viewBox="0 0 24 24" fill="black">
                                                        <path
                                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                    </svg>
                                                </span>
                                                <span class="qwfw-m-icon qwfw--predefined">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        viewBox="0 0 32 32" fill="black">
                                                        <path
                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z" />
                                                    </svg>
                                                </span>
                                                <span class="qwfw-m-text">Đã thêm vào yêu thích</span>
                                            </button>
                                        @else
                                            <form method="POST" action="{{ route('client.wishlist.add') }}"
                                                class="add-to-wishlist-form" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit"
                                                    class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon-with-text"
                                                    style="background:none;border:none;padding:0;cursor:pointer;">
                                                    <span class="qwfw-m-spinner qwfw-spinner-icon">
                                                        <!-- Trái tim viền -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                            height="22" viewBox="0 0 24 24" fill="none"
                                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path
                                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                        </svg>
                                                    </span>
                                                    <span class="qwfw-m-icon qwfw--predefined">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                            height="32" viewBox="0 0 32 32" fill="none"
                                                            stroke="black" stroke-width="2">
                                                            <g>
                                                                <path
                                                                    d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span class="qwfw-m-text">Thêm vào yêu thích</span>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('client.login') }}"
                                            class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon-with-text">
                                            <span class="qwfw-m-spinner qwfw-spinner-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                </svg>
                                            </span>
                                            <span class="qwfw-m-icon qwfw--predefined">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32" fill="none" stroke="black" stroke-width="2">
                                                    <g>
                                                        <path
                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="qwfw-m-text">Thêm vào yêu thích</span>
                                        </a>
                                    @endif
                                </div>
                                <div class="product_meta">
                                    @if ($product->sku && $product->sku !== '0158')
                                        <span class="sku_wrapper">
                                            <span class="qodef-woo-meta-label">Mã sản phẩm:</span>
                                            <span class="sku qodef-woo-meta-value">{{ $product->sku }}</span>
                                        </span>
                                    @endif
                                    <span class="posted_in">
                                        <span class="qodef-woo-meta-label">Danh mục:</span>
                                        <span class="qodef-woo-meta-value">
                                            @if ($product->categories && $product->categories->count())
                                                @foreach ($product->categories as $category)
                                                    <a href="{{ route('client.products.index', ['category_id' => $category->id]) }}"
                                                        rel="tag">{{ $category->name }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            @else
                                                Không có
                                            @endif
                                        </span>
                                    </span>
                                    @if ($product->brand)
                                        <span class="tagged_as"><span class="qodef-woo-meta-label">Thương hiệu:</span>
                                            <span class="qodef-woo-meta-value">
                                                <a href="{{ route('client.products.index', ['brand_id' => $product->brand->id]) }}"
                                                    rel="tag">{{ $product->brand->name }}</a>
                                            </span>
                                        </span>
                                    @endif
                                </div>
                                <div class="qodef-shortcode qodef-m  qodef-social-share clear qodef-layout--list ">
                                    <span class="qodef-social-title qodef-custom-label">Chia sẻ sản phẩm:</span>
                                    <ul class="qodef-shortcode-list">
                                        <li class="qodef-facebook-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="window.open('https://www.facebook.com/sharer.php?u=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fproduct%2Faviator-paris%2F', 'sharer', 'toolbar=0,status=0,width=620,height=280');">
                                                <span
                                                    class="qodef-icon-elegant-icons social_facebook qodef-social-network-icon"></span>
                                            </a></li>
                                        <li class="qodef-twitter-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="window.open('https://twitter.com/intent/tweet?text=Sed+viverra+tellus+in+hac.+Sagittis+vitae+et+leo+duis+ut+diam+quam.+Aliquet+eget+sit+amet++via+%40QodeInteractivehttps://neoocular.qodeinteractive.com/product/aviator-paris/', 'popupwindow', 'scrollbars=yes,width=800,height=400');">
                                                <span
                                                    class="qodef-icon-elegant-icons social_twitter qodef-social-network-icon"></span>
                                            </a></li>
                                        <li class="qodef-pinterest-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="popUp=window.open('https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fproduct%2Faviator-paris%2F&description=Aviator+Paris&media=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fwp-content%2Fuploads%2F2021%2F07%2Foptican-home-product-2.jpg', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                                                <span
                                                    class="qodef-icon-elegant-icons social_pinterest qodef-social-network-icon"></span>
                                            </a></li>
                                        <li class="qodef-tumblr-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="popUp=window.open('https://www.tumblr.com/share/link?url=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fproduct%2Faviator-paris%2F&name=Aviator+Paris&description=Sed+viverra+tellus+in+hac.+Sagittis+vitae+et+leo+duis+ut+diam+quam.+Aliquet+eget+sit+amet+tellus+cras+adipiscing+enim+eu+turpis.+Orci+ac+auctor+augue+mauris+augue.', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                                                <span
                                                    class="qodef-icon-elegant-icons social_tumblr qodef-social-network-icon"></span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="woocommerce-tabs wc-tabs-wrapper">
                        <ul class="tabs wc-tabs" role="tablist">
                            <li class="description_tab" id="tab-title-description" role="tab"
                                aria-controls="tab-description">
                                <a href="#tab-description">Mô tả</a>
                            </li>
                            <li class="additional_information_tab" id="tab-title-additional_information" role="tab"
                                aria-controls="tab-additional_information">
                                <a href="#tab-additional_information">Thông tin thêm</a>
                            </li>
                            <li class="reviews_tab" id="tab-title-reviews" role="tab" aria-controls="tab-reviews">
                                <a href="#tab-reviews">Đánh giá ({{ $product->reviews->count() }})</a>
                            </li>
                            <li class="comments_tab" id="tab-title-comments" role="tab"
                                aria-controls="tab-comments">
                                <a href="#tab-comments">Bình luận ({{ $comments->count() }})</a>
                            </li>
                        </ul>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab"
                            id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                            <h2>Mô tả</h2>
                            <p>{{ $product->description ?: 'Aliquet nec ullamcorper sit amet. Viverra tellus in hac habitasse. Eros in cursus turpis massa tincidunt dui ut ornare. Amet consectetur adipiscing elit ut aliquam. Sit amet nulla facilisi morbi tempus iaculis urna id volutpat. Sed cras ornare arcu dui vivamus arcu felis bibendum. Nunc sed velit dignissim sodales ut eu sem integer. Dictumst quisque sagittis purus sit amet. Suspendisse in est ante in nibh mauris cursus mattis. Quis varius quam quisque id diam vel. A lacus vestibulum sed arcu non. Laoreet non curabitur gravida arcu ac tortor dignissim convallis. Et netus et malesuada fames ac turpis egestas maecenas.' }}
                            </p>
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content wc-tab"
                            id="tab-additional_information" role="tabpanel"
                            aria-labelledby="tab-title-additional_information">

                            <h2>Thông tin thêm</h2>

                            <table class="woocommerce-product-attributes shop_attributes">
                                <tr
                                    class="woocommerce-product-attributes-item woocommerce-product-attributes-item--weight">
                                    <th class="woocommerce-product-attributes-item__label">Weight</th>
                                    <td class="woocommerce-product-attributes-item__value">0.5 kg</td>
                                </tr>
                                <tr
                                    class="woocommerce-product-attributes-item woocommerce-product-attributes-item--dimensions">
                                    <th class="woocommerce-product-attributes-item__label">Dimensions</th>
                                    <td class="woocommerce-product-attributes-item__value">1 &times; 2
                                        &times; 3 cm</td>
                                </tr>
                            </table>
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content wc-tab"
                            id="tab-additional_information" role="tabpanel"
                            aria-labelledby="tab-title-additional_information">
                            <h2>Thông tin thêm</h2>
                            <table class="woocommerce-product-attributes shop_attributes">
                                @if ($product->variations->isNotEmpty())
                                    @foreach ($product->variations->groupBy('attribute_name')->map->unique() as $attribute => $variations)
                                        <tr
                                            class="woocommerce-product-attributes-item woocommerce-product-attributes-item--{{ strtolower(str_replace(' ', '-', $attribute)) }}">
                                            <th class="woocommerce-product-attributes-item__label">{{ $attribute }}
                                            </th>
                                            <td class="woocommerce-product-attributes-item__value">
                                                <p>{{ $variations->pluck('attribute_value')->unique()->implode(', ') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab"
                            id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews" style="display:none;">
                            <h2>Đánh giá</h2>
                            @if ($product->reviews->count() > 0)
                                <div class="dmx-review-section">
                                    <div class="dmx-review-summary">
                                        <div class="dmx-review-score">
                                            <span
                                                class="score">{{ number_format($product->reviews->avg('rating'), 1) }}</span>
                                            <span class="score-max">/5</span>
                                            <div class="score-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="star{{ $i <= round($product->reviews->avg('rating')) ? ' filled' : '' }}">★</span>
                                                @endfor
                                            </div>
                                            <div class="score-count">{{ $product->reviews->count() }} đánh giá</div>
                                        </div>
                                        <div class="dmx-review-breakdown">
                                            @for ($i = 5; $i >= 1; $i--)
                                                @php
                                                    $count = $product->reviews->where('rating', $i)->count();
                                                    $percent = $product->reviews->count()
                                                        ? round(($count / $product->reviews->count()) * 100)
                                                        : 0;
                                                @endphp
                                                <div class="breakdown-row">
                                                    <span class="star-label">{{ $i }} <span
                                                            class="star">★</span></span>
                                                    <div class="progress-bar">
                                                        <div class="progress" style="width: {{ $percent }}%"></div>
                                                    </div>
                                                    <span class="percent">{{ $percent }}%</span>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="dmx-review-filter-bar" style="display:flex;gap:10px;margin-bottom:18px;">
                                        <button class="review-filter-btn active" data-star="all">Tất Cả</button>
                                        @for ($i = 5; $i >= 1; $i--)
                                            <button class="review-filter-btn" data-star="{{ $i }}">
                                                {{ $i }} Sao
                                                ({{ $product->reviews->where('rating', $i)->count() }})
                                            </button>
                                        @endfor
                                    </div>
                                    <div class="dmx-review-list">
                                        @php $totalReviews = $product->reviews->count(); @endphp
                                        @foreach ($product->reviews->sortByDesc('created_at')->take(2) as $review)
                                            <div class="dmx-review-item">
                                                <div class="review-header">
                                                    <span class="reviewer">{{ $review->user->name ?? 'Ẩn danh' }}</span>
                                                    <span
                                                        class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                                </div>
                                                @php
                                                    $orderItem = null;
                                                    if ($review->order_id && $review->product_id) {
                                                        $orderItem = \App\Models\OrderItem::where(
                                                            'order_id',
                                                            $review->order_id,
                                                        )
                                                            ->where('product_id', $review->product_id)
                                                            ->first();
                                                    }
                                                    $optionTexts = [];
                                                    if ($orderItem && $orderItem->product_options) {
                                                        $options = is_array($orderItem->product_options)
                                                            ? $orderItem->product_options
                                                            : json_decode($orderItem->product_options, true);
                                                        if (!empty($options['color'])) {
                                                            $optionTexts[] =
                                                                'Màu sắc: <b>' . e($options['color']) . '</b>';
                                                        }
                                                        if (!empty($options['size'])) {
                                                            $optionTexts[] =
                                                                'Kích thước: <b>' . e($options['size']) . '</b>';
                                                        }
                                                        if (!empty($options['spherical'])) {
                                                            $optionTexts[] =
                                                                'Độ cận: <b>' . e($options['spherical']) . '</b>';
                                                        }
                                                        if (!empty($options['cylindrical'])) {
                                                            $optionTexts[] =
                                                                'Độ loạn: <b>' . e($options['cylindrical']) . '</b>';
                                                        }
                                                    }
                                                @endphp
                                                @if (!empty($optionTexts))
                                                    <div class="review-variant mb-1" style="font-size:13px;color:#444;">
                                                        <span>Phân loại hàng: {!! implode(' | ', $optionTexts) !!}</span>
                                                    </div>
                                                @endif
                                                <div class="review-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="star{{ $i <= $review->rating ? ' filled' : '' }}">★</span>
                                                    @endfor
                                                </div>
                                                <div class="review-content">{{ $review->content }}</div>
                                                @if ($review->images && $review->images->count())
                                                    <div class="review-media mt-2 d-flex flex-wrap gap-2">
                                                        @foreach ($review->images as $media)
                                                            @if ($media->image_path)
                                                                <a href="{{ asset('storage/' . $media->image_path) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset('storage/' . $media->image_path) }}"
                                                                        alt="Ảnh đánh giá"
                                                                        style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:1.5px solid #eee;">
                                                                </a>
                                                            @endif
                                                            @if ($media->video_path)
                                                                <video src="{{ asset('storage/' . $media->video_path) }}"
                                                                    controls
                                                                    style="width:120px;height:70px;border-radius:6px;border:1.5px solid #eee;background:#000;"></video>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if ($review->reply)
                                                    <div class="review-reply">
                                                        <span class="reply-label">Phản hồi từ cửa hàng:</span>
                                                        <div class="reply-content">{!! nl2br(e($review->reply)) !!}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if ($totalReviews > 2)
                                            @foreach ($product->reviews->sortByDesc('created_at')->slice(2) as $review)
                                                <div class="dmx-review-item dmx-review-hidden" style="display:none;">
                                                    <div class="review-header">
                                                        <span
                                                            class="reviewer">{{ $review->user->name ?? 'Ẩn danh' }}</span>
                                                        <span
                                                            class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                    @php
                                                        $orderItem = null;
                                                        if ($review->order_id && $review->product_id) {
                                                            $orderItem = \App\Models\OrderItem::where(
                                                                'order_id',
                                                                $review->order_id,
                                                            )
                                                                ->where('product_id', $review->product_id)
                                                                ->first();
                                                        }
                                                        $optionTexts = [];
                                                        if ($orderItem && $orderItem->product_options) {
                                                            $options = is_array($orderItem->product_options)
                                                                ? $orderItem->product_options
                                                                : json_decode($orderItem->product_options, true);
                                                            if (!empty($options['color'])) {
                                                                $optionTexts[] =
                                                                    'Màu sắc: <b>' . e($options['color']) . '</b>';
                                                            }
                                                            if (!empty($options['size'])) {
                                                                $optionTexts[] =
                                                                    'Kích thước: <b>' . e($options['size']) . '</b>';
                                                            }
                                                            if (!empty($options['spherical'])) {
                                                                $optionTexts[] =
                                                                    'Độ cận: <b>' . e($options['spherical']) . '</b>';
                                                            }
                                                            if (!empty($options['cylindrical'])) {
                                                                $optionTexts[] =
                                                                    'Độ loạn: <b>' .
                                                                    e($options['cylindrical']) .
                                                                    '</b>';
                                                            }
                                                        }
                                                    @endphp
                                                    @if (!empty($optionTexts))
                                                        <div class="review-variant mb-1"
                                                            style="font-size:13px;color:#444;">
                                                            <span>Phân loại hàng: {!! implode(' | ', $optionTexts) !!}</span>
                                                        </div>
                                                    @endif
                                                    <div class="review-stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="star{{ $i <= $review->rating ? ' filled' : '' }}">★</span>
                                                        @endfor
                                                    </div>
                                                    <div class="review-content">{{ $review->content }}</div>
                                                    @if ($review->images && $review->images->count())
                                                        <div class="review-media mt-2 d-flex flex-wrap gap-2">
                                                            @foreach ($review->images as $media)
                                                                @if ($media->image_path)
                                                                    <a href="{{ asset('storage/' . $media->image_path) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/' . $media->image_path) }}"
                                                                            alt="Ảnh đánh giá"
                                                                            style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:1.5px solid #eee;">
                                                                    </a>
                                                                @endif
                                                                @if ($media->video_path)
                                                                    <video
                                                                        src="{{ asset('storage/' . $media->video_path) }}"
                                                                        controls
                                                                        style="width:120px;height:70px;border-radius:6px;border:1.5px solid #eee;background:#000;"></video>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if ($review->reply)
                                                        <div class="review-reply">
                                                            <span class="reply-label">Phản hồi từ cửa hàng:</span>
                                                            <div class="reply-content">{!! nl2br(e($review->reply)) !!}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="dmx-review-actions">
                                        <button class="btn btn-outline-dark" id="show-more-reviews"
                                            style="display:{{ $totalReviews > 2 ? '' : 'none' }};">Xem thêm đánh
                                            giá</button>
                                        <button class="btn btn-outline-dark" id="collapse-reviews"
                                            style="display:none;">Rút gọn</button>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var productId = '{{ $product->id }}';
                                            var viewed = [];
                                            var cookie = document.cookie.split('; ').find(row => row.startsWith('recently_viewed_products='));
                                            if (cookie) {
                                                try {
                                                    viewed = JSON.parse(decodeURIComponent(cookie.split('=')[1]));
                                                } catch (e) {
                                                    viewed = [];
                                                }
                                            }
                                            viewed = viewed.filter(id => id != productId);
                                            viewed.unshift(productId);
                                            viewed = viewed.slice(0, 8);
                                            document.cookie = 'recently_viewed_products=' + encodeURIComponent(JSON.stringify(viewed)) +
                                                ';path=/;max-age=2592000';
                                        });
                                    </script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var filterBtns = document.querySelectorAll('.review-filter-btn');
                                            var btnShow = document.getElementById('show-more-reviews');
                                            var btnCollapse = document.getElementById('collapse-reviews');

                                            function updateShowMoreBtn() {
                                                var activeBtn = document.querySelector('.review-filter-btn.active');
                                                var star = activeBtn ? activeBtn.getAttribute('data-star') : 'all';
                                                var reviews = Array.from(document.querySelectorAll('.dmx-review-item'));
                                                var filtered = reviews.filter(function(item) {
                                                    if (star === 'all') return true;
                                                    var count = 0;
                                                    item.querySelectorAll('.review-stars .star.filled').forEach(function() {
                                                        count++;
                                                    });
                                                    return parseInt(star) === count;
                                                });
                                                if (filtered.length > 2) {
                                                    var allVisible = filtered.every(function(item) {
                                                        return item.style.display !== 'none';
                                                    });
                                                    if (allVisible) {
                                                        if (btnShow) btnShow.style.display = 'none';
                                                        if (btnCollapse) btnCollapse.style.display = '';
                                                    } else {
                                                        if (btnShow) btnShow.style.display = '';
                                                        if (btnCollapse) btnCollapse.style.display = 'none';
                                                    }
                                                } else {
                                                    if (btnShow) btnShow.style.display = 'none';
                                                    if (btnCollapse) btnCollapse.style.display = 'none';
                                                }
                                            }
                                            filterBtns.forEach(function(btn) {
                                                btn.addEventListener('click', function() {
                                                    filterBtns.forEach(b => b.classList.remove('active'));
                                                    btn.classList.add('active');
                                                    var star = btn.getAttribute('data-star');
                                                    var reviews = Array.from(document.querySelectorAll('.dmx-review-item'));
                                                    var filtered = reviews.filter(function(item) {
                                                        if (star === 'all') return true;
                                                        var count = 0;
                                                        item.querySelectorAll('.review-stars .star.filled').forEach(
                                                            function() {
                                                                count++;
                                                            });
                                                        return parseInt(star) === count;
                                                    });
                                                    filtered.forEach(function(item, idx) {
                                                        item.style.display = idx < 2 ? '' : 'none';
                                                    });
                                                    updateShowMoreBtn();
                                                });
                                            });
                                            updateShowMoreBtn();
                                        });
                                    </script>
                                </div>
                            @else
                                <p class="text-muted">Chưa có đánh giá nào.</p>
                            @endif
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--comments panel entry-content wc-tab"
                            id="tab-comments" role="tabpanel" aria-labelledby="tab-title-comments"
                            style="display:none;">
                            <h2>Bình luận</h2>
                            @foreach ($comments as $comment)
                                <div class="comment-item" style="padding: 8px 0; border-bottom: 1px solid #eee;">
                                    <div style="display: flex; align-items: baseline; gap: 8px;">
                                        <span
                                            style="font-weight: bold;">{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</span>
                                        <span
                                            style="font-size: 13px; color: #888;">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div style="margin-top: 2px; font-size: 15px; color: #222;">
                                        {{ $comment->content }}
                                    </div>
                                    @if ($comment->replies && $comment->replies->count())
                                        <div class="comment-replies" style="margin-left:32px; margin-top:8px;">
                                            @foreach ($comment->replies as $reply)
                                                <div class="reply-item"
                                                    style="background:#f8f9fa; border-radius:6px; padding:8px 12px; margin-bottom:6px;">
                                                    <div style="display: flex; align-items: baseline; gap: 8px;">
                                                        <span
                                                            style="font-weight: bold; color:#007bff;">{{ $reply->user->name ?? 'Admin' }}</span>
                                                        <span
                                                            style="font-size: 13px; color: #888;">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                    <div style="margin-top: 2px; font-size: 15px; color: #333;">
                                                        {{ $reply->content }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @if (Auth::check())
                                @if (Auth::user()->banned_until && now()->lt(Auth::user()->banned_until))
                                    <div class="alert alert-warning" style="margin-top: 18px;">
                                        Bạn đã bị cấm bình luận đến
                                        {{ Auth::user()->banned_until->format('d/m/Y H:i') }}<br>
                                        (Còn
                                        {{ now()->diffForHumans(Auth::user()->banned_until, ['parts' => 2, 'short' => true]) }})
                                    </div>
                                @else
                                    <form action="{{ route('client.products.comment', $product->id) }}" method="POST"
                                        style="margin-top: 18px;">
                                        @csrf
                                        <div class="form-group">
                                            <label for="comment-content">Nội dung bình luận</label>
                                            <textarea name="content" id="comment-content" class="form-control" rows="3" required
                                                style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="margin-top:8px;">Gửi bình
                                            luận</button>
                                    </form>
                                @endif
                            @else
                                <p style="margin-top: 18px;">Bạn cần <a href="{{ route('client.login') }}">đăng nhập</a>
                                    để bình luận.</p>
                            @endif
                        </div>
                    </div>

                    <section class="related products">
                        <h2>Sản phẩm liên quan</h2>
                        <div class="qodef-woo-product-list qodef-item-layout--info-below qodef-gutter--medium">
                            <ul class="products columns-4">
                                @foreach ($related_products as $related_product)
                                    <li
                                        class="product type-product post-{{ $related_product->id }} status-publish {{ $related_product->total_stock_quantity > 0 ? 'instock' : 'outofstock' }} {{ implode(' ', $related_product->categories->pluck('slug')->map(fn($slug) => 'product_cat-' . $slug)->toArray()) }} has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-image" style="position:relative;">
                                                @php
                                                    $relatedFeaturedImage =
                                                        $related_product->images->where('is_featured', true)->first() ??
                                                        $related_product->images->first();
                                                    $relatedImagePath = $relatedFeaturedImage
                                                        ? asset('storage/' . $relatedFeaturedImage->image_path)
                                                        : asset('');
                                                @endphp
                                                @if ($related_product->sale_price && $related_product->sale_price < $related_product->price)
                                                    <span class="qodef-woo-product-mark qodef-woo-onsale"
                                                        style="position:absolute;top:10px;left:10px;z-index:2;">sale</span>
                                                @endif
                                                <img width="600" height="431" src="{{ $relatedImagePath }}"
                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                    alt="{{ $related_product->name }}" decoding="async" />
                                            </div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__link"><a
                                                        href="{{ route('client.products.show', $related_product->slug) }}">{{ $related_product->name }}</a>
                                                </h6>
                                                <div class="qodef-woo-product-categories qodef-e-info">
                                                    @foreach ($related_product->categories as $category)
                                                        <a href="{{ route('client.products.index', ['category_id' => $category->id]) }}"
                                                            rel="tag">{{ $category->name }}</a>
                                                        @if (!$loop->last)
                                                            <span class="qodef-info-separator-single"></span>
                                                        @endif
                                                    @endforeach
                                                    <div class="qodef-info-separator-end"></div>
                                                </div>
                                                <span class="price">
                                                    @if ($related_product->sale_price && $related_product->sale_price < $related_product->price)
                                                        <del aria-hidden="true">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format($related_product->price, 0, ',', '.') }}đ</bdi>
                                                            </span>
                                                        </del>
                                                        <span class="screen-reader-text">Giá gốc:
                                                            {{ number_format($related_product->price, 0, ',', '.') }}đ.</span>
                                                        <ins aria-hidden="true">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format($related_product->sale_price, 0, ',', '.') }}đ</bdi>
                                                            </span>
                                                        </ins>
                                                        <span class="screen-reader-text">Giá khuyến mãi:
                                                            {{ number_format($related_product->sale_price, 0, ',', '.') }}đ.</span>
                                                    @else
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>{{ number_format($related_product->price ?? $related_product->minimum_price, 0, ',', '.') }}đ</bdi>
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="#" data-item-id="{{ $related_product->id }}"
                                                        data-original-item-id="{{ $related_product->id }}"
                                                        aria-label="Thêm vào danh sách yêu thích"
                                                        data-shortcode-atts="{'button_behavior':'view','button_type':'icon','show_count':'','require_login':false}"
                                                        rel="noopener noreferrer">
                                                        <span class="qwfw-m-spinner qwfw-spinner-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
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
                                                        data-item-id="{{ $related_product->id }}"
                                                        data-quick-view-type="pop-up" data-quick-view-type-mobile="pop-up"
                                                        href="#"
                                                        data-shortcode-atts="{'button_type':'icon-with-text'}"
                                                        rel="noopener noreferrer">
                                                        <span class="qqvfw-m-spinner"><svg class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span>
                                                        <span class="qqvfw-m-icon qqvfw-icon--predefined"><span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span>
                                                        <span class="qqvfw-m-text"></span>
                                                    </a>
                                                </div>
                                                <a href="{{ route('client.products.show', $related_product->slug) }}"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="{{ $related_product->id }}"
                                                    data-product_sku="{{ $related_product->sku }}"
                                                    aria-label="Thêm vào giỏ hàng: "{{ $related_product->name }}"""
                                                    rel="nofollow">Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                        <a href="{{ route('client.products.show', $related_product->slug) }}"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                    @php
                        $recentlyViewed = [];
                        if (isset($_COOKIE['recently_viewed_products'])) {
                            $ids = json_decode($_COOKIE['recently_viewed_products'], true);
                            if (is_array($ids)) {
                                // Loại bỏ sản phẩm hiện tại
                                $ids = array_filter($ids, function ($id) use ($product) {
                                    return $id != $product->id;
                                });
                                if (count($ids)) {
                                    $recentlyViewed = \App\Models\Product::with(['images', 'categories', 'brand'])
                                        ->whereIn('id', $ids)
                                        ->get()
                                        ->sortBy(function ($item) use ($ids) {
                                            return array_search($item->id, $ids);
                                        });
                                }
                            }
                        }
                    @endphp
                    @if (!empty($recentlyViewed) && count($recentlyViewed))
                        <section class="recently-viewed products">
                            <h2 style="margin-top:32px; text-align:center;">Sản phẩm đã xem gần đây</h2>
                            <div class="qodef-woo-product-list qodef-item-layout--info-below qodef-gutter--medium">
                                <ul class="products columns-4">
                                    @foreach ($recentlyViewed as $rvProduct)
                                        <li
                                            class="product type-product post-{{ $rvProduct->id }} status-publish {{ $rvProduct->total_stock_quantity > 0 ? 'instock' : 'outofstock' }} {{ implode(' ', $rvProduct->categories->pluck('slug')->map(fn($slug) => 'product_cat-' . $slug)->toArray()) }} has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                            <div class="qodef-e-inner">
                                                <div class="qodef-woo-product-image" style="position:relative;">
                                                    @php
                                                        $rvFeaturedImage =
                                                            $rvProduct->images->where('is_featured', true)->first() ??
                                                            $rvProduct->images->first();
                                                        $rvImagePath = $rvFeaturedImage
                                                            ? asset('storage/' . $rvFeaturedImage->image_path)
                                                            : asset('');
                                                    @endphp
                                                    @if ($rvProduct->sale_price && $rvProduct->sale_price < $rvProduct->price)
                                                        <span class="qodef-woo-product-mark qodef-woo-onsale"
                                                            style="position:absolute;top:10px;left:10px;z-index:2;">sale</span>
                                                    @endif
                                                    <img width="600" height="431" src="{{ $rvImagePath }}"
                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                        alt="{{ $rvProduct->name }}" decoding="async" />
                                                </div>
                                                <div class="qodef-woo-product-content">
                                                    <h6 class="qodef-woo-product-title woocommerce-loop-product__link"><a
                                                            href="{{ route('client.products.show', $rvProduct->slug) }}">{{ $rvProduct->name }}</a>
                                                    </h6>
                                                    <div class="qodef-woo-product-categories qodef-e-info">
                                                        @foreach ($rvProduct->categories as $category)
                                                            <a href="{{ route('client.products.index', ['category_id' => $category->id]) }}"
                                                                rel="tag">{{ $category->name }}</a>
                                                            @if (!$loop->last)
                                                                <span class="qodef-info-separator-single"></span>
                                                            @endif
                                                        @endforeach
                                                        <div class="qodef-info-separator-end"></div>
                                                    </div>
                                                    <span class="price">
                                                        @if ($rvProduct->sale_price && $rvProduct->sale_price < $rvProduct->price)
                                                            <del aria-hidden="true">
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <bdi>{{ number_format($rvProduct->price, 0, ',', '.') }}đ</bdi>
                                                                </span>
                                                            </del>
                                                            <span class="screen-reader-text">Giá gốc:
                                                                {{ number_format($rvProduct->price, 0, ',', '.') }}đ.</span>
                                                            <ins aria-hidden="true">
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <bdi>{{ number_format($rvProduct->sale_price, 0, ',', '.') }}đ</bdi>
                                                                </span>
                                                            </ins>
                                                            <span class="screen-reader-text">Giá khuyến mãi:
                                                                {{ number_format($rvProduct->sale_price, 0, ',', '.') }}đ.</span>
                                                        @else
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi>{{ number_format($rvProduct->price ?? $rvProduct->minimum_price, 0, ',', '.') }}đ</bdi>
                                                            </span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="qodef-woo-product-image-inner">
                                                    <div
                                                        class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qwfw-shortcode qwfw-m qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                            href="#" data-item-id="{{ $rvProduct->id }}"
                                                            data-original-item-id="{{ $rvProduct->id }}"
                                                            aria-label="Thêm vào danh sách yêu thích"
                                                            data-shortcode-atts="{'button_behavior':'view','button_type':'icon','show_count':'','require_login':false}"
                                                            rel="noopener noreferrer">
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
                                                                    height="32" viewBox="0 0 32 32"
                                                                    fill="currentColor">
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
                                                            data-item-id="{{ $rvProduct->id }}"
                                                            data-quick-view-type="pop-up"
                                                            data-quick-view-type-mobile="pop-up" href="#"
                                                            data-shortcode-atts="{'button_type':'icon-with-text'}"
                                                            rel="noopener noreferrer">
                                                            <span class="qqvfw-m-spinner"><svg class="qqvfw-svg--spinner"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span>
                                                            <span class="qqvfw-m-icon qqvfw-icon--predefined"><span
                                                                    class="qodef-icon-linear-icons lnr-eye lnr"></span></span>
                                                            <span class="qqvfw-m-text"></span>
                                                        </a>
                                                    </div>
                                                    <a href="{{ route('client.products.show', $rvProduct->slug) }}"
                                                        class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                        data-product_id="{{ $rvProduct->id }}"
                                                        data-product_sku="{{ $rvProduct->sku }}"
                                                        aria-label="Thêm vào giỏ hàng: "{{ $rvProduct->name }}""
                                                        rel="nofollow">Thêm vào giỏ hàng</a>
                                                </div>
                                            </div>
                                            <a href="{{ route('client.products.show', $rvProduct->slug) }}"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                            </div>
                            </li>
                    @endforeach
                    </ul>
                </div>
                </section>
                @endif
            </div>
    </div>
    </main>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add to cart functionality
                document.querySelectorAll('.js-add-to-cart-form').forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        var formData = new FormData(form);
                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': form.querySelector('[name=_token]').value
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                var msgContainer = document.getElementById('add-to-cart-message');
                                if (msgContainer) {
                                    msgContainer.innerHTML = '';
                                }
                                if (data.success) {
                                    var msg = document.createElement('div');
                                    msg.className = 'woocommerce-message';
                                    msg.setAttribute('role', 'alert');
                                    var productName = form.getAttribute('data-product-name');
                                    msg.innerHTML =
                                        `<a href="/client/cart" tabindex="1" class="button wc-forward">Xem giỏ hàng</a> &ldquo;${productName}&rdquo; đã được thêm vào giỏ hàng.`;
                                    if (msgContainer) {
                                        msgContainer.appendChild(msg);
                                    }
                                } else {
                                    var msg = document.createElement('div');
                                    msg.className = 'alert alert-danger';
                                    msg.style =
                                        'background: #ffeaea; border: 1.5px solid #e74c3c; color: #c0392b; font-weight: bold; display: flex; align-items: center; gap: 8px; font-size: 16px; padding: 12px 18px; border-radius: 6px; margin-bottom: 18px;';
                                    msg.innerHTML =
                                        '<span style="font-size: 22px;">&#9888;</span><span>' + (
                                            data.message || 'Có lỗi xảy ra!') + '</span>' +
                                        '<button type="button" class="close" onclick="this.parentElement.style.display=\'none\'" style="background: none; border: none; font-size: 20px; margin-left: 10px; cursor: pointer;">&times;</button>';
                                    if (msgContainer) {
                                        msgContainer.appendChild(msg);
                                    }
                                }
                            })
                            .catch(() => alert('Có lỗi xảy ra!'));
                    });
                });

                // Quantity buttons
                document.querySelectorAll('.qodef-quantity-buttons').forEach(function(group) {
                    const minus = group.querySelector('.qodef-quantity-minus');
                    const plus = group.querySelector('.qodef-quantity-plus');
                    const input = group.querySelector('input.qodef-quantity-input');
                    let min = input.getAttribute('data-min');
                    let max = input.getAttribute('data-max');
                    min = min ? parseInt(min) : 1;
                    max = max ? parseInt(max) : null;
                    if (minus) {
                        minus.addEventListener('click', function() {
                            let val = parseInt(input.value) || min;
                            if (val > min) {
                                input.value = val - 1;
                            }
                        });
                    }
                    if (plus) {
                        plus.addEventListener('click', function() {
                            let val = parseInt(input.value) || min;
                            if (!max || val < max) {
                                input.value = val + 1;
                            }
                        });
                    }
                    input.addEventListener('change', function() {
                        let val = parseInt(input.value) || min;
                        if (val < min) val = min;
                        if (max && val > max) val = max;
                        input.value = val;
                    });
                });

                // Color selection functionality
                document.querySelectorAll('.color-option').forEach(function(option) {
                    option.addEventListener('click', function() {
                        // Remove active class from all options in the same group
                        const colorOptions = this.closest('.color-options').querySelectorAll(
                            '.color-option');
                        colorOptions.forEach(opt => opt.classList.remove('active'));

                        // Add active class to clicked option
                        this.classList.add('active');

                        // Update main product image if image URL is available
                        const imageUrl = this.getAttribute('data-image-url');
                        if (imageUrl && imageUrl !== '') {
                            const mainImage = document.getElementById('main-product-image');
                            if (mainImage) {
                                mainImage.src = imageUrl;
                            }
                        }
                    });
                });

                // Xử lý chọn biến thể dạng button group
                document.querySelectorAll('.variation-options').forEach(function(group) {
                    group.addEventListener('click', function(e) {
                        if (e.target.classList.contains('variation-btn')) {
                            // Bỏ active các nút khác
                            group.querySelectorAll('.variation-btn').forEach(btn => btn.classList
                                .remove('active'));
                            // Active nút vừa chọn
                            e.target.classList.add('active');
                            // Gán value vào input hidden
                            const input = group.parentElement.querySelector('.variation-input');
                            input.value = e.target.getAttribute('data-value');

                            // Sau khi chọn, kiểm tra nếu đã chọn đủ các biến thể thì đổi ảnh
                            showVariationImageIfSelected();
                        }
                    });
                });

                // Hàm kiểm tra và hiển thị ảnh biến thể nếu đã chọn đủ
                function showVariationImageIfSelected() {
                    // Debug log
                    console.log('variationsJson:', window.variationsJson);
                    const colorId = document.querySelector('input[name="color_id"]')?.value || '';
                    const sizeId = document.querySelector('input[name="size_id"]')?.value || '';
                    const sphericalId = document.querySelector('input[name="spherical_id"]')?.value || '';
                    const cylindricalId = document.querySelector('input[name="cylindrical_id"]')?.value || '';
                    console.log('Selected:', {
                        colorId,
                        sizeId,
                        sphericalId,
                        cylindricalId
                    });
                    // Lấy variations từ biến blade
                    const variations = window.variationsJson || [];
                    // Tìm variation phù hợp
                    let found = variations.find(v =>
                        (!colorId || v.color_id === colorId) &&
                        (!sizeId || v.size_id === sizeId) &&
                        (!sphericalId || v.spherical_id === sphericalId) &&
                        (!cylindricalId || v.cylindrical_id === cylindricalId)
                    );
                    // Nếu đã chọn đủ (tức là các thuộc tính nào có thì phải chọn)
                    let enough = true;
                    if (variations.length > 0) {
                        if (variations[0].color_id && !colorId) enough = false;
                        if (variations[0].size_id && !sizeId) enough = false;
                        if (variations[0].spherical_id && !sphericalId) enough = false;
                        if (variations[0].cylindrical_id && !cylindricalId) enough = false;
                    }
                    // Cập nhật input[name=variation_id] nếu tìm thấy
                    var variationInput = document.querySelector('input[name="variation_id"]');
                    if (variationInput) {
                        if (found && enough) {
                            variationInput.value = found.id;
                        } else {
                            variationInput.value = '';
                        }
                    }
                    // Đổi ảnh nếu có
                    if (found && enough && found.image) {
                        const mainImage = document.getElementById('main-product-image');
                        if (mainImage) {
                            mainImage.src = found.image;
                        }
                    }
                    // Disable nút nếu không có variation phù hợp
                    var addBtn = document.querySelector('.single_add_to_cart_button');
                    if (addBtn) {
                        if (enough && (!found || !variationInput.value)) {
                            addBtn.disabled = true;
                            addBtn.style.opacity = 0.7;
                            addBtn.style.pointerEvents = 'none';
                        } else {
                            addBtn.disabled = false;
                            addBtn.style.opacity = '';
                            addBtn.style.pointerEvents = '';
                        }
                    }
                    // Cập nhật số lượng tồn kho
                    var stockElem = document.getElementById('variant-stock-quantity');
                    if (found && enough && stockElem) {
                        if (found.stock_quantity === 0 || found.stock_quantity === '0') {
                            stockElem.textContent = 'Hết hàng';
                            if (addBtn) {
                                addBtn.disabled = true;
                                addBtn.style.opacity = 0.7;
                                addBtn.style.pointerEvents = 'none';
                            }
                        } else {
                            stockElem.textContent = found.stock_quantity;
                        }
                    } else if (stockElem) {
                        stockElem.textContent = window.defaultTotalStockQuantity ?? '';
                    }
                }

                // Gán biến variationsJson từ blade
                window.variationsJson = @json($variationsJson ?? []);
                window.defaultTotalStockQuantity = {{ $product->total_stock_quantity }};
            });
        </script>
    @endpush
    <style>
        /* Product Variations Styling */
        .product-variations {
            margin: 30px 0;
            padding: 25px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .variation-group {
            margin-bottom: 25px;
        }

        .variation-group:last-child {
            margin-bottom: 0;
        }

        .variation-label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Color Options */
        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .color-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            padding: 8px;
            border: 2px solid transparent;
            border-radius: 6px;
            transition: all 0.2s ease;
            min-width: 60px;
        }

        .color-option:hover {
            border-color: #ddd;
            background: #f8f8f8;
        }

        .color-option.active {
            border-color: #000;
            background: #f0f0f0;
        }

        .color-swatch {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 6px;
            transition: transform 0.2s ease;
        }

        .color-option:hover .color-swatch {
            transform: scale(1.1);
        }

        .color-option.active .color-swatch {
            transform: scale(1.15);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .color-swatch.transparent {
            background: repeating-linear-gradient(45deg, #eee 0 8px, #fff 8px 16px);
            border: 2px solid #ccc;
        }

        .color-name {
            font-size: 11px;
            color: #666;
            text-align: center;
            line-height: 1.2;
            max-width: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Select Dropdowns */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '▼';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 10px;
            pointer-events: none;
        }

        .variation-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #fff;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .variation-select:hover {
            border-color: #999;
        }

        .variation-select:focus {
            outline: none;
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
        }

        .variation-select option {
            padding: 8px;
            background: #fff;
            color: #333;
        }

        /* Reset Button */
        .variation-actions {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .reset-variations {
            background: none;
            border: 1px solid #ddd;
            color: #666;
            padding: 8px 16px;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .reset-variations:hover {
            background: #f5f5f5;
            border-color: #999;
            color: #333;
        }

        /* Existing styles */
        .woocommerce-message .wc-forward {
            border: 1.5px solid #222;
            background: #fff;
            color: #222;
            border-radius: 0;
            padding: 18px 40px;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: background 0.2s, color 0.2s;
            margin-left: 0;
            margin-right: 32px;
            box-shadow: none;
            outline: none;
            display: inline-block;
        }

        .woocommerce-message .wc-forward:hover {
            background: #222;
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-variations {
                padding: 20px;
                margin: 20px 0;
            }

            .color-options {
                gap: 8px;
            }

            .color-option {
                min-width: 50px;
                padding: 6px;
            }

            .color-swatch {
                width: 28px;
                height: 28px;
            }

            .color-name {
                font-size: 10px;
                max-width: 50px;
            }

            .variation-select {
                padding: 10px 14px;
                font-size: 13px;
            }
        }

        /* Bỏ khung ngoài, chỉ còn từng nhóm rời nhau */
        .product-variations-btn {
            display: unset !important;
            background: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        .variation-group {
            margin-bottom: 28px;
        }

        .variation-label {
            font-weight: 600;
            font-size: 14px;
            color: #222;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .variation-options {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .variation-btn {
            border: 2px solid #bbb;
            background: #fff;
            color: #111;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 13px;
            cursor: pointer;
            transition: border 0.2s, background 0.2s;
            outline: none;
        }

        .variation-btn.active,
        .variation-btn:focus {
            border: 2.5px solid #111;
            background: #f5f5f5;
            font-weight: bold;
        }

        .variation-btn:hover {
            border: 2px solid #111;
        }

        .dmx-review-section {
            background: #fff;
            color: #111;
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 32px 24px;
            margin-bottom: 32px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .dmx-review-summary {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .dmx-review-score {
            min-width: 120px;
            text-align: center;
        }

        .dmx-review-score .score {
            font-size: 2.8rem;
            font-weight: bold;
            color: #111;
        }

        .dmx-review-score .score-max {
            font-size: 1.2rem;
            color: #888;
        }

        .dmx-review-score .score-stars {
            margin: 8px 0;
        }

        .dmx-review-score .star {
            color: #bbb;
            font-size: 1.3rem;
        }

        .dmx-review-score .star.filled {
            color: #f7b500;
        }

        .dmx-review-score .score-count {
            font-size: 1rem;
            color: #666;
        }

        .dmx-review-breakdown {
            flex: 1;
            min-width: 200px;
        }

        .breakdown-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .star-label {
            min-width: 40px;
            color: #111;
            font-weight: 500;
        }

        .star-label .star {
            color: #f7b500;
        }

        .progress-bar {
            flex: 1;
            height: 8px;
            background: #eee;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 8px;
        }

        .progress {
            height: 100%;
            background: #111;
            border-radius: 4px;
        }

        .percent {
            min-width: 32px;
            color: #888;
            font-size: 0.95em;
        }

        .dmx-review-list {
            margin-top: 24px;
        }

        .dmx-review-item {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 18px 16px;
            margin-bottom: 18px;
            background: #fafafa;
        }

        .review-header {
            display: flex;
            gap: 12px;
            align-items: center;
            font-weight: 600;
            color: #111;
            margin-bottom: 4px;
        }

        .review-date {
            color: #888;
            font-size: 0.95em;
            font-weight: 400;
        }

        .review-stars {
            margin-bottom: 6px;
        }

        .review-stars .star {
            color: #bbb;
            font-size: 1.1rem;
        }

        .review-stars .star.filled {
            color: #f7b500;
        }

        .review-content {
            color: #222;
            font-size: 1.08em;
            margin-bottom: 8px;
        }

        .review-reply {
            background: #f5f5f5;
            border-left: 3px solid #111;
            padding: 10px 14px;
            border-radius: 6px;
            margin-top: 8px;
        }

        .reply-label {
            color: #111;
            font-weight: bold;
            font-size: 1em;
        }

        .reply-content {
            color: #333;
            margin-top: 2px;
        }

        .dmx-review-actions {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .btn.btn-dark {
            background: #111;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 28px;
            font-weight: 600;
            font-size: 1.08em;
            transition: background 0.2s;
        }

        .btn.btn-dark:hover {
            background: #333;
        }

        .btn.btn-outline-dark {
            background: #fff;
            color: #111;
            border: 1.5px solid #111;
            border-radius: 6px;
            padding: 10px 28px;
            font-weight: 600;
            font-size: 1.08em;
            transition: background 0.2s, color 0.2s;
        }

        .btn.btn-outline-dark:hover {
            background: #111;
            color: #fff;
        }

        .review-media {
            margin-top: 6px;
            gap: 10px;
        }

        .review-media img,
        .review-media video {
            transition: box-shadow 0.2s;
        }

        .review-media img:hover,
        .review-media video:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            border-color: #bbb;
        }

        .review-variant {
            font-size: 13px;
            color: #444;
            margin-bottom: 2px;
        }

        .review-variant b {
            color: #111;
            font-weight: 500;
        }

        .review-filter-btn {
            border: 1.5px solid #eee;
            color: #222;
            background: #fff;
            padding: 7px 18px;
            border-radius: 4px;
            font-weight: 500;
            transition: border 0.2s, color 0.2s;
        }

        .review-filter-btn.active {
            border: 1.5px solid #f44336 !important;
            color: #f44336 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var productId = '{{ $product->id }}';
            var viewed = [];
            var cookie = document.cookie.split('; ').find(row => row.startsWith('recently_viewed_products='));
            if (cookie) {
                try {
                    viewed = JSON.parse(decodeURIComponent(cookie.split('=')[1]));
                } catch (e) {
                    viewed = [];
                }
            }
            viewed = viewed.filter(id => id != productId);
            viewed.unshift(productId);
            viewed = viewed.slice(0, 8);
            document.cookie = 'recently_viewed_products=' + encodeURIComponent(JSON.stringify(viewed)) +
                ';path=/;max-age=2592000';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterBtns = document.querySelectorAll('.review-filter-btn');
            var btnShow = document.getElementById('show-more-reviews');
            var btnCollapse = document.getElementById('collapse-reviews');

            function updateShowMoreBtn() {
                var activeBtn = document.querySelector('.review-filter-btn.active');
                var star = activeBtn ? activeBtn.getAttribute('data-star') : 'all';
                var reviews = Array.from(document.querySelectorAll('.dmx-review-item'));
                var filtered = reviews.filter(function(item) {
                    if (star === 'all') return true;
                    var count = 0;
                    item.querySelectorAll('.review-stars .star.filled').forEach(function() {
                        count++;
                    });
                    return parseInt(star) === count;
                });
                if (filtered.length > 2) {
                    var allVisible = filtered.every(function(item) {
                        return item.style.display !== 'none';
                    });
                    if (allVisible) {
                        if (btnShow) btnShow.style.display = 'none';
                        if (btnCollapse) btnCollapse.style.display = '';
                    } else {
                        if (btnShow) btnShow.style.display = '';
                        if (btnCollapse) btnCollapse.style.display = 'none';
                    }
                } else {
                    if (btnShow) btnShow.style.display = 'none';
                    if (btnCollapse) btnCollapse.style.display = 'none';
                }
            }
            filterBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    var star = btn.getAttribute('data-star');
                    var reviews = Array.from(document.querySelectorAll('.dmx-review-item'));
                    var filtered = reviews.filter(function(item) {
                        if (star === 'all') return true;
                        var count = 0;
                        item.querySelectorAll('.review-stars .star.filled').forEach(
                            function() {
                                count++;
                            });
                        return parseInt(star) === count;
                    });
                    filtered.forEach(function(item, idx) {
                        item.style.display = idx < 2 ? '' : 'none';
                    });
                    updateShowMoreBtn();
                });
            });
            updateShowMoreBtn();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterBtns = document.querySelectorAll('.review-filter-btn');
            var btnShow = document.getElementById('show-more-reviews');
            var btnCollapse = document.getElementById('collapse-reviews');

            if (btnShow && btnCollapse) {
                btnShow.addEventListener('click', function() {
                    var activeBtn = document.querySelector('.review-filter-btn.active');
                    var star = activeBtn ? activeBtn.getAttribute('data-star') : 'all';
                    var reviews = Array.from(document.querySelectorAll('.dmx-review-item'));
                    var filtered = reviews.filter(function(item) {
                        if (star === 'all') return true;
                        var count = 0;
                        item.querySelectorAll('.review-stars .star.filled').forEach(function() {
                            count++;
                        });
                        return parseInt(star) === count;
                    });
                    filtered.forEach(function(item) {
                        item.style.display = '';
                    });
                    btnShow.style.display = 'none';
                    btnCollapse.style.display = '';
                });
                btnCollapse.addEventListener('click', function() {
                    var activeBtn = document.querySelector('.review-filter-btn.active');
                    var star = activeBtn ? activeBtn.getAttribute('data-star') : 'all';
                    var reviews = Array.from(document.querySelectorAll('.dmx-review-item'));
                    var filtered = reviews.filter(function(item) {
                        if (star === 'all') return true;
                        var count = 0;
                        item.querySelectorAll('.review-stars .star.filled').forEach(function() {
                            count++;
                        });
                        return parseInt(star) === count;
                    });
                    filtered.forEach(function(item, idx) {
                        item.style.display = idx < 2 ? '' : 'none';
                    });
                    btnShow.style.display = filtered.length > 2 ? '' : 'none';
                    btnCollapse.style.display = 'none';
                    var reviewPanel = document.querySelector('.woocommerce-Tabs-panel--reviews');
                    if (reviewPanel) {
                        reviewPanel.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else {
                        var reviewList = document.querySelector('.dmx-review-list');
                        if (reviewList) {
                            reviewList.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            }
        });
    </script>
@endsection
