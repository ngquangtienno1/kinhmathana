@extends('admin.layouts')
@section('title', 'Quản lý yêu cầu hỗ trợ')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Yêu cầu hỗ trợ</a></li>
    <li class="breadcrumb-item active">Quản lý yêu cầu hỗ trợ</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Quản lý yêu cầu hỗ trợ</h2>
            </div>
        </div>
    </div>

    <div id="tickets"
        data-list='{"valueNames":["id","name","priority","status","assigned_to","created_at"],"page":10,"pagination":true}'>
        <div class="mb-4 d-flex flex-wrap gap-3 align-items-center">
            <div class="search-box">
                <form action="{{ route('admin.tickets.index') }}" method="GET" class="position-relative">
                    <input class="form-control search-input search" name="search" type="search"
                        placeholder="Tìm kiếm ticket" value="{{ request('search') }}" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>

            <div class="btn-group position-static ms-2">
                <button class="btn btn-phoenix-secondary px-7" type="button" data-bs-toggle="dropdown">
                    Trạng thái <span class="fas fa-angle-down ms-2"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request('status') === null ? 'active' : '' }}"
                            href="{{ route('admin.tickets.index', request()->except('status', 'page')) }}">
                            Tất cả ({{ $totalCount }})
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('status') === 'mới' ? 'active' : '' }}"
                            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'mới'])) }}">
                            Mới ({{ $openCount }})
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('status') === 'đang xử lý' ? 'active' : '' }}"
                            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'đang xử lý'])) }}">
                            Đang xử lý ({{ $dangxulyCount }})
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('status') === 'chờ khách' ? 'active' : '' }}"
                            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'chờ khách'])) }}">
                            Chờ khách ({{ $pendingCount }})
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('status') === 'đã đóng' ? 'active' : '' }}"
                            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'đã đóng'])) }}">
                            Đã đóng ({{ $closedCount }})
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('status') === 'trashed' ? 'active' : '' }}"
                            href="{{ route('admin.tickets.index', array_merge(request()->except('status', 'page'), ['status' => 'trashed'])) }}">
                            Thùng rác ({{ $trashedCount }})
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-responsive bg-body-emphasis border-top border-bottom">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                            <a href="{{ route('admin.tickets.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                class="text-body" style="text-decoration:none;">
                                ID
                                @if (request('sort') === 'id')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="name">Người gửi</th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="priority">Ưu tiên
                        </th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="status">Trạng thái
                        </th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="assigned_to">Người
                            xử lý</th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="created_at">
                            <a href="{{ route('admin.tickets.index', ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                class="text-body" style="text-decoration:none;">
                                Ngày tạo
                                @if (request('sort') === 'created_at')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list" id="tickets-table-body">
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="id align-middle ps-4">{{ $ticket->id }}</td>
                            <td class="name align-middle ps-4">{{ $ticket->user->name ?? 'N/A' }}</td>
                            <td class="priority align-middle ps-4">{{ ucfirst($ticket->priority) }}</td>
                            <td class="status align-middle ps-4">
                                @php
                                    $status = $ticket->status;
                                    switch ($status) {
                                        case 'mới':
                                            $badge = 'info';
                                            break;
                                        case 'đang xử lý':
                                            $badge = 'warning';
                                            break;
                                        case 'chờ khách':
                                            $badge = 'secondary';
                                            break;
                                        case 'đã đóng':
                                            $badge = 'success';
                                            break;
                                        default:
                                            $badge = 'light';
                                    }
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($status) }}</span>
                            </td>
                            <td class="assigned_to align-middle ps-4">{{ $ticket->assignedUser->name ?? 'Chưa gán' }}</td>
                            <td class="created_at align-middle white-space-nowrap text-body-tertiary ps-4">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-reveal dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if (request('status') === 'trashed')
                                            <li>
                                                <form action="{{ route('admin.tickets.restore', $ticket->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item">Khôi phục</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.tickets.forceDelete', $ticket->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Xóa vĩnh viễn ticket?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Xóa vĩnh
                                                        viễn</button>
                                                </form>
                                            </li>
                                        @else
                                            <li><a class="dropdown-item"
                                                    href="{{ route('admin.tickets.show', $ticket->id) }}">Xem</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('admin.tickets.edit', $ticket->id) }}">Sửa</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}"
                                                    method="POST" onsubmit="return confirm('Xóa ticket này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger">Xóa</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có yêu cầu hỗ trợ nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                </p>
                <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span class="fas fa-angle-right ms-1"
                        data-fa-transform="down-1"></span></a>
                <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
                        class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
            </div>
            <div class="col-auto d-flex">
                <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="mb-0 pagination"></ul>
                <button class="page-link pe-0" data-list-pagination="next">
                    <span class="fas fa-chevron-right"></span>
                </button>
            </div>
        </div>
    </div>
@endsection

