@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Câu hỏi thường gặp </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="{{ route('client.home') }}"><span itemprop="title">Trang chủ</span></a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Câu hỏi thường gặp</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-full-width">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div data-elementor-type="wp-page" data-elementor-id="4363" class="elementor elementor-4363">

                            <!-- FAQ Categories Section -->
                            @php
                                $categories = $faqs->groupBy('category');
                            @endphp

                            @foreach ($categories as $categoryName => $categoryFaqs)
                                <section
                                    class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default elementor-section-height-default qodef-elementor-content-no">
                                    <div class="elementor-container elementor-column-gap-default">
                                        <div
                                            class="elementor-column elementor-col-100 elementor-top-column elementor-element">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div
                                                    class="elementor-element elementor-widget elementor-widget-neoocular_core_section_title">
                                                    <div class="elementor-widget-container">
                                                        <div
                                                            class="qodef-shortcode qodef-m qodef-section-title qodef-alignment--left">
                                                            <h3 class="qodef-m-title">
                                                                {{ $categoryName }}
                                                            </h3>
                                                            <p class="qodef-m-subtitle">
                                                                {{ $categoryFaqs->count() }} câu hỏi về {{ $categoryName }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- FAQ Accordion Content for Category -->
                                <section
                                    class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default elementor-section-height-default qodef-elementor-content-no">
                                    <div class="elementor-container elementor-column-gap-default">
                                        <div
                                            class="elementor-column elementor-col-100 elementor-top-column elementor-element">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div
                                                    class="elementor-element elementor-widget elementor-widget-neoocular_core_accordion">
                                                    <div class="elementor-widget-container">
                                                        <div
                                                            class="qodef-shortcode qodef-m qodef-accordion clear qodef-behavior--accordion qodef-layout--simple">
                                                            @foreach ($categoryFaqs as $faq)
                                                                <h6 class="qodef-accordion-title">
                                                                    <span class="qodef-accordion-mark">
                                                                        <span class="qodef-icon--plus">+</span>
                                                                        <span class="qodef-icon--minus">-</span>
                                                                    </span>
                                                                    <span
                                                                        class="qodef-tab-title">{{ $faq->question }}</span>
                                                                </h6>
                                                                <div class="qodef-accordion-content">
                                                                    <div class="qodef-accordion-content-inner">
                                                                        {!! $faq->formatted_answer ?? $faq->answer !!}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endforeach

                            <!-- FAQ Image Section -->
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default elementor-section-height-default qodef-elementor-content-no">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div
                                                class="elementor-element elementor-widget elementor-widget-neoocular_core_single_image">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m qodef-single-image qodef-layout--default">
                                                        <div class="qodef-m-image">
                                                            <img fetchpriority="high" fetchpriority="high" decoding="async"
                                                                width="1405" height="645"
                                                                src="{{ asset('v1/wp-content/uploads/2021/08/Faq-page-img.jpg') }}"
                                                                class="attachment-full size-full qodef-list-image"
                                                                alt="FAQ HANA EYEWEAR"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/Faq-page-img.jpg 1405w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/Faq-page-img-600x275.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/Faq-page-img-800x367.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/Faq-page-img-300x138.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/Faq-page-img-1024x470.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/Faq-page-img-768x353.jpg 768w"
                                                                sizes="(max-width: 1405px) 100vw, 1405px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Contact Section -->
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-b14e991 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div
                                                class="elementor-element elementor-widget elementor-widget-neoocular_core_section_title">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m qodef-section-title qodef-alignment--center">
                                                        <h3 class="qodef-m-title">
                                                            <a itemprop="url" href="" target="_self">
                                                                "Không tìm thấy câu trả lời? Liên hệ với chúng tôi
                                                                ngay."</a>
                                                        </h3>
                                                        <p class="qodef-m-text" style="margin-top: 12px">Nếu bạn không tìm
                                                            thấy thông tin mình cần, hãy liên hệ với chúng tôi để được hỗ
                                                            trợ chi tiết và nhanh chóng.</p>
                                                        <div class="qodef-m-button">
                                                            <a class="qodef-shortcode qodef-m qodef-button qodef-layout--outlined qodef-size--small qodef-html--link"
                                                                href="{{ route('client.contact.index') }}" target="_self"
                                                                style="margin: 21px 0px;padding: 13px 70px"> <span
                                                                    class="qodef-m-text">Liên hệ chúng tôi</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Clients Section -->
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-3d6ca40 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div
                                                class="elementor-element elementor-widget elementor-widget-neoocular_core_clients_list">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m qodef-clients-list qodef-grid qodef-layout--columns qodef-gutter--normal qodef-col-num--5 qodef-item-layout--image-only qodef-responsive--custom qodef-col-num--1440--5 qodef-col-num--1366--5 qodef-col-num--1024--5 qodef-col-num--768--5 qodef-col-num--680--1 qodef-col-num--480--1 qodef-hover-animation--fade-in">
                                                        <div class="qodef-grid-inner clear">
                                                            <span class="qodef-e qodef-grid-item">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 1" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-hover.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 1 Hover" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 2" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 2 Hover" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 3" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 3 Hover" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 4" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 4 Hover" /> </span>
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qodef-e qodef-grid-item">
                                                                <span class="qodef-e-inner">
                                                                    <span class="qodef-e-image">
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 5" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img loading="lazy" loading="lazy"
                                                                                    decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-hover-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="Client 5 Hover" /> </span>
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
        </div>
    </div>
@endsection
