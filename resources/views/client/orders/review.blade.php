@extends('client.layouts.app')
@section('title', 'Đánh giá sản phẩm')
@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">Đánh giá sản phẩm</h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                        <a itemprop="url" class="qodef-breadcrumbs-link" href="/">
                            <span itemprop="title">Trang chủ</span>
                        </a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Đánh giá sản phẩm</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-4 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
            <div class="order-card mb-4 shadow-sm border rounded-0" style="max-width: 700px; width: 100%;">
                <div class="order-products bg-white p-4 rounded-0">
                    <div class="mb-4 d-flex align-items-start gap-3">
                        @php
                            $product = $item->variation ? $item->variation->product : $item->product ?? null;
                            if ($item->variation && $item->variation->images->count()) {
                                $featuredImage =
                                    $item->variation->images->where('is_featured', true)->first() ??
                                    $item->variation->images->first();
                            } else {
                                $featuredImage =
                                    $product && isset($product->images)
                                        ? $product->images->where('is_featured', true)->first() ??
                                            $product->images->first()
                                        : null;
                            }
                            $imagePath = $featuredImage
                                ? asset('storage/' . $featuredImage->image_path)
                                : asset('/assets/img/products/1.png');
                        @endphp
                        <img src="{{ $imagePath }}" alt="{{ $product->name ?? 'Sản phẩm đã xóa' }}"
                            style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $item->product_name }}</div>
                            <div class="text-muted small mt-1">
                                @if ($item->product_options)
                                    @php $opts = json_decode($item->product_options, true); @endphp
                                    @if (!empty($opts['sku']))
                                        Mã SP: {{ $opts['sku'] }} |
                                    @endif
                                    @if (!empty($opts['color']))
                                        Màu: {{ $opts['color'] }}
                                    @endif
                                    @if (!empty($opts['size']))
                                        | Size: {{ $opts['size'] }}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('client.orders.review.submit', [$order->id, $item->id]) }}" method="POST"
                        enctype="multipart/form-data" id="review-form">
                        @csrf
                        <div class="border p-4 rounded-0" style="background: #fff;">
                            <h5 class="fw-semibold mb-3">Đánh giá sản phẩm</h5>
                            <div class="mb-3">
                                <label class="form-label">Chất lượng sản phẩm</label>
                                <div id="star-rating" class="mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star fs-3" data-value="{{ $i }}">&#9733;</span>
                                    @endfor
                                    <input type="hidden" name="rating" id="rating" value="5">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung đánh giá</label>
                                <textarea name="content" id="content" class="form-control rounded-0" rows="4" maxlength="1000"
                                    oninput="updateCharCount()" required></textarea>
                                <div class="text-end small text-muted mt-1"><span id="char-count">0</span>/1000 ký tự</div>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Thêm hình ảnh (tối đa 5 ảnh)</label>
                                <input type="file" name="images[]" id="images" class="form-control rounded-0" multiple
                                    accept="image/*" onchange="previewImages()">
                                <div class="d-flex flex-wrap mt-2 gap-2" id="image-preview"></div>
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label">Thêm video (tối đa 1 video, dung lượng tối đa
                                    50MB)</label>
                                <input type="file" name="video" id="video" class="form-control rounded-0"
                                    accept="video/*" onchange="previewVideo(); checkVideoSize();">
                                <div class="text-danger small mt-1" id="video-size-warning" style="display:none;">Video vượt
                                    quá dung lượng cho phép (50MB).</div>
                                <div class="mt-2" id="video-preview"></div>
                            </div>
                            <div class="mt-4 d-flex gap-2 justify-content-end align-items-center">
                                <a href="{{ route('client.orders.show', $order->id) }}"
                                    class="btn btn-secondary rounded-0 py-2 px-4">Trở lại</a>
                                <button type="submit" class="btn btn-dark rounded-0 py-2 px-4">Gửi đánh giá</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .star {
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star.selected,
        .star:hover,
        .star:hover~.star {
            color: #f39c12;
        }

        #image-preview img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        #video-preview video {
            width: 120px;
            border: 1px solid #ccc;
        }

        #star-rating {
            font-size: 0;
        }

        #star-rating .star {
            font-size: 2rem;
            /* hoặc giá trị bạn muốn */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.star').forEach(function(star) {
                star.addEventListener('click', function() {
                    let value = this.getAttribute('data-value');
                    document.getElementById('rating').value = value;
                    document.querySelectorAll('.star').forEach(function(s, idx) {
                        s.classList.toggle('selected', idx < value);
                    });
                });
            });
        });

        function updateCharCount() {
            document.getElementById('char-count').innerText = document.getElementById('content').value.length;
        }

        function previewImages() {
            let preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            let files = document.getElementById('images').files;
            for (let i = 0; i < files.length && i < 5; i++) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                }
                reader.readAsDataURL(files[i]);
            }
        }

        function previewVideo() {
            let preview = document.getElementById('video-preview');
            preview.innerHTML = '';
            let file = document.getElementById('video').files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let video = document.createElement('video');
                    video.src = e.target.result;
                    video.controls = true;
                    preview.appendChild(video);
                }
                reader.readAsDataURL(file);
            }
        }

        function checkVideoSize() {
            let file = document.getElementById('video').files[0];
            let warning = document.getElementById('video-size-warning');
            if (file && file.size > 50 * 1024 * 1024) {
                warning.style.display = 'block';
                document.getElementById('video').value = '';
                document.getElementById('video-preview').innerHTML = '';
            } else {
                warning.style.display = 'none';
            }
        }
    </script>
@endsection
