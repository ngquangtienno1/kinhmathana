@extends('client.layouts.app')

@section('content')
<style>
    .qodef-search-form {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .qodef-search-form-inner {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .qodef-search-form-field {
        flex: 1;
        min-width: 200px;
    }

    .qodef-search-form-input,
    .qodef-search-form-select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .qodef-search-form-submit {
        background: #007bff;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
    }

    .qodef-search-form-submit:hover {
        background: #0056b3;
    }

    .qodef-category-badge {
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        color: #495057;
    }

    /* FAQ Item Styles */
    .faq-item {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .faq-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .faq-question {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
        color: #333;
    }

    .faq-question:hover {
        background-color: #f8f9fa;
    }

    .faq-icon {
        font-size: 18px;
        color: #007bff;
        transition: transform 0.3s ease;
    }

    .faq-item:hover .faq-icon {
        transform: scale(1.1);
    }

    /* Đơn giản hóa modal FAQ */
    .faq-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.15);
    }

    .faq-modal-content {
        background: #fff;
        margin: 4% auto;
        border-radius: 10px;
        border: 1px solid #222;
        width: 98%;
        max-width: 720px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: none;
        padding: 0;
        position: relative;
        font-family: inherit;
    }

    .faq-modal-header {
        padding: 28px 40px 12px 40px;
        border-bottom: 1px solid #eee;
        background: #fff;
        border-radius: 10px 10px 0 0;
        position: relative;
    }

    .faq-modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #111;
        margin: 0 0 4px 0;
        text-transform: none;
        letter-spacing: 0;
        line-height: 1.3;
    }

    .faq-modal-category {
        display: inline-block;
        border: 1px solid #222;
        border-radius: 6px;
        padding: 2px 10px;
        font-size: 13px;
        color: #111;
        background: #fff;
        margin-top: 4px;
        font-weight: 500;
    }

    .faq-modal-close {
        position: absolute;
        top: 22px;
        right: 32px;
        width: 32px;
        height: 32px;
        font-size: 18px;
        font-weight: 700;
        color: #222;
        cursor: pointer;
        background: #fff;
        border: none;
        border-radius: 50%;
        outline: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, color 0.15s;
    }

    .faq-modal-close:hover {
        background: #f2f2f2;
        color: #000;
    }

    .faq-modal-body {
        padding: 28px 40px 32px 40px;
        color: #222;
        font-size: 18px;
        line-height: 1.7;
        background: #fff;
        max-height: 500px;
        overflow-y: auto;
    }

    .faq-modal-footer {
        padding: 16px 40px 22px 40px;
        border-top: 1px solid #eee;
        background: #fff;
        border-radius: 0 0 10px 10px;
        text-align: right;
    }

    .faq-modal-footer .btn {
        background: #fff;
        color: #111;
        border: 1px solid #222;
        padding: 7px 22px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        transition: background 0.15s, color 0.15s;
        text-decoration: none;
        display: inline-block;
    }

    .faq-modal-footer .btn:hover {
        background: #111;
        color: #fff;
    }

    @media (max-width: 900px) {
        .faq-modal-content {
            max-width: 99vw;
            margin: 10% auto;
        }

        .faq-modal-header,
        .faq-modal-body,
        .faq-modal-footer {
            padding-left: 12px;
            padding-right: 12px;
        }

        .faq-modal-title {
            font-size: 18px;
        }

        .faq-modal-body {
            font-size: 15px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // FAQ Modal functionality
    const faqItems = document.querySelectorAll('.faq-item');
    const modal = document.getElementById('faqModal');
    const modalTitle = document.getElementById('faqModalTitle');
    const modalCategory = document.getElementById('faqModalCategory');
    const modalBody = document.getElementById('faqModalBody');
    const closeBtn = document.querySelector('.faq-modal-close');
    const closeModalBtn = document.querySelector('.faq-modal-footer .btn');

        // Open modal when clicking on FAQ item
    faqItems.forEach(item => {
        item.addEventListener('click', function() {
            const question = this.getAttribute('data-question');
            const answer = this.getAttribute('data-answer');
            const category = this.getAttribute('data-category');

            modalTitle.textContent = question;
            modalCategory.textContent = category || 'Chung';
            modalBody.innerHTML = answer;

            // Scroll to top of modal content
            modalBody.scrollTop = 0;

            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // Add focus trap for accessibility
            modal.focus();
        });
    });

    // Close modal functions
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    closeBtn.addEventListener('click', closeModal);
    closeModalBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
});
</script>

<div id="qodef-page-outer">
    <div
        class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid">
                <h1 class="qodef-m-title entry-title">
                    FAQ </h1>
                <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                        href="{{ route('client.home') }}"><span itemprop="title">Home</span></a>
                    <span class="qodef-breadcrumbs-separator"></span>
                    <span itemprop="title" class="qodef-breadcrumbs-current">Page</span>
                    <span itemprop="title" class="qodef-breadcrumbs-separator"></span>
                    <span itemprop="title" class="qodef-breadcrumbs-current">FAQ</span>
                </div>
            </div>
        </div>
    </div>
    <div id="qodef-page-inner" class="qodef-content-full-width">
        <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
            <div class="qodef-grid-inner clear">
                <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                    <div data-elementor-type="wp-page" data-elementor-id="4363" class="elementor elementor-4363">

                        <!-- Form tìm kiếm -->
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-100 elementor-top-column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-widget-container">
                                            <form method="GET" action="{{ route('client.faq.index') }}"
                                                class="qodef-search-form">
                                                <div class="qodef-search-form-inner">
                                                    <div class="qodef-search-form-field" style="margin-top: 15px; padding: 12px 15px; border-radius: 5px; ">
                                                        <input type="text" name="search"
                                                            placeholder="Tìm kiếm câu hỏi..."
                                                            value="{{ request('search') }}"
                                                            class="qodef-search-form-input">
                                                    </div>
                                                    @if($categories->count() > 0)
                                                    <div class="qodef-search-form-field">
                                                        <select name="category" class="qodef-search-form-select">
                                                            <option value="">Tất cả danh mục</option>
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category }}" {{
                                                                request('category')==$category ? 'selected' : '' }}>
                                                                {{ $category }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif
                                                    <div class="qodef-search-form-field">
                                                        <button type="submit" class="qodef-search-form-submit">
                                                            <span>Tìm kiếm</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-23e0b2f elementor-section-boxed elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                            data-id="23e0b2f" data-element_type="section">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-abdc33d"
                                    data-id="abdc33d" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-c942b88 elementor-widget elementor-widget-neoocular_core_section_title"
                                            data-id="c942b88" data-element_type="widget"
                                            data-widget_type="neoocular_core_section_title.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--left ">
                                                    <h3 class="qodef-m-title">
                                                        CÂU HỎI CỦA BẠN</h3>
                                                    <p class="qodef-m-subtitle">
                                                        @if(request('search') || request('category'))
                                                        Kết quả tìm kiếm: {{ $faqs->count() }} câu hỏi
                                                        @else
                                                        Những câu hỏi được hỏi nhiều nhất
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-c379074"
                                    data-id="c379074" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-f49f21f elementor-widget elementor-widget-neoocular_core_accordion"
                                            data-id="f49f21f" data-element_type="widget"
                                            data-widget_type="neoocular_core_accordion.default">
                                            <div class="elementor-widget-container">
                                                <div class="faq-list">
                                                    @forelse($faqs as $faq)
                                                    <div class="faq-item" data-question="{{ $faq->question }}"
                                                        data-answer="{{ $faq->formatted_answer ?? $faq->answer }}"
                                                        data-category="{{ $faq->category }}">
                                                        <div class="faq-question">
                                                            <span>{{ $faq->question }}</span>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="faq-item">
                                                        <div class="faq-question">
                                                            <span>Chưa có câu hỏi nào</span>
                                                            <span class="faq-icon">❓</span>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-c2d9be3 elementor-section-boxed elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                            data-id="c2d9be3" data-element_type="section">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-228ae7f"
                                    data-id="228ae7f" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-f99ee5d elementor-widget elementor-widget-neoocular_core_single_image"
                                            data-id="f99ee5d" data-element_type="widget"
                                            data-widget_type="neoocular_core_single_image.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                                    <div class="qodef-m-image">
                                                        <img fetchpriority="high" fetchpriority="high" decoding="async"
                                                            width="1405" height="645"
                                                            src="{{ asset('v1/wp-content/uploads/2021/08/Faq-page-img.jpg') }}"
                                                            class="attachment-full size-full qodef-list-image" alt="m"
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
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-b14e991 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="b14e991" data-element_type="section">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-198e451"
                                    data-id="198e451" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-43d885e elementor-widget elementor-widget-neoocular_core_section_title"
                                            data-id="43d885e" data-element_type="widget"
                                            data-widget_type="neoocular_core_section_title.default">
                                            <div class="elementor-widget-container">
                                                <div
                                                    class="qodef-shortcode qodef-m  qodef-section-title qodef-alignment--center ">
                                                    <h3 class="qodef-m-title">
                                                        <a itemprop="url" href="" target="_self">
                                                            If you cannot find the answer to your question, please
                                                            contact us </a>
                                                    </h3>
                                                    <p class="qodef-m-text" style="margin-top: 12px">Diam volutpat
                                                        commodo sed egestas egestas fringilla phasellus. Augue eget arcu
                                                        dictum varius duis at consectetur lorem. Mauris nunc congue nisi
                                                        vitae purus in</p>
                                                    <div class="qodef-m-button">
                                                        <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--outlined qodef-size--small qodef-html--link "
                                                            href="#" target="_self"
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
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-3d6ca40 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="3d6ca40" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-bfc53d4"
                                    data-id="bfc53d4" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-4953879 elementor-widget elementor-widget-neoocular_core_clients_list"
                                            data-id="4953879" data-element_type="widget"
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
                                                                            <img loading="lazy" loading="lazy"
                                                                                decoding="async" width="170" height="70"
                                                                                src="{{ asset('v1/wp-content/uploads/2021/07/Client-02-1.png') }}"
                                                                                class="attachment-full size-full"
                                                                                alt="s" /> </span>
                                                                        <span class="qodef-e-hover-logo">
                                                                            <img loading="lazy" loading="lazy"
                                                                                decoding="async" width="170" height="70"
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
                                                                                decoding="async" width="170" height="70"
                                                                                src="{{ asset('v1/wp-content/uploads/2021/07/Client-03-1.png') }}"
                                                                                class="attachment-full size-full"
                                                                                alt="s" /> </span>
                                                                        <span class="qodef-e-hover-logo">
                                                                            <img loading="lazy" loading="lazy"
                                                                                decoding="async" width="170" height="70"
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
                                                                                decoding="async" width="170" height="70"
                                                                                src="{{ asset('v1/wp-content/uploads/2021/07/Client-04-1.png') }}"
                                                                                class="attachment-full size-full"
                                                                                alt="s" /> </span>
                                                                        <span class="qodef-e-hover-logo">
                                                                            <img loading="lazy" loading="lazy"
                                                                                decoding="async" width="170" height="70"
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
                                                                                decoding="async" width="170" height="70"
                                                                                src="{{ asset('v1/wp-content/uploads/2021/07/Client-05-1.png') }}"
                                                                                class="attachment-full size-full"
                                                                                alt="s" /> </span>
                                                                        <span class="qodef-e-hover-logo">
                                                                            <img loading="lazy" loading="lazy"
                                                                                decoding="async" width="170" height="70"
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

<!-- FAQ Modal -->
<div id="faqModal" class="faq-modal">
    <div class="faq-modal-content">
        <div class="faq-modal-header">
            <h2 id="faqModalTitle" class="faq-modal-title"></h2>
            <span id="faqModalCategory" class="faq-modal-category"></span>
            <span class="faq-modal-close">&times;</span>
        </div>
        <div id="faqModalBody" class="faq-modal-body">
            <!-- Nội dung câu trả lời sẽ được thêm vào đây -->
        </div>
        <div class="faq-modal-footer">
            <a href="#" class="btn">Đóng</a>
        </div>
    </div>
</div>

@endsection