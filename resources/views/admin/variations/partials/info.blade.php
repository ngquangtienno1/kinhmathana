<div class="card">
    <div class="card-body">
        <h4 class="mb-3">Thông tin cơ bản</h4>
        <table class="table table-bordered">
            <tbody>
                <tr><th>Tên biến thể</th><td>{{ $variation->name }}</td></tr>
                <tr><th>SKU</th><td>{{ $variation->sku }}</td></tr>
                <tr><th>Giá gốc</th><td>{{ number_format($variation->price, 0, ',', '.') }}đ</td></tr>
                <tr><th>Giá nhập</th><td>{{ number_format($variation->import_price, 0, ',', '.') }}đ</td></tr>
                <tr><th>Giá bán</th><td>{{ number_format($variation->sale_price, 0, ',', '.') }}đ</td></tr>
                <tr><th>Giá KM</th><td>{{ number_format($variation->discount_price, 0, ',', '.') }}đ</td></tr>
                <tr><th>Tồn kho</th><td>{{ $variation->stock_quantity }}</td></tr>
                <tr><th>Sản phẩm cha</th><td>{{ optional($variation->product)->name ?? 'Không có' }}</td></tr>
                <tr><th>Màu sắc</th><td>{{ optional(optional($variation->variationDetails->first())->color)->name ?? '-' }}</td></tr>
                <tr><th>Kích thước</th><td>{{ optional(optional($variation->variationDetails->first())->size)->name ?? '-' }}</td></tr>
                <tr><th>Ngày tạo</th><td>{{ $variation->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><th>Ngày cập nhật</th><td>{{ $variation->updated_at ? $variation->updated_at->format('d/m/Y H:i') : 'Chưa cập nhật' }}</td></tr>
            </tbody>
        </table>
    </div>
</div>
