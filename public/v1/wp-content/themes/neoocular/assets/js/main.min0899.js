!(function (a) {
    (window.qodef = {}),
        (qodef.body = a("body")),
        (qodef.html = a("html")),
        (qodef.window = a(window)),
        (qodef.windowWidth = a(window).width()),
        (qodef.windowHeight = a(window).height()),
        (qodef.scroll = 0),
        a(document).ready(function () {
            (qodef.scroll = a(window).scrollTop()),
                i.init(),
                _.init(),
                o.init(),
                r.init();
        }),
        a(window).resize(function () {
            (qodef.windowWidth = a(window).width()),
                (qodef.windowHeight = a(window).height());
        }),
        a(window).scroll(function () {
            qodef.scroll = a(window).scrollTop();
        }),
        a(document).on("neoocular_trigger_get_new_posts", function () {
            _.init(), o.init();
        });
    var i = {
        init: function () {
            i.addBodyClassName();
        },
        isBrowser: function (e) {
            var t = !1;
            switch (e) {
                case "chrome":
                    t =
                        /Chrome/.test(navigator.userAgent) &&
                        /Google Inc/.test(navigator.vendor);
                    break;
                case "safari":
                    t =
                        /Safari/.test(navigator.userAgent) &&
                        /Apple Computer/.test(navigator.vendor);
                    break;
                case "firefox":
                    t =
                        -1 <
                        navigator.userAgent
                            .toLowerCase()
                            .indexOf("firefox");
                    break;
                case "ie":
                    t =
                        0 < window.navigator.userAgent.indexOf("MSIE ") ||
                        !!navigator.userAgent.match(/Trident.*rv\:11\./);
                    break;
                case "edge":
                    t = /Edge\/\d./i.test(navigator.userAgent);
            }
            return t;
        },
        addBodyClassName: function () {
            a.each(
                ["chrome", "safari", "firefox", "ie", "edge"],
                function (e, t) {
                    i.isBrowser(t) &&
                        void 0 !== qodef.body &&
                        ("ie" === t && (t = "ms-explorer"),
                            qodef.body.addClass("qodef-browser--" + t));
                }
            );
        },
    },
        _ = {
            init: function (e) {
                (this.holder = a(".qodef-swiper-container")),
                    a.extend(this.holder, e),
                    this.holder.length &&
                    this.holder.each(function () {
                        _.initSlider(a(this));
                    });
            },
            initSlider: function (e) {
                var t = _.getOptions(e),
                    i = _.getEvents(e, t);
                new Swiper(e[0], Object.assign(t, i));
            },
            getOptions: function (e, t) {
                var i = void 0 !== e.data("options") ? e.data("options") : {},
                    o =
                        void 0 !== i.direction && "" !== i.direction
                            ? i.direction
                            : "horizontal",
                    n =
                        void 0 !== i.spaceBetween && "" !== i.spaceBetween
                            ? i.spaceBetween
                            : 0,
                    a =
                        void 0 !== i.slidesPerView && "" !== i.slidesPerView
                            ? i.slidesPerView
                            : 1,
                    r =
                        void 0 !== i.centeredSlides &&
                        "" !== i.centeredSlides &&
                        i.centeredSlides,
                    s =
                        void 0 !== i.sliderScroll &&
                        "" !== i.sliderScroll &&
                        i.sliderScroll,
                    d = void 0 === i.loop || "" === i.loop || i.loop,
                    l =
                        void 0 === i.autoplay ||
                        "" === i.autoplay ||
                        i.autoplay,
                    c =
                        void 0 !== i.speed && "" !== i.speed
                            ? parseInt(i.speed, 10)
                            : 5e3,
                    f =
                        void 0 !== i.speedAnimation && "" !== i.speedAnimation
                            ? parseInt(i.speedAnimation, 10)
                            : 800,
                    u =
                        void 0 !== i.slideAnimation && "" !== i.slideAnimation
                            ? i.slideAnimation
                            : "",
                    h =
                        void 0 !== i.customStages &&
                        "" !== i.customStages &&
                        i.customStages,
                    g =
                        void 0 !== i.outsideNavigation &&
                        "yes" === i.outsideNavigation,
                    p = g
                        ? ".swiper-button-next-" + i.unique
                        : e.children(".swiper-button-next").length
                            ? e.children(".swiper-button-next")[0]
                            : null,
                    g = g
                        ? ".swiper-button-prev-" + i.unique
                        : e.children(".swiper-button-prev").length
                            ? e.children(".swiper-button-prev")[0]
                            : null,
                    m = e.children(".swiper-pagination").length
                        ? e.children(".swiper-pagination")[0]
                        : null,
                    c =
                        (!0 === l &&
                            ((l = { disableOnInteraction: !1 }), 5e3 !== c) &&
                            (l.delay = c),
                            void 0 !== i.slidesPerView1440 &&
                                "" !== i.slidesPerView1440
                                ? parseInt(i.slidesPerView1440, 10)
                                : 5),
                    q =
                        void 0 !== i.slidesPerView1366 &&
                            "" !== i.slidesPerView1366
                            ? parseInt(i.slidesPerView1366, 10)
                            : 4,
                    w =
                        void 0 !== i.slidesPerView1024 &&
                            "" !== i.slidesPerView1024
                            ? parseInt(i.slidesPerView1024, 10)
                            : 3,
                    v =
                        void 0 !== i.slidesPerView768 &&
                            "" !== i.slidesPerView768
                            ? parseInt(i.slidesPerView768, 10)
                            : 2,
                    y =
                        void 0 !== i.slidesPerView680 &&
                            "" !== i.slidesPerView680
                            ? parseInt(i.slidesPerView680, 10)
                            : 1,
                    h =
                        (h ||
                            (a < 2
                                ? (v = w = q = c = a)
                                : a < 3
                                    ? (w = q = c = a)
                                    : a < 4
                                        ? (q = c = a)
                                        : a < 5 && (c = a)),
                        {
                            direction: o,
                            slidesPerView: (a = "vertical" === o ? 1 : a),
                            centeredSlides: r,
                            sliderScroll: s,
                            spaceBetween: n,
                            autoplay: l,
                            loop: d,
                            speed: f,
                            navigation: { nextEl: p, prevEl: g },
                            pagination: {
                                el: m,
                                type: "fraction",
                                clickable: !0,
                                formatFractionCurrent: function (e) {
                                    return ("0" + e).slice(-2);
                                },
                                formatFractionTotal: function (e) {
                                    return ("0" + e).slice(-2);
                                },
                                renderFraction: function (e, t) {
                                    return (
                                        '<span class="' +
                                        e +
                                        '"></span><span class="' +
                                        t +
                                        '"></span>'
                                    );
                                },
                            },
                            breakpoints: {
                                0: {
                                    slidesPerView:
                                        void 0 !== i.slidesPerView480 &&
                                            "" !== i.slidesPerView480
                                            ? parseInt(i.slidesPerView480, 10)
                                            : 1,
                                },
                                481: { slidesPerView: y },
                                681: { slidesPerView: v },
                                769: { slidesPerView: w },
                                1025: { slidesPerView: q },
                                1367: { slidesPerView: c },
                                1441: { slidesPerView: a },
                            },
                        });
                return (
                    u.length &&
                    "fade" === u &&
                    ((h.effect = "fade"),
                        (h.fadeEffect = { crossFade: !0 })),
                    Object.assign(h, _.getSliderDatas(e))
                );
            },
            getSliderDatas: function (e) {
                var t,
                    i = e.data(),
                    o = {};
                for (t in i)
                    i.hasOwnProperty(t) &&
                        "options" !== t &&
                        void 0 !== i[t] &&
                        "" !== i[t] &&
                        (o[t] = i[t]);
                return o;
            },
            getEvents: function (o, n) {
                return {
                    on: {
                        beforeInit: function () {
                            var e, t, i;
                            "vertical" === n.direction &&
                                ((t = e = 0),
                                    (i = o.find(".qodef-e")).length &&
                                    i.each(function () {
                                        (t = a(this).outerHeight()),
                                            e < t && (e = t);
                                    }),
                                    o.css("height", e),
                                    i.css("height", e));
                        },
                        init: function () {
                            var t;
                            o.addClass("qodef-swiper--initialized"),
                                qodef.body.trigger(
                                    "neoocular_trigger_swiper_is_initialized",
                                    [o, n]
                                ),
                                n.sliderScroll &&
                                ((t = !1),
                                    o.on("mousewheel", function (e) {
                                        e.preventDefault(),
                                            t ||
                                            ((t = !0),
                                                e.deltaY < 0
                                                    ? o[0].swiper.slideNext()
                                                    : o[0].swiper.slidePrev(),
                                                setTimeout(function () {
                                                    t = !1;
                                                }, 1e3));
                                    }));
                        },
                    },
                };
            },
        },
        o =
            ((qodef.qodefSwiper = _),
            {
                init: function (e) {
                    (this.holder = a(".qodef-magnific-popup")),
                        a.extend(this.holder, e),
                        this.holder.length &&
                        this.holder.each(function () {
                            o.initPopup(a(this));
                        });
                },
                initPopup: function (e) {
                    e.hasClass("qodef-popup-item")
                        ? o.initSingleImagePopup(e)
                        : e.hasClass("qodef-popup-gallery") &&
                        o.initGalleryPopup(e);
                },
                initSingleImagePopup: function (e) {
                    var t = e.data("type");
                    e.magnificPopup({
                        type: t,
                        titleSrc: "title",
                        image: { cursor: null },
                        closeMarkup:
                            '<button title="%title%" type="button" class="mfp-close">' +
                            qodefGlobal.vars.iconClose +
                            "</button>",
                    });
                },
                initGalleryPopup: function (e) {
                    var e = e.find(".qodef-popup-item"),
                        t = o.generateGalleryItems(e);
                    e.each(function (e) {
                        a(this).magnificPopup({
                            items: t,
                            gallery: {
                                enabled: !0,
                                arrowMarkup:
                                    '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%">' +
                                    qodefGlobal.vars.iconArrowLeft +
                                    "</button>",
                            },
                            index: e,
                            type: "image",
                            image: { cursor: null },
                            closeMarkup:
                                '<button title="%title%" type="button" class="mfp-close">' +
                                qodefGlobal.vars.iconClose +
                                "</button>",
                        });
                    });
                },
                generateGalleryItems: function (e) {
                    var t = [];
                    return (
                        e.length &&
                        e.each(function () {
                            var e = a(this),
                                e = {
                                    src: e.attr("href"),
                                    title: e.attr("title"),
                                    type: e.data("type"),
                                };
                            t.push(e);
                        }),
                        t
                    );
                },
            }),
        r =
            ((qodef.qodefMagnificPopup = o),
            {
                items: "",
                init: function (e) {
                    (this.holder = a(".qodef-anchor")),
                        a.extend(this.holder, e),
                        this.holder.length &&
                        ((r.items = this.holder),
                            r.clickTrigger(),
                            a(window).on("load", function () {
                                r.checkAnchorOnScroll(), r.checkAnchorOnLoad();
                            }));
                },
                clickTrigger: function () {
                    r.items.on("click", function (e) {
                        var t = r.getAnchorItem(this),
                            i = t.attr("href"),
                            o = t.prop("hash").split("#")[1],
                            n = window.location.href,
                            a = -1 < n.indexOf("#") ? n.split("#")[1] : 0;
                        (i.indexOf("http") < 0 ||
                            i === n ||
                            (0 !== a &&
                                i.substring(0, i.length - o.length - 1) ===
                                n.substring(0, n.length - a.length - 1)) ||
                            (0 === a &&
                                i.substring(0, i.length - o.length - 1) ===
                                n)) &&
                            e.preventDefault(),
                            r.animateScroll(t, o);
                    });
                },
                checkAnchorOnLoad: function () {
                    var t = window.location.hash.split("#")[1];
                    void 0 !== t &&
                        "" !== t &&
                        r.items.length &&
                        r.items.each(function () {
                            var e = r.getAnchorItem(this);
                            -1 < e.attr("href").indexOf(t) &&
                                r.animateScroll(e, t);
                        });
                },
                checkAnchorOnScroll: function () {
                    var e;
                    1024 < qodef.windowWidth &&
                        (e = a("#qodef-page-inner *[id]")).length &&
                        e.each(function () {
                            var e = a(this),
                                t = a('[href*="#' + e.attr("id") + '"]');
                            t.length &&
                                (r.isTargetInView(e) && r.setActiveState(t),
                                    a(window).scroll(function () {
                                        r.isTargetInView(e)
                                            ? r.setActiveState(t)
                                            : t.removeClass(r.getItemClasses(t));
                                    }));
                        });
                },
                isTargetInView: function (e) {
                    var e = e[0].getBoundingClientRect(),
                        t =
                            window.innerHeight ||
                            document.documentElement.clientHeight;
                    return !(
                        Math.floor(
                            100 - ((0 <= e.top ? 0 : e.top) / -+e.height) * 100
                        ) < 20 ||
                        Math.floor(100 - ((e.bottom - t) / e.height) * 100) < 20
                    );
                },
                getAnchorItem: function (e) {
                    return "A" === e.tagName ? a(e) : a(e).children("a");
                },
                animateScroll: function (e, t) {
                    var i = "" !== t ? a('[id="' + t + '"]') : "";
                    if (i.length)
                        return (
                            (i =
                                i.offset().top -
                                r.getHeaderHeight() -
                                qodefGlobal.vars.adminBarHeight),
                            r.setActiveState(e),
                            qodef.html
                                .stop()
                                .animate(
                                    { scrollTop: Math.round(i) },
                                    1e3,
                                    function () {
                                        history.pushState &&
                                            history.pushState(
                                                null,
                                                "",
                                                "#" + t
                                            );
                                    }
                                ),
                            !1
                        );
                },
                getHeaderHeight: function () {
                    var e = 0;
                    return (e =
                        1024 < qodef.windowWidth &&
                            null !== qodefGlobal.vars.headerHeight &&
                            "" !== qodefGlobal.vars.headerHeight
                            ? parseInt(qodefGlobal.vars.headerHeight, 10)
                            : e);
                },
                setActiveState: function (e) {
                    var t = !e.parent().hasClass("qodef-anchor"),
                        i = r.getItemClasses(e);
                    r.items.removeClass(i), (t ? e : e.parent()).addClass(i);
                },
                getItemClasses: function (e) {
                    return (
                        "qodef-anchor--active" +
                        (e.parents("#qodef-page-header")
                            ? " current-menu-item current_page_item"
                            : "")
                    );
                },
            });
    (qodef.qodefAnchor = r),
        (qodef.qodefWaitForImages = {
            check: function (e, t) {
                if (e.length) {
                    var i = e.find("img");
                    if (i.length)
                        for (var o = 0, n = 0; n < i.length; n++) {
                            var a,
                                r = i[n];
                            r.complete
                                ? ++o === i.length && t.call(e)
                                : ((a = new Image()).addEventListener(
                                    "load",
                                    function () {
                                        if (++o === i.length)
                                            return t.call(e), !1;
                                    },
                                    !1
                                ),
                                    (a.src = r.src));
                        }
                    else t.call(e);
                }
            },
        }),
        "function" != typeof Object.assign &&
        (Object.assign = function (e) {
            if (null == e)
                throw new TypeError(
                    "Cannot convert undefined or null to object"
                );
            e = Object(e);
            for (var t = 1; t < arguments.length; t++) {
                var i = arguments[t];
                if (null !== i)
                    for (var o in i)
                        Object.prototype.hasOwnProperty.call(i, o) &&
                            (e[o] = i[o]);
            }
            return e;
        });
})(jQuery),
    (function (o) {
        o(document).ready(function () {
            n.init();
        }),
            o(window).resize(function () {
                n.init();
            }),
            o(document).on("neoocular_trigger_get_new_posts", function (e, t) {
                t.hasClass("qodef-blog") && (i.resize(t), n.resize(t));
            });
        var i = {
            init: function () {
                var e = o(".qodef-blog");
                e.length && i.resize(e);
            },
            resize: function (e) {
                e = e
                    .find(".wp-video-shortcode, .wp-audio-shortcode")
                    .not(".mejs-container");
                e.length &&
                    e.each(function () {
                        var e = o(this);
                        "function" == typeof e.mediaelementplayer &&
                            e.mediaelementplayer({
                                videoWidth: "100%",
                                videoHeight: "56.5%",
                            });
                    });
            },
        },
            n =
                ((qodef.qodefReInitMediaElementPostFormats = i),
                {
                    init: function () {
                        var e = o(".qodef-blog");
                        e.length && n.resize(e);
                    },
                    resize: function (e) {
                        e = e.find(".qodef-e-media iframe");
                        e.length &&
                            e.each(function () {
                                var e = o(this),
                                    t = e.attr("width"),
                                    i = e.attr("height"),
                                    t = (e.width() / t) * i;
                                e.css("height", t);
                            });
                    },
                });
        qodef.qodefResizeIframes = n;
    })(jQuery),
    (function (o) {
        o(document).ready(function () {
            r.init();
        }),
            o(document).on("neoocular_trigger_get_new_posts", function (e, t) {
                t.hasClass("qodef-filter--on") &&
                    t.removeClass("qodef--filter-loading");
            });
        var r = {
            customListQuery: {},
            init: function (e) {
                (this.holder = o(".qodef-filter--on")),
                    o.extend(this.holder, e),
                    this.holder.length &&
                    this.holder.each(function () {
                        var e = o(this),
                            t = e.find(".qodef-m-filter-item");
                        r.checkCustomListQuery(e.data("options")),
                            r.clickEvent(e, t);
                    });
            },
            checkCustomListQuery: function (e) {
                void 0 !== e.additional_query_args &&
                    void 0 !== e.additional_query_args.tax_query &&
                    (r.customListQuery = e.additional_query_args.tax_query);
            },
            clickEvent: function (t, i) {
                i.on("click", function (e) {
                    e.preventDefault();
                    e = o(this);
                    e.hasClass("qodef--active") ||
                        (t.addClass("qodef--filter-loading"),
                            i.removeClass("qodef--active"),
                            e.addClass("qodef--active"),
                            r.setVisibility(t, e));
                });
            },
            setVisibility: function (e, t) {
                var i = t.data("taxonomy"),
                    t = t.data("filter"),
                    o = "*" === t,
                    n = e.data("options"),
                    a = {},
                    a = o
                        ? r.customListQuery
                        : {
                            0: {
                                taxonomy: i,
                                field:
                                    "number" == typeof t ? "term_id" : "slug",
                                terms: t,
                            },
                        };
                (n.additional_query_args = { tax_query: a }),
                    qodef.body.trigger("neoocular_trigger_load_more", [e, 1]);
            },
            isMasonryLayout: function (e) {
                return e.hasClass("qodef-layout--masonry");
            },
            hasLoadMore: function (e) {
                return e.hasClass("qodef-pagination-type--load-more");
            },
        };
        qodef.qodefFilter = r;
    })(jQuery),
    (function (s) {
        s(document).ready(function () {
            t.init();
        }),
            s(document).on("neoocular_trigger_get_new_posts", function () {
                t.init();
            });
        var t = {
            init: function () {
                var e = s(".qodef-layout--justified-gallery");
                e.length &&
                    e.each(function () {
                        t.setJustifyGallery(s(this));
                    });
            },
            setJustifyGallery: function (e) {
                var t = e.data("options"),
                    i = e.children(".qodef-grid-inner"),
                    o =
                        void 0 !== t.justified_gallery_row_height &&
                            "" !== t.justified_gallery_row_height
                            ? t.justified_gallery_row_height
                            : 150,
                    n =
                        void 0 !== t.justified_gallery_row_height_max &&
                        "" !== t.justified_gallery_row_height_max &&
                        t.justified_gallery_row_height_max,
                    a = void 0 !== t.space_value ? 2 * t.space_value : 0,
                    r =
                        void 0 !== t.justified_gallery_treshold &&
                            "" !== t.justified_gallery_treshold
                            ? t.justified_gallery_treshold
                            : 0.75;
                qodef.qodefWaitForImages.check(i, function () {
                    "function" == typeof i.justifiedGallery &&
                        i
                            .justifiedGallery({
                                captions: !1,
                                rowHeight: o,
                                maxRowHeight: n,
                                margins: a,
                                border: 0,
                                lastRow: "nojustify",
                                justifyThreshold: r,
                                selector: ".qodef-grid-item",
                            })
                            .on("jg.complete jg.rowflush", function () {
                                var t = s(this),
                                    i = !1;
                                t.find(".qodef-grid-item")
                                    .addClass("show")
                                    .each(function () {
                                        var e = s(this);
                                        e.height(Math.round(e.height())),
                                            i ||
                                            0 !== e.width() ||
                                            (t.height(
                                                t.height() - e.height() - a
                                            ),
                                                (i = !0));
                                    });
                            }),
                        e.addClass("qodef--justified-gallery-init");
                });
            },
        };
        qodef.qodefJustifiedGallery = t;
    })(jQuery),
    (function (t) {
        t(document).ready(function () {
            n.init();
        }),
            t(window).resize(function () {
                n.reInit();
            }),
            t(document).on("neoocular_trigger_get_new_posts", function (e, t) {
                t.hasClass("qodef-layout--masonry") && n.init();
            });
        var n = {
            init: function (e) {
                (this.holder = t(".qodef-layout--masonry")),
                    t.extend(this.holder, e),
                    this.holder.length &&
                    this.holder.each(function () {
                        n.createMasonry(t(this));
                    });
            },
            reInit: function (e) {
                (this.holder = t(".qodef-layout--masonry")),
                    t.extend(this.holder, e),
                    this.holder.length &&
                    this.holder.each(function () {
                        var e = t(this).find(".qodef-grid-inner");
                        "function" == typeof e.isotope &&
                            e.isotope("layout");
                    });
            },
            createMasonry: function (t) {
                var i = t.find(".qodef-grid-inner"),
                    o = i.find(".qodef-grid-item");
                qodef.qodefWaitForImages.check(i, function () {
                    var e;
                    "function" == typeof i.isotope &&
                        (i.isotope({
                            layoutMode: "packery",
                            itemSelector: ".qodef-grid-item",
                            percentPosition: !0,
                            masonry: {
                                columnWidth: ".qodef-grid-masonry-sizer",
                                gutter: ".qodef-grid-masonry-gutter",
                            },
                        }),
                            t.hasClass("qodef-items--fixed") &&
                            ((e = n.getFixedImageSize(i, o)),
                                n.setFixedImageProportionSize(i, o, e)),
                            i.isotope("layout")),
                        i.addClass("qodef--masonry-init");
                });
            },
            getFixedImageSize: function (e, t) {
                var i,
                    o = e.find(".qodef-item--square");
                return o.length
                    ? (i = (o = o.find("img")).width()) !== (o = o.height())
                        ? o
                        : i
                    : e.find(".qodef-grid-masonry-sizer").width() -
                    2 * parseInt(t.css("paddingLeft"), 10);
            },
            setFixedImageProportionSize: function (e, t, i) {
                var o = parseInt(t.css("paddingLeft"), 10),
                    n =
                        (e.find(".qodef-item--square"),
                            e.find(".qodef-item--landscape")),
                    a = e.find(".qodef-item--portrait"),
                    e = e.find(".qodef-item--huge-square"),
                    r = qodef.windowWidth <= 680;
                t.css("height", i),
                    n.length && n.css("height", Math.round(i / 2)),
                    a.length && a.css("height", Math.round(2 * (i + o))),
                    r ||
                    (n.length && n.css("height", i),
                        e.length && e.css("height", Math.round(2 * (i + o))));
            },
        };
        qodef.qodefMasonryLayout = n;
    })(jQuery),
    (function (t) {
        t(document).ready(function () {
            i.init();
        });
        var i = {
            init: function () {
                var e = t("#qodef-page-mobile-header");
                e.length &&
                    (i.initMobileHeaderOpener(e), i.initDropDownMobileMenu());
            },
            initMobileHeaderOpener: function (e) {
                var t,
                    i = e.find(".qodef-mobile-header-opener");
                i.length &&
                    ((t = e.find(".qodef-mobile-header-navigation")),
                        i.on("tap click", function (e) {
                            e.preventDefault(),
                                t.is(":visible")
                                    ? (t.slideUp(450),
                                        i.removeClass("qodef--opened"))
                                    : (t.slideDown(450),
                                        i.addClass("qodef--opened"));
                        }));
            },
            initDropDownMobileMenu: function () {
                var e = t(
                    ".qodef-mobile-header-navigation .menu-item-has-children > .qodef-menu-item-arrow"
                );
                e.length &&
                    e.each(function () {
                        var o = t(this);
                        o.on("tap click", function (e) {
                            e.preventDefault();
                            var t,
                                e = o.parent(),
                                i = e.siblings(".menu-item-has-children");
                            e.hasClass("menu-item-has-children") &&
                                ((t = e.find("ul.sub-menu").first()).is(
                                    ":visible"
                                )
                                    ? (t.slideUp(450),
                                        e.removeClass("qodef--opened"))
                                    : (e.addClass("qodef--opened"),
                                        (0 === i.length
                                            ? e
                                            : e
                                                .siblings()
                                                .removeClass("qodef--opened")
                                        )
                                            .find(".sub-menu")
                                            .slideUp(400, function () {
                                                t.slideDown(400);
                                            })));
                        });
                    });
            },
        };
    })(jQuery),
    (function (a) {
        a(document).ready(function () {
            e.init();
        });
        var e = {
            init: function () {
                var e = a(
                    ".qodef-header-navigation.qodef-header-navigation-initial > ul > li.qodef-menu-item--narrow.menu-item-has-children"
                );
                e.length &&
                    e.each(function () {
                        var e,
                            t = a(this),
                            i = t.offset().left,
                            o = t.find(" > ul"),
                            n = o.outerWidth(),
                            i = a(window).width() - i;
                        0 < t.find("li.menu-item-has-children").length &&
                            (e = i - n),
                            o.removeClass("qodef-drop-down--right"),
                            (i < n || e < n) &&
                            o.addClass("qodef-drop-down--right");
                    });
            },
        };
    })(jQuery),
    (function (a) {
        a(document).ready(function () {
            r.init();
        }),
            a(window).scroll(function () {
                r.scroll();
            }),
            a(document).on("neoocular_trigger_load_more", function (e, t, i) {
                r.triggerLoadMore(t, i);
            });
        var r = {
            init: function (e) {
                (this.holder = a(".qodef-pagination--on")),
                    a.extend(this.holder, e),
                    this.holder.length &&
                    this.holder.each(function () {
                        var e = a(this);
                        r.initPaginationType(e);
                    });
            },
            scroll: function (e) {
                (this.holder = a(".qodef-pagination--on")),
                    a.extend(this.holder, e),
                    this.holder.length &&
                    this.holder.each(function () {
                        var e = a(this);
                        e.hasClass(
                            "qodef-pagination-type--infinite-scroll"
                        ) && r.initInfiniteScroll(e);
                    });
            },
            initPaginationType: function (e) {
                e.hasClass("qodef-pagination-type--standard")
                    ? r.initStandard(e)
                    : e.hasClass("qodef-pagination-type--load-more")
                        ? r.initLoadMore(e)
                        : e.hasClass("qodef-pagination-type--infinite-scroll") &&
                        r.initInfiniteScroll(e);
            },
            initStandard: function (i, e) {
                var t,
                    o = i.find(".qodef-m-pagination-items");
                o.length &&
                    ((t = i.data("options")),
                        (e = void 0 !== e && "" !== e ? parseInt(e, 10) : 1),
                        r.changeStandardState(i, t.max_pages_num, e),
                        o.children().each(function () {
                            var t = a(this);
                            t.on("click", function (e) {
                                e.preventDefault(),
                                    t.hasClass("qodef--active") ||
                                    r.getNewPosts(i, t.data("paged"));
                            });
                        }));
            },
            changeStandardState: function (e, t, i) {
                var o, n, a;
                e.hasClass("qodef-pagination-type--standard") &&
                    ((o = (e = e.find(".qodef-m-pagination-items")).children(
                        ".qodef--number"
                    )),
                        (n = e.children(".qodef--prev")),
                        (a = e.children(".qodef--next")),
                        r.standardPaginationVisibility(e, t),
                        o
                            .removeClass("qodef--active")
                            .eq(i - 1)
                            .addClass("qodef--active"),
                        n.data("paged", i - 1),
                        1 < i
                            ? (n.show(), n.next().removeClass("qodef-prev--hidden"))
                            : (n.hide(), n.next().addClass("qodef-prev--hidden")),
                        a.data("paged", i + 1),
                        i === t ? a.hide() : a.show());
            },
            standardPaginationVisibility: function (e, t) {
                1 === t ? e.hide() : 1 < t && !e.is(":visible") && e.show();
            },
            changeStandardHtml: function (e, t, i, o) {
                var n, a;
                e.hasClass("qodef-pagination-type--standard") &&
                    ((n = e.find(".qodef-m-pagination")),
                        (a = e.find(".qodef-m-pagination-spinner")),
                        r.standardPaginationVisibility(n, t),
                        n.remove(),
                        a.remove(),
                        e.append(o),
                        r.initStandard(e, i));
            },
            triggerStandardScrollAnimation: function (e) {
                e.hasClass("qodef-pagination-type--standard") &&
                    a("html, body").animate(
                        { scrollTop: e.offset().top - 100 },
                        500
                    );
            },
            initLoadMore: function (t) {
                t.find(".qodef-load-more-button").on("click", function (e) {
                    e.preventDefault(), r.getNewPosts(t);
                });
            },
            triggerLoadMore: function (e, t) {
                r.getNewPosts(e, t);
            },
            loadMoreButtonVisibility: function (e, t) {
                e.hasClass("qodef-pagination-type--load-more") &&
                    (t.next_page > t.max_pages_num || 1 === t.max_pages_num
                        ? e.find(".qodef-load-more-button").hide()
                        : 1 < t.max_pages_num &&
                        t.next_page <= t.max_pages_num &&
                        e.find(".qodef-load-more-button").show());
            },
            initInfiniteScroll: function (e) {
                var t = e.outerHeight() + e.offset().top,
                    i = qodef.scroll + qodef.windowHeight,
                    o = e.data("options");
                !e.hasClass("qodef--loading") &&
                    t < i &&
                    o.max_pages_num >= o.next_page &&
                    r.getNewPosts(e);
            },
            getNewPosts: function (t, i) {
                t.addClass("qodef--loading");
                var o = t.children(".qodef-grid-inner"),
                    n = t.data("options");
                r.setNextPageValue(n, i, !1),
                    a.ajax({
                        type: "GET",
                        url:
                            qodefGlobal.vars.restUrl +
                            qodefGlobal.vars.paginationRestRoute,
                        data: { options: n },
                        beforeSend: function (e) {
                            e.setRequestHeader(
                                "X-WP-Nonce",
                                qodefGlobal.vars.restNonce
                            );
                        },
                        success: function (e) {
                            "success" === e.status
                                ? (n.max_pages_num !== e.data.max_pages_num &&
                                    (n.max_pages_num = e.data.max_pages_num),
                                    r.setNextPageValue(n, i, !0),
                                    r.changeStandardHtml(
                                        t,
                                        n.max_pages_num,
                                        i,
                                        e.data.pagination_html
                                    ),
                                    r.addPosts(o, e.data.html, i),
                                    r.reInitMasonryPosts(t, o),
                                    setTimeout(function () {
                                        qodef.body.trigger(
                                            "neoocular_trigger_get_new_posts",
                                            [t, e.data, i]
                                        );
                                    }, 300),
                                    r.triggerStandardScrollAnimation(t),
                                    r.loadMoreButtonVisibility(t, n))
                                : console.log(e.message);
                        },
                        complete: function () {
                            t.removeClass("qodef--loading");
                        },
                    });
            },
            setNextPageValue: function (e, t, i) {
                void 0 === t || "" === t || i
                    ? i && (e.next_page = parseInt(e.next_page, 10) + 1)
                    : (e.next_page = t);
            },
            addPosts: function (e, t, i) {
                void 0 !== i && "" !== i ? e.html(t) : e.append(t);
            },
            reInitMasonryPosts: function (e, t) {
                e.hasClass("qodef-layout--masonry") &&
                    (t
                        .isotope("reloadItems")
                        .isotope({ sortBy: "original-order" }),
                        setTimeout(function () {
                            t.isotope("layout");
                        }, 200));
            },
        };
        qodef.qodefPagination = r;
    })(jQuery),
    (function (d) {
        d(document).ready(function () {
            e.init(), t.init();
        }),
            d(window).on("load", function () {
                i.init();
            });
        var i = {
            init: function (e) {
                (this.holder = []),
                    this.holder.push({
                        holder: d(
                            "#qodef-woo-page .woocommerce-ordering select"
                        ),
                        options: { minimumResultsForSearch: 1 / 0 },
                    }),
                    this.holder.push({
                        holder: d(
                            '.variations select:not(.yith_wccl_custom):not([data-type="colorpicker"]):not([data-type="image"]):not([data-type="label"])'
                        ),
                        options: { minimumResultsForSearch: 1 / 0 },
                    }),
                    this.holder.push({
                        holder: d("#qodef-woo-page #calc_shipping_country"),
                        options: {},
                    }),
                    this.holder.push({
                        holder: d(
                            "#qodef-woo-page .shipping select#calc_shipping_state"
                        ),
                        options: {},
                    }),
                    this.holder.push({
                        holder: d(".widget.widget_archive select"),
                        options: {},
                    }),
                    this.holder.push({
                        holder: d(
                            ".widget .wp-block-group .wp-block-archives-dropdown select"
                        ),
                    }),
                    this.holder.push({
                        holder: d(".widget.widget_categories select"),
                        options: {},
                    }),
                    this.holder.push({
                        holder: d(
                            ".widget .wp-block-group .wp-block-categories-dropdown select"
                        ),
                        options: {},
                    }),
                    this.holder.push({
                        holder: d(".widget.widget_text select"),
                        options: {},
                    }),
                    this.holder.push({
                        holder: d(
                            ".qodef-appointment-form .menu-dd select"
                        ),
                        options: { minimumResultsForSearch: 1 / 0 },
                    }),
                    d.extend(this.holder, e),
                    "object" == typeof this.holder &&
                    d.each(this.holder, function (e, t) {
                        i.createSelect2(t.holder, t.options);
                    });
            },
            createSelect2: function (e, t) {
                "function" == typeof e.select2 && e.select2(t);
            },
        },
            t = {
                init: function () {
                    var e;
                    "object" == typeof qodef.qodefMagnificPopup &&
                        (e = d(
                            ".qodef--single.qodef-magnific-popup.qodef-popup-gallery .woocommerce-product-gallery__image"
                        )).length &&
                        (e.each(function () {
                            d(this)
                                .children("a")
                                .attr("data-type", "image")
                                .addClass("qodef-popup-item");
                        }),
                            qodef.qodefMagnificPopup.init());
                },
            };
        (qodef.qodefWooMagnificPopup = t),
            d(document).on("yith_wccl_product_gallery_loaded", function () {
                var e;
                "object" == typeof qodef.qodefMagnificPopup &&
                    (e = d(
                        ".qodef--single.qodef-magnific-popup.qodef-popup-gallery .woocommerce-product-gallery__image"
                    )).length &&
                    (e
                        .children("a")
                        .attr("data-type", "image")
                        .addClass("qodef-popup-item"),
                        qodef.qodefMagnificPopup.init());
            });
    })(jQuery);
