@extends('admin.layouts')

@section('title', 'Promotions')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Promotions</a>
    </li>
    <li class="breadcrumb-item active">All Promotions</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Promotions</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $promotions->total() }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Đang hoạt động </span><span
                    class="text-body-tertiary fw-semibold">({{ $promotions->where('is_active', true)->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Không hoạt động </span><span
                    class="text-body-tertiary fw-semibold">({{ $promotions->where('is_active', false)->count() }})</span></a></li>
    </ul>
    <div id="promotions"
        data-list='{"valueNames":["name","code","discount","status","time","usage"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative"><input class="form-control search-input search" type="search"
                            placeholder="Tìm kiếm khuyến mãi" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="scrollbar overflow-hidden-y">
                    <div class="btn-group position-static" role="group">
                        <div class="btn-group position-static text-nowrap"><button
                                class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent"> Trạng thái<span
                                    class="fas fa-angle-down ms-2"></span></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tất cả</a></li>
                                <li><a class="dropdown-item" href="#">Đang hoạt động</a></li>
                                <li><a class="dropdown-item" href="#">Không hoạt động</a></li>
                            </ul>
                        </div>
                        <div class="btn-group position-static text-nowrap"><button
                                class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                                data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent"> Loại giảm giá<span
                                    class="fas fa-angle-down ms-2"></span></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tất cả</a></li>
                                <li><a class="dropdown-item" href="#">Phần trăm</a></li>
                                <li><a class="dropdown-item" href="#">Số tiền</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="ms-xxl-auto">
                    <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary" id="addBtn">
                        <span class="fas fa-plus me-2"></span>Thêm khuyến mãi
                    </a>
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
                                        id="checkbox-bulk-promotions-select" type="checkbox"
                                        data-bulk-select='{"body":"promotions-table-body"}' /></div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:350px;"
                                data-sort="name">TÊN KHUYẾN MÃI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="code" style="width:150px;">
                                MÃ CODE</th>
                            <th class="sort align-middle text-end ps-4" scope="col" data-sort="discount"
                                style="width:150px;">GIẢM GIÁ</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="status" style="width:150px;">
                                TRẠNG THÁI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="time" style="width:200px;">
                                THỜI GIAN</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="usage" style="width:150px;">
                                LƯỢT DÙNG</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="promotions-table-body">
                        @forelse($promotions as $promotion)
                        <tr class="position-static">
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                        data-bulk-select-row='{"name":"{{ $promotion->name }}","code":"{{ $promotion->code }}","discount":"{{ $promotion->discount_type === 'percentage' ? $promotion->discount_value . '%' : number_format($promotion->discount_value, 2) }}","status":"{{ $promotion->is_active ? 'Hoạt động' : 'Không hoạt động' }}","time":"{{ $promotion->start_date->format('d/m/Y') }} - {{ $promotion->end_date->format('d/m/Y') }}","usage":"{{ $promotion->used_count }}{{ $promotion->usage_limit ? ' / ' . $promotion->usage_limit : '' }}"}' />
                                </div>
                            </td>
                            <td class="name align-middle ps-4">
                                <a class="fw-semibold line-clamp-3 mb-0" href="{{ route('admin.promotions.show', $promotion) }}">
                                    {{ $promotion->name }}
                                </a>
                            </td>
                            <td class="code align-middle ps-4">
                                <code>{{ $promotion->code }}</code>
                            </td>
                            <td class="discount align-middle text-end fw-bold text-body-tertiary ps-4">
                                @if($promotion->discount_type === 'percentage')
                                    {{ $promotion->discount_value }}%
                                @else
                                    {{ number_format($promotion->discount_value, 2) }}
                                @endif
                            </td>
                            <td class="status align-middle ps-4">
                                @if($promotion->is_active)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Không hoạt động</span>
                                @endif
                            </td>
                            <td class="time align-middle white-space-nowrap text-body-tertiary text-opacity-85 ps-4">
                                {{ $promotion->start_date->format('d/m/Y') }} - {{ $promotion->end_date->format('d/m/Y') }}
                            </td>
                            <td class="usage align-middle ps-4">
                                {{ $promotion->used_count }}
                                @if($promotion->usage_limit)
                                    / {{ $promotion->usage_limit }}
                                @endif
                            </td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                <div class="btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item" href="{{ route('admin.promotions.show', $promotion) }}">Xem</a>
                                        <a class="dropdown-item" href="{{ route('admin.promotions.edit', $promotion) }}">Sửa</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này?')">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có khuyến mãi nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                <a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                <a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
            </div>
            <div class="col-auto d-flex">
                <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="mb-0 pagination"></ul>
                <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
        </div>
    </div>
</div>
@endsection 