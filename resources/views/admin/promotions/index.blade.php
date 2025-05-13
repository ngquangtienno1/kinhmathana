@extends('admin.layouts')

@section('title', 'Manage Promotions')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Promotions</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Promotions</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Promotion
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Tên khuyến mãi</th>
                                <th>Mã code</th>
                                <th>Giảm giá</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Lượt dùng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promotions as $promotion)
                                <tr>
                                    <td>{{ $promotion->id }}</td>
                                    <td>{{ $promotion->name }}</td>
                                    <td>
                                        <code>{{ $promotion->code }}</code>
                                    </td>
                                    <td>
                                        @if($promotion->discount_type === 'percentage')
                                            {{ $promotion->discount_value }}%
                                        @else
                                            {{ number_format($promotion->discount_value, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($promotion->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $promotion->start_date->format('d/m/Y') }} - {{ $promotion->end_date->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $promotion->used_count }}
                                        @if($promotion->usage_limit)
                                            / {{ $promotion->usage_limit }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.promotions.show', $promotion) }}" class="btn btn-info btn-sm" title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-primary btn-sm" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này?')" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Không có khuyến mãi nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $promotions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 