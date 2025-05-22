@extends('admin.layouts')
@section('title', 'Thùng rác Slider')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.sliders.index') }}">Slider</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác Slider</h2>
        </div>
        <div class="col-auto ms-auto d-flex gap-2">
            <button id="bulk-restore-btn" class="btn btn-success" style="display:none;">Khôi phục</button>
            <button id="bulk-force-delete-btn" class="btn btn-danger" style="display:none;">Xóa vĩnh viễn</button>
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>
    <form id="bulk-restore-form" action="{{ route('admin.sliders.bulkRestore') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="ids" id="bulk-restore-ids">
    </form>
    <form id="bulk-force-delete-form" action="{{ route('admin.sliders.bulkForceDelete') }}" method="POST"
        style="display:none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-force-delete-ids">
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle text-center" style="width:40px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-sliders-select" type="checkbox" />
                                </div>
                            </th>
                            <th class="align-middle text-center" style="width:70px;">ẢNH</th>
                            <th class="align-middle text-center" style="width:220px;">TIÊU ĐỀ</th>
                            <th class="align-middle text-center" style="width:250px;">MÔ TẢ</th>
                            <th class="align-middle text-center" style="width:150px;">NGÀY XÓA</th>
                            <th class="align-middle text-center" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sliders as $slider)
                            <tr>
                                <td class="align-middle text-center">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input slider-checkbox" type="checkbox"
                                            value="{{ $slider->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="d-block border border-translucent rounded-2" href="#">
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt=""
                                            width="48" style="object-fit:cover; border-radius:4px;">
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="fw-semibold line-clamp-3 mb-0" href="#">{{ $slider->title }}</a>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-body-tertiary">{{ Str::limit($slider->description, 80) }}</span>
                                </td>
                                <td class="align-middle text-center text-body-tertiary">
                                    {{ $slider->deleted_at->format('d/m/Y H:i') }}
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
                                            <form action="{{ route('admin.sliders.restore', $slider->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.sliders.forceDelete', $slider->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn slider này?')">Xóa
                                                    vĩnh viễn</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Không có slider nào trong thùng rác</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $sliders->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-sliders-select');
        const itemCheckboxes = document.querySelectorAll('.slider-checkbox');
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
            if (!confirm('Bạn có chắc chắn muốn khôi phục các slider đã chọn?')) return;
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
            if (!confirm('Bạn có chắc chắn muốn xóa vĩnh viễn các slider đã chọn?')) return;
            bulkForceDeleteIds.value = checkedIds.join(',');
            bulkForceDeleteForm.submit();
        });
    });
</script>

@endsection
