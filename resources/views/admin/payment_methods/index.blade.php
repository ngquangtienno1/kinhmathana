@extends('admin.layouts')

@section('title', 'Phương thức thanh toán')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.payment_methods.index') }}">Phương thức thanh toán</a>
    </li>
    <li class="breadcrumb-item active">Danh sách phương thức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Phương thức thanh toán</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.payment_methods.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $paymentMethods->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.payment_methods.index', ['status' => 'active']) }}"><span>Đang hoạt động
                </span><span class="text-body-tertiary fw-semibold">({{ $activeCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.payment_methods.bin') }}"><span>Thùng rác
                </span><span class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span></a></li>
    </ul>
    <div id="payment-methods"
        data-list='{"valueNames":["name","description","status","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.payment_methods.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm phương thức" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa mềm
                    </button>
                    <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm phương thức
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
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-payment-methods-select"
                                        type="checkbox" data-bulk-select='{"body":"payment-methods-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">ID
                            </th>
                            <th class="sort white-space-nowrap align-middle fs-9" scope="col" style="width:70px;">
                                BIỂU TƯỢNG</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:250px;"
                                data-sort="name">TÊN PHƯƠNG THỨC</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="code" style="width:100px;">
                                MÃ</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="description"
                                style="width:200px;">MÔ TẢ</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="status" style="width:120px;">
                                TRẠNG THÁI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="created_at"
                                style="width:150px;">NGÀY TẠO</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="payment-methods-table-body">
                        @forelse ($paymentMethods as $method)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input payment-method-checkbox" type="checkbox"
                                            value="{{ $method->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $method->id }}</span>
                                </td>
                                <td class="align-middle white-space-nowrap py-0">
                                    @if ($method->logo)
                                        <a class="d-block border border-translucent rounded-2" href="#"
                                            style="width:53px; height:53px; overflow:hidden;">
                                            <img src="{{ asset('storage/' . $method->logo) }}" alt=""
                                                style="width:100%; height:100%; object-fit:contain; display:block;" />
                                        </a>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td class="name align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0"
                                        href="{{ route('admin.payment_methods.show', $method->id) }}">{{ $method->name }}</a>
                                </td>
                                <td class="code align-middle ps-4">
                                    <span
                                        class="badge bg-primary-subtle text-primary fw-semibold fs-9">{{ $method->code }}</span>
                                </td>
                                <td class="description align-middle ps-4">
                                    <span class="text-body-tertiary">{{ Str::limit($method->description, 50) }}</span>
                                </td>
                                <td class="status align-middle ps-4">
                                    <span
                                        class="badge badge-phoenix fs-10 {{ $method->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                        {{ $method->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $method->created_at->format('d/m/Y H:i') }}
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
                                                href="{{ route('admin.payment_methods.show', $method->id) }}">Xem</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.payment_methods.edit', $method->id) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.payment_methods.destroy', $method->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa phương thức này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có phương thức nào</td>
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
                    <button class="page-link pe-0" data-list-pagination="next"><span
                            class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('admin.payment_methods.bulkDestroy') }}" method="POST"
    style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-payment-methods-select');
        const itemCheckboxes = document.querySelectorAll('.payment-method-checkbox');
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

        // Xử lý submit xoá mềm
        bulkDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn xóa mềm các phương thức đã chọn?')) return;
            bulkDeleteIds.value = checkedIds.join(',');
            bulkDeleteForm.submit();
        });
    });
</script>

@endsection
