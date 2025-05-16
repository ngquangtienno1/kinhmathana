@extends('admin.layouts')
@section('title', 'Quản lý FAQ')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="#">Cài đặt</a>
</li>
<li class="breadcrumb-item active">FAQ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý FAQ</h2>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form class="position-relative" action="{{ route('admin.faqs.index') }}" method="GET">
                    <input class="form-control search-input search" type="search" name="search" placeholder="Tìm kiếm FAQ" value="{{ request('search') }}" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
            <div class="dropdown">
                <button class="btn btn-phoenix-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Danh mục: {{ request('category') ? request('category') : 'Tất cả' }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item {{ !request('category') ? 'active' : '' }}" href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => null])) }}">Tất cả</a></li>
                    <li><a class="dropdown-item {{ request('category') == 'Chung' ? 'active' : '' }}" href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Chung'])) }}">Chung</a></li>
                    <li><a class="dropdown-item {{ request('category') == 'Sản phẩm' ? 'active' : '' }}" href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Sản phẩm'])) }}">Sản phẩm</a></li>
                    <li><a class="dropdown-item {{ request('category') == 'Vận chuyển' ? 'active' : '' }}" href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Vận chuyển'])) }}">Vận chuyển</a></li>
                    <li><a class="dropdown-item {{ request('category') == 'Thanh toán' ? 'active' : '' }}" href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Thanh toán'])) }}">Thanh toán</a></li>
                    <li><a class="dropdown-item {{ request('category') == 'Bảo hành' ? 'active' : '' }}" href="{{ route('admin.faqs.index', array_merge(request()->query(), ['category' => 'Bảo hành'])) }}">Bảo hành</a></li>
                </ul>
            </div>
            <div class="ms-xxl-auto">
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                    <span class="fas fa-plus me-2"></span>Thêm FAQ
                </a>
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:20px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-faqs-select" type="checkbox" data-bulk-select='{"body":"faqs-table-body"}' />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="image">Hình ảnh</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="question">Câu hỏi</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="category">Danh mục</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="status">Trạng thái</th>
                        <th class="text-end" scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list" id="faqs-table-body">
                    @forelse($faqs as $faq)
                    <tr class="position-static">
                        <td class="fs-9 align-middle">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" type="checkbox" data-bulk-select-row='{"question":"{{ $faq->question }}","category":"{{ $faq->category }}"}' />
                            </div>
                        </td>
                        <td class="image align-middle">
                            @if($faq->image)
                                <img src="{{ asset($faq->image) }}" alt="{{ $faq->question }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded bg-light" style="width: 50px; height: 50px;"></div>
                            @endif
                        </td>
                        <td class="question align-middle">{{ $faq->question }}</td>
                        <td class="category align-middle">{{ $faq->category }}</td>
                        <td class="status align-middle">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" {{ $faq->is_active ? 'checked' : '' }}
                                onchange="updateStatus({{ $faq->id }}, this.checked)">
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                            <div class="btn-reveal-trigger position-static">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="{{ route('admin.faqs.edit', $faq->id) }}">Sửa</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa FAQ này?')">Xóa</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                    Hiển thị {{ $faqs->firstItem() ?? 0 }} đến {{ $faqs->lastItem() ?? 0 }} của {{ $faqs->total() }} kết quả
                </p>
            </div>
            <div class="col-auto d-flex">
                <nav aria-label="Page navigation">
                    {{ $faqs->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateStatus(id, status) {
    fetch(`/admin/faqs/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ is_active: status })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              window.showToast('success', 'Cập nhật trạng thái thành công');
          } else {
              window.showToast('error', 'Có lỗi xảy ra');
          }
      });
}

function deleteFaq(id) {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        fetch(`/admin/faqs/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              } else {
                  window.showToast('error', 'Có lỗi xảy ra');
              }
          });
    }
}
</script>
@endpush

@endsection
