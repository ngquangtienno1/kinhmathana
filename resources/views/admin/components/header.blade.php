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
                <a class="nav-link" href="#" style="min-width: 2.25rem" role="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside"><span class="d-block"
                        style="height:20px;width:20px;"><span data-feather="bell"
                            style="height:20px;width:20px;"></span></span></a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border navbar-dropdown-caret"
                    id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
                    <div class="card position-relative border-0">
                        <div class="card-header p-2">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-body-emphasis mb-0">Notifications</h5><button
                                    class="btn btn-link p-0 fs-9 fw-normal" type="button">Mark all as
                                    read</button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="scrollbar-overlay" style="height: 27rem;">
                                <div class="px-2 px-sm-3 py-3 notification-card position-relative read border-bottom">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="avatar avatar-m status-online me-3"><img
                                                    class="rounded-circle"
                                                    src="{{ asset('v1/assets/img/team/40x40/30.webp') }} "
                                                    alt="" />
                                            </div>
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span
                                                        class='me-1 fs-10'>💬</span>Mentioned you in a
                                                    comment.<span
                                                        class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">10m</span>
                                                </p>
                                                <p class="text-body-secondary fs-9 mb-0"><span
                                                        class="me-1 fas fa-clock"></span><span class="fw-bold">10:41
                                                        AM
                                                    </span>August 7,2021</p>
                                            </div>
                                        </div>
                                        <div class="dropdown notification-dropdown"><button
                                                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"
                                                data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                                            <div class="dropdown-menu py-2"><a class="dropdown-item"
                                                    href="#!">Mark
                                                    as
                                                    unread</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="avatar avatar-m status-online me-3">
                                                <div class="avatar-name rounded-circle"><span>J</span></div>
                                            </div>
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs-9 text-body-emphasis">Jane Foster</h4>
                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span
                                                        class='me-1 fs-10'>📅</span>Created an event.<span
                                                        class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">20m</span>
                                                </p>
                                                <p class="text-body-secondary fs-9 mb-0"><span
                                                        class="me-1 fas fa-clock"></span><span class="fw-bold">10:20
                                                        AM
                                                    </span>August 7,2021</p>
                                            </div>
                                        </div>
                                        <div class="dropdown notification-dropdown"><button
                                                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"
                                                data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                                            <div class="dropdown-menu py-2"><a class="dropdown-item"
                                                    href="#!">Mark
                                                    as
                                                    unread</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="avatar avatar-m status-online me-3"><img
                                                    class="rounded-circle avatar-placeholder"
                                                    src="{{ asset('v1/assets/img/team/40x40/avatar.webp') }} "
                                                    alt="" />
                                            </div>
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span
                                                        class='me-1 fs-10'>👍</span>Liked your comment.<span
                                                        class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">1h</span>
                                                </p>
                                                <p class="text-body-secondary fs-9 mb-0"><span
                                                        class="me-1 fas fa-clock"></span><span class="fw-bold">9:30 AM
                                                    </span>August 7,2021</p>
                                            </div>
                                        </div>
                                        <div class="dropdown notification-dropdown"><button
                                                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"
                                                data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                                            <div class="dropdown-menu py-2"><a class="dropdown-item"
                                                    href="#!">Mark
                                                    as
                                                    unread</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="avatar avatar-m status-online me-3"><img
                                                    class="rounded-circle"
                                                    src="{{ asset('v1/assets/img/team/40x40/57.webp') }} "
                                                    alt="" />
                                            </div>
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs-9 text-body-emphasis">Kiera Anderson</h4>
                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span
                                                        class='me-1 fs-10'>💬</span>Mentioned you in a
                                                    comment.<span
                                                        class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10"></span>
                                                </p>
                                                <p class="text-body-secondary fs-9 mb-0"><span
                                                        class="me-1 fas fa-clock"></span><span class="fw-bold">9:11 AM
                                                    </span>August 7,2021</p>
                                            </div>
                                        </div>
                                        <div class="dropdown notification-dropdown"><button
                                                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"
                                                data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                                            <div class="dropdown-menu py-2"><a class="dropdown-item"
                                                    href="#!">Mark
                                                    as
                                                    unread</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="avatar avatar-m status-online me-3"><img
                                                    class="rounded-circle"
                                                    src="{{ asset('v1/assets/img/team/40x40/59.webp') }} "
                                                    alt="" />
                                            </div>
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs-9 text-body-emphasis">Herman Carter</h4>
                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span
                                                        class='me-1 fs-10'>👤</span>Tagged you in a
                                                    comment.<span
                                                        class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10"></span>
                                                </p>
                                                <p class="text-body-secondary fs-9 mb-0"><span
                                                        class="me-1 fas fa-clock"></span><span class="fw-bold">10:58
                                                        PM
                                                    </span>August 7,2021</p>
                                            </div>
                                        </div>
                                        <div class="dropdown notification-dropdown"><button
                                                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"
                                                data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                                            <div class="dropdown-menu py-2"><a class="dropdown-item"
                                                    href="#!">Mark
                                                    as
                                                    unread</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2 px-sm-3 py-3 notification-card position-relative read ">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="avatar avatar-m status-online me-3"><img
                                                    class="rounded-circle"
                                                    src="{{ asset('v1/assets/img/team/40x40/58.webp') }} "
                                                    alt="" />
                                            </div>
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs-9 text-body-emphasis">Benjamin Button</h4>
                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal"><span
                                                        class='me-1 fs-10'>👍</span>Liked your comment.<span
                                                        class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10"></span>
                                                </p>
                                                <p class="text-body-secondary fs-9 mb-0"><span
                                                        class="me-1 fas fa-clock"></span><span class="fw-bold">10:18
                                                        AM
                                                    </span>August 7,2021</p>
                                            </div>
                                        </div>
                                        <div class="dropdown notification-dropdown"><button
                                                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false"
                                                data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10 text-body"></span></button>
                                            <div class="dropdown-menu py-2"><a class="dropdown-item"
                                                    href="#!">Mark
                                                    as
                                                    unread</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-0 border-top border-translucent border-0">
                            <div class="my-2 text-center fw-bold fs-10 text-body-tertiary text-opactity-85"><a
                                    class="fw-bolder" href="pages/notifications.html">Notification history</a>
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
                                        href="#!"><img
                                            src="{{ asset('v1/assets/img/nav-icons/behance.webp') }} " alt=""
                                            width="30" />
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
                            <div class="px-3">
                                <a href="{{ route('logout') }}"
                                    class="btn btn-phoenix-secondary d-flex flex-center w-100 mt-2">
                                    <span class="me-2" data-feather="log-out"></span>
                                    Đăng xuất
                                </a>
                            </div>
                            <div class="my-2 text-center fw-bold fs-10 text-body-quaternary">
                                <a class="text-body-quaternary me-1" href="#!">Privacy policy</a>&bull;
                                <a class="text-body-quaternary mx-1" href="#!">Terms</a>&bull;
                                <a class="text-body-quaternary ms-1" href="#!">Cookies</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

<style>
    .logo-container {
        position: relative;
        padding: 6px 0;
    }

    .logo-wrapper {
        position: relative;
        padding: 6px;
        border-radius: 10px;
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        box-shadow: 4px 4px 8px #d9d9d9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
    }

    .logo-wrapper:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #d9d9d9, -6px -6px 12px #ffffff;
    }

    .logo-img {
        transition: all 0.3s ease;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .logo-wrapper:hover .logo-img {
        transform: scale(1.1) rotate(5deg);
    }

    .gradient-text {
        background: linear-gradient(45deg, #2c3e50, #3498db, #2980b9);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shine 3s linear infinite;
        font-size: 1.25rem;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    @keyframes shine {
        to {
            background-position: 200% center;
        }
    }

    .navbar-brand {
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        opacity: 0.95;
    }

    /* Dark mode support */
    [data-bs-theme="dark"] .logo-wrapper {
        background: linear-gradient(145deg, #2d2d2d, #1a1a1a);
        box-shadow: 4px 4px 8px #1a1a1a, -4px -4px 8px #2d2d2d;
    }

    [data-bs-theme="dark"] .logo-wrapper:hover {
        box-shadow: 6px 6px 12px #1a1a1a, -6px -6px 12px #2d2d2d;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('globalSearch');
        const searchDropdown = document.getElementById('searchResults');
        const searchResultsList = document.getElementById('searchResultsList');
        const searchLoading = document.getElementById('searchLoading');
        const searchNoResults = document.getElementById('searchNoResults');
        const viewAllResults = document.getElementById('viewAllResults');

        let searchTimeout;
        let isSearching = false;

        // Hiển thị/ẩn dropdown
        function showDropdown() {
            searchDropdown.classList.add('show');
        }

        function hideDropdown() {
            searchDropdown.classList.remove('show');
        }

        // Xử lý sự kiện input
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            // Ẩn các trạng thái trước đó
            searchLoading.style.display = 'none';
            searchNoResults.style.display = 'none';
            viewAllResults.style.display = 'none';
            searchResultsList.innerHTML = '';

            if (query.length < 2) {
                hideDropdown();
                return;
            }

            // Hiển thị loading và dropdown
            searchLoading.style.display = 'block';
            showDropdown();

            // Debounce search
            searchTimeout = setTimeout(() => {
                if (!isSearching) {
                    isSearching = true;
                    fetch(`{{ route('admin.search') }}?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            searchLoading.style.display = 'none';
                            searchResultsList.innerHTML = ''; // Clear previous results

                            if (data.success) {
                                if (data.results.length > 0) {
                                    // Nhóm kết quả theo loại
                                    const groupedResults = data.results.reduce((acc,
                                        result) => {
                                        if (!acc[result.type]) {
                                            acc[result.type] = [];
                                        }
                                        acc[result.type].push(result);
                                        return acc;
                                    }, {});

                                    // Hiển thị kết quả theo nhóm
                                    Object.entries(groupedResults)
                                        .map(([type, results]) => `
                                            <div class="list-group-item px-3 py-2 bg-light text-body-emphasis">
                                                <h6 class="mb-0 text-700">${getTypeLabel(type)}</h6>
                                            </div>
                                            ${results.map(result => `
                                                <a href="${result.url}" class="list-group-item list-group-item-action px-3 py-2 d-flex align-items-center">
                                                    <span class="fas ${result.icon} me-3 text-primary"></span>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 text-body">${result.title}</h6>
                                                        ${result.description ? `<small class="text-muted">${result.description}</small>` : ''}
                                                    </div>
                                                </a>
                                            `).join('')}
                                        `)
                                        .forEach(html => searchResultsList.innerHTML +=
                                            html);

                                    // Hiển thị nút xem tất cả nếu có kết quả
                                    viewAllResults.style.display = 'block';
                                    viewAllResults.href =
                                        `{{ route('admin.search.results') }}?q=${encodeURIComponent(query)}`;

                                } else {
                                    searchNoResults.style.display = 'block';
                                }
                            } else {
                                searchResultsList.innerHTML = `
                                    <div class="list-group-item px-3 py-2 text-center text-danger">
                                        ${data.message}
                                    </div>
                                `;
                            }
                        })
                        .catch(error => {
                            searchLoading.style.display = 'none';
                            searchResultsList.innerHTML = `
                                <div class="list-group-item px-3 py-2 text-center text-danger">
                                    Có lỗi xảy ra khi tìm kiếm.
                                </div>
                            `;
                            console.error('Search error:', error);
                        })
                        .finally(() => {
                            isSearching = false;
                        });
                }
            }, 300);
        });

        // Xử lý sự kiện click outside để đóng dropdown
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !searchDropdown.contains(event.target)) {
                hideDropdown();
            }
        });

        // Xử lý phím Escape để đóng dropdown và xóa nội dung input
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideDropdown();
                searchInput.value = '';
            }
        });

        // Hàm lấy nhãn cho loại kết quả
        function getTypeLabel(type) {
            const labels = {
                'product': 'Sản phẩm',
                'news': 'Tin tức',
                'order': 'Đơn hàng',
                'comment': 'Bình luận',
                'category': 'Danh mục',
                'promotion': 'Khuyến mãi'
            };
            return labels[type] || type;
        }

        // Giữ dropdown mở khi click vào nó (ngăn chặn đóng do click outside)
        searchDropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        // Đảm bảo dropdown mở lại nếu input có giá trị khi người dùng quay lại trang
        if (searchInput.value.trim().length >= 2) {
            // Tự động kích hoạt tìm kiếm lại khi tải trang nếu có query trong input
            searchInput.dispatchEvent(new Event('input'));
        }
    });
</script>
