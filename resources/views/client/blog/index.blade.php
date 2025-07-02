@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Tin tức </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="../index.html"><span itemprop="title">Home</span></a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">Blog right sidebar</span></div>
                </div>  
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template qodef-gutter--big" role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--9">
                        <div data-elementor-type="wp-page" data-elementor-id="3863" class="elementor elementor-3863">
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-f808f50 elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                                data-id="f808f50" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-96f9282"
                                        data-id="96f9282" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-338fc2b elementor-widget elementor-widget-neoocular_core_blog_list"
                                                data-id="338fc2b" data-element_type="widget"
                                                data-widget_type="neoocular_core_blog_list.default">
                                                <div class="elementor-widget-container">
                                                    <div class="qodef-shortcode qodef-m  qodef-blog qodef--list qodef-item-layout--standard   qodef-grid qodef-layout--columns  qodef-gutter--huge qodef-col-num--1 qodef-item-layout--standard qodef-pagination--on qodef-pagination-type--standard qodef-responsive--predefined"
                                                        data-options="{&quot;plugin&quot;:&quot;neoocular_core&quot;,&quot;module&quot;:&quot;blog\/shortcodes&quot;,&quot;shortcode&quot;:&quot;blog-list&quot;,&quot;post_type&quot;:&quot;post&quot;,&quot;next_page&quot;:&quot;2&quot;,&quot;max_pages_num&quot;:4,&quot;behavior&quot;:&quot;columns&quot;,&quot;images_proportion&quot;:&quot;full&quot;,&quot;columns&quot;:&quot;1&quot;,&quot;columns_responsive&quot;:&quot;predefined&quot;,&quot;space&quot;:&quot;huge&quot;,&quot;posts_per_page&quot;:&quot;5&quot;,&quot;orderby&quot;:&quot;date&quot;,&quot;order&quot;:&quot;ASC&quot;,&quot;layout&quot;:&quot;standard&quot;,&quot;title_tag&quot;:&quot;h2&quot;,&quot;excerpt_length&quot;:&quot;448&quot;,&quot;date_margin&quot;:&quot;6px 0 0 0&quot;,&quot;pagination_type&quot;:&quot;standard&quot;,&quot;object_class_name&quot;:&quot;NeoOcularCore_Blog_List_Shortcode&quot;,&quot;taxonomy_filter&quot;:&quot;category&quot;,&quot;additional_query_args&quot;:[],&quot;top_holder_style&quot;:[&quot;margin: 6px 0 0 0&quot;],&quot;space_value&quot;:40}">
                                                        <div class="qodef-grid-inner clear">
                                                            @forelse($news as $item)
                                                                <article
                                                                    class="qodef-e qodef-blog-item qodef-grid-item qodef-item--full">
                                                                <div class="qodef-e-inner">
                                                                    <div class="qodef-e-media">
                                                                        <div class="qodef-e-media-image">
                                                                                <a
                                                                                    href="{{ route('client.blog.show', $item->slug) }}">
                                                                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('default-news.jpg') }}"
                                                                                        alt="{{ $item->title }}"
                                                                                        style="max-width:100%;height:auto;" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="qodef-e-content">
                                                                        <div class="qodef-e-top-holder">
                                                                                <div class="qodef-e-info"
                                                                                    style="margin: 6px 0 0 0">
                                                                                    <span
                                                                                        class="entry-date published updated">{{ optional($item->published_at)->format('d/m/Y') }}</span>
                                                                                    <div class="qodef-info-separator-end">
                                                                                    </div>
                                                                                    <a
                                                                                        href="#">{{ $item->category->name ?? '' }}</a>
                                                                                    <div class="qodef-info-separator-end">
                                                                                    </div>
                                                                                    <span>{{ $item->author->name ?? '' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="qodef-e-text">
                                                                                <h2 class="qodef-e-title entry-title">
                                                                                    <a
                                                                                        href="{{ route('client.blog.show', $item->slug) }}">{{ $item->title }}</a>
                                                                            </h2>
                                                                                <p class="qodef-e-excerpt">
                                                                                    {{ $item->summary }}</p>
                                                                        </div>
                                                                        <div class="qodef-e-bottom-holder">
                                                                            <div class="qodef-e-left">
                                                                                <div class="qodef-e-read-more">
                                                                                        <a class="qodef-shortcode qodef-m  qodef-button qodef-layout--textual  qodef-html--link "
                                                                                            href="{{ route('client.blog.show', $item->slug) }}"
                                                                                            target="_self">
                                                                                            <span class="qodef-m-text">Đọc
                                                                                                tiếp</span>
                                                                                        </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                            @empty
                                                                <div class="alert alert-info">Chưa có bài viết nào.</div>
                                                            @endforelse
                                                        </div>
                                                        <div style="display: flex; justify-content: center; align-items: center; margin: 32px 0;">
                                                            <nav>
                                                                {{-- Previous Page Link --}}
                                                                @if ($news->onFirstPage())
                                                                    <a href="#" aria-disabled="true" style="display: none;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="6.344px" height="10.906px" viewBox="0 0 6.344 10.906"><g><path d="M5.883,10.41c-0.329,0.315-0.652,0.315-0.967,0L0.447,5.942C0.304,5.827,0.232,5.67,0.232,5.469 s0.072-0.358,0.215-0.473l4.468-4.468c0.316-0.315,0.638-0.315,0.967,0c0.331,0.315,0.323,0.63-0.021,0.945L1.908,5.469 l3.953,3.996C6.205,9.78,6.212,10.095,5.883,10.41z"/></g></svg>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ $news->previousPageUrl() }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="6.344px" height="10.906px" viewBox="0 0 6.344 10.906"><g><path d="M5.883,10.41c-0.329,0.315-0.652,0.315-0.967,0L0.447,5.942C0.304,5.827,0.232,5.67,0.232,5.469 s0.072-0.358,0.215-0.473l4.468-4.468c0.316-0.315,0.638-0.315,0.967,0c0.331,0.315,0.323,0.63-0.021,0.945L1.908,5.469 l3.953,3.996C6.205,9.78,6.212,10.095,5.883,10.41z"/></g></svg>
                                                                    </a>
                                                                @endif
                                                                {{-- Pagination Elements --}}
                                                                @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                                                                    @if ($page == $news->currentPage())
                                                                        <a style="font-weight:bold; border-bottom:2px solid #222; margin: 0 6px; padding-bottom: 2px; color: #222; text-decoration: none;" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                                                    @else
                                                                        <a style="margin: 0 6px; padding-bottom: 2px; color: #222; text-decoration: none; border-bottom:2px solid transparent;" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                                                    @endif
                                                                @endforeach
                                                                {{-- Next Page Link --}}
                                                                @if ($news->hasMorePages())
                                                                    <a href="{{ $news->nextPageUrl() }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="6.344px" height="10.906px" viewBox="0 0 6.344 10.906"><g><path d="M0.496,9.465l3.953-3.996L0.496,1.473c-0.344-0.315-0.352-0.63-0.021-0.945 c0.329-0.315,0.651-0.315,0.967,0L5.91,4.996c0.143,0.115,0.215,0.272,0.215,0.473c0,0.201-0.072,0.358-0.215,0.473L1.441,10.41 c-0.315,0.315-0.638,0.315-0.967,0C0.145,10.095,0.152,9.78,0.496,9.465z"/></g></svg>
                                                                    </a>
                                                                @else
                                                                    <a href="#" aria-disabled="true" style="display: none;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="6.344px" height="10.906px" viewBox="0 0 6.344 10.906"><g><path d="M0.496,9.465l3.953-3.996L0.496,1.473c-0.344-0.315-0.352-0.63-0.021-0.945 c0.329-0.315,0.651-0.315,0.967,0L5.91,4.996c0.143,0.115,0.215,0.272,0.215,0.473c0,0.201-0.072,0.358-0.215,0.473L1.441,10.41 c-0.315,0.315-0.638,0.315-0.967,0C0.145,10.095,0.152,9.78,0.496,9.465z"/></g></svg>
                                                                    </a>
                                                                @endif
                                                            </nav>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="qodef-grid-item qodef-page-sidebar-section qodef-col--3">
                        <aside id="qodef-page-sidebar" role="complementary">

                            <div id="neoocular_core_title_widget-2" class="widget widget_neoocular_core_title_widget"
                                data-area="qodef-main-sidebar">
                                <h5 class="qodef-widget-title" style="margin-bottom: -10px">
                                    Danh mục </h5>
                            </div>
                            <div id="block-6" class="widget widget_block widget_categories"
                                data-area="qodef-main-sidebar">
                                <ul class="wp-block-categories-list wp-block-categories">
                                    @foreach ($categories as $cat)
                                        <li class="cat-item">
                                            <a href="{{ route('client.blog.index', ['category' => $cat->slug]) }}">{{ strtoupper($cat->name) }}
                                                ({{ $cat->news_count }})</a>
                                    </li>
                                    @endforeach
                                </ul>
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
                                    action="{{ route('client.blog.index') }}">
                                    <label for="qodef-search-form-1" class="qodef-search-form-label screen-reader-text">Tìm kiếm</label>
                                    <div class="qodef-search-form-inner ">
                                        <input type="search" id="qodef-search-form-1"
                                            class="qodef-search-form-field " name="q" value="{{ $query ?? '' }}"
                                            placeholder="Tìm kiếm bài viết..." required />
                                        <button type="submit" class="qodef-search-form-button  qodef--button-outside ">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                            <div id="neoocular_core_separator-2" class="widget widget_neoocular_core_separator"s
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-separator clear ">
                                    <div class="qodef-m-line" style="border-color: #ffffff;margin-top: 3px"></div>
                                </div>
                            </div>
                            <div id="neoocular_core_title_widget-5" class="widget widget_neoocular_core_title_widget"
                                data-area="qodef-main-sidebar">
                                <h5 class="qodef-widget-title" style="margin-bottom: -3px">
                                    Bài viết mới nhất </h5>
                            </div>
                            <div id="neoocular_core_simple_blog_list-3"
                                class="widget widget_neoocular_core_simple_blog_list" data-area="qodef-main-sidebar">
                                <div
                                    class="qodef-shortcode qodef-m  qodef-blog qodef-item-layout--minimal  qodef-item-layout--minimal-image qodef-grid qodef-layout--columns  qodef-gutter--no qodef-col-num--1 qodef-item-layout--minimal qodef--no-bottom-space qodef-pagination--off qodef-responsive--predefined qodef-swiper-pagination--on">
                                    <div class="qodef-grid-inner clear">
                                        @foreach ($latestNews as $item)
                                            <article class="qodef-e qodef-blog-item qodef-grid-item qodef-item--thumbnail">
                                            <div class="qodef-e-inner">
                                                <div class="qodef-e-media">
                                                        <div class="qodef-e-media-image">
                                                            <a href="{{ route('client.blog.show', $item->slug) }}">
                                                                <img loading="lazy" width="150" height="150"
                                                                    src="{{ $item->image ? asset('storage/' . $item->image) : asset('default-news.jpg') }}"
                                                                class="attachment-thumbnail size-thumbnail qodef-list-image"
                                                                    alt="" />
                                                            </a>
                                                    </div>
                                                </div>
                                                <div class="qodef-e-content">
                                                    <div class="qodef-e-top-holder" style="margin: 0 0 1px 0">
                                                            <div class="qodef-e-info">
                                                                <span
                                                                    class="entry-date published updated">{{ optional($item->published_at)->format('d/m/Y') }}</span>
                                                                <div class="qodef-info-separator-end"></div>
                                                                <a href="#">{{ $item->category->name ?? '' }}</a>
                                                            <div class="qodef-info-separator-end"></div>
                                                        </div>
                                                    </div>
                                                    <div class="qodef-e-text">
                                                            <h6 class="qodef-e-title entry-title">
                                                                <a
                                                                    href="{{ route('client.blog.show', $item->slug) }}">{{ $item->title }}</a>
                                                            </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="neoocular_core_separator-9" class="widget widget_neoocular_core_separator"
                                data-area="qodef-main-sidebar">
                                <div class="qodef-shortcode qodef-m  qodef-separator clear ">
                                    <div class="qodef-m-line"
                                        style="width: 0px;border-bottom-width: 0px;margin-top: 3px;margin-bottom: 0px">
                                    </div>
                                </div>
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
        </div>
    </div>
@endsection
