@extends('admin.layouts')

@section('title', 'Thùng rác liên hệ')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.contacts.index') }}">Liên hệ</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác liên hệ</h2>
        </div>
        <div class="col-auto ms-auto d-flex gap-2">
            <button id="bulk-restore-btn" class="btn btn-success" style="display:none;">Khôi phục</button>
            <button id="bulk-force-delete-btn" class="btn btn-danger" style="display:none;">Xóa vĩnh viễn</button>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>
    <form id="bulk-restore-form" action="{{ route('admin.contacts.bulkRestore') }}" method="POST"
        style="display:none;">
        @csrf
        <input type="hidden" name="ids" id="bulk-restore-ids">
    </form>
    <form id="bulk-force-delete-form" action="{{ route('admin.contacts.bulkForceDelete') }}" method="POST"
        style="display:none;">
        @csrf
        <input type="hidden" name="ids" id="bulk-force-delete-ids">
    </form>

    <div id="contacts"
        data-list='{"valueNames":["id","name","email","phone","deleted_at"],"page":10,"pagination":true}'>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive scrollbar">
                    <table class="table fs-9 mb-0">
                        <thead>
                            <tr>
                                <th class="align-middle text-center" style="width:40px;">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input" id="checkbox-bulk-contacts-select"
                                            type="checkbox" data-bulk-select='{"body":"contacts-table-body"}' />
                                    </div>
                                </th>
                                <th class="sort align-middle text-center" style="width:80px;" data-sort="id">ID</th>
                                <th class="sort align-middle text-center" style="width:200px;" data-sort="name">HỌ TÊN
                                </th>
                                <th class="sort align-middle text-center" style="width:200px;" data-sort="email">EMAIL
                                </th>
                                <th class="sort align-middle text-center" style="width:150px;" data-sort="phone">SỐ ĐIỆN
                                    THOẠI</th>
                                <th class="sort align-middle text-center" style="width:150px;" data-sort="deleted_at">
                                    NGÀY XÓA</th>
                                <th class="align-middle text-center" style="width:120px;"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="contacts-table-body">
                            @forelse($contacts as $contact)
                                <tr class="position-static">
                                    <td class="fs-9 align-middle">
                                        <div class="form-check mb-0 fs-8">
                                            <input class="form-check-input contact-checkbox" type="checkbox"
                                                value="{{ $contact->id }}" />
                                        </div>
                                    </td>
                                    <td class="id align-middle text-center">
                                        <span class="text-body-tertiary">{{ $contact->id }}</span>
                                    </td>
                                    <td class="name align-middle text-center">
                                        <a class="fw-semibold line-clamp-3 mb-0" href="#">{{ $contact->name }}</a>
                                    </td>
                                    <td class="email align-middle text-center">
                                        <span class="text-body-tertiary">{{ $contact->email }}</span>
                                    </td>
                                    <td class="phone align-middle text-center">
                                        <span class="text-body-tertiary">{{ $contact->phone ?? 'N/A' }}</span>
                                    </td>
                                    <td class="deleted_at align-middle text-center text-body-tertiary">
                                        {{ $contact->deleted_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="align-middle text-center btn-reveal-trigger">
                                        <div class="btn-reveal-trigger position-static">
                                            <button
                                                class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <span class="fas fa-ellipsis-h fs-10"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                <form action="{{ route('admin.contacts.restore', $contact->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item">Khôi phục</button>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.contacts.forceDelete', $contact->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn liên hệ này?')">Xóa
                                                        vĩnh viễn</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Không có liên hệ nào trong thùng rác
                                    </td>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-contacts-select');
        const itemCheckboxes = document.querySelectorAll('.contact-checkbox');
        const bulkRestoreBtn = document.getElementById('bulk-restore-btn');
        const bulkForceDeleteBtn = document.getElementById('bulk-force-delete-btn');
        const bulkRestoreForm = document.getElementById('bulk-restore-form');
        const bulkForceDeleteForm = document.getElementById('bulk-force-delete-form');
        const bulkRestoreIds = document.getElementById('bulk-restore-ids');
        const bulkForceDeleteIds = document.getElementById('bulk-force-delete-ids');

        function updateBulkActionBtns() {
            let checkedCount = 0;
            itemCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) checkedCount++;
            });
            if (checkedCount > 0) {
                bulkRestoreBtn.style.display = '';
                bulkForceDeleteBtn.style.display = '';
            } else {
                bulkRestoreBtn.style.display = 'none';
                bulkForceDeleteBtn.style.display = 'none';
            }
        }

        if (bulkCheckbox) {
            bulkCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(function(checkbox) {
                    if (checkbox) checkbox.checked = bulkCheckbox.checked;
                });
                updateBulkActionBtns();
            });
        }

        itemCheckboxes.forEach(function(checkbox) {
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    updateBulkActionBtns();
                });
            }
        });

        updateBulkActionBtns(); // Initial state

        // Xử lý submit khôi phục
        bulkRestoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb && cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn khôi phục các liên hệ đã chọn?')) return;
            bulkRestoreIds.value = checkedIds.join(',');
            bulkRestoreForm.submit();
        });

        // Xử lý submit xóa vĩnh viễn
        bulkForceDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb && cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn xóa vĩnh viễn các liên hệ đã chọn?')) return;
            bulkForceDeleteIds.value = checkedIds.join(',');
            bulkForceDeleteForm.submit();
        });
    });
</script>

@endsection
