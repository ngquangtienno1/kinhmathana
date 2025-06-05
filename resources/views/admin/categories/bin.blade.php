@extends('admin.layouts')
@section('title', 'Thùng rác danh mục')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Categories</a></li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác danh mục</h2>
        </div>
    </div>

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $categories->count() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.categories.bin') }}">
                Thùng rác <span class="text-body-tertiary fw-semibold">({{ $categories->count() }})</span>
            </a>
        </li>
    </ul>

    <div id="categories" data-list='{"valueNames":["name","description"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.categories.bin') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm danh mục" value="{{ request('search') }}" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <button id="bulk-restore-btn" class="btn btn-success me-2" style="display: none;">
                        <span class="fas fa-undo me-2"></span>Khôi phục
                    </button>
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa vĩnh viễn
                    </button>
                </div>
            </div>
        </div>

        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-categories-select" type="checkbox"
                                        data-bulk-select='{"body":"categories-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.categories.bin', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:250px;" data-sort="name">
                                TÊN DANH MỤC
                            </th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="description" style="width:200px;">
                                MÔ TẢ
                            </th>
                            <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                DANH MỤC CHA
                            </th>
                            <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                NGÀY XÓA
                            </th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="categories-table-body">
                        @forelse ($categories as $category)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input category-checkbox" type="checkbox"
                                            value="{{ $category->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $category->id }}</span>
                                </td>
                                <td class="name align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0"
                                        href="#">{{ $category->name }}</a>
                                </td>
                                <td class="description align-middle ps-4">
                                    <span class="text-body-tertiary">{{ Str::limit($category->description, 50) }}</span>
                                </td>
                                <td class="align-middle ps-4">
                                    <span class="text-body-tertiary">{{ optional($category->parent)->name ?? '-' }}</span>
                                </td>
                                <td class="align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $category->deleted_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                            aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.categories.restore', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.categories.forceDelete', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn danh mục này?')">Xóa vĩnh viễn</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Không có danh mục nào trong thùng rác</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        Tổng: {{ $categories->count() }} danh mục
                    </p>
                    <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="mb-0 pagination">
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                    </ul>
                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="bulk-restore-form" action="{{ route('admin.categories.bulkRestore') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-restore-ids">
</form>

<form id="bulk-delete-form" action="{{ route('admin.categories.bulkForceDelete') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-categories-select');
        const itemCheckboxes = document.querySelectorAll('.category-checkbox');
        const bulkRestoreBtn = document.getElementById('bulk-restore-btn');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const bulkRestoreForm = document.getElementById('bulk-restore-form');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const bulkRestoreIds = document.getElementById('bulk-restore-ids');
        const bulkDeleteIds = document.getElementById('bulk-delete-ids');

        function updateBulkButtons() {
            let checkedCount = 0;
            itemCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) checkedCount++;
            });
            if (checkedCount > 0) {
                bulkRestoreBtn.style.display = '';
                bulkDeleteBtn.style.display = '';
            } else {
                bulkRestoreBtn.style.display = 'none';
                bulkDeleteBtn.style.display = 'none';
            }
        }

        if (bulkCheckbox) {
            bulkCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = bulkCheckbox.checked;
                });
                updateBulkButtons();
            });
        }

        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateBulkButtons();
            });
        });

        updateBulkButtons(); // Initial state

        // Xử lý submit khôi phục
        bulkRestoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn khôi phục các danh mục đã chọn?')) return;
            bulkRestoreIds.value = checkedIds.join(',');
            bulkRestoreForm.submit();
        });

        // Xử lý submit xóa vĩnh viễn
        bulkDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn xóa vĩnh viễn các danh mục đã chọn?')) return;
            bulkDeleteIds.value = checkedIds.join(',');
            bulkDeleteForm.submit();
        });
    });
</script>

@endsection
