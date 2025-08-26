<script>
    window.RS_MODULES = window.RS_MODULES || {};
    window.RS_MODULES.modules = window.RS_MODULES.modules || {};
    window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
    window.RS_MODULES.defered = false;
    window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
    window.RS_MODULES.type = 'compiled';
</script>

<!-- Google Tag Manager for WordPress by gtm4wp.com -->
<script data-cfasync="false" data-pagespeed-no-defer>
    var gtm4wp_datalayer_name = "dataLayer";
    var dataLayer = dataLayer || [];
</script>
<script type="speculationrules">
{"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/*"},{"not":{"href_matches":["\/wp-*.php","\/wp-admin\/*","\/wp-content\/uploads\/*","\/wp-content\/*","\/wp-content\/plugins\/*","\/wp-content\/themes\/neoocular\/*","\/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
<div class="rbt-toolbar" data-theme="Neo Ocular" data-featured="" data-button-position="32%" data-button-horizontal="right"
    data-button-alt="no"></div>
<!-- GTM Container placement set to footer -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLJLSX7" height="0" width="0"
        style="display:none;visibility:hidden" aria-hidden="true"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --><!-- Instagram Feed JS -->
<script type="text/javascript">
    var sbiajaxurl = "{{ asset('v1/wp-admin/admin-ajax.html') }}";
</script>

<div id="qvsfw-notify-modal">
    <div class="qvsfw-notify-modal-overlay"></div>
    <div class="qvsfw-notify-modal-content">
        <a class="qvsfw-m-close" href="#" rel="noopener noreferrer">
            <svg class="class=&quot;qvsfw-svg--close-modal&quot;" xmlns="http://www.w3.org/2000/svg" width="18.1213"
                height="18.1213" viewBox="0 0 18.1213 18.1213">
                <line x1="1.0607" y1="1.0607" x2="17.0607" y2="17.0607" />
                <line x1="17.0607" y1="1.0607" x2="1.0607" y2="17.0607" />
            </svg> </a>
        <div class="qvsfw-notify-modal-content-inner-holder">
            <div class="qvsfw-notify-modal-content-inner">
                <h5 class="qvsfw-m-title">Get Notified</h5>
                <div class="qvsfw-selected-value-holder"></div>
                <p class="qvsfw-m-info">Get notified when this article is back in stock.</p>
                <form class="qvsfw-notify-me-form">
                    <div class="qvsfw-m-fields">
                        <label for="user_email">Email</label>
                        <input type="email" class="qvsfw-m-email" name="user_email" id="user_email"
                            placeholder="Enter your email address*" value="" required />
                    </div>
                    <button type="submit" class="qvsfw-button">Confirm</button>
                    <label class="qvsfw-privacy-policy-label">
                        <input name="privacy-policy" type="checkbox" id="privacy-policy" required>
                        <span>By subscribing, you agree with our <a href="#">Privacy Policy</a></span>
                    </label>
                </form>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    const lazyloadRunObserver = () => {
        const lazyloadBackgrounds = document.querySelectorAll(`.e-con.e-parent:not(.e-lazyloaded)`);
        const lazyloadBackgroundObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    let lazyloadBackground = entry.target;
                    if (lazyloadBackground) {
                        lazyloadBackground.classList.add('e-lazyloaded');
                    }
                    lazyloadBackgroundObserver.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '200px 0px 200px 0px'
        });
        lazyloadBackgrounds.forEach((lazyloadBackground) => {
            lazyloadBackgroundObserver.observe(lazyloadBackground);
        });
    };
    const events = [
        'DOMContentLoaded',
        'elementor/lazyload/observe',
    ];
    events.forEach((event) => {
        document.addEventListener(event, lazyloadRunObserver);
    });
</script>
<div id="qode-quick-view-for-woocommerce-pop-up" class="qqvfw qodef-neoocular-theme qqvfw-type--pop-up">
    <div class="qqvfw-m-overlay"></div>
    <div class="qqvfw-m-content">
        <div class="qqvfw-m-content-inner">
            <a class="qqvfw-m-close qqvfw-icon--predefined" href="#" rel="noopener noreferrer">
                <span class="qodef-icon-elegant-icons icon_close"></span></a>
            <div class="qqvfw-m-product woocommerce single-product"></div>
            <span class="qqvfw-m-spinner">
                <svg class="qqvfw-svg--spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                    </path>
                </svg></span>
        </div>
    </div>
</div>
<input type="hidden" class="qqvfw-hidden-type" data-quick-view-type="pop-up" data-quick-view-type-mobile="pop-up"
    data-quick-view-page-id="65" value="">
<div id="qode-wishlist-for-woocommerce-modal" class="qwfw-m">
    <div class="qwfw-m-overlay"></div>
    <div class="qwfw-m-content">
        <a class="qwfw-m-close" href="#" rel="noopener noreferrer">
            <svg class=qwfw-svg--close-modal xmlns="http://www.w3.org/2000/svg" width="18.1213" height="18.1213"
                viewBox="0 0 18.1213 18.1213" stroke-miterlimit="10" stroke-width="2">
                <line x1="1.0607" y1="1.0607" x2="17.0607" y2="17.0607" />
                <line x1="17.0607" y1="1.0607" x2="1.0607" y2="17.0607" />
            </svg> </a>
        <div class="qwfw-m-product"></div>
    </div>
</div>
<link href="http://fonts.googleapis.com/css?family=Roboto:400%7CWork+Sans:600%7CHeebo:300&amp;display=swap"
    rel="stylesheet" property="stylesheet" media="all" type="text/css">

<script type='text/javascript'>
    (function() {
        var c = document.body.className;
        c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
        document.body.className = c;
    })();
</script>
<script>
    if (typeof revslider_showDoubleJqueryError === "undefined") {
        function revslider_showDoubleJqueryError(sliderID) {
            console.log(
                "You have some jquery.js library include that comes after the Slider Revolution files js inclusion."
            );
            console.log("To fix this, you can:");
            console.log(
                "1. Set 'Module General Options' -> 'Advanced' -> 'jQuery & OutPut Filters' -> 'Put JS to Body' to on"
            );
            console.log("2. Find the double jQuery.js inclusion and remove it");
            return "Double Included jQuery Library";
        }
    }
</script>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" aria-label="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" aria-label="Share"></button>
                <button class="pswp__button pswp__button--fs" aria-label="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" aria-label="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" aria-label="Previous (arrow left)"></button>
            <button class="pswp__button pswp__button--arrow--right" aria-label="Next (arrow right)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<link rel='stylesheet' id='wc-blocks-style-css'
    href='{{ asset('v1/wp-content/plugins/woocommerce/assets/client/blocks/wc-blocksbbf5.css?ver=wc-9.1.4') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='perfect-scrollbar-css'
    href='{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/perfect-scrollbar/perfect-scrollbar0899.css?ver=6.8.1') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='magnific-popup-css'
    href='{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/magnific-popup/magnific-popup0899.css?ver=6.8.1') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='mediaelement-css'
    href='{{ asset('v1/wp-includes/js/mediaelement/mediaelementplayer-legacy.min1f61.css?ver=4.2.17') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='wp-mediaelement-css'
    href='{{ asset('v1/wp-includes/js/mediaelement/wp-mediaelement.min0899.css?ver=6.8.1') }}' type='text/css'
    media='all' />
<style id='global-styles-inline-css' type='text/css'>
    :root {
        --wp--preset--aspect-ratio--square: 1;
        --wp--preset--aspect-ratio--4-3: 4/3;
        --wp--preset--aspect-ratio--3-4: 3/4;
        --wp--preset--aspect-ratio--3-2: 3/2;
        --wp--preset--aspect-ratio--2-3: 2/3;
        --wp--preset--aspect-ratio--16-9: 16/9;
        --wp--preset--aspect-ratio--9-16: 9/16;
        --wp--preset--color--black: #000000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #ffffff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
        --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
        --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
        --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
        --wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
        --wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
        --wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
        --wp--preset--font-family--inter: "Inter", sans-serif;
        --wp--preset--font-family--cardo: Cardo;
        --wp--preset--spacing--20: 0.44rem;
        --wp--preset--spacing--30: 0.67rem;
        --wp--preset--spacing--40: 1rem;
        --wp--preset--spacing--50: 1.5rem;
        --wp--preset--spacing--60: 2.25rem;
        --wp--preset--spacing--70: 3.38rem;
        --wp--preset--spacing--80: 5.06rem;
        --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
        --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
    }

    :where(.is-layout-flex) {
        gap: 0.5em;
    }

    :where(.is-layout-grid) {
        gap: 0.5em;
    }

    body .is-layout-flex {
        display: flex;
    }

    .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
    }

    .is-layout-flex> :is(*, div) {
        margin: 0;
    }

    body .is-layout-grid {
        display: grid;
    }

    .is-layout-grid> :is(*, div) {
        margin: 0;
    }

    :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
    }

    :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
    }

    :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
    }

    :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
    }

    .has-black-color {
        color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-color {
        color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
    }

    .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
    }

    .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
    }

    .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
    }

    .has-cool-to-warm-spectrum-gradient-background {
        background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
    }

    .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
    }

    .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
    }

    .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
    }

    .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
    }

    .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
    }

    .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
    }

    .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
    }

    .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
    }

    .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
    }

    .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
    }
</style>
<link rel='stylesheet' id='photoswipe-css'
    href='{{ asset('v1/wp-content/plugins/woocommerce/assets/css/photoswipe/photoswipe.min4615.css?ver=9.1.4') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='photoswipe-default-skin-css'
    href='{{ asset('v1/wp-content/plugins/woocommerce/assets/css/photoswipe/default-skin/default-skin.min4615.css?ver=9.1.4') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='qqvfw-perfect-scrollbar-css'
    href='{{ asset('v1/wp-content/plugins/qode-quick-view-for-woocommerce/assets/plugins/perfect-scrollbar/perfect-scrollbar.min4b68.css?ver=1.0.4') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css'
    href='{{ asset('v1/wp-content/plugins/revslider/sr6/assets/css/rs6e9af.css?ver=6.7.15') }}' type='text/css'
    media='all' />
<style id='rs-plugin-settings-inline-css' type='text/css'>
    #rev_slider_9_1_wrapper .qodef-rev-nav {
        background: none !important;
        width: 36px;
        height: auto
    }

    #rev_slider_9_1_wrapper .qodef-rev-nav:before {
        display: none !Important
    }

    #rev_slider_9_1_wrapper .qodef-rev-nav.tp-leftarrow .qodef-rev-slider-arrow svg {
        transform: rotate(180deg)
    }

    .qodef-rev-slider-arrow svg polyline {
        display: block;
        fill: none;
        stroke: #ffffff;
        stroke-miterlimit: 10;
        transition: stroke-dashoffset 1.2s ease
    }

    .qodef-rev-slider-arrow svg polyline {
        stroke-dasharray: 100;
        stroke-dashoffset: 0
    }

    .qodef-rev-slider-arrow:hover svg polyline {
        stroke-dashoffset: 200
    }
</style>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/jquery/ui/core.minb37e.js?ver=1.13.3') }}"
    id="jquery-ui-core-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/jquery/ui/datepicker.minb37e.js?ver=1.13.3') }}"
    id="jquery-ui-datepicker-js"></script>
<script type="text/javascript" id="jquery-ui-datepicker-js-after">
    /* <![CDATA[ */
    jQuery(function(jQuery) {
        jQuery.datepicker.setDefaults({
            "closeText": "Close",
            "currentText": "Today",
            "monthNames": ["January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December"
            ],
            "monthNamesShort": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                "Nov", "Dec"
            ],
            "nextText": "Next",
            "prevText": "Previous",
            "dayNames": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "dayNamesShort": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            "dayNamesMin": ["S", "M", "T", "W", "T", "F", "S"],
            "dateFormat": "M d",
            "firstDay": 1,
            "isRTL": false
        });
    });
    /* ]]> */
</script>
<script type="text/javascript" src="{{ asset('v1/wp-content/plugins/booked/assets/js/spin.min7406.js?ver=2.0.1') }}"
    id="booked-spin-js-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-content/plugins/booked/assets/js/spin.jquery7406.js?ver=2.0.1') }}"
    id="booked-spin-jquery-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/booked/assets/js/tooltipster/js/jquery.tooltipster.min9b70.js?ver=3.3.0') }}"
    id="booked-tooltipster-js"></script>
<script type="text/javascript" id="booked-functions-js-extra">
    /* <![CDATA[ */
    var booked_js_vars = {
        "ajax_url": "https:\/\/neoocular.qodeinteractive.com\/wp-admin\/admin-ajax.php",
        "profilePage": "",
        "publicAppointments": "",
        "i18n_confirm_appt_delete": "Are you sure you want to cancel this appointment?",
        "i18n_please_wait": "Please wait ...",
        "i18n_wrong_username_pass": "Wrong username\/password combination.",
        "i18n_fill_out_required_fields": "Please fill out all required fields.",
        "i18n_guest_appt_required_fields": "Please enter your name to book an appointment.",
        "i18n_appt_required_fields": "Please enter your name, your email address and choose a password to book an appointment.",
        "i18n_appt_required_fields_guest": "Please fill in all \"Information\" fields.",
        "i18n_password_reset": "Please check your email for instructions on resetting your password.",
        "i18n_password_reset_error": "That username or email is not recognized."
    };
    /* ]]> */
</script>
<script type="text/javascript" src="{{ asset('v1/wp-content/plugins/booked/assets/js/functions25b6.js?ver=2.3.5') }}"
    id="booked-functions-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/dist/hooks.min4fdd.js?ver=4d63a3d491d11ffd8ac6') }}"
    id="wp-hooks-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/dist/i18n.minc33c.js?ver=5e580eb46a90c2b997e6') }}"
    id="wp-i18n-js"></script>
<script type="text/javascript" id="wp-i18n-js-after">
    /* <![CDATA[ */
    wp.i18n.setLocaleData({
        'text direction\u0004ltr': ['ltr']
    });
    /* ]]> */
</script>
<script type="text/javascript" id="contact-form-7-js-extra">
    /* <![CDATA[ */
    var wpcf7 = {
        "api": {
            "root": "https:\/\/neoocular.qodeinteractive.com\/wp-json\/",
            "namespace": "contact-form-7\/v1"
        }
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster.min4615.js?ver=9.1.4') }}"
    id="sourcebuster-js-js"></script>
<script type="text/javascript" id="wc-order-attribution-js-extra">
    /* <![CDATA[ */
    var wc_order_attribution = {
        "params": {
            "lifetime": 1.0000000000000000818030539140313095458623138256371021270751953125e-5,
            "session": 30,
            "base64": false,
            "ajaxurl": "https:\/\/neoocular.qodeinteractive.com\/wp-admin\/admin-ajax.php",
            "prefix": "wc_order_attribution_",
            "allowTracking": true
        },
        "fields": {
            "source_type": "current.typ",
            "referrer": "current_add.rf",
            "utm_campaign": "current.cmp",
            "utm_source": "current.src",
            "utm_medium": "current.mdm",
            "utm_content": "current.cnt",
            "utm_id": "current.id",
            "utm_term": "current.trm",
            "utm_source_platform": "current.plt",
            "utm_creative_format": "current.fmt",
            "utm_marketing_tactic": "current.tct",
            "session_entry": "current_add.ep",
            "session_start_time": "current_add.fd",
            "session_pages": "session.pgs",
            "session_count": "udata.vst",
            "user_agent": "udata.uag"
        }
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution.min4615.js?ver=9.1.4') }}"
    id="wc-order-attribution-js"></script>
<script type="text/javascript" id="booked-fea-js-js-extra">
    /* <![CDATA[ */
    var booked_fea_vars = {
        "ajax_url": "https:\/\/neoocular.qodeinteractive.com\/wp-admin\/admin-ajax.php",
        "i18n_confirm_appt_delete": "Are you sure you want to cancel this appointment?",
        "i18n_confirm_appt_approve": "Are you sure you want to approve this appointment?"
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/booked/includes/add-ons/frontend-agents/js/functions25b6.js?ver=2.3.5') }}"
    id="booked-fea-js-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/hoverIntent.min3e5a.js?ver=1.10.2') }}"
    id="hoverIntent-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/modernizr/modernizr0899.js?ver=6.8.1') }}"
    id="modernizr-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/parallax-scroll/jquery.parallax-scroll0899.js?ver=6.8.1') }}"
    id="parallax-scroll-js"></script>
<script type="text/javascript" id="neoocular-main-js-js-extra">
    /* <![CDATA[ */
    var qodefGlobal = {
        "vars": {
            "adminBarHeight": 0,
            "iconArrowLeft": "<svg  xmlns=\"http:\/\/www.w3.org\/2000\/svg\" xmlns:xlink=\"http:\/\/www.w3.org\/1999\/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 26 50.9\" xml:space=\"preserve\"><polyline points=\"25.6,0.4 0.7,25.5 25.6,50.6 \"\/><\/svg>",
            "iconArrowRight": "<svg  xmlns=\"http:\/\/www.w3.org\/2000\/svg\" xmlns:xlink=\"http:\/\/www.w3.org\/1999\/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 26 50.9\" xml:space=\"preserve\"><polyline points=\"0.4,50.6 25.3,25.5 0.4,0.4 \"\/><\/svg>",
            "iconClose": "<svg  xmlns=\"http:\/\/www.w3.org\/2000\/svg\" xmlns:xlink=\"http:\/\/www.w3.org\/1999\/xlink\" width=\"32\" height=\"32\" viewBox=\"0 0 32 32\"><g><path d=\"M 10.050,23.95c 0.39,0.39, 1.024,0.39, 1.414,0L 17,18.414l 5.536,5.536c 0.39,0.39, 1.024,0.39, 1.414,0 c 0.39-0.39, 0.39-1.024,0-1.414L 18.414,17l 5.536-5.536c 0.39-0.39, 0.39-1.024,0-1.414c-0.39-0.39-1.024-0.39-1.414,0 L 17,15.586L 11.464,10.050c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 15.586,17l-5.536,5.536 C 9.66,22.926, 9.66,23.56, 10.050,23.95z\"><\/path><\/g><\/svg>",
            "qodefStickyHeaderScrollAmount": 1100,
            "topAreaHeight": 32,
            "restUrl": "https:\/\/neoocular.qodeinteractive.com\/wp-json\/",
            "restNonce": "ca0059bf63",
            "wishlistRestRoute": "neoocular\/v1\/wishlist",
            "loginModalRestRoute": "neoocular\/v1\/login-modal",
            "loginModalGetRestRoute": "neoocular\/v1\/login-modal-get",
            "paginationRestRoute": "neoocular\/v1\/get-posts",
            "wishlistDropdownRestRoute": "neoocular\/v1\/wishlistdropdown",
            "ajaxurl": "https:\/\/neoocular.qodeinteractive.com\/wp-admin\/admin-ajax.php",
            "headerHeight": 110,
            "mobileHeaderHeight": 70
        }
    };
    /* ]]> */
</script>
<script type="text/javascript" src="{{ asset('v1/wp-content/themes/neoocular/assets/js/main.min0899.js?ver=6.8.1') }}"
    id="neoocular-main-js-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/inc/maps/assets/js/custom-marker0899.js?ver=6.8.1') }}"
    id="neoocular-core-map-custom-marker-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/inc/maps/assets/js/markerclusterer0899.js?ver=6.8.1') }}"
    id="markerclusterer-js"></script>
<script type="text/javascript" id="neoocular-core-google-map-js-extra">
    /* <![CDATA[ */
    var qodefMapsVariables = {
        "global": {
            "mapStyle": [{
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#e9e9e9"
                }, {
                    "lightness": 17
                }]
            }, {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                }, {
                    "lightness": 20
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffffff"
                }, {
                    "lightness": 17
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#ffffff"
                }, {
                    "lightness": 29
                }, {
                    "weight": 0.200000000000000011102230246251565404236316680908203125
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffffff"
                }, {
                    "lightness": 18
                }]
            }, {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffffff"
                }, {
                    "lightness": 16
                }]
            }, {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                }, {
                    "lightness": 21
                }]
            }, {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dedede"
                }, {
                    "lightness": 21
                }]
            }, {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "visibility": "on"
                }, {
                    "color": "#ffffff"
                }, {
                    "lightness": 16
                }]
            }, {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "saturation": 36
                }, {
                    "color": "#333333"
                }, {
                    "lightness": 40
                }]
            }, {
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f2f2f2"
                }, {
                    "lightness": 19
                }]
            }, {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#fefefe"
                }, {
                    "lightness": 20
                }]
            }, {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#fefefe"
                }, {
                    "lightness": 17
                }, {
                    "weight": 1.1999999999999999555910790149937383830547332763671875
                }]
            }],
            "mapZoom": 12,
            "mapScrollable": false,
            "mapDraggable": true,
            "streetViewControl": true,
            "zoomControl": true,
            "mapTypeControl": true,
            "fullscreenControl": true,
            "geolocationTitle": "Your location is here"
        },
        "multiple": []
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/inc/maps/assets/js/google-map0899.js?ver=6.8.1') }}"
    id="neoocular-core-google-map-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/assets/js/neoocular-core.min0899.js?ver=6.8.1') }}"
    id="neoocular-core-script-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/jquery/ui/tabs.minb37e.js?ver=1.13.3') }}"
    id="jquery-ui-tabs-js"></script>
<script type="text/javascript" id="neoocular-membership-script-js-extra">
    /* <![CDATA[ */
    var neoocularMembershipGlobal = [];
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-membership/assets/js/neoocular-membership.min0899.js?ver=6.8.1') }}"
    id="neoocular-membership-script-js"></script>
<script type="text/javascript" id="qode-quick-view-for-woocommerce-main-js-extra">
    /* <![CDATA[ */
    var qodeQuickViewForWooCommerceGlobal = {
        "adminBarHeight": "0",
        "protectedDataMessage": "Something went wrong",
        "makeASelectionText": "Please select some product options before adding this product to your cart.",
        "unavailableText": "Sorry, this product is unavailable. Please choose a different combination.",
        "emptyQuantityText": "Please choose the quantity of items you wish to add to your cart...",
        "inStockText": "In stock",
        "checkoutUrl": "https:\/\/neoocular.qodeinteractive.com\/checkout\/",
        "arrowLeft": "<svg class=\"qqvfw-svg--arrow-left\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"9\" height=\"15\"><path d=\"M7.821 15 .001 7.5l.684-.656L7.822 0l1.18 1.312L2.549 7.5l6.453 6.188Z\"\/><\/svg>",
        "arrowRight": "<svg class=\"qqvfw-svg--arrow-right\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"9\" height=\"15\"><path d=\"M1.18 15 9 7.5l-.684-.656L1.179 0l-1.18 1.312L6.452 7.5l-6.453 6.188Z\"\/><\/svg>",
        "restUrl": "https:\/\/neoocular.qodeinteractive.com\/wp-json\/",
        "restNonce": "ca0059bf63",
        "quickViewRestRouteName": "quick-view",
        "quickViewRestRoute": "qode-quick-view-for-woocommerce\/v1\/quick-view"
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/qode-quick-view-for-woocommerce/assets/js/main.min4b68.js?ver=1.0.4') }}"
    id="qode-quick-view-for-woocommerce-main-js"></script>
<script type="text/javascript" id="qode-wishlist-for-woocommerce-main-js-extra">
    /* <![CDATA[ */
    var qodeWishlistForWooCommerceGlobal = {
        "adminBarHeight": "0",
        "restUrl": "https:\/\/neoocular.qodeinteractive.com\/wp-json\/",
        "restNonce": "ca0059bf63",
        "addToWishlistRestRoute": "qode-wishlist-for-woocommerce\/v1\/add-to-wishlist",
        "wishlistTableRestRoute": "qode-wishlist-for-woocommerce\/v1\/wishlist-table",
        "hideWishlistModalTime": "2500",
        "confirmModalHTML": "<div class=\"qwfw-confirm-modal qwfw-m qwfw--opened\">\n\t<div id=\"qwfw-confirm-modal-overlay\" class=\"qwfw-m-overlay\"><\/div>\n\t<div class=\"qwfw-m-content\">\n\t\t<a id=\"qwfw-confirm-close-icon\" class=\"qwfw-m-close\" href=\"#\" rel=\"noopener noreferrer\"><svg  xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"18.1213\" height=\"18.1213\" viewBox=\"0 0 18.1213 18.1213\" stroke-miterlimit=\"10\" stroke-width=\"2\"><line x1=\"1.0607\" y1=\"1.0607\" x2=\"17.0607\" y2=\"17.0607\"\/><line x1=\"17.0607\" y1=\"1.0607\" x2=\"1.0607\" y2=\"17.0607\"\/><\/svg><\/a>\n\t\t<div class=\"qwfw-m-form-wrapper\">\n\t\t\t<p class=\"qwfw-m-form-title\"><\/p>\n\t\t\t<div class=\"qwfw-m-form-actions\">\n\t\t\t\t<button id=\"qwfw-confirm-button-false\" class=\"qwfw-m-form-button button qwfw--no\">Cancel<\/button>\n\t\t\t\t<button id=\"qwfw-confirm-button-true\" class=\"qwfw-m-form-button button qwfw--yes\">Delete<\/button>\n\t\t\t<\/div>\n\t\t<\/div>\n\t<\/div>\n<\/div>\n",
        "confirmSimpleModalHTML": "<div class=\"qwfw-confirm-modal qwfw-m qwfw--simple qwfw--opened\">\n\t<div id=\"qwfw-confirm-modal-overlay\" class=\"qwfw-m-overlay\"><\/div>\n\t<div class=\"qwfw-m-content\">\n\t\t<a id=\"qwfw-confirm-close-icon\" class=\"qwfw-m-close\" href=\"#\" rel=\"noopener noreferrer\"><svg  xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"18.1213\" height=\"18.1213\" viewBox=\"0 0 18.1213 18.1213\" stroke-miterlimit=\"10\" stroke-width=\"2\"><line x1=\"1.0607\" y1=\"1.0607\" x2=\"17.0607\" y2=\"17.0607\"\/><line x1=\"17.0607\" y1=\"1.0607\" x2=\"1.0607\" y2=\"17.0607\"\/><\/svg><\/a>\n\t\t<div class=\"qwfw-m-form-wrapper\">\n\t\t\t<p class=\"qwfw-m-form-title\"><\/p>\n\t\t<\/div>\n\t<\/div>\n<\/div>\n"
    };
    /* ]]> */
</script>
{{-- <script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/qode-wishlist-for-woocommerce/assets/js/main.min62ea.js?ver=1.2') }}"
    id="qode-wishlist-for-woocommerce-main-js"></script> --}}
{{-- <script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/qode-variation-swatches-for-woocommerce-premium/assets/js/main.min4bf4.js?ver=1.0.3') }}"
    id="qode-variation-swatches-for-woocommerce-premium-main-js"></script> --}}
<script type="text/javascript"
    src="{{ asset('v1/wp-content/themes/neoocular/assets/plugins/swiper/swiper.min0899.js?ver=6.8.1') }}"
    id="swiper-js"></script>
<script type="text/javascript" id="qode-variation-swatches-for-woocommerce-main-js-extra">
    /* <![CDATA[ */
    var qodeVariationSwatchesForWooCommerceGlobal = {
        "adminBarHeight": "0",
        "ajaxurl": "https:\/\/neoocular.qodeinteractive.com\/wp-admin\/admin-ajax.php",
        "restUrl": "https:\/\/neoocular.qodeinteractive.com\/wp-json\/",
        "restNonce": "ca0059bf63",
        "notifyModalRestRouteName": "notify-modal",
        "notifyModalRestRoute": "qode-variation-swatches-for-woocommerce\/v1\/notify-modal",
        "changeImageOnHoverOption": "no",
        "productAvailabilityOption": "no",
        "disableOutOfStockOption": "yes",
        "generateVariationUrlOption": "no",
        "enableAjaxInLoop": "no",
        "enableSelectedValueName": "no",
        "iconNotify": "<svg class=\"\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"10.2139\" height=\"11\" viewBox=\"0 0 10.2139 11\"><path d=\"M10.2139,8.6426a.7963.7963,0,0,1-.7856.7861h-2.75A1.5712,1.5712,0,0,1,5.1069,11,1.5712,1.5712,0,0,1,3.5356,9.4287H.7856a.757.757,0,0,1-.5527-.2334A.7557.7557,0,0,1,0,8.6426a5.3877,5.3877,0,0,0,.5586-.54A4.8583,4.8583,0,0,0,1.08,7.3691a5.5234,5.5234,0,0,0,.4575-.9727,7.172,7.172,0,0,0,.3066-1.2646,10.0089,10.0089,0,0,0,.12-1.5957,2.5545,2.5545,0,0,1,.7183-1.7344A3.0328,3.0328,0,0,1,4.5669.8291.6156.6156,0,0,1,4.5176.59a.5694.5694,0,0,1,.1719-.418.593.593,0,0,1,.835,0A.5713.5713,0,0,1,5.6963.59.6156.6156,0,0,1,5.647.8291a3.0328,3.0328,0,0,1,1.8848.9727A2.5545,2.5545,0,0,1,8.25,3.5361a10.0089,10.0089,0,0,0,.12,1.5957,7.172,7.172,0,0,0,.3066,1.2646,5.5234,5.5234,0,0,0,.4575.9727,4.8583,4.8583,0,0,0,.5215.7334A5.3877,5.3877,0,0,0,10.2139,8.6426ZM5.2051,10.4111a.0871.0871,0,0,0-.0981-.0986.89.89,0,0,1-.8838-.8838.0984.0984,0,1,0-.1968,0,1.0786,1.0786,0,0,0,1.0806,1.08A.0864.0864,0,0,0,5.2051,10.4111Z\"\/><\/svg>",
        "loopImageSelectors": "img.wp-post-image,img.attachment-woocommerce_thumbnail, img.qodef-list-image",
        "isWooPage": "",
        "setSrcsetOnLoopImage": "1",
        "setSrcsetOnWooPagesLoopImage": ""
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min0899.js?ver=6.8.1') }}"
    id="perfect-scrollbar-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/themes/neoocular/inc/justified-gallery/assets/js/plugins/jquery.justifiedGallery.min68b3.js?ver=1') }}"
    id="jquery-justified-gallery-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/themes/neoocular/inc/masonry/assets/js/plugins/isotope.pkgd.min0899.js?ver=6.8.1') }}"
    id="isotope-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/themes/neoocular/inc/masonry/assets/js/plugins/packery-mode.pkgd.min0899.js?ver=6.8.1') }}"
    id="packery-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/appear/jquery.appear0899.js?ver=6.8.1') }}"
    id="jquery-appear-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/assets/plugins/magnific-popup/jquery.magnific-popup.min0899.js?ver=6.8.1') }}"
    id="jquery-magnific-popup-js"></script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/jquery/ui/accordion.minb37e.js?ver=1.13.3') }}"
    id="jquery-ui-accordion-js"></script>
<script type="text/javascript" id="mediaelement-core-js-before">
    /* <![CDATA[ */
    var mejsL10n = {
        "language": "en",
        "strings": {
            "mejs.download-file": "Download File",
            "mejs.install-flash": "You are using a browser that does not have Flash player enabled or installed. Please turn on your Flash player plugin or download the latest version from https:\/\/get.adobe.com\/flashplayer\/",
            "mejs.fullscreen": "Fullscreen",
            "mejs.play": "Play",
            "mejs.pause": "Pause",
            "mejs.time-slider": "Time Slider",
            "mejs.time-help-text": "Use Left\/Right Arrow keys to advance one second, Up\/Down arrows to advance ten seconds.",
            "mejs.live-broadcast": "Live Broadcast",
            "mejs.volume-help-text": "Use Up\/Down Arrow keys to increase or decrease volume.",
            "mejs.unmute": "Unmute",
            "mejs.mute": "Mute",
            "mejs.volume-slider": "Volume Slider",
            "mejs.video-player": "Video Player",
            "mejs.audio-player": "Audio Player",
            "mejs.captions-subtitles": "Captions\/Subtitles",
            "mejs.captions-chapters": "Chapters",
            "mejs.none": "None",
            "mejs.afrikaans": "Afrikaans",
            "mejs.albanian": "Albanian",
            "mejs.arabic": "Arabic",
            "mejs.belarusian": "Belarusian",
            "mejs.bulgarian": "Bulgarian",
            "mejs.catalan": "Catalan",
            "mejs.chinese": "Chinese",
            "mejs.chinese-simplified": "Chinese (Simplified)",
            "mejs.chinese-traditional": "Chinese (Traditional)",
            "mejs.croatian": "Croatian",
            "mejs.czech": "Czech",
            "mejs.danish": "Danish",
            "mejs.dutch": "Dutch",
            "mejs.english": "English",
            "mejs.estonian": "Estonian",
            "mejs.filipino": "Filipino",
            "mejs.finnish": "Finnish",
            "mejs.french": "French",
            "mejs.galician": "Galician",
            "mejs.german": "German",
            "mejs.greek": "Greek",
            "mejs.haitian-creole": "Haitian Creole",
            "mejs.hebrew": "Hebrew",
            "mejs.hindi": "Hindi",
            "mejs.hungarian": "Hungarian",
            "mejs.icelandic": "Icelandic",
            "mejs.indonesian": "Indonesian",
            "mejs.irish": "Irish",
            "mejs.italian": "Italian",
            "mejs.japanese": "Japanese",
            "mejs.korean": "Korean",
            "mejs.latvian": "Latvian",
            "mejs.lithuanian": "Lithuanian",
            "mejs.macedonian": "Macedonian",
            "mejs.malay": "Malay",
            "mejs.maltese": "Maltese",
            "mejs.norwegian": "Norwegian",
            "mejs.persian": "Persian",
            "mejs.polish": "Polish",
            "mejs.portuguese": "Portuguese",
            "mejs.romanian": "Romanian",
            "mejs.russian": "Russian",
            "mejs.serbian": "Serbian",
            "mejs.slovak": "Slovak",
            "mejs.slovenian": "Slovenian",
            "mejs.spanish": "Spanish",
            "mejs.swahili": "Swahili",
            "mejs.swedish": "Swedish",
            "mejs.tagalog": "Tagalog",
            "mejs.thai": "Thai",
            "mejs.turkish": "Turkish",
            "mejs.ukrainian": "Ukrainian",
            "mejs.vietnamese": "Vietnamese",
            "mejs.welsh": "Welsh",
            "mejs.yiddish": "Yiddish"
        }
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-includes/js/mediaelement/mediaelement-and-player.min1f61.js?ver=4.2.17') }}"
    id="mediaelement-core-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-includes/js/mediaelement/mediaelement-migrate.min0899.js?ver=6.8.1') }}"
    id="mediaelement-migrate-js"></script>
<script type="text/javascript" id="mediaelement-js-extra">
    /* <![CDATA[ */
    var _wpmejsSettings = {
        "pluginPath": "\/wp-includes\/js\/mediaelement\/",
        "classPrefix": "mejs-",
        "stretching": "responsive",
        "audioShortcodeLibrary": "mediaelement",
        "videoShortcodeLibrary": "mediaelement"
    };
    /* ]]> */
</script>
<script type="text/javascript" src="{{ asset('v1/wp-includes/js/mediaelement/wp-mediaelement.min0899.js?ver=6.8.1') }}"
    id="wp-mediaelement-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-includes/js/mediaelement/renderers/vimeo.min1f61.js?ver=4.2.17') }}"
    id="mediaelement-vimeo-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/woocommerce/assets/js/zoom/jquery.zoom.minb1d9.js?ver=1.7.21-wc.9.1.4') }}"
    id="zoom-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/woocommerce/assets/js/photoswipe/photoswipe.minc867.js?ver=4.1.1-wc.9.1.4') }}"
    id="photoswipe-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/woocommerce/assets/js/photoswipe/photoswipe-ui-default.minc867.js?ver=4.1.1-wc.9.1.4') }}"
    id="photoswipe-ui-default-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" id="wc-single-product-js-extra">
    /* <![CDATA[ */
    var wc_single_product_params = {
        "i18n_required_rating_text": "Please select a rating",
        "review_rating_required": "yes",
        "flexslider": {
            "rtl": false,
            "animation": "slide",
            "smoothHeight": true,
            "directionNav": false,
            "controlNav": "thumbnails",
            "slideshow": false,
            "animationSpeed": 500,
            "animationLoop": false,
            "allowOneSlide": false
        },
        "zoom_enabled": "1",
        "zoom_options": [],
        "photoswipe_enabled": "1",
        "photoswipe_options": {
            "shareEl": false,
            "closeOnScroll": false,
            "history": false,
            "hideAnimationDuration": 0,
            "showAnimationDuration": 0
        },
        "flexslider_enabled": ""
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/woocommerce/assets/js/frontend/single-product.min4615.js?ver=9.1.4') }}"
    id="wc-single-product-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/qode-quick-view-for-woocommerce/assets/plugins/perfect-scrollbar/perfect-scrollbar.mine225.js?ver=1.5.3') }}"
    id="qqvfw-perfect-scrollbar-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/elementor/assets/js/webpack.runtime.min28fc.js?ver=3.23.3') }}"
    id="elementor-webpack-runtime-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/elementor/assets/js/frontend-modules.min28fc.js?ver=3.23.3') }}"
    id="elementor-frontend-modules-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/elementor/assets/lib/waypoints/waypoints.min05da.js?ver=4.0.2') }}"
    id="elementor-waypoints-js"></script>
<script type="text/javascript" id="elementor-frontend-js-before">
    /* <![CDATA[ */
    var elementorFrontendConfig = {
        "environmentMode": {
            "edit": false,
            "wpPreview": false,
            "isScriptDebug": false
        },
        "i18n": {
            "shareOnFacebook": "Share on Facebook",
            "shareOnTwitter": "Share on Twitter",
            "pinIt": "Pin it",
            "download": "Download",
            "downloadImage": "Download image",
            "fullscreen": "Fullscreen",
            "zoom": "Zoom",
            "share": "Share",
            "playVideo": "Play Video",
            "previous": "Previous",
            "next": "Next",
            "close": "Close",
            "a11yCarouselWrapperAriaLabel": "Carousel | Horizontal scrolling: Arrow Left & Right",
            "a11yCarouselPrevSlideMessage": "Previous slide",
            "a11yCarouselNextSlideMessage": "Next slide",
            "a11yCarouselFirstSlideMessage": "This is the first slide",
            "a11yCarouselLastSlideMessage": "This is the last slide",
            "a11yCarouselPaginationBulletMessage": "Go to slide"
        },
        "is_rtl": false,
        "breakpoints": {
            "xs": 0,
            "sm": 480,
            "md": 768,
            "lg": 1025,
            "xl": 1440,
            "xxl": 1600
        },
        "responsive": {
            "breakpoints": {
                "mobile": {
                    "label": "Mobile Portrait",
                    "value": 767,
                    "default_value": 767,
                    "direction": "max",
                    "is_enabled": true
                },
                "mobile_extra": {
                    "label": "Mobile Landscape",
                    "value": 880,
                    "default_value": 880,
                    "direction": "max",
                    "is_enabled": false
                },
                "tablet": {
                    "label": "Tablet Portrait",
                    "value": 1024,
                    "default_value": 1024,
                    "direction": "max",
                    "is_enabled": true
                },
                "tablet_extra": {
                    "label": "Tablet Landscape",
                    "value": 1200,
                    "default_value": 1200,
                    "direction": "max",
                    "is_enabled": false
                },
                "laptop": {
                    "label": "Laptop",
                    "value": 1366,
                    "default_value": 1366,
                    "direction": "max",
                    "is_enabled": false
                },
                "widescreen": {
                    "label": "Widescreen",
                    "value": 2400,
                    "default_value": 2400,
                    "direction": "min",
                    "is_enabled": false
                }
            }
        },
        "version": "3.23.3",
        "is_static": false,
        "experimentalFeatures": {
            "additional_custom_breakpoints": true,
            "container_grid": true,
            "e_swiper_latest": true,
            "e_nested_atomic_repeaters": true,
            "e_onboarding": true,
            "home_screen": true,
            "ai-layout": true,
            "landing-pages": true,
            "e_lazyload": true
        },
        "urls": {
            "assets": "https:\/\/neoocular.qodeinteractive.com\/wp-content\/plugins\/elementor\/assets\/",
            "ajaxurl": "https:\/\/neoocular.qodeinteractive.com\/wp-admin\/admin-ajax.php"
        },
        "nonces": {
            "floatingButtonsClickTracking": "ba0918763b"
        },
        "swiperClass": "swiper",
        "settings": {
            "page": [],
            "editorPreferences": []
        },
        "kit": {
            "active_breakpoints": ["viewport_mobile", "viewport_tablet"],
            "lightbox_enable_counter": "yes",
            "lightbox_enable_fullscreen": "yes",
            "lightbox_enable_zoom": "yes",
            "lightbox_enable_share": "yes",
            "lightbox_title_src": "title",
            "lightbox_description_src": "description"
        },
        "post": {
            "id": 65,
            "title": "Neo%20Ocular%20%E2%80%93%20Optician%20and%20Optical%20Store",
            "excerpt": "",
            "featuredImage": false
        }
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/elementor/assets/js/frontend.min28fc.js?ver=3.23.3') }}"
    id="elementor-frontend-js"></script>
<script type="text/javascript" id="neoocular-core-elementor-js-extra">
    /* <![CDATA[ */
    var qodefElementorGlobal = {
        "vars": {
            "elementorSectionHandler": {
                "162e224": [{
                    "parallax_type": "parallax",
                    "parallax_image": {
                        "url": "{{ asset('store.png') }}",
                        "id": 11167,
                        "size": "",
                        "alt": "store background",
                        "source": "library"
                    }
                }]
            },
            "elementorColumnHandler": ""
        }
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/neoocular-core/inc/plugins/elementor/assets/js/elementor.min0899.js?ver=6.8.1') }}"
    id="neoocular-core-elementor-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/qode-quick-view-for-woocommerce/inc/plugins/elementor/assets/js/elementor0899.js?ver=6.8.1') }}"
    id="qode-quick-view-for-woocommerce-elementor-js"></script>
<script type="text/javascript"
    src="{{ asset('v1/wp-content/plugins/qode-wishlist-for-woocommerce/inc/plugins/elementor/assets/js/elementor0899.js?ver=6.8.1') }}"
    id="qode-wishlist-for-woocommerce-elementor-js"></script>
<script id="rs-initialisation-scripts">
    var tpj = jQuery;

    var revapi9;

    if (window.RS_MODULES === undefined) window.RS_MODULES = {};
    if (RS_MODULES.modules === undefined) RS_MODULES.modules = {};
    RS_MODULES.modules["revslider91"] = {
        once: RS_MODULES.modules["revslider91"] !== undefined ? RS_MODULES.modules["revslider91"].once : undefined,
        init: function() {
            window.revapi9 = window.revapi9 === undefined || window.revapi9 === null || window.revapi9
                .length === 0 ? document.getElementById("rev_slider_9_1") : window.revapi9;
            if (window.revapi9 === null || window.revapi9 === undefined || window.revapi9.length == 0) {
                window.revapi9initTry = window.revapi9initTry === undefined ? 0 : window.revapi9initTry + 1;
                if (window.revapi9initTry < 20) requestAnimationFrame(function() {
                    RS_MODULES.modules["revslider91"].init()
                });
                return;
            }
            window.revapi9 = jQuery(window.revapi9);
            if (window.revapi9.revolution == undefined) {
                revslider_showDoubleJqueryError("rev_slider_9_1");
                return;
            }
            revapi9.revolutionInit({
                revapi: "revapi9",
                DPR: "dpr",
                sliderLayout: "fullscreen",
                visibilityLevels: "1920,1700,1025,680",
                gridwidth: "1300,1100,600,300",
                gridheight: "900,600,820,600",
                lazyType: "smart",
                perspective: 600,
                perspectiveType: "global",
                editorheight: "900,600,820,600",
                responsiveLevels: "1920,1700,1025,680",
                fullScreenOffset: "30px",
                progressBar: {
                    disableProgressBar: true
                },
                navigation: {
                    wheelCallDelay: 1000,
                    onHoverStop: false,
                    touch: {
                        touchenabled: true
                    },
                    arrows: {
                        enable: true,
                        tmp: "<div class=\"qodef-rev-slider-arrow\"><svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\"	 width=\"35.667px\" height=\"69.083px\" viewBox=\"0 0 35.667 69.083\" enable-background=\"new 0 0 35.667 69.083\" xml:space=\"preserve\"><polyline points=\"0.917,0.583 34.752,34.417 0.752,68.417 \"/></svg></div>",
                        style: "qodef-rev-nav",
                        hide_onmobile: true,
                        hide_under: "1250px",
                        left: {
                            h_offset: 30,
                            v_offset: 70
                        },
                        right: {
                            h_offset: 30,
                            v_offset: 70
                        }
                    }
                },
                viewPort: {
                    global: true,
                    globalDist: "-200px",
                    enable: false,
                    visible_area: "1px"
                },
                fallbacks: {
                    allowHTML5AutoPlayOnAndroid: true
                },
            });

        }
    } // End of RevInitScript

    if (window.RS_MODULES.checkMinimal !== undefined) {
        window.RS_MODULES.checkMinimal();
    };
</script>
