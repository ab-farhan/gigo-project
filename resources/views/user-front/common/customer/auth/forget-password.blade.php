@extends('user-front.common.layout')

@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->forget_password_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_forget_password }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_forget_password }}
  @endif
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $pageHeading->forget_password_page_title])

  <!--====== Forget Password Part Start ======-->
  <div class="user-area-section pt-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="user-form">
            <form action="{{ route('customer.send_forget_password_mail',getParam()) }}" method="POST">
              @csrf
              <div class="form_group">
                <label>{{$keywords['Email_Address'] ?? __('Email Address')}} {{'*'}}</label>
                <input type="email" class="form_control" name="email" value="{{ old('email') }}">
                @error('email')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <button type="submit" class="main-btn">{{$keywords['proceed'] ?? __('Proceed') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--====== Forget Password Part End ======-->
@endsection
