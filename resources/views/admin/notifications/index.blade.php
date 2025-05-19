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

@forelse($notifications as $date => $dateNotifications)
    <h5 class="text-body-emphasis mb-3">
        @if ($date == now()->format('Y-m-d'))
            Hôm nay
        @elseif($date == now()->subDay()->format('Y-m-d'))
            Hôm qua
        @else
            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        @endif
    </h5>

    <div class="mx-n4 mx-lg-n6 mb-5 border-bottom">
        @foreach ($dateNotifications as $notification)
            <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top {{ $notification->is_read ? 'read' : 'unread' }}"
                data-notification-id="{{ $notification->id }}">
                <div class="d-flex position-relative">
                    <div class="avatar avatar-xl me-3 position-relative">
                        @if (!$notification->is_read)
                            <span class="unread-dot"></span>
                        @endif
                        @switch($notification->type)
                            @case('order_new')
                                <div class="avatar-name rounded-circle bg-success"><span>🛒</span></div>
                            @break

                            @case('order_status')
                                <div class="avatar-name rounded-circle bg-info"><span>📦</span></div>
                            @break

                            @case('stock_alert')
                                <div class="avatar-name rounded-circle bg-warning"><span>⚠️</span></div>
                            @break

                            @case('promotion')
                                <div class="avatar-name rounded-circle bg-danger"><span>🎉</span></div>
                            @break

                            @case('order_cancelled')
                                <div class="avatar-name rounded-circle bg-secondary"><span>❌</span></div>
                            @break

                            @case('monthly_report')
                                <div class="avatar-name rounded-circle bg-primary"><span>📊</span></div>
                            @break

                            @default
                                <div class="avatar-name rounded-circle"><span>📢</span></div>
                        @endswitch
                    </div>
                    <div class="me-3 flex-1 mt-2">
                        <h4 class="fs-9 text-body-emphasis">{{ $notification->title }}</h4>
                        <p class="fs-9 text-body-highlight">
                            {!! $notification->content !!}
                            <span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10">
                                {{ $notification->time_ago }}
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
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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
                // Đánh dấu từng cái
                $('.mark-as-read').click(function(e) {
                    e.preventDefault();
                    const card = $(this).closest('.notification-card');
                    const id = card.data('notification-id');
                    $.ajax({
                        url: `/admin/notifications/${id}/mark-as-read`,
                        method: 'POST',
                        success: function() {
                            card.removeClass('unread').addClass('read');
                            card.find('.mark-as-read').parent().remove();
                            card.find('.unread-dot').remove();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
