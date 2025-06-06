@extends('admin.layouts')

@section('title', 'Liên hệ')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.contacts.index') }}">Liên hệ</a>
    </li>
    <li class="breadcrumb-item active">Danh sách liên hệ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0"> Danh sách liên hệ</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.contacts.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $contacts->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.contacts.index', ['status' => 'mới']) }}"><span>Mới </span><span
                    class="text-body-tertiary fw-semibold">({{ $newCount }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.contacts.index', ['status' => 'đã đọc']) }}"><span>Đã đọc </span><span
                    class="text-body-tertiary fw-semibold">({{ $readCount }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.contacts.index', ['status' => 'đã trả lời']) }}"><span>Đã trả lời </span><span
                    class="text-body-tertiary fw-semibold">({{ $repliedCount }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.contacts.index', ['status' => 'đã bỏ qua']) }}"><span>Đã bỏ qua </span><span
                    class="text-body-tertiary fw-semibold">({{ $ignoredCount }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.contacts.bin') }}"><span>Thùng rác </span><span
                    class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span></a>
        </li>
    </ul>
    <div id="contacts"
        data-list='{"valueNames":["name","email","phone","status","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.contacts.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm liên hệ" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa mềm
                    </button>
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
                                    <input class="form-check-input" id="checkbox-bulk-contacts-select" type="checkbox"
                                        data-bulk-select='{"body":"contacts-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.contacts.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:200px;"
                                data-sort="name">HỌ TÊN</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:200px;"
                                data-sort="email">EMAIL</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;"
                                data-sort="phone">SỐ ĐIỆN THOẠI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="status" style="width:120px;">
                                TRẠNG THÁI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="created_at"
                                style="width:150px;">NGÀY TẠO</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="contacts-table-body">
                        @forelse ($contacts as $contact)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input contact-checkbox" type="checkbox"
                                            value="{{ $contact->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $contact->id }}</span>
                                </td>
                                <td class="name align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0"
                                        href="{{ route('admin.contacts.show', $contact->id) }}">{{ $contact->name }}</a>
                                </td>
                                <td class="email align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $contact->email }}</span>
                                </td>
                                <td class="phone align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $contact->phone ?? 'N/A' }}</span>
                                </td>
                                <td class="status align-middle ps-4">
                                    <span
                                        class="badge badge-phoenix fs-10
                                        @switch($contact->status)
                                            @case('mới')
                                                badge-phoenix-info
                                                @break
                                            @case('đã đọc')
                                                badge-phoenix-warning
                                                @break
                                            @case('đã trả lời')
                                                badge-phoenix-success
                                                @break
                                            @case('đã bỏ qua')
                                                badge-phoenix-danger
                                                @break
                                        @endswitch">
                                        {{ $contact->status }}
                                    </span>
                                </td>
                                <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $contact->created_at->format('d/m/Y H:i') }}
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
                                                href="{{ route('admin.contacts.show', $contact->id) }}">Xem</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Không có liên hệ nào</td>
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

<form id="bulk-delete-form" action="{{ route('admin.contacts.bulkDestroy') }}" method="POST"
    style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-contacts-select');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const bulkDeleteIds = document.getElementById('bulk-delete-ids');

        function getItemCheckboxes() {
            return document.querySelectorAll('.contact-checkbox');
        }

        function updateBulkDeleteBtn() {
            const itemCheckboxes = getItemCheckboxes();
            let checkedCount = 0;
            itemCheckboxes.forEach(function(checkbox) {
                if (checkbox && checkbox.checked) checkedCount++;
            });
            if (checkedCount > 0) {
                bulkDeleteBtn.style.display = '';
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        if (bulkCheckbox) {
            bulkCheckbox.addEventListener('change', function() {
                const itemCheckboxes = getItemCheckboxes();
                itemCheckboxes.forEach(function(checkbox) {
                    if (checkbox) checkbox.checked = bulkCheckbox.checked;
                });
                updateBulkDeleteBtn();
            });
        }
        // Lắng nghe thay đổi trên từng checkbox con
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('contact-checkbox')) {
                updateBulkDeleteBtn();
            }
        });
        updateBulkDeleteBtn(); // Initial state

        // Xử lý submit xoá mềm
        bulkDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemCheckboxes = getItemCheckboxes();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb && cb.checked)
                .map(cb => cb.value);
            console.log('IDs gửi lên:', checkedIds); // DEBUG
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn xóa mềm các liên hệ đã chọn?')) return;
            bulkDeleteIds.value = checkedIds.join(',');
            bulkDeleteForm.submit();
        });
    });
</script>

@endsection
