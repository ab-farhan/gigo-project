@extends('front.layout')

@section('pagename')
    - {{ __('Blog Details') }}
@endsection

@section('meta-description', !empty($blog) ? $blog->meta_keywords : '')
@section('meta-keywords', !empty($blog) ? $blog->meta_description : '')

@section('og-meta')
    <meta property="og:image" content="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">
@endsection

@section('breadcrumb-title')
    {{ strlen($blog->title) > 30 ? mb_substr($blog->title, 0, 30) . '...' : $blog->title }}
@endsection
@section('breadcrumb-link')
    {{ __('Blog Details') }}
@endsection

@section('content')

    <!--====== BLOG DETAILS PART START ======-->

    <!-- Blog Details Start -->
    <div class="blog-details-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center gx-xl-5">
                <div class="col-lg-8">
                    {{-- <div class="blog-description mb-50">
                        <article class="item-single">
                            <div class="image">
                                <div class="lazy-container aspect-ratio-16-9">
                                    <img class="lazyload lazy-image" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                         data-src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Blog Image">
                                </div>
                            </div>
                            <div class="content">
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>{{__('Admin')}}</li>
                                    <li><i class="fal fa-calendar"></i>{{\Carbon\Carbon::parse($blog->created_at)->format("F j, Y")}}</li>
                                    <li><i class="fal fa-tag"></i><a
                                        href="{{route('front.blogs', ['category'=>$blog->bcategory->id])}}">{{$blog->bcategory->name}}</a></li>
                                </ul>
                                <h3 class="title">
                                    {{$blog->title}}
                                </h3>
                                <div class="summernote-content">
                                    {!! replaceBaseUrl($blog->content) !!}
                                </div>
                            </div>
                            <div class="blog-social">
                                <div class="shop-social d-flex align-items-center">
                                    <span>{{__('Share')}} :</span>
                                    <ul>
                                        <li class="p-1"><a href="//www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"><i class="fab fa-facebook-f"></i></a></li>
                                        <li class="p-1"><a href="//twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}"><i class="fab fa-twitter"></i></a></li>
                                        <li class="p-1"><a href="//www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title={{$blog->title}}"><i class="fab fa-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </article>


                    </div> --}}
                    <div class="blog-description mb-50">
                        <article class="item-single">
                            <div class="image">
                                <div class="lazy-container ratio-16-9">
                                    <img class="lazyload lazy-image"
                                        src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                        data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                        alt="Blog Image">
                                </div>
                                <a href="//twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"
                                    class="btn btn-lg btn-primary"><i class="fas fa-share-alt"></i>Share</a>
                            </div>
                            <div class="content">
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>Admin</li>
                                    <li> <i class="fal fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($blog->created_at)->format('d m, Y') }}
                                    </li>
                                    <li><i class="fal fa-tag"></i>
                                        {{ route('front.blogs', ['category' => $blog->bcategory->id]) }}">{{ $blog->bcategory->name }}
                                    </li>
                                </ul>
                                <h4 class="title">
                                    {{ $blog->title }}
                                </h4>
                                {!! replaceBaseUrl($blog->content) !!}
                            </div>
                        </article>
                    </div>
                    <div class="comments mb-30">
                        <div class="comment-box mb-50">
                            <span class="h3 d-block mb-20">Comments</span>
                            <ol class="comment-list">
                                <li class="comment">
                                    <div class="comment-body">
                                        <div class="comment-author">
                                            <div class="lazy-container ratio-1-1">
                                                <img class="lazyload lazy-image"
                                                    src="{{ asset('') }}/assets/front/images/placeholder.png"
                                                    data-src="{{ asset('') }}/assets/front/images/client/client-1.jpg"
                                                    alt="image" />
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            <h5 class="name">Adam Haul</h5>
                                            <p>
                                                Quality control of your data including read length distribution and
                                                uniformity assessment in a few clicks and choose your favorite. name
                                                this.
                                            </p>
                                            <a href="javaScript:void(0)" class="btn-reply"><i
                                                    class="fas fa-reply-all"></i>Reply</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="comment">
                                    <div class="comment-body">
                                        <div class="comment-author">
                                            <div class="lazy-container ratio-1-1">
                                                <img class="lazyload lazy-image"
                                                    src="{{ asset('') }}/assets/front/images/placeholder.png"
                                                    data-src="{{ asset('') }}/assets/front/images/client/client-2.jpg"
                                                    alt="image" />
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            <h5 class="name">David Murphy</h5>
                                            <p>
                                                Quality control of your data including read length distribution and
                                                uniformity assessment in a few clicks and choose your favorite. name
                                                this.
                                            </p>
                                            <a href="javaScript:void(0)" class="btn-reply"><i
                                                    class="fas fa-reply-all"></i>Reply</a>
                                        </div>
                                    </div>
                                    <ol class="children">
                                        <li class="comment">
                                            <div class="comment-body">
                                                <div class="comment-author">
                                                    <div class="lazy-container ratio-1-1">
                                                        <img class="lazyload lazy-image"
                                                            src="{{ asset('') }}/assets/front/images/placeholder.png"
                                                            data-src="{{ asset('') }}/assets/front/images/client/client-3.jpg"
                                                            alt="image" />
                                                    </div>
                                                </div>
                                                <div class="comment-content">
                                                    <h5 class="name">Harry jain</h5>
                                                    <p>
                                                        Quality control of your data including read length distribution
                                                        and uniformity assessment in a few clicks and choose your
                                                        favorite. name this.
                                                    </p>
                                                    <a href="javaScript:void(0)" class="btn-reply"><i
                                                            class="fas fa-reply-all"></i>Reply</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                        <div class="comment-reply mb-30">
                            <span class="h3 d-block">Post Comment</span>
                            <p class="comment-notes">
                                <span id="email-notes">Your email address will not be published.</span>
                                Required fields are marked
                                <span class="required">*</span>
                            </p>
                            <form id="commentForm" class="comment-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-20">
                                            <input type="text" class="form-control" name="name" placeholder=" Name*"
                                                required="required" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-20">
                                            <input type="email" class="form-control" name="email" placeholder=" Email*"
                                                required="required" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-30">
                                            <textarea name="message" class="form-control" placeholder="Comment" required="required" rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary">
                                    Post Comment
                                </button>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="blog-details-comment mt-5">
                        <div class="comment-lists">
                            <div id="disqus_thread"></div>
                        </div>
                    </div> --}}

                </div>
                <div class="col-lg-4">
                    @includeIf('front.partials.blog-sidebar')
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Details End -->



    <!--====== BLOG DETAILS PART ENDS ======-->


@endsection

@if ($bs->is_disqus == 1)
    @section('scripts')
        <script>
            "use strict";
            (function() {
                var d = document,
                    s = d.createElement('script');
                s.src = '//{{ $bs->disqus_shortname }}.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d. || d.body).appendChild(s);
            })();
        </script>
    @endsection
@endif
