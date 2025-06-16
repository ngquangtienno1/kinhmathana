<!DOCTYPE html>
<html>
<head>
    <title>Phiếu kho - {{ $inventory->reference }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .footer { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Phiếu kho</h2>
        <p>Mã phiếu: {{ $inventory->reference }}</p>
        <p>Ngày: {{ $inventory->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
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
                    Nhập kho
                @elseif ($inventory->type === 'export')
                    Xuất kho
                @else
                    Điều chỉnh
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
    </table>

    <div class="footer">
        <p>Người lập phiếu: {{ $inventory->user->name ?? 'N/A' }}</p>
    </div>
</body>
</html>
