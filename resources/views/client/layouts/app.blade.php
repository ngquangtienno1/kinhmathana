<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

<!-- Mirrored from neoocular.qodeinteractive.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Jun 2025 12:07:11 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

@include('client.components.head')

<body
    class="home wp-singular page-template page-template-page-full-width page-template-page-full-width-php page page-id-65 wp-theme-neoocular theme-neoocular qode-framework-1.2.3 woocommerce-no-js qodef-back-to-top--enabled qodef-custom-blog  qodef-content-behind-header qodef-header--standard qodef-header-appearance--sticky qodef-content--behind-header qodef-mobile-header--standard qodef-drop-down-second--full-width qodef-drop-down-second--default qodef-yith-wccl--predefined qodef-yith-wcqv--predefined qodef-yith-wcwl--predefined neoocular-core-1.1 neoocular-membership-1.0 qode-quick-view-for-woocommerce-1.0.4 qqvfw--no-touch qode-variation-swatches-for-woocommerce-1.0.3 qvsfw--no-touch qode-wishlist-for-woocommerce-1.2 qwfw--no-touch qode-variation-swatches-for-woocommerce-premium-1.0.3 neoocular-1.1 qodef-content-grid-1400 qvsfw-disabled-attribute--crossed-out qodef-header-standard--center qodef-search--covers-header elementor-default elementor-kit-6 elementor-page elementor-page-65"
    itemscope itemtype="https://schema.org/WebPage">
    <a class="skip-link screen-reader-text" href="#qodef-page-content">Skip to the content</a>
    <div id="qodef-page-wrapper" class="">
        @include('client.components.header')
        @yield('content')
        @include('client.components.footer')
        @include('client.components.support-chat')
    </div><!-- close #qodef-page-wrapper div from header.php -->

    @include('client.components.script')
    @stack('scripts')
</body>

</html>
