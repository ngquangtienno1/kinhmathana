@extends('client.layouts.app')

@section('content')
    <section class="pt-5 pb-9">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h1 class="fw-bold mb-3">{{ $news->title }}</h1>
                        <div class="d-flex align-items-center mb-3 text-muted small">
                            <span class="me-3"><i class="fas fa-calendar-alt me-1"></i>
                                {{ $news->published_at ? $news->published_at->format('d/m/Y') : '' }}</span>
                            <span class="me-3"><i class="fas fa-user me-1"></i>
                                {{ $news->author->name ?? 'Unknown' }}</span>
                            @if ($news->category)
                                <span class="badge bg-secondary me-3">{{ $news->category->name }}</span>
                            @endif
                            <span><i class="fas fa-eye me-1"></i> {{ $news->views }} lượt xem</span>
                        </div>
                    </div>
                    @if ($news->image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif
                    <div class="mb-4 fs-5 lh-lg text-body">
                        {!! $news->content !!}
                    </div>
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4">Bài viết xem nhiều</h3>
                        <div class="swiper most-viewed-swiper" style="padding-bottom: 32px;">
                            <div class="swiper-wrapper">
                                @foreach ($mostViewed as $item)
                                    <div class="swiper-slide" style="max-width:220px;">
                                        <a href="{{ route('client.blog.show', $item->slug) }}"
                                            class="text-decoration-none text-reset">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x300?text=Blog+Image' }}"
                                                    class="card-img-top" alt="{{ $item->title }}"
                                                    style="height:140px; object-fit:cover;">
                                                <div class="card-body p-2">
                                                    <div class="small text-muted mb-1">
                                                        {{ $item->published_at ? $item->published_at->format('d/m/Y') : '' }}
                                                    </div>
                                                    <div class="fw-semibold line-clamp-2" style="font-size:15px;">
                                                        {{ $item->title }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination mt-2"></div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <h3 class="fw-bold mb-3">Bình Luận</h3>
                        <div class="mb-4">
                            <form method="POST" action="{{ route('client.blog.comment', $news->slug) }}"
                                id="comment-form">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="content" rows="4" placeholder="Nhập bình luận..."></textarea>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4"><input type="text" class="form-control" name="name"
                                            placeholder="Nhập tên*" required></div>
                                    <div class="col-md-4"><input type="email" class="form-control" name="email"
                                            placeholder="admin@gmail.com" required></div>
                                    <div class="col-md-4"><input type="text" class="form-control" name="website"
                                            placeholder="Website"></div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="saveInfo">
                                    <label class="form-check-label small" for="saveInfo">Lưu tên của tôi, email, và trang
                                        web trong
                                        trình duyệt này cho lần bình luận kế tiếp của tôi.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Bình luận</button>
                            </form>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif
                        <div class="mt-4">
                            @forelse($comments as $comment)
                                <div class="mb-4 border-bottom pb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="fw-bold me-2">{{ $comment->user->name ?? 'Ẩn danh' }}</span>
                                        <span
                                            class="text-muted small">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="mb-2">{!! nl2br(e($comment->content)) !!}</div>
                                    @if ($comment->replies->count())
                                        <div class="ms-4 border-start ps-3">
                                            @foreach ($comment->replies as $reply)
                                                <div class="mb-2">
                                                    <span
                                                        class="fw-semibold text-primary">{{ $reply->user->name ?? 'Ẩn danh' }}:</span>
                                                    <span>{!! nl2br(e($reply->content)) !!}</span>
                                                    <span
                                                        class="text-muted small ms-2">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-muted">Chưa có bình luận nào.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.most-viewed-swiper', {
                slidesPerView: 2,
                spaceBetween: 16,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3
                    },
                    992: {
                        slidesPerView: 4
                    },
                    1200: {
                        slidesPerView: 4
                    },
                },
            });
        });
    </script>
    <style>
        .most-viewed-swiper .swiper-pagination {
            position: static !important;
            margin-top: 8px;
            text-align: center;
        }
    </style>
@endpush
