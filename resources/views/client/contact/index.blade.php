@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Liên hệ </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="{{ route('client.home') }}"><span itemprop="title">Home</span></a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">Liên hệ</span></div>
                </div>
            </div>
        </div>

        <div id="qodef-page-inner" class="qodef-content-full-width">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div data-elementor-type="wp-page" data-elementor-id="3396" class="elementor elementor-3396">
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-6afec47 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="6afec47" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4be3cdf"
                                        data-id="4be3cdf" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-e998359 elementor-widget elementor-widget-neoocular_core_section_title"
                                                data-id="e998359" data-element_type="widget"
                                                data-widget_type="neoocular_core_section_title.default">
                                                <div class="elementor-widget-container">
                                                    <div
                                                        class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                        <h2 class="qodef-m-title">
                                                            Liên hệ cho chúng tôi </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-64d5a65 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="64d5a65" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-66af7fd"
                                        data-id="66af7fd" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-d8fe16c elementor-widget elementor-widget-text-editor"
                                                data-id="d8fe16c" data-element_type="widget"
                                                data-widget_type="text-editor.default">
                                                <div class="elementor-widget-container">
                                                    <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn. Vui lòng liên hệ với chúng tôi
                                                        qua các thông tin dưới đây.</p>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-5527f0a elementor-widget elementor-widget-wp-widget-neoocular_core_contact_form_7"
                                                data-id="5527f0a" data-element_type="widget"
                                                data-widget_type="wp-widget-neoocular_core_contact_form_7.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-contact-form-7">

                                                        <div class="wpcf7 no-js" id="wpcf7-f690-p3396-o1" lang="en-US"
                                                            dir="ltr">
                                                            <div class="screen-reader-response">
                                                                <p role="status" aria-live="polite" aria-atomic="true"></p>
                                                                <ul></ul>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('client.contact.store') }}"
                                                                class="wpcf7-form init demo" aria-label="Contact form"
                                                                novalidate="novalidate" data-status="init">
                                                                @csrf
                                                                @if (session('success'))
                                                                    <div class="alert alert-success"
                                                                        style="background: #e6f9ed; border: 1.5px solid #2ecc71; color: #218c5a; font-weight: bold; display: flex; align-items: center; gap: 8px; font-size: 16px; padding: 12px 18px; border-radius: 6px; margin-bottom: 18px;">
                                                                        <span style="font-size: 22px;">&#10003;</span>
                                                                        <span>{{ session('success') }}</span>
                                                                    </div>
                                                                @endif
                                                                @if ($errors->any())
                                                                    @foreach ($errors->all() as $error)
                                                                        <div class="alert alert-danger"
                                                                            style="background: #ffeaea; border: 1.5px solid #e74c3c; color: #c0392b; font-weight: bold; display: flex; align-items: center; gap: 8px; font-size: 16px; padding: 12px 18px; border-radius: 6px; margin-bottom: 18px;">
                                                                            <span style="font-size: 22px;">&#9888;</span>
                                                                            <span>{{ $error }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                                <div style="display: none;">
                                                                    <input type="hidden" name="_wpcf7" value="690" />
                                                                    <input type="hidden" name="_wpcf7_version"
                                                                        value="5.9.8" />
                                                                    <input type="hidden" name="_wpcf7_locale"
                                                                        value="en_US" />
                                                                    <input type="hidden" name="_wpcf7_unit_tag"
                                                                        value="wpcf7-f690-p3396-o1" />
                                                                    <input type="hidden" name="_wpcf7_container_post"
                                                                        value="3396" />
                                                                    <input type="hidden" name="_wpcf7_posted_data_hash"
                                                                        value="" />
                                                                </div>
                                                                <div class="qodef-appointment-form">
                                                                    <p>
                                                                        <span class="wpcf7-form-control-wrap"
                                                                            data-name="name">
                                                                            <input size="40" maxlength="400"
                                                                                class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                                                aria-required="true" aria-invalid="false"
                                                                                placeholder="Tên của bạn (bắt buộc)"
                                                                                value="{{ old('name') }}" type="text"
                                                                                name="name" required />
                                                                            @error('name')
                                                                                <div class="text-danger"
                                                                                    style="color: red; font-size: 14px; text-align: left;">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </span>
                                                                        <span class="wpcf7-form-control-wrap"
                                                                            data-name="email">
                                                                            <input size="40" maxlength="400"
                                                                                class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email"
                                                                                aria-required="true" aria-invalid="false"
                                                                                placeholder="Email của bạn (bắt buộc)"
                                                                                value="{{ old('email') }}" type="email"
                                                                                name="email" required />
                                                                            @error('email')
                                                                                <div class="text-danger"
                                                                                    style="color: red; font-size: 14px; text-align: left;">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </span>
                                                                        <br />
                                                                        <span class="wpcf7-form-control-wrap"
                                                                            data-name="phone">
                                                                            <input size="40" maxlength="400"
                                                                                class="wpcf7-form-control wpcf7-text"
                                                                                aria-invalid="false"
                                                                                placeholder="Số điện thoại của bạn"
                                                                                value="{{ old('phone') }}" type="text"
                                                                                name="phone" />
                                                                            @error('phone')
                                                                                <div class="text-danger"
                                                                                    style="color: red; font-size: 14px; text-align: left;">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </span>
                                                                        <br />
                                                                        <span class="wpcf7-form-control-wrap"
                                                                            data-name="message">
                                                                            <textarea cols="40" rows="10" maxlength="2000" class="wpcf7-form-control wpcf7-textarea"
                                                                                aria-invalid="false" placeholder="Nội dung tin nhắn" name="message" required>{{ old('message') }}</textarea>
                                                                            @error('message')
                                                                                <div class="text-danger"
                                                                                    style="color: red; font-size: 14px; text-align: left;">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </span>
                                                                        <br />
                                                                        <button
                                                                            class="wpcf7-form-control wpcf7-submit qodef-button qodef-size--normal qodef-layout--filled qodef-m"
                                                                            type="submit">
                                                                            <span class="qodef-m-text">Gửi tin nhắn</span>
                                                                        </button>
                                                                    </p>
                                                                </div>
                                                                <div class="wpcf7-response-output" aria-hidden="true">
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
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-28a86fd qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                data-id="28a86fd" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-034646b"
                                        data-id="034646b" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-7fe33aa elementor-widget elementor-widget-neoocular_core_clients_list"
                                                data-id="7fe33aa" data-element_type="widget"
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
                                                                                <img decoding="async" width="170"
                                                                                    height="70"
                                                                                    src="{{ asset('v1/wp-content/uploads/2021/07/Client-01-1.png') }}"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img decoding="async" width="170"
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
                                                                        <a itemprop="url" href="#" target="_blank">
                                                                            <span class="qodef-e-logo">
                                                                                <img decoding="async" width="170"
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
                                                                        <a itemprop="url" href="#" target="_blank">
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
                                                                        <a itemprop="url" href="#" target="_blank">
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
                                                                        <a itemprop="url" href="#" target="_blank">
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
        </div>

    </div>
@endsection
