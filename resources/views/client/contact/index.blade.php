@extends('client.layouts.app')

@section('content')

    <div id="qodef-page-outer">
        <div class="qodef-page-title qodef-m qodef-title--standard qodef-alignment--center qodef-vertical-alignment--header-bottom qodef--has-image qodef-image--parallax qodef-parallax"
            style="margin-top: 32px !important;">
            <div class="qodef-m-inner">
                <div class="qodef-parallax-img-holder">
                    <div class="qodef-parallax-img-wrapper"><img loading="lazy" width="1920" height="1300"
                            src="../wp-content/uploads/2021/10/booking-parallax-title-image-01.jpg"
                            class="qodef-parallax-img" alt="r" decoding="async"
                            srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01.jpg 1920w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01-600x203.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01-800x271.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01-300x102.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01-1024x347.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01-768x260.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/10/booking-parallax-title-image-01-1536x520.jpg 1536w"
                            sizes="(max-width: 1920px) 100vw, 1920px" /></div>
                </div>
                <div class="qodef-m-content qodef-content-grid qodef-parallax-content-holder breadcrumbs-light-skin">
                    <h1 class="qodef-m-title entry-title">
                        Liên hệ </h1>
                    <p class="qodef-m-subtitle"> Donec varius semper magna sit amet dignissim</p>

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
                                                            Liên hệ </h2>
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
                                <div class="elementor-container d-flex flex-column align-items-center"
                                    style="max-width: 1200px; width: 90%; margin: 0 auto;">
                                    <div
                                        style="background: #fff; max-width: 100%; width: 100%; padding: 48px 40px; border-radius: 20px; box-shadow: 0 4px 32px rgba(0,0,0,0.10); margin-bottom: 40px;">
                                        <h2 class="mb-4"
                                            style="font-weight: bold; font-size: 1.5rem; border-bottom: 2px solid #222; display: inline-block;">
                                            Liên hệ</h2>
                                        <div class="mb-4">
                                            <div style="font-size: 16px; color: #888;">Địa chỉ chúng tôi</div>
                                            <div style="font-weight: bold;">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh
                                                Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</div>
                                            <div style="font-size: 16px; color: #888; margin-top: 16px;">Email chúng tôi
                                            </div>
                                            <div style="font-weight: bold;">kinhmathana@gmail.com</div>
                                            <div style="font-size: 16px; color: #888; margin-top: 16px;">Điện thoại</div>
                                            <div style="font-weight: bold;">0123456789</div>
                                            <div style="font-size: 16px; color: #888; margin-top: 16px;">Thời gian làm việc
                                            </div>
                                            <div style="font-weight: bold;">Tất cả các ngày trong tuần</div>
                                        </div>
                                        <h3 class="mb-3 text-center"
                                            style="font-weight: bold;  font-size: 1.5rem; border-bottom: 2px solid #222; display: inline-block;">
                                            Gửi thắc mắc cho chúng tôi</h3>
                                        <form method="POST" action="{{ route('client.contact.store') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Tên của bạn" required>
                                            </div>
                                            <div class="mb-3 d-flex gap-2">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Email của bạn" required>
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Số điện thoại của bạn">
                                            </div>
                                            <div class="mb-3">
                                                <textarea name="message" class="form-control" rows="4" placeholder="Nội dung" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-dark w-100">GỬI CHO CHÚNG TÔI</button>
                                        </form>
                                    </div>
                                </div>
                            </section>
                            <!-- Google Maps dưới khung trắng -->
                            <div
                                style="width: 100%; max-width: 1200px; height: 400px; margin: 32px auto 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d59581.82487630353!2d105.70606196305216!3d21.03812483681596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1751456217046!5m2!1svi!2s"
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <br><br><br>
                            <!-- Các ảnh client list để dưới cùng -->
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
                                                                                    src="../wp-content/uploads/2021/07/Client-01-1.png"
                                                                                    class="attachment-full size-full"
                                                                                    alt="s" /> </span>
                                                                            <span class="qodef-e-hover-logo">
                                                                                <img decoding="async" width="170"
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
                                                                                <img decoding="async" width="170"
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
    <style>
        .elementor-container>.row {
            display: flex !important;
            flex-wrap: wrap;
        }

        .elementor-container>.row>.col-md-6 {
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .elementor-container>.row.align-items-stretch {
            display: flex !important;
            align-items: stretch !important;
        }

        .elementor-container>.row.align-items-stretch>.col-md-6 {
            display: flex;
            flex-direction: column;
            justify-content: stretch;
        }

        .elementor-container {
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection
