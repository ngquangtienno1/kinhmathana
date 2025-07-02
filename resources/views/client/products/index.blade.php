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
                            href="{{ route('client.home') }}"><span itemprop="title">Home</span></a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">Sản phẩm</span></div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content"
                class="qodef-grid qodef-layout--template qodef--no-bottom-space qodef-gutter--medium" role="main">
                <div class="qodef-grid-inner clear">
                    <div id="qodef-woo-page"
                        class="qodef-grid-item qodef-pag e-content-section qodef-col--9 qodef-col-push--3 qodef--list">
                        <header class="woocommerce-products-header">

                        </header>
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="qodef-woo-results">
                            <p class="woocommerce-result-count">
                                Showing 1&ndash;12 of 55 results</p>
                            <form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="Shop order">
                                    <option value="menu_order" selected='selected'>Default sorting</option>
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="rating">Sort by average rating</option>
                                    <option value="date">Sort by latest</option>
                                    <option value="price">Sort by price: low to high</option>
                                    <option value="price-desc">Sort by price: high to low</option>
                                </select>
                                <input type="hidden" name="paged" value="1" />
                            </form>
                        </div>
                        <div class="qodef-woo-product-list qodef-item-layout--info-below qodef-gutter--medium">
                            <ul class="products columns-3">
                                <li
                                    class="product type-product post-253 status-publish first instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-01-img-01-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/gold-glasses/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Gold
                                                    glasses</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="index9056.html?add_to_wishlist=253" data-item-id="253"
                                                        data-original-item-id="253" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="253" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="indexfa3b.html?quick_view_button=253"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="indexe187.html?add-to-cart=253"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_253"
                                                    data-quantity="1"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="253" data-product_sku="005"
                                                    aria-label="Add to cart: &ldquo;Gold glasses&rdquo;"
                                                    rel="nofollow">Add to cart</a><span
                                                    id="woocommerce_loop_add_to_cart_link_describedby_253"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/gold-glasses/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-607 status-publish instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image">
                                            <span class="qodef-woo-product-mark qodef-woo-onsale">Sale</span>
                                            <img loading="lazy" width="600" height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-02-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-02-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" />
                                        </div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/transparent-lennons/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Transparent
                                                    Lennons</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
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
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
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
                                        </div><a href="../product/transparent-lennons/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-295 status-publish last instock product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-03-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-03-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-03-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-03-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-03-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/aviator-classic/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Aviator
                                                    Classic</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>311.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="indexec49.html?add_to_wishlist=295" data-item-id="295"
                                                        data-original-item-id="295" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="295" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="index0d4d.html?quick_view_button=295"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="indexfb29.html?add-to-cart=295"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_295"
                                                    data-quantity="1"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="295" data-product_sku="007"
                                                    aria-label="Add to cart: &ldquo;Aviator Classic&rdquo;"
                                                    rel="nofollow">Add to cart</a><span
                                                    id="woocommerce_loop_add_to_cart_link_describedby_295"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/aviator-classic/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-329 status-publish first instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail virtual purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-04-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/gold-pilot/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Gold
                                                    Pilot</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>437.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="index1640.html?add_to_wishlist=329" data-item-id="329"
                                                        data-original-item-id="329" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="329" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="index147b.html?quick_view_button=329"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="index3103.html?add-to-cart=329"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_329"
                                                    data-quantity="1"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="329" data-product_sku="0011"
                                                    aria-label="Add to cart: &ldquo;Gold Pilot&rdquo;" rel="nofollow">Add
                                                    to cart</a><span id="woocommerce_loop_add_to_cart_link_describedby_329"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/gold-pilot/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-332 status-publish instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image">
                                            <span class="qodef-woo-product-mark qodef-woo-onsale">Sale</span>
                                            <img loading="lazy" width="600" height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-05-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-05-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-05-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-05-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-05-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" />
                                        </div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/way-glasses/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Way
                                                    Glasses</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><del aria-hidden="true"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>214.00</bdi></span></del>
                                                <span class="screen-reader-text">Original price was:
                                                    &#036;214.00.</span><ins aria-hidden="true"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span></ins><span
                                                    class="screen-reader-text">Current price is:
                                                    &#036;199.00.</span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="index08f8.html?add_to_wishlist=332" data-item-id="332"
                                                        data-original-item-id="332" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="332" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="index97da.html?quick_view_button=332"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="index32b7.html?add-to-cart=332"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_332"
                                                    data-quantity="1"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="332" data-product_sku="0012"
                                                    aria-label="Add to cart: &ldquo;Way Glasses&rdquo;" rel="nofollow">Add
                                                    to cart</a><span id="woocommerce_loop_add_to_cart_link_describedby_332"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/way-glasses/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-609 status-publish last instock product_cat-round product_cat-summer-sale product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-06-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-06-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-06-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-06-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-06-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/slim-frame-black/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Slim
                                                    Frame Black</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/round/index.html"
                                                    rel="tag">Round</a><span
                                                    class="qodef-info-separator-single"></span><a
                                                    href="../product-category/summer-sale/index.html"
                                                    rel="tag">Summer Sale</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>200.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="indexb9d5.html?add_to_wishlist=609" data-item-id="609"
                                                        data-original-item-id="609" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="609" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="index15ff.html?quick_view_button=609"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="indexd259.html?add-to-cart=609"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_609"
                                                    data-quantity="1"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="609" data-product_sku="0023"
                                                    aria-label="Add to cart: &ldquo;Slim Frame Black&rdquo;"
                                                    rel="nofollow">Add to cart</a><span
                                                    id="woocommerce_loop_add_to_cart_link_describedby_609"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/slim-frame-black/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-335 status-publish first instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-07-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-07-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/thalia-round/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Thalia
                                                    Round</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
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
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
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
                                        </div><a href="../product/thalia-round/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-339 status-publish instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-08-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-08-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-08-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-08-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-08-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/dark-aviator/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Dark
                                                    Aviator</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>287.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="index5d23.html?add_to_wishlist=339" data-item-id="339"
                                                        data-original-item-id="339" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="339" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="index8aae.html?quick_view_button=339"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="index612c.html?add-to-cart=339"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_339"
                                                    data-quantity="1"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                    data-product_id="339" data-product_sku="0014"
                                                    aria-label="Add to cart: &ldquo;Dark Aviator&rdquo;"
                                                    rel="nofollow">Add to cart</a><span
                                                    id="woocommerce_loop_add_to_cart_link_describedby_339"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/dark-aviator/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-342 status-publish last instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-09-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-09-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/shinny-glasses/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Shinny
                                                    Glasses</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
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
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
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
                                        </div><a href="../product/shinny-glasses/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-402 status-publish first outofstock product_cat-cat-eye product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/shop-single-19-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/shop-single-19-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/shop-single-19-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/shop-single-19-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/shop-single-19-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /><span
                                                class="qodef-woo-product-mark qodef-out-of-stock">Sold</span></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/optical-dark/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Optical
                                                    dark</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/cat-eye/index.html"
                                                    rel="tag">Cat-Eye</a><span
                                                    class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>234.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="indexa316.html?add_to_wishlist=402" data-item-id="402"
                                                        data-original-item-id="402" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="402" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="indexb316.html?quick_view_button=402"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="../product/optical-dark/index.html"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_402"
                                                    data-quantity="1" class="button product_type_simple"
                                                    data-product_id="402" data-product_sku="0018"
                                                    aria-label="Read more about &ldquo;Optical dark&rdquo;"
                                                    rel="nofollow">Read more</a><span
                                                    id="woocommerce_loop_add_to_cart_link_describedby_402"
                                                    class="screen-reader-text">
                                                </span>
                                            </div>
                                        </div><a href="../product/optical-dark/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-235 status-publish instock product_cat-classic product_cat-round product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-simple">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="431"
                                                src="../wp-content/uploads/2021/07/Shop-Single-10-img-600x431.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-10-img.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/wild-round-glasses/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Wild
                                                    Round Glasses</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/classic/index.html" rel="tag">Classic
                                                    style</a><span class="qodef-info-separator-single"></span><a
                                                    href="../product-category/round/index.html" rel="tag">Round</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
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
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
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
                                        </div><a href="../product/wild-round-glasses/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                                <li
                                    class="product type-product post-135 status-publish last instock product_cat-cat-eye product_tag-frame product_tag-stripe has-post-thumbnail shipping-taxable purchasable product-type-variable">
                                    <div class="qodef-e-inner">
                                        <div class="qodef-woo-product-image"><img loading="lazy" width="600"
                                                height="445"
                                                src="../wp-content/uploads/2021/07/Shop-Single-img-01-600x445.jpg"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                alt="m" decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-img-01-600x445.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-img-01-300x222.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-img-01-768x569.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-img-01.jpg 800w"
                                                sizes="(max-width: 600px) 100vw, 600px" /></div>
                                        <div class="qodef-woo-product-content">
                                            <h6 class="qodef-woo-product-title woocommerce-loop-product__title"><a
                                                    href="../product/marshal-glasses/index.html"
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">Marshal
                                                    Glasses</a></h6>
                                            <div class="qodef-woo-product-categories qodef-e-info"><a
                                                    href="../product-category/cat-eye/index.html"
                                                    rel="tag">Cat-Eye</a>
                                                <div class="qodef-info-separator-end"></div>
                                            </div>
                                            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>256.00</bdi></span></span>
                                            <div class="qodef-woo-product-image-inner">
                                                <div
                                                    class="qwfw-add-to-wishlist-wrapper qwfw--loop qwfw-position--after-add-to-cart qwfw-item-type--icon qodef-neoocular-theme">
                                                    <a role="button" tabindex="0"
                                                        class="qwfw-shortcode qwfw-m  qwfw-add-to-wishlist qwfw-spinner-item qwfw-behavior--view qwfw-type--icon"
                                                        href="indexdf22.html?add_to_wishlist=135" data-item-id="135"
                                                        data-original-item-id="135" aria-label="Add to wishlist"
                                                        data-shortcode-atts="{&quot;button_behavior&quot;:&quot;view&quot;,&quot;button_type&quot;:&quot;icon&quot;,&quot;show_count&quot;:&quot;&quot;,&quot;require_login&quot;:false}"
                                                        rel="noopener noreferrer"> <span
                                                            class="qwfw-m-spinner qwfw-spinner-icon"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span> <span class="qwfw-m-icon qwfw--predefined"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="32"
                                                                height="32" viewBox="0 0 32 32" fill="currentColor">
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
                                                        data-item-id="135" data-quick-view-type="pop-up"
                                                        data-quick-view-type-mobile="pop-up"
                                                        href="index077b.html?quick_view_button=135"
                                                        data-shortcode-atts="{&quot;button_type&quot;:&quot;icon-with-text&quot;}"
                                                        rel="noopener noreferrer"> <span class="qqvfw-m-spinner"> <svg
                                                                class="qqvfw-svg--spinner"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path
                                                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                                                </path>
                                                            </svg></span><span class="qqvfw-m-icon qqvfw-icon--predefined">
                                                            <span
                                                                class="qodef-icon-linear-icons lnr-eye lnr"></span></span><span
                                                            class="qqvfw-m-text"></span> </a>
                                                </div><a href="../product/marshal-glasses/index.html"
                                                    aria-describedby="woocommerce_loop_add_to_cart_link_describedby_135"
                                                    data-quantity="1"
                                                    class="button product_type_variable add_to_cart_button qvsfw-ajax-add-to-cart"
                                                    data-product_id="135" data-product_sku="003"
                                                    aria-label="Select options for &ldquo;Marshal Glasses&rdquo;"
                                                    rel="nofollow" data-add-to-cart-text="Add to cart">Select
                                                    options</a><span id="woocommerce_loop_add_to_cart_link_describedby_135"
                                                    class="screen-reader-text">
                                                    This product has multiple variants. The options may be chosen on the
                                                    product page</span>
                                            </div>
                                        </div><a href="../product/marshal-glasses/index.html"
                                            class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <nav class="woocommerce-pagination">
                            <span aria-current="page" class="page-numbers current">01</span>
                            <a class="page-numbers" href="page/2/index.html">02</a>
                            <a class="page-numbers" href="page/3/index.html">03</a>
                            <a class="page-numbers" href="page/4/index.html">04</a>
                            <a class="page-numbers" href="page/5/index.html">05</a>
                            <a class="next page-numbers" href="page/2/index.html"><svg xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="6.344px"
                                    height="10.906px" viewBox="0 0 6.344 10.906" enable-background="new 0 0 6.344 10.906"
                                    xml:space="preserve">
                                    <g>
                                        <path
                                            d="M0.496,9.465l3.953-3.996L0.496,1.473c-0.344-0.315-0.352-0.63-0.021-0.945 c0.329-0.315,0.651-0.315,0.967,0L5.91,4.996c0.143,0.115,0.215,0.272,0.215,0.473c0,0.201-0.072,0.358-0.215,0.473L1.441,10.41 c-0.315,0.315-0.638,0.315-0.967,0C0.145,10.095,0.152,9.78,0.496,9.465z" />
                                    </g>
                                </svg></a>
                        </nav>
                    </div>
                    <div class="qodef-grid-item qodef-page-sidebar-section qodef-col--3 qodef-col-pull--9">
                        <aside id="qodef-page-sidebar" role="complementary">
                            <div class="widget woocommerce widget_product_categories" data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Product categories</h5>
                                <ul class="product-categories">
                                    <li class="cat-item cat-item-16"><a
                                            href="../product-category/cat-eye/index.html">Cat-Eye</a></li>
                                    <li class="cat-item cat-item-15"><a
                                            href="../product-category/classic/index.html">Classic style</a></li>
                                    <li class="cat-item cat-item-75"><a
                                            href="../product-category/eyeglasses-trend/index.html">Eyeglasses Trend</a>
                                    </li>
                                    <li class="cat-item cat-item-51"><a
                                            href="../product-category/lens/index.html">Lens</a></li>
                                    <li class="cat-item cat-item-97"><a
                                            href="../product-category/luxory/index.html">Luxory</a></li>
                                    <li class="cat-item cat-item-77"><a href="../product-category/new/index.html">New</a>
                                    </li>
                                    <li class="cat-item cat-item-73"><a
                                            href="../product-category/new-collection/index.html">New collection</a></li>
                                    <li class="cat-item cat-item-23"><a
                                            href="../product-category/round/index.html">Round</a></li>
                                    <li class="cat-item cat-item-72"><a
                                            href="../product-category/summer-sale/index.html">Summer Sale</a></li>
                                    <li class="cat-item cat-item-48 cat-parent"><a
                                            href="../product-category/top-frames/index.html">Top Frames</a>
                                        <ul class='children'>
                                            <li class="cat-item cat-item-85"><a
                                                    href="../product-category/top-frames/kids/index.html">Kids</a></li>
                                            <li class="cat-item cat-item-79"><a
                                                    href="../product-category/top-frames/men/index.html">Men</a></li>
                                            <li class="cat-item cat-item-84"><a
                                                    href="../product-category/top-frames/unisex/index.html">Unisex</a>
                                            </li>
                                            <li class="cat-item cat-item-78"><a
                                                    href="../product-category/top-frames/women/index.html">Women</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_price_filter" data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Filter by price</h5>
                                <form method="get" action="https://neoocular.qodeinteractive.com/shop/">
                                    <div class="price_slider_wrapper">
                                        <div class="price_slider" style="display:none;"></div>
                                        <div class="price_slider_amount" data-step="10">
                                            <label class="screen-reader-text" for="min_price">Min price</label>
                                            <input type="text" id="min_price" name="min_price" value="110"
                                                data-min="110" placeholder="Min price" />
                                            <label class="screen-reader-text" for="max_price">Max price</label>
                                            <input type="text" id="max_price" name="max_price" value="520"
                                                data-max="520" placeholder="Max price" />
                                            <button type="submit" class="button">Filter</button>
                                            <div class="price_label" style="display:none;">
                                                Price: <span class="from"></span> &mdash; <span class="to"></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Filter by gender</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexcfb7.html?filter_gender=unisex&amp;query_type_gender=or">Unisex</a>
                                        <span class="count">(17)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexe312.html?filter_gender=male&amp;query_type_gender=or">Male</a>
                                        <span class="count">(10)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexee24.html?filter_gender=female&amp;query_type_gender=or">Female</a>
                                        <span class="count">(20)</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Filter by color</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index5e9e.html?filter_color=bronze&amp;query_type_color=or">Bronze</a>
                                        <span class="count">(18)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index2eb4.html?filter_color=orange&amp;query_type_color=or">Orange</a>
                                        <span class="count">(18)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index9d90.html?filter_color=purple&amp;query_type_color=or">Purple</a>
                                        <span class="count">(9)</span>
                                    </li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index4ded.html?filter_color=dark-green&amp;query_type_color=or">Dark
                                            Green</a> <span class="count">(2)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexdb6c.html?filter_color=blue&amp;query_type_color=or">Blue</a> <span
                                            class="count">(1)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexd323.html?filter_color=gold&amp;query_type_color=or">Gold</a> <span
                                            class="count">(18)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexc3cf.html?filter_color=silver&amp;query_type_color=or">Silver</a>
                                        <span class="count">(16)</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav"
                                data-area="shop-sidebar">
                                <h5 class="qodef-widget-title">Filter by size</h5>
                                <ul class="woocommerce-widget-layered-nav-list">
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index0513.html?filter_size=m&amp;query_type_size=or">M</a> <span
                                            class="count">(23)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index8175.html?filter_size=s&amp;query_type_size=or">S</a> <span
                                            class="count">(15)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexb129.html?filter_size=xs&amp;query_type_size=or">XS</a> <span
                                            class="count">(9)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="indexe712.html?filter_size=xl&amp;query_type_size=or">XL</a> <span
                                            class="count">(16)</span></li>
                                    <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term "><a
                                            rel="nofollow"
                                            href="index8160.html?filter_size=l&amp;query_type_size=or">L</a> <span
                                            class="count">(22)</span></li>
                                </ul>
                            </div>
                            <div class="widget widget_block" data-area="shop-sidebar">
                                <div data-block-name="woocommerce/product-search" data-label=""
                                    data-form-id="wc-block-product-search-0"
                                    class="wc-block-product-search wp-block-woocommerce-product-search">
                                    <form role="search" method="get"
                                        action="https://neoocular.qodeinteractive.com/"><label
                                            for="wc-block-search__input-1"
                                            class="wc-block-product-search__label"></label>
                                        <div class="wc-block-product-search__fields">
                                            <input type="search" id="wc-block-search__input-1"
                                                class="wc-block-product-search__field" placeholder="Search products…"
                                                name="s" /><button type="submit"
                                                class="wc-block-product-search__button" aria-label="Search">
                                                <svg aria-hidden="true" role="img" focusable="false"
                                                    class="dashicon dashicons-arrow-right-alt2"
                                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20">
                                                    <path d="M6 15l5-5-5-5 1-2 7 7-7 7z" />
                                                </svg>
                                            </button>
                                            <input type="hidden" name="post_type" value="product" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="widget widget_block widget_media_image" data-area="shop-sidebar">
                                <figure class="wp-block-image size-large"><a href="../vouchers/index.html"><img
                                            fetchpriority="high" fetchpriority="high" decoding="async"
                                            width="1024" height="690"
                                            src="../wp-content/uploads/2021/08/shop-banner-1024x690.jpg" alt=""
                                            class="wp-image-7903"
                                            srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-1024x690.jpg 1024w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-600x404.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-800x539.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-300x202.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner-768x517.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/shop-banner.jpg 1100w"
                                            sizes="(max-width: 1024px) 100vw, 1024px" /></a></figure>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
        </div><!-- close #qodef-page-inner div from header.php -->
    </div><!-- close #qodef-page-outer div from header.php -->
@endsection
