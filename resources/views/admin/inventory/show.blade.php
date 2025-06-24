@extends('admin.layouts')

@section('title', 'Chi tiết giao dịch kho')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.inventory.index') }}">Quản lý kho</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết giao dịch kho</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết giao dịch kho</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.inventory.inventory-print', $inventory->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-print me-2"></span>In phiếu
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin giao dịch</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Mã giao dịch</th>
                                        <td>{{ $inventory->reference }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sản phẩm/Biến thể</th>
                                        <td>
                                            @if ($inventory->variation)
                                                {{ $inventory->variation->product->name ?? 'N/A' }} - {{ $inventory->variation->name ?? 'N/A' }} (SKU: {{ $inventory->variation->sku ?? 'N/A' }})
                                            @elseif ($inventory->product)
                                                {{ $inventory->product->name ?? 'N/A' }} (SKU: {{ $inventory->product->sku ?? 'N/A' }})
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loại giao dịch</th>
                                        <td>
                                            @if ($inventory->type === 'import')
                                                <span class="badge bg-success">Nhập kho</span>
                                            @elseif ($inventory->type === 'export')
                                                <span class="badge bg-danger">Xuất kho</span>
                                            @else
                                                <span class="badge bg-warning">Điều chỉnh</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Số lượng</th>
                                        <td>{{ $inventory->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ghi chú</th>
                                        <td>{{ $inventory->note ?? 'Không có' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Người thực hiện</th>
                                        <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mã phiếu nhập</th>
                                        <td>{{ $inventory->importDocument->code ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $inventory->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $inventory->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 