@extends('admin.layouts')
@section('title', 'Thùng rác Tin tức')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.news.index') }}">Tin tức</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác Tin tức</h2>
        </div>
        <div class="col-auto ms-auto d-flex gap-2">
            <button id="bulk-restore-btn" class="btn btn-success" style="display:none;">Khôi phục</button>
            <button id="bulk-force-delete-btn" class="btn btn-danger" style="display:none;">Xóa vĩnh viễn</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>
    <form id="bulk-restore-form" action="{{ route('admin.news.bulkRestore') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="ids" id="bulk-restore-ids">
    </form>
    <form id="bulk-force-delete-form" action="{{ route('admin.news.bulkForceDelete') }}" method="POST"
        style="display:none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-force-delete-ids">
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="align-middle text-center" style="width:40px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-news-select" type="checkbox" />
                                </div>
                            </th>
                            <th class="align-middle text-center" style="width:70px;">ẢNH</th>
                            <th class="sort" data-sort="title">Tiêu đề</th>
                            <th class="sort" data-sort="category">Danh mục</th>
                            <th class="sort" data-sort="author">Tác giả</th>
                            <th class="sort" data-sort="published_at">Ngày xuất bản</th>
                            <th class="sort" data-sort="status">Trạng thái</th>
                            <th class="sort" data-sort="deleted_at">Ngày xóa</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($news as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input news-checkbox" type="checkbox"
                                            value="{{ $item->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    @if ($item->image)
                                        <a class="d-block" href="#">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt=""
                                                width="48" style="object-fit:cover;"
                                                class="border border-translucent rounded-2">
                                        </a>
                                    @endif
                                </td>
                                <td class="title">{{ $item->title }}</td>
                                <td class="category">{{ $item->category ? $item->category->name : 'N/A' }}</td>
                                <td class="author">{{ $item->author ? $item->author->name : 'N/A' }}</td>
                                <td class="published_at">
                                    {{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : 'Chưa xuất bản' }}
                                </td>
                                <td class="status">
                                    <span
                                        class="badge badge-phoenix fs-10 {{ $item->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                        {{ $item->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="deleted_at">
                                    {{ $item->deleted_at ? $item->deleted_at->format('d/m/Y H:i') : '' }}</td>
                                <td class="align-middle text-center btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.news.restore', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.news.forceDelete', $item->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tin tức này?')">Xóa
                                                    vĩnh viễn</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Không có tin tức nào trong thùng rác</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-news-select');
        const itemCheckboxes = document.querySelectorAll('.news-checkbox');
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
                    checkbox.checked = bulkCheckbox.checked;
                });
                updateBulkActionBtns();
            });
        }
        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateBulkActionBtns();
            });
        });
        updateBulkActionBtns(); // Initial state

        // Xử lý submit khôi phục
        bulkRestoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn khôi phục các tin tức đã chọn?')) return;
            bulkRestoreIds.value = checkedIds.join(',');
            bulkRestoreForm.submit();
        });
        // Xử lý submit xóa vĩnh viễn
        bulkForceDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn xóa vĩnh viễn các tin tức đã chọn?')) return;
            bulkForceDeleteIds.value = checkedIds.join(',');
            bulkForceDeleteForm.submit();
        });
    });
</script>

@endsection
