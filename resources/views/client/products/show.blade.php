@extends('client.layouts.app')

@section('content')
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
                                <div style="margin-top: 15px; font-size: 1.05em; color: #222;">
                                    Số lượng: <strong>{{ $product->total_stock_quantity }}</strong>
                                </div>
                                <div class="woocommerce-product-details__short-description">
                                    <p>{{ $product->short_description ?? Str::limit($product->description, 120) }}</p>
                                </div>
                                @if ($product->total_stock_quantity <= 0)
                                    <div style="color: red; font-weight: bold; margin-bottom: 12px;">Sản phẩm đã hết hàng
                                    </div>
                                @endif
                                @if ($product->variations->count() > 0)
                                    <div id="qvsfw-variations-form-wrapper">
                                        <form class="variations_form cart" method="post"
                                            action="{{ route('client.products.add-to-cart') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @if ($product->total_stock_quantity <= 0)
                                                <fieldset disabled style="opacity:0.7;pointer-events:none;">
                                            @endif
                                            <table class="variations" cellspacing="0" role="presentation">
                                                <tbody>
                                                    @if ($colors->count())
                                                        <tr>
                                                            <th class="label"><label for="pa_color">Màu sắc</label></th>
                                                            <td class="value">
                                                                <div class="qvsfw-select-options-container qvsfw-select-options-container-type--color pa_color qvsfw-color-layout-style--layout-2"
                                                                    data-attribute-name="Color"
                                                                    style="margin-bottom: 10px;">
                                                                    @foreach ($colors as $color)
                                                                        @php
                                                                            $isTransparent =
                                                                                strtolower($color->name) ===
                                                                                    'trong suốt' ||
                                                                                $color->hex_code === '#FFFFFF00';
                                                                            $variationWithImage = $product->variations
                                                                                ->where('color_id', $color->id)
                                                                                ->first();
                                                                            $imageUrl =
                                                                                $variationWithImage &&
                                                                                $variationWithImage->images->first()
                                                                                    ? asset(
                                                                                        'storage/' .
                                                                                            $variationWithImage->images->first()
                                                                                                ->image_path,
                                                                                    )
                                                                                    : (isset($featuredImage)
                                                                                        ? asset(
                                                                                            'storage/' .
                                                                                                $featuredImage->image_path,
                                                                                        )
                                                                                        : '');
                                                                        @endphp
                                                                        <span
                                                                            class="qvsfw-select-option qvsfw-select-option--color"
                                                                            data-value="{{ $color->id }}"
                                                                            data-name="{{ $color->name }}"
                                                                            data-image-url="{{ $imageUrl }}">
                                                                            <span class="qvsfw-select-option-inner">
                                                                                <span
                                                                                    class="qvsfw-select-option-additional-holder">
                                                                                    @if ($isTransparent)
                                                                                        <span class="qvsfw-select-value"
                                                                                            style="background: repeating-linear-gradient(45deg, #eee 0 8px, #fff 8px 16px); border: 2px solid #888; width: 30px; height: 30px; display: inline-block; vertical-align: middle;"
                                                                                            title="{{ $color->name }}"></span>
                                                                                    @else
                                                                                        <span class="qvsfw-select-value"
                                                                                            style="background-color: {{ $color->hex_code ?? '#ccc' }}; width: 30px; height: 30px; display: inline-block; vertical-align: middle;"
                                                                                            title="{{ $color->name }}"></span>
                                                                                    @endif
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($sizes->count())
                                                        <tr>
                                                            <th class="label"><label for="custom_size">Kích thước</label>
                                                            </th>
                                                            <td class="value">
                                                                <select name="size_id" id="custom_size"
                                                                    class="custom-attribute-select"
                                                                    style="min-width:80px;height:32px;border-radius:6px;border:1.5px solid #222;font-weight:bold;text-align:center;">
                                                                    <option value="">Chọn kích thước</option>
                                                                    @foreach ($sizes as $size)
                                                                        <option value="{{ $size->id }}">
                                                                            {{ $size->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($sphericals->count())
                                                        <tr>
                                                            <th class="label"><label for="custom_spherical">Độ cận</label>
                                                            </th>
                                                            <td class="value">
                                                                <select name="spherical_id" id="custom_spherical"
                                                                    class="custom-attribute-select"
                                                                    style="min-width:80px;height:32px;border-radius:6px;border:1.5px solid #222;font-weight:bold;text-align:center;">
                                                                    <option value="">Chọn độ cận</option>
                                                                    @foreach ($sphericals as $spherical)
                                                                        <option value="{{ $spherical->id }}">
                                                                            {{ $spherical->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($cylindricals->count())
                                                        <tr>
                                                            <th class="label"><label for="custom_cylindrical">Độ
                                                                    loạn</label></th>
                                                            <td class="value">
                                                                <select name="cylindrical_id" id="custom_cylindrical"
                                                                    class="custom-attribute-select"
                                                                    style="min-width:80px;height:32px;border-radius:6px;border:1.5px solid #222;font-weight:bold;text-align:center;">
                                                                    <option value="">Chọn độ loạn</option>
                                                                    @foreach ($cylindricals as $cylindrical)
                                                                        <option value="{{ $cylindrical->id }}">
                                                                            {{ $cylindrical->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>

                                            </table>
                                            <div style="margin-top:12px;text-align:left;">
                                                <a class="reset_variations" href="#"
                                                    style="font-size:14px;color:#007bff;cursor:pointer;">Clear tất cả lựa
                                                    chọn</a>
                                            </div>

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
                                    <a role="button" tabindex="0"
                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon-with-text"
                                        href="index7f33.html?add_to_wishlist=921" data-item-id="921"
                                        data-original-item-id="921" aria-label="Thêm vào danh sách yêu thích"
                                        data-shortcode-atts="{"button_behavior":"view","button_type":"icon-with-text","show_count":"","require_login":false}"
                                        rel="noopener noreferrer"> <span class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                </path>
                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                viewBox="0 0 32 32" fill="currentColor">
                                                <g>
                                                    <path
                                                        d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                </g>
                                            </svg> </span> <span class="qwfw-m-text">Thêm vào yêu thích</span>
                                    </a>
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
                                <div class="reviews-list">
                                    @foreach ($product->reviews as $review)
                                        <div class="review-item mb-3 p-3 border rounded">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $review->user->name ?? 'Người dùng ẩn danh' }}</strong>
                                                <span>{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                                @endfor
                                            </div>
                                            <p class="mt-2">{{ $review->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Chưa có đánh giá nào.</p>
                            @endif
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--comments panel entry-content wc-tab"
                            id="tab-comments" role="tabpanel" aria-labelledby="tab-title-comments"
                            style="display:none;">
                            <h2>Bình luận</h2>
                            @if ($comments->count() > 0)
                                <div class="comments-list">
                                    @foreach ($comments as $comment)
                                        <div class="comment-item" style="padding: 8px 0; border-bottom: 1px solid #eee;">
                                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                                <span
                                                    style="font-weight: bold;">{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</span>
                                                <span
                                                    style="font-size: 13px; color: #888;">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <div style="margin-top: 2px; font-size: 15px; color: #222;">
                                                {{ $comment->content }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Chưa có bình luận nào.</p>
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
                                                        style="position:absolute;top:10px;left:10px;z-index:2;">Giảm
                                                        giá</span>
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
                </div>
            </div>
    </div>
    </main>
    </div><!-- close #qodef-page-inner div from header.php -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.querySelector('.thumbnail-slider');
            const prevBtn = document.querySelector('.slider-prev');
            const nextBtn = document.querySelector('.slider-next');
            const thumbnailWidth = 196; // 180px width + 16px margin-right
            let currentPosition = 0;
            const maxScroll = (slider.children.length - 3) * thumbnailWidth;

            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', function() {
                    if (currentPosition > 0) {
                        currentPosition -= thumbnailWidth;
                    } else {
                        currentPosition = maxScroll; // Quay về ảnh cuối
                    }
                    slider.style.transform = `translateX(-${currentPosition}px)`;
                });

                nextBtn.addEventListener('click', function() {
                    if (currentPosition < maxScroll) {
                        currentPosition += thumbnailWidth;
                    } else {
                        currentPosition = 0; // Quay về ảnh đầu
                    }
                    slider.style.transform = `translateX(-${currentPosition}px)`;
                });
            }

            // Prepare variations data from PHP (for JS)
            window.productVariations = @json($variationsJson);

            // Helper: get selected attribute values
            function getSelectedAttributes() {
                const colorEl = document.querySelector('.qvsfw-select-option--color.qvsfw-selected');
                const colorId = colorEl ? colorEl.getAttribute('data-value') : '';
                const sizeId = document.getElementById('custom_size') ? document.getElementById('custom_size')
                    .value : '';
                const sphericalId = document.getElementById('custom_spherical') ? document.getElementById(
                    'custom_spherical').value : '';
                const cylindricalId = document.getElementById('custom_cylindrical') ? document.getElementById(
                    'custom_cylindrical').value : '';
                return {
                    colorId,
                    sizeId,
                    sphericalId,
                    cylindricalId
                };
            }

            // Attribute change handler
            function onAttributeChange() {
                const {
                    colorId,
                    sizeId,
                    sphericalId,
                    cylindricalId
                } = getSelectedAttributes();
                const mainImg = document.getElementById('main-product-image');
                const defaultImg = mainImg.dataset.defaultSrc ||
                    '{{ isset($featuredImage) ? asset('storage/' . $featuredImage->image_path) : asset('') }}';
                const variationIdInput = document.querySelector('input[name="variation_id"]');

                if (colorId || sizeId || sphericalId || cylindricalId) {
                    const matchingVariation = window.productVariations.find(v =>
                        (!colorId || v.color_id === colorId) &&
                        (!sizeId || v.size_id === sizeId) &&
                        (!sphericalId || v.spherical_id === sphericalId) &&
                        (!cylindricalId || v.cylindrical_id === cylindricalId)
                    );

                    if (matchingVariation) {
                        if (matchingVariation.image) {
                            mainImg.src = matchingVariation.image;
                        }
                        // Cập nhật variation_id
                        if (variationIdInput) {
                            variationIdInput.value = matchingVariation.id;
                        }
                    } else if (colorId) {
                        // Nếu chỉ chọn màu sắc, dùng ảnh của màu
                        const colorVariation = window.productVariations.find(v => v.color_id === colorId);
                        if (colorVariation) {
                            if (colorVariation.image) {
                                mainImg.src = colorVariation.image;
                            }
                            // Cập nhật variation_id
                            if (variationIdInput) {
                                variationIdInput.value = colorVariation.id;
                            }
                        } else {
                            mainImg.src = defaultImg;
                        }
                    } else {
                        mainImg.src = defaultImg;
                    }
                } else {
                    mainImg.src = defaultImg;
                    // Reset variation_id về giá trị mặc định
                    if (variationIdInput) {
                        variationIdInput.value = '{{ $selectedVariation->id ?? '' }}';
                    }
                }
            }

            // Color select
            document.querySelectorAll('.qvsfw-select-option--color').forEach(function(el) {
                el.addEventListener('click', function() {
                    document.querySelectorAll('.qvsfw-select-option--color').forEach(e => e
                        .classList.remove('qvsfw-selected'));
                    el.classList.add('qvsfw-selected');
                    onAttributeChange();
                });
            });

            // Other attribute selects
            const sizeSelect = document.getElementById('custom_size');
            const sphericalSelect = document.getElementById('custom_spherical');
            const cylindricalSelect = document.getElementById('custom_cylindrical');
            if (sizeSelect) sizeSelect.addEventListener('change', onAttributeChange);
            if (sphericalSelect) sphericalSelect.addEventListener('change', onAttributeChange);
            if (cylindricalSelect) cylindricalSelect.addEventListener('change', onAttributeChange);

            // Clear button: reset all selects and color (Clear All)
            const clearBtn = document.querySelector('.reset_variations');
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (sizeSelect) sizeSelect.selectedIndex = 0;
                    if (sphericalSelect) sphericalSelect.selectedIndex = 0;
                    if (cylindricalSelect) cylindricalSelect.selectedIndex = 0;
                    document.querySelectorAll('.qvsfw-select-option--color').forEach(el => el.classList
                        .remove('qvsfw-selected'));
                    const mainImg = document.getElementById('main-product-image');
                    mainImg.src = mainImg.dataset.defaultSrc ||
                        '{{ isset($featuredImage) ? asset('storage/' . $featuredImage->image_path) : asset('') }}';
                    // Reset variation_id về giá trị mặc định
                    const variationIdInput = document.querySelector('input[name="variation_id"]');
                    if (variationIdInput) {
                        variationIdInput.value = '{{ $selectedVariation->id ?? '' }}';
                    }
                    onAttributeChange();
                });
            }

            // Store default image src for reset
            const mainImg = document.getElementById('main-product-image');
            if (mainImg && !mainImg.dataset.defaultSrc) {
                mainImg.dataset.defaultSrc = mainImg.src;
            }

            // Initial call to set image based on default selection (if any)
            onAttributeChange();

            // Tab switching logic
            const tabLinks = document.querySelectorAll('.wc-tabs li');
            const tabPanels = document.querySelectorAll('.woocommerce-Tabs-panel');
            tabLinks.forEach(function(tab) {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    tabLinks.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    tabPanels.forEach(panel => panel.style.display = 'none');
                    const target = tab.querySelector('a').getAttribute('href');
                    document.querySelector(target).style.display = '';
                });
            });
            // Mặc định mở tab đầu tiên
            tabLinks[0].classList.add('active');
            tabPanels[0].style.display = '';
        });
    </script>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                                // Xóa message cũ nếu có
                                var msgContainer = document.getElementById('add-to-cart-message');
                                if (msgContainer) {
                                    msgContainer.innerHTML = '';
                                }
                                // Tạo message mới
                                var msg = document.createElement('div');
                                msg.className = 'woocommerce-message';
                                msg.setAttribute('role', 'alert');
                                var productName = form.getAttribute('data-product-name');
                                msg.innerHTML =
                                    `<a href="/client/cart" tabindex="1" class="button wc-forward">Xem giỏ hàng</a> &ldquo;${productName}&rdquo; đã được thêm vào giỏ hàng.`;
                                if (msgContainer) {
                                    msgContainer.appendChild(msg);
                                }
                            })
                            .catch(() => alert('Có lỗi xảy ra!'));
                    });
                });
            });
        </script>
    @endpush
    <style>
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
    </style>
@endsection
