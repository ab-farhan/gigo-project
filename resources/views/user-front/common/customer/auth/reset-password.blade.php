@extends('user-front.common.layout')

@section('pageHeading')
  {{$keywords['reset_password'] ?? __('Reset Password') }}
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' =>$keywords['reset_password'] ?? __('Reset Password')])

  <!--====== Reset Password Part Start ======-->
  <div class="user-area-section pt-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="user-form">
            <form action="{{ route('customer.reset_password_submit', getParam()) }}" method="POST">
              @csrf
              <div class="form_group">
                <label>{{$keywords['new_password'] ?? __('New Password') . '*' }}</label>
                <input type="password" class="form_control" name="new_password">
                @error('new_password')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <label>{{$keywords['confirm_new_password'] ?? __('Confirm New Password') . '*' }}</label>
                <input type="password" class="form_control" name="new_password_confirmation">
                @error('new_password_confirmation')
                  <p class="text-danger mb-3">{{ $message }}</p>
                @enderror
              </div>

              <div class="form_group">
                <button type="submit" class="main-btn">{{$keywords['Submit'] ?? __('Submit') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--====== Reset Password Part End ======-->
@endsection
