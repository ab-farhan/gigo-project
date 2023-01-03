@extends('front.layout')

@section('pagename')
    - {{ __('Home') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->home_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : '')

@section('content')


    {{-- <!-- Home Start-->
    @if ($bs->home_section == 1)
    <section id="home" class="home-banner pb-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content mb-30" data-aos="fade-down">
                        <span class="subtitle">{{$be->hero_section_title}}<img loading="lazy" src="{{asset('assets/front/img/icon-trophy.png')}}"
                                                                               alt="Icon"></span>
                        <h1 class="title">{{$be->hero_section_text}} 
                        </h1>
                        <p class="text">{{$be->hero_section_desc}}</p>
                        <div class="content-botom d-flex align-items-center">
                            @if ($be->hero_section_button_url)
                            <a href="{{$be->hero_section_button_url}}" class="btn primary-btn">{{$be->hero_section_button_text}}</a>
                            @endif
                            @if ($be->hero_section_video_url)
                            <a href="{{$be->hero_section_video_url}}" class="btn video-btn youtube-popup"><i
                                    class="fas fa-play"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner-img image-right mb-30" data-aos="fade-right">
                        <img src="{{asset('assets/front/img/'.$be->hero_img)}}" alt="Banner Image">
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-1.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-2.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-5.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-7" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-8" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
            <img class="shape-9" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Home End -->

    <!-- partner Start  -->
    @if ($bs->partners_section == 1)
    <section class="sponsor pt-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <span class="subtitle">{{$bs->partner_title}} </span>
                        <h2 class="title">{{$bs->partner_subtitle}} </span></h2>
                        <!-- Shape -->
                        <img class="shape-1" src="{{asset('assets/front/img/shape/arrow-1.png')}}" alt="Shape">
                        <img class="shape-2" src="{{asset('assets/front/img/shape/arrow-2.png')}}" alt="Shape">
                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper sponsor-slider">
                        <div class="swiper-wrapper">

                            @foreach ($partners as $partner)
                                <div class="swiper-slide">
                                    <div class="item-single d-flex" data-aos="fade-up" data-aos-delay="100">
                                        <div class="sponsor-img">
                                            <a class="d-block" href="{{$partner->url}}" target="_blank">
                                                <img src="{{asset('assets/front/img/partners/'.$partner->image)}}" alt="Sponsor">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination" data-aos="fade-up"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- partner End -->

    <!-- Work Process Start -->
    @if ($bs->process_section == 1)
    <section class="store-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title align-items-center justify-content-between mw-100"
                         data-aos="fade-up" data-aos-delay="100">
                        <span class="subtitle">{{$bs->work_process_subtitle}}</span>
                        <h2 class="title">{{$bs->work_process_title }}</span></h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">
                        @foreach ($processes as $process)
                        <div class="col-sm-6 col-lg-6 col-xl-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="card primary mb-30">
                                <div class="card-icon green">
                                    <i class=" {{$process->icon}}"></i>
                                </div>
                                <div class="card-content">
                                    <a>
                                        <h3 class="card-title"> {{$process->title}}</h3>
                                    </a>
                                    <p class="card-text">{{$process->text}}</p>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-2.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-9.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-11.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Work Process End -->

    <!-- Template Start -->
    @if ($bs->template_section == 1)
    <section class="template-area pt-120 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <span class="subtitle">{{$bs->preview_templates_title}}</span>
                        <h2 class="title"> {{$bs->preview_templates_subtitle}}</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">

                        @foreach ($templates as $template)
                            <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="50">
                                <div class="card text-center mb-50">
                                    <div class="card-image">
                                        <a href="{{detailsUrl($template)}}" class="lazy-container">
                                            <img class="lazyload lazy-image" data-src="{{asset('assets/front/img/template-previews/' . $template->template_img)}}"
                                                 alt="Demo Image" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-1.png')}}" alt="Bg">
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-9.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-7" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-8" src="{{asset('assets/front/img/shape/shape-9.png')}}" alt="Shape">
            <img class="shape-9" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-10" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Template End -->

    <!-- Intro Start -->
    @if ($bs->intro_section == 1)
    <section class="choose-area pt-120 pb-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="choose-content mb-30" data-aos="fade-right">
                        <span class="subtitle">{{$bs->intro_title}}</span>
                        <h2 class="title">{{$bs->intro_subtitle}}</h2>
                        <p class="text">{!! nl2br($bs->intro_text) !!} </p>
                        <div class="d-flex align-items-center">

                            @if ($bs->intro_section_button_url)
                                <a href="{{$bs->intro_section_button_url}}" class="btn primary-btn">{{$bs->intro_section_button_text}}</a>
                            @endif
                            @if ($bs->intro_section_video_url)
                                    <a href="{{$bs->intro_section_video_url}}" class="btn video-btn youtube-popup"><i
                                            class="fas fa-play"></i></a>
                            @endif



                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row justify-content-center">
                        @foreach ($features as $feature)
                            <div class="col-lg-6 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="card mt-30 mb-sm-30">
                                    <div class="card-icon green">
                                        <img src="{{asset('assets/front/img/feature/'.$feature->icon)}}" alt="Barcode">
                                    </div>
                                    <div class="card-content">
                                        <a href="#">
                                            <h3 class="card-title">{{$feature->title}}</h3>
                                        </a>
                                        <p class="card-text">{{$feature->text}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
        <div class="shape">

            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-12.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-13.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-14.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Intro End -->

    <!-- Pricing Start -->
    @if ($bs->pricing_section == 1)
    <section class="pricing-area pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        <span class="subtitle">{{$bs->pricing_title}}</span>
                        <h2 class="title">{{$bs->pricing_subtitle}}</h2>

                    </div>
                </div>
                <div class="col-12">
                    @if (count($terms) > 1)
                        <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                            <ul class="nav nav-tabs">
                                @foreach ($terms as $term)

                                    <li class="nav-item">
                                        <button class="nav-link {{$loop->first ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#{{__("$term")}}"
                                                type="button">{{__("$term")}}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="tab-content">
                        @foreach ($terms as $term)
                            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}} " id="{{__("$term")}}">
                                <div class="row">
                                    @php
                                        $packages = \App\Models\Package::where('status', '1')->where('featured', '1')->where('term', strtolower($term))->get();
                                    @endphp
                                    @foreach ($packages as $package)
                                        @php
                                            $pFeatures = json_decode($package->features);
                                        @endphp
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card mb-30 {{$package->recommended == '1' ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="100">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon blue"><i class="{{ $package->icon }}"></i></div>
                                                    <div class="label">
                                                        <h3>{{$package->title}}</h3>

                                                        @if ($package->recommended == '1')
                                                            <span>{{ __('Recommended') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="text"></p>
                                                <div class="d-flex align-items-center">

                                                    <span class="price">{{$package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''}}{{$package->price == 0 ? "Free" : $package->price}}{{$package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''}}</span>
                                                    <span class="period">/ {{__("$package->term")}}</span>


                                                </div>
                                                <h5>{{ __('Whats Included') }}</h5>
                                                <ul class="item-list list-unstyled p-0">
    
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->course_categories_limit === 999999 ? __('Unlimited') : $package->course_categories_limit.' '}}{{$package->course_categories_limit ===1 ? __('Course Category'):__('Course Categories')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->course_limit === 999999 ? __('Unlimited') : $package->course_limit.' '}}{{$package->course_limit=== 1 ? __('Course'):__('Courses')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->module_limit === 999999 ? __('Unlimited') : $package->module_limit.' '}}{{$package->module_limit===1 ? __('Module'): __('Modules')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->lesson_limit === 999999 ? __('Unlimited') : $package->lesson_limit.' '}}{{$package->lesson_limit ===1 ? __('Lesson'):__('Lessons')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->featured_course_limit === 999999 ? __('Unlimited') : $package->featured_course_limit.' '}}{{$package->featured_course_limit === 1 ? __('Featured Course'):__('Featured Courses')}}
                                                    </li>
        
                                                    @foreach ($allPfeatures as $feature)
                                                        <li  class="{{is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled'}}">
                                                            <i class="{{is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times'}}"></i>
                                                            @if ($feature == 'Storage Limit')
                                                                @if ($package->storage_limit == 0 || $package->storage_limit == 999999)
                                                                    {{ __("$feature") }}
                                                                @elseif($package->storage_limit < 1024)
                                                                    {{ __("$feature"). ' ( '.$package->storage_limit .'MB )'}}
                                                                @else
                                                                    {{ __("$feature"). ' ( '. ceil($package->storage_limit/1024) .'GB )'}}
                                                                @endif
                                                            @else
                                                                {{__("$feature")}}
                                                            @endif
                                                        </li>
                                                    @endforeach

                                                </ul>
                                                <div class="d-flex align-items-center">
                                                    @if ($package->is_trial === '1' && $package->price != 0)
                                                        <a href="{{route('front.register.view',['status' => 'trial','id'=> $package->id])}}"
                                                           class="btn secondary-btn">{{__('Trial')}}</a>
                                                    @endif
                                                    @if ($package->price == 0)
                                                        <a href="{{route('front.register.view',['status' => 'regular','id'=> $package->id])}}"
                                                           class="btn primary-btn">{{__('Signup')}}</a>
                                                    @else
                                                        <a href="{{route('front.register.view',['status' => 'regular','id'=> $package->id])}}"
                                                           class="btn primary-btn">{{__('Purchase')}}</a>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-1.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-5.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-11.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Pricing End -->

    <!-- Featured Profile Start -->
    @if ($bs->featured_users_section == 1)
    <section class="user-profile-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center" data-aos="fade-up">
                        @if (!empty($bs->featured_users_title))
                            <span class="subtitle">{{$bs->featured_users_title}}</span>
                        @endif
                        @if (!empty($bs->featured_users_subtitle))
                            <h2 class="title">{{$bs->featured_users_subtitle}}</h2>
                        @endif

                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper user-slider">
                        <div class="swiper-wrapper">
                            @foreach ($featured_users as $featured_user)

                                <div class="swiper-slide">
                                    <div class="card" data-aos="fade-up" data-aos-delay="100">
                                        <div class="icon">
                                            @if ($featured_user->photo)
                                            <img class="lazy" src="{{ asset('assets/front/img/user/'.$featured_user->photo) }}"
                                                  alt="user">
                                            @else
                                                <img class="lazy" src="{{ asset('assets/admin/img/propics/blank_user.jpg') }}"
                                                          alt="user">
                                            @endif

                                        </div>
                                        <div class="card-content blue">
                                            <h3 class="card-title">{{$featured_user->first_name." ".$featured_user->last_name}}</h3>


                                            <div class="social-link">


                                                <div class="social-link">
                                                    @foreach ($featured_user->social_media as $social)
                                                        <a href="{{$social->url}}" target="_blank"><i
                                                                class="{{$social->icon}}"></i></a>
                                                    @endforeach
                                                </div>

                                            </div>

                                            <div class="cta-btns">
                                                @php
                                                    if (!empty($featured_user)) {
                                                        $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($featured_user->id);
                                                        $preferences = App\Models\User\UserPermission::where([
                                                            ['user_id',$featured_user->id],
                                                            ['package_id',$currentPackage->package_id]
                                                        ])->first();
                                                        $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                                    }
                                                @endphp
                                                <a href="{{detailsUrl($featured_user)}}" class="btn btn-sm secondary-btn">{{ __("View Profile") }}</a>
                                                @guest
                                                    @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))

                                                        <a href="{{route('user.follow',['id' => $featured_user->id])}}" class="btn btn-sm primary-btn"><i class="fal fa-user-plus"></i>{{__('Follow')}}
                                                        </a>

                                                    @endif
                                                @endguest
                                                @if (Auth::check() && Auth::id() != $featured_user->id)
                                                    @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))

                                                        @if (App\Models\User\Follower::where('follower_id', Auth::id())->where('following_id', $featured_user->id)->count() > 0)
                                                            <a href="{{route('user.unfollow', $featured_user->id)}}" class="btn btn-sm primary-btn"><i class="fal fa-user-minus"></i>{{__('Unfollow')}}
                                                            </a>
                                                        @else
                                                            <a href="{{route('user.follow',['id' => $featured_user->id])}}" class="btn btn-sm primary-btn"><i class="fal fa-user-plus"></i>{{__('Follow')}}
                                                                @endif
                                                            </a>

                                                        @endif
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination" data-aos="fade-up"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Featured Profile End -->

    <!-- Testimonial Start -->
    @if ($bs->testimonial_section == 1)
    <section class="testimonial-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title ms-0" data-aos="fade-right">
                        <span class="subtitle">{{$bs->testimonial_subtitle}}</span>
                    @if (!empty($bs->testimonial_title))
                            <h2 class="title">{{$bs->testimonial_title}}</h2>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center gx-xl-5">
                        <div class="col-lg-6">
                            <div class="image image-left" data-aos="fade-right">
                                <img src="{{asset('assets/front/img/testimonials/'.$be->testimonial_img)}}" alt="Banner Image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="swiper testimonial-slider" data-aos="fade-left">
                                <div class="swiper-wrapper">

                                    @for ($i = 0; $i <= count($testimonials); $i = $i + 2)
                                        @if ($i < count($testimonials) - 1)
                                            <div class="swiper-slide">

                                                <div class="slider-item">
                                                    <div class="quote">
                                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                                        <p class="text">
                                                            {{$testimonials[$i]->comment}}
                                                        </p>
                                                    </div>
                                                    <div class="client">
                                                        <div class="image">
                                                            <div class="lazy-container aspect-ratio-1-1">
                                                                <img class="lazyload lazy-image"
                                                                     data-src="{{$testimonials[$i]->image ? asset('assets/front/img/testimonials/'. $testimonials[$i]->image) : asset('assets/front/img/thumb-1.jpg')}}"
                                                                     alt="Person Image">
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name">{{$testimonials[$i]->name}}</h6>
                                                            <span class="designation">{{$testimonials[$i]->rank}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="slider-item">
                                                    <div class="quote">
                                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                                        <p class="text">
                                                            {{$testimonials[$i+1]->comment}}
                                                        </p>
                                                    </div>
                                                    <div class="client">
                                                        <div class="image">
                                                            <div class="lazy-container aspect-ratio-1-1">
                                                                <img class="lazyload lazy-image"
                                                                     data-src="{{$testimonials[$i+1]->image ? asset('assets/front/img/testimonials/'. $testimonials[$i+1]->image) : asset('assets/front/img/thumb-1.jpg')}}"
                                                                     alt="Person Image">
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name">{{$testimonials[$i+1]->name}}</h6>
                                                            <span class="designation">{{$testimonials[$i+1]->rank}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    @endfor

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-1.png')}}" alt="Bg">
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
        </div>
    </section>
    @endif
    <!-- Testimonial End -->

    <!-- Blog Start -->
    @if ($bs->news_section == 1)
    <section class="blog-area ptb-90">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <span class="subtitle">{{$bs->blog_subtitle}}</span>

                @if (!empty($bs->blog_title))
                    <h2 class="title">{{$bs->blog_title}}</h2>
                @endif
            </div>
            <div class="row justify-content-center">

                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-image">
                                <a href="{{route('front.blogdetails',['id' => $blog->id,'slug' => $blog->slug])}}" class="lazy-container aspect-ratio-16-9">
                                    <img class="lazyload lazy-image" data-src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Banner Image">
                                </a>
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>{{ __("Admin") }}</li>
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
                                <a href="#" class="card-btn">{{__("Read More")}}</a>
                            </div>
                        </article>
                    </div>
                @endforeach
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
    </section>
    @endif
    <!-- Blog End --> --}}

    @if ($bs->home_section == 1)
        <!-- Home Start-->
        <section id="home" class="home-banner bg-primary-light pb-120">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="fluid-left">
                            <div class="content mb-30">
                                <span class="subtitle bg-primary-light color-primary" data-aos="fade-up">
                                    {{ $be->hero_section_title }} </span>
                                <h1 class="title" data-aos="fade-up" data-aos-delay="100">
                                    {{ $be->hero_section_text }}
                                </h1>
                                <p data-aos="fade-up" data-aos-delay="150">
                                    We are elite author at envato, We help you to build
                                    your own booking website easy way
                                </p>
                                <div class="btn-groups" data-aos="fade-up" data-aos-delay="200">
                                    {{-- <a href="javaScript:void(0)" class="btn btn-lg btn-primary" title="Build Your Website"
                                        target="_self">Build Your Website</a> --}}

                                    @if ($be->hero_section_button_url)
                                        <a href="{{ $be->hero_section_button_url }}"
                                            title="{{ $be->hero_section_button_text }}"
                                            class="btn btn-lg btn-primary">{{ $be->hero_section_button_text }}</a>
                                    @endif
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline" title="View Demo"
                                        target="_self">View Demo</a>
                                    {{-- @if ($be->hero_section_video_url)
                                        <a href="{{ $be->hero_section_video_url }}" class="btn video-btn youtube-popup"><i
                                                class="fas fa-play"></i>
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="fluid-auto">
                            <div class="banner-img mb-30" data-aos="fade-left">
                                <img src="{{ asset('assets/front/img/' . $be->hero_img) }}" alt="Banner Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-1.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-2.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-10" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-11" src="{{ asset('/') }}assets/front/images/shape/shape-5.png" alt="Shape">
            </div>
        </section>
        <!-- Home End -->
    @endif

    @if ($bs->partners_section == 1)
        <!-- Sponsor Start  -->
        <section class="sponsor pt-120">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <span class="subtitle">{{ $bs->partner_title }} </span>
                            <h2 class="title">{{ $bs->partner_subtitle }} </h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper sponsor-slider">
                            <div class="swiper-wrapper">
                                @foreach ($partners as $partner)
                                    <div class="swiper-slide">
                                        <div class="item-single d-flex justify-content-center">
                                            <div class="sponsor-img">
                                                <img class="lazyload blur-up"
                                                    src="{{ asset('assets/front/img/partners/' . $partner->image) }}"
                                                    alt="Sponsor">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="swiper-slide">
                                    <div class="item-single d-flex justify-content-center">
                                        <div class="sponsor-img">
                                            <img class="lazyload blur-up"
                                                src="{{ asset('/') }}assets/front/images/sponsor-2.png" alt="Sponsor">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item-single d-flex justify-content-center">
                                        <div class="sponsor-img">
                                            <img class="lazyload blur-up"
                                                src="{{ asset('/') }}assets/front/images/sponsor-3.png" alt="Sponsor">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item-single d-flex justify-content-center">
                                        <div class="sponsor-img">
                                            <img src="{{ asset('/') }}assets/front/images/sponsor-4.png" alt="Sponsor">
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="swiper-pagination position-static mt-30" data-aos="fade-up"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sponsor End -->
    @endif

    @if ($bs->process_section == 1)
        <!-- Store Start -->
        <section class="store-area pt-120 pb-90">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title title-inline mb-50" data-aos="fade-up">
                            <h2 class="title">{{ $bs->work_process_title }}</h2>

                            <a href="{{ route('front.pricing') }}" class="btn btn-lg btn-primary" title="Purchase Now"
                                target="_self">Purchase Now</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center">
                            @foreach ($processes as $process)
                                <div class="col-sm-6 col-lg-4 col-xl-3 mb-30 item" data-aos="fade-up">
                                    <div class="card">
                                        <div class="card-icon">
                                            <i class=" {{ $process->icon }} "></i>
                                        </div>
                                        <div class="card-content">
                                            <a href="javaScript:void(0)">
                                                <h4 class="card-title lc-1">{{ $process->title }}</h4>
                                            </a>
                                            <p class="card-text lc-2">{{ $process->text }}</p>
                                            <a href="{{ route('front.pricing') }}" class="btn-text color-primary"
                                                title="Title" target="_self">Purchase Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
            </div>
        </section>
        <!-- Store End -->
    @endif

    @if ($bs->template_section == 1)
        <!-- Template Start -->
        <section class="template-area bg-primary-light ptb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <span class="subtitle">{{ $bs->preview_templates_title }}</span>
                            <h2 class="title mt-0">{{ $bs->preview_templates_subtitle }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center">
                            @foreach ($templates as $template)
                                <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                                    <div class="card text-center mb-50">
                                        <div class="card-image">
                                            <a href="javaScript:void(0)" class="lazy-container" title="Image"
                                                target="_self">
                                                <img class="lazyload lazy-image"
                                                    data-src="{{ asset('assets/front/img/template-previews/' . $template->template_img) }}"
                                                    alt="Demo Image" />
                                            </a>
                                        </div>
                                        <h4 class="card-title">
                                            <a href="javaScript:void(0)" title="Link" target="_self">
                                                01 - Home Demo
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                                <div class="card text-center mb-50">
                                    <div class="card-image">
                                        <a href="javaScript:void(0)" class="lazy-container" title="Image"
                                            target="_self">
                                            <img class="lazyload lazy-image"
                                                data-src="{{ asset('/') }}assets/front/images/template/template-2.png"
                                                alt="Demo Image" />
                                        </a>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="javaScript:void(0)" title="Link" target="_self">
                                            02 - Home Demo
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                                <div class="card text-center mb-50">
                                    <div class="card-image">
                                        <a href="javaScript:void(0)" class="lazy-container" title="Image"
                                            target="_self">
                                            <img class="lazyload lazy-image"
                                                data-src="{{ asset('/') }}assets/front/images/template/template-3.png"
                                                alt="Demo Image" />
                                        </a>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="javaScript:void(0)" title="Link" target="_self">
                                            03 - Home Demo
                                        </a>
                                    </h4>
                                </div>
                            </div> --}}
                            <div class="col-12 text-center">
                                <a href="javaScript:void(0)" class="btn btn-lg btn-primary" title="More Template"
                                    target="_self">More Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-9.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-7" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-8" src="{{ asset('/') }}assets/front/images/shape/shape-9.png" alt="Shape">
                <img class="shape-9" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-10" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
            </div>
        </section>
        <!-- Template End -->
    @endif

    @if ($bs->intro_section == 1)
        <!-- Choose Start -->
        <section class="choose-area pt-120 pb-90">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="choose-content mb-30 pe-lg-5" data-aos="fade-right">
                            <span class="subtitle">{{ $bs->intro_title }}</span>
                            <h2 class="title">{{ $bs->intro_subtitle }}</h2>
                            <p class="text">{!! nl2br($bs->intro_text) !!}</p>
                            {{-- <ul class="choose-list list-unstyled p-0">
                                <li>
                                    <span><i class="fal fa-check-double"></i></span>We completed 500+ client’s projects
                                </li>
                                <li>
                                    <span><i class="fal fa-check-double"></i></span>We have 10+ multiple developer
                                </li>
                                <li>
                                    <span><i class="fal fa-check-double"></i></span>100+ active client’s working with us
                                </li>
                                <li>
                                    <span><i class="fal fa-check-double"></i></span>Your trusted business partner
                                </li>
                            </ul> --}}
                            @if ($bs->intro_section_button_url)
                                <a href="{{ $bs->intro_section_button_url }}"
                                    class="btn btn-lg btn-primary">{{ $bs->intro_section_button_text }}</a>
                            @endif

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            @foreach ($features as $feature)
                                <div class="col-sm-6 item" data-aos="fade-up">
                                    <div class="card mb-30">
                                        <div class="card-icon">
                                            <img src="{{ asset('assets/front/img/feature/' . $feature->icon) }}"
                                                alt="Icon">
                                        </div>
                                        <div class="card-content">
                                            <a href="#">
                                                <h4 class="card-title lc-1">{{ $feature->title }}</h4>
                                            </a>
                                            <p class="card-text">{{ $feature->text }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-11.png" alt="Shape">
            </div>
        </section>
        <!-- Choose End -->
    @endif

    @if ($bs->pricing_section == 1)
        <!-- Pricing Start -->
        <section class="pricing-area pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            <span class="subtitle">{{ $bs->pricing_title }}</span>
                            <h2 class="title mb-2 mt-0"> {{ $bs->pricing_subtitle }} </h2>
                            <p class="text">Curabitur non nulla sit amet nisl tempus lectus Nulla porttitor accumsan
                                tincidunt.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        @if (count($terms) > 1)
                            <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                                <ul class="nav nav-tabs">
                                    @foreach ($terms as $term)
                                        <li class="nav-item">
                                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                data-bs-toggle="tab" data-bs-target="#{{ __("$term") }}"
                                                type="button">{{ __("$term") }}</button>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        @endif
                        <div class="tab-content">
                            @foreach ($terms as $term)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ __("$term") }}">
                                    <div class="row justify-content-center">
                                        @php
                                            $packages = \App\Models\Package::where('status', '1')
                                                ->where('featured', '1')
                                                ->where('term', strtolower($term))
                                                ->get();
                                        @endphp
                                        @foreach ($packages as $package)
                                            @php
                                                $pFeatures = json_decode($package->features);
                                            @endphp
                                            <div class="col-md-6 col-lg-4 item">
                                                <div class="card mb-30 {{ $package->recommended == '1' ? 'active' : '' }}"
                                                    data-aos="fade-up" data-aos-delay="100">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon"><i class="{{ $package->icon }}"></i></div>
                                                        <div class="label">
                                                            <h4>{{ $package->title }}</h4>
                                                            @if ($package->recommended == '1')
                                                                <span>{{ __('Recommended') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <p class="text">

                                                    </p>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="price">{{ $package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ $package->price == 0 ? 'Free' : $package->price }}{{ $package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                        <span class="period">/ {{ __("$package->term") }}</span>
                                                    </div>
                                                    <h5>What's Included</h5>
                                                    <ul class="pricing-list list-unstyled p-0">
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ $package->course_categories_limit === 999999 ? __('Unlimited') : $package->course_categories_limit . ' ' }}{{ $package->course_categories_limit === 1 ? __('Course Category') : __('Course Categories') }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ $package->course_limit === 999999 ? __('Unlimited') : $package->course_limit . ' ' }}{{ $package->course_limit === 1 ? __('Course') : __('Courses') }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ $package->module_limit === 999999 ? __('Unlimited') : $package->module_limit . ' ' }}{{ $package->module_limit === 1 ? __('Module') : __('Modules') }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ $package->lesson_limit === 999999 ? __('Unlimited') : $package->lesson_limit . ' ' }}{{ $package->lesson_limit === 1 ? __('Lesson') : __('Lessons') }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ $package->featured_course_limit === 999999 ? __('Unlimited') : $package->featured_course_limit . ' ' }}{{ $package->featured_course_limit === 1 ? __('Featured Course') : __('Featured Courses') }}
                                                        </li>

                                                        @foreach ($allPfeatures as $feature)
                                                            <li
                                                                class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled' }}">
                                                                <i
                                                                    class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times' }}"></i>
                                                                @if ($feature == 'Storage Limit')
                                                                    @if ($package->storage_limit == 0 || $package->storage_limit == 999999)
                                                                        {{ __("$feature") }}
                                                                    @elseif($package->storage_limit < 1024)
                                                                        {{ __("$feature") . ' ( ' . $package->storage_limit . 'MB )' }}
                                                                    @else
                                                                        {{ __("$feature") . ' ( ' . ceil($package->storage_limit / 1024) . 'GB )' }}
                                                                    @endif
                                                                @else
                                                                    {{ __("$feature") }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="btn-groups">


                                                        @if ($package->is_trial === '1' && $package->price != 0)
                                                            <a href="{{ route('front.register.view', ['status' => 'trial', 'id' => $package->id]) }}"
                                                                class="btn btn-lg btn-primary no-animation">{{ __('Trial') }}</a>
                                                        @endif
                                                        @if ($package->price == 0)
                                                            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                                class="btn btn-lg btn-primary no-animation">{{ __('Signup') }}</a>
                                                        @else
                                                            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                                class="btn btn-lg btn-outline no-animation">{{ __('Purchase') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-11.png" alt="Shape">
            </div>
        </section>
        <!-- Pricing End -->
    @endif
    @if ($bs->featured_users_section == 1)
        <!-- User Profile Start -->
        <section class="user-profile-area pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="section-title title-center mb-50" data-aos="fade-up">
                            @if (!empty($bs->featured_users_title))
                                <span class="subtitle">{{ $bs->featured_users_title }}</span>
                            @endif
                            @if (!empty($bs->featured_users_subtitle))
                                <h2 class="title">{{ $bs->featured_users_subtitle }}</h2>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper user-slider" data-aos="fade-up">
                            <div class="swiper-wrapper">
                                @foreach ($featured_users as $featured_user)
                                    <div class="swiper-slide">
                                        <div class="card">
                                            <div class="icon">
                                                @if ($featured_user->photo)
                                                    <img class="lazy"
                                                        src="{{ asset('assets/front/img/user/' . $featured_user->photo) }}"
                                                        alt="user">
                                                @else
                                                    <img class="lazy"
                                                        src="{{ asset('assets/admin/img/propics/blank_user.jpg') }}"
                                                        alt="user">
                                                @endif
                                            </div>
                                            <div class="card-content">
                                                <h4 class="card-title">
                                                    {{ $featured_user->first_name . ' ' . $featured_user->last_name }}
                                                </h4>
                                                <div class="social-link">
                                                    <a href="https://www.instagram.com/" target="_blank"><i
                                                            class="fab fa-instagram"></i></a>
                                                    <a href="https://www.dribbble.com/" target="_blank"><i
                                                            class="fab fa-dribbble"></i></a>
                                                    <a href="https://www.twitter.com/" target="_blank"><i
                                                            class="fab fa-twitter"></i></a>
                                                    <a href="https://www.youtube.com/" target="_blank"><i
                                                            class="fab fa-youtube"></i></a>
                                                </div>
                                                <div class="btn-groups">
                                                    {{-- <a href="javaScript:void(0)" class="btn btn-sm btn-outline"
                                                    title="View Profile" target="_self">View Profile</a>
                                                <a href="javaScript:void(0)" class="btn btn-sm btn-primary"
                                                    title="Follow Us" target="_self">Follow Us</a> --}}
                                                    @php
                                                        if (!empty($featured_user)) {
                                                            $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($featured_user->id);
                                                            $preferences = App\Models\User\UserPermission::where([['user_id', $featured_user->id], ['package_id', $currentPackage->package_id]])->first();
                                                            $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                                        }
                                                    @endphp
                                                    <a href="{{ detailsUrl($featured_user) }}"
                                                        class="btn btn-sm btn-outline">{{ __('View Profile') }}</a>
                                                    @guest
                                                        @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))
                                                            <a href="{{ route('user.follow', ['id' => $featured_user->id]) }}"
                                                                class="btn btn-sm btn-primary"> {{ __('Follow') }}
                                                            </a>
                                                        @endif
                                                    @endguest
                                                    @if (Auth::check() && Auth::id() != $featured_user->id)
                                                        @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))
                                                            @if (App\Models\User\Follower::where('follower_id', Auth::id())->where('following_id', $featured_user->id)->count() > 0)
                                                                <a href="{{ route('user.unfollow', $featured_user->id) }}"
                                                                    class="btn btn-sm btn-primary"> {{ __('Unfollow') }}
                                                                </a>
                                                            @else
                                                                <a href="{{ route('user.follow', ['id' => $featured_user->id]) }}"
                                                                    class="btn btn-sm btn-primary"> {{ __('Follow') }}
                                                            @endif
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="swiper-pagination position-static mt-30"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-8.png" alt="Shape">
            </div>
        </section>
        <!-- User Profile End -->
    @endif
    @if ($bs->testimonial_section == 1)
        <!-- Testimonial Start -->
        <section class="testimonial-area">
            <div class="container">
                <div class="row align-items-center gx-xl-5">
                    <div class="col-lg-6">
                        <div class="content mb-30" data-aos="fade-up">
                            <h2 class="title">{{ $bs->testimonial_title }}</h2>

                        </div>
                        <div class="swiper testimonial-slider mb-30" data-aos="fade-up">
                            <div class="swiper-wrapper">

                                @foreach ($testimonials as $testimonial)
                                    <div class="swiper-slide">
                                        <div class="slider-item bg-primary-light">
                                            <div class="ratings justify-content-between size-md">
                                                <div class="rate">
                                                    <div class="rating-icon"></div>
                                                </div>
                                                <span class="ratings-total">5 star of 20 review</span>
                                            </div>
                                            <div class="quote">
                                                <p class="text mb-0">
                                                    {{ $testimonial->comment }}
                                                </p>
                                            </div>
                                            <div class="client flex-wrap">
                                                <div class="client-info d-flex align-items-center">
                                                    <div class="client-img">
                                                        <div class="lazy-container ratio ratio-1-1">
                                                            <img class="lazyload"
                                                                data-src="{{ $testimonial->image ? asset('assets/front/img/testimonials/' . $testimonial->image) : asset('assets/front/img/thumb-1.jpg') }}"
                                                                alt="Person Image">
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h6 class="name">{{ $testimonial->name }}</h6>
                                                        <span class="designation">{{ $testimonial->rank }}</span>
                                                    </div>
                                                </div>
                                                <span class="icon"><i class="fas fa-quote-right"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="swiper-pagination" id="testimonial-slider-pagination" data-min data-max></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="image mb-30 img-right" data-aos="fade-left">
                            <img src="{{ asset('assets/front/img/testimonials/' . $be->testimonial_img) }}"
                                alt="Image">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-8.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
            </div>
        </section>
        <!-- Testimonial End -->
    @endif

    @if ($bs->news_section == 1)
        <!-- Blog Start -->
        <section class="blog-area ptb-90">
            <div class="container">
                <div class="section-title title-inline mb-50" data-aos="fade-up">
                    <h2 class="title">{{ $bs->blog_title }}</h2>
                    {{-- <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                        class="btn btn-lg btn-primary" title="Read More" target="_self">Read
                        More</a> --}}
                </div>
                <div class="row justify-content-center">
                    @foreach ($blogs as $blog)
                        <div class="col-md-6 col-lg-4">
                            <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                <div class="card-image">
                                    <a href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                                        class="lazy-container ratio-16-9">
                                        <img class="lazyload lazy-image"
                                            src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                            data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                            alt="Blog Image">
                                    </a>
                                    <ul class="info-list">
                                        <li><i class="fal fa-user"></i>{{ __('Admin') }}</li>
                                        <li><i
                                                class="fal fa-calendar"></i>{{ \Carbon\Carbon::parse($blog->created_at)->format('d m, Y') }}
                                        </li>
                                        <li><i class="fal fa-tag"></i>{{ $blog->bcategory->name }}</li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <h5 class="card-title lc-2">
                                        <a
                                            href="{{ route('front.blogdetails', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
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

                </div>
            </div>
            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('/') }}assets/front/images/shape/shape-10.png" alt="Shape">
                <img class="shape-2" src="{{ asset('/') }}assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-3" src="{{ asset('/') }}assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-4" src="{{ asset('/') }}assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-5" src="{{ asset('/') }}assets/front/images/shape/shape-3.png" alt="Shape">
                <img class="shape-6" src="{{ asset('/') }}assets/front/images/shape/shape-8.png" alt="Shape">
            </div>
        </section>
    @endif
    <!-- Blog End -->

@endsection
