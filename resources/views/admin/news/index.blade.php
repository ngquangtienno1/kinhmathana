@extends('admin.layouts')
@section('title', 'Tin tức')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Tin tức</a>
    </li>
    <li class="breadcrumb-item active">Danh sách tin tức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0"> Danh sách tin tức</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link active" aria-current="page"
                href="{{ route('admin.news.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $news->count() }})</span></a></li>
        <li class="nav-item"><a class="nav-link"
                href="{{ route('admin.news.index', ['status' => 'active']) }}"><span>Đang hoạt động </span><span
                    class="text-body-tertiary fw-semibold">({{ $activeCount }})</span></a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.news.bin') }}"><span>Thùng rác </span><span
                    class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span></a>
        </li>
    </ul>
    <div id="news"
        data-list='{"valueNames":["title","content","status","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                <form action="{{ route('admin.news.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-3 mb-0">
                    <!-- Search Input -->
                    <div class="search-box">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm tin tức" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </div>
                    <!-- Category Filter -->
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-phoenix-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Danh mục: {{ request('category') ? $categories->firstWhere('id', request('category'))->name : 'Tất cả' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ !request('category') ? 'active' : '' }}"
                                        href="{{ route('admin.news.index', array_merge(request()->query(), ['category' => null])) }}">Tất cả</a></li>
                                @foreach ($categories as $category)
                                    <li><a class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}"
                                            href="{{ route('admin.news.index', array_merge(request()->query(), ['category' => $category->id])) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Date Range Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}" style="width: 150px;" placeholder="Từ ngày">
                        <span>-</span>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}" style="width: 150px;" placeholder="Đến ngày">
                    </div>
                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Lọc</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary"><i class="fas fa-times me-1"></i>Bỏ lọc</a>
                    </div>
                </form>
                <div class="ms-xxl-auto d-flex gap-2">
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa mềm
                    </button>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm tin tức
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
                                    <input class="form-check-input" id="checkbox-bulk-news-select" type="checkbox"
                                        data-bulk-select='{"body":"news-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.news.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle fs-9" scope="col" style="width:70px;">
                                ẢNH</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:250px;"
                                data-sort="title">TIÊU ĐỀ</th>
                            <th class="sort" data-sort="category">Danh mục</th>
                            <th class="sort" data-sort="author">Tác giả</th>
                            <th class="sort" data-sort="published_at">Ngày xuất bản</th>
                            <th class="sort" data-sort="status">Trạng thái</th>
                            <th class="sort" data-sort="created_at">Ngày tạo</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="news-table-body">
                        @forelse ($news as $item)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input news-checkbox" type="checkbox"
                                            value="{{ $item->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $item->id }}</span>
                                </td>
                                <td class="align-middle white-space-nowrap py-0">
                                    <a class="d-block" href="{{ route('admin.news.show', $item) }}">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt=""
                                            width="53" class="img-fluid rounded-2 border border-translucent" />
                                    </a>
                                </td>
                                <td class="title align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0"
                                        href="{{ route('admin.news.show', $item) }}">{{ $item->title }}</a>
                                </td>
                                <td class="category align-middle ps-4">
                                    {{ $item->category ? $item->category->name : 'N/A' }}</td>
                                <td class="author align-middle ps-4">{{ $item->author ? $item->author->name : 'N/A' }}
                                </td>
                                <td class="published_at align-middle ps-4">
                                    {{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : 'Chưa xuất bản' }}
                                </td>
                                <td class="status align-middle ps-4">
                                    <span
                                        class="badge badge-phoenix fs-10 {{ $item->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                        {{ $item->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '' }}
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
                                                href="{{ route('admin.news.show', $item) }}">Xem</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.news.edit', $item) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có tin tức nào</td>
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

<form id="bulk-delete-form" action="{{ route('admin.news.bulkDestroy') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulkCheckbox = document.getElementById('checkbox-bulk-news-select');
        const itemCheckboxes = document.querySelectorAll('.news-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const bulkDeleteIds = document.getElementById('bulk-delete-ids');

        function updateBulkDeleteBtn() {
            let checkedCount = 0;
            itemCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) checkedCount++;
            });
            if (checkedCount > 0) {
                bulkDeleteBtn.style.display = '';
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        if (bulkCheckbox) {
            bulkCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = bulkCheckbox.checked;
                });
                updateBulkDeleteBtn();
            });
        }
        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateBulkDeleteBtn();
            });
        });
        updateBulkDeleteBtn(); // Initial state

        // Xử lý submit xoá mềm
        bulkDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedIds = Array.from(itemCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            if (checkedIds.length === 0) return;
            if (!confirm('Bạn có chắc chắn muốn xóa mềm các tin tức đã chọn?')) return;
            bulkDeleteIds.value = checkedIds.join(',');
            bulkDeleteForm.submit();
        });
    });
</script>

@endsection
