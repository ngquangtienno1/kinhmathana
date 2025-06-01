@extends('admin.layouts')

@section('title', 'Support List')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.support.list') }}">Support</a>
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
        <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.support.list') }}">
                    <span>Tất cả </span>
                    <span class="text-body-tertiary fw-semibold">({{ $totalCount }})</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'active' ? 'active' : '' }}"
                    href="{{ route('admin.support.list', ['status' => 'active']) }}">
                    <span>Đang hoạt động </span>
                    <span class="text-body-tertiary fw-semibold">({{ $activeCount }})</span>
                </a>
            </li>
        </ul>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" method="GET" action="{{ route('admin.support.list') }}">
                        <input class="form-control search-input search" type="search" name="q"
                            value="{{ request('q') }}" placeholder="Tìm kiếm hỗ trợ khách hàng" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                {{-- Các nút filter/action khác nếu cần đồng bộ từ products/index.blade.php --}}
                {{-- <div class="ms-xxl-auto"><a href="{{ route('admin.support.create') }}" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Thêm hỗ trợ</a></div> --}}
            </div>
        </div>
        <div id="supports"
            data-list='{"valueNames":["name","email","message","status","created_at"],"page":10,"pagination":true}'
            class="bg-white mx-n4 px-4 mx-lg-n6 px-lg-6 border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-supports-select" type="checkbox"
                                        data-bulk-select='{"body":"supports-table-body"}' />
                                </div>
                            </th>
                            <th class="text-center" style="width: 50px;">STT</th>
                            <th class="name">Họ tên</th>
                            <th class="email">Email</th>
                            <th class="message" style="min-width:180px;">Nội dung</th>
                            <th class="status text-center">Trạng thái</th>
                            <th class="created_at text-center">Thời gian gửi</th>
                            <th class="text-center" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="supports-table-body">
                        @forelse($supports as $index => $item)
                            <tr>
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input" type="checkbox"
                                            data-bulk-select-row='{"id":"{{ $item->id }}"}' />
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ $index + 1 }}</td>
                                <td class="name">{{ $item->user->name }}</td>
                                <td class="email"><a href="mailto:{{ $item->user->email }}">{{ $item->user->email }}</a>
                                </td>
                                <td class="message">
                                    <span title="{{ $item->message }}">
                                        {{ \Illuminate\Support\Str::limit($item->message, 50) }}
                                    </span>
                                </td>
                                <td class="status text-center">
                                    <span
                                        class="badge badge-phoenix fs-10
                                        @if ($item->status == 'mới') badge-phoenix-danger
                                        @elseif($item->status == 'đang xử lý') badge-phoenix-warning
                                        @elseif($item->status == 'đã xử lý') badge-phoenix-success
                                        @else badge-phoenix-secondary @endif
                                    ">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="created_at text-center">{{ $item->created_at->format('d/m/Y H:i') }}</td>
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
                                                href="{{ route('admin.support.show', $item->id) }}">Xem</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal{{ $item->id }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.support.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Chưa có phản hồi nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
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

    @foreach ($supports as $item)
        <!-- Modal sửa trạng thái -->
        <div class="modal fade" id="editStatusModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editStatusModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.support.updateStatus', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editStatusModalLabel{{ $item->id }}">Cập nhật trạng thái hỗ
                                trợ khách hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="status{{ $item->id }}" class="form-label"><strong>Trạng
                                        thái</strong></label>
                                <select name="status" id="status{{ $item->id }}" class="form-select">
                                    <option value="mới" {{ $item->status == 'mới' ? 'selected' : '' }}>Mới</option>
                                    <option value="đang xử lý" {{ $item->status == 'đang xử lý' ? 'selected' : '' }}>Đang
                                        xử lý</option>
                                    <option value="đã xử lý" {{ $item->status == 'đã xử lý' ? 'selected' : '' }}>Đã xử lý
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
