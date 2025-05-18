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
                @if (canAccess('view-products'))
                    <!-- Product Management -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-products" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-products">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="box"></span></span>
                                    <span class="nav-link-text">Products</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-products">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Product List</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Categories</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Brands</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Variations</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Attributes</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Inventory</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- Bình luận -->
                    <li class="nav-item">
                        <p class="navbar-vertical-label">Bình luận & Đánh giá</p>
                        <hr class="navbar-vertical-line" />
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
                            {{-- <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-comments">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.comments.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Danh sách bình luận</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                        </div>
                    </li>
                @endif

                @if (canAccess('view-sliders'))
                    <!-- Quản lý Slider -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-slider" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-orders">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="image"></span></span>
                                    <span class="nav-link-text">Slider</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-slider">
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

                @if (canAccess('view-news'))
                    <!-- Marketing -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-news" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-marketing">
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
                                        <a class="nav-link" href="{{ route('admin.news.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Danh sách tin tức</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.news.bin') }}">
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


                @if (canAccess('view-brands'))
                    <!-- Quản lý Brands -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-brands" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-content">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="tag"></span></span>
                                    <span class="nav-link-text">Quản lý Brands</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-brands">
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
                                    @if (canAccess('view-faqs'))
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
                @if (canAccess('view-settings'))
                    <!-- Settings -->
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-settings" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-settings">
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Sao lưu dữ liệu</span>
                                            </div>
                                        </a>
                                    </li>
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
