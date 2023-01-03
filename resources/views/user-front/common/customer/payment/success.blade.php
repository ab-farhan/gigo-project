@extends('user-front.common.layout')

@section('pageHeading')
  {{ __('Payment Success') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/summernote-content.css') }}">
@endsection

@section('content')
@includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' =>$keywords['success'] ?? __('Success')])

  <!--====== Purchase Success Section Start ======-->
  @if ($paidVia == 'offline')
    <div class="purchase-message">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="purchase-success">
              <div class="icon text-success"><i class="far fa-check-circle"></i></div>
              <h2>{{ __('Success') . '!' }}</h2>
              <p>{{ __('Your transaction request was received and sent for review') . '.' }}</p>
              <p>{{ __('It might take upto 24 - 48 hours') . '.' }}</p>

              <div class="summernote-content px-5">
                {!! replaceBaseUrl($courseInfo->thanks_page_content, 'summernote') !!}
              </div>

              <p>{{ __('Thank you') . '.' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    @elseif($paidVia == 'coupon100')
      <div class="purchase-message">
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="purchase-success">
                <div class="icon text-success"><i class="far fa-check-circle"></i></div>
                <h2>{{ __('Success') . '!' }}</h2>
                <p>{{ __('You have enrolled successfully with 100% discount') . '.' }}</p>
                <p>{{ __('We have sent you a mail with an invoice') . '.' }}</p>

                <div class="summernote-content px-5">
                  {!! replaceBaseUrl($courseInfo->thanks_page_content, 'summernote') !!}
                </div>

                <p>{{ __('Thank you') . '.' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="purchase-message">
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="purchase-success">
                <div class="icon text-success"><i class="far fa-check-circle"></i></div>
                <h2>{{ __('Success') . '!' }}</h2>
                <p>{{ __('Your transaction was successful') . '.' }}</p>
                <p>{{ __('We have sent you a mail with an invoice') . '.' }}</p>

                <div class="summernote-content px-5">
                  {!! replaceBaseUrl($courseInfo->thanks_page_content, 'summernote') !!}
                </div>

                <p>{{ __('Thank you') . '.' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif    
  <!--====== Purchase Success Section End ======-->
@endsection

@section('script')
  <script type="text/javascript">
    "use strict";
    sessionStorage.removeItem('course_id');
    sessionStorage.removeItem('new_price');
  </script>
@endsection
