<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1" href="#">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><span data-feather="home"></span></span>
                                <span class="nav-link-text">Dashboard</span>
                            </div>
                        </a>
                    </div>
                </li>
                @if(canAccess('xem-danh-sach-san-pham'))
                <!-- Product Management -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-products" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-products">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-products">

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.products.list') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách sản phẩm</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.variations.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Biến thể sản phẩm</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách danh mục</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.brands.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Thương hiệu</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <div class="nav-item-wrapper">
                                            <a class="nav-link dropdown-indicator label-1" href="#nv-attributes"
                                                role="button" data-bs-toggle="collapse"
                                                aria-expanded="{{ request()->is('admin/colors*') || request()->is('admin/sizes*') ? 'true' : 'false' }}"
                                                aria-controls="nv-attributes">
                                                <div class="d-flex align-items-center">
                                                    <div class="dropdown-indicator-icon-wrapper">
                                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                                    </div>
                                                    <span class="nav-link-text">Thuộc tính</span>
                                                </div>
                                            </a>
                                            <div class="parent-wrapper label-1">
                                                <ul class="nav collapse parent {{ request()->is('admin/colors*') || request()->is('admin/sizes*') ? 'show' : '' }}"
                                                    data-bs-parent="#nv-products" id="nv-attributes">
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ request()->is('admin/colors*') ? 'active' : '' }}"
                                                            href="{{ route('admin.colors.index') }}">
                                                            <div class="d-flex align-items-center">
                                                                <span class="nav-link-text">Màu sắc</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ request()->is('admin/sizes*') ? 'active' : '' }}"
                                                            href="{{ route('admin.sizes.index') }}">
                                                            <div class="d-flex align-items-center">
                                                                <span class="nav-link-text">Kích thước</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Tồn kho</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @if (canAccess('view-orders'))
                        <!-- Orders Management -->
                        <li class="nav-item">
                            <div class="nav-item-wrapper">
                                <a class="nav-link dropdown-indicator label-1" href="#nv-orders" role="button"
                                    data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-orders">
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
                                            <a class="nav-link" href="{{ route('admin.orders.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Danh sách đơn hàng</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                    <!-- Bình luận -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-comments" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-comments">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="shopping-bag"></span></span>
                                    <span class="nav-link-text">Bình luận</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-comments">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.comments.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách bình luận</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('admin.comments.index', array_merge(request()->all(), ['status' => 'trashed'])) }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Thùng rác</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if(canAccess('xem-danh-sach-slider'))
                <!-- Quản lý Slider -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-slider" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-orders">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-slider">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.sliders.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách Slider</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.sliders.bin') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Thùng rác</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if(canAccess('xem-news'))
                <!-- Marketing -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-news" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-marketing">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-news">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.news.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách tin tức</span>
                                            </div>
                                        </a>
                                    </li>
                                    {{-- Thùng rác tin tức - chưa có route --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Thùng rác</span>
                                            </div>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if(canAccess('xem-danh-sach-faq'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.faqs.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-text">FAQ</span>
                        </div>
                    </a>
                </li>
                @endif

                @if (canAccess('view-users'))
                    <!-- User Management -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-users" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-users">
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.listUser') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách người dùng</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if (canAccess('view-roles'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.roles.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Roles</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (canAccess('view-permissions'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">Permissions</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Activity Log - chưa có route --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Activity Log</span>
                                            </div>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-brands">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.brands.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Danh sách Brands</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.brands.bin') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Comments</span>
                                        </div>
                                    </a>
                                </li>
                                @if(canAccess('xem-danh-sach-faq'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.faqs.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">FAQ</span>
                                        </div>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Pages</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Media Library</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                @if(canAccess('xem-danh-sach-nguoi-dung'))
                <!-- User Management -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-users" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-users">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="user-check"></span></span>
                                <span class="nav-link-text">Người dùng</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-users">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.listUser') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Danh sách người dùng</span>
                                        </div>
                                    </a>
                                </li>
                                @if(canAccess('xem-danh-sach-vai-tro'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.roles.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Roles</span>
                                        </div>
                                    </a>
                                </li>
                                @endif
                                @if(canAccess('xem-danh-sach-quyen'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Permissions</span>
                                        </div>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Activity Log</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                @endif

                <!-- Reports -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-reports" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-reports">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="bar-chart-2"></span></span>
                                <span class="nav-link-text">Reports</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-reports">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Sales Reports</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Product Reports</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Customer Reports</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Analytics</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                @if(canAccess('xem-cai-dat'))
                <!-- Settings -->
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-settings" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-settings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-settings">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.settings.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Cài đặt chung</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.shipping.providers.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Đơn vị vận chuyển</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.roles.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Quản lý vai trò</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Quản lý quyền</span>
                                            </div>
                                        </a>
                                    </li>
                                    {{-- Sao lưu dữ liệu - chưa có route --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Sao lưu dữ liệu</span>
                                            </div>
                                        </a>
                                    </li> --}}
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
            <span class="navbar-vertical-footer-text ms-2">Collapsed View</span>
        </button>
    </div>
</nav>
