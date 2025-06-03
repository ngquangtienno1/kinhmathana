@stack('styles')

<nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="navbar-logo">
            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
                aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('admin.home') }}">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center logo-container" style="margin-left: 20px;">
                        <div class="logo-wrapper">
                            <img src="{{ getLogoUrl() }}" alt="phoenix" width="32" class="logo-img"
                                style="border-radius: 5px;" />
                        </div>
                        <h5 class="logo-text ms-3 d-none d-sm-block fw-bold">
                            <span class="gradient-text">{{ getSetting('website_name') }}</span>
                        </h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="search-box">
            <form class="position-relative" action="{{ route('admin.search.results') }}" method="GET">
                <input class="form-control search-input search" type="search" name="q" id="globalSearch"
                    placeholder="Tìm kiếm..." value="{{ request('q') }}" aria-label="Search" autocomplete="off" />
                <span class="fas fa-search search-box-icon"></span>
            </form>
            <div class="dropdown-menu dropdown-menu-end search-dropdown-menu py-0 shadow border rounded-2"
                id="searchResults" style="width: 25rem; max-height: 24rem; overflow-y: auto;">
                <div class="list-group list-group-flush" id="searchResultsList">
                    {{-- Search results will be loaded here --}}
                </div>
                <div class="list-group-item px-3 py-2 text-center" id="searchLoading" style="display: none;">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
                <div class="list-group-item px-3 py-2 text-center text-muted" id="searchNoResults"
                    style="display: none;">
                    Không tìm thấy kết quả.
                </div>
                <a href="{{ route('admin.search.results', ['q' => request('q')]) }}"
                    class="list-group-item list-group-item-action px-3 py-2 text-center text-primary"
                    id="viewAllResults" style="display: none;">
                    Xem tất cả kết quả
                </a>
            </div>
        </div>
        <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2"><input
                        class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                        data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" /><label
                        class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="moon"></span></label><label
                        class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="sun"></span></label></div>
            </li>
            <li class="nav-item d-lg-none"><a class="nav-link" href="#" data-bs-toggle="modal"
                    data-bs-target="#searchBoxModal"><span data-feather="search"
                        style="height:19px;width:19px;margin-bottom: 2px;"></span></a></li>
            <li class="nav-item dropdown">
                <a class="nav-link position-relative" href="#" style="min-width: 2.25rem" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside"
                    id="notificationDropdownToggle">
                    <span class="d-block" style="height:20px;width:20px;position:relative;">
                        <span data-feather="bell" style="height:20px;width:20px;"></span>
                        <span id="notification-badge"
                            style="display:none;position:absolute;top:-9px;right:-5px;min-width:20px;height:18px;background:#ff3b3b;color:#fff;font-size:12px;font-weight:bold;line-height:15px;text-align:center;border-radius:50%;border:2px solid #fff;z-index:10;"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border navbar-dropdown-caret"
                    id="navbarDropdownNotfication" aria-labelledby="notificationDropdownToggle"
                    style="min-width:350px;max-width:400px;">
                    <div class="card position-relative border-0">
                        <div class="card-header p-2">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-body-emphasis mb-0">Thông báo</h5>
                                <a href="{{ route('admin.notifications.index') }}"
                                    class="btn btn-link p-0 fs-9 fw-normal">Xem tất cả</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="scrollbar-overlay" style="max-height: 27rem;"
                                id="dropdown-notification-list">
                                <div class="text-center py-4 text-muted">Đang tải...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" data-bs-auto-close="outside"
                    aria-expanded="false"><svg width="16" height="16" viewbox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
                    </svg></a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nine-dots shadow border"
                    aria-labelledby="navbarDropdownNindeDots">
                    <div class="card bg-body-emphasis position-relative border-0">
                        <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
                            <div class="row text-center align-items-center gx-0 gy-0">
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img src="{{ asset('v1/assets/img/nav-icons/behance.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Behance
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/google-cloud.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Cloud
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img src="{{ asset('v1/assets/img/nav-icons/slack.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Slack
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img src="{{ asset('v1/assets/img/nav-icons/gitlab.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Gitlab
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/bitbucket.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">
                                            BitBucket</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/google-drive.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Drive
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img src="{{ asset('v1/assets/img/nav-icons/trello.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Trello
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img src="{{ asset('v1/assets/img/nav-icons/figma.webp') }} "
                                            alt="" width="20" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Figma
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/twitter.webp') }} " alt=""
                                            width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Twitter
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/pinterest.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">
                                            Pinterest</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img src="{{ asset('v1/assets/img/nav-icons/ln.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">
                                            Linkedin</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/google-maps.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Maps
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/google-photos.webp') }} "
                                            alt="" width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Photos
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/spotify.webp') }} " alt=""
                                            width="30" />
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Spotify
                                        </p>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!"
                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="avatar avatar-l ">
                        <img class="rounded-circle"
                            src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('v1/assets/img/team/40x40/57.webp') }}"
                            alt="{{ auth()->user()->name }}" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border"
                    aria-labelledby="navbarDropdownUser">
                    <div class="card position-relative border-0">
                        <div class="card-body p-0">
                            <div class="text-center pt-4 pb-3">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle"
                                        src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('v1/assets/img/team/72x72/57.webp') }}"
                                        alt="{{ auth()->user()->name }}" />
                                </div>
                                <h6 class="mt-2 text-body-emphasis">{{ auth()->user()->name }}</h6>
                                <p class="text-body-tertiary mb-0">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="overflow-auto scrollbar" style="height: 10rem;">
                            <ul class="nav d-flex flex-column mb-2 pb-1">
                                <li class="nav-item">
                                    <a class="nav-link px-3 d-block" href="{{ route('admin.users.profile') }}">
                                        <span class="me-2 text-body align-bottom" data-feather="user"></span>
                                        <span>Thông tin tài khoản</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 d-block" href="{{ route('admin.home') }}">
                                        <span class="me-2 text-body align-bottom" data-feather="pie-chart"></span>
                                        Thống kê
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 d-block" href="{{ route('admin.settings.index') }}">
                                        <span class="me-2 text-body align-bottom" data-feather="settings"></span>
                                        Cài đặt & Bảo mật
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 d-block" href="{{ route('admin.faqs.index') }}">
                                        <span class="me-2 text-body align-bottom" data-feather="help-circle"></span>
                                        FAQS
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer p-0 border-top border-translucent">

                            <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100"
                                    href="{{ route('logout') }}">
                                    <span class="me-2" data-feather="log-out"> </span>Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
@push('styles')
    <style>
        .dropdown-notification-dot {
            position: absolute;
            left: -4px;
            top: 2px;
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            border: 2px solid #fff;
            z-index: 2;
        }

        .dropdown-menu.dropdown-menu-end.py-2 {
            min-width: 180px !important;
            padding: 8px 0;
            right: 0 !important;
            left: auto !important;
            z-index: 9999;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            text-align: left;
        }

        .dropdown-item.dropdown-mark-as-read {
            white-space: nowrap;
            font-size: 15px;
            padding: 8px 18px;
            text-align: left !important;
            direction: ltr;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function renderDropdownNotifications(data) {
                let html = '';
                if (data.notifications.length === 0) {
                    html = '<div class="text-center py-4 text-muted">Không có thông báo</div>';
                } else {
                    data.notifications.forEach(function(n, idx) {
                        html += `
                        <div class="d-flex align-items-center px-3 py-2 border-bottom dropdown-notification-item ${n.is_read ? 'read' : 'unread'}"
                             style="position:relative;${!n.is_read ? 'background:#e9ecef !important;' : 'background:#fff !important;'}"
                             data-notification-id="${n.id}">
                            <div class="avatar avatar-m me-3 position-relative" style="width:40px;height:40px;">
                                ${!n.is_read ? '<span class="dropdown-notification-dot"></span>' : ''}
                                <span class='avatar-name rounded-circle bg-warning d-flex align-items-center justify-content-center' style='width:40px;height:40px;font-size:20px;'>🔔</span>
                            </div>
                            <div class="flex-1 me-sm-3">
                                <div class="fw-bold mb-1">${n.title || 'Hệ thống'}</div>
                                <div class="fs-9 text-body-highlight mb-1">${n.content}</div>
                                <div class="small text-body-secondary"><span class="me-1 fas fa-clock"></span>${n.time_ago || ''}</div>
                            </div>
                            ${!n.is_read ? `
                                                                                            <div class="dropdown ms-2">
                                                                                                <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                                                    <span class="fas fa-ellipsis-h fs-10 text-body"></span>
                                                                                                </button>
                                                                                                <div class="dropdown-menu dropdown-menu-end py-2" style="min-width:180px;z-index:9999;left:auto;right:0;text-align:left;">
                                                                                                    <a class="dropdown-item dropdown-mark-as-read" href="#">Đánh dấu đã đọc</a>
                                                                                                </div>
                                                                                            </div>
                                                                                            ` : ''}
                        </div>`;
                    });
                }
                $('#dropdown-notification-list').html(html);
                if (data.unreadCount > 0) {
                    $('#notification-badge').show().text(data.unreadCount);
                } else {
                    $('#notification-badge').hide();
                }
                // Gắn sự kiện đánh dấu đã đọc cho dropdown
                $('.dropdown-mark-as-read').off('click').on('click', function(e) {
                    e.preventDefault();
                    const card = $(this).closest('.dropdown-notification-item');
                    const id = card.data('notification-id');
                    $.ajax({
                        url: `/admin/notifications/${id}/mark-as-read`,
                        method: 'POST',
                        success: function() {
                            card.removeClass('unread').addClass('read');
                            card.css('background',
                                '#fff'); // Đổi nền trắng ngay khi đánh dấu đã đọc
                            card.find('.dropdown-notification-dot').remove();
                            card.find('.dropdown').remove();
                            // Reload lại badge
                            $.get("{{ url('/admin/notifications/dropdown') }}", function(
                                data) {
                                if (data.unreadCount > 0) {
                                    $('#notification-badge').show().text(data
                                        .unreadCount);
                                } else {
                                    $('#notification-badge').hide();
                                }
                            });
                        }
                    });
                });
            }

            function loadDropdownNotifications() {
                $.get("{{ url('/admin/notifications/dropdown') }}", function(data) {
                    renderDropdownNotifications(data);
                });
            }
            // Load khi mở dropdown
            $('#notificationDropdownToggle').on('click', function() {
                loadDropdownNotifications();
            });
            // Load badge số lượng chưa đọc khi vừa load trang
            $.get("{{ url('/admin/notifications/dropdown') }}", function(data) {
                if (data.unreadCount > 0) {
                    $('#notification-badge').show().text(data.unreadCount);
                } else {
                    $('#notification-badge').hide();
                }
            });
        });
    </script>
@endpush
