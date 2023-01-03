@extends('user.layout')
@php
    $user = Auth::guard('web')->user();
    $features = \App\Http\Helpers\UserPermissionHelper::currentPackageFeatures($user->id);
    $hasAwsPermission = in_array("Amazon AWS s3", $features);
@endphp
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Plugins') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('user-dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Basic Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Plugins') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
      @if($hasAwsPermission)
          <div class="col-lg-4">
              <div class="card">
                  <form action="{{route('user.update_aws_credentials')}}" method="post">
                      @csrf
                      <div class="card-header">
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="card-title">{{ __('AWS Credentials') }}</div>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group">
                                      <label>{{ __('AWS Status*') }}</label>
                                      <div class="selectgroup w-100">
                                          <label class="selectgroup-item">
                                              <input type="radio" name="aws_status" value="1" class="selectgroup-input" {{ $data->aws_status == 1 ? 'checked' : '' }}>
                                              <span class="selectgroup-button">{{ __('Active') }}</span>
                                          </label>

                                          <label class="selectgroup-item">
                                              <input type="radio" name="aws_status" value="0" class="selectgroup-input" {{ $data->aws_status != 1 ? 'checked' : '' }}>
                                              <span class="selectgroup-button">{{ __('Deactive') }}</span>
                                          </label>
                                      </div>

                                      @if ($errors->has('aws_status'))
                                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('aws_status') }}</p>
                                      @endif
                                  </div>

                                  <div class="form-group">
                                      <label>{{ __('AWS Access Key Id*') }}</label>
                                      <input type="text" class="form-control" name="aws_access_key_id" value="{{ $data->aws_access_key_id }}">

                                      @if ($errors->has('aws_access_key_id'))
                                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('aws_access_key_id') }}</p>
                                      @endif
                                  </div>
                                  <div class="form-group">
                                      <label>{{ __('AWS Secret Access Key*') }}</label>
                                      <input type="text" class="form-control" name="aws_secret_access_key" value="{{ $data->aws_secret_access_key }}">

                                      @if ($errors->has('aws_secret_access_key'))
                                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('aws_secret_access_key') }}</p>
                                      @endif
                                  </div>
                                  <div class="form-group">
                                      <label>{{ __('AWS Default Region*') }}</label>
                                      <input type="text" class="form-control" name="aws_default_region" value="{{ $data->aws_default_region }}">

                                      @if ($errors->has('aws_default_region'))
                                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('aws_default_region') }}</p>
                                      @endif
                                  </div>
                                  <div class="form-group">
                                      <label>{{ __('AWS Bucket*') }}</label>
                                      <input type="text" class="form-control" name="aws_bucket" value="{{ $data->aws_bucket }}">

                                      @if ($errors->has('aws_bucket'))
                                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('aws_bucket') }}</p>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="card-footer">
                          <div class="row">
                              <div class="col-12 text-center">
                                  <button type="submit" class="btn btn-success">
                                      {{ __('Update') }}
                                  </button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      @endif
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('user.update_disqus') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Disqus') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Disqus Status*') }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="disqus_status" value="1" class="selectgroup-input" {{ $data->disqus_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="disqus_status" value="0" class="selectgroup-input" {{ $data->disqus_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('disqus_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('disqus_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Disqus Short Name*') }}</label>
                  <input type="text" class="form-control" name="disqus_short_name" value="{{ $data->disqus_short_name }}">

                  @if ($errors->has('disqus_short_name'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('disqus_short_name') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('user.update_whatsapp') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('WhatsApp') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('WhatsApp Status*') }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_status" value="1" class="selectgroup-input" {{ $data->whatsapp_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_status" value="0" class="selectgroup-input" {{ $data->whatsapp_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('whatsapp_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Number*') }}</label>
                  <input type="text" class="form-control" name="whatsapp_number" value="{{ $data->whatsapp_number }}">

                  @if ($errors->has('whatsapp_number'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_number') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Header Title*') }}</label>
                  <input type="text" class="form-control" name="whatsapp_header_title" value="{{ $data->whatsapp_header_title }}">

                  @if ($errors->has('whatsapp_header_title'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_header_title') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Popup Status*') }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_popup_status" value="1" class="selectgroup-input" {{ $data->whatsapp_popup_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_popup_status" value="0" class="selectgroup-input" {{ $data->whatsapp_popup_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('whatsapp_popup_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_popup_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Popup Message*') }}</label>
                  <textarea class="form-control" name="whatsapp_popup_message" rows="2">{{ $data->whatsapp_popup_message }}</textarea>

                  @if ($errors->has('whatsapp_popup_message'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_popup_message') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
