@extends('user-front.common.layout')

@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->instructors_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->instructors_meta_keywords }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->instructors_meta_description }}
  @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/front/css/summernote-content.css') }}">
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $pageHeading->instructors_page_title])

  <!--====== INSTRUCTORS PART START ======-->
  <section class="speakers-area pt-90 pb-90">
    <div class="container">
      <div class="row">
        @if (count($instructors) == 0)
          <div class="col">
            <h3 class="text-center">{{$keywords['no_instructor_found'] ?? __('No Instructor Found') . '!' }}</h3>
          </div>
        @else
          @foreach ($instructors as $instructor)
            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="single-speakers mt-30">
                <div class="speakers-thumb">
                  <img data-src="{{ \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_INSTRUCTOR_IMAGE,$instructor->image,$userBs) }}" class="lazy" alt="image">
                  <a href="#" data-toggle="modal" data-target="{{ '#staticBackdrop-' . $instructor->id }}"><i class="fas fa-plus"></i></a>
                </div>
                <div class="speakers-content text-center">
                  <span>{{ $instructor->occupation }}</span>
                  <h4 class="title">{{ $instructor->name }}</h4>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="{{ 'staticBackdrop-' . $instructor->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{$keywords['information_of'] ?? __('Information of') }}{{' ' . $instructor->name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="summernote-content">
                      {!! replaceBaseUrl($instructor->description) !!}
                    </div>

                    @php $socials = $instructor->socials; @endphp

                    @if (count($socials) > 0)
                      <h5 class="my-3">{{ $keywords['follow_me'] ?? __('Follow Me') }} {{':'}}</h5>
                      <div class="btn-group" role="group" aria-label="Social Links">
                        @foreach ($socials as $social)
                          <a href="{{ $social->url }}" class="btn social-link-btn mr-2" target="_blank"><i class="{{ $social->icon }}"></i></a>
                        @endforeach
                      </div>
                    @endif
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $keywords['close'] ?? __('Close') }}</button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

      @if (is_array($packagePermissions) && in_array('Advertisement',$packagePermissions))
          @if (!empty(showAd(3)))
              <div class="text-center mt-30">
                  {!! showAd(3) !!}
              </div>
          @endif
      @endif
    </div>
  </section>
  <!--====== INSTRUCTORS PART END ======-->
@endsection
