@extends('admin.layouts')
@section('title', 'Quản lý đơn vị vận chuyển')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.settings.index') }}">Cài đặt</a>
</li>
<li class="breadcrumb-item active">Đơn vị vận chuyển</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý đơn vị vận chuyển</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="ms-xxl-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProviderModal">
                    <span class="fas fa-plus me-2"></span>Thêm đơn vị vận chuyển
                </button>
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th scope="col">Tên đơn vị</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thứ tự</th>
                        <th scope="col" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                    <tr>
                        <td>{{ $provider->name }}</td>
                        <td>{{ $provider->code }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    {{ $provider->is_active ? 'checked' : '' }}
                                    onchange="updateStatus({{ $provider->id }}, this.checked)">
                            </div>
                        </td>
                        <td>{{ $provider->sort_order }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.shipping.fees', $provider->id) }}"
                                   class="btn btn-sm btn-phoenix-secondary">
                                    Phí vận chuyển
                                </a>
                                <button class="btn btn-sm btn-phoenix-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editProviderModal{{ $provider->id }}">
                                    Sửa
                                </button>
                                <button class="btn btn-sm btn-phoenix-secondary text-danger"
                                        onclick="deleteProvider({{ $provider->id }})">
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
<div class="modal fade" id="addProviderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.shipping.providers.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm đơn vị vận chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên đơn vị</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo URL</label>
                        <input type="text" class="form-control" name="logo_url">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Key</label>
                        <input type="text" class="form-control" name="api_key">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Secret</label>
                        <input type="text" class="form-control" name="api_secret">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Endpoint</label>
                        <input type="text" class="form-control" name="api_endpoint">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control" name="sort_order" value="0">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
                        <label class="form-check-label">Kích hoạt</label>
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

@foreach($providers as $provider)
<!-- Modal chỉnh sửa -->
<div class="modal fade" id="editProviderModal{{ $provider->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.shipping.providers.update', $provider->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa đơn vị vận chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên đơn vị</label>
                        <input type="text" class="form-control" name="name" value="{{ $provider->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã</label>
                        <input type="text" class="form-control" name="code" value="{{ $provider->code }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description">{{ $provider->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo URL</label>
                        <input type="text" class="form-control" name="logo_url" value="{{ $provider->logo_url }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Key</label>
                        <input type="text" class="form-control" name="api_key" value="{{ $provider->api_key }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Secret</label>
                        <input type="text" class="form-control" name="api_secret" value="{{ $provider->api_secret }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Endpoint</label>
                        <input type="text" class="form-control" name="api_endpoint" value="{{ $provider->api_endpoint }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ $provider->sort_order }}">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1"
                            {{ $provider->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">Kích hoạt</label>
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
function updateStatus(id, status) {
    fetch(`/admin/shipping/providers/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ is_active: status })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              // Thành công
          } else {
              alert('Có lỗi xảy ra');
          }
      });
}

function deleteProvider(id) {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        fetch(`/admin/shipping/providers/${id}`, {
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
