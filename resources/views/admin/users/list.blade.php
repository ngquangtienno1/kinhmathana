@extends('admin.layouts')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Người dùng</li>
@endsection

@section('content')
    <style>
        .contentt {
            margin-top: 0px;
        }
    </style>
    <div class="contentt">
        @if ($errors->has('delete'))
            <div class="alert alert-danger">{{ $errors->first('delete') }}</div>
        @endif
        <h2 class="text-bold text-body-emphasis mb-5">Danh sách người dùng</h2>
        <!-- Tabs for user status filter -->
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item">
                <a class="nav-link {{ !request('status_user') ? 'active' : '' }}" aria-current="page"
                    href="{{ route('admin.users.index', request()->except('status_user')) }}">
                    <span>Tất cả </span>
                    <span class="text-body-tertiary fw-semibold">({{ $allCount }})</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status_user') == 'active' ? 'active' : '' }}"
                    href="{{ route('admin.users.index', array_merge(request()->except('status_user'), ['status_user' => 'active'])) }}">
                    <span>Đang hoạt động </span>
                    <span class="text-body-tertiary fw-semibold">({{ $activeCount }})</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status_user') == 'inactive' ? 'active' : '' }}"
                    href="{{ route('admin.users.index', array_merge(request()->except('status_user'), ['status_user' => 'inactive'])) }}">
                    <span>Không hoạt động </span>
                    <span class="text-body-tertiary fw-semibold">({{ $inactiveCount }})</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status_user') == 'blocked' ? 'active' : '' }}"
                    href="{{ route('admin.users.index', array_merge(request()->except('status_user'), ['status_user' => 'blocked'])) }}">
                    <span>Bị chặn </span>
                    <span class="text-body-tertiary fw-semibold">({{ $blockedCount }})</span>
                </a>
            </li>
        </ul>
        <div id="members"
            data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>
            <!-- Gộp các bộ lọc và search form vào cùng một row -->
            <div class="row align-items-end justify-content-between g-3 mb-4">
                <!-- Bộ lọc -->
                <div class="col-auto">
                    <form class="row g-2 align-items-end" method="GET" action="">
                        <!-- Search Form -->
                        <div class="col-auto">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input class="form-control search-input search" type="search"
                                        placeholder="Tìm kiếm người dùng" aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <label for="role_id" class="form-label mb-0">Vai trò</label>
                            <select class="form-select" id="role_id" name="role_id">
                                <option value="">Tất cả</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="gender" class="form-label mb-0">Giới tính</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Tất cả</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="created_from" class="form-label mb-0">Từ ngày</label>
                            <input type="date" class="form-control" id="created_from" name="created_from"
                                value="{{ request('created_from') }}">
                        </div>
                        <div class="col-auto">
                            <label for="created_to" class="form-label mb-0">Đến ngày</label>
                            <input type="date" class="form-control" id="created_to" name="created_to"
                                value="{{ request('created_to') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Đặt lại</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bảng dữ liệu -->
            <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1">
                <div class="table-responsive scrollbar ms-n1 ps-1">
                    <table class="table table-sm fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="sort align-middle" scope="col" data-sort="customer"
                                    style="width:15%; min-width:200px;">TÊN</th>
                                <th class="sort align-middle" scope="col" data-sort="email"
                                    style="width:15%; min-width:200px;">EMAIL</th>
                                <th class="sort align-middle pe-3" scope="col" data-sort="mobile_number"
                                    style="width:20%; min-width:200px;">SỐ ĐIỆN THOẠI</th>
                                <th class="sort align-middle" scope="col" data-sort="city" style="width:10%;">NƠI Ở
                                </th>
                                <th class="sort align-middle text-end" scope="col" data-sort="last_active"
                                    style="width:21%; min-width:200px;">HOẠT ĐỘNG</th>
                                <th class="sort align-middle text-end pe-0" scope="col" data-sort="joined"
                                    style="width:19%; min-width:200px;">THAM GIA</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="members-table-body">
                            @foreach ($users as $user)
                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                    <td class="customer align-middle white-space-nowrap">
                                        <a class="d-flex align-items-center text-body text-hover-1000"
                                            href="{{ route('admin.users.profile', $user->id) }}">
                                            <div class="avatar avatar-m">
                                                <img class="rounded-circle"
                                                    src="{{ $user->avatar ? asset($user->avatar) : asset('v1/assets/img/blog/blog-1.png') }}"
                                                    alt="" />
                                            </div>
                                            <h6 class="mb-0 ms-3 fw-semibold">{{ $user->name }}</h6>
                                        </a>
                                    </td>
                                    <td class="email align-middle white-space-nowrap">
                                        <a class="fw-semibold" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </td>
                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <a class="fw-bold text-body-emphasis"
                                            href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
                                    </td>
                                    <td class="city align-middle white-space-nowrap text-body">
                                        {{ $user->address ?? 'N/A' }}
                                    </td>
                                    <td class="last_active align-middle text-end white-space-nowrap text-body-tertiary">
                                        {{ $user->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="joined align-middle white-space-nowrap text-body-tertiary text-end">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                        @if (
                                            ($user->role_id == 1 || $user->role_id == 2) &&
                                                (auth()->user()->role_id == 1 || (auth()->user()->role_id == 2 && $user->id == auth()->id())))
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.users.edit', $user->id) }}">Sửa</a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                        <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    </div>
                    <div class="col-auto d-flex">
                        <button class="page-link" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="mb-0 pagination"></ul>
                        <button class="page-link pe-0" data-list-pagination="next"><span
                                class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Tùy chỉnh giao diện để các bộ lọc và search form thẳng hàng */
            .search-box {
                margin-top: 0 !important;
            }

            .search-input {
                padding-left: 2.5rem;
                height: calc(1.5em + 0.75rem + 2px);
                /* Đồng bộ chiều cao với các input khác */
            }

            .search-box-icon {
                position: absolute;
                top: 50%;
                left: 0.75rem;
                transform: translateY(-50%);
                color: #6c757d;
            }

            .form-select,
            .form-control {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            .btn-primary,
            .btn-secondary {
                font-size: 0.875rem;
                padding: 0.375rem 1rem;
            }

            /* Responsive: Xếp chồng các bộ lọc trên màn hình nhỏ */
            @media (max-width: 992px) {
                .row.align-items-end {
                    flex-wrap: wrap;
                }

                .col-auto {
                    margin-bottom: 0.5rem;
                }

                .search-box {
                    width: 100%;
                }

                .search-input {
                    width: 100%;
                }
            }
        </style>
    @endpush
@endsection
