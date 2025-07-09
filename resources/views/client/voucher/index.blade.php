@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Mã giảm giá </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="{{ route('client.home') }}"><span itemprop="title">Home</span></a>
                            <span class="qodef-breadcrumbs-separator"></span>
                            <span itemprop="title" class="qodef-breadcrumbs-current">Page</span>
                            <span itemprop="title" class="qodef-breadcrumbs-separator"></span>
                            <span itemprop="title" class="qodef-breadcrumbs-current">Mã giảm giá</span></div>

                    {{-- Danh sách mã giảm giá --}}
                    <div class="voucher-list" style="margin-top: 32px;">
                        @forelse($vouchers as $voucher)
                            <div class="voucher-item" style="border:1px solid #eee; border-radius:8px; padding:16px; margin-bottom:16px; background:#fafbfc;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <div><strong>{{ $voucher->name }}</strong> <span style="color:#888;">({{ $voucher->code }})</span></div>
                                        <div>{{ $voucher->description }}</div>
                                        <div>
                                            <span>Giảm:
                                                @if($voucher->discount_type === 'percentage')
                                                    {{ $voucher->discount_value }}%
                                                @else
                                                    {{ number_format($voucher->discount_value, 0) }}đ
                                                @endif
                                            </span>
                                            <span style="margin-left:16px;">Đơn tối thiểu: {{ number_format($voucher->minimum_purchase, 0) }}đ</span>
                                        </div>
                                        <div>HSD: {{ $voucher->end_date->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div style="min-width:180px; text-align:center;">
                                        <div class="voucher-countdown" data-end="{{ $voucher->end_date->format('Y-m-d H:i:s') }}" style="font-size:18px; color:#e74c3c; font-weight:bold;"></div>
                                        <div style="font-size:12px; color:#888;">Còn lại</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div>Hiện không có mã giảm giá nào.</div>
                        @endforelse
                    </div>
                </div>  
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-full-width">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div data-elementor-type="wp-page" data-elementor-id="3964" class="elementor elementor-3964">
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-b38fcf2 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="b38fcf2" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-ad7d6ff"
                                        data-id="ad7d6ff" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-d1cda19 elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="d1cda19" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-605 qodef-layout--simple"
                                                        style="color: #FFFFFF">
                                                        FREE GIFT BAG -</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-b158005"
                                        data-id="b158005" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-49e8d16 elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="49e8d16" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <p class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-822 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Heebo">
                                                        With every frame</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-6afec47 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="6afec47" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-0327199"
                                        data-id="0327199" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-34d50d1 elementor-widget elementor-widget-neoocular_core_single_image"
                                                data-id="34d50d1" data-element_type="widget"
                                                data-widget_type="neoocular_core_single_image.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                        <div class="qodef-m-image">
                                                            <a itemprop="url" href="../product/way-glasses/index.html"
                                                                target="_self">
                                                                <img fetchpriority="high" fetchpriority="high"
                                                                    decoding="async" width="900" height="593"
                                                                    src="../wp-content/uploads/2021/08/voucher-01-img.jpg"
                                                                    class="attachment-full size-full qodef-list-image"
                                                                    alt="m"
                                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img.jpg 900w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-600x395.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-800x527.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-300x198.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-768x506.jpg 768w"
                                                                    sizes="(max-width: 900px) 100vw, 900px" /> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-3a43075"
                                        data-id="3a43075" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-b2b3f48 elementor-widget elementor-widget-neoocular_core_single_image"
                                                data-id="b2b3f48" data-element_type="widget"
                                                data-widget_type="neoocular_core_single_image.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                        <div class="qodef-m-image">
                                                            <a itemprop="url" href="../shop/index.html" target="_self">
                                                                <img decoding="async" width="900" height="593"
                                                                    src="../wp-content/uploads/2021/08/voucher-img-02.jpg"
                                                                    class="attachment-full size-full qodef-list-image"
                                                                    alt="m"
                                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02.jpg 900w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-600x395.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-800x527.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-300x198.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-768x506.jpg 768w"
                                                                    sizes="(max-width: 900px) 100vw, 900px" /> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-8991627"
                                        data-id="8991627" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-0fe844c elementor-widget elementor-widget-neoocular_core_single_image"
                                                data-id="0fe844c" data-element_type="widget"
                                                data-widget_type="neoocular_core_single_image.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                        <div class="qodef-m-image">
                                                            <a itemprop="url" href="../variable-product-list/index.html"
                                                                target="_self">
                                                                <img decoding="async" width="900" height="593"
                                                                    src="../wp-content/uploads/2021/08/voucher-img-03.jpg"
                                                                    class="attachment-full size-full qodef-list-image"
                                                                    alt="m"
                                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03.jpg 900w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-600x395.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-800x527.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-300x198.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-768x506.jpg 768w"
                                                                    sizes="(max-width: 900px) 100vw, 900px" /> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-845692c qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="845692c" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-b2c4a56"
                                        data-id="b2c4a56" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-5d12e18 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="5d12e18" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title">
                                                            The best offers for you </h2>
                                                        <p class="qodef-m-text" style="margin-top: 12px">Diam
                                                            volutpat commodo sed egestas egestas fringilla
                                                            phasellus. Augue eget arcu dictum varius duis at
                                                            consectetur lorem. Mauris nunc congue nisi vitae. Purus
                                                            in mollis nunc sed. Eu mi bibendum neque egestas congue
                                                            quisque egestas diam in neque convallis </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-56fd60e elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="56fd60e" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-00e36d7"
                                        data-id="00e36d7" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-1d9f469 elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="1d9f469" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <h1 class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-355 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Work sans;font-size: 100px;line-height: 64px;letter-spacing: 0.01em;font-weight: 100;font-style: normal">
                                                        Sale</h1>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-19cdae0 elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="19cdae0" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <h1 class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-444 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Work sans;font-size: 100px;line-height: 64px;letter-spacing: 0.01em;font-weight: 500">
                                                        70%</h1>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-38fc587 elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="38fc587" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <p class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-573 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Heebo;font-size: 19px;line-height: 25px;letter-spacing: 0px;font-weight: 300">
                                                        Sale up to 70% on new items.</p>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-c4f7adc elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_button"
                                                data-id="c4f7adc" data-element_type="widget"
                                                data-widget_type="neoocular_core_button.default">
                                                <div class="elementor-widget-container">
                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined qodef-size--large qodef-html--link qodef-layout--custom"
                                                        href="../product/green-pilot/index.html" target="_self"
                                                        style="--qode-button-color: #FFFFFF;--qode-button-border-color: #FFFFFF;--qode-button-hover-color: #FFFFFF;--qode-button-hover-background-color: #1C1C1C;--qode-button-hover-border-color: #1C1C1C">
                                                        <span class="qodef-m-text">Shop now</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-d43ee65"
                                        data-id="d43ee65" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-a4770b6 elementor-widget-mobile__width-auto elementor-widget__width-inherit elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="a4770b6" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <h1 class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-543 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Work sans;font-size: 100px;line-height: 64px;letter-spacing: 0.01em;font-weight: 100;font-style: normal">
                                                        Virtual</h1>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-7a371c1 elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="7a371c1" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <h1 class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-379 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Work sans;font-size: 100px;line-height: 64px;letter-spacing: 0.01em;font-weight: 500">
                                                        Try-On</h1>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-991f4a8 elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_custom_font"
                                                data-id="991f4a8" data-element_type="widget"
                                                data-widget_type="neoocular_core_custom_font.default">
                                                <div class="elementor-widget-container">
                                                    <p class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-822 qodef-layout--simple"
                                                        style="color: #FFFFFF;font-family: Heebo;font-size: 19px;line-height: 25px;letter-spacing: 0px;font-weight: 300">
                                                        Sale up to 70% on new items.</p>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-2bf73f9 elementor-widget-mobile__width-auto elementor-widget elementor-widget-neoocular_core_button"
                                                data-id="2bf73f9" data-element_type="widget"
                                                data-widget_type="neoocular_core_button.default">
                                                <div class="elementor-widget-container">
                                                    <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined qodef-size--large qodef-html--link qodef-layout--custom"
                                                        href="../product-carousel/index.html" target="_self"
                                                        style="--qode-button-color: #FFFFFF;--qode-button-border-color: #FFFFFF;--qode-button-hover-color: #FFFFFF;--qode-button-hover-background-color: #1C1C1C;--qode-button-hover-border-color: #1C1C1C">
                                                        <span class="qodef-m-text">Shop now</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-e01bcfe qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="e01bcfe" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-12c2509"
                                        data-id="12c2509" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-eb27cc3 elementor-widget elementor-widget-neoocular_core_clients_list"
                                                data-id="eb27cc3" data-element_type="widget"
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
                                                                                    src="../wp-content/uploads/2021/07/Client-01-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="../wp-content/uploads/2021/07/Client-01-hover.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
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
                                                                                    src="../wp-content/uploads/2021/07/Client-02-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="../wp-content/uploads/2021/07/Client-02-hover-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
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
                                                                                    src="../wp-content/uploads/2021/07/Client-03-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="../wp-content/uploads/2021/07/Client-03-hover-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
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
                                                                                    src="../wp-content/uploads/2021/07/Client-04-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="../wp-content/uploads/2021/07/Client-04-hover-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="h" /> </span>
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
                                                                                    src="../wp-content/uploads/2021/07/Client-05-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="../wp-content/uploads/2021/07/Client-05-hover-1.png"
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
    </div>
@endsection

@section('scripts')
<script>
    function startCountdown() {
        document.querySelectorAll('.voucher-countdown').forEach(function(el) {
            var end = new Date(el.getAttribute('data-end').replace(/-/g, '/')).getTime();
            function updateCountdown() {
                var now = new Date().getTime();
                var distance = end - now;
                if (distance < 0) {
                    el.innerHTML = 'Đã hết hạn';
                    return;
                }
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                el.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
                setTimeout(updateCountdown, 1000);
            }
            updateCountdown();
        });
    }
    document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endsection
