{{-- <aside class="sidebar-widget-area">


    <div class="widget widget-post mb-30">
        <h3 class="title">{{ __('Recent Posts') }}</h3>
        @foreach ($allBlogs as $blog)
            <article class="article-item mb-30">
                <div class="image">
                    <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                        class="lazy-container aspect-ratio-1-1 d-block">
                        <img class="lazyload lazy-image" src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                            data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" alt="Blog Image">
                    </a>
                </div>
                <div class="content">
                    <h6>
                        <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
                            {{ strlen($blog->title) > 60 ? mb_substr($blog->title, 0, 60, 'utf-8') . '...' : $blog->title }}
                        </a>
                    </h6>
                    <div class="time">
                        {{ $blog->created_at->diffForHumans() }}
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="widget widget-categories mb-30">
        <h3 class="title">{{ __('Categories') }}</h3>
        <ul class="list-unstyled m-0">
            @foreach ($bcats as $key => $bcat)
                <li
                    class="d-flex align-items-center justify-content-between @if (request()->input('category') == $bcat->id) active @endif">
                    <a href="{{ route('front.blogs', ['category' => $bcat->id]) }}"><i
                            class="fal fa-folder"></i>{{ $bcat->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

</aside> --}}

<aside class="sidebar-widget-area">
    <div class="widget widget-search mb-30">
        <h4 class="title">Search Posts</h4>
        <form class="search-form">
            <input type="search" class="search-input" placeholder="Search Here">
            <button class="btn-search" type="submit">
                <i class="far fa-search"></i>
            </button>
        </form>
    </div>
    <div class="widget widget-post mb-30">
        <h4 class="title">{{ __('Recent Posts') }}</h4>
        @foreach ($allBlogs as $blog)
            <article class="article-item mb-30">
                <div class="image">
                    <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                        class="lazy-container aspect-ratio-1-1 d-block">
                        <img class="lazyload lazy-image"
                            src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                            data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" alt="Blog Image">
                    </a>
                </div>
                <div class="content">
                    <h6>
                        <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
                            {{ strlen($blog->title) > 60 ? mb_substr($blog->title, 0, 60, 'utf-8') . '...' : $blog->title }}
                        </a>
                    </h6>
                    <div class="time">
                        {{ $blog->created_at->diffForHumans() }}
                    </div>
                </div>
            </article>
        @endforeach
    </div>
    <div class="widget widget-social-link mb-30">
        <h4 class="title">Follow Us</h4>
        <div class="social-link">
            @foreach ($socials as $social)
                <a href="{{ $social->url }}" target="_blank" title="Social Link"><i
                        class="{{ $social->icon }}"></i></a>
            @endforeach

        </div>
    </div>
    <div class="widget widget-categories mb-30">
        <h4 class="title">{{ __('Categories') }}</h4>
        <ul class="list-unstyled m-0">
            @foreach ($bcats as $key => $bcat)
                <li class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('front.blogs', ['category' => $bcat->id]) }}"> <i class="fal fa-folder"></i>
                        {{ $bcat->name }} </a>
                    <span class="tqy">( {{ $bcat->blogs->count() }} )</span>
                </li>
            @endforeach

        </ul>
    </div>
    <div class="widget widget-tag mb-30">
        <h4 class="title">Tags</h4>
        <ul class="list-unstyled mb-0">
            <li><a href="javaScript:void(0)">Technology</a></li>
            <li><a href="javaScript:void(0)">Business</a></li>
            <li><a href="javaScript:void(0)">Marketing</a></li>
            <li><a href="javaScript:void(0)">App</a></li>
            <li><a href="javaScript:void(0)">Social</a></li>
            <li><a href="javaScript:void(0)">Politics</a></li>
        </ul>
    </div>
</aside>
