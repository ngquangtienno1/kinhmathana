@extends('admin.layouts')
@section('title', 'Thùng rác Sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác Sản phẩm</h2>
        </div>
        <div class="col-auto ms-auto d-flex gap-2">
            <button id="bulk-restore-btn" class="btn btn-success" style="display:none;">Khôi phục</button>
            <button id="bulk-force-delete-btn" class="btn btn-danger" style="display:none;">Xóa vĩnh viễn</button>
            <a href="{{ route('admin.products.list') }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>
    <form id="bulk-restore-form" action="{{ route('admin.products.bulkRestore') }}" method="POST"
        style="display:none;">
        @csrf
        <input type="hidden" name="ids" id="bulk-restore-ids">
    </form>
    <form id="bulk-force-delete-form" action="{{ route('admin.products.bulkForceDelete') }}" method="POST"
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
                                    <input class="form-check-input" id="checkbox-bulk-products-select"
                                        type="checkbox" />
                                </div>
                            </th>
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Tên</th>
                            <th class="align-middle text-center">Giá gốc</th>
                            <th class="align-middle text-center">Giá nhập</th>
                            <th class="align-middle text-center">Giá bán</th>
                            <th class="align-middle text-center">Danh mục</th>
                            <th class="align-middle text-center">Thương hiệu</th>
                            <th class="align-middle text-center">Trạng thái</th>
                            <th class="align-middle text-center">Nổi bật</th>
                            <th class="align-middle text-center">Ngày xóa</th>
                            <th class="align-middle text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="align-middle text-center">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input product-checkbox" type="checkbox"
                                            value="{{ $product->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle text-center">{{ $product->id }}</td>
                                <td class="align-middle text-center">{{ $product->name }}</td>
                                <td class="align-middle text-end">{{ number_format($product->price, 0, ',', '.') }}đ
                                </td>
                                <td class="align-middle text-end">
                                    {{ number_format($product->import_price, 0, ',', '.') }}đ</td>
                                <td class="align-middle text-end">
                                    {{ number_format($product->sale_price, 0, ',', '.') }}đ</td>
                                <td class="align-middle text-center">{{ optional($product->category)->name ?? '-' }}
                                </td>
                                <td class="align-middle text-center">{{ optional($product->brand)->name ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    <span
                                        class="badge {{ $product->status === 'Hoạt động' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->status ?? 'Không rõ' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge {{ $product->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->is_featured ? 'Có' : 'Không' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-body-tertiary">
                                    {{ $product->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.products.restore', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.products.forceDelete', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này?')">
                                                    Xóa vĩnh viễn
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">Không có sản phẩm nào trong thùng rác</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-products-select');
        const itemCheckboxes = document.querySelectorAll('.product-checkbox');
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
            if (!confirm('Bạn có chắc chắn muốn khôi phục các sản phẩm đã chọn?')) return;
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
            if (!confirm('Bạn có chắc chắn muốn xóa vĩnh viễn các sản phẩm đã chọn?')) return;
            bulkForceDeleteIds.value = checkedIds.join(',');
            bulkForceDeleteForm.submit();
        });
    });
</script>

@endsection
