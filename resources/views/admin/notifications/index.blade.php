@extends('admin.layouts')
@section('title', 'Thông báo')
@section('content')
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thông báo</a>
    </li>
    <li class="breadcrumb-item active">Danh sách thông báo</li>
@endsection

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Thông báo</h2>
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
                    <li><a class="dropdown-item" href="{{ route('admin.notifications.test.new-order') }}">Test Đơn hàng
                            mới</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.notifications.test.order-status') }}">Test Cập
                            nhật trạng thái</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.notifications.test.stock-alert') }}">Test Cảnh
                            báo kho</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.notifications.test.promotion') }}">Test Khuyến
                            mãi mới</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.notifications.test.order-cancelled') }}">Test Hủy
                            đơn hàng</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.notifications.test.monthly-report') }}">Test Báo
                            cáo tháng</a></li>
                </ul>
            </div>
        @endif
    </div>
</div>

{{-- Bộ lọc loại thông báo dạng dropdown --}}
<div class="mb-3">
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="notificationTypeDropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
            {{ $type == 'all'
                ? 'Tất cả'
                : [
                        'order_new' => 'Đơn hàng mới',
                        'order_status' => 'Trạng thái đơn hàng',
                        'stock_alert' => 'Cảnh báo kho',
                        'promotion' => 'Khuyến mãi',
                        'order_cancelled' => 'Đơn hàng bị huỷ',
                        'monthly_report' => 'Báo cáo tháng',
                        'slider' => 'Slider',
                    ][$type] ?? $type }}
            @if ($type == 'all')
                ({{ $totalCount }})
            @elseif(isset($typeCounts[$type]))
                ({{ $typeCounts[$type] }})
            @endif
        </button>
        <ul class="dropdown-menu" aria-labelledby="notificationTypeDropdown">
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
                        ][$t] ?? $t }}
                        ({{ $count }})
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@forelse($notifications as $notification)
    <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top {{ $notification->is_read ? 'read' : 'unread' }}"
        data-notification-id="{{ $notification->id }}">
        <div class="d-flex position-relative">
            <div class="avatar avatar-xl me-3 position-relative">
                @if (!$notification->is_read)
                    <span class="unread-dot"></span>
                @endif
                <span class="avatar-name rounded-circle bg-warning d-flex align-items-center justify-content-center"
                    style="width:48px;height:48px;font-size:28px;">🔔</span>
            </div>
            <div class="me-3 flex-1 mt-2">
                <h4 class="fs-9 text-body-emphasis">{{ $notification->title }}</h4>
                <p class="fs-9 text-body-highlight">
                    {!! $notification->content !!}
                    <span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10">
                        {{ $notification->created_at ? $notification->created_at->diffForHumans() : '' }}
                    </span>
                </p>
            </div>
        </div>
        <div class="dropdown">
            <button
                class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle"
                type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                aria-expanded="false" data-bs-reference="parent">
                <span class="fas fa-ellipsis-h fs-10 text-body"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end py-2">
                @if (!$notification->is_read)
                    <a class="dropdown-item mark-as-read" href="#">Đánh dấu đã đọc</a>
                @else
                    <a class="dropdown-item mark-as-unread" href="#">Đánh dấu là chưa đọc</a>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5">
        <p class="text-muted">Không có thông báo nào</p>
    </div>
@endforelse

@push('styles')
    <style>
        .notification-card.unread {
            background-color: #e9ecef !important;
        }

        .notification-card.read {
            background-color: #fff;
            transition: background 0.3s;
        }

        .unread-dot {
            position: absolute;
            left: -2px;
            top: -2px;
            width: 15px;
            height: 15px;
            background: #0866ff;
            border-radius: 50%;
            border: 2.5px solid #fff;
            box-shadow: 0 0 0 2px #888888;
            z-index: 2;
        }
    </style>
@endpush

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
                        $('.mark-as-read').parent().remove();
                        $('.unread-dot').remove();
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
                        card.find('.unread-dot').remove();
                        // Thay thế dropdown thành nút mark-as-unread
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
                        // Thay thế dropdown thành nút mark-as-read
                        card.find('.dropdown-menu').html(
                            '<a class="dropdown-item mark-as-read" href="#">Đánh dấu đã đọc</a>'
                        );
                        if (card.find('.unread-dot').length === 0) {
                            card.find('.avatar').prepend('<span class="unread-dot"></span>');
                        }
                    }
                });
            });
        });
    </script>
@endpush
@endsection
