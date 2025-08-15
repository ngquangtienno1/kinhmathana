<div class="card">
    <div class="card-body">
        <h5>{{ $product->name }}</h5>
        <p>Tồn kho tổng: {{ $product->total_stock }}</p>
        <div class="row">
            @foreach ($product->variations as $variation)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <p>Tên: {{ $variation->name }}</p>
                            <p>Giá: {{ number_format($variation->price, 2) }}</p>
                            <p>Tồn kho: {{ $variation->quantity }}</p>
                            <a href="{{ route('admin.variations.edit', $variation->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
