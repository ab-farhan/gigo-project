@extends('user-front.common.layout')

@section('pageHeading')
  {{$keywords['change_password'] ?? __('Change Password') }}
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $keywords['change_password'] ?? __('Change Password')])

  <!-- Start Change Password Section -->
  <section class="user-dashboard">
    <div class="container">
      <div class="row">
        @includeIf('user-front.common.customer.common.side-navbar')

        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-12">
              <div class="user-profile-details">
                <div class="account-info">
                  <div class="title">
                    <h4>{{$keywords['change_password'] ?? __('Change Password') }}</h4>
                  </div>

                  <div class="edit-info-area">
                    <form action="{{ route('customer.update_password', getParam()) }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="col-lg-12">
                          <input type="password" class="form_control" placeholder="{{$keywords['current_password'] ?? __('Current Password') }}" name="current_password">
                          @error('current_password')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <input type="password" class="form_control" placeholder="{{$keywords['new_password'] ?? __('New Password') }}" name="new_password">
                          @error('new_password')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <input type="password" class="form_control" placeholder="{{$keywords['confirm_new_password'] ?? __('Confirm New Password') }}" name="new_password_confirmation">
                          @error('new_password_confirmation')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-button">
                            <button class="btn">{{$keywords['Submit'] ?? __('Submit') }}</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Change Password Section -->
@endsection
