@extends('user-front.common.layout')

@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->login_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->login_meta_keywords }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->login_meta_description }}
  @endif
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $pageHeading->login_page_title])

  <!--====== User Login Part Start ======-->
  <div class="user-area-section pt-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="user-form">
            <form action="{{ route('customer.login_submit', getParam()) }}" method="POST">
              @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="form_group">
                <label>{{$keywords['Email_Address'] ?? __('Email Address') . '*' }}</label>
                <input type="email" class="form_control" name="email" value="{{old('email')}}">
                @error('email')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <label>{{$keywords['password'] ?? __('Password') . '*' }}</label>
                <input type="password" class="form_control" name="password" value="">
                @error('password')
                  <p class="text-danger mb-4">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group d-flex justify-content-between align-items-center">
                <button type="submit" class="main-btn">{{$keywords['login'] ?? __('Login') }}</button>
                <a href="{{ route('customer.forget_password', getParam()) }}">{{$keywords['lost_your_password'] ?? __('Lost your password')}} {{'?'}}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--====== User Login Part End ======-->
@endsection
