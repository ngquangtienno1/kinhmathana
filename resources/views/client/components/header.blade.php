<div id="qodef-top-area">
    <div id="qodef-top-area-inner">
        @php
            $contactEmail = getSetting('contact_email');
            $hotline = getSetting('hotline');
            $address = getSetting('address');
            $logoUrl = getSetting('logo_url') ?? asset('images/default-logo.png');
        @endphp
        <div class="qodef-widget-holder qodef--left">
            <div id="neoocular_core_social_icons_group-10"
                class="widget widget_neoocular_core_social_icons_group qodef-top-bar-widget">
                <div class="qodef-social-icons-group">
                    <span class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                        style="margin: 2px 13px 0 0"> <a itemprop="url" href="https://www.facebook.com/QodeInteractive/"
                            target="_blank"> <span class="qodef-icon-elegant-icons social_facebook qodef-icon qodef-e"
                                style="font-size: 12px"></span> </a> </span><span
                        class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                        style="margin: 2px 16px 0 0 "> <a itemprop="url" href="https://twitter.com/qodeinteractive"
                            target="_blank"> <span class="qodef-icon-elegant-icons social_twitter qodef-icon qodef-e"
                                style="font-size: 12px"></span> </a> </span><span
                        class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                        style="margin: 2px 15px 0 0 "> <a itemprop="url"
                            href="https://www.instagram.com/qodeinteractive/" target="_blank"> <span
                                class="qodef-icon-elegant-icons social_instagram qodef-icon qodef-e"
                                style="font-size: 12px"></span> </a> </span><span
                        class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                        style="margin: 2px 1px 0 0"> <a itemprop="url" href="https://www.pinterest.com/qodeinteractive/"
                            target="_blank"> <span class="qodef-icon-elegant-icons social_pinterest qodef-icon qodef-e"
                                style="font-size: 12px"></span> </a> </span>
                </div>
            </div>
            <div id="neoocular_core_icon_list_item-2"
                class="widget widget_neoocular_core_icon_list_item qodef-top-bar-widget">
                <div class="qodef-icon-list-item qodef-icon--icon-pack">
                    <p class="qodef-e-title"> <a itemprop="url" href="mailto:{{ $contactEmail }}" target="_self"> <span
                                class="qodef-e-title-inner"> <span
                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal">
                                    <span class="qodef-icon-elegant-icons icon_mail_alt qodef-icon qodef-e"
                                        style="font-size: 13px"></span> </span> <span
                                    class="qodef-e-title-text">{{ $contactEmail }}</span>
                            </span> </a> </p>
                </div>
            </div>
        </div>
        <div class="qodef-widget-holder qodef--right">
            <div id="neoocular_core_icon_list_item-3"
                class="widget widget_neoocular_core_icon_list_item qodef-top-bar-widget">
                <div class="qodef-icon-list-item qodef-icon--icon-pack">
                    <p class="qodef-e-title"> <a itemprop="url" href="#" target="_blank"> <span
                                class="qodef-e-title-inner"> <span
                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                    style="margin: 0 7px 0 0"> <span
                                        class="qodef-icon-elegant-icons icon_pin_alt qodef-icon qodef-e"
                                        style="font-size: 13px"></span> </span> <span
                                    class="qodef-e-title-text">{{ $address }}</span>
                            </span> </a> </p>
                </div>
            </div>
            <div id="neoocular_core_icon_list_item-4"
                class="widget widget_neoocular_core_icon_list_item qodef-top-bar-widget">
                <div class="qodef-icon-list-item qodef-icon--icon-pack">
                    <p class="qodef-e-title"> <a itemprop="url" href="tel:{{ $hotline }}" target="_self"> <span
                                class="qodef-e-title-inner"> <span
                                    class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                    style="margin: 0 5px 0 -2px"> <span
                                        class="qodef-icon-elegant-icons icon_mobile qodef-icon qodef-e"
                                        style="font-size: 13px"></span> </span> <span class="qodef-e-title-text">SĐT:
                                    {{ $hotline }}</span> </span> </a> </p>
                </div>
            </div>
            <div id="neoocular_core_icon_list_item-5"
                class="widget widget_neoocular_core_icon_list_item qodef-top-bar-widget">
                <div class="qodef-icon-list-item qodef-icon--icon-pack">
                    <p class="qodef-e-title"> <span class="qodef-e-title-inner"> <span
                                class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"> <span
                                    class="qodef-icon-elegant-icons icon_clock_alt qodef-icon qodef-e"
                                    style="font-size: 13px"></span> </span> <span class="qodef-e-title-text">Thứ Hai -
                                Thứ Bảy: 9AM - 9PM</span> </span> </p>
                </div>
            </div>
        </div>
    </div>
</div>
<header id="qodef-page-header" role="banner">
    <div id="qodef-page-header-inner" class=" qodef-skin--dark">
        <div class="qodef-header-wrapper">
            <div class="qodef-header-logo">
                <a itemprop="url" class="qodef-header-logo-link qodef-height--set qodef-source--svg-path"
                    href="{{ route('client.home') }}" rel="home">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 150" width="160" height="150">
                        <!-- HANA -->
                        <text x="50%" y="50%" text-anchor="middle"
                            style="font-family: Arial, sans-serif; font-size: 70px; font-weight: bold; letter-spacing: 14px; fill: #000;">
                            HANA
                        </text>
                        <!-- EYEWEAR -->
                        <text x="50%" y="80%" text-anchor="middle"
                            style="font-family: Arial, sans-serif; font-size: 22px; letter-spacing: 12px; fill: #000;">
                            EYEWEAR
                        </text>
                    </svg>
                </a>
            </div>
            <nav class="qodef-header-navigation" role="navigation" aria-label="Top Menu">
                <ul id="menu-main-menu-1" class="menu">
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-111 qodef--hide-link qodef-menu-item--narrow {{ request()->routeIs('client.home') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a href="{{ route('client.home') }}"><span class="qodef-menu-item-text">Trang chủ<svg
                                    class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                    </li>
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-112 qodef--hide-link qodef-menu-item--narrow {{ request()->is('about-us*') || request()->is('who-we-are*') || request()->is('our-staff*') || request()->is('meet-the-doctor*') || request()->routeIs('client.voucher.index') || request()->is('pricing-plans*') || request()->is('book-an-appointment*') || request()->is('get-in-touch*') || request()->routeIs('client.faq.index') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a onclick="JavaScript: return false;"><span class="qodef-menu-item-text">Trang<svg
                                    class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                        <div class="qodef-drop-down-second">
                            <div class="qodef-drop-down-second-inner">
                                <ul class="sub-menu">
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4641">
                                        <a href="about-us/index.html"><span class="qodef-menu-item-text">About
                                                Us</span></a>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4464">
                                        <a href="{{ route('client.voucher.index') }}"><span
                                                class="qodef-menu-item-text">Mã giảm giá</span></a>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4643">
                                        <a href="{{ route('client.faq.index') }}"><span
                                                class="qodef-menu-item-text">FAQ
                                            </span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-113 qodef--hide-link qodef-menu-item--wide {{ request()->routeIs('client.products.index') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a href="{{ route('client.products.index') }}"><span class="qodef-menu-item-text">Sản
                                phẩm<svg class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                        <div class="qodef-drop-down-second">
                            <div class="qodef-drop-down-second-inner qodef-content-grid">
                                <ul class="sub-menu">
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-370 qodef--hide-link">
                                        <a onclick="JavaScript: return false;"><span class="qodef-menu-item-text">Danh
                                                mục<svg class="qodef-menu-item-arrow"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                                                    height="32" viewBox="0 0 32 32">
                                                    <g>
                                                        <path
                                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                                        </path>
                                                    </g>
                                                </svg></span></a>
                                        <ul class="sub-menu">
                                            @foreach (\App\Models\Category::whereNull('parent_id')->where('is_active', true)->get() as $category)
                                                <li
                                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-{{ $category->id }}">
                                                    <a
                                                        href="{{ route('client.products.index', ['category_id' => $category->id]) }}">
                                                        <span
                                                            class="qodef-menu-item-text">{{ $category->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-347 qodef--hide-link">
                                        <a onclick="JavaScript: return false;"><span
                                                class="qodef-menu-item-text">Thương
                                                hiệu<svg class="qodef-menu-item-arrow"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                                                    height="32" viewBox="0 0 32 32">
                                                    <g>
                                                        <path
                                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                                        </path>
                                                    </g>
                                                </svg></span></a>
                                        <ul class="sub-menu">
                                            @foreach (\App\Models\Brand::where('is_active', true)->get() as $brand)
                                                <li
                                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-{{ $brand->id }}">
                                                    <a
                                                        href="{{ route('client.products.index', ['brand_id' => $brand->id]) }}">
                                                        <span class="qodef-menu-item-text">{{ $brand->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-7770 qodef--hide-link">
                                        <a onclick="JavaScript: return false;"><span class="qodef-menu-item-text">Shop
                                                Pages<svg class="qodef-menu-item-arrow"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                                                    height="32" viewBox="0 0 32 32">
                                                    <g>
                                                        <path
                                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                                        </path>
                                                    </g>
                                                </svg></span></a>
                                        <ul class="sub-menu">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2686">
                                                <a href="{{ route('client.cart.index') }}"><span
                                                        class="qodef-menu-item-text">Giỏ hàng</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2685">
                                                <a href="{{ route('client.orders.index') }}"><span
                                                        class="qodef-menu-item-text">Checkout</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2684">
                                                <a href="{{ route('client.users.index') }}"><span
                                                        class="qodef-menu-item-text">My
                                                        Account</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7769">
                                        <div class="qodef-mega-menu-widget-holder">
                                            <div class="widget widget_neoocular_core_single_image"
                                                data-area="wide-menu">
                                                <div
                                                    class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default  qodef--retina ">
                                                    <div class="qodef-m-image"> <a itemprop="url"
                                                            href="http://127.0.0.1:8000/client/voucher"
                                                            target="_blank"> <img loading="lazy" itemprop="image"
                                                                src="{{ asset('v1/wp-content/uploads/2021/09/wide-menu-banner-img-0001.jpg') }}"
                                                                width="400" height="274" alt="" /> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-114 qodef--hide-link qodef-menu-item--narrow {{ request()->routeIs('client.blog.index') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a href="{{ route('client.blog.index') }}"><span class="qodef-menu-item-text">Tin tức<svg
                                    class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                    </li>
                    <li
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4747 {{ request()->routeIs('client.contact.index') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a href="{{ route('client.contact.index') }}"><span class="qodef-menu-item-text">Liên
                                Hệ</span></a>
                    </li>
                </ul>
            </nav>
            <div class="qodef-widget-holder qodef--one">
                <div id="neoocular_core_search-2"
                    class="widget widget_neoocular_core_search qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    <div class="widget qodef-search-widget">

                        <form id="searchform" class="qodef-search-form" method="get"
                            action="{{ route('client.products.index') }}">
                            <div class="qodef-search-form-inner clear">
                                <input type="text" class="search-field" name="q"
                                    placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
                                <span class="qodef-m-underline"></span>
                                <button type="submit" class="qodef-search-form-button"><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" width="15.22px" height="15.1px" viewBox="0 0 15.22 15.1"
                                        enable-background="new 0 0 15.22 15.1" xml:space="preserve">
                                        <circle fill="none" stroke="currentColor" stroke-miterlimit="10"
                                            cx="9.053" cy="6.167" r="5.667" />
                                        <line fill="none" stroke="currentColor" stroke-width="1.2"
                                            stroke-linecap="round" stroke-miterlimit="10" x1="0.6"
                                            y1="14.5" x2="4.746" y2="10.354" />
                                    </svg></button>
                            </div>
                        </form>
                    </div>

                </div>
                @php
                    $wishlistCount = 0;
                    if (Auth::check()) {
                        $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count();
                    }
                @endphp
                <div id="neoocular_core_qode_wishlist-2"
                    class="widget widget_neoocular_core_qode_wishlist qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    <div class="qodef-wishlist-widget-holder">
                        <div class="qodef-wishlist-inner" style="margin: 0 6px 0 0">
                            <a href="{{ route('client.wishlist.index') }}" class="qodef-wishlist-widget-link"
                                title="View Wishlist">
                                <span class="qodef-wishlist-icon-count-holder">
                                    <span class="qodef-wishlist-widget-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="18px"
                                            height="15.453px" viewBox="0 0 18 15.453"
                                            enable-background="new 0 0 18 15.453" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M18,5.272v0.035v0.035c0,0.023-0.006,0.059-0.018,0.105c-0.012,0.047-0.018,0.083-0.018,0.105c-0.023,0.961-0.217,1.881-0.58,2.76s-0.797,1.641-1.301,2.285c-0.504,0.645-1.102,1.248-1.793,1.811s-1.318,1.02-1.881,1.371s-1.148,0.673-1.757,0.967c-0.61,0.293-1.02,0.475-1.23,0.545S9.047,15.42,8.93,15.468c-0.118-0.047-0.281-0.111-0.492-0.193c-0.211-0.083-0.615-0.264-1.213-0.545s-1.172-0.598-1.723-0.949c-0.551-0.352-1.166-0.814-1.846-1.389c-0.68-0.574-1.271-1.178-1.775-1.811C1.376,9.948,0.949,9.192,0.598,8.313s-0.54-1.798-0.563-2.76c0-0.023-0.006-0.058-0.018-0.105C0.005,5.401,0,5.366,0,5.343V5.308c0-0.023,0-0.047,0-0.07c0.023-1.383,0.533-2.596,1.529-3.639c0.996-1.042,2.174-1.564,3.533-1.564c1.594,0,2.906,0.691,3.938,2.074c1.031-1.383,2.343-2.074,3.937-2.074c1.359,0,2.537,0.522,3.533,1.564C17.466,2.642,17.976,3.854,18,5.237V5.272z M16.875,5.343c0-0.023,0-0.047,0-0.07c-0.023-1.125-0.422-2.092-1.195-2.9s-1.688-1.213-2.742-1.213c-1.219,0-2.227,0.54-3.023,1.617C9.68,3.081,9.375,3.233,9,3.233c-0.375,0-0.68-0.152-0.914-0.457C7.289,1.699,6.281,1.159,5.063,1.159c-1.055,0-1.969,0.404-2.742,1.213s-1.172,1.775-1.195,2.9c0,0.023,0,0.047,0,0.07C1.148,5.39,1.16,5.437,1.16,5.483C1.183,6.515,1.429,7.5,1.898,8.437c0.469,0.938,1.002,1.711,1.6,2.32c0.598,0.61,1.295,1.184,2.092,1.723c0.796,0.54,1.441,0.926,1.934,1.16c0.492,0.234,0.961,0.445,1.406,0.633c0.445-0.188,0.919-0.398,1.424-0.633c0.504-0.234,1.16-0.621,1.968-1.16c0.809-0.539,1.518-1.113,2.127-1.723c0.609-0.609,1.154-1.383,1.635-2.32c0.48-0.937,0.732-1.91,0.756-2.918C16.839,5.448,16.851,5.39,16.875,5.343z" />
                                            </g>
                                        </svg></span>
                                    <span class="qodef-wishlist-count">{{ $wishlistCount }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="neoocular_membership_login_opener-4"
                    class="widget widget_neoocular_membership_login_opener qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    @guest
                        <div class="qodef-login-opener-widget qodef-user-logged--out">
                            <a href="{{ route('client.login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                    y="0px" width="16.289px" height="16.087px" viewBox="0 0 16.289 16.087"
                                    enable-background="new 0 0 16.289 16.087" xml:space="preserve">
                                    <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="8.144"
                                        cy="4.594" r="4.094" />
                                    <path fill="none" stroke="currentColor" stroke-miterlimit="10"
                                        d="M15.677,15.587c-0.633-3.107-3.76-5.469-7.532-5.469 c-3.772,0-6.899,2.362-7.532,5.469H15.677z" />
                                </svg>
                            </a>
                        </div>
                    @endguest
                    @auth
                        <div class="qodef-login-opener-widget qodef-user-logged--in" style="position: relative;">
                            <a href="{{ route('client.users.index') }}" class="qodef-user-dropdown-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                    y="0px" width="16.289px" height="16.087px" viewBox="0 0 16.289 16.087"
                                    enable-background="new 0 0 16.289 16.087" xml:space="preserve">
                                    <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="8.144"
                                        cy="4.594" r="4.094" />
                                    <path fill="none" stroke="currentColor" stroke-miterlimit="10"
                                        d="M15.677,15.587c-0.633-3.107-3.76-5.469-7.532-5.469 c-3.772,0-6.899,2.362-7.532,5.469H15.677z" />
                                </svg>
                            </a>
                            <div class="qodef-user-dropdown-menu"
                                style="display: none; position: absolute; right: 0; top: 75px; background: #fff; border-radius: 10px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); min-width: 180px; z-index: 1000; padding: 18px 0;">
                                <ul style="list-style: none; margin: 0; padding: 0;">
                                    <li style="padding: 8px 24px;"><a href="{{ route('client.users.index') }}"
                                            style="color: #232323; text-decoration: none; display: block;">Tài khoản của
                                            tôi</a></li>
                                    <li style="padding: 8px 24px;"><a href="{{ route('client.orders.index') }}"
                                            style="color: #232323; text-decoration: none; display: block;">Đơn mua</a>
                                    </li>
                                    <li style="padding: 8px 24px;"><a href="{{ route('client.logout') }}"
                                            style="color: #d00; text-decoration: none; display: block;">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var userWidget = document.querySelectorAll('.qodef-user-logged--in');
                                userWidget.forEach(function(widget) {
                                    var dropdown = widget.querySelector('.qodef-user-dropdown-menu');
                                    widget.addEventListener('mouseenter', function() {
                                        dropdown.style.display = 'block';
                                    });
                                    widget.addEventListener('mouseleave', function() {
                                        dropdown.style.display = 'none';
                                    });
                                });
                            });
                        </script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var userWidget = document.querySelector('.qodef-user-logged--in');
                                    var dropdown = userWidget.querySelector('.qodef-user-dropdown-menu');
                                    userWidget.addEventListener('mouseenter', function() {
                                        dropdown.style.display = 'block';
                                    });
                                    userWidget.addEventListener('mouseleave', function() {
                                        dropdown.style.display = 'none';
                                    });
                                });
                            </script>
                        @elseif ($role == 1 || $role == 2)
                            <div class="qodef-login-opener-widget qodef-user-logged--in" style="position: relative;">
                                <a href="#" onclick="event.preventDefault(); document.getElementById('force-logout-form').submit();" class="qodef-user-dropdown-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                        y="0px" width="16.289px" height="16.087px" viewBox="0 0 16.289 16.087"
                                        enable-background="new 0 0 16.289 16.087" xml:space="preserve">
                                        <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="8.144"
                                            cy="4.594" r="4.094" />
                                        <path fill="none" stroke="currentColor" stroke-miterlimit="10"
                                            d="M15.677,15.587c-0.633-3.107-3.76-5.469-7.532-5.469 c-3.772,0-6.899,2.362-7.532,5.469H15.677z" />
                                    </svg>
                                </a>
                                <form id="force-logout-form" action="{{ route('client.logout') }}" method="GET" style="display: none;"></form>
                            </div>
                    @endauth
                </div>
                <div id="neoocular_core_woo_side_area_cart-2"
                    class="widget widget_neoocular_core_woo_side_area_cart qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    <div class="qodef-widget-side-area-cart-inner">
                        <a itemprop="url" class="qodef-m-opener" href="{{ route('client.cart.index') }}">
                            <span class="qodef-m-opener-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px" y="0px" width="13.5px" height="18px" viewBox="0 0 13.5 18"
                                    enable-background="new 0 0 13.5 18" xml:space="preserve">
                                    <g>
                                        <path fill="currentColor" d="M0.334,17.666C0.111,17.443,0,17.179,0,16.875V4.5c0-0.304,0.111-0.568,0.334-0.791
            C0.557,3.486,0.82,3.375,1.125,3.375h2.25c0.023-0.937,0.363-1.734,1.02-2.391C5.05,0.329,5.836,0,6.75,0s1.699,0.329,2.355,0.984
            c0.656,0.656,0.996,1.454,1.019,2.391h2.25c0.305,0,0.568,0.111,0.791,0.334C13.388,3.932,13.5,4.196,13.5,4.5v12.375
            c0,0.304-0.111,0.568-0.334,0.791C12.943,17.889,12.679,18,12.375,18H1.125C0.82,18,0.557,17.889,0.334,17.666z M1.125,4.5v12.375
            h11.25V4.5H1.125z M4.5,3.375H9c-0.023-0.633-0.252-1.166-0.686-1.6C7.88,1.342,7.359,1.125,6.75,1.125
            c-0.61,0-1.131,0.217-1.564,0.65C4.751,2.209,4.523,2.742,4.5,3.375z M4.658,6.592C4.553,6.486,4.5,6.352,4.5,6.188
            c0-0.164,0.053-0.299,0.158-0.404s0.24-0.158,0.404-0.158h3.375c0.164,0,0.299,0.053,0.404,0.158S9,6.024,9,6.188
            c0,0.164-0.053,0.299-0.158,0.404S8.601,6.75,8.438,6.75H5.063C4.898,6.75,4.764,6.697,4.658,6.592z" />
                                    </g>
                                </svg>
                                <span class="qodef-m-opener-count">{{ $cartCount ?? 0 }}</span>
                            </span>
                        </a>
                        <div class="qodef-widget-side-area-cart-content">
                            <div class="qodef-cart-header-holder">
                                <a itemprop="url" class="qodef-m-opener"
                                    href="https://neoocular.qodeinteractive.com/cart/">
                                    <span class="qodef-m-opener-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="13.5px"
                                            height="18px" viewBox="0 0 13.5 18" enable-background="new 0 0 13.5 18"
                                            xml:space="preserve">
                                            <g>
                                                <path fill="currentColor"
                                                    d="M0.334,17.666C0.111,17.443,0,17.179,0,16.875V4.5c0-0.304,0.111-0.568,0.334-0.791
                                            C0.557,3.486,0.82,3.375,1.125,3.375h2.25c0.023-0.937,0.363-1.734,1.02-2.391C5.05,0.329,5.836,0,6.75,0s1.699,0.329,2.355,0.984
                                            c0.656,0.656,0.996,1.454,1.019,2.391h2.25c0.305,0,0.568,0.111,0.791,0.334C13.388,3.932,13.5,4.196,13.5,4.5v12.375
                                            c0,0.304-0.111,0.568-0.334,0.791C12.943,17.889,12.679,18,12.375,18H1.125C0.82,18,0.557,17.889,0.334,17.666z M1.125,4.5v12.375
                                            h11.25V4.5H1.125z M4.5,3.375H9c-0.023-0.633-0.252-1.166-0.686-1.6C7.88,1.342,7.359,1.125,6.75,1.125
                                            c-0.61,0-1.131,0.217-1.564,0.65C4.751,2.209,4.523,2.742,4.5,3.375z M4.658,6.592C4.553,6.486,4.5,6.352,4.5,6.188
                                            c0-0.164,0.053-0.299,0.158-0.404s0.24-0.158,0.404-0.158h3.375c0.164,0,0.299,0.053,0.404,0.158S9,6.024,9,6.188
                                            c0,0.164-0.053,0.299-0.158,0.404S8.601,6.75,8.438,6.75H5.063C4.898,6.75,4.764,6.697,4.658,6.592z" />
                                            </g>
                                        </svg>
                                        <span class="qodef-m-opener-count">{{ $cartCount ?? 0 }}</span>
                                    </span>
                                </a>

                                <h5 class="qodef-cart-title">Giỏ hàng của tôi</h5>

                                <a class="qodef-m-close" href="#">
                                    <span class="qodef-m-close-icon"><span
                                            class="qodef-icon-elegant-icons icon_close"></span></span>
                                </a>
                            </div>
                            @if ($cartCount > 0)
                                <ul class="qodef-woo-side-area-cart">
                                    @foreach ($cartItems as $item)
                                        @php
                                            $cartProduct = $item->variation
                                                ? $item->variation->product
                                                : $item->product;
                                            if ($item->variation && $item->variation->images->count()) {
                                                $featuredImage =
                                                    $item->variation->images->where('is_featured', true)->first() ??
                                                    $item->variation->images->first();
                                            } else {
                                                $featuredImage =
                                                    $cartProduct->images->where('is_featured', true)->first() ??
                                                    $cartProduct->images->first();
                                            }
                                            $imagePath = $featuredImage
                                                ? asset('storage/' . $featuredImage->image_path)
                                                : asset('/path/to/default.jpg');
                                            $productUrl = route('client.products.show', $cartProduct->slug);
                                            $productName = $cartProduct->name;
                                            $variationName =
                                                $item->variation && $item->variation->name
                                                    ? $item->variation->name
                                                    : null;
                                            $price = $item->variation
                                                ? $item->variation->sale_price ?? $item->variation->price
                                                : $cartProduct->sale_price ?? $cartProduct->price;
                                        @endphp
                                        <li class="qodef-woo-side-area-cart-item qodef-e">
                                            <button type="button" class="remove btn-remove-cart-item-header"
                                                data-form-id="remove-cart-item-header-{{ $item->id }}"
                                                aria-label="Xóa {{ $productName }} khỏi giỏ hàng"
                                                style="background:none;border:none;padding:0;margin:0;font-size:22px;line-height:1;color:#d00;cursor:pointer;">
                                                &times;
                                            </button>
                                            <form id="remove-cart-item-header-{{ $item->id }}"
                                                action="{{ route('client.cart.remove', $item->id) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <div class="qodef-e-image">
                                                <a href="{{ $productUrl }}">
                                                    <img src="{{ $imagePath }}" width="60"
                                                        alt="{{ $productName }}">
                                                </a>
                                            </div>
                                            <div class="qodef-e-content">
                                                <h6 itemprop="name" class="qodef-e-title entry-title">
                                                    <a href="{{ $productUrl }}">{{ $productName }}</a>
                                                </h6>
                                                @if ($item->variation)
                                                    <div><small>
                                                            Phân loại:
                                                            @if ($item->variation->color)
                                                                {{ $item->variation->color->name }}
                                                            @endif
                                                            @if ($item->variation->size)
                                                                - {{ $item->variation->size->name }}
                                                            @endif
                                                            @if ($item->variation->spherical_power)
                                                                - {{ $item->variation->spherical_power }}
                                                            @endif
                                                            @if ($item->variation->cylinder_power)
                                                                - {{ $item->variation->cylinder_power }}
                                                            @endif
                                                        </small></div>
                                                @endif
                                                <p class="qodef-e-quantity">Số lượng: {{ $item->quantity }}</p>
                                                <p class="qodef-e-price">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>{{ number_format($price, 0, ',', '.') }}₫</bdi>
                                                    </span>
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="qodef-m-order-details">
                                    <h5 class="qodef-m-order-label">Tổng:</h5>
                                    <h5 class="qodef-m-order-amount">
                                        <span class="woocommerce-Price-amount amount">
                                            <bdi>
                                                @php
                                                    $subtotal = $cartItems->sum(function ($item) {
                                                        $cartProduct = $item->variation
                                                            ? $item->variation->product
                                                            : $item->product;
                                                        $price = $item->variation
                                                            ? $item->variation->sale_price ?? $item->variation->price
                                                            : $cartProduct->sale_price ?? $cartProduct->price;
                                                        return $price * $item->quantity;
                                                    });
                                                @endphp
                                                {{ number_format($subtotal, 0, ',', '.') }}₫
                                            </bdi>
                                        </span>
                                    </h5>
                                </div>
                                <div class="qodef-m-action">
                                    <a itemprop="url" href="{{ route('client.cart.index') }}"
                                        class="qodef-m-action-link">Xem giỏ hàng & Thanh toán</a>
                                </div>
                            @else
                                <p class="qodef-m-posts-not-found">No products in the cart.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="qodef-header-sticky qodef-custom-header-layout qodef-skin--dark qodef-appearance--down">
        <div class="qodef-header-sticky-inner ">
            <a itemprop="url" class="qodef-header-logo-link qodef-height--set qodef-source--svg-path"
                href="{{ route('client.home') }}" rel="home">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 150" width="160" height="150">
                    <!-- HANA -->
                    <text x="50%" y="50%" text-anchor="middle"
                        style="font-family: Arial, sans-serif; font-size: 70px; font-weight: bold; letter-spacing: 14px; fill: #000;">
                        HANA
                    </text>
                    <!-- EYEWEAR -->
                    <text x="50%" y="80%" text-anchor="middle"
                        style="font-family: Arial, sans-serif; font-size: 22px; letter-spacing: 12px; fill: #000;">
                        EYEWEAR
                    </text>
                </svg>
            </a>

            <nav class="qodef-header-navigation" role="navigation" aria-label="Top Menu">
                <ul id="menu-main-menu-2" class="menu">
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-111 qodef--hide-link qodef-menu-item--narrow">
                        <a href="{{ route('client.home') }}"><span class="qodef-menu-item-text">Trang chủ<svg
                                    class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                    </li>
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-112 qodef--hide-link qodef-menu-item--narrow">
                        <a onclick="JavaScript: return false;"><span class="qodef-menu-item-text">Trang<svg
                                    class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                        <div class="qodef-drop-down-second">
                            <div class="qodef-drop-down-second-inner">
                                <ul class="sub-menu">
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4641">
                                        <a href="about-us/index.html"><span class="qodef-menu-item-text">About
                                                Us</span></a>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4464">
                                        <a href="{{ route('client.voucher.index') }}"><span
                                                class="qodef-menu-item-text">Mã giảm giá</span></a>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4643">
                                        <a href="{{ route('client.faq.index') }}"><span
                                                class="qodef-menu-item-text">FAQ
                                            </span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-113 qodef--hide-link qodef-menu-item--wide">
                        <a href="{{ route('client.products.index') }}"><span class="qodef-menu-item-text">Sản
                                phẩm<svg class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                        <div class="qodef-drop-down-second">
                            <div class="qodef-drop-down-second-inner qodef-content-grid">
                                <ul class="sub-menu">
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-370 qodef--hide-link">
                                        <a onclick="JavaScript: return false;"><span class="qodef-menu-item-text">Danh
                                                mục<svg class="qodef-menu-item-arrow"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                                                    height="32" viewBox="0 0 32 32">
                                                    <g>
                                                        <path
                                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                                        </path>
                                                    </g>
                                                </svg></span></a>
                                        <ul class="sub-menu">
                                            @foreach (\App\Models\Category::whereNull('parent_id')->where('is_active', true)->get() as $category)
                                                <li
                                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-{{ $category->id }}">
                                                    <a
                                                        href="{{ route('client.products.index', ['category_id' => $category->id]) }}">
                                                        <span
                                                            class="qodef-menu-item-text">{{ $category->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-347 qodef--hide-link">
                                        <a onclick="JavaScript: return false;"><span
                                                class="qodef-menu-item-text">Thương
                                                hiệu<svg class="qodef-menu-item-arrow"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                                                    height="32" viewBox="0 0 32 32">
                                                    <g>
                                                        <path
                                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                                        </path>
                                                    </g>
                                                </svg></span></a>
                                        <ul class="sub-menu">
                                            @foreach (\App\Models\Brand::where('is_active', true)->get() as $brand)
                                                <li
                                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-{{ $brand->id }}">
                                                    <a
                                                        href="{{ route('client.products.index', ['brand_id' => $brand->id]) }}">

                                                        <span class="qodef-menu-item-text">{{ $brand->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-7770 qodef--hide-link">
                                        <a onclick="JavaScript: return false;"><span class="qodef-menu-item-text">Shop
                                                Pages<svg class="qodef-menu-item-arrow"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                                                    height="32" viewBox="0 0 32 32">
                                                    <g>
                                                        <path
                                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                                        </path>
                                                    </g>
                                                </svg></span></a>
                                        <ul class="sub-menu">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2686">
                                                <a href="{{ route('client.cart.index') }}"><span
                                                        class="qodef-menu-item-text">Giỏ hàng</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2685">
                                                <a href="{{ route('client.orders.index') }}"><span
                                                        class="qodef-menu-item-text">Checkout</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2684">
                                                <a href="{{ route('client.users.index') }}"><span
                                                        class="qodef-menu-item-text">My
                                                        Account</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7769">
                                        <div class="qodef-mega-menu-widget-holder">
                                            <div class="widget widget_neoocular_core_single_image"
                                                data-area="wide-menu">
                                                <div
                                                    class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default  qodef--retina ">
                                                    <div class="qodef-m-image"> <a itemprop="url"
                                                            href="shop/index.html" target="_blank"> <img
                                                                loading="lazy" itemprop="image"
                                                                src="{{ asset('v1/wp-content/uploads/2021/09/wide-menu-banner-img-0001.jpg') }}"
                                                                width="400" height="274" alt="" /> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-114 qodef--hide-link qodef-menu-item--narrow {{ request()->routeIs('client.blog.index') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a href="{{ route('client.blog.index') }}"><span class="qodef-menu-item-text">Tin tức<svg
                                    class="qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <g>
                                        <path
                                            d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z">
                                        </path>
                                    </g>
                                </svg></span></a>
                    </li>
                    <li
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4747 {{ request()->routeIs('client.contact.index') ? 'current-menu-ancestor current-menu-parent' : '' }}">
                        <a href="{{ route('client.contact.index') }}"><span class="qodef-menu-item-text">Liên
                                Hệ</span></a>
                    </li>
                </ul>
            </nav>
            <div class="qodef-widget-holder qodef--one">
                <div id="neoocular_core_search-2"
                    class="widget widget_neoocular_core_search qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    <div class="widget qodef-search-widget">

                        <form id="searchform" class="qodef-search-form" method="get"
                            action="{{ route('client.products.index') }}">
                            <div class="qodef-search-form-inner clear">
                                <input type="text" class="search-field" name="q"
                                    placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
                                <span class="qodef-m-underline"></span>
                                <button type="submit" class="qodef-search-form-button"><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" width="15.22px" height="15.1px" viewBox="0 0 15.22 15.1"
                                        enable-background="new 0 0 15.22 15.1" xml:space="preserve">
                                        <circle fill="none" stroke="currentColor" stroke-miterlimit="10"
                                            cx="9.053" cy="6.167" r="5.667" />
                                        <line fill="none" stroke="currentColor" stroke-width="1.2"
                                            stroke-linecap="round" stroke-miterlimit="10" x1="0.6"
                                            y1="14.5" x2="4.746" y2="10.354" />
                                    </svg></button>
                            </div>
                        </form>
                    </div>

                </div>
                @php
                    $wishlistCount = 0;
                    if (Auth::check()) {
                        $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count();
                    }
                @endphp
                <div id="neoocular_core_qode_wishlist-2"
                    class="widget widget_neoocular_core_qode_wishlist qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    <div class="qodef-wishlist-widget-holder">
                        <div class="qodef-wishlist-inner" style="margin: 0 6px 0 0">
                            <a href="{{ route('client.wishlist.index') }}" class="qodef-wishlist-widget-link"
                                title="View Wishlist">
                                <span class="qodef-wishlist-icon-count-holder">
                                    <span class="qodef-wishlist-widget-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="18px"
                                            height="15.453px" viewBox="0 0 18 15.453"
                                            enable-background="new 0 0 18 15.453" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M18,5.272v0.035v0.035c0,0.023-0.006,0.059-0.018,0.105c-0.012,0.047-0.018,0.083-0.018,0.105c-0.023,0.961-0.217,1.881-0.58,2.76s-0.797,1.641-1.301,2.285c-0.504,0.645-1.102,1.248-1.793,1.811s-1.318,1.02-1.881,1.371s-1.148,0.673-1.757,0.967c-0.61,0.293-1.02,0.475-1.23,0.545S9.047,15.42,8.93,15.468c-0.118-0.047-0.281-0.111-0.492-0.193c-0.211-0.083-0.615-0.264-1.213-0.545s-1.172-0.598-1.723-0.949c-0.551-0.352-1.166-0.814-1.846-1.389c-0.68-0.574-1.271-1.178-1.775-1.811C1.376,9.948,0.949,9.192,0.598,8.313s-0.54-1.798-0.563-2.76c0-0.023-0.006-0.058-0.018-0.105C0.005,5.401,0,5.366,0,5.343V5.308c0-0.023,0-0.047,0-0.07c0.023-1.383,0.533-2.596,1.529-3.639c0.996-1.042,2.174-1.564,3.533-1.564c1.594,0,2.906,0.691,3.938,2.074c1.031-1.383,2.343-2.074,3.937-2.074c1.359,0,2.537,0.522,3.533,1.564C17.466,2.642,17.976,3.854,18,5.237V5.272z M16.875,5.343c0-0.023,0-0.047,0-0.07c-0.023-1.125-0.422-2.092-1.195-2.9s-1.688-1.213-2.742-1.213c-1.219,0-2.227,0.54-3.023,1.617C9.68,3.081,9.375,3.233,9,3.233c-0.375,0-0.68-0.152-0.914-0.457C7.289,1.699,6.281,1.159,5.063,1.159c-1.055,0-1.969,0.404-2.742,1.213s-1.172,1.775-1.195,2.9c0,0.023,0,0.047,0,0.07C1.148,5.39,1.16,5.437,1.16,5.483C1.183,6.515,1.429,7.5,1.898,8.437c0.469,0.938,1.002,1.711,1.6,2.32c0.598,0.61,1.295,1.184,2.092,1.723c0.796,0.54,1.441,0.926,1.934,1.16c0.492,0.234,0.961,0.445,1.406,0.633c0.445-0.188,0.919-0.398,1.424-0.633c0.504-0.234,1.16-0.621,1.968-1.16c0.809-0.539,1.518-1.113,2.127-1.723c0.609-0.609,1.154-1.383,1.635-2.32c0.48-0.937,0.732-1.91,0.756-2.918C16.839,5.448,16.851,5.39,16.875,5.343z" />
                                            </g>
                                        </svg></span>
                                    <span class="qodef-wishlist-count">{{ $wishlistCount }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="neoocular_membership_login_opener-4"
                    class="widget widget_neoocular_membership_login_opener qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    @guest
                        <div class="qodef-login-opener-widget qodef-user-logged--out">
                            <a href="{{ route('client.login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                    y="0px" width="16.289px" height="16.087px" viewBox="0 0 16.289 16.087"
                                    enable-background="new 0 0 16.289 16.087" xml:space="preserve">
                                    <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="8.144"
                                        cy="4.594" r="4.094" />
                                    <path fill="none" stroke="currentColor" stroke-miterlimit="10"
                                        d="M15.677,15.587c-0.633-3.107-3.76-5.469-7.532-5.469 c-3.772,0-6.899,2.362-7.532,5.469H15.677z" />
                                </svg>
                            </a>
                        </div>
                    @endguest
                    @auth
                        <div class="qodef-login-opener-widget qodef-user-logged--in" style="position: relative;">
                            <a href="{{ route('client.users.index') }}" class="qodef-user-dropdown-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                    y="0px" width="16.289px" height="16.087px" viewBox="0 0 16.289 16.087"
                                    enable-background="new 0 0 16.289 16.087" xml:space="preserve">
                                    <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="8.144"
                                        cy="4.594" r="4.094" />
                                    <path fill="none" stroke="currentColor" stroke-miterlimit="10"
                                        d="M15.677,15.587c-0.633-3.107-3.76-5.469-7.532-5.469 c-3.772,0-6.899,2.362-7.532,5.469H15.677z" />
                                </svg>
                            </a>
                            <div class="qodef-user-dropdown-menu"
                                style="display: none; position: absolute; right: 0; top: 75px; background: #fff; border-radius: 10px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); min-width: 180px; z-index: 1000; padding: 18px 0;">
                                <ul style="list-style: none; margin: 0; padding: 0;">
                                    <li style="padding: 8px 24px;"><a href="{{ route('client.users.index') }}"
                                            style="color: #232323; text-decoration: none; display: block;">Tài khoản của
                                            tôi</a></li>
                                    <li style="padding: 8px 24px;"><a href="{{ route('client.orders.index') }}"
                                            style="color: #232323; text-decoration: none; display: block;">Đơn mua</a>
                                    </li>
                                    <li style="padding: 8px 24px;"><a href="{{ route('client.logout') }}"
                                            style="color: #d00; text-decoration: none; display: block;">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var userWidget = document.querySelectorAll('.qodef-user-logged--in');
                                userWidget.forEach(function(widget) {
                                    var dropdown = widget.querySelector('.qodef-user-dropdown-menu');
                                    widget.addEventListener('mouseenter', function() {
                                        dropdown.style.display = 'block';
                                    });
                                    widget.addEventListener('mouseleave', function() {
                                        dropdown.style.display = 'none';
                                    });
                                });
                            });
                        </script>
                    @endauth
                </div>
                <div id="neoocular_core_woo_side_area_cart-2"
                    class="widget widget_neoocular_core_woo_side_area_cart qodef-header-widget-area-one"
                    data-area="header-widget-one">
                    <div class="qodef-widget-side-area-cart-inner">
                        <a itemprop="url" class="qodef-m-opener" href="{{ route('client.cart.index') }}">
                            <span class="qodef-m-opener-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px" y="0px" width="13.5px" height="18px" viewBox="0 0 13.5 18"
                                    enable-background="new 0 0 13.5 18" xml:space="preserve">
                                    <g>
                                        <path fill="currentColor" d="M0.334,17.666C0.111,17.443,0,17.179,0,16.875V4.5c0-0.304,0.111-0.568,0.334-0.791
            C0.557,3.486,0.82,3.375,1.125,3.375h2.25c0.023-0.937,0.363-1.734,1.02-2.391C5.05,0.329,5.836,0,6.75,0s1.699,0.329,2.355,0.984
            c0.656,0.656,0.996,1.454,1.019,2.391h2.25c0.305,0,0.568,0.111,0.791,0.334C13.388,3.932,13.5,4.196,13.5,4.5v12.375
            c0,0.304-0.111,0.568-0.334,0.791C12.943,17.889,12.679,18,12.375,18H1.125C0.82,18,0.557,17.889,0.334,17.666z M1.125,4.5v12.375
            h11.25V4.5H1.125z M4.5,3.375H9c-0.023-0.633-0.252-1.166-0.686-1.6C7.88,1.342,7.359,1.125,6.75,1.125
            c-0.61,0-1.131,0.217-1.564,0.65C4.751,2.209,4.523,2.742,4.5,3.375z M4.658,6.592C4.553,6.486,4.5,6.352,4.5,6.188
            c0-0.164,0.053-0.299,0.158-0.404s0.24-0.158,0.404-0.158h3.375c0.164,0,0.299,0.053,0.404,0.158S9,6.024,9,6.188
            c0,0.164-0.053,0.299-0.158,0.404S8.601,6.75,8.438,6.75H5.063C4.898,6.75,4.764,6.697,4.658,6.592z" />
                                    </g>
                                </svg>
                                <span class="qodef-m-opener-count">{{ $cartCount ?? 0 }}</span>
                            </span>
                        </a>
                        <div class="qodef-widget-side-area-cart-content">
                            <div class="qodef-cart-header-holder">
                                <a itemprop="url" class="qodef-m-opener"
                                    href="https://neoocular.qodeinteractive.com/cart/">
                                    <span class="qodef-m-opener-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="13.5px"
                                            height="18px" viewBox="0 0 13.5 18" enable-background="new 0 0 13.5 18"
                                            xml:space="preserve">
                                            <g>
                                                <path fill="currentColor"
                                                    d="M0.334,17.666C0.111,17.443,0,17.179,0,16.875V4.5c0-0.304,0.111-0.568,0.334-0.791
                                            C0.557,3.486,0.82,3.375,1.125,3.375h2.25c0.023-0.937,0.363-1.734,1.02-2.391C5.05,0.329,5.836,0,6.75,0s1.699,0.329,2.355,0.984
                                            c0.656,0.656,0.996,1.454,1.019,2.391h2.25c0.305,0,0.568,0.111,0.791,0.334C13.388,3.932,13.5,4.196,13.5,4.5v12.375
                                            c0,0.304-0.111,0.568-0.334,0.791C12.943,17.889,12.679,18,12.375,18H1.125C0.82,18,0.557,17.889,0.334,17.666z M1.125,4.5v12.375
                                            h11.25V4.5H1.125z M4.5,3.375H9c-0.023-0.633-0.252-1.166-0.686-1.6C7.88,1.342,7.359,1.125,6.75,1.125
                                            c-0.61,0-1.131,0.217-1.564,0.65C4.751,2.209,4.523,2.742,4.5,3.375z M4.658,6.592C4.553,6.486,4.5,6.352,4.5,6.188
                                            c0-0.164,0.053-0.299,0.158-0.404s0.24-0.158,0.404-0.158h3.375c0.164,0,0.299,0.053,0.404,0.158S9,6.024,9,6.188
                                            c0,0.164-0.053,0.299-0.158,0.404S8.601,6.75,8.438,6.75H5.063C4.898,6.75,4.764,6.697,4.658,6.592z" />
                                            </g>
                                        </svg>
                                        <span class="qodef-m-opener-count">{{ $cartCount ?? 0 }}</span>
                                    </span>
                                </a>

                                <h5 class="qodef-cart-title">Giỏ hàng của tôi</h5>

                                <a class="qodef-m-close" href="#">
                                    <span class="qodef-m-close-icon"><span
                                            class="qodef-icon-elegant-icons icon_close"></span></span>
                                </a>
                            </div>
                            @if ($cartCount > 0)
                                <ul class="qodef-woo-side-area-cart">
                                    @foreach ($cartItems as $item)
                                        @php
                                            $cartProduct = $item->variation
                                                ? $item->variation->product
                                                : $item->product;
                                            if ($item->variation && $item->variation->images->count()) {
                                                $featuredImage =
                                                    $item->variation->images->where('is_featured', true)->first() ??
                                                    $item->variation->images->first();
                                            } else {
                                                $featuredImage =
                                                    $cartProduct->images->where('is_featured', true)->first() ??
                                                    $cartProduct->images->first();
                                            }
                                            $imagePath = $featuredImage
                                                ? asset('storage/' . $featuredImage->image_path)
                                                : asset('/path/to/default.jpg');
                                            $productUrl = route('client.products.show', $cartProduct->slug);
                                            $productName = $cartProduct->name;
                                            $variationName =
                                                $item->variation && $item->variation->name
                                                    ? $item->variation->name
                                                    : null;
                                            $price = $item->variation
                                                ? $item->variation->sale_price ?? $item->variation->price
                                                : $cartProduct->sale_price ?? $cartProduct->price;
                                        @endphp
                                        <li class="qodef-woo-side-area-cart-item qodef-e">
                                            <button type="button" class="remove btn-remove-cart-item-header"
                                                data-form-id="remove-cart-item-header-{{ $item->id }}"
                                                aria-label="Xóa {{ $productName }} khỏi giỏ hàng"
                                                style="background:none;border:none;padding:0;margin:0;font-size:22px;line-height:1;color:#d00;cursor:pointer;">
                                                &times;
                                            </button>
                                            <form id="remove-cart-item-header-{{ $item->id }}"
                                                action="{{ route('client.cart.remove', $item->id) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <div class="qodef-e-image">
                                                <a href="{{ $productUrl }}">
                                                    <img src="{{ $imagePath }}" width="60"
                                                        alt="{{ $productName }}">
                                                </a>
                                            </div>
                                            <div class="qodef-e-content">
                                                <h6 itemprop="name" class="qodef-e-title entry-title">
                                                    <a href="{{ $productUrl }}">{{ $productName }}</a>
                                                </h6>
                                                @if ($variationName)
                                                    <div><small>Phân loại: {{ $variationName }}</small></div>
                                                @endif
                                                @if ($item->variation)
                                                    <div><small>
                                                            Phân loại:
                                                            @if ($item->variation->color)
                                                                {{ $item->variation->color->name }}
                                                            @endif
                                                            @if ($item->variation->size)
                                                                - {{ $item->variation->size->name }}
                                                            @endif
                                                            @if ($item->variation->spherical_power)
                                                                - {{ $item->variation->spherical_power }}
                                                            @endif
                                                            @if ($item->variation->cylinder_power)
                                                                - {{ $item->variation->cylinder_power }}
                                                            @endif
                                                        </small></div>
                                                @endif
                                                <p class="qodef-e-quantity">Số lượng: {{ $item->quantity }}</p>
                                                <p class="qodef-e-price">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>{{ number_format($price, 0, ',', '.') }}₫</bdi>
                                                    </span>
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="qodef-m-order-details">
                                    <h5 class="qodef-m-order-label">Tổng:</h5>
                                    <h5 class="qodef-m-order-amount">
                                        <span class="woocommerce-Price-amount amount">
                                            <bdi>
                                                @php
                                                    $subtotal = $cartItems->sum(function ($item) {
                                                        $cartProduct = $item->variation
                                                            ? $item->variation->product
                                                            : $item->product;
                                                        $price = $item->variation
                                                            ? $item->variation->sale_price ?? $item->variation->price
                                                            : $cartProduct->sale_price ?? $cartProduct->price;
                                                        return $price * $item->quantity;
                                                    });
                                                @endphp
                                                {{ number_format($subtotal, 0, ',', '.') }}₫
                                            </bdi>
                                        </span>
                                    </h5>
                                </div>
                                <div class="qodef-m-action">
                                    <a itemprop="url" href="{{ route('client.cart.index') }}"
                                        class="qodef-m-action-link">Xem giỏ hàng & Thanh toán</a>
                                </div>
                            @else
                                <p class="qodef-m-posts-not-found">No products in the cart.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-remove-cart-item-header').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var formId = btn.getAttribute('data-form-id');
                var form = document.getElementById(formId);
                if (!form) return;
                var action = form.getAttribute('action');
                var csrf = form.querySelector('input[name="_token"]').value;
                fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        },
                        body: new URLSearchParams({
                            '_method': 'DELETE'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        location.reload();
                    });
            });
        });
    });
</script>
