@extends('user-front.common.layout')

@section('pageHeading')
  {{$keywords['payment_success'] ?? __('Payment Success') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/front/css/summernote-content.css') }}">
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' =>$keywords['success'] ?? __('Success')])

  <!--====== Purchase Success Section Start ======-->
  @if (empty($courseInfo->thanks_page_content))
    <div class="purchase-message">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="purchase-success">
              <div class="icon text-success"><i class="far fa-check-circle"></i></div>
              <h2>{{$keywords['success'] ?? __('Success') . '!' }}</h2>
              <p>{{$keywords['your_transaction_was_successful'] ?? __('Your transaction was successful') . '.' }}</p>
              <p>{{$keywords['We_have_sent_you_a_mail_with_an_invoice'] ?? __('We have sent you a mail with an invoice') . '.' }}</p>
              <p class="mt-4">{{$keywords['thank_you'] ?? __('Thank you') . '.' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  @else
    <section class="payment-success-page-area">
      <div class="container">
        <div class="row bg-light py-5">
          <div class="col">
            <div class="summernote-content">
              {!! replaceBaseUrl($courseInfo->thanks_page_content) !!}
            </div>
          </div>
        </div>
      </div>
    </section>
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
