@extends('admin.layouts')

@section('title', 'Thùng rác lý do hủy')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.cancellation_reasons.index') }}">Lý do hủy</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác lý do hủy</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('admin.cancellation_reasons.index') }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle text-center" style="width:40px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-reasons-select" type="checkbox"
                                        data-bulk-select='{"body":"reasons-table-body"}' />
                                </div>
                            </th>
                            <th class="align-middle text-center" style="width:80px;">ID</th>
                            <th class="align-middle text-center" style="width:250px;">LÝ DO HỦY</th>
                            <th class="align-middle text-center" style="width:120px;">LOẠI</th>
                            <th class="align-middle text-center" style="width:120px;">TRẠNG THÁI</th>
                            <th class="align-middle text-center" style="width:150px;">NGÀY XÓA</th>
                            <th class="align-middle text-center" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="reasons-table-body">
                        @forelse($cancellationReasons as $reason)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input reason-checkbox" type="checkbox"
                                            value="{{ $reason->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-body-tertiary">{{ $reason->id }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="fw-semibold line-clamp-3 mb-0" href="#">{{ $reason->reason }}</a>
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="badge badge-phoenix fs-10 {{ $reason->type === 'customer' ? 'badge-phoenix-info' : 'badge-phoenix-warning' }}">
                                        {{ $reason->type === 'customer' ? 'Khách hàng' : 'Admin' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="badge badge-phoenix fs-10 {{ $reason->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                        {{ $reason->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-body-tertiary">
                                    {{ $reason->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle text-center btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form
                                                action="{{ route('admin.cancellation_reasons.restore', $reason->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form
                                                action="{{ route('admin.cancellation_reasons.forceDelete', $reason->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn lý do hủy này?')">Xóa
                                                    vĩnh viễn</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Không có lý do hủy nào trong thùng rác
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $cancellationReasons->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
