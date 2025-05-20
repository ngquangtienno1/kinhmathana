@extends('admin.layouts')

@section('title', 'Support List')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.support.index') }}">Support</a>
    </li>
    <li class="breadcrumb-item active">Quản lý hỗ trợ khách hàng</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý hỗ trợ khách hàng</h2>
        </div>
    </div>
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form class="position-relative" method="GET">
                    <input class="form-control search-input search" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm hỗ trợ khách hàng" aria-label="Search" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
            {{-- Các nút filter/action khác nếu cần đồng bộ từ products/index.blade.php --}}
            {{-- <div class="ms-xxl-auto"><button class="btn btn-primary"><span class="fas fa-plus me-2"></span>Thêm hỗ trợ</button></div> --}}
        </div>
    </div>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-supports-select" type="checkbox" data-bulk-select='{"body":"supports-table-body"}' />
                            </div>
                        </th>
                        <th class="text-center" style="width: 50px;">STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th style="min-width:180px;">Nội dung</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Thời gian gửi</th>
                        <th class="text-center" style="width:120px;">Action</th>
                    </tr>
                </thead>
                <tbody class="list" id="supports-table-body">
                    @forelse($supports as $index => $item)
                        <tr>
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox" data-bulk-select-row='{"id":"{{ $item->id }}"}' />
                                </div>
                            </td>
                            <td class="text-center">{{ ($supports->currentPage() - 1) * $supports->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                            <td>
                                <span title="{{ $item->message }}">
                                    {{ \Illuminate\Support\Str::limit($item->message, 50) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge
                                    @if($item->status == 'chưa giải quyết') bg-danger
                                    @elseif($item->status == 'đang xử lý') bg-warning text-dark
                                    @elseif($item->status == 'đã giải quyết') bg-success
                                    @else bg-secondary
                                    @endif
                                ">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                <div class="btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item" href="{{ route('admin.support.show', $item->id) }}">
                                            <i class="fas fa-eye text-info me-2"></i>Xem chi tiết
                                        </a>
                                        @if($item->status == 'mới')
                                            <form action="{{ route('admin.support.done', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Xác nhận đánh dấu đã xử lý?')">
                                                    <i class="fas fa-check text-success me-2"></i>Đánh dấu đã xử lý
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.support.delete', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                                <i class="fas fa-trash-alt me-2"></i>Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Chưa có phản hồi nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
        <div class="col-auto d-flex">
            <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                 @if($supports->total() > 0)
                    Hiển thị {{ $supports->firstItem() }} - {{ $supports->lastItem() }} trên tổng số {{ $supports->total() }} hỗ trợ
                @else
                    Không có dữ liệu
                @endif
            </p>
        </div>
        <div class="col-auto d-flex">
            {{ $supports->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection 