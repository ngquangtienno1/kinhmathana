@extends('client.layouts.app')

@section('content')
    @if(session('message'))
    <div id="toast-success" class="toast-custom toast-success toast-animate">
        <span class="toast-icon">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#388e3c" stroke-width="2"><circle cx="12" cy="12" r="10" fill="#e8f5e9"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12.5l2.5 2.5 5-5"/></svg>
        </span>
        <span class="toast-content">{{ session('message') }}</span>
        <span class="toast-close" onclick="document.getElementById('toast-success').remove()">&times;</span>
    </div>
    <script>
        setTimeout(function(){
            var el = document.getElementById('toast-success');
            if(el) el.style.opacity = 0;
        }, 3500);
        setTimeout(function(){
            var el = document.getElementById('toast-success');
            if(el) el.remove();
        }, 4000);
    </script>
    <style>
    .toast-animate {
        opacity: 0;
        transform: translateY(-30px) scale(0.98);
        animation: toastIn 0.5s cubic-bezier(.4,0,.2,1) forwards;
    }
    @keyframes toastIn {
        0% {
            opacity: 0;
            transform: translateY(-30px) scale(0.98);
        }
        60% {
            opacity: 1;
            transform: translateY(4px) scale(1.01);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .toast-custom {
        position: fixed;
        top: 32px;
        right: 32px;
        z-index: 9999;
        width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 24px;
        margin-top: 90px;
        margin-left: 15px;
        font-size: 0.9rem;
        font-weight: 500;
        box-shadow: 0 4px 24px 0 rgba(0,0,0,0.12);
        opacity: 1;
        transition: opacity 0.5s;
        letter-spacing: 0.2px;
        border-bottom: 4px solid;
        border-radius: 10px;
    }
    .toast-success {
        background: #e8f5e9;
        color: #388e3c;
        border-bottom-color: #388e3c;
    }
    .toast-icon {
        display: flex;
        align-items: center;
        margin-right: 2px;
    }
    .toast-content {
        flex: 1;
        line-height: 1.5;
    }
    .toast-close {
        cursor: pointer;
        font-size: 1.3rem;
        font-weight: 700;
        color: #888;
        margin-left: 8px;
        transition: color 0.2s;
    }
    .toast-close:hover {
        color: #222;
    }
    </style>
    @endif
    <div id="qodef-page-outer">
        <div class="qodef-content-full-width">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div data-elementor-type="wp-page" data-elementor-id="65" class="elementor elementor-65">
                            {{-- Banner Carousel Start --}}
                            <div id="main-banner-carousel" class="main-banner-carousel"
                                style="position:relative;width:100vw;max-width:1950px;margin:0 auto;overflow:hidden;">
                                <div class="main-banner-slides"
                                    style="width:100vw;max-width:1950px;height:762px;position:relative;">
                                    @foreach ($sliders as $index => $slider)
                                        <div class="main-banner-slide" data-index="{{ $index }}"
                                            style="display:{{ $index === 0 ? 'block' : 'none' }};width:100vw;max-width:1950px;height:762px;position:absolute;top:0;left:0;">
                                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                                                style="width:100vw;max-width:1950px;height:762px;object-fit:cover;">
                                            {{-- @if ($slider->title || $slider->description)
                                                <div class="main-banner-caption"
                                                    style="position:absolute;left:60px;top:60px;color:#fff;text-shadow:0 2px 8px #000;font-size:2.8rem;max-width:60%;">
                                                    <div style="font-weight:bold;font-size:3.2rem;">{{ $slider->title }}
                                                    </div>
                                                    <div style="margin-top:18px;font-size:1.5rem;">
                                                        {{ $slider->description }}</div>
                                                </div>
                                            @endif --}}
                                        </div>
                                    @endforeach
                                </div>
                                <div class="main-banner-dots"
                                    style="position:absolute;bottom:25px;left:0;right:0;text-align:center;z-index:10;">
                                    @foreach ($sliders as $index => $slider)
                                        <span class="main-banner-dot" data-index="{{ $index }}"
                                            style="display:inline-block;width:12px;height:12px;margin:0 5px;background:#fff;opacity:{{ $index === 0 ? '1' : '0.5' }};border-radius:50%;cursor:pointer;"></span>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Banner Carousel End --}}

                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-bf39784 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
                                data-id="bf39784" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-f6e32a5"
                                        data-id="f6e32a5" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-5328483 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="5328483" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title">
                                                            Sản phẩm bán chạy nhất </h2>
                                                        <p class="qodef-m-subtitle" style="margin-top: 12px">Những sản
                                                            phẩm bán chạy nhất của chúng tôi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-element elementor-widget elementor-widget-neoocular_core_product_list">
                                <div class="elementor-widget-container">
                                    <div
                                        class="qodef-shortcode qodef-m  qodef-woo-shortcode qodef-woo-product-list qodef-item-layout--info-below  qodef-grid qodef-layout--columns  qodef-gutter--small qodef-col-num--3 qodef-item-layout--info-below qodef--no-bottom-space qodef-pagination--off qodef-responsive--custom qodef-col-num--1440--3 qodef-col-num--1366--3 qodef-col-num--1024--2 qodef-col-num--768--2 qodef-col-num--680--1 qodef-col-num--480--1">
                                        <ul class="qodef-grid-inner clear">
                                            @forelse($bestSellerProducts as $product)
                                                <li
                                                    class="qodef-e qodef-grid-item qodef-item--full product type-product post-{{ $product->id }} status-publish {{ $product->total_quantity > 0 ? 'instock' : 'outofstock' }} has-post-thumbnail {{ $product->sale_price && $product->sale_price < $product->price ? 'sale' : '' }} shipping-taxable purchasable product-type-{{ $product->product_type }}">
                                                    <div class="qodef-e-inner">
                                                        <div class="qodef-woo-product-image">
                                                            @if ($product->sale_price && $product->sale_price < $product->price)
                                                                <span
                                                                    class="qodef-woo-product-mark qodef-woo-onsale">Sale</span>
                                                            @endif
                                                            @php
                                                                $featuredImage = null;
                                                                if ($product->variations->count() > 0) {
                                                                    $firstVariation = $product->variations->first();
                                                                    if ($firstVariation->images->count() > 0) {
                                                                        $featuredImage =
                                                                            $firstVariation->images
                                                                                ->where('is_featured', true)
                                                                                ->first() ??
                                                                            $firstVariation->images->first();
                                                                    }
                                                                }

                                                                // Nếu không có ảnh biến thể, lấy ảnh sản phẩm chính
                                                                if (!$featuredImage) {
                                                                    $featuredImage =
                                                                        $product->images
                                                                            ->where('is_featured', true)
                                                                            ->first() ?? $product->images->first();
                                                                }

                                                                $imagePath = $featuredImage
                                                                    ? asset('storage/' . $featuredImage->image_path)
                                                                    : asset('default-product.jpg');
                                                            @endphp
                                                            <img loading="lazy" decoding="async" width="800"
                                                                height="393" src="{{ $imagePath }}"
                                                                class="attachment-full size-full qodef-list-image"
                                                                alt="{{ $product->name }}" />
                                                            <a href="{{ route('client.products.show', $product->slug) }}"
                                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                                        </div>
                                                        <div class="qodef-woo-product-content"
                                                            style="background-color: #FFFFFF">
                                                            <div class="qodef-woo-color-variations-holder"></div>
                                                            <h5 itemprop="name" class="qodef-woo-product-title entry-title"
                                                                style="margin-bottom: 8px">
                                                                <a itemprop="url" class="qodef-woo-product-title-link"
                                                                    href="{{ route('client.products.show', $product->slug) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            </h5>
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
                                                            <div class="qodef-woo-product-price price">
                                                                @php
                                                                    $price = $product->price;
                                                                    $salePrice = $product->sale_price;

                                                                    if ($product->variations->count() > 0) {
                                                                        $firstVariation = $product->variations->first();
                                                                        $price =
                                                                            $firstVariation->price ?? $product->price;
                                                                        $salePrice =
                                                                            $firstVariation->sale_price ??
                                                                            $product->sale_price;
                                                                    }
                                                                @endphp
                                                                @if ($salePrice && $salePrice < $price)
                                                                    <del aria-hidden="true">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <bdi>{{ number_format($price, 0, ',', '.') }}đ</bdi>
                                                                        </span>
                                                                    </del>
                                                                    <span class="screen-reader-text">Giá gốc:
                                                                        {{ number_format($price, 0, ',', '.') }}đ.</span>
                                                                    <ins aria-hidden="true">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <bdi>{{ number_format($salePrice, 0, ',', '.') }}đ</bdi>
                                                                        </span>
                                                                    </ins>
                                                                    <span class="screen-reader-text">Giá khuyến mãi:
                                                                        {{ number_format($salePrice, 0, ',', '.') }}đ.</span>
                                                                @else
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <bdi>{{ number_format($price ?? 0, 0, ',', '.') }}đ</bdi>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="qodef-woo-product-image-inner">
                                                                <a href="{{ route('client.products.show', $product->slug) }}"
                                                                    class="button product_type_simple add_to_cart_button"
                                                                    aria-label="Xem chi tiết: {{ $product->name }}"
                                                                    rel="nofollow">Xem chi tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="qodef-e qodef-grid-item qodef-item--full">
                                                    <div class="qodef-e-inner">
                                                        <p>Chưa có sản phẩm bán chạy</p>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </section>

                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-c22d12f elementor-section-full_width elementor-hidden-tablet elementor-hidden-mobile elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="c22d12f" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-ca5ad62"
                                        data-id="ca5ad62" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-14b6643 elementor-widget elementor-widget-neoocular_core_stacked_images"
                                                data-id="14b6643" data-element_type="widget"
                                                data-widget_type="neoocular_core_stacked_images.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-stacked-images qodef-layout--default qodef-stack--bottom-right">
                                                        <div class="qodef-m-images">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1300" height="1300"
                                                                src="{{ asset('v1/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001.jpg') }}"
                                                                class="qodef-e-image qodef--main" alt="g"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001.jpg 1300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-300x300.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-1024x1024.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-768x768.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-1200x1200.jpg 1200w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-650x650.jpg 650w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-600x600.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-800x800.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-100x100.jpg 100w"
                                                                sizes="(max-width: 1300px) 100vw, 1300px" /> <img
                                                                loading="lazy" loading="lazy" decoding="async"
                                                                width="1300" height="1228"
                                                                src="{{ asset('v1/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1.png') }}"
                                                                class="qodef-e-image qodef--stack" alt="j"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1.png 1300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1-300x283.png 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1-1024x967.png 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1-768x725.png 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1-1200x1134.png 1200w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1-600x567.png 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0001-1-800x756.png 800w"
                                                                sizes="(max-width: 1300px) 100vw, 1300px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-d5d8e61"
                                        data-id="d5d8e61" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <section
                                                class="elementor-section elementor-inner-section elementor-element elementor-element-81384a8 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                                data-id="81384a8" data-element_type="section">
                                                <div class="elementor-container elementor-column-gap-default">
                                                    <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-eb7cad7"
                                                        data-id="eb7cad7" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-e015bd1 elementor-widget elementor-widget-neoocular_core_section_title"
                                                                data-id="e015bd1" data-element_type="widget"
                                                                data-widget_type="neoocular_core_section_title.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                                        <h3 class="qodef-m-title">
                                                                            Tròng Kính Đa Năng </h3>
                                                                        <p class="qodef-m-subtitle"
                                                                            style="margin-top: 11px"> Bảo vệ mắt khỏi ánh
                                                                            sáng xanh từ màn hình – giảm mỏi, tăng tập trung
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-ee33dfc elementor-widget elementor-widget-neoocular_core_icon_with_text"
                                                                data-id="ee33dfc" data-element_type="widget"
                                                                data-widget_type="neoocular_core_icon_with_text.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--before-content qodef--icon-pack ">
                                                                        <div class="qodef-m-icon-wrapper">
                                                                            <span
                                                                                class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--default qodef-layout--normal"
                                                                                data-hover-color="#1C1C1C"> <span
                                                                                    class="qodef-icon-dripicons dripicons-brightness-max qodef-icon qodef-e"
                                                                                    style="color: #1C1C1C;font-size: 20px"></span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="qodef-m-content">
                                                                            <h6 class="qodef-m-title">
                                                                                <span class="qodef-m-title-text">Thiết kế
                                                                                    tinh xảo, vừa vặn đến từng chi
                                                                                    tiết</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Đảm bảo sự thoải mái tối đa cho người đeo
                                                                                trong mọi hoạt động hằng ngày
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-33e1c67 elementor-widget-divider--view-line elementor-widget elementor-widget-divider"
                                                                data-id="33e1c67" data-element_type="widget"
                                                                data-widget_type="divider.default">
                                                                <div class="elementor-widget-container">
                                                                    <div class="elementor-divider">
                                                                        <span class="elementor-divider-separator">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-5f74730 elementor-widget elementor-widget-neoocular_core_icon_with_text"
                                                                data-id="5f74730" data-element_type="widget"
                                                                data-widget_type="neoocular_core_icon_with_text.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--before-content qodef--icon-pack ">
                                                                        <div class="qodef-m-icon-wrapper"
                                                                            style="margin-right: 20px">
                                                                            <span
                                                                                class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--default qodef-layout--normal"
                                                                                data-hover-color="#1C1C1C"> <span
                                                                                    class="qodef-icon-ionicons ion-ios-leaf qodef-icon qodef-e"
                                                                                    style="color: #1C1C1C;font-size: 20px"></span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="qodef-m-content">
                                                                            <h6 class="qodef-m-title">
                                                                                <span class="qodef-m-title-text">Chất lượng
                                                                                    vượt trội, thiết kế đầy cuốn hút</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Kết hợp công nghệ hiện đại và tính thẩm mỹ –
                                                                                nâng tầm trải nghiệm thị giác của bạn
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-dd5cd28 elementor-section-full_width elementor-hidden-desktop elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="dd5cd28" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-6cfc69f"
                                        data-id="6cfc69f" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-dc8fd0d elementor-widget elementor-widget-neoocular_core_single_image"
                                                data-id="dc8fd0d" data-element_type="widget"
                                                data-widget_type="neoocular_core_single_image.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                        <div class="qodef-m-image">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1300" height="1300"
                                                                src="{{ asset('v1/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001.jpg') }}"
                                                                class="attachment-full size-full qodef-list-image"
                                                                alt="g"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001.jpg 1300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-300x300.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-1024x1024.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-768x768.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-1200x1200.jpg 1200w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-650x650.jpg 650w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-600x600.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-800x800.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-Home-stacked-img-big-001-100x100.jpg 100w"
                                                                sizes="(max-width: 1300px) 100vw, 1300px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-4854fff"
                                        data-id="4854fff" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <section
                                                class="elementor-section elementor-inner-section elementor-element elementor-element-a91c827 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                                data-id="a91c827" data-element_type="section">
                                                <div class="elementor-container elementor-column-gap-default">
                                                    <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-0f6465d"
                                                        data-id="0f6465d" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-46ee11c elementor-widget elementor-widget-neoocular_core_section_title"
                                                                data-id="46ee11c" data-element_type="widget"
                                                                data-widget_type="neoocular_core_section_title.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                                        <h3 class="qodef-m-title">
                                                                            Tròng Kính Chống Ánh Sáng Xanh </h3>
                                                                        <p class="qodef-m-subtitle"
                                                                            style="margin-top: 11px">Bảo vệ đôi mắt bạn
                                                                            khỏi ánh sáng xanh, thoải mái suốt cả ngày</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-cdf42d0 elementor-widget elementor-widget-neoocular_core_icon_with_text"
                                                                data-id="cdf42d0" data-element_type="widget"
                                                                data-widget_type="neoocular_core_icon_with_text.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--before-content qodef--icon-pack ">
                                                                        <div class="qodef-m-icon-wrapper">
                                                                            <span
                                                                                class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--default qodef-layout--normal"
                                                                                data-hover-color="#1C1C1C"> <span
                                                                                    class="qodef-icon-dripicons dripicons-brightness-max qodef-icon qodef-e"
                                                                                    style="color: #1C1C1C;font-size: 20px"></span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="qodef-m-content">
                                                                            <h6 class="qodef-m-title">
                                                                                <span class="qodef-m-title-text">Thoải mái
                                                                                    tuyệt đối, phù hợp mọi khuôn mặt</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Thiết kế nhẹ, ôm vừa vặn và thời trang cho
                                                                                cả ngày dài năng động
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-5e6c79a elementor-widget-divider--view-line elementor-widget elementor-widget-divider"
                                                                data-id="5e6c79a" data-element_type="widget"
                                                                data-widget_type="divider.default">
                                                                <div class="elementor-widget-container">
                                                                    <div class="elementor-divider">
                                                                        <span class="elementor-divider-separator">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-0b6c313 elementor-widget elementor-widget-neoocular_core_icon_with_text"
                                                                data-id="0b6c313" data-element_type="widget"
                                                                data-widget_type="neoocular_core_icon_with_text.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--before-content qodef--icon-pack ">
                                                                        <div class="qodef-m-icon-wrapper">
                                                                            <span
                                                                                class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--default qodef-layout--normal"
                                                                                data-hover-color="#1C1C1C"> <span
                                                                                    class="qodef-icon-ionicons ion-ios-leaf qodef-icon qodef-e"
                                                                                    style="color: #1C1C1C;font-size: 20px"></span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="qodef-m-content">
                                                                            <h6 class="qodef-m-title">
                                                                                <span class="qodef-m-title-text">Chống mỏi
                                                                                    mắt, nâng cao hiệu suất làm việc</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Giảm thiểu tác hại từ ánh sáng xanh – tập
                                                                                trung tốt hơn, làm việc hiệu quả hơn mỗi
                                                                                ngày
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-3daa4ed elementor-widget elementor-widget-neoocular_core_button"
                                                                data-id="3daa4ed" data-element_type="widget"
                                                                data-widget_type="neoocular_core_button.default">
                                                                <div class="elementor-widget-container">
                                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined qodef-size--large qodef-html--link "
                                                                        href="shop/index.html" target="_self">
                                                                        <span class="qodef-m-text">Xem thêm</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-bf39784 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
                                data-id="bf39784" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-f6e32a5"
                                        data-id="f6e32a5" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-5328483 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="5328483" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title">
                                                            Sản phẩm nổi bật </h2>
                                                        <p class="qodef-m-subtitle" style="margin-top: 12px">Khám phá bộ
                                                            sưu tập mùa hè mới của chúng tôi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-0f2b2e5 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="0f2b2e5" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-427e087"
                                        data-id="427e087" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-bb3a89e elementor-widget elementor-widget-neoocular_core_product_list"
                                                data-id="bb3a89e" data-element_type="widget"
                                                data-widget_type="neoocular_core_product_list.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-shortcode qodef-m  qodef-woo-shortcode qodef-woo-product-list qodef-item-layout--info-below  qodef-grid qodef-layout--columns  qodef-gutter--small qodef-col-num--3 qodef-item-layout--info-below qodef--no-bottom-space qodef-pagination--off qodef-responsive--custom qodef-col-num--1440--3 qodef-col-num--1366--3 qodef-col-num--1024--2 qodef-col-num--768--2 qodef-col-num--680--1 qodef-col-num--480--1"
                                                        data-options="{&quot;plugin&quot;:&quot;neoocular_core&quot;,&quot;module&quot;:&quot;plugins\/woocommerce\/shortcodes&quot;,&quot;shortcode&quot;:&quot;product-list&quot;,&quot;post_type&quot;:&quot;product&quot;,&quot;next_page&quot;:&quot;2&quot;,&quot;max_pages_num&quot;:1,&quot;behavior&quot;:&quot;columns&quot;,&quot;images_proportion&quot;:&quot;full&quot;,&quot;columns&quot;:&quot;3&quot;,&quot;columns_responsive&quot;:&quot;custom&quot;,&quot;columns_1440&quot;:&quot;3&quot;,&quot;columns_1366&quot;:&quot;3&quot;,&quot;columns_1024&quot;:&quot;2&quot;,&quot;columns_768&quot;:&quot;2&quot;,&quot;columns_680&quot;:&quot;1&quot;,&quot;columns_480&quot;:&quot;1&quot;,&quot;space&quot;:&quot;small&quot;,&quot;enable_color_variation&quot;:&quot;yes&quot;,&quot;posts_per_page&quot;:&quot;6&quot;,&quot;orderby&quot;:&quot;date&quot;,&quot;order&quot;:&quot;ASC&quot;,&quot;additional_params&quot;:&quot;tax&quot;,&quot;tax&quot;:&quot;product_cat&quot;,&quot;tax_slug&quot;:&quot;luxory&quot;,&quot;layout&quot;:&quot;info-below&quot;,&quot;title_tag&quot;:&quot;h5&quot;,&quot;title_margin_bottom&quot;:&quot;8px&quot;,&quot;content_bg_color&quot;:&quot;#FFFFFF&quot;,&quot;pagination_type&quot;:&quot;no-pagination&quot;,&quot;object_class_name&quot;:&quot;NeoOcularCore_Product_List_Shortcode&quot;,&quot;taxonomy_filter&quot;:&quot;product_cat&quot;,&quot;additional_query_args&quot;:{&quot;tax_query&quot;:[{&quot;taxonomy&quot;:&quot;product_cat&quot;,&quot;field&quot;:&quot;slug&quot;,&quot;terms&quot;:&quot;luxory&quot;}]},&quot;content_styles&quot;:[&quot;background-color: #FFFFFF&quot;],&quot;title_styles&quot;:[&quot;margin-bottom: 8px&quot;],&quot;space_value&quot;:10}">
                                                        <ul class="qodef-grid-inner clear">
                                                            @forelse($featuredProducts as $product)
                                                                <li
                                                                    class="qodef-e qodef-grid-item qodef-item--full product type-product post-{{ $product->id }} status-publish {{ $product->total_quantity > 0 ? 'instock' : 'outofstock' }} has-post-thumbnail {{ $product->sale_price && $product->sale_price < $product->price ? 'sale' : '' }} shipping-taxable purchasable product-type-{{ $product->product_type }}">
                                                                    <div class="qodef-e-inner">
                                                                        <div class="qodef-woo-product-image">
                                                                            @if ($product->sale_price && $product->sale_price < $product->price)
                                                                                <span
                                                                                    class="qodef-woo-product-mark qodef-woo-onsale">Sale</span>
                                                                            @endif
                                                                            @php
                                                                                // Ưu tiên ảnh biến thể nếu có
                                                                                $featuredImage = null;
                                                                                if ($product->variations->count() > 0) {
                                                                                    $firstVariation = $product->variations->first();
                                                                                    if (
                                                                                        $firstVariation->images->count() >
                                                                                        0
                                                                                    ) {
                                                                                        $featuredImage =
                                                                                            $firstVariation->images
                                                                                                ->where(
                                                                                                    'is_featured',
                                                                                                    true,
                                                                                                )
                                                                                                ->first() ??
                                                                                            $firstVariation->images->first();
                                                                                    }
                                                                                }

                                                                                // Nếu không có ảnh biến thể, lấy ảnh sản phẩm chính
                                                                                if (!$featuredImage) {
                                                                                    $featuredImage =
                                                                                        $product->images
                                                                                            ->where('is_featured', true)
                                                                                            ->first() ??
                                                                                        $product->images->first();
                                                                                }

                                                                                $imagePath = $featuredImage
                                                                                    ? asset(
                                                                                        'storage/' .
                                                                                            $featuredImage->image_path,
                                                                                    )
                                                                                    : asset('default-product.jpg');
                                                                            @endphp
                                                                            <img loading="lazy" decoding="async"
                                                                                width="800" height="393"
                                                                                src="{{ $imagePath }}"
                                                                                class="attachment-full size-full qodef-list-image"
                                                                                alt="{{ $product->name }}" />
                                                                            <a href="{{ route('client.products.show', $product->slug) }}"
                                                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                                                        </div>
                                                                        <div class="qodef-woo-product-content"
                                                                            style="background-color: #FFFFFF">
                                                                            <div class="qodef-woo-color-variations-holder">
                                                                            </div>
                                                                            <h5 itemprop="name"
                                                                                class="qodef-woo-product-title entry-title"
                                                                                style="margin-bottom: 8px">
                                                                                <a itemprop="url"
                                                                                    class="qodef-woo-product-title-link"
                                                                                    href="{{ route('client.products.show', $product->slug) }}">
                                                                                    {{ $product->name }}
                                                                                </a>
                                                                            </h5>
                                                                            <div
                                                                                class="qodef-woo-product-categories qodef-e-info">
                                                                                @foreach ($product->categories as $category)
                                                                                    <a href="{{ route('client.products.index', ['category_id' => $category->id]) }}"
                                                                                        rel="tag">{{ $category->name }}</a>
                                                                                    @if (!$loop->last)
                                                                                        <span
                                                                                            class="qodef-info-separator-single"></span>
                                                                                    @endif
                                                                                @endforeach
                                                                                <div class="qodef-info-separator-end">
                                                                                </div>
                                                                            </div>
                                                                            <div class="qodef-woo-product-price price">
                                                                                @php
                                                                                    // Lấy giá từ biến thể đầu tiên nếu có
                                                                                    $price = $product->price;
                                                                                    $salePrice = $product->sale_price;

                                                                                    if (
                                                                                        $product->variations->count() >
                                                                                        0
                                                                                    ) {
                                                                                        $firstVariation = $product->variations->first();
                                                                                        $price =
                                                                                            $firstVariation->price ??
                                                                                            $product->price;
                                                                                        $salePrice =
                                                                                            $firstVariation->sale_price ??
                                                                                            $product->sale_price;
                                                                                    }
                                                                                @endphp
                                                                                @if ($salePrice && $salePrice < $price)
                                                                                    <del aria-hidden="true">
                                                                                        <span
                                                                                            class="woocommerce-Price-amount amount">
                                                                                            <bdi>{{ number_format($price, 0, ',', '.') }}đ</bdi>
                                                                                        </span>
                                                                                    </del>
                                                                                    <span class="screen-reader-text">Giá
                                                                                        gốc:
                                                                                        {{ number_format($price, 0, ',', '.') }}đ.</span>
                                                                                    <ins aria-hidden="true">
                                                                                        <span
                                                                                            class="woocommerce-Price-amount amount">
                                                                                            <bdi>{{ number_format($salePrice, 0, ',', '.') }}đ</bdi>
                                                                                        </span>
                                                                                    </ins>
                                                                                    <span class="screen-reader-text">Giá
                                                                                        khuyến mãi:
                                                                                        {{ number_format($salePrice, 0, ',', '.') }}đ.</span>
                                                                                @else
                                                                                    <span
                                                                                        class="woocommerce-Price-amount amount">
                                                                                        <bdi>{{ number_format($price ?? 0, 0, ',', '.') }}đ</bdi>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="qodef-woo-product-image-inner">
                                                                                <a href="{{ route('client.products.show', $product->slug) }}"
                                                                                    class="button product_type_simple add_to_cart_button"
                                                                                    aria-label="Xem chi tiết: {{ $product->name }}"
                                                                                    rel="nofollow">Xem chi tiết</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @empty
                                                                <li class="qodef-e qodef-grid-item qodef-item--full">
                                                                    <div class="qodef-e-inner">
                                                                        <p>Chưa có sản phẩm nổi bật</p>
                                                                    </div>
                                                                </li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-162e224 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-min-height elementor-section-height-default elementor-section-items-middle"
                                data-id="162e224" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6a992d1"
                                        data-id="6a992d1" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <section
                                                class="elementor-section elementor-inner-section elementor-element elementor-element-9b6821c elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                                data-id="9b6821c" data-element_type="section"
                                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                                <div class="elementor-container elementor-column-gap-default">
                                                    <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-770cf30"
                                                        data-id="770cf30" data-element_type="column"
                                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-fbe2962 elementor-widget elementor-widget-neoocular_core_section_title"
                                                                data-id="fbe2962" data-element_type="widget"
                                                                data-widget_type="neoocular_core_section_title.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                                        <h2 class="qodef-m-title">
                                                                            Đặt lịch hẹn ngay </h2>
                                                                        <p class="qodef-m-subtitle"
                                                                            style="margin-top: 12px"> Nhận tư vấn chuyên
                                                                            nghiệp một cách nhanh chóng và tiện lợi
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-d8181ea elementor-widget elementor-widget-wp-widget-neoocular_core_contact_form_7"
                                                                data-id="d8181ea" data-element_type="widget"
                                                                data-widget_type="wp-widget-neoocular_core_contact_form_7.default">
                                                                <div class="elementor-widget-container">
                                                                    <div class="qodef-contact-form-7">

                                                                        <div class="wpcf7 no-js" id="wpcf7-f683-p65-o1"
                                                                            lang="en-US" dir="ltr">
                                                                            <div class="screen-reader-response">
                                                                                <p role="status" aria-live="polite"
                                                                                    aria-atomic="true"></p>
                                                                                <ul></ul>
                                                                            </div>
                                                                            <form
                                                                                action="https://neoocular.qodeinteractive.com/#wpcf7-f683-p65-o1"
                                                                                method="post"
                                                                                class="wpcf7-form init demo"
                                                                                aria-label="Contact form"
                                                                                novalidate="novalidate"
                                                                                data-status="init">
                                                                                <div style="display: none;">
                                                                                    <input type="hidden" name="_wpcf7"
                                                                                        value="683" />
                                                                                    <input type="hidden"
                                                                                        name="_wpcf7_version"
                                                                                        value="5.9.8" />
                                                                                    <input type="hidden"
                                                                                        name="_wpcf7_locale"
                                                                                        value="en_US" />
                                                                                    <input type="hidden"
                                                                                        name="_wpcf7_unit_tag"
                                                                                        value="wpcf7-f683-p65-o1" />
                                                                                    <input type="hidden"
                                                                                        name="_wpcf7_container_post"
                                                                                        value="65" />
                                                                                    <input type="hidden"
                                                                                        name="_wpcf7_posted_data_hash"
                                                                                        value="" />
                                                                                </div>
                                                                                <div class="qodef-simple-form">
                                                                                    <p><span class="wpcf7-form-control-wrap"
                                                                                            data-name="your-text"><input
                                                                                                size="40"
                                                                                                maxlength="400"
                                                                                                class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                                                                aria-required="true"
                                                                                                aria-invalid="false"
                                                                                                placeholder="Nhập câu hỏi"
                                                                                                value=""
                                                                                                type="text"
                                                                                                name="your-text" /></span><button
                                                                                            class="wpcf7-form-control wpcf7-submit qodef-button qodef-size--normal qodef-layout--filled qodef-m"
                                                                                            type="submit"><span
                                                                                                class="qodef-m-text">Gửi
                                                                                                ngay
                                                                                            </span></button>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="wpcf7-response-output"
                                                                                    aria-hidden="true">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-82e9fa8 elementor-section-full_width elementor-hidden-tablet elementor-hidden-mobile elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="82e9fa8" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-ddc2358"
                                        data-id="ddc2358" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-94214f9 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="94214f9" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                        <h3 class="qodef-m-title">
                                                            Bộ Sưu Tập Thu / Đông 2025 </h3>
                                                        <p class="qodef-m-subtitle" style="margin-top: 12px"> Phong cách
                                                            thời thượng – Đậm chất riêng trong từng thiết kế</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-0525929 elementor-widget elementor-widget-neoocular_core_accordion"
                                                data-id="0525929" data-element_type="widget"
                                                data-widget_type="neoocular_core_accordion.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-accordion clear qodef-behavior--accordion qodef-layout--simple">
                                                        <h6 class="qodef-accordion-title">
                                                            <span class="qodef-accordion-mark">
                                                                <span class="qodef-icon--plus">+</span>
                                                                <span class="qodef-icon--minus">-</span>
                                                            </span>
                                                            <span class="qodef-tab-title">Khám phá bộ sưu tập kính mới tại
                                                                cửa hàng trực tuyến</span>
                                                        </h6>
                                                        <div class="qodef-accordion-content">
                                                            <div class="qodef-accordion-content-inner">
                                                                <p>Trải nghiệm các mẫu kính hiện đại, hợp xu hướng – dễ dàng
                                                                    chọn mua chỉ với vài cú nhấp chuột.</p>
                                                            </div>
                                                        </div>
                                                        <h6 class="qodef-accordion-title">
                                                            <span class="qodef-accordion-mark">
                                                                <span class="qodef-icon--plus">+</span>
                                                                <span class="qodef-icon--minus">-</span>
                                                            </span>
                                                            <span class="qodef-tab-title">Thiết kế tinh tế, tiện dụng và
                                                                đầy phong cách</span>
                                                        </h6>
                                                        <div class="qodef-accordion-content">
                                                            <div class="qodef-accordion-content-inner">
                                                                <p>Kết hợp hoàn hảo giữa thẩm mỹ và công năng – mang lại cảm
                                                                    giác thoải mái suốt cả ngày dài.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-5c7ae79"
                                        data-id="5c7ae79" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-background-overlay"></div>
                                            <div class="elementor-element elementor-element-a2e795f elementor-widget elementor-widget-neoocular_core_stacked_images"
                                                data-id="a2e795f" data-element_type="widget"
                                                data-widget_type="neoocular_core_stacked_images.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-stacked-images qodef-layout--default qodef-stack--bottom-left">
                                                        <div class="qodef-m-images">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1300" height="1300"
                                                                src="{{ asset('v1/wp-content/uploads/2021/10/main-home-img-stacked-02.jpg') }}"
                                                                class="qodef-e-image qodef--main" alt=""
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02.jpg 1300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-300x300.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-1024x1024.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-768x768.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-1200x1200.jpg 1200w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-650x650.jpg 650w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-600x600.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-800x800.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/main-home-img-stacked-02-100x100.jpg 100w"
                                                                sizes="(max-width: 1300px) 100vw, 1300px" /> <img
                                                                loading="lazy" loading="lazy" decoding="async"
                                                                width="1300" height="1164"
                                                                src="wp-content/uploads/2021/10/Main-home-stacked-img-0002.png"
                                                                class="qodef-e-image qodef--stack" alt="g"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002.png 1300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002-300x269.png 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002-1024x917.png 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002-768x688.png 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002-1200x1074.png 1200w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002-600x537.png 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/Main-home-stacked-img-0002-800x716.png 800w"
                                                                sizes="(max-width: 1300px) 100vw, 1300px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-3e5530b elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
                                data-id="3e5530b" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-842512e"
                                        data-id="842512e" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-0bfcfb6 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="0bfcfb6" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title">
                                                            Tin tức mới nhất của Hana</h2>
                                                        <p class="qodef-m-subtitle">Đọc thêm những thông tin mới nhất về
                                                            Kính Mắt Hana</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-67a57bd elementor-widget elementor-widget-neoocular_core_blog_list"
                                                data-id="67a57bd" data-element_type="widget"
                                                data-widget_type="neoocular_core_blog_list.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-blog qodef--list qodef-item-layout--standard   qodef-grid qodef-layout--columns  qodef-gutter--normal qodef-col-num--3 qodef-item-layout--standard qodef--no-bottom-space qodef-pagination--off qodef-responsive--custom qodef-col-num--1440--3 qodef-col-num--1366--3 qodef-col-num--1024--1 qodef-col-num--768--1 qodef-col-num--680--1 qodef-col-num--480--1">
                                                        <div class="qodef-grid-inner clear">
                                                            @foreach ($latestNews as $news)
                                                                <article
                                                                    class="qodef-e qodef-blog-item qodef-grid-item qodef-item--full">
                                                                    <div class="qodef-e-inner">
                                                                        <div class="qodef-e-media">
                                                                            <div class="qodef-e-media-image">
                                                                                <a
                                                                                    href="{{ route('client.blog.show', $news->slug) }}">
                                                                                    <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('default-news.jpg') }}"
                                                                                        alt="{{ $news->title }}"
                                                                                        style="max-width:100%;height:auto;" />
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="qodef-e-content">
                                                                            <div class="qodef-e-top-holder">
                                                                                <div class="post-meta-custom"
                                                                                    style="display: flex; align-items: center; gap: 12px; font-size: 15px; color: #555; margin-bottom: 10px;">
                                                                                    <span>
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        {{ optional($news->published_at)->format('d/m/Y') }}
                                                                                    </span>
                                                                                    <span
                                                                                        style="font-size: 18px; color: #bbb;">&bull;</span>
                                                                                    <span>
                                                                                        <i class="fa fa-folder-open"></i>
                                                                                        {{ $news->category->name ?? '' }}
                                                                                    </span>
                                                                                    <span
                                                                                        style="font-size: 18px; color: #bbb;">&bull;</span>
                                                                                    <span>
                                                                                        <i class="fa fa-eye"></i>
                                                                                        {{ $news->views }} lượt xem
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="qodef-e-text">
                                                                                <h4 class="qodef-e-title entry-title">
                                                                                    <a
                                                                                        href="{{ route('client.blog.show', $news->slug) }}">{{ $news->title }}</a>
                                                                                </h4>
                                                                                <p class="qodef-e-excerpt">
                                                                                    {{ $news->summary }}</p>
                                                                            </div>
                                                                            <div class="qodef-e-bottom-holder">
                                                                                <div class="qodef-e-left">
                                                                                    <div class="qodef-e-read-more">
                                                                                        <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--textual  qodef-html--link "
                                                                                            href="{{ route('client.blog.show', $news->slug) }}"
                                                                                            target="_self">
                                                                                            <span class="qodef-m-text">Đọc
                                                                                                tiếp</span>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </article>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-c748857 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
                                data-id="c748857" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6fd8502"
                                        data-id="6fd8502" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-60b715f elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="60b715f" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title" style="color: #FFFFFF">
                                                            GHÉ THĂM INSTAGRAM CỦA CHÚNG TÔI </h2>
                                                        <p class="qodef-m-subtitle" style="color: #FFFFFF">Check our
                                                            bài viết mới nhất hiện nay</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-4028bf1 elementor-widget elementor-widget-neoocular_core_image_gallery"
                                                data-id="4028bf1" data-element_type="widget"
                                                data-widget_type="neoocular_core_image_gallery.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-image-gallery qodef-magnific-popup qodef-popup-gallery qodef-grid qodef-layout--columns  qodef-gutter--normal qodef-col-num--5  qodef-responsive--custom qodef-col-num--1440--5 qodef-col-num--1366--5 qodef-col-num--1024--3 qodef-col-num--768--2 qodef-col-num--680--1 qodef-col-num--480--1">
                                                        <div class="qodef-grid-inner clear">
                                                            <div class="qodef-e qodef-image-wrapper qodef-grid-item ">
                                                                <a class="qodef-popup-item" itemprop="image"
                                                                    href="wp-content/uploads/2023/11/gallery-img-01.jpg"
                                                                    data-type="image" title="d">
                                                                    <img loading="lazy" loading="lazy" decoding="async"
                                                                        width="800" height="791"
                                                                        src="wp-content/uploads/2023/11/gallery-img-01.jpg"
                                                                        class="attachment-full size-full" alt="d"
                                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-01.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-01-300x297.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-01-768x759.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-01-600x593.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-01-100x100.jpg 100w"
                                                                        sizes="(max-width: 800px) 100vw, 800px" />
                                                                </a>
                                                            </div>
                                                            <div class="qodef-e qodef-image-wrapper qodef-grid-item ">
                                                                <a class="qodef-popup-item" itemprop="image"
                                                                    href="wp-content/uploads/2023/11/gallery-img-02.jpg"
                                                                    data-type="image" title="d">
                                                                    <img loading="lazy" loading="lazy" decoding="async"
                                                                        width="800" height="791"
                                                                        src="wp-content/uploads/2023/11/gallery-img-02.jpg"
                                                                        class="attachment-full size-full" alt="d"
                                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-02.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-02-300x297.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-02-768x759.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-02-600x593.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-02-100x100.jpg 100w"
                                                                        sizes="(max-width: 800px) 100vw, 800px" />
                                                                </a>
                                                            </div>
                                                            <div class="qodef-e qodef-image-wrapper qodef-grid-item ">
                                                                <a class="qodef-popup-item" itemprop="image"
                                                                    href="wp-content/uploads/2023/11/gallery-img-03.jpg"
                                                                    data-type="image" title="d">
                                                                    <img loading="lazy" loading="lazy" decoding="async"
                                                                        width="800" height="791"
                                                                        src="wp-content/uploads/2023/11/gallery-img-03.jpg"
                                                                        class="attachment-full size-full" alt="d"
                                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-03.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-03-300x297.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-03-768x759.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-03-600x593.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-03-100x100.jpg 100w"
                                                                        sizes="(max-width: 800px) 100vw, 800px" />
                                                                </a>
                                                            </div>
                                                            <div class="qodef-e qodef-image-wrapper qodef-grid-item ">
                                                                <a class="qodef-popup-item" itemprop="image"
                                                                    href="wp-content/uploads/2023/11/gallery-img-04.jpg"
                                                                    data-type="image" title="d">
                                                                    <img loading="lazy" loading="lazy" decoding="async"
                                                                        width="800" height="791"
                                                                        src="wp-content/uploads/2023/11/gallery-img-04.jpg"
                                                                        class="attachment-full size-full" alt="d"
                                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-04.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-04-300x297.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-04-768x759.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-04-600x593.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-04-100x100.jpg 100w"
                                                                        sizes="(max-width: 800px) 100vw, 800px" />
                                                                </a>
                                                            </div>
                                                            <div class="qodef-e qodef-image-wrapper qodef-grid-item ">
                                                                <a class="qodef-popup-item" itemprop="image"
                                                                    href="wp-content/uploads/2023/11/gallery-img-05.jpg"
                                                                    data-type="image" title="d">
                                                                    <img loading="lazy" loading="lazy" decoding="async"
                                                                        width="800" height="791"
                                                                        src="wp-content/uploads/2023/11/gallery-img-05.jpg"
                                                                        class="attachment-full size-full" alt="d"
                                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-05.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-05-300x297.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-05-768x759.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-05-600x593.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2023/11/gallery-img-05-100x100.jpg 100w"
                                                                        sizes="(max-width: 800px) 100vw, 800px" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-9de3992 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="9de3992" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e976245"
                                        data-id="e976245" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-188a30d elementor-widget elementor-widget-neoocular_core_clients_list"
                                                data-id="188a30d" data-element_type="widget"
                                                data-widget_type="neoocular_core_clients_list.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-clients-list qodef-grid qodef-layout--columns  qodef-gutter--normal qodef-col-num--5 qodef-item-layout--image-only qodef-responsive--custom qodef-col-num--1440--5 qodef-col-num--1366--5 qodef-col-num--1024--5 qodef-col-num--768--5 qodef-col-num--680--1 qodef-col-num--480--1 qodef-hover-animation--fade-in">
                                                        <div class="qodef-grid-inner clear">
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" />
                                                                            </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-hover.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" />
                                                                            </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" />
                                                                            </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" />
                                                                            </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" />
                                                                            </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" />
                                                                            </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" />
                                                                            </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" />
                                                                            </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" />
                                                                            </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" />
                                                                            </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>
        </div><!-- close #qodef-page-inner div from header.php -->
    </div><!-- close #qodef-page-outer div from header.php -->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var slides = document.querySelectorAll('.main-banner-slide');
            var dots = document.querySelectorAll('.main-banner-dot');
            var current = 0;

            function showSlide(idx) {
                slides.forEach(function(slide, i) {
                    slide.style.display = (i === idx) ? 'block' : 'none';
                });
                dots.forEach(function(dot, i) {
                    dot.style.opacity = (i === idx) ? '1' : '0.5';
                });
                current = idx;
            }
            dots.forEach(function(dot, i) {
                dot.addEventListener('click', function() {
                    showSlide(i);
                });
            });
            // Auto slide
            setInterval(function() {
                var next = (current + 1) % slides.length;
                showSlide(next);
            }, 5000);
        });
    </script>
@endpush
