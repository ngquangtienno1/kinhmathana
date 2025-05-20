@extends('admin.layouts')

@section('title', 'Quản lý đánh giá sản phẩm')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách đánh giá sản phẩm</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">
                                        <input type="checkbox" id="check-all">
                                    </th>
                                    <th>Sản phẩm</th>
                                    <th>Người đánh giá</th>
                                    <th>Đánh giá</th>
                                    <th>Nội dung</th>
                                    <th>Ngày đánh giá</th>
                                    <th style="width: 150px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item" value="{{ $review->id }}">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $review->product_id) }}">
                                            {{ $review->product->name }}
                                        </a>
                                    </td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($review->content, 100) }}</td>
                                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.reviews.show', $review->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Xử lý check all
    $('#check-all').change(function() {
        $('.checkbox-item').prop('checked', $(this).prop('checked'));
    });

    // Xóa nhiều
    $('.btn-bulk-delete').click(function() {
        if(confirm('Bạn có chắc chắn muốn xóa các mục đã chọn?')) {
            let ids = [];
            $('.checkbox-item:checked').each(function() {
                ids.push($(this).val());
            });

            if(ids.length === 0) {
                alert('Vui lòng chọn ít nhất một mục để xóa');
                return;
            }

            $.ajax({
                url: '{{ route("admin.reviews.bulk-delete") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                }
            });
        }
    });
});
</script>
@endpush
@endsection 