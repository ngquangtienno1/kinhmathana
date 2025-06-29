@extends('client.layouts.app')
@section('title', 'Đánh giá sản phẩm')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Đánh Giá Sản Phẩm</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $item->product->images->first() ? asset('storage/'.$item->product->images->first()->image_path) : '/assets/img/products/1.png' }}" width="70" class="rounded border me-3">
                        <div>
                            <div class="fw-bold">{{ $item->product_name }}</div>
                            <div class="text-muted small">
                                @if($item->product->brand) {{ $item->product->brand->name }} | @endif
                                @if($item->product->categories->first()) {{ $item->product->categories->first()->name }} | @endif
                                @if($item->product_options)
                                    @php $opts = json_decode($item->product_options, true); @endphp
                                    @if(isset($opts['color'])) Màu: {{ $opts['color'] }} @endif
                                    @if(isset($opts['size'])) - Size: {{ $opts['size'] }} @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('client.orders.review.submit', [$order->id, $item->id]) }}" method="POST" enctype="multipart/form-data" id="review-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Chất lượng sản phẩm</label>
                            <div id="star-rating" class="mb-1">
                                @for($i=1;$i<=5;$i++)
                                    <span class="star fs-3" data-value="{{ $i }}">&#9733;</span>
                                @endfor
                                <input type="hidden" name="rating" id="rating" value="5">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung đánh giá</label>
                            <textarea name="content" id="content" class="form-control" rows="4" maxlength="1000" oninput="updateCharCount()" required></textarea>
                            <div class="text-end small text-muted mt-1"><span id="char-count">0</span>/1000 ký tự</div>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Thêm hình ảnh (tối đa 5 ảnh)</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" onchange="previewImages()" max="5">
                            <div class="d-flex flex-wrap mt-2" id="image-preview"></div>
                        </div>
                        <div class="mb-3">
                            <label for="video" class="form-label">Thêm video (tối đa 1 video, dung lượng tối đa 50MB)</label>
                            <input type="file" name="video" id="video" class="form-control" accept="video/*" onchange="previewVideo(); checkVideoSize();">
                            <div class="text-danger small mt-1" id="video-size-warning" style="display:none;">Video vượt quá dung lượng cho phép (50MB).</div>
                            <div class="mt-2" id="video-preview"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-secondary">Trở lại</a>
                            <button type="submit" class="btn btn-primary px-4">Hoàn thành</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .star {
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .star.selected, .star:hover, .star:hover ~ .star {
        color: #f39c12;
    }
    #image-preview img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-right: 8px;
        margin-bottom: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    #video-preview video {
        width: 120px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
</style>
<script>
    // Star rating
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
    // Char count
    function updateCharCount() {
        document.getElementById('char-count').innerText = document.getElementById('content').value.length;
    }
    // Preview images
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
    // Preview video
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