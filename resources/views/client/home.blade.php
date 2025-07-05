@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div class="qodef-content-full-width">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div data-elementor-type="wp-page" data-elementor-id="65" class="elementor elementor-65">
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-eb45484 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="eb45484" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e29fadd"
                                        data-id="e29fadd" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-eb51187 elementor-widget elementor-widget-slider_revolution"
                                                data-id="eb51187" data-element_type="widget"
                                                data-widget_type="slider_revolution.default">
                                                <div class="elementor-widget-container">

                                                    <div class="wp-block-themepunch-revslider">
                                                        <!-- START Main Home Main Rev REVOLUTION SLIDER 6.7.15 -->
                                                        <p class="rs-p-wp-fix"></p>
                                                        <rs-module-wrap id="rev_slider_9_1_wrapper" data-source="gallery"
                                                            style="visibility:hidden;background:transparent;padding:0;">
                                                            <rs-module id="rev_slider_9_1" style=""
                                                                data-version="6.7.15">
                                                                <rs-slides style="overflow: hidden; position: absolute;">
                                                                    @for ($i = 0; $i < count($sliders); $i += 2)
                                                                        <rs-slide style="position: absolute;"
                                                                            data-key="rs-{{ $i + 13 }}"
                                                                            data-title="{{ $sliders[$i]->title }}"
                                                                            data-anim="adpr:false;" data-in="o:0;"
                                                                            data-out="a:false;">
                                                                            <img decoding="async" src="{{ asset('') }}"
                                                                                alt="{{ $sliders[$i]->title }}"
                                                                                title="{{ $sliders[$i]->title }}"
                                                                                class="rev-slidebg tp-rs-img rs-lazyload"
                                                                                data-lazyload="" data-no-retina>

                                                                            @if (isset($sliders[$i]))
                                                                                <!-- Layer 0: Ảnh nhỏ trong ô trắng (sliderLeft) -->
                                                                                <rs-layer
                                                                                    id="slider-9-slide-{{ $i + 13 }}-layer-0"
                                                                                    data-type="image" data-rsp_ch="on"
                                                                                    data-xy="x:c;xo:-482px,-346px,0,0;y:m;yo:32px,29px,-24px,-28px;"
                                                                                    data-text="w:normal;s:20,16,8,4;l:0,21,11,6;"
                                                                                    data-dim="w:300px,280px,240px,200px;h:350px,320px,270px,220px;"
                                                                                    data-basealign="slide"
                                                                                    data-frame_0="y:50,42,22,11;"
                                                                                    data-frame_1="st:300;sp:1000;"
                                                                                    data-frame_999="o:0;st:w;"
                                                                                    style="z-index:20;">
                                                                                    <img decoding="async"
                                                                                        src="{{ asset('') }}"
                                                                                        alt="{{ $sliders[$i]->title }}"
                                                                                        class="tp-rs-img rs-lazyload"
                                                                                        width="300" height="350"
                                                                                        data-lazyload="{{ asset('storage/' . $sliders[$i]->image) }}"
                                                                                        data-no-retina>
                                                                                </rs-layer>
                                                                            @endif

                                                                            @if (isset($sliders[$i]))
                                                                                <!-- Layer 4: Main Image Left (bên trái) -->
                                                                                <rs-layer
                                                                                    id="slider-9-slide-{{ $i + 13 }}-layer-4"
                                                                                    data-type="image"
                                                                                    data-xy="x:l,l,c,c;xo:-15px,-15px,0,0;y:t,m,b,b;yo:0,0,-220px,-220px;"
                                                                                    data-text="w:normal;"
                                                                                    data-dim="w:50%,50%,1028px,1028px;h:auto,auto,1414px,1414px;"
                                                                                    data-basealign="slide" data-rsp_o="off"
                                                                                    data-rsp_bd="off"
                                                                                    data-frame_1="e:power4.inOut;sp:1000;"
                                                                                    data-frame_999="o:0;e:power2.in;st:w;sp:1000;"
                                                                                    style="z-index:9;">
                                                                                    <img decoding="async"
                                                                                        src="{{ asset('') }}"
                                                                                        alt="{{ $sliders[$i]->title }}"
                                                                                        class="tp-rs-img rs-lazyload"
                                                                                        width="945" height="1300"
                                                                                        data-lazyload="{{ asset('storage/' . $sliders[$i]->image) }}"
                                                                                        data-no-retina>
                                                                                </rs-layer>
                                                                            @endif

                                                                            @if (isset($sliders[$i + 1]))
                                                                                <!-- Layer 12: Main Image Right (bên phải) -->
                                                                                <rs-layer
                                                                                    id="slider-9-slide-{{ $i + 13 }}-layer-12"
                                                                                    data-type="image"
                                                                                    data-xy="x:r;xo:-15px,-15px,1054px,1054px;y:m;yo:0,0,-3px,-3px;"
                                                                                    data-text="w:normal;"
                                                                                    data-dim="w:['50%','50%','50%','50%'];"
                                                                                    data-vbility="t,t,f,f"
                                                                                    data-basealign="slide" data-rsp_o="off"
                                                                                    data-rsp_bd="off"
                                                                                    data-frame_1="e:power4.inOut;sp:1000;"
                                                                                    data-frame_999="o:0;e:power2.in;st:w;sp:1000;"
                                                                                    style="z-index:8;">
                                                                                    <img decoding="async"
                                                                                        src="{{ asset('') }}"
                                                                                        alt="{{ $sliders[$i + 1]->title }}"
                                                                                        class="tp-rs-img rs-lazyload"
                                                                                        width="945" height="1300"
                                                                                        data-lazyload="{{ asset('storage/' . $sliders[$i + 1]->image) }}"
                                                                                        data-no-retina>
                                                                                </rs-layer>
                                                                            @endif

                                                                            <!-- Layer 13: White Background Shape -->
                                                                            <rs-layer
                                                                                id="slider-9-slide-{{ $i + 13 }}-layer-13"
                                                                                data-type="shape"
                                                                                data-xy="x:c;xo:-481px,-345px,-1px,0;y:m;yo:71px,70px,19px,19px;"
                                                                                data-text="w:normal;"
                                                                                data-dim="w:400px,340px,340px,298px;h:540px,423px,423px,429px;"
                                                                                data-basealign="slide" data-rsp_o="off"
                                                                                data-rsp_bd="off" data-frame_0="y:50;"
                                                                                data-frame_1="st:300;sp:1000;"
                                                                                data-frame_999="o:0;st:w;"
                                                                                style="z-index:10;background-color:#ffffff;">
                                                                            </rs-layer>

                                                                            <!-- Layer 14: Title Text -->
                                                                            <rs-layer
                                                                                id="slider-9-slide-{{ $i + 13 }}-layer-14"
                                                                                data-type="text"
                                                                                data-xy="x:c;xo:484px,348px,662px,662px;y:m;yo:18px,20px,-18px,18px;"
                                                                                data-text="w:normal;s:42;l:64;fw:600;"
                                                                                data-vbility="t,t,f,f"
                                                                                data-basealign="slide" data-rsp_o="off"
                                                                                data-rsp_bd="off" data-frame_0="y:50;"
                                                                                data-frame_1="st:300;sp:1000;"
                                                                                data-frame_999="o:0;st:w;"
                                                                                style="z-index:19;font-family:'Work Sans';">
                                                                                {{ strtoupper($sliders[$i]->title) }}
                                                                            </rs-layer>

                                                                            <!-- Layer 15: Description Text -->
                                                                            <rs-layer
                                                                                id="slider-9-slide-{{ $i + 13 }}-layer-15"
                                                                                data-type="text"
                                                                                data-xy="x:c;xo:483px,347px,588px,588px;y:m;yo:62px,63px,42px,78px;"
                                                                                data-text="w:normal;s:18;l:26;fw:300;"
                                                                                data-vbility="t,t,f,f"
                                                                                data-basealign="slide" data-rsp_o="off"
                                                                                data-rsp_bd="off" data-frame_0="y:50;"
                                                                                data-frame_1="st:300;sp:1000;"
                                                                                data-frame_999="o:0;st:w;"
                                                                                style="z-index:14;font-family:'Heebo';">
                                                                                {{ $sliders[$i]->description }}
                                                                            </rs-layer>

                                                                            <!-- Layer 16: View More Button -->
                                                                            <rs-layer
                                                                                id="slider-9-slide-{{ $i + 13 }}-layer-16"
                                                                                data-type="text"
                                                                                data-xy="x:c;xo:552px,416px,619px,619px;y:m;yo:135px,136px,126px,162px;"
                                                                                data-text="w:normal;s:18;l:26;fw:300;"
                                                                                data-dim="w:341px;" data-vbility="t,t,f,f"
                                                                                data-basealign="slide" data-rsp_o="off"
                                                                                data-rsp_bd="off" data-frame_0="y:50;"
                                                                                data-frame_1="st:300;sp:1000;"
                                                                                data-frame_999="o:0;st:w;"
                                                                                style="z-index:13;font-family:'Heebo';">
                                                                                <a class="qodef-shortcode qodef-m qodef-button qodef-layout--outlined qodef-size--large qodef-html--link qodef-layout--custom"
                                                                                    href="{{ $sliders[$i]->url ?? '#' }}"
                                                                                    target="_self"
                                                                                    style="--qode-button-color: #FFFFFF;--qode-button-border-color: #FFFFFF;--qode-button-hover-color: #FFFFFF;--qode-button-hover-background-color: #1C1C1C;--qode-button-hover-border-color: #1C1C1C">
                                                                                    <span class="qodef-m-text">View
                                                                                        more</span>
                                                                                </a>
                                                                            </rs-layer>

                                                                            <!-- Layer 21: Book Now Button -->
                                                                            <rs-layer
                                                                                id="slider-9-slide-{{ $i + 13 }}-layer-21"
                                                                                data-type="text" data-color="#000000"
                                                                                data-xy="x:c;xo:-425px,-289px,55px,57px;y:m;yo:241px,215px,159px,162px;"
                                                                                data-text="w:normal;s:18;l:26;fw:300;"
                                                                                data-dim="w:201px;" data-basealign="slide"
                                                                                data-rsp_o="off" data-rsp_bd="off"
                                                                                data-frame_0="y:50;"
                                                                                data-frame_1="st:300;sp:1000;"
                                                                                data-frame_999="o:0;st:w;"
                                                                                style="z-index:12;font-family:'Heebo';">
                                                                                <a class="qodef-shortcode qodef-m qodef-button qodef-layout--textual qodef-html--link"
                                                                                    href="{{ $sliders[$i]->url ?? '#' }}"
                                                                                    target="_self">
                                                                                    <span class="qodef-m-text">Book
                                                                                        Now</span>
                                                                                </a>
                                                                            </rs-layer>
                                                                        </rs-slide>
                                                                    @endfor
                                                                </rs-slides>
                                                            </rs-module>
                                                            <script>
                                                                setREVStartSize({
                                                                    c: 'rev_slider_9_1',
                                                                    rl: [1920, 1700, 1025, 680],
                                                                    el: [900, 600, 820, 600],
                                                                    gw: [1300, 1100, 600, 300],
                                                                    gh: [900, 600, 820, 600],
                                                                    type: 'standard',
                                                                    justify: '',
                                                                    layout: 'fullscreen',
                                                                    offsetContainer: '',
                                                                    offset: '30px',
                                                                    mh: "0"
                                                                });
                                                                if (window.RS_MODULES !== undefined && window.RS_MODULES.modules !== undefined && window.RS_MODULES.modules[
                                                                        "revslider91"] !== undefined) {
                                                                    window.RS_MODULES.modules["revslider91"].once = false;
                                                                    window.revapi9 = undefined;
                                                                    if (window.RS_MODULES.checkMinimal !== undefined) window.RS_MODULES.checkMinimal();
                                                                }
                                                            </script>
                                                        </rs-module-wrap>
                                                        <!-- END REVOLUTION SLIDER -->
                                                    </div>
                                                </div>
                                            </div>
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
                                                                    class="qodef-e qodef-grid-item qodef-item--full product type-product post-{{ $product->id }} status-publish {{ $product->total_stock_quantity > 0 ? 'instock' : 'outofstock' }} has-post-thumbnail {{ $product->sale_price && $product->sale_price < $product->price ? 'sale' : '' }} shipping-taxable purchasable product-type-{{ $product->product_type }}">
                                                                    <div class="qodef-e-inner">
                                                                        <div class="qodef-woo-product-image">
                                                                            @if ($product->sale_price && $product->sale_price < $product->price)
                                                                                <span
                                                                                    class="qodef-woo-product-mark qodef-woo-onsale">Sale</span>
                                                                            @endif
                                                                            @php
                                                                                $featuredImage =
                                                                                    $product->images
                                                                                        ->where('is_featured', true)
                                                                                        ->first() ??
                                                                                    $product->images->first();
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
                                                                                @if ($product->sale_price && $product->sale_price < $product->price)
                                                                                    <del aria-hidden="true">
                                                                                        <span
                                                                                            class="woocommerce-Price-amount amount">
                                                                                            <bdi>{{ number_format($product->price, 0, ',', '.') }}đ</bdi>
                                                                                        </span>
                                                                                    </del>
                                                                                    <span class="screen-reader-text">Giá
                                                                                        gốc:
                                                                                        {{ number_format($product->price, 0, ',', '.') }}đ.</span>
                                                                                    <ins aria-hidden="true">
                                                                                        <span
                                                                                            class="woocommerce-Price-amount amount">
                                                                                            <bdi>{{ number_format($product->sale_price, 0, ',', '.') }}đ</bdi>
                                                                                        </span>
                                                                                    </ins>
                                                                                    <span class="screen-reader-text">Giá
                                                                                        khuyến mãi:
                                                                                        {{ number_format($product->sale_price, 0, ',', '.') }}đ.</span>
                                                                                @else
                                                                                    <span
                                                                                        class="woocommerce-Price-amount amount">
                                                                                        <bdi>{{ number_format($product->price ?? 0, 0, ',', '.') }}đ</bdi>
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
                                                                            Blue light optical lens </h3>
                                                                        <p class="qodef-m-subtitle"
                                                                            style="margin-top: 11px">Lorem
                                                                            ipsum
                                                                            dolore amet, vivid vel risus sit</p>
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
                                                                                <span class="qodef-m-title-text">Cras
                                                                                    sodales odio non libero
                                                                                    tincidunt amet</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Lorem ipsum
                                                                                dolor sit amet, consectetur sit do
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
                                                                                <span class="qodef-m-title-text">Amet
                                                                                    lorem ipsum sodales odio vivid
                                                                                    sit mor</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Lorem ipsum
                                                                                dolor sit amet, consectetur del sint
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
                                                                            Blue light optical lens </h3>
                                                                        <p class="qodef-m-subtitle"
                                                                            style="margin-top: 11px">Lorem
                                                                            ipsum
                                                                            dolore amet, vivid vel risus sit</p>
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
                                                                                <span class="qodef-m-title-text">Cras
                                                                                    sodales odio non libero
                                                                                    tincidunt amet</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Lorem ipsum
                                                                                dolor sit amet, consectetur sit do
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
                                                                                <span class="qodef-m-title-text">Amet
                                                                                    lorem ipsum sodales odio vivid
                                                                                    sit mor</span>
                                                                            </h6>
                                                                            <p class="qodef-m-text"
                                                                                style="margin-top: 5px">
                                                                                Lorem ipsum
                                                                                dolor sit amet, consectetur del sint
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
                                                                        <span class="qodef-m-text">View more</span>
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
                                class="elementor-section elementor-top-section elementor-element elementor-element-9c02104 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="9c02104" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-c70d838"
                                        data-id="c70d838" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-b86ec9c elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="b86ec9c" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title">
                                                            Online shop services </h2>
                                                        <p class="qodef-m-subtitle" style="margin-top: 12px">Our
                                                            entire offer is only just one click away</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-777c3be elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="777c3be" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-bd31d83"
                                        data-id="bd31d83" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-0849f51 elementor-widget elementor-widget-neoocular_core_banner"
                                                data-id="0849f51" data-element_type="widget"
                                                data-widget_type="neoocular_core_banner.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-banner qodef-layout--link-button">
                                                        <div class="qodef-m-image">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1100" height="1165"
                                                                src="{{ asset('v1/wp-content/uploads/2021/08/main-home-banner-01.jpg') }}"
                                                                class="attachment-full size-full" alt="m"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-01.jpg 1100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-01-600x635.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-01-800x847.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-01-283x300.jpg 283w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-01-967x1024.jpg 967w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-01-768x813.jpg 768w"
                                                                sizes="(max-width: 1100px) 100vw, 1100px" />
                                                        </div>
                                                        <div class="qodef-m-content">
                                                            <div class="qodef-m-content-inner">
                                                                <h3 class="qodef-m-title"
                                                                    style="margin-top: 0px;color: #FFFFFF">
                                                                    quality standards </h3>
                                                                <p class="qodef-m-text" style="color: #FFFFFF">
                                                                    View all our frames and diiscover your perfect
                                                                    match </p>
                                                                <div class="qodef-m-button">
                                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined qodef-size--small qodef-html--link qodef-layout--custom"
                                                                        href="vouchers/index.html" target="_self"
                                                                        style="--qode-button-color: #FFFFFF;--qode-button-border-color: #FFFFFF;--qode-button-hover-color: #FFFFFF;--qode-button-hover-background-color: #1C1C1C;--qode-button-hover-border-color: #1C1C1C">
                                                                        <span class="qodef-m-text">View
                                                                            more</span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-3ab629e"
                                        data-id="3ab629e" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-03f029d elementor-widget elementor-widget-neoocular_core_banner"
                                                data-id="03f029d" data-element_type="widget"
                                                data-widget_type="neoocular_core_banner.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-banner qodef-layout--link-button">
                                                        <div class="qodef-m-image">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1100" height="1165"
                                                                src="{{ asset('v1/wp-content/uploads/2021/08/main-home-banner-02.jpg') }}"
                                                                class="attachment-full size-full" alt="m"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-02.jpg 1100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-02-600x635.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-02-800x847.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-02-283x300.jpg 283w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-02-967x1024.jpg 967w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/main-home-banner-02-768x813.jpg 768w"
                                                                sizes="(max-width: 1100px) 100vw, 1100px" />
                                                        </div>
                                                        <div class="qodef-m-content">
                                                            <div class="qodef-m-content-inner">
                                                                <h3 class="qodef-m-title" style="color: #FFFFFF">
                                                                    Professional team </h3>
                                                                <p class="qodef-m-text" style="color: #FFFFFF">
                                                                    Get expert lens advice from our eyecare
                                                                    specialists </p>
                                                                <div class="qodef-m-button">
                                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined qodef-size--small qodef-html--link qodef-layout--custom"
                                                                        href="our-staff/index.html" target="_self"
                                                                        style="--qode-button-color: #FFFFFF;--qode-button-border-color: #FFFFFF;--qode-button-hover-color: #FFFFFF;--qode-button-hover-background-color: #1C1C1C;--qode-button-hover-border-color: #1C1C1C">
                                                                        <span class="qodef-m-text">View
                                                                            more</span></a>
                                                                </div>
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
                                class="elementor-section elementor-top-section elementor-element elementor-element-bf4a0e9 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="bf4a0e9" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-d0cae89"
                                        data-id="d0cae89" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-1ca86ee elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="1ca86ee" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                        <h2 class="qodef-m-title">
                                                            Book a meeting now </h2>
                                                        <p class="qodef-m-subtitle" style="margin-top: 11px">Book
                                                            your term online fast and easy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-19c8ff7 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="19c8ff7" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-c207b20"
                                        data-id="c207b20" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-ec4b266 elementor-widget elementor-widget-neoocular_core_single_image"
                                                data-id="ec4b266" data-element_type="widget"
                                                data-widget_type="neoocular_core_single_image.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                        <div class="qodef-m-image">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1100" height="826"
                                                                src="{{ asset('v1/wp-content/uploads/2021/07/h3-image-w-text-01.jpg') }}"
                                                                class="attachment-full size-full qodef-list-image"
                                                                alt="m"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-01.jpg 1100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-01-600x451.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-01-800x601.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-01-300x225.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-01-1024x769.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-01-768x577.jpg 768w"
                                                                sizes="(max-width: 1100px) 100vw, 1100px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-13c14a7 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="13c14a7" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                        <h4 class="qodef-m-title">
                                                            Comprehensive eye exams </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-94a8579 elementor-widget elementor-widget-neoocular_core_icon_list_item"
                                                data-id="94a8579" data-element_type="widget"
                                                data-widget_type="neoocular_core_icon_list_item.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-icon-list-item qodef-icon--icon-pack">
                                                        <p class="qodef-e-title">
                                                            <span class="qodef-e-title-inner">
                                                                <span
                                                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                                                    style="margin: 0px 11px 0px 0px"> <span
                                                                        class="qodef-icon-elegant-icons icon_check_alt2 qodef-icon qodef-e"
                                                                        style="color: #1C1C1C;font-size: 18px"></span>
                                                                </span> <span class="qodef-e-title-text"> Lorem
                                                                    ipsum dolor sit amet, vivir elit purss</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-c547cb5 elementor-widget elementor-widget-neoocular_core_icon_list_item"
                                                data-id="c547cb5" data-element_type="widget"
                                                data-widget_type="neoocular_core_icon_list_item.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-icon-list-item qodef-icon--icon-pack">
                                                        <p class="qodef-e-title">
                                                            <span class="qodef-e-title-inner">
                                                                <span
                                                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                                                    style="margin: 0px 11px 0px 0px"> <span
                                                                        class="qodef-icon-elegant-icons icon_check_alt2 qodef-icon qodef-e"
                                                                        style="color: #1C1C1C;font-size: 18px"></span>
                                                                </span> <span class="qodef-e-title-text">Consequat
                                                                    dolor duis, consectetur </span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-c92a7fd elementor-widget elementor-widget-neoocular_core_icon_list_item"
                                                data-id="c92a7fd" data-element_type="widget"
                                                data-widget_type="neoocular_core_icon_list_item.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-icon-list-item qodef-icon--icon-pack">
                                                        <p class="qodef-e-title">
                                                            <span class="qodef-e-title-inner">
                                                                <span
                                                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                                                    style="margin: 0px 11px 0px 0px"> <span
                                                                        class="qodef-icon-elegant-icons icon_close_alt2 qodef-icon qodef-e"
                                                                        style="color: #1C1C1C;font-size: 18px"></span>
                                                                </span> <span class="qodef-e-title-text">Nostrum
                                                                    vivid, dolor lorem ipsum aliquiam</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-f15238a elementor-widget elementor-widget-neoocular_core_button"
                                                data-id="f15238a" data-element_type="widget"
                                                data-widget_type="neoocular_core_button.default">
                                                <div class="elementor-widget-container">
                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined  qodef-html--link "
                                                        href="book-an-appointment/index.html" target="_self">
                                                        <span class="qodef-m-text">Book appointment</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-c1ddb11"
                                        data-id="c1ddb11" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-f9c6453 elementor-widget elementor-widget-neoocular_core_single_image"
                                                data-id="f9c6453" data-element_type="widget"
                                                data-widget_type="neoocular_core_single_image.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                        <div class="qodef-m-image">
                                                            <img loading="lazy" loading="lazy" decoding="async"
                                                                width="1100" height="826"
                                                                src="wp-content/uploads/2021/07/h3-image-w-text-02.jpg"
                                                                class="attachment-full size-full qodef-list-image"
                                                                alt="m"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-02.jpg 1100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-02-600x451.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-02-800x601.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-02-300x225.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-02-1024x769.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h3-image-w-text-02-768x577.jpg 768w"
                                                                sizes="(max-width: 1100px) 100vw, 1100px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-513226d elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="513226d" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                        <h4 class="qodef-m-title">
                                                            Book your exam online </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-e4f5ca9 elementor-widget elementor-widget-neoocular_core_icon_list_item"
                                                data-id="e4f5ca9" data-element_type="widget"
                                                data-widget_type="neoocular_core_icon_list_item.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-icon-list-item qodef-icon--icon-pack">
                                                        <p class="qodef-e-title">
                                                            <span class="qodef-e-title-inner">
                                                                <span
                                                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                                                    style="margin: 0px 11px 0px 0px"> <span
                                                                        class="qodef-icon-elegant-icons icon_check_alt2 qodef-icon qodef-e"
                                                                        style="color: #1C1C1C;font-size: 18px"></span>
                                                                </span> <span class="qodef-e-title-text"> Duis aute
                                                                    irure dolor in reprehenderit in</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-ae4d183 elementor-widget elementor-widget-neoocular_core_icon_list_item"
                                                data-id="ae4d183" data-element_type="widget"
                                                data-widget_type="neoocular_core_icon_list_item.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-icon-list-item qodef-icon--icon-pack">
                                                        <p class="qodef-e-title">
                                                            <span class="qodef-e-title-inner">
                                                                <span
                                                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                                                    style="margin: 0px 11px 0px 0px"> <span
                                                                        class="qodef-icon-elegant-icons icon_check_alt2 qodef-icon qodef-e"
                                                                        style="color: #1C1C1C;font-size: 18px"></span>
                                                                </span> <span class="qodef-e-title-text">Excepteur
                                                                    sint occaecat cupidatat</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-e720f15 elementor-widget elementor-widget-neoocular_core_icon_list_item"
                                                data-id="e720f15" data-element_type="widget"
                                                data-widget_type="neoocular_core_icon_list_item.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-icon-list-item qodef-icon--icon-pack">
                                                        <p class="qodef-e-title">
                                                            <span class="qodef-e-title-inner">
                                                                <span
                                                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                                                    style="margin: 0px 11px 0px 0px"> <span
                                                                        class="qodef-icon-elegant-icons icon_check_alt2 qodef-icon qodef-e"
                                                                        style="color: #1C1C1C;font-size: 18px"></span>
                                                                </span> <span class="qodef-e-title-text">Officia
                                                                    deserunt mollit animest laborum</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-de1e032 elementor-widget elementor-widget-neoocular_core_button"
                                                data-id="de1e032" data-element_type="widget"
                                                data-widget_type="neoocular_core_button.default">
                                                <div class="elementor-widget-container">
                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined  qodef-html--link "
                                                        href="book-an-appointment/index.html" target="_self">
                                                        <span class="qodef-m-text">Book appointment</span>
                                                    </a>
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
                                                                            Book appointment </h2>
                                                                        <p class="qodef-m-subtitle"
                                                                            style="margin-top: 12px">Get
                                                                            professional assistance the simplest way
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
                                                                                                placeholder="Type question"
                                                                                                value=""
                                                                                                type="text"
                                                                                                name="your-text" /></span><button
                                                                                            class="wpcf7-form-control wpcf7-submit qodef-button qodef-size--normal qodef-layout--filled qodef-m"
                                                                                            type="submit"><span
                                                                                                class="qodef-m-text">send
                                                                                                now</span></button>
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
                                                            Autumn / winter shop 2021 </h3>
                                                        <p class="qodef-m-subtitle" style="margin-top: 12px">Lorem
                                                            ipsum dolore amet, vel consectetur risus</p>
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
                                                            <span class="qodef-tab-title">Explore new collection of
                                                                glasses in our online shop</span>
                                                        </h6>
                                                        <div class="qodef-accordion-content">
                                                            <div class="qodef-accordion-content-inner">
                                                                <p>Nullam vitae eros nisi. Vestibulum non purus
                                                                    vitae massa mollis sagittis vesti bulum.</p>
                                                            </div>
                                                        </div>
                                                        <h6 class="qodef-accordion-title">
                                                            <span class="qodef-accordion-mark">
                                                                <span class="qodef-icon--plus">+</span>
                                                                <span class="qodef-icon--minus">-</span>
                                                            </span>
                                                            <span class="qodef-tab-title">Unique items with
                                                                ergonomic design style</span>
                                                        </h6>
                                                        <div class="qodef-accordion-content">
                                                            <div class="qodef-accordion-content-inner">
                                                                <p>Nullam vitae eros nisi. Vestibulum non purus
                                                                    vitae massa mollis sagittis vesti bulum.</p>
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
                                                                src="wp-content/uploads/2021/10/main-home-img-stacked-02.jpg"
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
                                                            Visit our instagram </h2>
                                                        <p class="qodef-m-subtitle" style="color: #FFFFFF">Check our
                                                            lastest posts now</p>
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
                                                                    <img loading="lazy" loading="lazy"
                                                                        decoding="async" width="800" height="791"
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
                                                                        <a itemprop="url" href="#"
                                                                            target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-hover.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#"
                                                                            target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#"
                                                                            target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#"
                                                                            target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item ">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#"
                                                                            target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
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
        // Khởi tạo slider revolution sau khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof setREVStartSize !== 'undefined') {
                setREVStartSize({
                    c: 'rev_slider_9_1',
                    rl: [1920, 1700, 1025, 680],
                    el: [900, 600, 820, 600],
                    gw: [1300, 1100, 600, 300],
                    gh: [900, 600, 820, 600],
                    type: 'standard',
                    justify: '',
                    layout: 'fullscreen',
                    offsetContainer: '',
                    offset: '30px',
                    mh: "0"
                });
            }

            // Hiển thị slider sau khi khởi tạo
            setTimeout(function() {
                var sliderWrapper = document.getElementById('rev_slider_9_1_wrapper');
                if (sliderWrapper) {
                    sliderWrapper.style.visibility = 'visible';
                }
            }, 1000);
        });
    </script>
@endpush
