@extends('admin.layouts')
@section('title', 'Quản lý kho')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active">Quản lý kho</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý kho</h2>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="inventoryTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="single-tab" data-bs-toggle="tab" href="#single" role="tab">Giao dịch đơn lẻ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="bulk-tab" data-bs-toggle="tab" href="#bulk" role="tab">Giao dịch hàng loạt</a>
        </li>
    </ul>

    <div class="tab-content" id="inventoryTabContent">
        <!-- Tab Giao dịch đơn lẻ -->
        <div class="tab-pane fade show active" id="single" role="tabpanel">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Thêm giao dịch kho</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.inventory.store') }}" method="POST">
                        @csrf
                        <div class="row gx-2 align-items-end mb-3">
                            <div class="col-md">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md">
                                <label class="form-label">Sản phẩm/Biến thể<span class="text-danger">*</span></label>
                                <div class="search-box">
                                    <form class="position-relative" id="target-search-form">
                                        <input type="hidden" name="target_id" id="target_id" required>
                                        <input class="form-control search-input search" type="search"
                                            id="target_search"
                                            placeholder="Tìm sản phẩm/biến thể theo tên hoặc SKU"
                                            autocomplete="off" />
                                        <span class="fas fa-search search-box-icon"></span>
                                    </form>
                                    <div class="dropdown-menu dropdown-menu-end search-dropdown-menu py-0 shadow border rounded-2"
                                        id="targetSearchResults"
                                        style="width: 100%; max-height: 24rem; overflow-y: auto;">
                                        <div class="list-group list-group-flush" id="targetSearchResultsList">
                                            <!-- Search results will be loaded here -->
                                        </div>
                                        <div class="list-group-item px-3 py-2 text-center" id="targetSearchLoading" style="display: none;">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Đang tải...</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-3 py-2 text-center text-muted" id="targetSearchNoResults" style="display: none;">
                                            Không tìm thấy kết quả.
                                        </div>
                                    </div>
                                </div>
                                @error('target_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Loại giao dịch<span class="text-danger">*</span></label>
                                <select name="type" class="form-select">
                                    <option value="import">Nhập kho</option>
                                    <option value="export">Xuất kho</option>
                                    <option value="adjust">Điều chỉnh kho</option>
                                </select>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Số lượng<span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control" min="1" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="note" class="form-control" value="{{ old('note') }}">
                                @error('note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-auto d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fas fa-save me-2"></span>Thực hiện
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tab Giao dịch hàng loạt -->
        <div class="tab-pane fade" id="bulk" role="tabpanel">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Nhập kho hàng loạt cho biến thể</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.inventory.store-bulk') }}" method="POST">
                        @csrf
                        <div class="row gx-2 align-items-end mb-3">
                            <div class="col-auto" style="min-width:260px;">
                                <label class="form-label">Sản phẩm<span class="text-danger">*</span></label>
                                <div class="search-box">
                                    <input type="hidden" name="product_id" id="product_id" required>
                                    <input class="form-control search-input search" type="search"
                                        id="product_search"
                                        placeholder="Tìm sản phẩm theo tên hoặc SKU"
                                        autocomplete="off" />
                                    <span class="fas fa-search search-box-icon"></span>
                                    <div class="dropdown-menu dropdown-menu-end search-dropdown-menu py-0 shadow border rounded-2"
                                        id="productSearchResults"
                                        style="width: 100%; max-height: 24rem; overflow-y: auto;">
                                        <div class="list-group list-group-flush" id="productSearchResultsList">
                                            <!-- Search results will be loaded here -->
                                        </div>
                                        <div class="list-group-item px-3 py-2 text-center" id="productSearchLoading" style="display: none;">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Đang tải...</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-3 py-2 text-center text-muted" id="productSearchNoResults" style="display: none;">
                                            Không tìm thấy kết quả.
                                        </div>
                                    </div>
                                </div>
                                @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto" style="min-width:180px;">
                                <label class="form-label">Loại giao dịch<span class="text-danger">*</span></label>
                                <select name="type" class="form-control" required>
                                    <option value="import">Nhập kho</option>
                                    <option value="export">Xuất kho</option>
                                    <option value="adjust">Điều chỉnh kho</option>
                                </select>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto" style="min-width:300px;">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="note" class="form-control" value="{{ old('note') }}" placeholder="Ghi chú">
                                @error('note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto d-flex align-items-end">
                                <button type="submit" class="btn btn-primary" id="submit-bulk" disabled>
                                    <span class="fas fa-save me-2"></span>Thực hiện
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive scrollbar">
                            <table class="table table-hover table-sm align-middle rounded-3 shadow-sm mb-0 fs-9" id="variations-table" style="overflow:hidden;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle ps-4" style="min-width:180px;">Biến thể</th>
                                        <th class="align-middle ps-4" style="min-width:120px;">SKU</th>
                                        <th class="align-middle ps-4" style="min-width:120px;">Tồn kho hiện tại</th>
                                        <th class="align-middle ps-4" style="min-width:120px;">Số lượng<span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Biến thể sẽ được thêm động qua JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch sử giao dịch kho -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Lịch sử giao dịch kho</h5>
        </div>
        <div class="card-body">
            <div id="inventory-history" data-list='{"valueNames":["reference","product","import_code","type","quantity","current_stock","user","date"],"page":10,"pagination":true}'>
                <div class="mb-4">
                    <form action="{{ route('admin.inventory.index') }}" method="GET">
                        <div class="d-flex align-items-end gap-2 flex-wrap mb-3">
                            <div class="search-box" style="min-width:220px;max-width:300px;flex:1;">
                                <input class="form-control search-input search" type="search" name="search"
                                    placeholder="Tìm SKU hoặc tên sản phẩm" value="{{ request('search') }}" />
                                <span class="fas fa-search search-box-icon"></span>
                    </div>
                            <div style="min-width:160px;">
                                <select name="type" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả loại giao dịch</option>
                            <option value="import" {{ request('type') === 'import' ? 'selected' : '' }}>Nhập kho</option>
                            <option value="export" {{ request('type') === 'export' ? 'selected' : '' }}>Xuất kho</option>
                            <option value="adjust" {{ request('type') === 'adjust' ? 'selected' : '' }}>Điều chỉnh kho</option>
                        </select>
                    </div>
                            <div class="form-check d-flex align-items-center ms-2 mb-0">
                                <input type="checkbox" name="low_stock" class="form-check-input me-2" id="lowStockCheckbox"
                                    {{ request('low_stock') ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="lowStockCheckbox">Hiển thị tồn kho thấp</label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table table-hover table-sm align-middle rounded-3 shadow-sm mb-0 fs-9">
                <thead>
                    <tr>
                                <th class="align-middle ps-4">Mã giao dịch</th>
                                <th class="align-middle ps-4">Sản phẩm/Biến thể</th>
                                <th class="align-middle ps-4">Mã phiếu nhập</th>
                                <th class="align-middle ps-4">Loại</th>
                                <th class="align-middle ps-4">Số lượng</th>
                                <th class="align-middle ps-4">Tồn kho hiện tại</th>
                                <th class="align-middle ps-4">Người thực hiện</th>
                                <th class="align-middle ps-4">Ngày</th>
                                <th class="align-middle text-end pe-0 ps-4">Thao tác</th>
                    </tr>
                </thead>
                        <tbody class="list">
                @foreach ($inventories as $inventory)
                    <tr>
                                    <td class="reference align-middle ps-4">{{ $inventory->reference }}</td>
                                    <td class="product align-middle ps-4">
                            @if ($inventory->variation)
                                {{ $inventory->variation->product->name ?? 'N/A' }} - {{ $inventory->variation->name }} (SKU: {{ $inventory->variation->sku }})
                            @elseif ($inventory->product)
                                {{ $inventory->product->name ?? 'N/A' }} (SKU: {{ $inventory->product->sku }})
                            @else
                                N/A
                            @endif
                        </td>
                                    <td class="import_code align-middle ps-4">{{ $inventory->importDocument->code ?? 'N/A' }}</td>
                                    <td class="type align-middle ps-4">
                            @if ($inventory->type === 'import')
                                            <span class="badge bg-success">Nhập kho</span>
                            @elseif ($inventory->type === 'export')
                                            <span class="badge bg-danger">Xuất kho</span>
                            @else
                                            <span class="badge bg-warning">Điều chỉnh</span>
                            @endif
                        </td>
                                    <td class="quantity align-middle ps-4">{{ $inventory->quantity }}</td>
                                    <td class="current_stock align-middle ps-4">
                            @if ($inventory->variation)
                                {{ $inventory->variation->stock_quantity ?? 'N/A' }}
                                @if ($inventory->variation && $inventory->variation->stock_quantity <= $inventory->variation->stock_alert_threshold)
                                    <span class="badge bg-warning">Tồn thấp</span>
                                @endif
                            @elseif ($inventory->product)
                                {{ $inventory->product->stock_quantity ?? 'N/A' }}
                                @if ($inventory->product && $inventory->product->stock_quantity <= 10)
                                    <span class="badge bg-warning">Tồn thấp</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                                    <td class="user align-middle ps-4">{{ $inventory->user->name ?? 'N/A' }}</td>
                                    <td class="date align-middle ps-4">{{ $inventory->created_at->format('d/m/Y H:i') }}</td>
                        <td class="align-middle text-end pe-0 ps-4 btn-reveal-trigger">
                            <div class="btn-reveal-trigger position-static">
                                <button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="{{ route('admin.inventory.show', $inventory->id) }}">Xem</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.inventory.inventory-print', $inventory->id) }}">In phiếu</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                </div>

                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                            Tổng: {{ $inventories->count() }} giao dịch
                        </p>
                        <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    </div>
                    <div class="col-auto d-flex">
                        <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                        <ul class="mb-0 pagination"></ul>
                        <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chặn submit form search để Phoenix List.js tự động lọc realtime
    const searchForm = document.querySelector('.search-box form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    // Xử lý tìm kiếm sản phẩm/biến thể
    const targetSearch = document.getElementById('target_search');
    const targetId = document.getElementById('target_id');
    const targetSearchResults = document.getElementById('targetSearchResults');
    const targetSearchResultsList = document.getElementById('targetSearchResultsList');
    const targetSearchLoading = document.getElementById('targetSearchLoading');
    const targetSearchNoResults = document.getElementById('targetSearchNoResults');
    let searchTimeout;

    targetSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = this.value.trim();

        if (searchTerm.length < 2) {
            targetSearchResults.style.display = 'none';
            return;
        }

        targetSearchLoading.style.display = 'block';
        targetSearchResults.style.display = 'block';
        targetSearchResultsList.innerHTML = '';
        targetSearchNoResults.style.display = 'none';

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('admin.inventory.search-variations') }}?search=${encodeURIComponent(searchTerm)}&category_id=${document.getElementById('category_id').value}`)
                .then(response => response.json())
                .then(data => {
                    targetSearchLoading.style.display = 'none';

                    if (data.results && data.results.length > 0) {
                        data.results.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'list-group-item list-group-item-action px-3 py-2';
                            div.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <div class="flex-1">
                                        <h6 class="mb-0">${item.text}</h6>
                                        <small class="text-muted">SKU: ${item.sku || 'N/A'}</small>
                                    </div>
                                </div>
                            `;
                            div.addEventListener('click', () => {
                                targetId.value = item.id;
                                targetSearch.value = item.text;
                                targetSearchResults.style.display = 'none';
                            });
                            targetSearchResultsList.appendChild(div);
                        });
                    } else {
                        targetSearchNoResults.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    targetSearchLoading.style.display = 'none';
                    targetSearchNoResults.style.display = 'block';
                });
        }, 300);
    });

    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!targetSearch.contains(e.target) && !targetSearchResults.contains(e.target)) {
            targetSearchResults.style.display = 'none';
        }
    });

    // Xử lý khi thay đổi danh mục
    document.getElementById('category_id').addEventListener('change', function() {
        targetId.value = '';
        targetSearch.value = '';
    });

    // Search-box cho product_id (giao dịch hàng loạt)
    const productSearch = document.getElementById('product_search');
    const productId = document.getElementById('product_id');
    const productSearchResults = document.getElementById('productSearchResults');
    const productSearchResultsList = document.getElementById('productSearchResultsList');
    const productSearchLoading = document.getElementById('productSearchLoading');
    const productSearchNoResults = document.getElementById('productSearchNoResults');
    let productSearchTimeout;

    productSearch.addEventListener('input', function() {
        clearTimeout(productSearchTimeout);
        const searchTerm = this.value.trim();
        if (searchTerm.length < 2) {
            productSearchResults.style.display = 'none';
            return;
        }
        productSearchLoading.style.display = 'block';
        productSearchResults.style.display = 'block';
        productSearchResultsList.innerHTML = '';
        productSearchNoResults.style.display = 'none';
        productSearchTimeout = setTimeout(() => {
            fetch(`{{ route('admin.inventory.search-products') }}?search=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    productSearchLoading.style.display = 'none';
                    if (data.results && data.results.length > 0) {
                        data.results.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'list-group-item list-group-item-action px-3 py-2';
                            div.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <div class="flex-1">
                                        <h6 class="mb-0">${item.text}</h6>
                                        <small class="text-muted">SKU: ${item.sku || 'N/A'}</small>
                                    </div>
                                </div>
                            `;
                            div.addEventListener('click', () => {
                                productId.value = item.id;
                                productSearch.value = item.text;
                                productSearchResults.style.display = 'none';
                                // Trigger load biến thể như cũ
                                const event = new Event('change', { bubbles: true });
                                productId.dispatchEvent(event);
                            });
                            productSearchResultsList.appendChild(div);
                        });
                    } else {
                        productSearchNoResults.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    productSearchLoading.style.display = 'none';
                    productSearchNoResults.style.display = 'block';
                });
        }, 300);
    });
    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!productSearch.contains(e.target) && !productSearchResults.contains(e.target)) {
            productSearchResults.style.display = 'none';
        }
    });
    // Reset khi submit hoặc chuyển tab
    productSearch.form && productSearch.form.addEventListener('reset', function() {
        productId.value = '';
        productSearch.value = '';
    });

    // Load biến thể khi chọn sản phẩm
    $('#product_id').on('change', function() {
        const productIdVal = $(this).val() || productId.value;
        const tableBody = $('#variations-table tbody');
        tableBody.empty();
        $('#submit-bulk').prop('disabled', true);
        if (productIdVal) {
            $.ajax({
                url: '{{ route('admin.inventory.get-variations') }}',
                method: 'GET',
                data: { product_id: productIdVal },
                success: function(response) {
                    if (response.variations.length > 0) {
                        response.variations.forEach(function(variation) {
                            tableBody.append(`
                                <tr>
                                    <td class="align-middle ps-4">${variation.name}</td>
                                    <td class="align-middle ps-4">${variation.sku}</td>
                                    <td class="align-middle ps-4">${variation.stock_quantity}</td>
                                    <td class="align-middle ps-4">
                                        <input type="hidden" name="variations[${variation.id}][id]" value="${variation.id}">
                                        <input type="number" name="variations[${variation.id}][quantity]" class="form-control form-control-sm quantity-input" min="1" required>
                                    </td>
                                </tr>
                            `);
                        });
                        $('#submit-bulk').prop('disabled', false);
                    } else {
                        tableBody.append('<tr><td colspan="4" class="text-center">Không có biến thể nào.</td></tr>');
                    }
                },
                error: function() {
                    tableBody.append('<tr><td colspan="4" class="text-center">Lỗi khi tải biến thể.</td></tr>');
                }
            });
        }
    });
});
</script>
@endsection
