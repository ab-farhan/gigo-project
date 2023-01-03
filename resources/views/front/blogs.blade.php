@extends('front.layout')

@section('pagename')
    - {{ __('Blog') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->blogs_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->blogs_meta_keywords : '')

@section('breadcrumb-title')
    {{ __('Blog') }}
@endsection
@section('breadcrumb-link')
    {{ __('Blog') }}
@endsection

@section('content')

    <!--====== Start saas-blog section ======-->


    {{-- <section class="blog-area pb-90 pt-120">
        <div class="container">

            <div class="row justify-content-center">

                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-image">
                                <a href="{{route('front.blogdetails',['id' => $blog->id,'slug' => $blog->slug])}}" class="lazy-container aspect-ratio-16-9">
                                    <img class="lazyload lazy-image" data-src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Banner Image">
                                </a>
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>{{__('Admin')}}</li>
                                    <li><i class="fal fa-calendar"></i>{{\Carbon\Carbon::parse($blog->created_at)->format("F j, Y")}}</li>
                                    <li><i class="fal fa-tag"></i>{{$blog->bcategory->name}}</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h3 class="card-title">
                                    <a href="{{route('front.blogdetails',['id' => $blog->id,'slug' => $blog->slug])}}">
                                        {{strlen($blog->title) > 55 ? mb_substr($blog->title, 0, 55, 'utf-8') . '...' : $blog->title }}
                                    </a>
                                </h3>
                                <p class="card-text">
                                    {!!  substr(strip_tags($blog->content), 0, 150) !!}

                                </p>
                                <a href="#" class="card-btn">Read More</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="pagination mb-30 justify-content-center">
                {{$blogs->appends(['category' => request()->input('category')])->links()}}
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-1.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
        </div>
    </section> --}}
    <section class="blog-area ptb-120">
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-image">
                                <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                                    class="lazy-container ratio-16-9">
                                    <img class="lazyload lazy-image" {{-- src="assets/images/placeholder.png" --}}
                                        data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                        alt="Blog Image">
                                </a>
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>{{ __('Admin') }}</li>
                                    <li><i class="fal fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}
                                    </li>
                                    <li><i class="fal fa-tag"></i>{{ $blog->bcategory->name }}</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h5 class="card-title lc-2">
                                    <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
                                        {{ strlen($blog->title) > 55 ? mb_substr($blog->title, 0, 55, 'utf-8') . '...' : $blog->title }}
                                    </a>
                                </h5>
                                <p class="card-text lc-2">
                                    {!! substr(strip_tags($blog->content), 0, 150) !!}
                                </p>
                                <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                                    class="card-btn">Read More</a>
                            </div>
                        </article>
                    </div>
                @endforeach
                {{-- <div class="col-md-6 col-lg-4">
                    <article class="card mb-30" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-image">
                            <a href="blog-details.html" class="lazy-container ratio-16-9">
                                <img class="lazyload lazy-image" src="assets/images/placeholder.png"
                                    data-src="{{ asset('') }}/assets/front/images/blog/blog-2.jpg" alt="Blog Image">
                            </a>
                            <ul class="info-list">
                                <li><i class="fal fa-user"></i>Admin</li>
                                <li><i class="fal fa-calendar"></i>08 Dec 2022</li>
                                <li><i class="fal fa-tag"></i>Business</li>
                            </ul>
                        </div>
                        <div class="content">
                            <h5 class="card-title lc-2">
                                <a href="blog-details.html">
                                    Top 10 most popular education Website template for online shopping.
                                </a>
                            </h5>
                            <p class="card-text lc-2">
                                It is a long established fact that a reader will be by the readable content of a page
                                when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                normal distribution of letters
                            </p>
                            <a href="javaScript:void(0)" class="card-btn">Read More</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="card mb-30" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-image">
                            <a href="blog-details.html" class="lazy-container ratio-16-9">
                                <img class="lazyload lazy-image" src="assets/images/placeholder.png"
                                    data-src="{{ asset('') }}/assets/front/images/blog/blog-3.jpg" alt="Blog Image">
                            </a>
                            <ul class="info-list">
                                <li><i class="fal fa-user"></i>John</li>
                                <li><i class="fal fa-calendar"></i>11 May 2022</li>
                                <li><i class="fal fa-tag"></i>Software</li>
                            </ul>
                        </div>
                        <div class="content">
                            <h5 class="card-title lc-2">
                                <a href="blog-details.html">
                                    Top 10 most popular education Website template for online shopping.
                                </a>
                            </h5>
                            <p class="card-text lc-2">
                                It is a long established fact that a reader will be by the readable content of a page
                                when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                normal distribution of letters
                            </p>
                            <a href="javaScript:void(0)" class="card-btn">Read More</a>
                        </div>
                    </article>
                </div> --}}
            </div>

            <nav class="pagination-nav" data-aos="fade-up">

                <ul class="pagination justify-content-center mb-0">
                    {{ $blogs->appends(['category' => request()->input('category')])->links() }}
                    {{--
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="far fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="far fa-angle-right"></i>
                        </a>
                    </li> --}}
                </ul>
            </nav>
        </div>
    </section>
    <!--====== End saas-blog section ======-->


@endsection
