@extends('admin.layouts')
@section('title', 'Quản lý FAQ')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">FAQ</a></li>
    <li class="breadcrumb-item active">Quản lý FAQ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý FAQ</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link {{ !request('status') ? 'active' : '' }}" aria-current="page"
                href="{{ route('admin.faqs.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $faqs->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link {{ request('status') == '1' ? 'active' : '' }}"
                href="{{ route('admin.faqs.index', ['status' => '1']) }}"><span>Đang hoạt động </span><span
                    class="text-body-tertiary fw-semibold">({{ $activeCount }})</span></a>
        </li>
    </ul>
    <div id="faqs" data-list='{"valueNames":["question","category","status"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.faqs.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm FAQ" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="scrollbar overflow-hidden-y">
                    <div class="btn-group position-static" role="group">
                        <div class="btn-group position-static text-nowrap">
                            <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent">
                                Danh mục
                                <span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item {{ !request('category') ? 'active' : '' }}"
                                        href="{{ route('admin.faqs.index', array_merge(request()->except(['category', 'page']), ['search' => request('search')])) }}">
                                        Tất cả
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request('category') == 'Chung' ? 'active' : '' }}"
                                        href="{{ route('admin.faqs.index', array_merge(request()->except(['category', 'page']), ['category' => 'Chung', 'search' => request('search')])) }}">
                                        Chung
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request('category') == 'Sản phẩm' ? 'active' : '' }}"
                                        href="{{ route('admin.faqs.index', array_merge(request()->except(['category', 'page']), ['category' => 'Sản phẩm', 'search' => request('search')])) }}">
                                        Sản phẩm
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request('category') == 'Vận chuyển' ? 'active' : '' }}"
                                        href="{{ route('admin.faqs.index', array_merge(request()->except(['category', 'page']), ['category' => 'Vận chuyển', 'search' => request('search')])) }}">
                                        Vận chuyển
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request('category') == 'Thanh toán' ? 'active' : '' }}"
                                        href="{{ route('admin.faqs.index', array_merge(request()->except(['category', 'page']), ['category' => 'Thanh toán', 'search' => request('search')])) }}">
                                        Thanh toán
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request('category') == 'Bảo hành' ? 'active' : '' }}"
                                        href="{{ route('admin.faqs.index', array_merge(request()->except(['category', 'page']), ['category' => 'Bảo hành', 'search' => request('search')])) }}">
                                        Bảo hành
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
                    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm FAQ
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
                                    <input class="form-check-input" id="checkbox-bulk-faqs-select" type="checkbox"
                                        data-bulk-select='{"body":"faqs-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.faqs.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:90px;">Ảnh
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col"
                                style="min-width:300px;">
                                <a href="{{ route('admin.faqs.index', ['sort' => 'question', 'direction' => request('sort') === 'question' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Câu hỏi
                                    @if (request('sort') === 'question')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;">
                                <a href="{{ route('admin.faqs.index', ['sort' => 'category', 'direction' => request('sort') === 'category' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Danh mục
                                    @if (request('sort') === 'category')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>

                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:100px;">
                                <a href="{{ route('admin.faqs.index', ['sort' => 'sort_order', 'direction' => request('sort') === 'sort_order' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Thứ tự
                                    @if (request('sort') === 'sort_order')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col"
                                style="width:100px;">
                                <a href="{{ route('admin.faqs.index', ['sort' => 'is_active', 'direction' => request('sort') === 'is_active' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Trạng thái
                                    @if (request('sort') === 'is_active')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:90px;">Thao
                                tác</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="faqs-table-body">
                        @forelse($faqs as $faq)
                            <tr>
                                <td class="align-middle text-center px-3">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input faq-checkbox" type="checkbox"
                                            value="{{ $faq->id }}">
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $faq->id }}</span>
                                </td>
                                <td class="align-middle ps-4">
                                    @if ($faq->images)
                                        @php
                                            $images = json_decode($faq->images, true);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if ($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="FAQ Image"
                                                class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light" style="width: 50px; height: 50px;"></div>
                                        @endif
                                    @else
                                        <div class="rounded bg-light" style="width: 50px; height: 50px;"></div>
                                    @endif
                                </td>
                                <td class="question align-middle ps-4">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ Str::limit($faq->question, 50) }}</span>
                                        <small
                                            class="text-muted">{{ Str::limit(strip_tags($faq->answer), 100) }}</small>
                                    </div>
                                </td>
                                <td class="category align-middle ps-4">{{ $faq->category }}</td>

                                <td class="sort_order align-middle ps-4">{{ $faq->sort_order }}</td>
                                <td class="status align-middle ps-4">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input status-switch" type="checkbox" role="switch"
                                            data-id="{{ $faq->id }}" {{ $faq->is_active ? 'checked' : '' }}>
                                    </div>
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
                                                href="{{ route('admin.faqs.show', $faq->id) }}">Xem</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.faqs.edit', $faq->id) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa FAQ này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
    <form id="bulk-delete-form" action="{{ route('admin.faqs.bulkDestroy') }}" method="POST"
        style="display:none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-delete-ids">
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bulkCheckbox = document.getElementById('checkbox-bulk-faqs-select');
            const itemCheckboxes = document.querySelectorAll('.faq-checkbox');
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
                if (!confirm('Bạn có chắc chắn muốn xóa các FAQ đã chọn?')) return;
                bulkDeleteIds.value = checkedIds.join(',');
                bulkDeleteForm.submit();
            });

            // Xử lý switch status
            document.querySelectorAll('.status-switch').forEach(
                switch => {
                    switch.addEventListener('change', function() {
                        const id = this.dataset.id;
                        const isActive = this.checked;

                        fetch(`/admin/faqs/${id}/status`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    is_active: isActive
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    this.checked = !isActive;
                                    alert('Có lỗi xảy ra khi cập nhật trạng thái');
                                }
                            })
                            .catch(error => {
                                this.checked = !isActive;
                                alert('Có lỗi xảy ra khi cập nhật trạng thái');
                            });
                    });
                });
        });
    </script>
</div>

@endsection
