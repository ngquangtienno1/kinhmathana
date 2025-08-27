@extends('client.layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">Mã giảm giá</h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                        <a itemprop="url" class="qodef-breadcrumbs-link" href="{{ route('client.home') }}"><span
                                itemprop="title">Home</span></a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Mã giảm giá</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- Banner ảnh giữ nguyên như cũ --}}
        <div data-elementor-type="wp-page" data-elementor-id="3964" class="elementor elementor-3964">
            <section
                class="elementor-section elementor-top-section elementor-element elementor-element-b38fcf2 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                data-id="b38fcf2" data-element_type="section"
                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                <div class="elementor-container elementor-column-gap-default">
                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-ad7d6ff"
                        data-id="ad7d6ff" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-d1cda19 elementor-widget elementor-widget-neoocular_core_custom_font"
                                data-id="d1cda19" data-element_type="widget"
                                data-widget_type="neoocular_core_custom_font.default">
                                <div class="elementor-widget-container">
                                    <h5 class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-605 qodef-layout--simple"
                                        style="color: #FFFFFF">FREE GIFT BAG -</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-b158005"
                        data-id="b158005" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-49e8d16 elementor-widget elementor-widget-neoocular_core_custom_font"
                                data-id="49e8d16" data-element_type="widget"
                                data-widget_type="neoocular_core_custom_font.default">
                                <div class="elementor-widget-container">
                                    <p class="qodef-shortcode qodef-m  qodef-custom-font qodef-custom-font-822 qodef-layout--simple"
                                        style="color: #FFFFFF;font-family: Heebo">With every frame</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section
                class="elementor-section elementor-top-section elementor-element elementor-element-6afec47 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                data-id="6afec47" data-element_type="section">
                <div class="elementor-container elementor-column-gap-default">
                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-0327199"
                        data-id="0327199" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-34d50d1 elementor-widget elementor-widget-neoocular_core_single_image"
                                data-id="34d50d1" data-element_type="widget"
                                data-widget_type="neoocular_core_single_image.default">
                                <div class="elementor-widget-container">
                                    <div class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                        <div class="qodef-m-image">
                                            <a itemprop="url" href="../product/way-glasses/index.html" target="_self">
                                                <img fetchpriority="high" fetchpriority="high" decoding="async"
                                                    width="900" height="593"
                                                    src="{{ asset('v1/wp-content/uploads/2021/08/voucher-01-img.jpg') }}"
                                                    class="attachment-full size-full qodef-list-image" alt="m"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img.jpg 900w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-600x395.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-800x527.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-300x198.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-01-img-768x506.jpg 768w"
                                                    sizes="(max-width: 900px) 100vw, 900px" /> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-3a43075"
                        data-id="3a43075" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-b2b3f48 elementor-widget elementor-widget-neoocular_core_single_image"
                                data-id="b2b3f48" data-element_type="widget"
                                data-widget_type="neoocular_core_single_image.default">
                                <div class="elementor-widget-container">
                                    <div class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                        <div class="qodef-m-image">
                                            <a itemprop="url" href="../shop/index.html" target="_self">
                                                <img decoding="async" width="900" height="593"
                                                    src="../wp-content/uploads/2021/08/voucher-img-02.jpg"
                                                    class="attachment-full size-full qodef-list-image" alt="m"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02.jpg 900w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-600x395.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-800x527.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-300x198.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-02-768x506.jpg 768w"
                                                    sizes="(max-width: 900px) 100vw, 900px" /> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-8991627"
                        data-id="8991627" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-0fe844c elementor-widget elementor-widget-neoocular_core_single_image"
                                data-id="0fe844c" data-element_type="widget"
                                data-widget_type="neoocular_core_single_image.default">
                                <div class="elementor-widget-container">
                                    <div class="qodef-shortcode qodef-m  qodef-single-image qodef-layout--default   ">
                                        <div class="qodef-m-image">
                                            <a itemprop="url" href="../variable-product-list/index.html" target="_self">
                                                <img decoding="async" width="900" height="593"
                                                    src="../wp-content/uploads/2021/08/voucher-img-03.jpg"
                                                    class="attachment-full size-full qodef-list-image" alt="m"
                                                    srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03.jpg 900w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-600x395.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-800x527.jpg 800w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-300x198.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/08/voucher-img-03-768x506.jpg 768w"
                                                    sizes="(max-width: 900px) 100vw, 900px" /> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- Lưới voucher vuông --}}
        <div class="qodef-content-grid">
            <style>
                .btn.btn-dark {
                    background: #111;
                    color: #fff;
                    border: none;
                    border-radius: 6px;
                    padding: 8px 16px;
                    font-weight: 600;
                    font-size: 0.9em;
                    font-family: Inter, sans-serif;
                    transition: background 0.2s;
                }

                .btn.btn-dark:hover {
                    background: #333;
                }

                .card-title {
                    font-weight: 600;
                    color: #111;
                    font-size: 1.1em;
                    font-family: Inter, sans-serif;
                }

                .card-text {
                    color: #666;
                    font-size: 0.9em;
                    line-height: 1.4;
                    font-family: Inter, sans-serif;
                }

                .text-muted {
                    color: #666 !important;
                    font-family: Inter, sans-serif;
                }

                .text-danger {
                    color: #e74c3c !important;
                    font-family: Inter, sans-serif;
                }

                .text-success {
                    color: #27ae60 !important;
                    font-family: Inter, sans-serif;
                }

                .alert {
                    font-family: Inter, sans-serif;
                }

                .card {
                    font-family: Inter, sans-serif;
                }
            </style>

            <div class="row">
                @if($vouchers->count() > 0)
                    <div class="col-12 mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Hiển thị các mã giảm giá còn hiệu lực và còn lượt sử dụng
                        </div>
                    </div>
                @endif
                @forelse($vouchers as $voucher)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $voucher->name }}</h5>
                                <p class="card-text text-muted small">{{ $voucher->description }}</p>
                                
                                <div class="mb-2">
                                    <strong>Giảm: 
                                        @if ($voucher->discount_type === 'percentage')
                                            {{ number_format($voucher->discount_value, 0, ',', '.') }}%
                                        @else
                                            {{ number_format($voucher->discount_value, 0, ',', '.') }}₫
                                        @endif
                                    </strong>
                                </div>
                                
                                <div class="small text-muted mb-1">
                                    Đơn tối thiểu: {{ number_format($voucher->minimum_purchase, 0, ',', '.') }}₫
                                </div>
                                <div class="small text-muted mb-1">
                                    HSD: {{ $voucher->end_date->format('d/m/Y') }}
                                </div>
                                <div class="small text-muted mb-2">
                                    @if($voucher->usage_limit)
                                        Còn lại: {{ $voucher->usage_limit - $voucher->used_count }} lượt
                                    @else
                                        Không giới hạn lượt dùng
                                    @endif
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="voucher-countdown text-danger small" data-end="{{ $voucher->end_date->format('Y-m-d h:i:s A') }}"></div>
                                        <button class="btn btn-dark btn-sm copy-voucher-btn" data-code="{{ $voucher->code }}">
                                            Sao chép mã
                                        </button>
                                    </div>
                                    <div class="copy-success-msg text-success small mt-1" style="display: none;">Đã sao chép!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Hiện không có mã giảm giá nào.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Countdown timer
            function updateCountdown() {
                document.querySelectorAll('.voucher-countdown').forEach(function(element) {
                    var endDate = element.getAttribute('data-end');
                    if (!endDate) return;
                    
                    // Parse date with AM/PM format
                    var date = new Date(endDate);
                    var now = new Date();
                    var diff = date - now;
                    
                    if (diff <= 0) {
                        element.innerHTML = 'Đã hết hạn';
                        element.style.color = '#999';
                        return;
                    }
                    
                    var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    var timeString = '';
                    if (days > 0) timeString += days + ' ngày ';
                    if (hours > 0) timeString += hours + ' giờ ';
                    if (minutes > 0) timeString += minutes + ' phút ';
                    timeString += seconds + ' giây';
                    
                    element.innerHTML = timeString;
                });
            }
            
            // Update countdown every second
            updateCountdown();
            setInterval(updateCountdown, 1000);

            // Tạo sẵn div chứa flash message nếu chưa có
            if (!document.getElementById('js-flash-message')) {
                var flashDiv = document.createElement('div');
                flashDiv.id = 'js-flash-message';
                document.body.appendChild(flashDiv);
            }

            function showFlashMessage(message, type = 'success') {
                var flashDiv = document.getElementById('js-flash-message');
                flashDiv.innerHTML = `<div class="alert alert-${type}"
            style="position: fixed; top: 100px; right: 20px; z-index: 9999; background: ${type === 'success' ? '#d4edda' : '#f8d7da'}; color: ${type === 'success' ? '#155724' : '#721c24'}; padding: 15px; border-radius: 5px; border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'}; min-width: 220px;">
            ${message}
            <button type="button" class="close" onclick="this.parentElement.style.display='none'"
                style="background: none; border: none; font-size: 20px; margin-left: 10px; cursor: pointer;">&times;</button>
        </div>`;
                setTimeout(function() {
                    if (flashDiv.firstChild) {
                        flashDiv.firstChild.style.display = 'none';
                    }
                }, 1800);
            }
            document.querySelectorAll('.copy-voucher-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var code = btn.getAttribute('data-code');
                    // Copy to clipboard
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(code);
                    } else {
                        var textarea = document.createElement('textarea');
                        textarea.value = code;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }
                    // Hiện thông báo flash giống layout
                    showFlashMessage('Sao chép mã thành công!', 'success');
                });
            });
        });
    </script>
@endpush
