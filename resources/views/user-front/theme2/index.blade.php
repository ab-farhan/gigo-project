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

@section('content')
  <!--====== BANNER PART START ======-->
  <section class="banner-area banner-area-2 bg_cover lazy" @if (!empty($heroInfo)) data-bg="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_HERO_SECTION_IMAGE,$heroInfo->background_image,$userBs) }}" @else data-bg="{{asset('assets/tenant/image/static/hero_bg_2.jpeg')}}" @endif>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="banner-content text-center">
            @if (!empty($heroInfo->video_url))
              <a class="video-popup" href="{{ $heroInfo->video_url }}"><i class="fal fa-play"></i></a> <br>
            @endif

            @if (!empty($heroInfo->first_title))
              <span>{{ $heroInfo->first_title }}</span>
            @endif

            @if (!empty($heroInfo->second_title))
              <h1 class="title">{{ $heroInfo->second_title }}</h1>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--====== BANNER PART END ======-->

  <!--====== SUB ITEMS PART START ======-->
  @if ($secInfo->features_section_status == 1 && count($features) > 0)
    <section class="sub-items-area">
      <div class="container-fluid p-0">
        <div class="row no-gutters">
          <div class="col-lg-4">
            <div class="sub-item">
              <h3 class="title">{{$keywords['find_your_dream_course'] ?? __('Find Your Dream Course') }}</h3>
              <form action="{{ route('front.user.courses',getParam()) }}" method="GET">
                <div class="input-box">
                  <input type="text" name="keyword" placeholder="{{ $keywords['search_course_here'] ?? __('Search Course Here') }}">
                  <i class="fal fa-search"></i>
                  <button type="submit">{{ $keywords['find_course'] ?? __('Find Course') }}</button>
                </div>
              </form>
            </div>
          </div>

          @foreach ($features as $feature)
            <div class="col-lg-4">
              <div class="sub-item item-2" style="background: {{ '#' . $feature->background_color }};">
                <h3 class="title">{{ $feature->title }}</h3>
                <div class="sub-content">
                  <p>{{ $feature->text }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif
  <!--====== SUB ITEMS PART END ======-->

  <!--====== FEATURED COURSES PART START ======-->
  @if ($secInfo->featured_courses_section_status == 1)
    <section class="advance-courses-area pt-110 pb-110">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <div class="section-title section-title-2">
              <h3 class="title">{{ !empty($secTitleInfo->featured_courses_section_title) ? $secTitleInfo->featured_courses_section_title : '' }}</h3>
            </div>
          </div>
        </div>

        @if (count($courses) == 0)
          <div class="row text-center">
            <div class="col">
              <h3 class="mt-5">{{ $keywords['no_featured_course_found'] ?? __('No Featured Course Found') }} {{'!'}}</h3>
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
                    <li><i class="fal fa-users"></i> {{ $course->enrolmentCount }} {{$keywords['students'] ?? __('Students')}}</li>

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
  <!--====== FEATURED COURSES PART END ======-->

  <!--====== OFFER-2 PART START ======-->
  @if ($secInfo->call_to_action_section_status == 1)
    <section class="offer-2-area bg_cover pt-110 pb-120 lazy" @if (!empty($callToActionInfo)) data-bg="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_ACTION_SECTION_IMAGE,$callToActionInfo->background_image,$userBs) }}" @else data-bg="{{ asset('assets/tenant/image/static/cta_bg_2.jpeg') }}" @endif>
      <div class="container">
        <div class="row">
          <div class="{{ empty($callToActionInfo->image) ? 'col' : 'col-lg-7' }} ">
            <div class="offer-content">
              <span>{{ !empty($callToActionInfo->first_title) ? $callToActionInfo->first_title : '' }}</span>
              <h3 class="title">{{ !empty($callToActionInfo->second_title) ? $callToActionInfo->second_title : '' }}</h3>
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

          @if (!empty($callToActionInfo->image))
            <div class="col-lg-5">
              <div class="offer-thumb ml-30 pt-25">
                <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_ACTION_SECTION_IMAGE,$callToActionInfo->image,$userBs) }}" class="lazy" alt="image">
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
  @endif
  <!--====== OFFER-2 PART END ======-->

  <!--====== FEATURED INSTRUCTORS PART START ======-->
  @if ($secInfo->featured_instructors_section_status == 1)
    <section class="mentors-area pt-105 pb-120 gray-bg">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-title section-title-2 text-center">
              <h3 class="title">{{ !empty($secTitleInfo->featured_instructors_section_title) ? $secTitleInfo->featured_instructors_section_title : 'Our Instructors' }}</h3>
            </div>
          </div>
        </div>

        @if (count($instructors) == 0)
          <div class="row text-center">
            <div class="col">
              <h3 class="mt-5">{{ $keywords['no_featured_instructor_found'] ?? __('No Featured Instructor Found') }} {{'!'}}</h3>
            </div>
          </div>
        @else
          <div class="row justify-content-center">
            @foreach ($instructors as $instructor)
              <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="single-mentors mt-30">
                  <div class="mentors-thumb">
                    <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_INSTRUCTOR_IMAGE,$instructor->image,$userBs) }}" class="lazy" alt="instructor">
                  </div>
                  <div class="mentors-content bg-white text-center">
                    <h4 class="title">{{ $instructor->name }}</h4>
                    <span class="d-block mb-2">{{ $instructor->occupation }}</span>
                    <a href="#" class="main-btn" data-toggle="modal" data-target="#{{ 'staticBackdrop-' . $instructor->id }}">{{__('View More')}}</a>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="{{ 'staticBackdrop-' . $instructor->id }}" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">{{ __('Information of') . ' ' . $instructor->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="summernote-content">
                          {!! replaceBaseUrl($instructor->description, 'summernote') !!}
                        </div>
    
                        @php 
                          $socials = $instructor->socialPlatform; 
                        @endphp
    
                        @if (count($socials) > 0)
                          <h5 class="my-3">{{ __('Follow Me') . ':' }}</h5>
                          <div class="btn-group" role="group" aria-label="Social Links">
                            @foreach ($socials as $social)
                              <a href="{{ $social->url }}" class="btn social-link-btn mr-2" target="_blank"><i class="{{ $social->icon }}"></i></a>
                            @endforeach
                          </div>
                        @endif
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">{{ __('Close') }}</button>
                      </div>
                    </div>
                  </div>
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
  <!--====== FEATURED INSTRUCTORS PART END ======-->

  <!--====== VIDEO PART START ======-->
  @if ($secInfo->video_section_status == 1)
    <section class="play-area play-area-2">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-title section-title-2 text-center">
              <h3 class="title">{{ !empty($videoData->title) ? $videoData->title : '' }}</h3>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="play-thumb mt-30">
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
    <section class="counter-area counter-area-2 bg_cove lazy" @if (!empty($factData->background_image)) data-bg="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE,$factData->background_image,$userBs) }}" @endif>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-title section-title-2 text-center">
              <h3 class="title">{{ !empty($factData->title) ? $factData->title : '' }}</h3>
            </div>
          </div>
        </div>

        @if (count($countInfos) == 0)
          <div class="row text-center">
            <div class="col">
              <h3 class="text-light">{{ $keywords['no_information_found'] ?? __('No Information Found') }} {{'!'}}</h3>
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
    <section class="testimonials-2-area">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-title section-title-2 text-center">
              <h3 class="title">{{ !empty($secTitleInfo->testimonials_section_title) ? $secTitleInfo->testimonials_section_title : '' }}</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        @if (count($testimonials) == 0)
          <div class="row text-center">
            <div class="col">
              <h3>{{ $keywords['no_testimonial_found'] ?? __('No Testimonial Found') }} {{'!'}}</h3>
            </div>
          </div>
        @else
          <div class="testimonials-2-active">
            @foreach ($testimonials as $testimonial)
              <div class="single-testimonials mt-60">
                <div class="testimonials-content">
                  <i class="fas fa-quote-left"></i>
                  <p>{{ $testimonial->comment }}</p>
                </div>

                <div class="testimonials-info d-flex align-items-center pl-15 pt-30">
                  <div class="info-thumb">
                    <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image,$userBs) }}" class="lazy" alt="client">
                  </div>

                  <div class="info-content pl-20">
                    <h5 class="title">{{ $testimonial->name }}</h5>
                    <span>{{ $testimonial->occupation }}</span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  @endif
  <!--====== TESTIMONIALS PART END ======-->
@endsection
