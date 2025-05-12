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

                <!-- Product Management -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Product Management</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-products" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-products">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="shopping-bag"></span></span>
                                <span class="nav-link-text">Products</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-products">
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

                <!-- Quản lý Slider -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Quản lý Slider</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-orders" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-orders">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="shopping-cart"></span></span>
                                <span class="nav-link-text">Slider</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-orders">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.slider.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Danh sách Slider</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Payments</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Shipping</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Returns</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Marketing -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Marketing</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-marketing" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-marketing">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="percent"></span></span>
                                <span class="nav-link-text">Tin tức</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                id="nv-marketing">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.news.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Danh sách tin tức</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Flash Sales</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Email Marketing</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Affiliate Program</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Content Management -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Content Management</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-content" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-content">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="file-text"></span></span>
                                <span class="nav-link-text">Content</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-content">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Blog Posts</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Comments</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">FAQ</span>
                                        </div>
                                    </a>
                                </li>
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

                <!-- Customer Management -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Customer Management</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-customers" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-customers">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="users"></span></span>
                                <span class="nav-link-text">Customers</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                id="nv-customers">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Customer List</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Customer Groups</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Reviews</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Wishlist</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- User Management -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">User Management</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-users" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-users">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="user"></span></span>
                                <span class="nav-link-text">Users</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-users">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">User List</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Roles</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Permissions</span>
                                        </div>
                                    </a>
                                </li>
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

                <!-- Reports -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Reports</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-reports" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-reports">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="bar-chart"></span></span>
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

                <!-- Settings -->
                <li class="nav-item">
                    <p class="navbar-vertical-label">Settings</p>
                    <hr class="navbar-vertical-line" />
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-settings" role="button"
                            data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-settings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><span data-feather="settings"></span></span>
                                <span class="nav-link-text">Settings</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                id="nv-settings">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">General Settings</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Payment Methods</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Shipping Methods</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Tax Settings</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">SEO Settings</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Email Templates</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Backup & Restore</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
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
