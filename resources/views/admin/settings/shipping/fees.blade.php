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
            <div class="ms-xxl-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeeModal">
                    <span class="fas fa-plus me-2"></span>Thêm phí vận chuyển
                </button>
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th scope="col">Tỉnh/Thành</th>
                        <th scope="col">Phí cơ bản</th>
                        <th scope="col">Phí theo cân nặng</th>
                        <th scope="col">Phí theo khoảng cách</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                    <tr>
                        <td>{{ $fee->province_name }} ({{ $fee->province_code }})</td>
                        <td>{{ number_format($fee->base_fee) }}đ</td>
                        <td>{{ number_format($fee->weight_fee) }}đ</td>
                        <td>{{ number_format($fee->distance_fee) }}đ</td>
                        <td>{{ $fee->note }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-phoenix-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editFeeModal{{ $fee->id }}">
                                    Sửa
                                </button>
                                <button class="btn btn-sm btn-phoenix-secondary text-danger"
                                        onclick="deleteFee({{ $fee->id }})">
                                    Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <input type="number" class="form-control" name="base_fee" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo cân nặng</label>
                        <input type="number" class="form-control" name="weight_fee" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo khoảng cách</label>
                        <input type="number" class="form-control" name="distance_fee" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="note"></textarea>
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
                        <input type="text" class="form-control" name="province_code" value="{{ $fee->province_code }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên tỉnh/thành</label>
                        <input type="text" class="form-control" name="province_name" value="{{ $fee->province_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí cơ bản</label>
                        <input type="number" class="form-control" name="base_fee" value="{{ $fee->base_fee }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo cân nặng</label>
                        <input type="number" class="form-control" name="weight_fee" value="{{ $fee->weight_fee }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phí theo khoảng cách</label>
                        <input type="number" class="form-control" name="distance_fee" value="{{ $fee->distance_fee }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="note">{{ $fee->note }}</textarea>
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
                  location.reload();
              } else {
                  alert('Có lỗi xảy ra');
              }
          });
    }
}
</script>
@endpush

@endsection
