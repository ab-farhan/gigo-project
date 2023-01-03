@extends('user-front.common.layout')

@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->faq_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->faqs_meta_keywords }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->faqs_meta_description }}
  @endif
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $pageHeading->faq_page_title])

  <!--====== FAQ PART START ======-->
  <section class="faq-area pb-120">
    <div class="container">
      <div class="row">
        <div class="col">
          @if (count($faqs) == 0)
            <h3 class="text-center">{{$keywords['no_faq_found'] ?? __('No FAQ Found') . '!' }}</h3>
          @else
            <div class="faq-accordion">
              <div class="accordion" id="accordionExample">
                @foreach ($faqs as $faq)
                  <div class="card">
                    <div class="card-header" id="{{ 'heading-' . $faq->id }}">
                      <a class="{{ $loop->first ? '' : 'collapsed' }}" href="" data-toggle="collapse" data-target="{{ '#collapse-' . $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="{{ 'collapse-' . $faq->id }}">
                        {{ $faq->question }}
                      </a>
                    </div>

                    <div id="{{ 'collapse-' . $faq->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="{{ 'heading-' . $faq->id }}" data-parent="#accordionExample">
                      <div class="card-body">
                        <p>{{ $faq->answer }}</p>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
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
  <!--====== FAQ PART END ======-->
@endsection
