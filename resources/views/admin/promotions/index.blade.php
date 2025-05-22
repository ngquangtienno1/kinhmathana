@extends('admin.layouts')

@section('title', 'Khuyến mãi')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.promotions.index') }}">Khuyến mãi</a>
    </li>
    <li class="breadcrumb-item active">Tất cả khuyến mãi</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Danh sách khuyến mãi</h2>
            </div>
        </div>
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item"><a class="nav-link {{ !request('status') && !request('discount_type') ? 'active' : '' }}"
                    aria-current="page" href="{{ route('admin.promotions.index') }}"><span>Tất cả </span><span
                        class="text-body-tertiary fw-semibold">({{ $promotions->count() }})</span></a></li>
            <li class="nav-item"><a class="nav-link {{ request('status') === 'active' ? 'active' : '' }}"
                    href="{{ route('admin.promotions.index', ['status' => 'active']) }}"><span>Đang hoạt động </span><span
                        class="text-body-tertiary fw-semibold">({{ $activeCount }})</span></a>
            </li>
            <li class="nav-item"><a class="nav-link {{ request('status') === 'inactive' ? 'active' : '' }}"
                    href="{{ route('admin.promotions.index', ['status' => 'inactive']) }}"><span>Không hoạt động
                    </span><span class="text-body-tertiary fw-semibold">({{ $inactiveCount }})</span></a>
            </li>
            <li class="nav-item"><a class="nav-link {{ request('discount_type') === 'percentage' ? 'active' : '' }}"
                    href="{{ route('admin.promotions.index', ['discount_type' => 'percentage']) }}"><span>Phần trăm
                    </span><span class="text-body-tertiary fw-semibold">({{ $percentageCount }})</span></a>
            </li>
            <li class="nav-item"><a class="nav-link {{ request('discount_type') === 'fixed' ? 'active' : '' }}"
                    href="{{ route('admin.promotions.index', ['discount_type' => 'fixed']) }}"><span>Số tiền </span><span
                        class="text-body-tertiary fw-semibold">({{ $fixedCount }})</span></a>
            </li>
        </ul>
        <div id="promotions"
            data-list='{"valueNames":["name","code","discount","status","time","usage"],"page":10,"pagination":true}'>
            <div class="mb-4">
                <div class="d-flex flex-wrap gap-3">
                    <div class="search-box">
                        <form class="position-relative" action="{{ route('admin.promotions.index') }}" method="GET">
                            <input class="form-control search-input search" type="search" name="search"
                                placeholder="Tìm kiếm khuyến mãi" value="{{ request('search') }}" aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                    </div>
                    <div class="scrollbar overflow-hidden-y">
                        <div class="btn-group position-static" role="group">
                            <div class="btn-group position-static text-nowrap">
                                <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                    data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                    Trạng thái
                                    <span class="fas fa-angle-down ms-2"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item {{ !request('status') ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index', array_merge(request()->except(['status', 'page']), ['discount_type' => request('discount_type')])) }}">
                                            Tất cả
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request('status') === 'active' ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index', array_merge(request()->except(['status', 'page']), ['status' => 'active', 'discount_type' => request('discount_type')])) }}">
                                            Đang hoạt động
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request('status') === 'inactive' ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index', array_merge(request()->except(['status', 'page']), ['status' => 'inactive', 'discount_type' => request('discount_type')])) }}">
                                            Không hoạt động
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group position-static text-nowrap">
                                <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                    data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                    Loại giảm giá
                                    <span class="fas fa-angle-down ms-2"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item {{ !request('discount_type') ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index', array_merge(request()->except(['discount_type', 'page']), ['status' => request('status')])) }}">
                                            Tất cả
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request('discount_type') === 'percentage' ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index', array_merge(request()->except(['discount_type', 'page']), ['discount_type' => 'percentage', 'status' => request('status')])) }}">
                                            Phần trăm
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request('discount_type') === 'fixed' ? 'active' : '' }}"
                                            href="{{ route('admin.promotions.index', array_merge(request()->except(['discount_type', 'page']), ['discount_type' => 'fixed', 'status' => request('status')])) }}">
                                            Số tiền
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="ms-xxl-auto">
                        <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                            <span class="fas fa-trash me-2"></span>Xóa tất cả
                        </button>
                        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary" id="addBtn">
                            <span class="fas fa-plus me-2"></span>Thêm khuyến mãi
                        </a>
                    </div>
                </div>
            </div>
            <div
                class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                <div class="table-responsive scrollbar mx-n1 px-1">
                    <table class="table fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="align-middle text-center px-3" style="width:10px;">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input" id="checkbox-bulk-promotions-select" type="checkbox"
                                            data-bulk-select='{"body":"promotions-table-body"}' />
                                    </div>
                                </th>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        ID
                                        @if (request('sort') === 'id')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort white-space-nowrap align-middle ps-4" scope="col"
                                    style="width:350px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        TÊN KHUYẾN MÃI
                                        @if (request('sort') === 'name')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'code', 'direction' => request('sort') === 'code' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        MÃ CODE
                                        @if (request('sort') === 'code')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle text-end ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'discount_value', 'direction' => request('sort') === 'discount_value' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        GIẢM GIÁ
                                        @if (request('sort') === 'discount_value')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'is_active', 'direction' => request('sort') === 'is_active' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        TRẠNG THÁI
                                        @if (request('sort') === 'is_active')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle ps-4" scope="col" style="width:200px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'start_date', 'direction' => request('sort') === 'start_date' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        THỜI GIAN
                                        @if (request('sort') === 'start_date')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                    <a href="{{ route('admin.promotions.index', ['sort' => 'used_count', 'direction' => request('sort') === 'used_count' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                        class="text-body" style="text-decoration:none;">
                                        LƯỢT DÙNG
                                        @if (request('sort') === 'used_count')
                                            <i
                                                class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:90px;">Thao
                                    tác</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="promotions-table-body">
                            @forelse($promotions as $promotion)
                                <tr class="position-static">
                                    <td class="align-middle text-center px-3">
                                        <div class="form-check mb-0 fs-8">
                                            <input class="form-check-input promotion-checkbox" type="checkbox"
                                                value="{{ $promotion->id }}" />
                                        </div>
                                    </td>
                                    <td class="id align-middle ps-4">
                                        <span class="text-body-tertiary">{{ $promotion->id }}</span>
                                    </td>
                                    <td class="name align-middle ps-4">
                                        <a class="fw-semibold line-clamp-3 mb-0"
                                            href="{{ route('admin.promotions.show', $promotion) }}">
                                            {{ $promotion->name }}
                                        </a>
                                    </td>
                                    <td class="code align-middle ps-4">
                                        <code>{{ $promotion->code }}</code>
                                    </td>
                                    <td class="discount align-middle text-end fw-bold text-body-tertiary ps-4">
                                        @if ($promotion->discount_type === 'percentage')
                                            {{ $promotion->discount_value }}%
                                        @else
                                            {{ number_format($promotion->discount_value, 2) }}
                                        @endif
                                    </td>
                                    <td class="status align-middle ps-4">
                                        @if ($promotion->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td
                                        class="time align-middle white-space-nowrap text-body-tertiary text-opacity-85 ps-4">
                                        {{ $promotion->start_date->format('d/m/Y') }} -
                                        {{ $promotion->end_date->format('d/m/Y') }}
                                    </td>
                                    <td class="usage align-middle ps-4">
                                        {{ $promotion->used_count }}
                                        @if ($promotion->usage_limit)
                                            / {{ $promotion->usage_limit }}
                                        @endif
                                    </td>
                                    <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                        <div class="btn-reveal-trigger position-static">
                                            <button
                                                class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <span class="fas fa-ellipsis-h fs-10"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.promotions.show', $promotion) }}">Xem</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.promotions.edit', $promotion) }}">Sửa</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.promotions.destroy', $promotion) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này?')">
                                                        Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">Không có khuyến mãi nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="bulk-delete-form" action="{{ route('admin.promotions.bulkDestroy') }}" method="POST"
        style="display:none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-delete-ids">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bulkCheckbox = document.getElementById('checkbox-bulk-promotions-select');
            const itemCheckboxes = document.querySelectorAll('.promotion-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            const bulkDeleteIds = document.getElementById('bulk-delete-ids');

            function updateBulkDeleteBtn() {
                let checkedCount = 0;
                itemCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) checkedCount++;
                });
                if (checkedCount > 0) {
                    bulkDeleteBtn.style.display = '';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            if (bulkCheckbox) {
                bulkCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = bulkCheckbox.checked;
                    });
                    updateBulkDeleteBtn();
                });
            }
            itemCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateBulkDeleteBtn();
                });
            });
            updateBulkDeleteBtn(); // Initial state

            // Xử lý submit xoá
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checkedIds = Array.from(itemCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                if (checkedIds.length === 0) return;
                if (!confirm('Bạn có chắc chắn muốn xóa các khuyến mãi đã chọn?')) return;
                bulkDeleteIds.value = checkedIds.join(',');
                bulkDeleteForm.submit();
            });
        });
    </script>
@endsection
