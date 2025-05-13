@extends('admin.layouts')
@section('title', 'Products')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="#">Products</a>
</li>
<li class="breadcrumb-item active">All Products</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Products</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>All </span><span
                    class="text-body-tertiary fw-semibold">({{ $products->count() }})</span></a></li>
    </ul>
    <div id="products"
        data-list='{"valueNames":["product","price","category","status","featured"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative"><input class="form-control search-input search" type="search"
                            placeholder="Search products" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <button class="btn btn-primary" id="addBtn">
                        <span class="fas fa-plus me-2"></span>Add product
                    </button>
                </div>
            </div>
        </div>
        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                        id="checkbox-bulk-products-select" type="checkbox"
                                        data-bulk-select='{"body":"products-table-body"}' /></div>
                            </th>
                            <th class="sort white-space-nowrap align-middle" scope="col" style="width:350px;"
                                data-sort="product">PRODUCT NAME</th>
                            <th class="sort align-middle text-end" scope="col" data-sort="price"
                                style="width:150px;">PRICE</th>
                            <th class="sort align-middle" scope="col" data-sort="category" style="width:150px;">
                                CATEGORY</th>
                            <th class="sort align-middle" scope="col" data-sort="status" style="width:100px;">
                                STATUS</th>
                            <th class="sort align-middle" scope="col" data-sort="featured" style="width:100px;">
                                FEATURED</th>
                            <th class="sort align-middle" scope="col" style="width:80px;">VIEWS</th>
                            <th class="sort text-end align-middle pe-0" scope="col" style="width:100px;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="products-table-body">
                        @foreach($products as $product)
                        <tr class="position-static">
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"product":"{{ $product->name }}"}'>
                                </div>
                            </td>
                            <td class="product align-middle ps-4">
                                <a class="fw-semibold line-clamp-3 mb-0" href="#">
                                    {{ $product->name }}
                                </a>
                                @if($product->description_short)
                                <p class="mb-0 text-body-tertiary fs-9">{{ Str::limit($product->description_short, 50) }}</p>
                                @endif
                            </td>
                            <td class="price align-middle white-space-nowrap text-end fw-bold text-body-tertiary ps-4">
                                ${{ number_format($product->price, 2) }}
                                @if($product->discount_price > 0)
                                <br><small class="text-danger"><del>${{ number_format($product->sale_price, 2) }}</del></small>
                                @endif
                            </td>
                            <td class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                                {{ $product->category->name ?? 'N/A' }}
                            </td>
                            <td class="status align-middle white-space-nowrap ps-4">
                                <span class="badge badge-phoenix fs-10 badge-phoenix-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ $product->status ?? 'inactive' }}
                                </span>
                            </td>
                            <td class="featured align-middle white-space-nowrap ps-4">
                                @if($product->is_featured)
                                <span class="fas fa-check-circle text-success"></span>
                                @else
                                <span class="fas fa-times-circle text-danger"></span>
                                @endif
                            </td>
                            <td class="align-middle white-space-nowrap ps-4">
                                {{ $product->views }}
                            </td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4">
                                <div class="btn-group">
                                    <a href="" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                    <a class="fw-semibold" href="#!" data-list-view="*">
                        View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                    </a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">
                        View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                    </a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
