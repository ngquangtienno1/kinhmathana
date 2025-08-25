@extends('admin.layouts')
@section('title', 'Quản lý phí vận chuyển')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.settings.index') }}">Cài đặt</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.shipping.providers.index') }}">Đơn vị vận chuyển</a>
</li>
<li class="breadcrumb-item active">Phí vận chuyển - {{ $provider->name }}</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Phí vận chuyển - {{ $provider->name }}</h2>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form class="position-relative">
                    <input class="form-control search-input search" type="search" placeholder="Tìm kiếm phí vận chuyển" aria-label="Search" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
            <div class="ms-xxl-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeeModal">
                    <span class="fas fa-plus me-2"></span>Thêm phí vận chuyển
                </button>
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0" data-list='{"valueNames":["province","base_fee","weight_fee","distance_fee","note"],"page":10,"pagination":true}'>
                <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:20px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-fees-select" type="checkbox"
                                    data-bulk-select='{"body":"fees-table-body"}' />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="province">Tỉnh/Thành</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="base_fee">Phí cơ bản</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="note">Ghi chú</th>
                        <th class="text-end" scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list" id="fees-table-body">
                    @foreach($fees as $fee)
                    <tr class="position-static">
                        <td class="fs-9 align-middle">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"province":"{{ $fee->province_name }}","code":"{{ $fee->province_code }}"}' />
                            </div>
                        </td>
                        <td class="province align-middle">{{ $fee->province_name }} ({{ $fee->province_code }})</td>
                        <td class="base_fee align-middle">{{ number_format($fee->base_fee) }}đ</td>
                        <td class="note align-middle">{{ $fee->note }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-phoenix-secondary" data-bs-toggle="modal"
                                    data-bs-target="#editFeeModal{{ $fee->id }}">
                                    <span class="fas fa-edit"></span>
                                </button>
                                <button class="btn btn-sm btn-phoenix-secondary text-danger"
                                    onclick="deleteFee({{ $fee->id }})">
                                    <span class="fas fa-trash"></span>
                                </button>
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
                <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
            </div>
            <div class="col-auto d-flex">
                <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="mb-0 pagination"></ul>
                <button class="page-link" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm mới -->
<div class="modal fade" id="addFeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.shipping.fees.store', $provider->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm phí vận chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã tỉnh/thành</label>
                        <input type="text" class="form-control" name="province_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên tỉnh/thành</label>
                        <input type="text" class="form-control" name="province_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí cơ bản</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="base_fee" required>
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo cân nặng</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="weight_fee" value="0">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo khoảng cách</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="distance_fee" value="0">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="note" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($fees as $fee)
<!-- Modal chỉnh sửa -->
<div class="modal fade" id="editFeeModal{{ $fee->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.shipping.fees.update', [$provider->id, $fee->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa phí vận chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã tỉnh/thành</label>
                        <input type="text" class="form-control" name="province_code" value="{{ $fee->province_code }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên tỉnh/thành</label>
                        <input type="text" class="form-control" name="province_name" value="{{ $fee->province_name }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí cơ bản</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="base_fee" value="{{ $fee->base_fee }}" required>
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo cân nặng</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="weight_fee" value="{{ $fee->weight_fee }}">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo khoảng cách</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="distance_fee" value="{{ $fee->distance_fee }}">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="note" rows="3">{{ $fee->note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
function deleteFee(id) {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        fetch(`/admin/shipping/providers/{{ $provider->id }}/fees/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  window.showToast('success', 'Xóa phí vận chuyển thành công');
                  location.reload();
              } else {
                  window.showToast('error', 'Có lỗi xảy ra');
              }
          });
    }
}

// Initialize list.js
document.addEventListener('DOMContentLoaded', function() {
    const options = {
        valueNames: ['province', 'base_fee', 'weight_fee', 'distance_fee', 'note'],
        page: 10,
        pagination: true
    };
    const feeList = new List('fees-table-body', options);
});
</script>
@endpush

@endsection
