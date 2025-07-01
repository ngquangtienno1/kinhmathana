@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Sản phẩm </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="{{ route('client.home') }}"><span itemprop="title">Trang chủ</span></a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Sản phẩm</span>
                    </div>
                    <span class="qodef-breadcrumbs-separator"></span>
                    <span itemprop="title" class="qodef-breadcrumbs-current">{{ $product->name }}</span>
                </div>
            </div>
        </div>
    </div>
    <div id="qodef-page-inner" class="qodef-content-grid">

        <main id="qodef-page-content" class="qodef-grid qodef-layout--template qodef--no-bottom-space qodef-gutter--medium"
            role="main">
            <div class="qodef-grid-inner clear">
                <div id="qodef-woo-page"
                    class="qodef-grid-item qodef--single qodef-popup--magnific-popup qodef-magnific-popup qodef-popup-gallery">

                    <div class="woocommerce-notices-wrapper"></div>
                    <div id="product-921"
                        class="product type-product post-921 status-publish first instock product_cat-men product_cat-round product_cat-top-frames product_cat-unisex product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes">

                        <div class="qodef-woo-single-inner">
                            <div class="qodef-woo-single-image">
                                <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-3 images qvsfw-loading qodef-position--below"
                                    data-columns="3" style="opacity: 0; transition: opacity .25s ease-in-out;">
                                    <div class="woocommerce-product-gallery__wrapper">
                                        <div data-thumb="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2-600x431.jpg"
                                            data-thumb-alt="m" class="woocommerce-product-gallery__image"><a
                                                href="{{ asset('v1/wp-content/uploads/2021/07/optican-home-product-2.jpg') }}"><img
                                                    width="800" height="575"
                                                    src="{{ asset('v1/wp-content/uploads/2021/07/optican-home-product-2.jpg') }}"
                                                    class="wp-post-image" alt="m" title="optican home product 2"
                                                    data-caption=""
                                                    data-src="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2.jpg"
                                                    data-large_image="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2.jpg"
                                                    data-large_image_width="800" data-large_image_height="575"
                                                    decoding="async"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/optican-home-product-2-600x431.jpg 600w"
                                                    sizes="(max-width: 800px) 100vw, 800px" /></a></div>
                                        <div class="qodef-woo-thumbnails-wrapper">
                                            <div data-thumb="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1.jpg"
                                                data-thumb-alt="m" class="woocommerce-product-gallery__image"><a
                                                    href="../../wp-content/uploads/2021/07/product-05-02-gallery-img-1.jpg"><img
                                                        loading="lazy" width="600" height="600"
                                                        src="{{ asset('v1/wp-content/uploads/2021/07/product-05-02-gallery-img-1.jpg') }}"
                                                        class="" alt="m" title="product-05-02-gallery img (1)"
                                                        data-caption=""
                                                        data-src="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1.jpg"
                                                        data-large_image="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1.jpg"
                                                        data-large_image_width="600" data-large_image_height="600"
                                                        decoding="async"
                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1-300x300.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-1-150x150.jpg 150w"
                                                        sizes="(max-width: 600px) 100vw, 600px" /></a></div>
                                            <div data-thumb="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2.jpg"
                                                data-thumb-alt="m" class="woocommerce-product-gallery__image"><a
                                                    href="{{ asset('v1/wp-content/uploads/2021/07/product-05-02-gallery-img-2.jpg') }}"><img
                                                        loading="lazy" width="600" height="600"
                                                        src="{{ asset('v1/wp-content/uploads/2021/07/product-05-02-gallery-img-2.jpg') }}"
                                                        class="" alt="m" title="product-05-02-gallery img (2)"
                                                        data-caption=""
                                                        data-src="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2.jpg"
                                                        data-large_image="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2.jpg"
                                                        data-large_image_width="600" data-large_image_height="600"
                                                        decoding="async"
                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2-300x300.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-2-150x150.jpg 150w"
                                                        sizes="(max-width: 600px) 100vw, 600px" /></a></div>
                                            <div data-thumb="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3.jpg"
                                                data-thumb-alt="m" class="woocommerce-product-gallery__image"><a
                                                    href="{{ asset('v1/wp-content/uploads/2021/07/product-05-02-gallery-img-3.jpg') }}"><img
                                                        loading="lazy" width="600" height="600"
                                                        src="{{ asset('v1/wp-content/uploads/2021/07/product-05-02-gallery-img-3.jpg') }}"
                                                        class="" alt="m"
                                                        title="product-05-02-gallery img (3)" data-caption=""
                                                        data-src="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3.jpg"
                                                        data-large_image="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3.jpg"
                                                        data-large_image_width="600" data-large_image_height="600"
                                                        decoding="async"
                                                        srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3-300x300.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/product-05-02-gallery-img-3-150x150.jpg 150w"
                                                        sizes="(max-width: 600px) 100vw, 600px" /></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="summary entry-summary">
                                <h1 class="qodef-woo-product-title product_title entry-title">Aviator Paris</h1>
                                <p class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                class="woocommerce-Price-currencySymbol">&#36;</span>315.00</bdi></span>
                                </p>
                                <div class="woocommerce-product-details__short-description">
                                    <p>Sed viverra tellus in hac. Sagittis vitae et leo duis ut diam quam. Aliquet eget
                                        sit amet tellus cras adipiscing enim eu turpis. Orci ac auctor augue mauris
                                        augue.</p>
                                </div>
                                <div id="qvsfw-variations-form-wrapper">
                                    <form class="variations_form cart"
                                        action="https://neoocular.qodeinteractive.com/product/aviator-paris/"
                                        method="post" enctype='multipart/form-data' data-product_id="921"
                                        data-product_variations="[{&quot;attributes&quot;:{&quot;attribute_pa_color&quot;:&quot;silver&quot;,&quot;attribute_pa_size&quot;:&quot;&quot;},&quot;availability_html&quot;:&quot;&quot;,&quot;backorders_allowed&quot;:false,&quot;dimensions&quot;:{&quot;length&quot;:&quot;1&quot;,&quot;width&quot;:&quot;2&quot;,&quot;height&quot;:&quot;3&quot;},&quot;dimensions_html&quot;:&quot;1 &amp;times; 2 &amp;times; 3 cm&quot;,&quot;display_price&quot;:315,&quot;display_regular_price&quot;:315,&quot;image&quot;:{&quot;title&quot;:&quot;optican home product 2 c&quot;,&quot;caption&quot;:&quot;&quot;,&quot;url&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c.jpg&quot;,&quot;alt&quot;:&quot;b&quot;,&quot;src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c.jpg&quot;,&quot;srcset&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c.jpg 800w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c-300x216.jpg 300w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c-768x552.jpg 768w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c-600x431.jpg 600w&quot;,&quot;sizes&quot;:&quot;(max-width: 800px) 100vw, 800px&quot;,&quot;full_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c.jpg&quot;,&quot;full_src_w&quot;:800,&quot;full_src_h&quot;:575,&quot;gallery_thumbnail_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c-600x431.jpg&quot;,&quot;gallery_thumbnail_src_w&quot;:600,&quot;gallery_thumbnail_src_h&quot;:431,&quot;thumb_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-c-600x431.jpg&quot;,&quot;thumb_src_w&quot;:600,&quot;thumb_src_h&quot;:431,&quot;src_w&quot;:800,&quot;src_h&quot;:575},&quot;image_id&quot;:11644,&quot;is_downloadable&quot;:false,&quot;is_in_stock&quot;:true,&quot;is_purchasable&quot;:true,&quot;is_sold_individually&quot;:&quot;no&quot;,&quot;is_virtual&quot;:false,&quot;max_qty&quot;:&quot;&quot;,&quot;min_qty&quot;:1,&quot;price_html&quot;:&quot;&quot;,&quot;sku&quot;:&quot;0158&quot;,&quot;variation_description&quot;:&quot;&quot;,&quot;variation_id&quot;:11632,&quot;variation_is_active&quot;:true,&quot;variation_is_visible&quot;:true,&quot;weight&quot;:&quot;0.5&quot;,&quot;weight_html&quot;:&quot;0.5 kg&quot;},{&quot;attributes&quot;:{&quot;attribute_pa_color&quot;:&quot;bronze&quot;,&quot;attribute_pa_size&quot;:&quot;&quot;},&quot;availability_html&quot;:&quot;&quot;,&quot;backorders_allowed&quot;:false,&quot;dimensions&quot;:{&quot;length&quot;:&quot;1&quot;,&quot;width&quot;:&quot;2&quot;,&quot;height&quot;:&quot;3&quot;},&quot;dimensions_html&quot;:&quot;1 &amp;times; 2 &amp;times; 3 cm&quot;,&quot;display_price&quot;:315,&quot;display_regular_price&quot;:315,&quot;image&quot;:{&quot;title&quot;:&quot;optican home product 2 b&quot;,&quot;caption&quot;:&quot;&quot;,&quot;url&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b.jpg&quot;,&quot;alt&quot;:&quot;b&quot;,&quot;src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b.jpg&quot;,&quot;srcset&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b.jpg 800w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b-300x216.jpg 300w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b-768x552.jpg 768w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b-600x431.jpg 600w&quot;,&quot;sizes&quot;:&quot;(max-width: 800px) 100vw, 800px&quot;,&quot;full_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b.jpg&quot;,&quot;full_src_w&quot;:800,&quot;full_src_h&quot;:575,&quot;gallery_thumbnail_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b-600x431.jpg&quot;,&quot;gallery_thumbnail_src_w&quot;:600,&quot;gallery_thumbnail_src_h&quot;:431,&quot;thumb_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/10\/optican-home-product-2-b-600x431.jpg&quot;,&quot;thumb_src_w&quot;:600,&quot;thumb_src_h&quot;:431,&quot;src_w&quot;:800,&quot;src_h&quot;:575},&quot;image_id&quot;:11643,&quot;is_downloadable&quot;:false,&quot;is_in_stock&quot;:true,&quot;is_purchasable&quot;:true,&quot;is_sold_individually&quot;:&quot;no&quot;,&quot;is_virtual&quot;:false,&quot;max_qty&quot;:&quot;&quot;,&quot;min_qty&quot;:1,&quot;price_html&quot;:&quot;&quot;,&quot;sku&quot;:&quot;0158&quot;,&quot;variation_description&quot;:&quot;&quot;,&quot;variation_id&quot;:11633,&quot;variation_is_active&quot;:true,&quot;variation_is_visible&quot;:true,&quot;weight&quot;:&quot;0.5&quot;,&quot;weight_html&quot;:&quot;0.5 kg&quot;},{&quot;attributes&quot;:{&quot;attribute_pa_color&quot;:&quot;gold&quot;,&quot;attribute_pa_size&quot;:&quot;&quot;},&quot;availability_html&quot;:&quot;&quot;,&quot;backorders_allowed&quot;:false,&quot;dimensions&quot;:{&quot;length&quot;:&quot;1&quot;,&quot;width&quot;:&quot;2&quot;,&quot;height&quot;:&quot;3&quot;},&quot;dimensions_html&quot;:&quot;1 &amp;times; 2 &amp;times; 3 cm&quot;,&quot;display_price&quot;:315,&quot;display_regular_price&quot;:315,&quot;image&quot;:{&quot;title&quot;:&quot;optican home product 2&quot;,&quot;caption&quot;:&quot;&quot;,&quot;url&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2.jpg&quot;,&quot;alt&quot;:&quot;m&quot;,&quot;src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2.jpg&quot;,&quot;srcset&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2.jpg 800w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2-300x216.jpg 300w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2-768x552.jpg 768w, https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2-600x431.jpg 600w&quot;,&quot;sizes&quot;:&quot;(max-width: 800px) 100vw, 800px&quot;,&quot;full_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2.jpg&quot;,&quot;full_src_w&quot;:800,&quot;full_src_h&quot;:575,&quot;gallery_thumbnail_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2-600x431.jpg&quot;,&quot;gallery_thumbnail_src_w&quot;:600,&quot;gallery_thumbnail_src_h&quot;:431,&quot;thumb_src&quot;:&quot;https:\/\/neoocular.qodeinteractive.com\/wp-content\/uploads\/2021\/07\/optican-home-product-2-600x431.jpg&quot;,&quot;thumb_src_w&quot;:600,&quot;thumb_src_h&quot;:431,&quot;src_w&quot;:800,&quot;src_h&quot;:575},&quot;image_id&quot;:11642,&quot;is_downloadable&quot;:false,&quot;is_in_stock&quot;:true,&quot;is_purchasable&quot;:true,&quot;is_sold_individually&quot;:&quot;no&quot;,&quot;is_virtual&quot;:false,&quot;max_qty&quot;:&quot;&quot;,&quot;min_qty&quot;:1,&quot;price_html&quot;:&quot;&quot;,&quot;sku&quot;:&quot;0158&quot;,&quot;variation_description&quot;:&quot;&quot;,&quot;variation_id&quot;:11631,&quot;variation_is_active&quot;:true,&quot;variation_is_visible&quot;:true,&quot;weight&quot;:&quot;0.5&quot;,&quot;weight_html&quot;:&quot;0.5 kg&quot;}]">

                                        <table class="variations" cellspacing="0" role="presentation">
                                            <tbody>
                                                <tr>
                                                    <th class="label"><label for="pa_color">Color</label></th>
                                                    <td class="value">
                                                        <select id="pa_color" class="qvsfw-attribute-type--color"
                                                            name="attribute_pa_color"
                                                            data-attribute_name="attribute_pa_color"
                                                            data-show_option_none="yes">
                                                            <option value="">Choose an option</option>
                                                            <option value="silver">Silver</option>
                                                            <option value="bronze">Bronze</option>
                                                            <option value="gold" selected='selected'>Gold</option>
                                                        </select>
                                                        <div class="qvsfw-select-options-container qvsfw-select-options-container-type--color pa_color qvsfw-color-layout-style--layout-2"
                                                            data-attribute-name="Color">
                                                            <span class="qvsfw-select-option qvsfw-select-option--color  "
                                                                data-value="silver" data-name="Silver">
                                                                <span class="qvsfw-select-option-inner">
                                                                    <span class="qvsfw-select-option-additional-holder">
                                                                        <span class="qvsfw-select-value"
                                                                            style="background-color: #a9a9a9"></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="qvsfw-select-option qvsfw-select-option--color  "
                                                                data-value="bronze" data-name="Bronze">
                                                                <span class="qvsfw-select-option-inner">
                                                                    <span class="qvsfw-select-option-additional-holder">
                                                                        <span class="qvsfw-select-value"
                                                                            style="background-color: #cd823d"></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span
                                                                class="qvsfw-select-option qvsfw-select-option--color  qvsfw-selected"
                                                                data-value="gold" data-name="Gold">
                                                                <span class="qvsfw-select-option-inner">
                                                                    <span class="qvsfw-select-option-additional-holder">
                                                                        <span class="qvsfw-select-value"
                                                                            style="background-color: #ceaf79"></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="label"><label for="pa_size">Size</label></th>
                                                    <td class="value">
                                                        <select id="pa_size" class="qvsfw-attribute-type--label"
                                                            name="attribute_pa_size"
                                                            data-attribute_name="attribute_pa_size"
                                                            data-show_option_none="yes">
                                                            <option value="">Choose an option</option>
                                                            <option value="m">M</option>
                                                            <option value="s" selected='selected'>S</option>
                                                            <option value="l">L</option>
                                                        </select>
                                                        <div class="qvsfw-select-options-container qvsfw-select-options-container-type--label pa_size qvsfw-badge-position--bottom qvsfw-label-layout-style--layout-1"
                                                            data-attribute-name="Size">
                                                            <span class="qvsfw-select-option qvsfw-select-option--label  "
                                                                data-value="m" data-name="M">
                                                                <span class="qvsfw-select-option-inner">
                                                                    <span class="qvsfw-select-value">M</span>
                                                                </span>
                                                            </span>
                                                            <span
                                                                class="qvsfw-select-option qvsfw-select-option--label  qvsfw-selected"
                                                                data-value="s" data-name="S">
                                                                <span class="qvsfw-select-option-inner">
                                                                    <span class="qvsfw-select-value">S</span>
                                                                </span>
                                                            </span>
                                                            <span class="qvsfw-select-option qvsfw-select-option--label  "
                                                                data-value="l" data-name="L">
                                                                <span class="qvsfw-select-option-inner">
                                                                    <span class="qvsfw-select-value">L</span>
                                                                </span>
                                                            </span>
                                                        </div>

                                                        <a class="reset_variations" href="#">Clear</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="single_variation_wrap">
                                            <div class="woocommerce-variation single_variation"></div>
                                            <div class="woocommerce-variation-add-to-cart variations_button">

                                                <div class="qodef-quantity-buttons quantity">
                                                    <label class="screen-reader-text" for="quantity_68627e2494143">Aviator
                                                        Paris quantity</label>
                                                    <span class="qodef-quantity-minus"></span>
                                                    <input type="text" id="quantity_68627e2494143"
                                                        class="input-text qty text qodef-quantity-input" data-step="1"
                                                        data-min="1" data-max="" name="quantity" value="01"
                                                        title="Qty" size="4" placeholder=""
                                                        inputmode="numeric" />
                                                    <span class="qodef-quantity-plus"></span>
                                                </div>

                                                <button type="submit" class="single_add_to_cart_button button alt">Add to
                                                    cart</button>


                                                <input type="hidden" name="add-to-cart" value="921" />
                                                <input type="hidden" name="product_id" value="921" />
                                                <input type="hidden" name="variation_id" class="variation_id"
                                                    value="0" />
                                            </div>
                                        </div>

                                    </form>

                                </div>
                                <div
                                    class="qwfw-add-to-wishlist-wrapper qwfw--single qwfw-position--after-add-to-cart qwfw-item-type--icon-with-text qodef-neoocular-theme">
                                    <a role="button" tabindex="0"
                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon-with-text"
                                        href="index7f33.html?add_to_wishlist=921" data-item-id="921"
                                        data-original-item-id="921" aria-label="Add to wishlist"
                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon-with-text&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                        rel="noopener noreferrer"> <span class="qwfw-m-spinner qwfw-spinner-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
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
                                            </svg> </span> <span class="qwfw-m-text">Add to wishlist</span> </a>
                                </div>
                                <div class="product_meta">

                                    <span class="sku_wrapper">
                                        <span class="qodef-woo-meta-label">SKU:</span>
                                        <span class="sku qodef-woo-meta-value">0158</span>
                                    </span>

                                    <span class="posted_in"><span class="qodef-woo-meta-label">Categories:</span><span
                                            class="qodef-woo-meta-value"><a
                                                href="../../product-category/top-frames/men/index.html"
                                                rel="tag">Men</a>, <a href="../../product-category/round/index.html"
                                                rel="tag">Round</a>, <a
                                                href="../../product-category/top-frames/index.html" rel="tag">Top
                                                Frames</a>, <a href="../../product-category/top-frames/unisex/index.html"
                                                rel="tag">Unisex</a></span></span>
                                    <span class="tagged_as"><span class="qodef-woo-meta-label">Tags:</span><span
                                            class="qodef-woo-meta-value"><a href="../../product-tag/frame/index.html"
                                                rel="tag">Frame</a>, <a href="../../product-tag/stripe/index.html"
                                                rel="tag">Stripe</a></span></span>
                                </div>
                                <div class="qodef-shortcode qodef-m  qodef-social-share clear qodef-layout--list ">
                                    <span class="qodef-social-title qodef-custom-label">Share product:</span>
                                    <ul class="qodef-shortcode-list">
                                        <li class="qodef-facebook-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="window.open(&#039;https://www.facebook.com/sharer.php?u=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fproduct%2Faviator-paris%2F&#039;, &#039;sharer&#039;, &#039;toolbar=0,status=0,width=620,height=280&#039;);">
                                                <span
                                                    class="qodef-icon-elegant-icons social_facebook qodef-social-network-icon"></span>
                                            </a></li>
                                        <li class="qodef-twitter-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="window.open(&#039;https://twitter.com/intent/tweet?text=Sed+viverra+tellus+in+hac.+Sagittis+vitae+et+leo+duis+ut+diam+quam.+Aliquet+eget+sit+amet++via+%40QodeInteractivehttps://neoocular.qodeinteractive.com/product/aviator-paris/&#039;, &#039;popupwindow&#039;, &#039;scrollbars=yes,width=800,height=400&#039;);">
                                                <span
                                                    class="qodef-icon-elegant-icons social_twitter qodef-social-network-icon"></span>
                                            </a></li>
                                        <li class="qodef-pinterest-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="popUp=window.open(&#039;https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fproduct%2Faviator-paris%2F&amp;description=Aviator+Paris&amp;media=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fwp-content%2Fuploads%2F2021%2F07%2Foptican-home-product-2.jpg&#039;, &#039;popupwindow&#039;, &#039;scrollbars=yes,width=800,height=400&#039;);popUp.focus();return false;">
                                                <span
                                                    class="qodef-icon-elegant-icons social_pinterest qodef-social-network-icon"></span>
                                            </a></li>
                                        <li class="qodef-tumblr-share"> <a itemprop="url" class="qodef-share-link"
                                                href="#"
                                                onclick="popUp=window.open(&#039;https://www.tumblr.com/share/link?url=https%3A%2F%2Fneoocular.qodeinteractive.com%2Fproduct%2Faviator-paris%2F&amp;name=Aviator+Paris&amp;description=Sed+viverra+tellus+in+hac.+Sagittis+vitae+et+leo+duis+ut+diam+quam.+Aliquet+eget+sit+amet+tellus+cras+adipiscing+enim+eu+turpis.+Orci+ac+auctor+augue+mauris+augue.&#039;, &#039;popupwindow&#039;, &#039;scrollbars=yes,width=800,height=400&#039;);popUp.focus();return false;">
                                                <span
                                                    class="qodef-icon-elegant-icons social_tumblr qodef-social-network-icon"></span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="woocommerce-tabs wc-tabs-wrapper">
                            <ul class="tabs wc-tabs" role="tablist">
                                <li class="description_tab" id="tab-title-description" role="tab"
                                    aria-controls="tab-description">
                                    <a href="#tab-description">
                                        Description </a>
                                </li>
                                <li class="additional_information_tab" id="tab-title-additional_information"
                                    role="tab" aria-controls="tab-additional_information">
                                    <a href="#tab-additional_information">
                                        Additional information </a>
                                </li>
                                <li class="reviews_tab" id="tab-title-reviews" role="tab"
                                    aria-controls="tab-reviews">
                                    <a href="#tab-reviews">
                                        Reviews (0) </a>
                                </li>
                            </ul>
                            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab"
                                id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">

                                <h2>Description</h2>

                                <p>Aliquet nec ullamcorper sit amet. Viverra tellus in hac habitasse. Eros in cursus
                                    turpis massa tincidunt dui ut ornare. Amet consectetur adipiscing elit ut aliquam.
                                    Sit amet nulla facilisi morbi tempus iaculis urna id volutpat. Sed cras ornare arcu
                                    dui vivamus arcu felis bibendum. Nunc sed velit dignissim sodales ut eu sem integer.
                                    Dictumst quisque sagittis purus sit amet. Suspendisse in est ante in nibh mauris
                                    cursus mattis. Quis varius quam quisque id diam vel. A lacus vestibulum sed arcu
                                    non. Laoreet non curabitur gravida arcu ac tortor dignissim convallis. Et netus et
                                    malesuada fames ac turpis egestas maecenas.</p>
                            </div>
                            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content wc-tab"
                                id="tab-additional_information" role="tabpanel"
                                aria-labelledby="tab-title-additional_information">

                                <h2>Additional information</h2>

                                <table class="woocommerce-product-attributes shop_attributes">
                                    <tr
                                        class="woocommerce-product-attributes-item woocommerce-product-attributes-item--weight">
                                        <th class="woocommerce-product-attributes-item__label">Weight</th>
                                        <td class="woocommerce-product-attributes-item__value">0.5 kg</td>
                                    </tr>
                                    <tr
                                        class="woocommerce-product-attributes-item woocommerce-product-attributes-item--dimensions">
                                        <th class="woocommerce-product-attributes-item__label">Dimensions</th>
                                        <td class="woocommerce-product-attributes-item__value">1 &times; 2 &times; 3 cm
                                        </td>
                                    </tr>
                                    <tr
                                        class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_color">
                                        <th class="woocommerce-product-attributes-item__label">Color</th>
                                        <td class="woocommerce-product-attributes-item__value">
                                            <p>Silver, Bronze, Orange, Purple, Gold</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_size">
                                        <th class="woocommerce-product-attributes-item__label">Size</th>
                                        <td class="woocommerce-product-attributes-item__value">
                                            <p>M, S, L</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab"
                                id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews">
                                <div id="reviews" class="woocommerce-Reviews">
                                    <div id="comments">
                                        <h2 class="woocommerce-Reviews-title">
                                            Reviews </h2>

                                        <p class="woocommerce-noreviews">There are no reviews yet.</p>
                                    </div>

                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                <h3 id="reply-title" class="comment-reply-title">Be the first to
                                                    review &ldquo;Aviator Paris&rdquo; <small><a rel="nofollow"
                                                            id="cancel-comment-reply-link" href="index.html#respond"
                                                            style="display:none;">Cancel reply</a></small></h3>
                                                <form action="https://neoocular.qodeinteractive.com/wp-comments-post.php"
                                                    method="post" id="commentform" class="qodef-comment-form">
                                                    <p class="comment-notes"><span id="email-notes">Your email address
                                                            will not be published.</span> <span
                                                            class="required-field-message">Required fields are marked
                                                            <span class="required">*</span></span></p>
                                                    <div class="comment-form-rating">
                                                        <label for="rating">Your Rating <span
                                                                class="required">*</span></label>
                                                        <p class="stars qodef-comment-form-ratings"><a class="star-1"
                                                                href="#">1<svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="32" height="32" viewBox="0 0 32 32">
                                                                    <g>
                                                                        <path
                                                                            d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z">
                                                                        </path>
                                                                    </g>
                                                                </svg></a><a class="star-2" href="#">2<svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="32" height="32" viewBox="0 0 32 32">
                                                                    <g>
                                                                        <path
                                                                            d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z">
                                                                        </path>
                                                                    </g>
                                                                </svg></a><a class="star-3" href="#">3<svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="32" height="32" viewBox="0 0 32 32">
                                                                    <g>
                                                                        <path
                                                                            d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z">
                                                                        </path>
                                                                    </g>
                                                                </svg></a><a class="star-4" href="#">4<svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="32" height="32" viewBox="0 0 32 32">
                                                                    <g>
                                                                        <path
                                                                            d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z">
                                                                        </path>
                                                                    </g>
                                                                </svg></a><a class="star-5" href="#">5<svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="32" height="32" viewBox="0 0 32 32">
                                                                    <g>
                                                                        <path
                                                                            d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z">
                                                                        </path>
                                                                    </g>
                                                                </svg></a></p>
                                                        <select name="rating" id="rating" required>
                                                            <option value="">Rate&hellip;</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <p class="comment-form-comment">
                                                        <textarea id="comment" name="comment" placeholder="Your Review *" cols="45" rows="8"
                                                            maxlength="65525" required="required"></textarea>
                                                    </p>
                                                    <div class="qodef-grid qodef-layout--columns qodef-col-num--2">
                                                        <div class="qodef-grid-inner">
                                                            <div class="qodef-grid-item">
                                                                <p class="comment-form-author">
                                                                    <input id="author" name="author"
                                                                        placeholder="Your Name *" type="text"
                                                                        value="" size="30" maxlength="245"
                                                                        required="required" />
                                                                </p>
                                                            </div>
                                                            <div class="qodef-grid-item">
                                                                <p class="comment-form-email">
                                                                    <input id="email" name="email"
                                                                        placeholder="Your Email *" type="text"
                                                                        value="" size="30" maxlength="100"
                                                                        aria-describedby="email-notes"
                                                                        required="required" />
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="comment-form-cookies-consent"><input
                                                            id="wp-comment-cookies-consent"
                                                            name="wp-comment-cookies-consent" type="checkbox"
                                                            value="yes" /> <label for="wp-comment-cookies-consent">Save
                                                            my name, email, and
                                                            website in this browser for the next time I comment.</label>
                                                    </p>
                                                    <p class="form-submit"><button name="submit" type="submit"
                                                            id="submit" class="qodef-button qodef-layout--outlined"
                                                            value="Submit"><span
                                                                class="qodef-m-text">Submit</span></button> <input
                                                            type='hidden' name='comment_post_ID' value='921'
                                                            id='comment_post_ID' />
                                                        <input type='hidden' name='comment_parent' id='comment_parent'
                                                            value='0' />
                                                    </p><!-- Anti-spam plugin wordpress.org/plugins/anti-spam/ -->
                                                    <div class="wantispam-required-fields"><input type="hidden"
                                                            name="wantispam_t"
                                                            class="wantispam-control wantispam-control-t"
                                                            value="1751285284" />
                                                        <div class="wantispam-group wantispam-group-q"
                                                            style="clear: both;">
                                                            <label>Current ye@r <span class="required">*</span></label>
                                                            <input type="hidden" name="wantispam_a"
                                                                class="wantispam-control wantispam-control-a"
                                                                value="2025" />
                                                            <input type="text" name="wantispam_q"
                                                                class="wantispam-control wantispam-control-q"
                                                                value="7.3.6" autocomplete="off" />
                                                        </div>
                                                        <div class="wantispam-group wantispam-group-e"
                                                            style="display: none;">
                                                            <label>Leave this field empty</label>
                                                            <input type="text" name="wantispam_e_email_url_website"
                                                                class="wantispam-control wantispam-control-e"
                                                                value="" autocomplete="off" />
                                                        </div>
                                                    </div><!--\End Anti-spam plugin -->
                                                </form>
                                            </div><!-- #respond -->
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                            </div>

                        </div>


                        <section class="related products">

                            <h2>Related products</h2>

                            <div class="qodef-woo-product-list qodef-item-layout--info-below qodef-gutter--medium">
                                <ul class="products columns-4">


                                    <li
                                        class="product type-product post-607 status-publish first instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-image">
                                                <span class="qodef-woo-product-mark qodef-woo-onsale">Sale</span>
                                                <img width="600" height="431"
                                                    src="../../wp-content/uploads/2021/07/Shop-Single-02-img-600x431.jpg"
                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                    alt="m" decoding="async"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img.jpg 800w"
                                                    sizes="(max-width: 600px) 100vw, 600px" />
                                            </div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                        href="../transparent-lennons/index.html"
                                                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Transparent
                                                        Lennons</a></h6>
                                                <div class="qodef-woo-product-categories qodef-e-info"><a
                                                        href="../../product-category/classic/index.html"
                                                        rel="tag">Classic style</a><span
                                                        class="qodef-info-separator-single"></span><a
                                                        href="../../product-category/round/index.html"
                                                        rel="tag">Round</a>
                                                    <div class="qodef-info-separator-end"></div>
                                                </div>
                                                <span class="price"><del aria-hidden="true"><span
                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">&#36;</span>235.00</bdi></span></del>
                                                    <span class="screen-reader-text">Original price was:
                                                        &#036;235.00.</span><ins aria-hidden="true"><span
                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span></ins><span
                                                        class="screen-reader-text">Current price is:
                                                        &#036;199.00.</span></span>
                                                <div class="qodef-woo-product-image-inner">
                                                    <div
                                                        class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                            href="index61db.html?add_to_wishlist=607" data-item-id="607"
                                                            data-original-item-id="607" aria-label="Add to wishlist"
                                                            data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                            rel="noopener noreferrer"> <span
                                                                class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span> <span class="qwfw-m-icon qwfw--predefined">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                    height="32" viewBox="0 0 32 32"
                                                                    fill="currentColor">
                                                                    <g>
                                                                        <path
                                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                                    </g>
                                                                </svg> </span> </a>
                                                    </div>
                                                    <div
                                                        class="qqvfw-quick-view-button-wrapper qqvfw-position--after-add-to-cart qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qqvfw-shortcode qqvfw-m  qqvfw-quick-view-button qqvfw-type--icon-with-text"
                                                            data-item-id="607" data-quick-view-type="pop-up"
                                                            data-quick-view-type-mobile="pop-up"
                                                            href="index7fe0.html?quick_view_button=607"
                                                            data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                            rel="noopener noreferrer"> <span class="qqvfw-m-spinner">
                                                                <svg class="qqvfw-svg--spinner"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span><span
                                                                class="qqvfw-m-icon qqvfw-icon--predefined"> <span
                                                                    class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                                class="qqvfw-m-text"></span> </a>
                                                    </div><a href="index23d2.html?add-to-cart=607"
                                                        aria-describedby="woocommerce_loop_add_to_cart_link_describedby_607"
                                                        data-quantity="1"
                                                        class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                        data-product_id="607" data-product_sku="0022"
                                                        aria-label="Add to cart: &ldquo;Transparent Lennons&rdquo;"
                                                        rel="nofollow">Add to cart</a><span
                                                        id="woocommerce_loop_add_to_cart_link_describedby_607"
                                                        class="screen-reader-text">
                                                    </span>
                                                </div>
                                            </div><a href="../transparent-lennons/index.html"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                        </div>
                                    </li>


                                    <li
                                        class="product type-product post-235 status-publish instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-image"><img width="600" height="431"
                                                    src="../../wp-content/uploads/2021/07/Shop-Single-10-img-600x431.jpg"
                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                    alt="m" decoding="async"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img.jpg 800w"
                                                    sizes="(max-width: 600px) 100vw, 600px" /></div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                        href="../wild-round-glasses/index.html"
                                                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Wild
                                                        Round Glasses</a></h6>
                                                <div class="qodef-woo-product-categories qodef-e-info"><a
                                                        href="../../product-category/classic/index.html"
                                                        rel="tag">Classic style</a><span
                                                        class="qodef-info-separator-single"></span><a
                                                        href="../../product-category/round/index.html"
                                                        rel="tag">Round</a>
                                                    <div class="qodef-info-separator-end"></div>
                                                </div>
                                                <span class="price"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>152.00</bdi></span></span>
                                                <div class="qodef-woo-product-image-inner">
                                                    <div
                                                        class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                            href="indexf6cd.html?add_to_wishlist=235" data-item-id="235"
                                                            data-original-item-id="235" aria-label="Add to wishlist"
                                                            data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                            rel="noopener noreferrer"> <span
                                                                class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span> <span class="qwfw-m-icon qwfw--predefined">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                    height="32" viewBox="0 0 32 32"
                                                                    fill="currentColor">
                                                                    <g>
                                                                        <path
                                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                                    </g>
                                                                </svg> </span> </a>
                                                    </div>
                                                    <div
                                                        class="qqvfw-quick-view-button-wrapper qqvfw-position--after-add-to-cart qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qqvfw-shortcode qqvfw-m  qqvfw-quick-view-button qqvfw-type--icon-with-text"
                                                            data-item-id="235" data-quick-view-type="pop-up"
                                                            data-quick-view-type-mobile="pop-up"
                                                            href="indexeb36.html?quick_view_button=235"
                                                            data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                            rel="noopener noreferrer"> <span class="qqvfw-m-spinner">
                                                                <svg class="qqvfw-svg--spinner"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span><span
                                                                class="qqvfw-m-icon qqvfw-icon--predefined"> <span
                                                                    class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                                class="qqvfw-m-text"></span> </a>
                                                    </div><a href="indexfa33.html?add-to-cart=235"
                                                        aria-describedby="woocommerce_loop_add_to_cart_link_describedby_235"
                                                        data-quantity="1"
                                                        class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                        data-product_id="235" data-product_sku="004"
                                                        aria-label="Add to cart: &ldquo;Wild Round Glasses&rdquo;"
                                                        rel="nofollow">Add to cart</a><span
                                                        id="woocommerce_loop_add_to_cart_link_describedby_235"
                                                        class="screen-reader-text">
                                                    </span>
                                                </div>
                                            </div><a href="../wild-round-glasses/index.html"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                        </div>
                                    </li>


                                    <li
                                        class="product type-product post-342 status-publish instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-image"><img width="600" height="431"
                                                    src="../../wp-content/uploads/2021/07/Shop-Single-09-img-600x431.jpg"
                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                    alt="m" decoding="async"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img.jpg 800w"
                                                    sizes="(max-width: 600px) 100vw, 600px" /></div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                        href="../shinny-glasses/index.html"
                                                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Shinny
                                                        Glasses</a></h6>
                                                <div class="qodef-woo-product-categories qodef-e-info"><a
                                                        href="../../product-category/classic/index.html"
                                                        rel="tag">Classic style</a><span
                                                        class="qodef-info-separator-single"></span><a
                                                        href="../../product-category/round/index.html"
                                                        rel="tag">Round</a>
                                                    <div class="qodef-info-separator-end"></div>
                                                </div>
                                                <span class="price"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>152.00</bdi></span></span>
                                                <div class="qodef-woo-product-image-inner">
                                                    <div
                                                        class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                            href="indexb6be.html?add_to_wishlist=342" data-item-id="342"
                                                            data-original-item-id="342" aria-label="Add to wishlist"
                                                            data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                            rel="noopener noreferrer"> <span
                                                                class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span> <span class="qwfw-m-icon qwfw--predefined">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                    height="32" viewBox="0 0 32 32"
                                                                    fill="currentColor">
                                                                    <g>
                                                                        <path
                                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                                    </g>
                                                                </svg> </span> </a>
                                                    </div>
                                                    <div
                                                        class="qqvfw-quick-view-button-wrapper qqvfw-position--after-add-to-cart qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qqvfw-shortcode qqvfw-m  qqvfw-quick-view-button qqvfw-type--icon-with-text"
                                                            data-item-id="342" data-quick-view-type="pop-up"
                                                            data-quick-view-type-mobile="pop-up"
                                                            href="indexfaad.html?quick_view_button=342"
                                                            data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                            rel="noopener noreferrer"> <span class="qqvfw-m-spinner">
                                                                <svg class="qqvfw-svg--spinner"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span><span
                                                                class="qqvfw-m-icon qqvfw-icon--predefined"> <span
                                                                    class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                                class="qqvfw-m-text"></span> </a>
                                                    </div><a href="index5529.html?add-to-cart=342"
                                                        aria-describedby="woocommerce_loop_add_to_cart_link_describedby_342"
                                                        data-quantity="1"
                                                        class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                        data-product_id="342" data-product_sku="0015"
                                                        aria-label="Add to cart: &ldquo;Shinny Glasses&rdquo;"
                                                        rel="nofollow">Add to cart</a><span
                                                        id="woocommerce_loop_add_to_cart_link_describedby_342"
                                                        class="screen-reader-text">
                                                    </span>
                                                </div>
                                            </div><a href="../shinny-glasses/index.html"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                        </div>
                                    </li>


                                    <li
                                        class="product type-product post-335 status-publish last instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                        <div class="qodef-e-inner">
                                            <div class="qodef-woo-product-image"><img width="600" height="431"
                                                    src="../../wp-content/uploads/2021/07/Shop-Single-07-img-600x431.jpg"
                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                    alt="m" decoding="async"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img.jpg 800w"
                                                    sizes="(max-width: 600px) 100vw, 600px" /></div>
                                            <div class="qodef-woo-product-content">
                                                <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                        href="../thalia-round/index.html"
                                                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Thalia
                                                        Round</a></h6>
                                                <div class="qodef-woo-product-categories qodef-e-info"><a
                                                        href="../../product-category/classic/index.html"
                                                        rel="tag">Classic style</a><span
                                                        class="qodef-info-separator-single"></span><a
                                                        href="../../product-category/round/index.html"
                                                        rel="tag">Round</a>
                                                    <div class="qodef-info-separator-end"></div>
                                                </div>
                                                <span class="price"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>152.00</bdi></span></span>
                                                <div class="qodef-woo-product-image-inner">
                                                    <div
                                                        class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                            href="index342e.html?add_to_wishlist=335" data-item-id="335"
                                                            data-original-item-id="335" aria-label="Add to wishlist"
                                                            data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                            rel="noopener noreferrer"> <span
                                                                class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span> <span class="qwfw-m-icon qwfw--predefined">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                    height="32" viewBox="0 0 32 32"
                                                                    fill="currentColor">
                                                                    <g>
                                                                        <path
                                                                            d="M 31.984,13.834C 31.9,8.926, 27.918,4.552, 23,4.552c-2.844,0-5.35,1.488-7,3.672 C 14.35,6.040, 11.844,4.552, 9,4.552c-4.918,0-8.9,4.374-8.984,9.282L0,13.834 c0,0.030, 0.006,0.058, 0.006,0.088 C 0.006,13.944,0,13.966,0,13.99c0,0.138, 0.034,0.242, 0.040,0.374C 0.48,26.872, 15.874,32, 15.874,32s 15.62-5.122, 16.082-17.616 C 31.964,14.244, 32,14.134, 32,13.99c0-0.024-0.006-0.046-0.006-0.068C 31.994,13.89, 32,13.864, 32,13.834L 31.984,13.834 z M 29.958,14.31 c-0.354,9.6-11.316,14.48-14.080,15.558c-2.74-1.080-13.502-5.938-13.84-15.596C 2.034,14.172, 2.024,14.080, 2.010,13.98 c 0.002-0.036, 0.004-0.074, 0.006-0.112C 2.084,9.902, 5.282,6.552, 9,6.552c 2.052,0, 4.022,1.048, 5.404,2.878 C 14.782,9.93, 15.372,10.224, 16,10.224s 1.218-0.294, 1.596-0.794C 18.978,7.6, 20.948,6.552, 23,6.552c 3.718,0, 6.916,3.35, 6.984,7.316 c0,0.038, 0.002,0.076, 0.006,0.114C 29.976,14.080, 29.964,14.184, 29.958,14.31z" />
                                                                    </g>
                                                                </svg> </span> </a>
                                                    </div>
                                                    <div
                                                        class="qqvfw-quick-view-button-wrapper qqvfw-position--after-add-to-cart qodef-neoocular-theme">
                                                        <a role="button" tabindex="0"
                                                            class="qqvfw-shortcode qqvfw-m  qqvfw-quick-view-button qqvfw-type--icon-with-text"
                                                            data-item-id="335" data-quick-view-type="pop-up"
                                                            data-quick-view-type-mobile="pop-up"
                                                            href="indexc2e7.html?quick_view_button=335"
                                                            data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                            rel="noopener noreferrer"> <span class="qqvfw-m-spinner">
                                                                <svg class="qqvfw-svg--spinner"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                    </path>
                                                                </svg></span><span
                                                                class="qqvfw-m-icon qqvfw-icon--predefined"> <span
                                                                    class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                                class="qqvfw-m-text"></span> </a>
                                                    </div><a href="indexfefc.html?add-to-cart=335"
                                                        aria-describedby="woocommerce_loop_add_to_cart_link_describedby_335"
                                                        data-quantity="1"
                                                        class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                        data-product_id="335" data-product_sku="0013"
                                                        aria-label="Add to cart: &ldquo;Thalia Round&rdquo;"
                                                        rel="nofollow">Add to cart</a><span
                                                        id="woocommerce_loop_add_to_cart_link_describedby_335"
                                                        class="screen-reader-text">
                                                    </span>
                                                </div>
                                            </div><a href="../thalia-round/index.html"
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </section>
                    </div>



                </div>
            </div>
        </main>

    </div><!-- close #qodef-page-inner div from header.php -->
    </div>
@endsection
