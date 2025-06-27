@extends('client.layouts.app')

@section('content')
<div class="container">

    <div class="content mx-auto mb-9" style="max-width: 1200px;">
        <div class="mx-n4 mx-lg-n6 mt-n5 position-relative mb-md-9 pb-5" style="height:208px">
            <div class="bg-holder bg-card d-dark-none border border-translucent"
                style="background-color: #6699ff;background-size:cover; border-radius: 10px;"></div>
            <!--/.bg-holder-->
            <div class="bg-holder bg-card d-light-none border border-translucent"
                style="background-color: #6699ff;background-size:cover; border-radius: 10px;"></div>
            <!--/.bg-holder-->
            <div
                class="faq-title-box position-relative bg-body-emphasis border border-translucent p-6 rounded-3 text-center mx-auto">
                <h2 class="fw-bold">Xin chào, Hana có thể giúp gì cho bạn?</h2>
                <p class="my-3">Tìm kiếm chủ đề bạn cần hỗ trợ hoặc <a href="#!">liên hệ hỗ trợ</a></p>
                <div class="search-box w-100">
                    <form class="position-relative" method="GET" action="{{ route('client.faq.index') }}"
                        data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Nhập từ khóa hoặc nội dung cần tìm" value="{{ request('search') }}"
                            aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
            </div>
        </div>
        <div class="row gx-xl-8 gx-xxl-11 gy-6 faq pt-5">
            <div class="col-md-6 col-xl-5 col-xxl-4">
                <!-- GỠ bỏ 'offcanvas offcanvas-start' để sidebar cuộn bình thường -->
                <div class="faq-sidebar bg-body w-100">

                    <!-- Tabs cấp 1: Popular / All -->
                    <ul class="faq-category-tab nav nav-tabs mb-4 pb-3 pt-2 w-100 w-sm-75 w-md-100 mx-auto">
                        <li class="nav-item">
                            <button class="nav-link fw-semibold me-3 fs-8" id="popular" type="button"
                                data-bs-toggle="tab" data-category-filter="popular">Danh mục phổ biến</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-semibold fs-8 active" id="all" type="button" data-bs-toggle="tab"
                                data-category-filter="all">Tất cả danh mục</button>
                        </li>
                    </ul>

                    <!-- Tabs cấp 2: Subcategories -->
                    <div class="faq-subcategory-tab nav nav-tabs w-100 mx-auto mb-4" id="faq-subcategory-tab"
                        style="max-width: 90%;">

                        @php
                        $iconMap = [
                        'Sản phẩm' => 'fa-chart-pie',
                        'Vận chuyển' => 'fa-truck-fast',
                        'Thanh toán' => 'fa-credit-card',
                        'Bảo hành' => 'fa-shield-alt',
                        'Chung' => 'fa-circle-info',
                        'default' => 'fa-folder-open'
                        ];
                        @endphp

                        <!-- Mỗi danh mục -->
                        @foreach($categories as $index => $category)
                        @php
                        $icon = $iconMap[$category] ?? $iconMap['default'];
                        $slug = \Str::slug($category);
                        $isActive = $index === 0 ? 'active' : '';
                        @endphp
                        <div class="nav-item w-100 mb-3" role="presentation">
                            <button
                                class="category nav-link btn bg-body-emphasis w-100 px-3 pt-4 pb-3 fs-8 {{ $isActive }}"
                                id="tab-{{ $slug }}" data-bs-toggle="tab" data-bs-target="#{{ $slug }}" type="button"
                                role="tab" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                <span class="category-icon text-body-secondary fs-6 fa-solid {{ $icon }}"></span>
                                <span class="d-block fs-6 fw-bolder lh-1 text-body mt-3 mb-2">{{ $category }}</span>
                                <span class="d-block text-body fw-normal mb-0 fs-9">Trả lời các câu hỏi thường gặp nhất
                                    về sản phẩm & dịch vụ của bạn tại đây.</span>
                            </button>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-7 col-xxl-8 mt-md-11">
                <div class="faq-subcategory-content tab-content">
                    <button class="btn btn-link d-md-none my-6 fs-8 ps-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#faq-offcanvas"> <span class="fa-solid fa-chevron-left fs-9 me-2"
                            data-fa-transform="up-2"></span>Danh mục</button>

                    @foreach($categories as $index => $category)
                    @php
                    $slug = \Str::slug($category);
                    $isActive = $index === 0 ? 'active show' : '';
                    @endphp
                    <div class="tab-pane fade {{ $isActive }}" id="{{ $slug }}">
                        <ul class="list-inline mb-0">
                            @foreach($faqsByCategory[$category]->take(3) as $faq)
                            <li class="d-flex gap-2 mb-6">
                                <span class="fa-solid fa-star fs-8 text-primary"></span>
                                <div>
                                    <h4 class="mb-3 text-body-highlight">
                                        <a href="javascript:void(0)" onclick="openFaqModal({{ $faq->id }})"
                                            class="text-decoration-none">{{ $faq->question }}</a>
                                    </h4>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <hr class="border-top" />
                        <ul class="faq-list list-inline">
                            @foreach($faqsByCategory[$category]->skip(3) as $faq)
                            <li class="d-flex mt-6">
                                <div>
                                    <h5 class="mb-3 text-body-highlight text-3xl">
                                        <span class="fa-solid fa-circle"></span>
                                        <a href="javascript:void(0)" onclick="openFaqModal({{ $faq->id }})"
                                            class="text-decoration-none">{{ $faq->question }}</a>
                                    </h5>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Blog Modal -->
<div class="modal fade" id="faqBlogModal" tabindex="-1" aria-labelledby="faqBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div id="faqBlogContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openFaqModal(faqId) {
        const faqData = findFaqById(faqId);
        if (!faqData) return;
        const modal = new bootstrap.Modal(document.getElementById('faqBlogModal'));
        const contentDiv = document.getElementById('faqBlogContent');
        const blogContent = createBlogContent(faqData);
        contentDiv.innerHTML = blogContent;
        modal.show();
    }

    function findFaqById(faqId) {
        @foreach($categories as $category)
            @foreach($faqsByCategory[$category] as $faq)
                if ({{ $faq->id }} === faqId) {
                    return {
                        id: {{ $faq->id }},
                        question: "{{ addslashes($faq->question) }}",
                        answer: `{!! addslashes($faq->answer) !!}`,
                        category: "{{ $category }}",
                        rating: {{ $faq->rating ?? 0 }},
                        images: @json($faq->images),
                        updated_at: "{{ $faq->updated_at->format('d/m/Y H:i') }}"
                    };
                }
            @endforeach
        @endforeach
        return null;
    }

    function createBlogContent(faq) {
        let imagesHtml = '';
        if (faq.images && faq.images.length > 0) {
            const images = Array.isArray(faq.images) ? faq.images : JSON.parse(faq.images);
            imagesHtml = `<div class="mb-4"><div class="row g-3">${images.map(image => `<div class="col-md-6"><img src="${window.location.origin}/storage/${image}" alt="FAQ Image" class="img-fluid rounded shadow-sm"></div>`).join('')}</div></div>`;
        }

        let ratingHtml = '';
        if (faq.rating > 0) {
            ratingHtml = `<div class="text-warning mb-3">${Array.from({length: 5}, (_, i) => i < faq.rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>').join('')}<span class="ms-2 text-body-secondary">(${faq.rating.toFixed(1)})</span></div>`;
        }

        return `<article class="faq-blog-post">
            <header class="mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="badge bg-primary fs-6">${faq.category}</span>
                    <small class="text-body-secondary">
                        <span class="fas fa-calendar me-1"></span>${faq.updated_at}
                    </small>
                </div>
                ${ratingHtml}
                <h1 class="display-6 fw-bold text-body-highlight mb-3">${faq.question}</h1>
            </header>
            ${imagesHtml}
            <div class="faq-content">
                <div class="lead mb-4">${faq.answer}</div>
            </div>
            <footer class="mt-5 pt-4 border-top">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-body-secondary">Bài viết này có hữu ích không?</span>
                        <button class="btn btn-outline-success btn-sm" onclick="rateFaq(${faq.id}, 'helpful')">
                            <span class="fas fa-thumbs-up me-1"></span>Có
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="rateFaq(${faq.id}, 'not-helpful')">
                            <span class="fas fa-thumbs-down me-1"></span>Không
                        </button>
                    </div>
                    <button class="btn btn-outline-primary" onclick="shareFaq(${faq.id})">
                        <span class="fas fa-share me-1"></span>Chia sẻ
                    </button>
                </div>
            </footer>
        </article>`;
    }

    function rateFaq(faqId, rating) {
        console.log(`Rating FAQ ${faqId} as ${rating}`);
        // Có thể thêm logic gửi rating lên server
    }

    function shareFaq(faqId) {
        if (navigator.share) {
            navigator.share({
                title: 'FAQ - Câu hỏi thường gặp',
                url: window.location.href + '?faq=' + faqId
            });
        } else {
            navigator.clipboard.writeText(window.location.href + '?faq=' + faqId);
            alert('Đã sao chép link vào clipboard!');
        }
    }
</script>

@endsection

<style>
    .faq-category-tab {
        position: static !important;
        /* hoặc 'relative' nếu bạn cần */
    }
</style>