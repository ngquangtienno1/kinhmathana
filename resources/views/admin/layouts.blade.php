    <!DOCTYPE html>
    <html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">


    <!-- Mirrored from prium.github.io/phoenix/v1.22.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 10 May 2025 16:39:55 GMT -->
    <!-- Added by HTTrack -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @include('admin.components.head')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <body>
        <!-- ===============================================-->
        <!--    Main Content-->
        <!-- ===============================================-->
        <main class="main" id="top">

            @include('admin.components.slidebar')
            @include('admin.components.header')



            <div class="content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @include('admin.components.breadcrumbs')

                @yield('content')


                @include('admin.components.footer')
            </div>
            <div class="modal fade" id="searchBoxModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true"
                data-phoenix-admin.components.modal="data-phoenix-admin.components.modal"
                style="--phoenix-admin.components.backdrop-opacity: 1;">
                <div class="modal-dialog">
                    <div class="modal-content mt-15 rounded-pill">
                        <div class="modal-body p-0">
                            <div class="search-box navbar-top-search-box" data-list='{"valueNames":["title"]}'
                                style="width: auto;">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                                        class="form-control search-input fuzzy-search rounded-pill form-control-lg"
                                        type="search" placeholder="Search..." aria-label="Search" />
                                    <span class="fas fa-search search-box-admin.components.icon"></span>
                                </form>
                                <div class="btn-close position-absolute end-0 top-50 translate-middle cursor-pointer shadow-none"
                                    data-bs-dismiss="search"><button class="btn btn-link p-0"
                                        aria-label="Close"></button>
                                </div>
                                <div class="dropdown-menu border start-0 py-0 overflow-hidden w-100">
                                    <div class="scrollbar-overlay" style="max-admin.components.height: 30rem;">
                                        <div class="list pb-3">
                                            <h6 class="dropdown-header text-body-highlight fs-10 py-2">24 <span
                                                    class="text-body-quaternary">results</span></h6>
                                            <hr class="my-0" />
                                            <h6
                                                class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                                                Recently Searched </h6>
                                            <div class="py-2"><a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"><span
                                                                class="fa-solid fa-clock-rotate-left"
                                                                data-fa-transform="shrink-2"></span> Store Macbook</div>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"> <span
                                                                class="fa-solid fa-clock-rotate-left"
                                                                data-fa-transform="shrink-2"></span> MacBook Air - 13″
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr class="my-0" />
                                            <h6
                                                class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                                                Products</h6>
                                            <div class="py-2"><a class="dropdown-item py-2 d-flex align-items-center"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="file-thumbnail me-2"><img
                                                            class="h-100 w-100 object-fit-cover rounded-3"
                                                            src="{{ asset('v1/assets/img/products/60x60/3.png') }} "
                                                            alt="" /></div>
                                                    <div class="flex-admin.components.1">
                                                        <h6 class="mb-0 text-body-highlight title">MacBook Air - 13″
                                                        </h6>
                                                        <p class="fs-10 mb-0 d-flex text-body-tertiary"><span
                                                                class="fw-medium text-body-tertiary text-opactity-85">8GB
                                                                Memory - 1.6GHz - 128GB Storage</span></p>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item py-2 d-flex align-items-center"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="file-thumbnail me-2"><img class="img-fluid"
                                                            src="{{ asset('v1/assets/img/products/60x60/3.png') }} "
                                                            alt="" /></div>
                                                    <div class="flex-admin.components.1">
                                                        <h6 class="mb-0 text-body-highlight title">MacBook Pro - 13″
                                                        </h6>
                                                        <p class="fs-10 mb-0 d-flex text-body-tertiary"><span
                                                                class="fw-medium text-body-tertiary text-opactity-85">30
                                                                Sep
                                                                at 12:30 PM</span></p>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr class="my-0" />
                                            <h6
                                                class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                                                Quick Links</h6>
                                            <div class="py-2"><a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"><span
                                                                class="fa-solid fa-link text-body"
                                                                data-fa-transform="shrink-2"></span> Support MacBook
                                                            House
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"> <span
                                                                class="fa-solid fa-link text-body"
                                                                data-fa-transform="shrink-2"></span> Store MacBook″
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr class="my-0" />
                                            <h6
                                                class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                                                Files</h6>
                                            <div class="py-2"><a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"><span
                                                                class="fa-solid fa-file-zipper text-body"
                                                                data-fa-transform="shrink-2"></span> Library MacBook
                                                            folder.rar</div>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"> <span
                                                                class="fa-solid fa-file-lines text-body"
                                                                data-fa-transform="shrink-2"></span> Feature MacBook
                                                            extensions.txt</div>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"> <span
                                                                class="fa-solid fa-image text-body"
                                                                data-fa-transform="shrink-2"></span> MacBook Pro_13.jpg
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr class="my-0" />
                                            <h6
                                                class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                                                Members</h6>
                                            <div class="py-2"><a
                                                    class="dropdown-item py-2 d-flex align-items-center"
                                                    href="pages/members.html">
                                                    <div class="avatar avatar-l status-online  me-2 text-body">
                                                        <img class="rounded-circle "
                                                            src="{{ asset('v1/assets/img/team/40x40/10.webp') }} "
                                                            alt="" />
                                                    </div>
                                                    <div class="flex-admin.components.1">
                                                        <h6 class="mb-0 text-body-highlight title">Carry Anna</h6>
                                                        <p class="fs-10 mb-0 d-flex text-body-tertiary">
                                                            anna@technext.it
                                                        </p>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item py-2 d-flex align-items-center"
                                                    href="pages/members.html">
                                                    <div class="avatar avatar-l  me-2 text-body">
                                                        <img class="rounded-circle "
                                                            src="{{ asset('v1/assets/img/team/40x40/12.webp') }} "
                                                            alt="" />
                                                    </div>
                                                    <div class="flex-admin.components.1">
                                                        <h6 class="mb-0 text-body-highlight title">John Smith</h6>
                                                        <p class="fs-10 mb-0 d-flex text-body-tertiary">
                                                            smith@technext.it
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr class="my-0" />
                                            <h6
                                                class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                                                Related Searches</h6>
                                            <div class="py-2"><a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"><span
                                                                class="fa-brands fa-firefox-admin.components.browser text-body"
                                                                data-fa-transform="shrink-2"></span> Search in the Web
                                                            MacBook</div>
                                                    </div>
                                                </a>
                                                <a class="dropdown-item"
                                                    href="apps/e-commerce/landing/product-details.html">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-normal text-body-highlight title"> <span
                                                                class="fa-brands fa-chrome text-body"
                                                                data-fa-transform="shrink-2"></span> Store MacBook″
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p class="fallback fw-bold fs-7 d-none">No Result Found.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.components.support-chat')
        </main><!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
            aria-labelledby="settings-offcanvas">
            <div
                class="offcanvas-header align-items-start border-bottom flex-admin.components.column border-translucent">
                <div class="pt-1 w-100 mb-6 d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-2 me-2 lh-sm"><span class="fas fa-palette me-2 fs-8"></span>Tùy chỉnh chủ đề
                        </h5>
                        <p class="mb-0 fs-9">Tùy chỉnh chủ đề theo sở thích của bạn</p>
                    </div><button class="btn p-1 fw-bolder" type="button" data-bs-dismiss="offcanvas"
                        aria-label="Close"><span class="fas fa-times fs-8"> </span></button>
                </div><button class="btn btn-phoenix-admin.components.secondary w-100"
                    data-theme-control="reset"><span class="fas fa-arrows-rotate me-2 fs-10"></span>Đặt lại về mặc
                    định</button>
            </div>
            <div class="offcanvas-body scrollbar px-admin.components.card" id="themeController">
                <div class="setting-panel-item mt-0">
                    <h5 class="setting-panel-item-title">Bảng màu</h5>
                    <div class="row gx-admin.components.2">
                        <div class="col-4"><input class="btn-check" id="themeSwitcherLight" name="theme-color"
                                type="radio" value="light" data-theme-control="phoenixTheme" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="themeSwitcherLight"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                        src="{{ asset('v1/assets/img/generic/default-light.png') }} "
                                        alt="" /></span><span class="label-text">Sáng</span></label></div>
                        <div class="col-4"><input class="btn-check" id="themeSwitcherDark" name="theme-color"
                                type="radio" value="dark" data-theme-control="phoenixTheme" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="themeSwitcherDark"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                        src="{{ asset('v1/assets/img/generic/default-dark.png') }} "
                                        alt="" /></span><span class="label-text">
                                    Tối</span></label></div>
                        <div class="col-4"><input class="btn-check" id="themeSwitcherAuto" name="theme-color"
                                type="radio" value="auto" data-theme-control="phoenixTheme" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="themeSwitcherAuto"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                        src="{{ asset('v1/assets/img/generic/auto.png') }} "
                                        alt="" /></span><span class="label-text">
                                    Tự động</span></label></div>
                    </div>
                </div>
                <div class="border border-translucent rounded-3 p-4 setting-panel-item bg-body-emphasis">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="setting-panel-item-title mb-1">Chỉnh hướng </h5>
                        <div class="form-check form-switch mb-0"><input class="form-check-input ms-auto"
                                type="checkbox" data-theme-control="phoenixIsRTL" /></div>
                    </div>
                    <p class="mb-0 text-body-tertiary">Chỉnh hướng văn bản</p>
                </div>
                <div class="border border-translucent rounded-3 p-4 setting-panel-item bg-body-emphasis">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="setting-panel-item-title mb-1">Chat hỗ trợ </h5>
                        <div class="form-check form-switch mb-0"><input class="form-check-input ms-auto"
                                type="checkbox" data-theme-control="phoenixSupportChat" /></div>
                    </div>
                    <p class="mb-0 text-body-tertiary">Bật/tắt chat hỗ trợ</p>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">Loại thanh điều hướng</h5>
                    <div class="row gx-admin.components.2">
                        <div class="col-6"><input class="btn-check" id="navbarPositionVertical"
                                name="navigation-type" type="radio" value="vertical"
                                data-theme-control="phoenixNavbarPosition" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarPositionVertical"> <span
                                    class="rounded d-block"><img class="img-fluid img-prototype d-dark-none"
                                        src="{{ asset('v1/assets/img/generic/default-light.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none"
                                        src="{{ asset('v1/assets/img/generic/default-dark.png') }} "
                                        alt="" /></span><span class="label-text">Dọc</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarPositionHorizontal"
                                name="navigation-type" type="radio" value="horizontal"
                                data-theme-control="phoenixNavbarPosition" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarPositionHorizontal"> <span
                                    class="rounded d-block"><img class="img-fluid img-prototype d-dark-none"
                                        src="{{ asset('v1/assets/img/generic/top-default.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none"
                                        src="{{ asset('v1/assets/img/generic/top-default-dark.png') }} "
                                        alt="" /></span><span class="label-text"> Ngang</span></label>
                        </div>
                        <div class="col-6"><input class="btn-check" id="navbarPositionCombo" name="navigation-type"
                                type="radio" value="combo" data-theme-control="phoenixNavbarPosition" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarPositionCombo"> <span
                                    class="rounded d-block"><img class="img-fluid img-prototype d-dark-none"
                                        src="{{ asset('v1/assets/img/generic/nav-combo-light.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none"
                                        src="{{ asset('v1/assets/img/generic/nav-combo-dark.png') }} "
                                        alt="" /></span><span class="label-text"> Kết hợp</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarPositionTopDouble"
                                name="navigation-type" type="radio" value="dual-nav"
                                data-theme-control="phoenixNavbarPosition" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarPositionTopDouble"> <span
                                    class="rounded d-block"><img class="img-fluid img-prototype d-dark-none"
                                        src="{{ asset('v1/assets/img/generic/dual-light.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none"
                                        src="{{ asset('v1/assets/img/generic/dual-dark.png') }} "
                                        alt="" /></span><span class="label-text"> Hai thanh điều
                                    hướng</span></label>
                        </div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">Thanh điều hướng dọc</h5>
                    <div class="row gx-admin.components.2">
                        <div class="col-6"><input class="btn-check" id="navbar-style-default" type="radio"
                                name="config.name" value="default"
                                data-theme-control="phoenixNavbarVerticalStyle" /><label
                                class="btn d-block w-100 btn-navbar-style fs-9" for="navbar-style-default"> <img
                                    class="img-fluid img-prototype d-dark-none"
                                    src="{{ asset('v1/assets/img/generic/default-light.png') }} "
                                    alt="" /><img class="img-fluid img-prototype d-light-none"
                                    src="{{ asset('v1/assets/img/generic/default-dark.png') }} "
                                    alt="" /><span class="label-text d-dark-none">
                                    Mặc định</span><span class="label-text d-light-none">Mặc định</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbar-style-dark" type="radio"
                                name="config.name" value="darker"
                                data-theme-control="phoenixNavbarVerticalStyle" /><label
                                class="btn d-block w-100 btn-navbar-style fs-9" for="navbar-style-dark"> <img
                                    class="img-fluid img-prototype d-dark-none"
                                    src="{{ asset('v1/assets/img/generic/vertical-darker.png') }} "
                                    alt="" /><img class="img-fluid img-prototype d-light-none"
                                    src="{{ asset('v1/assets/img/generic/vertical-lighter.png') }} "
                                    alt="" /><span class="label-text d-dark-none"> Tối hơn</span><span
                                    class="label-text d-light-none">Sáng hơn</span></label></div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">Hình dạng thanh điều hướng ngang</h5>
                    <div class="row gx-admin.components.2">
                        <div class="col-6"><input class="btn-check" id="navbarShapeDefault" name="navbar-shape"
                                type="radio" value="default" data-theme-control="phoenixNavbarTopShape" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarShapeDefault"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-default.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-default-dark.png') }} "
                                        alt="" /></span><span class="label-text">Mặc định</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarShapeSlim" name="navbar-shape"
                                type="radio" value="slim" data-theme-control="phoenixNavbarTopShape" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarShapeSlim"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-slim.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-slim-dark.png') }} "
                                        alt="" /></span><span class="label-text">
                                    Nhẹ</span></label></div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">Hình dạng thanh điều hướng ngang</h5>
                    <div class="row gx-admin.components.2">
                        <div class="col-6"><input class="btn-check" id="navbarTopDefault" name="navbar-top-style"
                                type="radio" value="default" data-theme-control="phoenixNavbarTopStyle" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarTopDefault"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-default.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-style-darker.png') }} "
                                        alt="" /></span><span class="label-text">Mặc định</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarTopDarker" name="navbar-top-style"
                                type="radio" value="darker" data-theme-control="phoenixNavbarTopStyle" /><label
                                class="btn d-inline-block btn-navbar-style fs-9" for="navbarTopDarker"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/navbar-top-style-light.png') }} "
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('v1/assets/img/generic/top-style-lighter.png') }} "
                                        alt="" /></span><span class="label-text d-dark-none">Tối
                                    hơn</span><span class="label-text d-light-none">Sáng hơn</span></label></div>
                    </div>
                </div><a class="bun btn-primary d-grid mb-3 text-white mt-5 btn btn-primary"
                    href="https://www.facebook.com/tuananhh111/" target="_blank">Mua template</a>
            </div>
        </div><a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
            <div class="card-body d-flex align-items-center px-admin.components.2 py-1">
                <div class="position-relative rounded-start" style="height:34px;width:28px">
                    <div class="settings-popover"><span class="ripple"><span
                                class="fa-spin position-absolute all-0 d-flex flex-admin.components.center"><span
                                    class="icon-spin position-absolute all-0 d-flex flex-admin.components.center"><svg
                                        width="20" height="20" viewBox="0 0 20 20" fill="#ffffff"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                            fill="#2A7BE4"></path>
                                    </svg></span></span></span></div>
                </div><small class="text-uppercase text-body-tertiary fw-bold py-2 pe-2 ps-1 rounded-end">Tùy
                    chỉnh</small>
            </div>
        </a>

        <!-- JavaScript files -->
        @include('admin.components.script')
        @stack('scripts')
    </body>


    <!-- Mirrored from prium.github.io/phoenix/v1.22.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 10 May 2025 16:41:42 GMT -->

    </html>
