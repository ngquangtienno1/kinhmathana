@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid  ">
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="../index.html"><span itemprop="title">Home</span></a><span
                            class="qodef-breadcrumbs-separator"></span><a href="{{ route('client.blog.index') }}">Bài viết</a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">{{ $news->title }}</span></div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template qodef-gutter--big" role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--9">
                        <div class="qodef-blog qodef-m qodef--single">
                            <article
                                class="qodef-blog-item qodef-e post-2646 post type-post status-publish format-standard has-post-thumbnail hentry category-frame category-optic tag-brands tag-design tag-sight tag-trends">
                                <div class="qodef-e-inner">
                                    <div class="qodef-e-media">
                                        <div class="qodef-e-media-image">
                                            <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('default-news.jpg') }}" alt="{{ $news->title }}" style="max-width:100%;height:auto;" />
                                        </div>
                                    </div>
                                    <div class="qodef-e-content">
                                        <div class="qodef-e-top-holder">
                                            <div class="post-meta-custom" style="display: flex; align-items: center; justify-content: center; gap: 18px; font-size: 15px; color: #555; margin-bottom: 18px;">
                                                <span>
                                                    <i class="fa fa-calendar"></i>
                                                    {{ optional($news->published_at)->format('d/m/Y') }}
                                                </span>
                                                <span style="font-size: 18px; color: #bbb;">&bull;</span>
                                                <span>
                                                    <i class="fa fa-folder-open"></i>
                                                    {{ $news->category->name ?? '' }}
                                                </span>
                                                <span style="font-size: 18px; color: #bbb;">&bull;</span>
                                                <span>
                                                    <i class="fa fa-user"></i>
                                                    {{ $news->author->name ?? '' }}
                                                </span>
                                                <span style="font-size: 18px; color: #bbb;">&bull;</span>
                                                <span>
                                                    <i class="fa fa-eye"></i>
                                                    Lượt xem: {{ $news->views }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="qodef-e-text">
                                            <h1 class="qodef-e-title entry-title">{{ $news->title }}</h1>
                                            <p class="qodef-e-excerpt">{{ $news->summary }}</p>
                                            <div class="qodef-e-content-detail">{!! $news->content !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <div id="qodef-single-post-navigation" class="qodef-m">
                                <div class="qodef-m-inner">
                                    <a itemprop="url" class="qodef-m-nav qodef--next"
                                        href="../what-is-blue-light/index.html">
                                        <span class="qodef-m-nav-image">
                                            <img loading="lazy" width="150" height="150"
                                                src="../wp-content/uploads/2021/07/b-single-img-1-150x150.jpg"
                                                class="attachment-thumbnail size-thumbnail wp-post-image" alt="c"
                                                decoding="async"
                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/b-single-img-1-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/b-single-img-1-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/b-single-img-1-650x650.jpg 650w"
                                                sizes="(max-width: 150px) 100vw, 150px" /> </span>
                                        <span class="qodef-m-nav-info">
                                            <span class="qodef-m-top">
                                                <span class="qodef-m-nav-date">
                                                    Jul 30 </span>
                                                <span class="qodef-m-nav-cat">
                                                    Frame, Optic </span>
                                            </span>
                                            <span class="qodef-m-nav-title">
                                                What is blue light? </span>
                                        </span>

                                    </a>
                                </div>
                            </div>
                            <div id="qodef-author-info" class="qodef-m">
                                <div class="qodef-m-inner">
                                    @if($relatedNews)
                                    <div class="qodef-m-image">
                                            <a href="{{ route('client.blog.show', $relatedNews->slug) }}">
                                                <img loading="lazy" src="{{ $relatedNews->image ? asset('storage/' . $relatedNews->image) : asset('default-news.jpg') }}"
                                                    width="193" height="198" alt="{{ $relatedNews->title }}"
                                                class="avatar avatar-198 wp-user-avatar wp-user-avatar-198 alignnone photo" />
                                        </a>
                                    </div>
                                    <div class="qodef-m-content">
                                        <h4 class="qodef-m-author vcard author">
                                                <a href="{{ route('client.blog.show', $relatedNews->slug) }}">
                                                    <span class="fn">{{ $relatedNews->author->name }}</span>
                                            </a>
                                        </h4>
                                            <p class="qodef-m-description">{{ $relatedNews->summary }}</p>
                                            <div style="font-size:13px;color:#888;margin-bottom:4px;">
                                                <i class="fa fa-calendar"></i> {{ optional($relatedNews->published_at)->format('d/m/Y') }}
                                            </div>
                                            <div style="margin-top:8px;">
                                                <a href="{{ route('client.blog.show', $relatedNews->slug) }}" class="qodef-shortcode qodef-m qodef-button qodef-layout--textual qodef-html--link" style="font-size:13px;">Đọc bài viết</a>
                                            </div>
                                        </div>
                                    @else
                                        <div>Không có bài viết cùng danh mục.</div>
                                    @endif
                                </div>
                            </div>
                            <div id="qodef-page-comments">
                                <div id="qodef-page-comments-list" class="qodef-m">
                                    <h3 class="qodef-m-title">Bình luận</h3>
                                    <ul class="qodef-m-comments">
                                        @forelse($comments as $comment)
                                            <li class="qodef-comment-item qodef-e">
                                                <div class="qodef-e-inner">
                                                    <div class="qodef-e-image">
                                                        <img loading="lazy" src="{{ $comment->user->avatar ?? asset('default-avatar.png') }}" width="64" height="64" alt="{{ $comment->user->name }}" class="avatar avatar-64 alignnone photo" />
                                                </div>
                                                <div class="qodef-e-content">
                                                    <div class="qodef-e-date commentmetadata">
                                                            <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                        <h5 class="qodef-e-title vcard"><span class="fn">{{ $comment->user->name }}</span></h5>
                                                    <div class="qodef-e-text">
                                                            <p>{{ $comment->content }}</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                @if($comment->replies && $comment->replies->count())
                                            <ul class="children">
                                                        @foreach($comment->replies as $reply)
                                                            <li class="qodef-comment-item qodef-e">
                                                                <div class="qodef-e-inner">
                                                                    <div class="qodef-e-image">
                                                                        <img loading="lazy" src="{{ $reply->user->avatar ?? asset('default-avatar.png') }}" width="48" height="48" alt="{{ $reply->user->name }}" class="avatar avatar-48 alignnone photo" />
                                                        </div>
                                                        <div class="qodef-e-content">
                                                            <div class="qodef-e-date commentmetadata">
                                                                            <span>{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                                            </div>
                                                                        <h5 class="qodef-e-title vcard"><span class="fn">{{ $reply->user->name }}</span></h5>
                                                            <div class="qodef-e-text">
                                                                            <p>{{ $reply->content }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @empty
                                            <li><div class="alert alert-info">Chưa có bình luận nào.</div></li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div id="qodef-page-comments-form">
                                    <div id="respond" class="comment-respond">
                                        <h3 id="reply-title" class="comment-reply-title">Gửi bình luận</h3>
                                        @if(session('success'))
                                            <div class="alert alert-success" style="background: #e6f9ed; border: 1.5px solid #2ecc71; color: #218c5a; font-weight: bold; display: flex; align-items: center; gap: 8px; font-size: 16px; padding: 12px 18px; border-radius: 6px; margin-bottom: 18px;">
                                                <span style="font-size: 22px;">&#10003;</span>
                                                <span>{{ session('success') }}</span>
                                            </div>
                                        @endif
                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul style="margin-bottom:0;">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @auth
                                        <form action="{{ route('client.blog.comment', $news->slug) }}" method="POST" id="commentform" class="qodef-comment-form">
                                            @csrf
                                            <p class="comment-notes">
                                                <span id="email-notes">Email của bạn sẽ không được công khai.</span>
                                                <span class="required-field-message">Các trường bắt buộc được đánh dấu <span class="required">*</span></span>
                                            </p>
                                            <p class="comment-form-comment">
                                                <textarea id="content" name="content" placeholder="Bình luận của bạn *" cols="45" rows="8" maxlength="2000" required></textarea>
                                                @error('content')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </p>
                                            <p class="form-submit">
                                                <button name="submit" type="submit" id="submit" class="qodef-button qodef-layout--outlined" value="Gửi bình luận">
                                                    <span class="qodef-m-text">Gửi bình luận</span>
                                                </button>
                                            </p>
                                        </form>
                                        @else
                                            <div class="alert alert-warning">Bạn cần <a href="{{ route('client.login') }}">đăng nhập</a> để gửi bình luận.</div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qodef-grid-item qodef-page-sidebar-section qodef-col--3">
                        <aside id="qodef-page-sidebar" role="complementary">
                            <div id="neoocular_core_title_widget-2" class="widget widget_neoocular_core_title_widget"
                                data-area="qodef-main-sidebar">
                                <h5 class="qodef-widget-title" style="margin-bottom: -10px">
                                    Category </h5>
                            </div>
                            <div id="block-6" class="widget widget_block widget_categories"
                                data-area="qodef-main-sidebar">
                                <ul class="wp-block-categories-list wp-block-categories">
                                    <li class="cat-item cat-item-57"><a href="../category/color/index.html">Color</a> (3)
                                    </li>
                                    <li class="cat-item cat-item-54"><a href="../category/frame/index.html">Frame</a> (10)
                                    </li>
                                    <li class="cat-item cat-item-53"><a href="../category/optic/index.html">Optic</a> (9)
                                    </li>
                                    <li class="cat-item cat-item-56"><a href="../category/shape/index.html">Shape</a> (2)
                                    </li>
                                    <li class="cat-item cat-item-58"><a href="../category/style/index.html">Style</a> (3)
                                    </li>
                                    <li class="cat-item cat-item-1"><a href="../category/vision/index.html">Vision</a> (4)
                                    </li>
                                </ul>
                            </div>
                            <div id="neoocular_core_separator-2" class="widget widget_neoocular_core_separator"
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-separator clear ">
                                    <div class="qodef-m-line" style="border-color: #ffffff;margin-top: 3px"></div>
                                </div>
                            </div>
                            <div id="neoocular_core_title_widget-5" class="widget widget_neoocular_core_title_widget"
                                data-area="qodef-main-sidebar">
                                <h5 class="qodef-widget-title" style="margin-bottom: -3px">
                                    Latest Posts </h5>
                            </div>
                            <div id="neoocular_core_simple_blog_list-3"
                                class="widget widget_neoocular_core_simple_blog_list" data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-blog qodef-item-layout--minimal  qodef-item-layout--minimal-image qodef-grid qodef-layout--columns  qodef-gutter--no qodef-col-num--1 qodef-item-layout--minimal qodef--no-bottom-space qodef-pagination--off qodef-responsive--predefined qodef-swiper-pagination--on"
                                    data-options="{&quot;plugin&quot;:&quot;neoocular_core&quot;,&quot;module&quot;:&quot;blog\/shortcodes&quot;,&quot;shortcode&quot;:&quot;blog-list&quot;,&quot;post_type&quot;:&quot;post&quot;,&quot;next_page&quot;:&quot;2&quot;,&quot;max_pages_num&quot;:6,&quot;behavior&quot;:&quot;columns&quot;,&quot;images_proportion&quot;:&quot;thumbnail&quot;,&quot;columns&quot;:1,&quot;columns_responsive&quot;:&quot;predefined&quot;,&quot;columns_1440&quot;:&quot;3&quot;,&quot;columns_1366&quot;:&quot;3&quot;,&quot;columns_1024&quot;:&quot;3&quot;,&quot;columns_768&quot;:&quot;3&quot;,&quot;columns_680&quot;:&quot;3&quot;,&quot;columns_480&quot;:&quot;3&quot;,&quot;space&quot;:&quot;no&quot;,&quot;posts_per_page&quot;:&quot;3&quot;,&quot;orderby&quot;:&quot;date&quot;,&quot;order&quot;:&quot;DESC&quot;,&quot;tax&quot;:&quot;category&quot;,&quot;layout&quot;:&quot;minimal&quot;,&quot;title_tag&quot;:&quot;h6&quot;,&quot;date_margin&quot;:&quot;0 0 1px 0&quot;,&quot;show_image&quot;:&quot;yes&quot;,&quot;is_widget_element&quot;:&quot;yes&quot;,&quot;pagination_type&quot;:&quot;no-pagination&quot;,&quot;object_class_name&quot;:&quot;NeoOcularCore_Blog_List_Shortcode&quot;,&quot;taxonomy_filter&quot;:&quot;category&quot;,&quot;additional_query_args&quot;:[],&quot;top_holder_style&quot;:[&quot;margin: 0 0 1px 0&quot;],&quot;space_value&quot;:0}">
                                    <div class="qodef-grid-inner clear">
                                        <article
                                            class="qodef-e qodef-blog-item qodef-grid-item qodef-item--thumbnail post-13019 post type-post status-publish format-standard has-post-thumbnail hentry category-color tag-brands tag-design tag-trends tag-vibrant">
                                            <div class="qodef-e-inner">
                                                <div class="qodef-e-media">
                                                    <div class="qodef-e-media-image"> <a itemprop="url"
                                                            href="../girl-cheek-trend/index.html"> <img loading="lazy"
                                                                width="150" height="150"
                                                                src="../wp-content/uploads/2021/07/h1-b-list-img-3-150x150.jpg"
                                                                class="attachment-thumbnail size-thumbnail qodef-list-image"
                                                                alt="c" decoding="async"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-3-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-3-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-3-650x650.jpg 650w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-3-1300x1300.jpg 1300w"
                                                                sizes="(max-width: 150px) 100vw, 150px" /> </a> </div>
                                                </div>
                                                <div class="qodef-e-content">
                                                    <div class="qodef-e-top-holder" style="margin: 0 0 1px 0">
                                                        <div class="qodef-e-info"> <a itemprop="dateCreated"
                                                                href="../2021/10/index.html"
                                                                class="entry-date published updated"> Oct 7</a>
                                                            <div class="qodef-info-separator-end"></div><a
                                                                href="../category/color/index.html"
                                                                rel="tag">Color</a>
                                                            <div class="qodef-info-separator-end"></div>
                                                        </div>
                                                    </div>
                                                    <div class="qodef-e-text">
                                                        <h6 itemprop="name" class="qodef-e-title entry-title"> <a
                                                                itemprop="url" class="qodef-e-title-link"
                                                                href="../girl-cheek-trend/index.html"> Girl cheek trend
                                                            </a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article
                                            class="qodef-e qodef-blog-item qodef-grid-item qodef-item--thumbnail post-13018 post type-post status-publish format-standard has-post-thumbnail hentry category-frame tag-brands tag-design tag-trends tag-vibrant">
                                            <div class="qodef-e-inner">
                                                <div class="qodef-e-media">
                                                    <div class="qodef-e-media-image"> <a itemprop="url"
                                                            href="../this-year-frames/index.html"> <img loading="lazy"
                                                                width="150" height="150"
                                                                src="../wp-content/uploads/2021/07/h1-b-list-img-2-150x150.jpg"
                                                                class="attachment-thumbnail size-thumbnail qodef-list-image"
                                                                alt="c" decoding="async"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-2-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-2-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-2-650x650.jpg 650w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-2-1300x1300.jpg 1300w"
                                                                sizes="(max-width: 150px) 100vw, 150px" /> </a> </div>
                                                </div>
                                                <div class="qodef-e-content">
                                                    <div class="qodef-e-top-holder" style="margin: 0 0 1px 0">
                                                        <div class="qodef-e-info"> <a itemprop="dateCreated"
                                                                href="../2021/10/index.html"
                                                                class="entry-date published updated"> Oct 5</a>
                                                            <div class="qodef-info-separator-end"></div><a
                                                                href="../category/frame/index.html"
                                                                rel="tag">Frame</a>
                                                            <div class="qodef-info-separator-end"></div>
                                                        </div>
                                                    </div>
                                                    <div class="qodef-e-text">
                                                        <h6 itemprop="name" class="qodef-e-title entry-title"> <a
                                                                itemprop="url" class="qodef-e-title-link"
                                                                href="../this-year-frames/index.html"> This year frames
                                                            </a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article
                                            class="qodef-e qodef-blog-item qodef-grid-item qodef-item--thumbnail post-13017 post type-post status-publish format-standard has-post-thumbnail hentry category-vision tag-brands tag-design tag-trends tag-vibrant">
                                            <div class="qodef-e-inner">
                                                <div class="qodef-e-media">
                                                    <div class="qodef-e-media-image"> <a itemprop="url"
                                                            href="../trendy-21-shapes/index.html"> <img loading="lazy"
                                                                width="150" height="150"
                                                                src="../wp-content/uploads/2021/07/h1-b-list-img-1-150x150.jpg"
                                                                class="attachment-thumbnail size-thumbnail qodef-list-image"
                                                                alt="c" decoding="async"
                                                                srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-1-150x150.jpg 150w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-1-100x100.jpg 100w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-1-650x650.jpg 650w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/h1-b-list-img-1-1300x1300.jpg 1300w"
                                                                sizes="(max-width: 150px) 100vw, 150px" /> </a> </div>
                                                </div>
                                                <div class="qodef-e-content">
                                                    <div class="qodef-e-top-holder" style="margin: 0 0 1px 0">
                                                        <div class="qodef-e-info"> <a itemprop="dateCreated"
                                                                href="../2021/10/index.html"
                                                                class="entry-date published updated"> Oct 1</a>
                                                            <div class="qodef-info-separator-end"></div><a
                                                                href="../category/vision/index.html"
                                                                rel="tag">Vision</a>
                                                            <div class="qodef-info-separator-end"></div>
                                                        </div>
                                                    </div>
                                                    <div class="qodef-e-text">
                                                        <h6 itemprop="name" class="qodef-e-title entry-title"> <a
                                                                itemprop="url" class="qodef-e-title-link"
                                                                href="../trendy-21-shapes/index.html"> Trendy 21 shapes
                                                            </a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                            <div id="block-16" class="widget widget_block" data-area="qodef-main-sidebar">
                                <div style="margin-bottom:-27px; margin-top:7px;">
                                    <h5> Tags</h5>
                                </div>
                            </div>
                            <div id="block-8" class="widget widget_block widget_tag_cloud"
                                data-area="qodef-main-sidebar">
                                <p class="wp-block-tag-cloud"><a href="../tag/brands/index.html"
                                        class="tag-cloud-link tag-link-60 tag-link-position-1" style="font-size: 22pt;"
                                        aria-label="Brands (17 items)">Brands<span class="tag-link-count"> (17)</span></a>
                                    <a href="../tag/design/index.html"
                                        class="tag-cloud-link tag-link-61 tag-link-position-2"
                                        style="font-size: 20.30303030303pt;" aria-label="Design (14 items)">Design<span
                                            class="tag-link-count"> (14)</span></a>
                                    <a href="../tag/glasses/index.html"
                                        class="tag-cloud-link tag-link-63 tag-link-position-3" style="font-size: 8pt;"
                                        aria-label="Glasses (3 items)">Glasses<span class="tag-link-count"> (3)</span></a>
                                    <a href="../tag/sight/index.html"
                                        class="tag-cloud-link tag-link-64 tag-link-position-4"
                                        style="font-size: 18.181818181818pt;" aria-label="Sight (11 items)">Sight<span
                                            class="tag-link-count"> (11)</span></a>
                                    <a href="../tag/trends/index.html"
                                        class="tag-cloud-link tag-link-59 tag-link-position-5" style="font-size: 22pt;"
                                        aria-label="Trends (17 items)">Trends<span class="tag-link-count"> (17)</span></a>
                                    <a href="../tag/vibrant/index.html"
                                        class="tag-cloud-link tag-link-62 tag-link-position-6"
                                        style="font-size: 13.30303030303pt;" aria-label="Vibrant (6 items)">Vibrant<span
                                            class="tag-link-count"> (6)</span></a>
                                </p>
                            </div>
                            <div id="neoocular_core_separator-9" class="widget widget_neoocular_core_separator"
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-separator clear ">
                                    <div class="qodef-m-line"
                                        style="width: 0px;border-bottom-width: 0px;margin-top: 3px;margin-bottom: 0px">
                                    </div>
                                </div>
                            </div>
                            <div id="neoocular_core_title_widget-8" class="widget widget_neoocular_core_title_widget"
                                data-area="qodef-main-sidebar">
                                <h5 class="qodef-widget-title" style="margin-bottom: -12px">
                                    Instagram </h5>
                            </div>
                            <div id="neoocular_core_instagram_list-2" class="widget widget_neoocular_core_instagram_list"
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-instagram-list qodef-instagram-columns"> </div>
                            </div>
                            <div id="neoocular_core_separator-5" class="widget widget_neoocular_core_separator"
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-separator clear ">
                                    <div class="qodef-m-line"
                                        style="width: 0px;border-bottom-width: 0px;margin-top: 14px"></div>
                                </div>
                            </div>
                            <div id="block-25" class="widget widget_block widget_search" data-area="qodef-main-sidebar">
                                <form role="search" method="get"
                                    class="wp-block-search__button-outside wp-block-search__text-button qodef-search-form wp-block-search"
                                    action="https://neoocular.qodeinteractive.com/"><label for="qodef-search-form-1"
                                        class="qodef-search-form-label screen-reader-text">Search</label>
                                    <div class="qodef-search-form-inner "><input type="search" id="qodef-search-form-1"
                                            class="qodef-search-form-field " name="s" value=""
                                            placeholder="Search" required /><button type="submit"
                                            class="qodef-search-form-button  qodef--button-outside ">Search</button></div>
                                </form>
                            </div>
                            <div id="neoocular_core_separator-8" class="widget widget_neoocular_core_separator"
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-separator clear ">
                                    <div class="qodef-m-line"
                                        style="width: 0px;border-bottom-width: 0px;margin-top: 19px"></div>
                                </div>
                            </div>
                            <div id="neoocular_core_social_icons_group-8"
                                class="widget widget_neoocular_core_social_icons_group" data-area="qodef-main-sidebar">
                                <h5 class="qodef-widget-title">Follow Us</h5>
                                <div class="qodef-social-icons-group">
                                    <span class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                        data-hover-color="#000000" style="margin: -1px 22px 0 0"> <a itemprop="url"
                                            href="https://www.facebook.com/QodeInteractive/" target="_blank"> <span
                                                class="qodef-icon-elegant-icons social_facebook qodef-icon qodef-e"
                                                style="color: #1c1c1c"></span> </a> </span><span
                                        class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                        data-hover-color="#000000" style="margin: -1px 22px 0 0 "> <a itemprop="url"
                                            href="https://twitter.com/qodeinteractive" target="_blank"> <span
                                                class="qodef-icon-elegant-icons social_twitter qodef-icon qodef-e"
                                                style="color: #1c1c1c"></span> </a> </span><span
                                        class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                        data-hover-color="#000000" style="margin: -1px 23px 0 0 "> <a itemprop="url"
                                            href="https://www.instagram.com/qodeinteractive/" target="_blank"> <span
                                                class="qodef-icon-elegant-icons social_instagram qodef-icon qodef-e"
                                                style="color: #1c1c1c"></span> </a> </span><span
                                        class="qodef-shortcode qodef-m  qodef-icon-holder  qodef-layout--normal"
                                        data-hover-color="#000000" style="margin: -1px 0px 0px 0px"> <a itemprop="url"
                                            href="https://www.pinterest.com/qodeinteractive/" target="_blank"> <span
                                                class="qodef-icon-elegant-icons social_pinterest qodef-icon qodef-e"
                                                style="color: #1c1c1c"></span> </a> </span>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
        </div><!-- close #qodef-page-inner div from header.php -->
    </div><!-- close #qodef-page-outer div from header.php -->
@endsection
