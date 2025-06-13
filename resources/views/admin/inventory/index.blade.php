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
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sản phẩm/Biến thể <span class="text-danger">*</span></label>
                                <select name="target_id" id="target_id" class="form-select" required>
                                    <option value="">Chọn sản phẩm/biến thể</option>
                                </select>
                                @error('target_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Loại giao dịch <span class="text-danger">*</span></label>
                                <select name="type" class="form-select">
                                    <option value="import">Nhập kho</option>
                                    <option value="export">Xuất kho</option>
                                    <option value="adjust">Điều chỉnh kho</option>
                                </select>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control" min="1" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="note" class="form-control" value="{{ old('note') }}">
                                @error('note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Thực hiện</button>
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
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    <option value="">Chọn sản phẩm</option>
                                </select>
                                @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Loại giao dịch <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="import">Nhập kho</option>
                                    <option value="export">Xuất kho</option>
                                    <option value="adjust">Điều chỉnh kho</option>
                                </select>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="note" class="form-control" value="{{ old('note') }}">
                                @error('note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <table class="table table-bordered" id="variations-table">
                                <thead>
                                    <tr>
                                        <th>Biến thể</th>
                                        <th>SKU</th>
                                        <th>Tồn kho hiện tại</th>
                                        <th>Số lượng <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Biến thể sẽ được thêm động qua JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit-bulk" disabled>Thực hiện</button>
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
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Tìm SKU hoặc tên sản phẩm" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">Tất cả loại giao dịch</option>
                            <option value="import" {{ request('type') === 'import' ? 'selected' : '' }}>Nhập kho</option>
                            <option value="export" {{ request('type') === 'export' ? 'selected' : '' }}>Xuất kho</option>
                            <option value="adjust" {{ request('type') === 'adjust' ? 'selected' : '' }}>Điều chỉnh kho</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" name="low_stock" class="form-check-input" {{ request('low_stock') ? 'checked' : '' }}>
                            <label class="form-check-label">Hiển thị tồn kho thấp</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã giao dịch</th>
                        <th>Sản phẩm/Biến thể</th>
                        <th>Mã phiếu nhập</th>
                        <th>Loại</th>
                        <th>Số lượng</th>
                        <th>Tồn kho hiện tại</th>
                        <th>Ghi chú</th>
                        <th>Người thực hiện</th>
                        <th>Ngày</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->reference }}</td>
                        <td>
                            @if ($inventory->variation)
                                {{ $inventory->variation->product->name ?? 'N/A' }} - {{ $inventory->variation->name }} (SKU: {{ $inventory->variation->sku }})
                            @elseif ($inventory->product)
                                {{ $inventory->product->name ?? 'N/A' }} (SKU: {{ $inventory->product->sku }})
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $inventory->importDocument->code ?? 'N/A' }}</td>
                        <td>
                            @if ($inventory->type === 'import')
                                Nhập kho
                            @elseif ($inventory->type === 'export')
                                Xuất kho
                            @else
                                Điều chỉnh
                            @endif
                        </td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>
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
                        <td>{{ $inventory->note }}</td>
                        <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                        <td>{{ $inventory->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.inventory.inventory-print', $inventory->id) }}" class="btn btn-sm btn-primary">In phiếu</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $inventories->links() }}
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Select2 cho target_id (giao dịch đơn lẻ)
    $('#target_id').select2({
        placeholder: 'Tìm sản phẩm/biến thể theo tên hoặc SKU',
        allowClear: true,
        ajax: {
            url: '{{ route('admin.inventory.search-variations') }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    category_id: $('#category_id').val()
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    $('#category_id').on('change', function() {
        $('#target_id').val(null).trigger('change');
    });

    // Select2 cho product_id (giao dịch hàng loạt)
    $('#product_id').select2({
        placeholder: 'Tìm sản phẩm theo tên hoặc SKU',
        allowClear: true,
        ajax: {
            url: '{{ route('admin.inventory.search-products') }}', // Route mới sẽ được thêm
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    // Load biến thể khi chọn sản phẩm
    $('#product_id').on('change', function() {
        const productId = $(this).val();
        const tableBody = $('#variations-table tbody');
        tableBody.empty();
        $('#submit-bulk').prop('disabled', true);

        if (productId) {
            $.ajax({
                url: '{{ route('admin.inventory.get-variations') }}',
                method: 'GET',
                data: { product_id: productId },
                success: function(response) {
                console.log('Variations:', response.variations);
                    if (response.variations.length > 0) {
                        response.variations.forEach(function(variation) {
                            tableBody.append(`
                                <tr>
                                    <td>${variation.name}</td>
                                    <td>${variation.sku}</td>
                                    <td>${variation.stock_quantity}</td>
                                    <td>
                                        <input type="hidden" name="variations[${variation.id}][id]" value="${variation.id}">
                                        <input type="number" name="variations[${variation.id}][quantity]" class="form-control quantity-input" min="1" required>
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
