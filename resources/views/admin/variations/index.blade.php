@extends('admin.layouts')
@section('title', 'Biến thể sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Biến thể</a></li>
    <li class="breadcrumb-item active">Danh sách biến thể</li>
@endsection

@php
    $totalCount = \App\Models\Variation::count();
    $outOfStockCount = \App\Models\Variation::where('stock_quantity', '<=', 0)->count();
    $trashedCount = \App\Models\Variation::onlyTrashed()->count();
@endphp

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Biến thể sản phẩm</h2>
        </div>
    </div>

   <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link {{ request()->get('filter') === null ? 'active' : '' }}"
               href="{{ route('admin.variations.index') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $totalCount }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->get('filter') === 'out_of_stock' ? 'active' : '' }}"
               href="{{ route('admin.variations.index', ['filter' => 'out_of_stock']) }}">
                Hết hàng <span class="text-body-tertiary fw-semibold">({{ $outOfStockCount }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.variations.bin') ? 'active' : '' }}"
               href="{{ route('admin.variations.bin') }}">
                Thùng rác <span class="text-body-tertiary fw-semibold">({{ $trashedCount }})</span>
            </a>
        </li>
    </ul>
    <div id="variations"
         data-list='{"valueNames":["name","sku","price","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.variations.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm biến thể" value="{{ request('search') }}" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <a href="{{ route('admin.variations.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm biến thể
                    </a>
                </div>
            </div>
        </div>

    <div class="card">
        <div class="table-responsive scrollbar">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tên biến thể</th>
                        <th class="text-center">SKU</th>
                        <th class="text-end">Giá gốc</th>
                        <th class="text-end">Giá nhập</th>
                        <th class="text-end">Giá bán</th>
                        <th class="text-center">Sản phẩm cha</th>
                        <th class="text-center">Màu</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variations as $variation)
                        @php
                            $detail = $variation->variationDetails->first();
                            $color = optional($detail?->color);
                            $size = optional($detail?->size);
                            $image = $variation->images->where('is_thumbnail', true)->first() ?? $variation->images->first();
                        @endphp
                        <tr>
                            <td class="text-center">{{ $variation->id }}</td>
                            <td class="text-center">{{ $variation->name }}</td>
                            <td class="text-center">{{ $variation->sku }}</td>
                            <td class="text-end">{{ number_format($variation->price, 0, ',', '.') }}đ</td>
                            <td class="text-end">{{ number_format($variation->import_price, 0, ',', '.') }}đ</td>
                            <td class="text-end">{{ number_format($variation->sale_price, 0, ',', '.') }}đ</td>
                            <td class="text-center">{{ optional($variation->product)->name ?? '-' }}</td>
                            <td class="text-center">
                                @if($color)
                                    <span class="badge" style="background-color: {{ $color->hex_code }}; color: #fff;">
                                        {{ $color->name }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $size->name ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item" href="{{ route('admin.variations.show', $variation->id) }}">Xem</a>
                                        <a class="dropdown-item" href="{{ route('admin.variations.edit', $variation->id) }}">Sửa</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.variations.destroy', $variation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">Không có biến thể nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center py-3 px-4">
            <div class="text-body-secondary small">
                Hiển thị {{ $variations->firstItem() }} đến {{ $variations->lastItem() }} trong tổng số {{ $variations->total() }} mục
            </div>
            <div>{{ $variations->links() }}</div>
        </div>
    </div>
</div>

@endsection
