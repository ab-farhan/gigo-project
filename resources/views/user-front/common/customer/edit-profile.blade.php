@extends('user-front.common.layout')

@section('pageHeading')
  {{$keywords['edit_profile'] ?? __('Edit Profile') }}
@endsection

@section('content')
  @includeIf('user-front.common.partials.breadcrumb', ['breadcrumb' => $bgImg->breadcrumb, 'title' => $keywords['edit_profile'] ?? __('Edit Profile')])

  <!-- Start User Edit-Profile Section -->
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
                    <h4>{{$keywords['edit_your_profile'] ?? __('Edit Your Profile') }}</h4>
                  </div>

                  <div class="edit-info-area">
                    <form action="{{ route('customer.update_profile', getParam()) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="upload-img">
                        <div class="img-box">
                          <img data-src="{{ is_null($authUser->image) ? asset('assets/tenant/image/customers/profile.jpg') : \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_TENANT_CUSTOMER_IMAGE.'/'.$user->id,$authUser->image,$userBs) }}" alt="user image" class="user-photo lazy">
                        </div>

                        <div class="file-upload-area">
                          <div class="upload-file">
                            <input type="file" accept=".jpg, .jpeg, .png" name="image" class="upload">
                            <span>{{$keywords['upload'] ?? __('Upload') }}</span>
                          </div>
                        </div>
                      </div>
                      @error('image')
                        <p class="mb-3 text-danger">{{ $message }}</p>
                      @enderror

                      <div class="row">
                        <div class="col-lg-6">
                          <input type="text" class="form_control" placeholder="{{$keywords['first_name'] ?? __('First Name') }}" name="first_name" value="{{ $authUser->first_name }}">
                          @error('first_name')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="col-lg-6">
                          <input type="text" class="form_control" placeholder="{{$keywords['last_name'] ?? __('Last Name') }}" name="last_name" value="{{ $authUser->last_name }}">
                          @error('last_name')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="col-lg-6">
                          <input type="email" class="form_control" placeholder="{{$keywords['email'] ?? __('Email') }}" value="{{ $authUser->email }}" readonly>
                        </div>

                        <div class="col-lg-6">
                          <input type="text" class="form_control" placeholder="{{$keywords['contact_number'] ?? __('Contact Number') }}" name="contact_number" value="{{ $authUser->contact_number }}">
                          @error('contact_number')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="col-lg-6">
                          <textarea class="form_control" placeholder="{{$keywords['address'] ?? __('Address') }}" name="address">{{ $authUser->address }}</textarea>
                          @error('address')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="col-lg-6">
                          <input type="text" class="form_control" placeholder="{{$keywords['city'] ?? __('City') }}" name="city" value="{{ $authUser->city }}">
                          @error('city')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="col-lg-6">
                          <input type="text" class="form_control" placeholder="{{$keywords['state'] ?? __('State') }}" name="state" value="{{ $authUser->state }}">
                        </div>

                        <div class="col-lg-6">
                          <input type="text" class="form_control" placeholder="{{$keywords['country'] ?? __('Country') }}" name="country" value="{{ $authUser->country }}">
                          @error('country')
                            <p class="mb-3 text-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="col-lg-12">
                          <div class="form-button">
                            <button class="btn form-btn">{{$keywords['submit'] ?? __('Submit') }}</button>
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
  <!-- End User Edit-Profile Section -->
@endsection
