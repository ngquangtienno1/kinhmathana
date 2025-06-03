@extends('admin.layouts')
@section('title', 'Thông báo')
@section('content')
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.notifications.index') }}">Thông báo</a>
    </li>
    <li class="breadcrumb-item active">Danh sách Thông báo</li>
@endsection

<div class="mb-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Danh sách Thông báo</h2>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm" id="markAllAsRead">
                Đánh dấu tất cả đã đọc
            </button>

            @if (app()->environment('local', 'development'))
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Test Thông báo
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.notifications.test.new-order') }}">Test Đơn
                                hàng
                                mới</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.notifications.test.order-status') }}">Test
                                Cập
                                nhật trạng thái</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.notifications.test.stock-alert') }}">Test
                                Cảnh
                                báo kho</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.notifications.test.promotion') }}">Test
                                Khuyến
                                mãi mới</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.notifications.test.order-cancelled') }}">Test
                                Hủy
                                đơn hàng</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.notifications.test.monthly-report') }}">Test
                                Báo
                                cáo tháng</a></li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Bộ lọc loại thông báo dạng dropdown --}}
    <div class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-0">
                    <div class="btn-group position-static text-nowrap" role="group">
                        <button class="btn btn-phoenix-secondary px-7 py-2 border-end" type="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            data-bs-reference="parent" style="border-radius: 8px 0 0 8px; height: 40px;">
                            Loại thông báo <span class="fas fa-angle-down ms-2"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ $type == 'all' ? 'active' : '' }}"
                                    href="{{ route('admin.notifications.index', ['type' => 'all']) }}">
                                    Tất cả ({{ $totalCount }})
                                </a>
                            </li>
                            @foreach ($typeCounts as $t => $count)
                                <li>
                                    <a class="dropdown-item {{ $type == $t ? 'active' : '' }}"
                                        href="{{ route('admin.notifications.index', ['type' => $t]) }}">
                                        {{ [
                                            'order_new' => 'Đơn hàng mới',
                                            'order_status' => 'Trạng thái đơn hàng',
                                            'stock_alert' => 'Cảnh báo kho',
                                            'promotion' => 'Khuyến mãi',
                                            'order_cancelled' => 'Đơn hàng bị huỷ',
                                            'monthly_report' => 'Báo cáo tháng',
                                            'slider' => 'Slider',
                                            'product' => 'Sản phẩm mới',
                                        ][$t] ?? $t }}
                                        ({{ $count }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="align-middle text-center" style="width:40px;">STT</th>
                        <th class="align-middle text-center" style="width:56px;">&nbsp;</th>
                        <th class="align-middle">Tiêu đề</th>
                        <th class="align-middle">Nội dung</th>
                        <th class="align-middle">Loại</th>
                        <th class="align-middle">Thời gian</th>
                        <th class="align-middle">Trạng thái</th>
                        <th class="align-middle text-end" style="width:80px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $i => $notification)
                        <tr class="notification-card {{ $notification->is_read ? 'read' : 'unread' }}"
                            data-notification-id="{{ $notification->id }}">
                            <td class="align-middle text-center">{{ $i + 1 }}</td>
                            <td class="align-middle text-center">
                                <span
                                    class="avatar-name rounded-circle bg-warning d-flex align-items-center justify-content-center position-relative"
                                    style="width:38px;height:38px;font-size:20px;">
                                    🔔
                                    @if (!$notification->is_read)
                                        <span class="unread-dot"
                                            style="position:absolute;left:-4px;top:-4px;width:12px;height:12px;background:#0866ff;border-radius:50%;border:2px solid #fff;box-shadow:0 0 0 2px #888888;z-index:2;"></span>
                                    @endif
                                </span>
                            </td>
                            <td class="align-middle fw-semibold">{{ $notification->title }}</td>
                            <td class="align-middle">{!! Str::limit(strip_tags($notification->content), 60) !!}</td>
                            <td class="align-middle">
                                {{ [
                                    'order_new' => 'Đơn hàng mới',
                                    'order_status' => 'Trạng thái đơn hàng',
                                    'stock_alert' => 'Cảnh báo kho',
                                    'promotion' => 'Khuyến mãi',
                                    'order_cancelled' => 'Đơn hàng bị huỷ',
                                    'monthly_report' => 'Báo cáo tháng',
                                    'slider' => 'Slider',
                                ][$notification->type] ?? $notification->type }}
                            </td>
                            <td class="align-middle">
                                {{ $notification->created_at ? $notification->created_at->format('d/m/Y H:i') : '' }}
                            </td>
                            <td class="align-middle">
                                @if (!$notification->is_read)
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                @else
                                    <span class="badge bg-success">Đã đọc</span>
                                @endif
                            </td>
                            <td class="align-middle text-end">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                        aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        @if (!$notification->is_read)
                                            <a class="dropdown-item mark-as-read" href="#">Đánh dấu đã đọc</a>
                                        @else
                                            <a class="dropdown-item mark-as-unread" href="#">Đánh dấu là chưa
                                                đọc</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Không có thông báo nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Đánh dấu tất cả đã đọc
            $('#markAllAsRead').click(function() {
                $.ajax({
                    url: '{{ route('admin.notifications.mark-all-as-read') }}',
                    method: 'POST',
                    success: function() {
                        $('.notification-card').removeClass('unread').addClass('read');
                        $('.notification-card .badge').removeClass('bg-warning text-dark')
                            .addClass('bg-success').text('Đã đọc');
                        $('.notification-card .unread-dot').remove();
                        $('.notification-card .dropdown-menu').html(
                            '<a class="dropdown-item mark-as-unread" href="#">Đánh dấu là chưa đọc</a>'
                        );
                    }
                });
            });
            // Đánh dấu từng cái đã đọc
            $(document).on('click', '.mark-as-read', function(e) {
                e.preventDefault();
                const card = $(this).closest('.notification-card');
                const id = card.data('notification-id');
                $.ajax({
                    url: `/admin/notifications/${id}/mark-as-read`,
                    method: 'POST',
                    success: function() {
                        card.removeClass('unread').addClass('read');
                        card.find('.badge').removeClass('bg-warning text-dark').addClass(
                            'bg-success').text('Đã đọc');
                        card.find('.unread-dot').remove();
                        card.find('.dropdown-menu').html(
                            '<a class="dropdown-item mark-as-unread" href="#">Đánh dấu là chưa đọc</a>'
                        );
                    }
                });
            });
            // Đánh dấu từng cái là chưa đọc
            $(document).on('click', '.mark-as-unread', function(e) {
                e.preventDefault();
                const card = $(this).closest('.notification-card');
                const id = card.data('notification-id');
                $.ajax({
                    url: `/admin/notifications/${id}/mark-as-unread`,
                    method: 'POST',
                    success: function() {
                        card.removeClass('read').addClass('unread');
                        card.find('.badge').removeClass('bg-success').addClass(
                            'bg-warning text-dark').text('Chưa đọc');
                        // Thêm lại chấm xanh nếu chưa có
                        if (card.find('.unread-dot').length === 0) {
                            card.find('.avatar-name').append(
                                '<span class="unread-dot" style="position:absolute;left:-4px;top:-4px;width:12px;height:12px;background:#0866ff;border-radius:50%;border:2px solid #fff;box-shadow:0 0 0 2px #888888;z-index:2;"></span>'
                            );
                        }
                        card.find('.dropdown-menu').html(
                            '<a class="dropdown-item mark-as-read" href="#">Đánh dấu đã đọc</a>'
                        );
                    }
                });
            });
        });
    </script>
@endpush
@endsection
