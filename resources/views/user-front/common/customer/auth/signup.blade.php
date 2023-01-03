@extends('user-front.common.layout')

@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->signup_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->sign_up_meta_keywords }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->sign_up_meta_description }}
  @endif
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $pageHeading->signup_page_title])

  <!--====== User Signup Part Start ======-->
  <div class="user-area-section pt-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="user-form">
              @if(Session::has('sendmail'))
                  <div class="alert alert-success mb-4">
                      <p>{{__(Session::get('sendmail'))}}</p>
                  </div>
              @endif
            <form action="{{ route('customer.signup.submit', getParam()) }}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{$user->id}}">
              <div class="form_group">
                <label>{{$keywords['Username'] ?? __('Username')}} {{'*'}}</label>
                <input type="text" class="form_control" name="username" value="{{ old('username') }}">
                @error('username')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <label>{{$keywords['Email_Address'] ?? __('Email Address')}} {{'*'}}</label>
                <input type="email" class="form_control" name="email" value="{{ old('email') }}">
                @error('email')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <label>{{$keywords['password'] ?? __('Password')}} {{'*'}}</label>
                <input type="password" class="form_control" name="password" value="{{ old('password') }}">
                @error('password')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <label>{{$keywords['confirm_password'] ?? __('Confirm Password')}} {{'*'}}</label>
                <input type="password" class="form_control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                @error('password_confirmation')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <button type="submit" class="main-btn">{{$keywords['signup'] ?? __('Signup') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--====== User Signup Part End ======-->
@endsection
