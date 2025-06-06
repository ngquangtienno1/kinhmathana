@extends('admin.layouts')
@section('title', 'Quản lý yêu cầu hỗ trợ')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Yêu cầu hỗ trợ</a></li>
    <li class="breadcrumb-item active">Quản lý yêu cầu hỗ trợ</li>
@endsection

<div class="mb-4">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý yêu cầu hỗ trợ</h2>
        </div>
    </div>
</div>

<ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
    <li class="nav-item">
        <a class="nav-link {{ request('status') === null ? 'active' : '' }}" href="{{ route('admin.tickets.index') }}">
            Tất cả <span class="text-body-tertiary fw-semibold">({{ $totalCount }})</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'mới' ? 'active' : '' }}"
            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'mới'])) }}">
            Mới <span class="text-body-tertiary fw-semibold">({{ $openCount }})</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'đang xử lý' ? 'active' : '' }}"
            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'đang xử lý'])) }}">
            Đang xử lý <span class="text-body-tertiary fw-semibold">({{ $dangxulyCount }})</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'chờ khách' ? 'active' : '' }}"
            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'chờ khách'])) }}">
            Chờ khách <span class="text-body-tertiary fw-semibold">({{ $pendingCount }})</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'đã đóng' ? 'active' : '' }}"
            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'đã đóng'])) }}">
            Đã đóng <span class="text-body-tertiary fw-semibold">({{ $closedCount }})</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'trashed' ? 'active' : '' }}"
            href="{{ route('admin.tickets.trashed') }}">
            Thùng rác <span class="text-body-tertiary fw-semibold">({{ $trashedCount }})</span>
        </a>
    </li>
</ul>

<div id="tickets"
    data-list='{"valueNames":["id","name","priority","status","assigned_to","created_at"],"page":10,"pagination":true}'>
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form class="position-relative" action="{{ route('admin.tickets.index') }}" method="GET">
                    <input class="form-control search-input search" type="search" name="search"
                        placeholder="Tìm kiếm ticket" value="{{ request('search') }}" />
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
                                <input class="form-check-input" id="checkbox-bulk-tickets-select" type="checkbox"
                                    data-bulk-select='{"body":"tickets-table-body"}' />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                            <a href="{{ route('admin.tickets.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                class="text-body" style="text-decoration:none;">
                                ID
                                @if (request('sort') === 'id')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="name">Người gửi
                        </th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="priority">Ưu
                            tiên</th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="status">Trạng
                            thái</th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="assigned_to">
                            Người xử lý</th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="created_at">
                            <a href="{{ route('admin.tickets.index', ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                class="text-body" style="text-decoration:none;">
                                Ngày tạo
                                @if (request('sort') === 'created_at')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="list" id="tickets-table-body">
                    @forelse($tickets as $ticket)
                        <tr class="position-static">
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input ticket-checkbox" type="checkbox"
                                        value="{{ $ticket->id }}" />
                                </div>
                            </td>
                            <td class="id align-middle ps-4">
                                <span class="text-body-tertiary">{{ $ticket->id }}</span>
                            </td>
                            <td class="name align-middle ps-4">
                                <a class="fw-semibold line-clamp-3 mb-0"
                                    href="{{ route('admin.tickets.show', $ticket->id) }}">{{ $ticket->user->name ?? 'N/A' }}</a>
                            </td>
                            <td class="priority align-middle ps-4">
                                <span
                                    class="badge badge-phoenix fs-10 badge-phoenix-{{ $ticket->priority === 'cao' ? 'danger' : ($ticket->priority === 'trung bình' ? 'warning' : 'info') }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="status align-middle ps-4">
                                @php
                                    $status = $ticket->status;
                                    switch ($status) {
                                        case 'mới':
                                            $badge = 'info';
                                            break;
                                        case 'đang xử lý':
                                            $badge = 'warning';
                                            break;
                                        case 'chờ khách':
                                            $badge = 'secondary';
                                            break;
                                        case 'đã đóng':
                                            $badge = 'success';
                                            break;
                                        default:
                                            $badge = 'light';
                                    }
                                @endphp
                                <span
                                    class="badge badge-phoenix fs-10 badge-phoenix-{{ $badge }}">{{ ucfirst($status) }}</span>
                            </td>
                            <td class="assigned_to align-middle ps-4">
                                <span
                                    class="text-body-tertiary">{{ $ticket->assignedUser->name ?? 'Chưa gán' }}</span>
                            </td>
                            <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
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
                                            href="{{ route('admin.tickets.show', $ticket->id) }}">Xem</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.tickets.edit', $ticket->id) }}">Sửa</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa ticket này?')">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Không có yêu cầu hỗ trợ nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    Tổng: {{ $tickets->count() }} ticket
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

<form id="bulk-delete-form" action="{{ route('admin.tickets.bulkDestroy') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-tickets-select');
        const itemCheckboxes = document.querySelectorAll('.ticket-checkbox');
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
            if (!confirm('Bạn có chắc chắn muốn xóa mềm các ticket đã chọn?')) return;
            bulkDeleteIds.value = checkedIds.join(',');
            bulkDeleteForm.submit();
        });
    });
</script>
@endsection
