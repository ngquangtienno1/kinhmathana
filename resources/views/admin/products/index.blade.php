<!-- resources/views/admin/products/index.blade.php -->
@extends('admin.layouts')
@section('title', 'Products')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.products.list') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Danh sách sản phẩm</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Danh sách sản phẩm</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link {{ request('status') == null ? 'active' : '' }}"
                href="{{ route('admin.products.list') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $products->count() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') === 'Hoạt động' ? 'active' : '' }}"
                href="{{ route('admin.products.list', ['status' => 'Hoạt động']) }}">
                Đang hoạt động <span class="text-body-tertiary fw-semibold">({{ $activeCount }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('bin') === '1' ? 'active' : '' }}"
                href="{{ route('admin.products.trashed') }}">
                Thùng rác <span class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span>
            </a>
        </li>
    </ul>
    <div id="products"
        data-list='{"valueNames":["name","price","sale_price","stock","description","categories","brand","has_variations","is_featured","views","status","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.products.list') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm sản phẩm" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <select class="form-select" name="category_id" id="category_id">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <input class="form-control" type="date" name="date_from" placeholder="Ngày tạo từ"
                        value="{{ request('date_from') }}" />
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <span class="fas fa-filter me-2"></span>Lọc
                    </button>
                    <a href="{{ route('admin.products.list') }}" class="btn btn-secondary">
                        <span class="fas fa-eraser me-2"></span>Bỏ lọc
                    </a>
                </div>
                <div class="ms-auto">
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa mềm
                    </button>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm sản phẩm
                    </a>
                </div>
            </div>
        </div>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1"
            id="product-table-wrapper">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-products-select" type="checkbox"
                                        data-bulk-select='{"body":"products-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4">ID</th>
                            <th class="sort align-middle ps-4">Tên</th>
                            <th class="sort align-middle ps-4">Giá gốc</th>
                            <th class="sort align-middle ps-4">Giá bán</th>
                            <th class="sort align-middle ps-4">Số lượng</th>
                            <th class="sort align-middle ps-4">Mô tả ngắn</th>
                            <th class="sort align-middle ps-4">Danh mục</th>
                            <th class="sort align-middle ps-4">Thương hiệu</th>
                            <th class="sort align-middle ps-4">Sp có biến thể</th>
                            <th class="sort align-middle ps-4">Nổi bật</th>
                            <th class="sort align-middle ps-4">Lượt xem</th>
                            <th class="sort align-middle ps-4">Trạng thái</th>
                            <th class="sort text-end align-middle pe-0 ps-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="products-table-body">
                        @forelse ($products as $product)
                            <tr class="position-static">
                                <td class="align-middle ps-0">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input product-checkbox" type="checkbox"
                                            value="{{ $product->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle ps-4">{{ $loop->iteration }}</td>
                                <td class="align-middle ps-4 name">{{ $product->name }}</td>
                                <td class="align-middle ps-4 text-end price">
                                    {{ $product->product_type === 'simple' ? number_format($product->price ?? 0, 0, ',', '.') . 'đ' : number_format($product->default_price ?? 0, 0, ',', '.') . 'đ' }}
                                </td>
                                <td class="align-middle ps-4 text-end sale_price">
                                    {{ $product->product_type === 'simple' ? number_format($product->sale_price ?? 0, 0, ',', '.') . 'đ' : number_format($product->default_sale_price ?? 0, 0, ',', '.') . 'đ' }}
                                </td>
                                <td class="align-middle ps-4 text-center stock">
                                    {{ $product->total_stock }}
                                </td>
                                <td class="align-middle ps-4 description">{{ Str::limit($product->description_short ?? '', 50) }}
                                </td>
                                <td class="align-middle ps-4 categories">
                                    @if ($product->categories->count() > 0)
                                        {{ $product->categories->pluck('name')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="align-middle ps-4 brand">{{ optional($product->brand)->name ?? '-' }}</td>
                                <td class="align-middle text-center has_variations">
                                    <span
                                        class="badge {{ $product->product_type === 'variable' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->product_type === 'variable' ? 'Có' : 'Không' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center is_featured">
                                    <span class="badge {{ $product->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->is_featured ? 'Có' : 'Không' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center views">{{ $product->views ?? 0 }}</td>
                                <td class="align-middle text-center status">
                                    <span
                                        class="badge {{ $product->status === 'Hoạt động' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->status ?? 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="align-middle text-end pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.show', $product->id) }}">Xem</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.edit', $product->id) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger"
                                                    onclick="deleteProduct({{ $product->id }})">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center py-4 text-muted">Không có sản phẩm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        Tổng: {{ $products->count() }} sản phẩm
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả <span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn <span
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

<form id="bulk-delete-form" action="{{ route('admin.products.bulkDestroy') }}" method="POST"
    style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids[]" id="bulk-delete-ids">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-products-select');
        const itemCheckboxes = document.querySelectorAll('.product-checkbox');
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
            if (!confirm('Bạn có chắc chắn muốn xóa mềm các sản phẩm đã chọn?')) return;
            bulkDeleteIds.value = checkedIds.join(',');
            bulkDeleteForm.submit();
        });
    });

    function deleteProduct(id) {
        $.ajax({
            url: `/admin/products/destroy/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Xác nhận xóa',
                        text: response.message,
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Gửi lại request với force true
                            $.ajax({
                                url: `/admin/products/destroy/${id}`,
                                type: 'DELETE',
                                data: { force: true },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công!',
                                        text: 'Sản phẩm đã được chuyển vào thùng rác',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi!',
                                        text: 'Có lỗi xảy ra khi xóa sản phẩm'
                                    });
                                }
                            });
                        }
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi xóa sản phẩm'
                });
            }
        });
    }
</script>

@endsection
