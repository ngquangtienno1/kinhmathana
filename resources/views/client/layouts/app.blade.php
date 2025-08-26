<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

<!-- Mirrored from neoocular.qodeinteractive.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Jun 2025 12:07:11 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@include('client.components.head')

<style>
    .alert {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        opacity: 1;
        transform: translateX(0);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .alert.alert-success {
        background: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .alert.alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }

    .alert.alert-warning {
        background: #fff3cd;
        color: #856404;
        border-color: #ffeaa7;
    }

    .alert.alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border-color: #bee5eb;
    }

    .alert.fade-out {
        opacity: 0;
        transform: translateX(100%);
    }

    .alert .close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        line-height: 1;
        opacity: 0.7;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alert .close:hover {
        opacity: 1;
    }
</style>

<body
    class="wp-singular product-template-default single single-product postid-607 wp-theme-neoocular theme-neoocular qode-framework-1.2.3 woocommerce woocommerce-page woocommerce-no-js qodef-back-to-top--enabled qodef-custom-blog  qodef-header--standard qodef-header-appearance--sticky qodef-mobile-header--standard qodef-drop-down-second--full-width qodef-drop-down-second--default qodef-yith-wccl--predefined qodef-yith-wcqv--predefined qodef-yith-wcwl--predefined neoocular-core-1.1 neoocular-membership-1.0 qode-quick-view-for-woocommerce-1.0.4 qqvfw--no-touch qode-variation-swatches-for-woocommerce-1.0.3 qvsfw--no-touch qode-wishlist-for-woocommerce-1.2 qwfw--no-touch qode-variation-swatches-for-woocommerce-premium-1.0.3 neoocular-1.1 qodef-content-grid-1400 qvsfw-disabled-attribute--crossed-out qodef-header-standard--center qodef-search--covers-header elementor-default elementor-kit-6"
    itemscope itemtype="https://schema.org/WebPage">
    <a class="skip-link screen-reader-text" href="#qodef-page-content">Skip to the content</a>
    <div id="qodef-page-wrapper" class="">
        @include('client.components.header')

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success" id="alert-success">
                {{ session('success') }}
                <button type="button" class="close" onclick="hideAlert(this.parentElement)">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" id="alert-error">
                {{ session('error') }}
                <button type="button" class="close" onclick="hideAlert(this.parentElement)">&times;</button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning" id="alert-warning">
                {{ session('warning') }}
                <button type="button" class="close" onclick="hideAlert(this.parentElement)">&times;</button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info" id="alert-info">
                {{ session('info') }}
                <button type="button" class="close" onclick="hideAlert(this.parentElement)">&times;</button>
            </div>
        @endif

        @yield('content')
        @include('client.components.footer')

        @include('client.components.support-chat')
        @include('client.components.chat')
        @include('client.components.ai-chat')
    </div>
    @include('client.components.script')
    @stack('scripts')
    <script>
        // Hàm ẩn thông báo với hiệu ứng fade
        function hideAlert(alertElement) {
            if (alertElement) {
                alertElement.classList.add('fade-out');
                setTimeout(function() {
                    if (alertElement.parentNode) {
                        alertElement.parentNode.removeChild(alertElement);
                    }
                }, 300);
            }
        }

        // Hàm tự động ẩn thông báo sau thời gian nhất định
        function autoHideAlert(alertElement, duration = 3000) {
            if (alertElement) {
                setTimeout(function() {
                    hideAlert(alertElement);
                }, duration);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý tất cả các thông báo
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Không tự động ẩn các alert có class cart-alert hoặc chứa thông báo hết hàng
                if (!alert.classList.contains('cart-alert') && 
                    !alert.textContent.includes('hết hàng') && 
                    !alert.textContent.includes('Hết hàng') &&
                    !alert.textContent.includes('Không thể đặt hàng')) {
                    // Tự động ẩn sau 3 giây chỉ cho các alert thông thường
                    autoHideAlert(alert, 3000);
                }

                // Thêm sự kiện click để ẩn thủ công
                alert.addEventListener('click', function(e) {
                    if (e.target.classList.contains('close')) {
                        hideAlert(this);
                    }
                });
            });

            // Polling kiểm tra trạng thái user mỗi 10s
            function pollUserStatus() {
                fetch('/client/user-status', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                       if (data.status === 'blocked') {
    window.location.href = '/client/logout?blocked=1';
}
                    })
                    .catch(function() {});
            }
            setInterval(pollUserStatus, 5000);
        });
    </script>
</body>

</html>