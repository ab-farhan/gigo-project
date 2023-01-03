@extends('user-front.common.layout')

@section('pageHeading')
    {{$keywords["Home"] ?? "Home"}}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->home_meta_keywords }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->home_meta_description }}
  @endif
@endsection

@section('style')
  @if ($secInfo->newsletter_section_status == 1 && !empty($newsletterData))
    <style>
      .community-area::before {
        background-image: url({{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE,$newsletterData->background_image,$userBs) }});
      }
    </style>
  @endif
@endsection

@section('content')
  <!--====== BANNER PART START ======-->
  <section class="banner-area bg_cover lazy" 
  @if (!empty($heroInfo)) 
    data-bg="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_HERO_SECTION_IMAGE,$heroInfo->background_image,$userBs)}}" 
  @else 
    data-bg="{{ asset('assets/tenant/image/static/hero.jpeg') }}" 
  @endif>
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div class="banner-content">
            <span>{{ !empty($heroInfo->first_title) ? $heroInfo->first_title : '' }}</span>
            <h1 class="title">{{ !empty($heroInfo->second_title) ? $heroInfo->second_title : '' }}</h1>
            <ul>
              @if (!empty($heroInfo->first_button) && !empty($heroInfo->first_button_url))
                <li><a class="main-btn" href="{{ $heroInfo->first_button_url }}">{{ $heroInfo->first_button }}</a></li>
              @endif

              @if (!empty($heroInfo->second_button) && !empty($heroInfo->second_button_url))
                <li><a class="main-btn-2 main-btn" href="{{ $heroInfo->second_button_url }}">{{ $heroInfo->second_button }}</a></li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="banner-shape-1">
      <img data-src="{{ asset('assets/tenant/image/shapes/item-1.png') }}" class="lazy" alt="shape">
    </div>

    <div class="banner-shape-2">
      <img data-src="{{ asset('assets/tenant/image/shapes/item-2.png') }}" class="lazy" alt="shape">
    </div>
  </section>
  <!--====== BANNER PART END ======-->

  <!--====== DREAM COURSE PART START ======-->
  <div class="dream-course-area">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="dream-course-content">
            <div class="dream-course-title text-center">
              <span>{{ $keywords['find_your_dream_course'] ?? __('Find Your Dream Course') }}</span>
            </div>

            <form action="{{ route('front.user.courses',getParam()) }}" method="GET">
              <div class="dream-course-search d-flex">
                <div class="input-box">
                  <i class="fal fa-search"></i>
                  <input type="text" name="keyword" placeholder="{{ $keywords['search_course_here'] ??  __('Search Course Here') }}">
                </div>

                @if (count($categories) > 0)
                  <div class="dream-course-category d-none d-lg-inline-block">
                    <select name="category">
                      <option selected disabled>{{ $keywords['select_category'] ??  __('Select a Category') }}</option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                @endif

                <div class="dream-course-btn">
                  <button type="submit">{{ $keywords['find_course'] ?? __('Find Course') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--====== DREAM COURSE PART END ======-->

  <!--====== COURSE CATEGORIES PART START ======-->
  @if ($secInfo->course_categories_section_status == 1)
    <section class="services-area pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-11">
            <div class="section-title text-center">
              <h3 class="title">{{ !empty($secTitleInfo->category_section_title) ? $secTitleInfo->category_section_title : 'Course Categories' }}</h3>
            </div>
          </div>
        </div>

        @if (count($categories) == 0)
          <div class="row text-center">
            <div class="col">
              <h3>{{ $keywords['no_course_category_found'] ??  __('No Course Category Found') }} {{'!'}}</h3>
            </div>
          </div>
        @else
          <div class="services-border">
            <div class="row no-gutters">
              @foreach ($categories as $category)
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <a class="single-services text-center d-block" href="{{route('front.user.courses', [getParam(), 'category' => $category->slug])}}">
                    <i class="{{ $category->icon }}" style="color: {{ '#' . $category->color }};"></i>
                    <h5 class="title">{{ $category->name }}</h5>
                  </a>
                </div>
              @endforeach
            </div>

            @if (is_array($packagePermissions) && in_array('Advertisement',$packagePermissions))
                @if (!empty(showAd(3)))
                    <div class="text-center mt-5">
                        {!! showAd(3) !!}
                    </div>
                @endif
            @endif
          </div>
        @endif
      </div>
    </section>
  @endif
  <!--====== COURSE CATEGORIES PART END ======-->

  <!--====== CALL TO ACTION PART START ======-->
  @if ($secInfo->call_to_action_section_status == 1)
    <section class="offer-area bg_cover pt-110 pb-120 lazy" @if (!empty($callToActionInfo)) data-bg="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_ACTION_SECTION_IMAGE,$callToActionInfo->background_image,$userBs) }}" @else data-bg="{{ asset('assets/tenant/image/static/call_to_action.jpeg') }}" @endif>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-11">
            <div class="offer-content text-center">
              <span>{{ !empty($callToActionInfo) ? $callToActionInfo->first_title : '' }}</span>
              <h1 class="title">{{ !empty($callToActionInfo) ? $callToActionInfo->second_title : '' }}</h1>
              <ul>
                @if (!empty($callToActionInfo->first_button) && !empty($callToActionInfo->first_button_url))
                  <li><a class="main-btn" href="{{ $callToActionInfo->first_button_url }}">{{ $callToActionInfo->first_button }}</a></li>
                @endif

                @if (!empty($callToActionInfo->second_button) && !empty($callToActionInfo->second_button_url))
                  <li><a class="main-btn-2 main-btn" href="{{ $callToActionInfo->second_button_url }}">{{ $callToActionInfo->second_button }}</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!--====== CALL TO ACTION PART END ======-->

  <!--====== COURSES PART START ======-->
  @if ($secInfo->featured_courses_section_status == 1)
    <section class="advance-courses-area pb-120">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <div class="section-title">
              <h3 class="title">{{ !empty($secTitleInfo->featured_courses_section_title) ? $secTitleInfo->featured_courses_section_title : '' }}</h3>
            </div>
          </div>
        </div>

        @if (count($courses) == 0)
          <div class="row text-center">
            <div class="col">
              <h3>{{ $keywords['no_featured_course_found'] ?? __('No Featured Course Found') }} {{'!'}}</h3>
            </div>
          </div>
        @else
          <div class="courses-active">
            @foreach ($courses as $course)
              <div class="single-courses mt-30">
                <div class="courses-thumb">
                  <a class="d-block" href="{{ route('front.user.course.details', [getParam(), 'slug' => $course->slug]) }}"><img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_COURSE_THUMBNAIL_IMAGE,$course->thumbnail_image,$userBs) }}" class="lazy" alt="image"></a>

                  <div class="corses-thumb-title">
                    <a class="category" href="{{route('front.user.courses', [getParam(), 'category' => $course->categorySlug])}}">{{ $course->categoryName }}</a>
                  </div>
                </div>

                <div class="courses-content">
                  <a href="{{ route('front.user.course.details', [getParam(),'slug' => $course->slug]) }}">
                    <h4 class="title">{{ strlen($course->title) > 45 ? mb_substr($course->title, 0, 45, 'UTF-8') . '...' : $course->title }}</h4>
                  </a>
                  <div class="courses-info d-flex justify-content-between">
                    <div class="item">
                      <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_INSTRUCTOR_IMAGE,$course->instructorImage,$userBs) }}" class="lazy" alt="instructor">
                      <p>{{strlen($course->instructorName) > 10 ? mb_substr($course->instructorName, 0, 10, 'utf-8') . '...' : $course->instructorName}}</p>
                    </div>

                    <div class="price">
                      @if ($course->pricing_type == 'premium')
                        <span>{{ $currencyInfo->base_currency_symbol_position == 'left' ? $currencyInfo->base_currency_symbol : '' }}{{ $course->current_price }}{{ $currencyInfo->base_currency_symbol_position == 'right' ? $currencyInfo->base_currency_symbol : '' }}</span>

                        @if (!is_null($course->previous_price))
                          <span class="pre-price">{{ $currencyInfo->base_currency_symbol_position == 'left' ? $currencyInfo->base_currency_symbol : '' }}{{ $course->previous_price }}{{ $currencyInfo->base_currency_symbol_position == 'right' ? $currencyInfo->base_currency_symbol : '' }}</span>
                        @endif
                      @else
                        <span>{{ $keywords['free'] ?? __('Free') }}</span>
                      @endif
                    </div>
                  </div>
                  <ul class="d-flex justify-content-center">
                    <li><i class="fal fa-users"></i> {{ $course->enrolmentCount .' '}}{{$keywords['students'] ?? __('Students')}}</li>

                    @php
                      $period = $course->duration;
                      $array = explode(':', $period);
                      $hour = $array[0];
                      $courseDuration = \Carbon\Carbon::parse($period);
                    @endphp

                    <li><i class="fal fa-clock"></i> {{ $hour == '00' ? '00' : $courseDuration->format('h') }}h {{ $courseDuration->format('i') }}m</li>
                  </ul>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        @if (is_array($packagePermissions) && in_array('Advertisement',$packagePermissions))
            @if (!empty(showAd(3)))
                <div class="text-center mt-5">
                    {!! showAd(3) !!}
                </div>
            @endif
        @endif
      </div>
    </section>
  @endif
  <!--====== COURSES PART END ======-->

  <!--====== FEATURES PART START ======-->
  @if ($secInfo->features_section_status == 1)
    @if (count($features) == 0)
      <section class="features-area gray-bg py-5">
        <div class="container">
          <div class="row text-center">
            <div class="col">
              <h3>{{ $keywords['no_feature_found'] ??  __('No Feature Found') }} {{'!'}}</h3>
            </div>
          </div>
        </div>
      </section>
    @else
      <section class="features-area gray-bg bg_cover lazy" @if (!empty($featureData)) data-bg="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_FEATURE_SECTION_IMAGE,$featureData->features_section_image,$userBs,'assets/tenant/image/static/features_bg.jpeg') }}" @endif>
        <div class="container-fluid">
          <div class="features-margin pl-70 pr-70">
            <div class="row">
              <div class="col-lg-9">
                <div class="row">
                  @foreach ($features as $feature)
                    <div class="col-lg-6 col-md-6">
                      <div class="single-features mt-30" style="background: {{ '#' . $feature->background_color }};">
                        <h4 class="title">{{ $feature->title }}</h4>
                        <p>{{ $feature->text }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif
  @endif
  <!--====== FEATURES PART END ======-->

  <!--====== VIDEO PART START ======-->
  @if ($secInfo->video_section_status == 1)
    <section class="play-area">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-11">
            <div class="section-title text-center">
              <h3 class="title">{{ !empty($videoData) ? $videoData->title : '' }}</h3>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="play-thumb">
              @if (!empty($videoData))
                <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_VIDEO_SECTION_IMAGE,$videoData->image,$userBs) }}" class="lazy" alt="image">
                <div class="play-btn">
                  <a href="{{ $videoData->link }}" class="video-popup"><i class="fas fa-play"></i></a>
                </div>
              @else
                <img data-src="{{ asset('assets/tenant/image/static/intro_video.png') }}" class="lazy" alt="image">
                <div class="play-btn">
                  <a href="#" class="video-popup"><i class="fas fa-play"></i></a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!--====== VIDEO PART END ======-->

  <!--====== COUNTER PART START ======-->
  @if ($secInfo->fun_facts_section_status == 1)
    <section class="counter-area bg_cove lazy" @if (!empty($factData->background_image)) data-bg="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE,$factData->background_image,$userBs) }}" @else data-bg="{{ asset('assets/tenant/image/static/fun_fact_bg.jpeg') }}" @endif>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7">
            <div class="section-title text-center">
              <h3 class="title">{{ !empty($factData) ? $factData->title : '' }}</h3>
            </div>
          </div>
        </div>

        @if (count($countInfos) == 0)
          <div class="row text-center">
            <div class="col">
              <h3 class="text-light">{{ $keywords['no_information_found'] ?? __('No Information Found')}} {{'!'}}</h3>
            </div>
          </div>
        @else
          <div class="row">
            @foreach ($countInfos as $countInfo)
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter-item text-center pt-40">
                  <h3 class="title"><span class="counter">{{ $countInfo->amount }}</span>+</h3>
                  <span>{{ $countInfo->title }}</span>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <div class="counter-dot">
        <img data-src="{{ asset('assets/tenant/image/counter-dot.png') }}" class="lazy" alt="dot">
      </div>
    </section>
  @endif
  <!--====== COUNTER PART END ======-->

  <!--====== TESTIMONIALS PART START ======-->
  @if ($secInfo->testimonials_section_status == 1)
    <section class="testimonials-area pb-115 bg_cover lazy" @if (!empty($testimonialData->testimonials_section_image)) data-bg="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_SECTION_IMAGE,$testimonialData->testimonials_section_image,$userBs) }}" @else data-bg="{{ asset('assets/tenant/image/static/testimonial_bg.png') }}" @endif>
      <div class="container">
        @if (count($testimonials) == 0)
          <div class="row text-center">
            <div class="col">
              <h3>{{ $keywords['no_testimonial_found'] ?? __('No Testimonial Found') }} {{'!'}}</h3>
            </div>
          </div>
        @else
          <div class="row testimonials-active">
            @foreach ($testimonials as $testimonial)
              <div class="col-lg-12">
                <div class="testimonials-content text-center">
                  <i class="fas fa-quote-left"></i>
                  <p>{{ $testimonial->comment }}</p>
                  <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image,$userBs) }}" class="lazy" alt="client">
                  <h5>{{ $testimonial->name }}</h5>
                  <span>{{ $testimonial->occupation }}</span>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  @endif
  <!--====== TESTIMONIALS PART END ======-->

  <!--======NEWSLETTER PART START ======-->
  @if ($secInfo->newsletter_section_status == 1)
    <section class="community-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <div class="community-content">
              <h3 class="title">{{ !empty($newsletterData->title) ? $newsletterData->title : '' }}</h3>
              <p class="mt-3">{{ !empty($newsletterData->text) ? $newsletterData->text : '' }}</p>

              <form class="subscriptionForm" action="{{ route('front.user.subscriber',getParam()) }}" method="POST">
                @csrf
                <div class="input-box">
                  <input type="email" placeholder="{{ $keywords['Enter_Email_Address'] ?? __('Enter Your Email Address') }}" name="email">
                  <button type="submit">{{ $keywords['Subscribe'] ??__('Subscribe') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      @if (!empty($newsletterData->image))
        <div class="community-thumb d-none d-lg-block">
          <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE,$newsletterData->image,$userBs) }}" class="lazy" alt="image">
        </div>
      @endif
    </section>
  @endif
  <!--======NEWSLETTER PART END ======-->
@endsection
