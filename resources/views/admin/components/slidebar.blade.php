<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ request()->routeIs('admin.home') ? 'active' : '' }}"
                            href="{{ route('admin.home') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><span data-feather="home"></span></span>
                                <span class="nav-link-text">Trang chủ</span>
                            </div>
                        </a>
                    </div>
                </li>
                @if (canAccess('xem-danh-sach-khach-hang'))
                    <!-- Quản lý Khách hàng -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                                href="#nv-customers" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-customers">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="users"></span></span>
                                    <span class="nav-link-text">Khách hàng</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-customers">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}"
                                            href="{{ route('admin.customers.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách khách hàng</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
                @if (canAccess('xem-danh-sach-san-pham') ||
                        canAccess('xem-bien-the-san-pham') ||
                        canAccess('xem-danh-sach-danh-muc') ||
                        canAccess('xem-danh-sach-mau-sac') ||
                        canAccess('xem-danh-sach-kich-thuoc'))
                    <!-- Product Management -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.variations.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.colors.*') || request()->routeIs('admin.sizes.*') ? 'active' : '' }}"
                                href="#nv-products" role="button" data-bs-toggle="collapse"
                                aria-expanded="{{ request()->is('admin/products*') ||
                                request()->is('admin/variations*') ||
                                request()->is('admin/categories*') ||
                                request()->is('admin/brands*') ||
                                request()->is('admin/colors*') ||
                                request()->is('admin/sizes*')
                                    ? 'true'
                                    : 'false' }}"
                                aria-controls="nv-products">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="box"></span></span>
                                    <span class="nav-link-text">Sản phẩm</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent {{ request()->is('admin/products*') ||
                                request()->is('admin/variations*') ||
                                request()->is('admin/categories*') ||
                                request()->is('admin/colors*') ||
                                request()->is('admin/sizes*')
                                    ? 'show'
                                    : '' }}"
                                    data-bs-parent="#navbarVerticalCollapse" id="nv-products">

                                    @if (canAccess('xem-danh-sach-san-pham'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                                href="{{ route('admin.products.list') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Danh sách sản phẩm</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif

                                    @if (canAccess('xem-danh-sach-danh-muc'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                                                href="{{ route('admin.categories.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Danh sách danh mục</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif

                                    @if (canAccess('xem-mau-sac') || canAccess('xem-kich-thuoc'))
                                        <li class="nav-item">
                                            <div class="nav-item-wrapper">
                                                <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.colors.*') || request()->routeIs('admin.sizes.*') ? 'active' : '' }}"
                                                    href="#nv-attributes" role="button" data-bs-toggle="collapse"
                                                    aria-expanded="{{ request()->is('admin/colors*') || request()->is('admin/sizes*') ? 'true' : 'false' }}"
                                                    aria-controls="nv-attributes">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-indicator-icon-wrapper">
                                                            <span
                                                                class="fas fa-caret-right dropdown-indicator-icon"></span>
                                                        </div>
                                                        <span class="nav-link-text">Thuộc tính</span>
                                                    </div>
                                                </a>
                                                <div class="parent-wrapper label-1">
                                                    <ul class="nav collapse parent {{ request()->is('admin/colors*') || request()->is('admin/sizes*') ? 'show' : '' }}"
                                                        data-bs-parent="#nv-products" id="nv-attributes">
                                                        @if (canAccess('xem-mau-sac'))
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}"
                                                                    href="{{ route('admin.colors.index') }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="nav-link-text">Màu sắc</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if (canAccess('xem-kich-thuoc'))
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}"
                                                                    href="{{ route('admin.sizes.index') }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="nav-link-text">Kích thước</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-don-hang'))
                    <!-- Orders Management -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                                href="#nv-orders" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-orders">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="shopping-cart"></span></span>
                                    <span class="nav-link-text">Đơn hàng</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-orders">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"
                                            href="{{ route('admin.orders.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách đơn hàng</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.orders.status_histories.*') ? 'active' : '' }}"
                                            href="{{ route('admin.orders.status_histories.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Lịch sử cập nhật</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-binh-luan'))
                    <!-- Bình luận -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}"
                                href="#nv-comments" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-comments">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="message-square"></span></span>
                                    <span class="nav-link-text">Bình luận</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-comments">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.comments.index') && !request()->has('status') ? 'active' : '' }}"
                                            href="{{ route('admin.comments.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách bình luận</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xoa-binh-luan'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.comments.index') && request()->has('status') ? 'active' : '' }}"
                                                href="{{ route('admin.comments.index', array_merge(request()->all(), ['status' => 'trashed'])) }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Thùng rác</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-danh-gia'))
                    <!-- Đánh giá -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"
                                href="#nv-reviews" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-reviews">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="star"></span></span>
                                    <span class="nav-link-text">Đánh giá</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-reviews">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"
                                            href="{{ route('admin.reviews.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách đánh giá</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-khuyen-mai'))
                    <!-- Khuyến mãi -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"
                                href="#nv-promotions" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-promotions">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="percent"></span></span>
                                    <span class="nav-link-text">Khuyến mãi</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-promotions">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách khuyến mãi</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-slider'))
                    <!-- Quản lý Slider -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}"
                                href="#nv-slider" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-slider">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="image"></span></span>
                                    <span class="nav-link-text">Slider</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-slider">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.sliders.index') ? 'active' : '' }}"
                                            href="{{ route('admin.sliders.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách Slider</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xoa-slider'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.sliders.bin') ? 'active' : '' }}"
                                                href="{{ route('admin.sliders.bin') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Thùng rác</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-news'))
                    <!-- News -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.news.*') ? 'active' : '' }}"
                                href="#nv-news" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-news">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="file-text"></span></span>
                                    <span class="nav-link-text">Tin tức</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-news">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.news.index') ? 'active' : '' }}"
                                            href="{{ route('admin.news.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách tin tức</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xem-danh-muc-tin-tuc'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.news.categories.*') ? 'active' : '' }}"
                                                href="{{ route('admin.news.categories.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Danh mục tin tức</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif


                @if (canAccess('xem-danh-sach-thuong-hieu'))
                    <!-- Quản lý Brands -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}"
                                href="#nv-brands" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-brands">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="tag"></span></span>
                                    <span class="nav-link-text">Brands</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-brands">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}"
                                            href="{{ route('admin.brands.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách Brands</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-faq'))
                    <!-- Quản lý FAQ -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"
                                href="#nv-faqs" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-faqs">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="help-circle"></span></span>
                                    <span class="nav-link-text">FAQ</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-faqs">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"
                                            href="{{ route('admin.faqs.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách FAQ</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                {{-- @if (canAccess('xem-ticket'))
                    <!-- Quản lý Ticket -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}"
                                href="#nv-tickets" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-tickets">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="message-circle"></span></span>
                                    <span class="nav-link-text">Ticket</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-tickets">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.tickets.index') ? 'active' : '' }}"
                                            href="{{ route('admin.tickets.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách ticket</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xem-thung-rac-ticket'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.tickets.trashed') ? 'active' : '' }}"
                                                href="{{ route('admin.tickets.trashed') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Thùng rác</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif --}}

                @if (canAccess('xem-danh-sach-lien-he'))
                <!-- Quản lý Liên hệ -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
                            href="#nv-contacts" role="button" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="nv-contacts">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="message-circle"></span></span>
                                <span class="nav-link-text">Liên hệ</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                id="nv-contacts">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}"
                                        href="{{ route('admin.contacts.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Danh sách liên hệ</span>
                                        </div>
                                    </a>
                                </li>
                                @if (canAccess('xem-thung-rac-lien-he'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.contacts.bin') ? 'active' : '' }}"
                                            href="{{ route('admin.contacts.bin') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Thùng rác</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </li>
            @endif

                @if (canAccess('xem-ly-do-huy-don'))
                    <!-- Quản lý Lý do hủy -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.cancellation_reasons.*') ? 'active' : '' }}"
                                href="#nv-cancellation-reasons" role="button" data-bs-toggle="collapse"
                                aria-expanded="false" aria-controls="nv-cancellation-reasons">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="x-circle"></span></span>
                                    <span class="nav-link-text">Lý do hủy đơn</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-cancellation-reasons">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.cancellation_reasons.index') ? 'active' : '' }}"
                                            href="{{ route('admin.cancellation_reasons.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách lý do hủy</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xem-thung-rac-ly-do-huy-don'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.cancellation_reasons.bin') ? 'active' : '' }}"
                                                href="{{ route('admin.cancellation_reasons.bin') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Thùng rác</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                {{-- @if (canAccess('xem-danh-sach-ho-tro-khach-hang'))
                    <!-- Quản lý Hỗ trợ khách hàng -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.support.*') ? 'active' : '' }}"
                                href="#nv-support" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-support">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="message-circle"></span></span>
                                    <span class="nav-link-text">Hỗ trợ khách hàng</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-support">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.support.list') ? 'active' : '' }}"
                                            href="{{ route('admin.support.list') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách hỗ trợ khách hàng</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif --}}
                @if (canAccess('xem-danh-sach-thong-bao'))
                    <!-- Quản lý Thông báo -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}"
                                href="#nv-notifications" role="button" data-bs-toggle="collapse"
                                aria-expanded="false" aria-controls="nv-notifications">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="bell"></span></span>
                                    <span class="nav-link-text">Thông báo</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-notifications">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}"
                                            href="{{ route('admin.notifications.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách thông báo</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-phuong-thuc-thanh-toan'))
                    <!-- Quản lý Lý do hủy -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.payment_methods.*') ? 'active' : '' }}"
                                href="#nv-payment-methods" role="button" data-bs-toggle="collapse"
                                aria-expanded="false" aria-controls="nv-payment-methods">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="credit-card"></span></span>
                                    <span class="nav-link-text">Phương thức thanh toán</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-payment-methods">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.payment_methods.index') ? 'active' : '' }}"
                                            href="{{ route('admin.payment_methods.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách phương thức thanh toán</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xoa-phuong-thuc-thanh-toan'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.payment_methods.bin') ? 'active' : '' }}"
                                                href="{{ route('admin.payment_methods.bin') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Thùng rác</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-danh-sach-nguoi-dung') || canAccess('xem-danh-sach-vai-tro') || canAccess('xem-danh-sach-quyen'))
                    <!-- User Management -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
                                href="#nv-users" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-users">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="user-check"></span></span>
                                    <span class="nav-link-text">Người dùng</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-users">
                                    @if (canAccess('xem-danh-sach-nguoi-dung'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                                                href="{{ route('admin.users.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Danh sách người dùng</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (canAccess('xem-danh-sach-vai-tro'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                                                href="{{ route('admin.roles.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Roles</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (canAccess('xem-danh-sach-quyen'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
                                                href="{{ route('admin.permissions.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Permissions</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (canAccess('xem-cai-dat'))
                    <!-- Settings -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.shipping.providers.*') ? 'active' : '' }}"
                                href="#nv-settings" role="button" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="nv-settings">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="settings"></span></span>
                                    <span class="nav-link-text">Cài đặt</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-settings">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                                            href="{{ route('admin.settings.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Cài đặt chung</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('xem-don-vi-van-chuyen'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.shipping.providers.*') ? 'active' : '' }}"
                                                href="{{ route('admin.shipping.providers.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Đơn vị vận chuyển</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (canAccess('xem-danh-sach-vai-tro'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                                                href="{{ route('admin.roles.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Quản lý vai trò</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (canAccess('xem-danh-sach-quyen'))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
                                                href="{{ route('admin.permissions.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Quản lý quyền</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-8"></span>
            <span class="uil uil-arrow-from-right fs-8"></span>
            <span class="navbar-vertical-footer-text ms-2">Chế độ thu gọn</span>
        </button>
    </div>
</nav>
