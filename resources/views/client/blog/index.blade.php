@extends('client.layouts.app')

@section('content')
    <section class="pt-5 pb-9">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="letter-spacing: 1px;">Tất cả bài viết</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
                    </ol>
                </nav>
            </div>
            <div id="blog-list"
                data-list='{"valueNames":["title","summary","author","category","published_at"],"page":6,"pagination":true}'>
                <div class="row gx-4 gy-6 mb-8 list">
                    @forelse ($news as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <a href="{{ route('client.blog.show', $item->slug) }}" class="text-decoration-none text-reset">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/600x350?text=Blog+Image' }}"
                                        class="card-img-top" alt="{{ $item->title }}"
                                        style="height: 300px; object-fit: cover; width: 100%;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2 text-muted small">
                                            <span class="me-3 published_at"><i class="fas fa-calendar-alt me-1"></i>
                                                {{ $item->published_at ? $item->published_at->format('M d, Y') : '' }}</span>
                                            <span><i class="fas fa-eye me-1"></i> {{ $item->views }} lượt xem</span>
                                        </div>
                                        <h5 class="card-title fw-bold line-clamp-2 title">{{ $item->title }}</h5>
                                        <p class="card-text line-clamp-3 summary">{{ $item->summary }}</p>
                                        <div class="d-flex align-items-center mt-3">
                                            <span class="me-2 small author"><i class="fas fa-user"></i>
                                                {{ $item->author->name ?? 'Unknown' }}</span>
                                            @if ($item->category)
                                                <span
                                                    class="badge bg-secondary ms-2 category">{{ $item->category->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">No news found.</div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-end">
                    <ul class="pagination mb-0"></ul>
                </div>
            </div>
            <div class="text-center my-5">
                <h4 class="fw-bold mb-3">Nhận bài viết mới nhất được gửi
                    <br>ngay đến hộp thư đến của bạn
                </h4>
                <form class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                    <input type="email" class="form-control w-auto" style="min-width: 250px;"
                        placeholder="Địa chỉ email của bạn">
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                </form>
            </div>
        </div>
    </section>
@endsection
