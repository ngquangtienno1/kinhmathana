@extends('admin.layouts')
@section('title', 'Sliders')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Slider</a>
    </li>
    <li class="breadcrumb-item active">Danh sách Slider</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Slider</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.sliders.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $sliders->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.sliders.index', ['status' => 'active']) }}"><span>Đang hoạt động </span><span
                    class="text-body-tertiary fw-semibold">({{ $activeCount }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.sliders.bin') }}"><span>Thùng rác </span><span
                    class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span></a>
        </li>
    </ul>
    <div id="sliders"
        data-list='{"valueNames":["title","description","sort_order","status","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.sliders.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm slider" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa mềm
                    </button>
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm slider
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
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-sliders-select" type="checkbox"
                                        data-bulk-select='{"body":"sliders-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.sliders.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle fs-9" scope="col" style="width:70px;">
                                ẢNH
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:250px;"
                                data-sort="title">TIÊU ĐỀ</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="description"
                                style="width:200px;">MÔ TẢ</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="sort_order"
                                style="width:100px;">SẮP XẾP</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="status" style="width:120px;">
                                TRẠNG THÁI</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="created_at"
                                style="width:150px;">NGÀY TẠO</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="sliders-table-body">
                        @forelse ($sliders as $slider)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input slider-checkbox" type="checkbox"
                                            value="{{ $slider->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $slider->id }}</span>
                                </td>
                                <td class="align-middle white-space-nowrap py-0">
                                    <a class="d-block border border-translucent rounded-2" href="#">
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt=""
                                            width="53" />
                                    </a>
                                </td>
                                <td class="title align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0"
                                        href="{{ route('admin.sliders.show', $slider->id) }}">{{ $slider->title }}</a>
                                </td>
                                <td class="description align-middle ps-4">
                                    <span class="text-body-tertiary">{{ Str::limit($slider->description, 50) }}</span>
                                </td>
                                <td class="sort_order align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $slider->sort_order }}</span>
                                </td>
                                <td class="status align-middle ps-4">
                                    <span
                                        class="badge badge-phoenix fs-10 {{ $slider->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                        {{ $slider->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $slider->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.sliders.show', $slider->id) }}">Xem</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.sliders.edit', $slider->id) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.sliders.destroy', $slider->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa slider này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có slider nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                    <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
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

@endsection
