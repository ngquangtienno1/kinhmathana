@extends('admin.layouts')
@section('title', 'Quản lý đánh giá')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Đánh giá</a></li>
    <li class="breadcrumb-item active">Quản lý đánh giá</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý đánh giá</h2>
        </div>
    </div>
    <div id="reviews"
        data-list='{"valueNames":["userId","userName","productName","rating","content","createdAt"],"page":10,"pagination":true}'>
        <div class="mb-4">
            {{-- Combined Filter Form --}}
            <form action="{{ route('admin.reviews.index') }}" method="GET">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    {{-- Search Input --}}
                    <div class="search-box" style="width: 200px;">
                        <input class="form-control search-input" type="search" name="search"
                            placeholder="Tìm kiếm đánh giá" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </div>

                    {{-- Product Filter --}}
                    <div style="width: 180px;">
                        <select class="form-select" name="product_id">
                            <option value="">Chọn Sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- User Filter --}}
                     <div style="width: 180px;">
                        <select class="form-select" name="user_id">
                            <option value="">Chọn Người dùng</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Rating Filter --}}
                    <div style="width: 180px;">
                        <select class="form-select" name="rating">
                            <option value="">Tất cả đánh giá</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} sao ({{ ${['zero', 'one', 'two', 'three', 'four', 'five'][$i] . 'StarCount'} }})
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Reply Status Filter --}}
                    <div style="width: 180px;">
                        <select class="form-select" name="reply_status">
                            <option value="">Tất cả trạng thái trả lời</option>
                            <option value="replied" {{ request('reply_status') === 'replied' ? 'selected' : '' }}>
                                Đã trả lời ({{ $repliedCount }})
                            </option>
                            <option value="not_replied" {{ request('reply_status') === 'not_replied' ? 'selected' : '' }}>
                                Chưa trả lời ({{ $notRepliedCount }})
                            </option>
                        </select>
                    </div>

                    {{-- Date Range Filter --}}
                    <div class="d-flex align-items-center gap-2">
                        <input type="date" class="form-control" id="startDate" name="start_date" style="width: 150px;"
                            value="{{ request('start_date') }}" placeholder="Từ ngày">
                        <span>đến</span>
                        <input type="date" class="form-control" id="endDate" name="end_date" style="width: 150px;"
                            value="{{ request('end_date') }}" placeholder="Đến ngày">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
            {{-- End Combined Filter Form --}}
        </div>

        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle text-center px-3" style="width:10px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-reviews-select" type="checkbox"
                                        data-bulk-select='{"body":"reviews-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'user_id', 'direction' => request('sort') === 'user_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Người dùng
                                    @if (request('sort') === 'user_id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:200px;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'product_id', 'direction' => request('sort') === 'product_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Sản phẩm
                                    @if (request('sort') === 'product_id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:100px;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'rating', 'direction' => request('sort') === 'rating' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Đánh giá
                                    @if (request('sort') === 'rating')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                         
                            <th class="sort align-middle ps-4" scope="col" style="min-width:300px;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'content', 'direction' => request('sort') === 'content' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Nội dung
                                    @if (request('sort') === 'content')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort align-middle ps-4" scope="col" style="min-width:300px;">
                                Câu trả lời Admin
                            </th>
                            <th class="sort align-middle ps-4" scope="col" style="width:150px;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    Ngày tạo
                                    @if (request('sort') === 'created_at')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:90px;">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="reviews-table-body">
                        @forelse ($reviews as $review)
                            <tr>
                                <td class="align-middle text-center px-3">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input review-checkbox" type="checkbox"
                                            value="{{ $review->id }}" />
                                    </div>
                                </td>
                                <td class="id align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $review->id }}</span>
                                </td>
                                <td class="userName align-middle ps-4">
                                    {{ $review->user->name ?? 'N/A' }}<br><small>{{ $review->user->email ?? '' }}</small>
                                </td>
                                <td class="productName align-middle ps-4">
                                    <a href="{{ route('admin.products.show', $review->product_id) }}">
                                        {{ $review->product->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="rating align-middle ps-4">
                                    <div class="text-warning d-flex align-items-center" style="min-width: 100px;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star me-1"></i>
                                            @else
                                                <i class="far fa-star me-1"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                
                                <td class="content align-middle ps-4">{{ $review->content }}</td>
                                <td class="reply align-middle ps-4">
                                    {{ $review->reply ?? '' }}
                                </td>
                                <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $review->created_at->format('d/m/Y H:i') }}
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
                                                href="{{ route('admin.reviews.show', $review->id) }}">Xem</a>
                                            {{-- <a class="dropdown-item" href="{{ route('admin.reviews.edit', $review->id) }}">Sửa</a> --}}
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Không có đánh giá nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn<span
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
    <form id="bulk-delete-form" action="{{ route('admin.reviews.bulkDestroy') }}" method="POST"
        style="display:none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-delete-ids">
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bulkCheckbox = document.getElementById('checkbox-bulk-reviews-select');
            const itemCheckboxes = document.querySelectorAll('.review-checkbox');
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

            // Xử lý submit xoá
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checkedIds = Array.from(itemCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                if (checkedIds.length === 0) return;
                if (!confirm('Bạn có chắc chắn muốn xóa các đánh giá đã chọn?')) return;
                bulkDeleteIds.value = checkedIds.join(',');
                bulkDeleteForm.submit();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const filterForm = searchInput.closest('form');
            let typingTimer;
            const doneTypingInterval = 500; // milliseconds

            searchInput.addEventListener('input', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    filterForm.submit();
                }, doneTypingInterval);
            });

            // Optional: Prevent form submission on Enter key in search input to avoid double submission
            searchInput.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });
        });
    </script>
</div>

@endsection
