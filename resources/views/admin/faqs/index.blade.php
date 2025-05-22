@extends('admin.layouts')
@section('title', 'Quản lý FAQ')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.faqs.index') }}">FAQ</a>
    </li>
    <li class="breadcrumb-item active">Danh sách FAQ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý FAQ</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.faqs.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $faqs->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.faqs.index', ['status' => 'active']) }}"><span>Đang hoạt động </span><span
                    class="text-body-tertiary fw-semibold">({{ $activeCount }})</span></a>
        </li>
        {{-- <li class="nav-item"><a class="nav-link" href="{{ route('admin.faqs.bin') }}"><span>Thùng rác </span><span
                    class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span></a>
        </li> --}}
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
                <div class="dropdown">
                    <button class="btn btn-phoenix-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Danh mục: {{ request('category') ? request('category') : 'Tất cả' }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ !request('category') ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => null])) }}">Tất
                                cả</a></li>
                        <li><a class="dropdown-item {{ request('category') == 'Chung' ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Chung'])) }}">Chung</a>
                        </li>
                        <li><a class="dropdown-item {{ request('category') == 'Sản phẩm' ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Sản phẩm'])) }}">Sản
                                phẩm</a></li>
                        <li><a class="dropdown-item {{ request('category') == 'Vận chuyển' ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Vận chuyển'])) }}">Vận
                                chuyển</a></li>
                        <li><a class="dropdown-item {{ request('category') == 'Thanh toán' ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Thanh toán'])) }}">Thanh
                                toán</a></li>
                        <li><a class="dropdown-item {{ request('category') == 'Bảo hành' ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Bảo hành'])) }}">Bảo
                                hành</a></li>
                    </ul>
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

        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle text-center px-3" style="width:44px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-faqs-select" type="checkbox"
                                        data-bulk-select='{"body":"faqs-table-body"}' />
                                </div>
                            </th>
                            <th class="sort align-middle text-center px-3" scope="col" style="width:70px;">ID</th>
                            <th class="sort align-middle text-center px-3" scope="col" style="width:90px;">ẢNH</th>
                            <th class="sort align-middle text-start px-4" scope="col" style="min-width:300px;">Câu
                                hỏi</th>
                            <th class="sort align-middle text-center px-3" scope="col" style="width:150px;">Danh mục
                            </th>
                            <th class="sort align-middle text-center px-3" scope="col" style="width:130px;">Trạng
                                thái</th>
                            <th class="align-middle text-center px-3" scope="col" style="width:110px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="faqs-table-body">
                        @forelse($faqs as $faq)
                            <tr class="position-static">
                                <td class="align-middle text-center px-3">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input faq-checkbox" type="checkbox"
                                            value="{{ $faq->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle text-center px-3">{{ $faq->id }}</td>
                                <td class="align-middle text-center px-3">
                                    @if ($faq->image)
                                        <a class="d-block border border-translucent rounded-2" href="#">
                                            <img src="{{ asset($faq->image) }}" alt="{{ $faq->question }}"
                                                class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        </a>
                                    @else
                                        <div class="rounded bg-light" style="width: 50px; height: 50px;"></div>
                                    @endif
                                </td>
                                <td class="question align-middle text-start px-4">{{ $faq->question }}</td>
                                <td class="category align-middle text-center px-3">{{ $faq->category }}</td>
                                <td class="status align-middle text-center px-3">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            {{ $faq->is_active ? 'checked' : '' }}
                                            onchange="updateStatus({{ $faq->id }}, this.checked)">
                                    </div>
                                </td>
                                <td
                                    class="align-middle text-center px-3 white-space-nowrap pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
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
                                <td colspan="7" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                    <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
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
</div>

<form id="bulk-delete-form" action="{{ route('admin.faqs.bulkDestroy') }}" method="POST" style="display:none;">
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
    });
</script>
@endsection
