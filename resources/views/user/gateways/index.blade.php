@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{__('Payment Gateways')}}</h4>
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
        <a href="#">{{__('Payment Gateways')}}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <div class="card">
        <form action="{{route('user.paypal.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">{{__('Paypal')}}</div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">
                @csrf

                <div class="form-group">
                  <label>{{__('Paypal')}}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($paypal) && $paypal->status == 1 ? 'checked' : ''}}>
                      <span class="selectgroup-button">{{__('Active')}}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($paypal) || $paypal->status == 0 ? 'checked' : ''}}>
                      <span class="selectgroup-button">{{__('Deactive')}}</span>
                    </label>
                  </div>
                </div>
                @php
                    $paypalInfo = isset($paypal->information) ? json_decode($paypal->information, true) : null;
                @endphp
                <div class="form-group">
                  <label>{{__('Paypal Test Mode')}}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="sandbox_check" value="1" class="selectgroup-input" {{isset($paypal) && $paypalInfo["sandbox_check"] == 1 ? 'checked' : ''}}>
                      <span class="selectgroup-button">{{__('Active')}}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="sandbox_check" value="0" class="selectgroup-input" {{!isset($paypal) || $paypalInfo["sandbox_check"] == 0 ? 'checked' : ''}}>
                      <span class="selectgroup-button">{{__('Deactive')}}</span>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label>{{__('Paypal Client ID')}}</label>
                  <input class="form-control" name="client_id" value="{{isset($paypalInfo) ? $paypalInfo["client_id"] : null}}">
                  @if ($errors->has('client_id'))
                    <p class="mb-0 text-danger">{{$errors->first('client_id')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>{{__('Paypal Client Secret')}}</label>
                  <input class="form-control" name="client_secret" value="{{isset($paypalInfo) ? $paypalInfo["client_secret"] : null}}">
                  @if ($errors->has('client_secret'))
                    <p class="mb-0 text-danger">{{$errors->first('client_secret')}}</p>
                  @endif
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">{{__('Update')}}</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="card">
        <form class="" action="{{route('user.stripe.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">Stripe</div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">
                @csrf
                @php
                    $stripeInfo = isset($stripe) ? json_decode($stripe->information, true) : null;
                @endphp
                <div class="form-group">
                    <label>Stripe</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($stripe) && $stripe->status == 1 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Active</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($stripe) || $stripe->status == 0 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Deactive</span>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Stripe Key</label>
                    <input class="form-control" name="key" value="{{isset($stripeInfo) ? $stripeInfo['key'] : null}}">
                    @if ($errors->has('key'))
                        <p class="mb-0 text-danger">{{$errors->first('key')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Stripe Secret</label>
                    <input class="form-control" name="secret" value="{{isset($stripeInfo) ? $stripeInfo['secret'] : null}}">
                    @if ($errors->has('secret'))
                        <p class="mb-0 text-danger">{{$errors->first('secret')}}</p>
                    @endif
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="card">
        <form class="" action="{{route('user.paytm.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">Paytm</div>
                  </div>
              </div>
          </div>


          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">
                @csrf
                @php
                    $paytmInfo = isset($paytm) ? json_decode($paytm->information, true) : null;
                @endphp
                <div class="form-group">
                    <label>Paytm</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($paytm) && $paytm->status == 1 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Active</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($paytm) || $paytm->status == 0 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Deactive</span>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                  <label>Paytm Environment</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input
                        type="radio"
                        name="environment"
                        value="local"
                        class="selectgroup-input"
                        {{ isset($paytm) && $paytmInfo['environment'] == 'local' ? 'checked' : '' }}
                      >
                      <span class="selectgroup-button">{{ __('Local') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input
                        type="radio"
                        name="environment"
                        value="production"
                        class="selectgroup-input"
                        {{ isset($paytm) && $paytmInfo['environment'] == 'production' ? 'checked' : '' }}
                      >
                      <span class="selectgroup-button">{{ __('Production') }}</span>
                    </label>
                  </div>
                  @if ($errors->has('environment'))
                    <p class="mb-0 text-danger">{{ $errors->first('environment') }}</p>
                  @endif
                </div>
                <div class="form-group">
                    <label>Paytm Merchant Key</label>
                    <input class="form-control" name="secret" value="{{isset($paytmInfo) ? $paytmInfo['secret'] : null}}">
                    @if ($errors->has('secret'))
                        <p class="mb-0 text-danger">{{$errors->first('secret')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Paytm Merchant mid</label>
                    <input class="form-control" name="merchant" value="{{isset($paytmInfo) ? $paytmInfo['merchant'] : null}}">
                    @if ($errors->has('merchant'))
                        <p class="mb-0 text-danger">{{$errors->first('merchant')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Paytm Merchant website</label>
                    <input class="form-control" name="website" value="{{isset($paytmInfo) ? $paytmInfo['website'] : null}}">
                    @if ($errors->has('website'))
                        <p class="mb-0 text-danger">{{$errors->first('website')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Industry type id</label>
                    <input class="form-control" name="industry" value="{{isset($paytmInfo) ? $paytmInfo['industry'] : null}}">
                    @if ($errors->has('industry'))
                        <p class="mb-0 text-danger">{{$errors->first('industry')}}</p>
                    @endif
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="card">
        <form class="" action="{{route('user.instamojo.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">Instamojo</div>
                  </div>
              </div>
          </div>


          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">
                @csrf
                @php
                    $instamojoInfo = isset($instamojo) ? json_decode($instamojo->information, true) : null;
                @endphp
                <div class="form-group">
                    <label>Instamojo</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($instamojo) && $instamojo->status == 1 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Active</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($instamojo) || $instamojo->status == 0 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Deactive</span>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Test Mode</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="sandbox_check" value="1" class="selectgroup-input" {{isset($instamojoInfo) && $instamojoInfo['sandbox_check'] == 1 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Active</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="sandbox_check" value="0" class="selectgroup-input" {{!isset($instamojoInfo) || $instamojoInfo['sandbox_check'] == 0 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Deactive</span>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Instamojo API Key</label>
                    <input class="form-control" name="key" value="{{isset($instamojoInfo) ? $instamojoInfo['key'] : null}}">
                    @if ($errors->has('key'))
                        <p class="mb-0 text-danger">{{$errors->first('key')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Instamojo Auth Token</label>
                    <input class="form-control" name="token" value="{{isset($instamojoInfo) ? $instamojoInfo['token'] : null}}">
                    @if ($errors->has('token'))
                        <p class="mb-0 text-danger">{{$errors->first('token')}}</p>
                    @endif
                </div>

              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="card">
        <form class="" action="{{route('user.paystack.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">Paystack</div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">
                @csrf
                @php
                    $paystackInfo = isset($paystack) ? json_decode($paystack->information, true) : null;
                @endphp
                <div class="form-group">
                    <label>Paystack</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($paystack) && $paystack->status == 1 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Active</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($paystack) || $paystack->status == 0 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Deactive</span>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Paystack Secret Key</label>
                    <input class="form-control" name="key" value="{{isset($paystackInfo) ? $paystackInfo['key'] : null}}">
                    @if ($errors->has('key'))
                        <p class="mb-0 text-danger">{{$errors->first('key')}}</p>
                    @endif
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="card">
        <form class="" action="{{route('user.flutterwave.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">Flutterwave</div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">
                @csrf
                @php
                    $flutterwaveInfo = isset($flutterwave) ? json_decode($flutterwave->information, true) : null;
                @endphp
                <div class="form-group">
                    <label>Flutterwave</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($flutterwave) && $flutterwave->status == 1 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Active</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($flutterwave) || $flutterwave->status == 0 ? 'checked' : ''}}>
                        <span class="selectgroup-button">Deactive</span>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Flutterwave Public Key</label>
                    <input class="form-control" name="public_key" value="{{isset($flutterwaveInfo) ? $flutterwaveInfo['public_key'] : null}}">
                    @if ($errors->has('public_key'))
                        <p class="mb-0 text-danger">{{$errors->first('public_key')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Flutterwave Secret Key</label>
                    <input class="form-control" name="secret_key" value="{{isset($flutterwaveInfo) ? $flutterwaveInfo['secret_key'] : null}}">
                    @if ($errors->has('secret_key'))
                        <p class="mb-0 text-danger">{{$errors->first('secret_key')}}</p>
                    @endif
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <form class="" action="{{route('user.mollie.update')}}" method="post">
            @csrf
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-title">Mollie Payment</div>
                    </div>
                </div>
            </div>


            <div class="card-body pt-5 pb-5">
                <div class="row">
                <div class="col-lg-12">
                    @csrf
                    @php
                        $mollieInfo = isset($mollie) ? json_decode($mollie->information, true) : null;
                    @endphp
                    <div class="form-group">
                        <label>Mollie Payment</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="1" class="selectgroup-input" {{ isset($mollie) && $mollie->status == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="0" class="selectgroup-input" {{ !isset($mollie) || $mollie->status == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mollie Payment Key</label>
                        <input class="form-control" name="key" value="{{isset($mollieInfo) ? $mollieInfo['key'] : null }}">
                        @if ($errors->has('key'))
                            <p class="mb-0 text-danger">{{$errors->first('key')}}</p>
                        @endif
                    </div>

                </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="form">
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <form class="" action="{{route('user.razorpay.update')}}" method="post">
            @csrf
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-title">Razorpay</div>
                    </div>
                </div>
            </div>


            <div class="card-body pt-5 pb-5">
                <div class="row">
                <div class="col-lg-12">
                    @csrf
                    @php
                        $razorpayInfo = isset($razorpay) ? json_decode($razorpay->information, true) : null;
                    @endphp
                    <div class="form-group">
                        <label>Razorpay</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($razorpay) && $razorpay->status == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($razorpay) || $razorpay->status == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Razorpay Key</label>
                        <input class="form-control" name="key" value="{{isset($razorpayInfo) ? $razorpayInfo['key'] : null}}">
                        @if ($errors->has('key'))
                            <p class="mb-0 text-danger">{{$errors->first('key')}}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Razorpay Secret</label>
                        <input class="form-control" name="secret" value="{{isset($razorpayInfo) ? $razorpayInfo['secret'] : null}}">
                        @if ($errors->has('secret'))
                            <p class="mb-0 text-danger">{{$errors->first('secret')}}</p>
                        @endif
                    </div>

                </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="form">
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <form class="" action="{{route('user.anet.update')}}" method="post">
            @csrf
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-title">Authorize.Net</div>
                    </div>
                </div>
            </div>


            <div class="card-body pt-5 pb-5">
                <div class="row">
                <div class="col-lg-12">
                    @csrf
                    @php
                        $anetInfo = isset($anet) ? json_decode($anet->information, true) : null;
                    @endphp
                    <div class="form-group">
                        <label>Authorize.Net</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($anet) && $anet->status == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($anet) || $anet->status == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Authorize.Net Test Mode</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="sandbox_check" value="1" class="selectgroup-input" {{isset($anetInfo) && $anetInfo['sandbox_check'] == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="sandbox_check" value="0" class="selectgroup-input" {{!isset($anetInfo) || $anetInfo['sandbox_check'] == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>API Login ID</label>
                        <input class="form-control" name="login_id" value="{{isset($anetInfo) ? $anetInfo['login_id'] : null }}">
                        @if ($errors->has('login_id'))
                            <p class="mb-0 text-danger">{{$errors->first('login_id')}}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Transaction Key</label>
                        <input class="form-control" name="transaction_key" value="{{isset($anetInfo) ? $anetInfo['transaction_key'] : null}}">
                        @if ($errors->has('transaction_key'))
                            <p class="mb-0 text-danger">{{$errors->first('transaction_key')}}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Public Client Key</label>
                        <input class="form-control" name="public_key" value="{{isset($anetInfo) ? $anetInfo['public_key'] : null}}">
                        @if ($errors->has('public_key'))
                            <p class="mb-0 text-danger">{{$errors->first('public_key')}}</p>
                        @endif
                    </div>

                </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="form">
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <form class="" action="{{route('user.mercadopago.update')}}" method="post">
            @csrf
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-title">Mercadopago</div>
                    </div>
                </div>
            </div>


            <div class="card-body pt-5 pb-5">

                    @csrf
                    @php
                        $mercadopagoInfo = isset($mercadopago) ? json_decode($mercadopago->information, true) : null;
                    @endphp
                    <div class="form-group">
                        <label>Mercado Pago</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="1" class="selectgroup-input" {{isset($mercadopago) && $mercadopago->status == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="0" class="selectgroup-input" {{!isset($mercadopago) || $mercadopago->status == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Mercado Pago Test Mode</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="sandbox_check" value="1" class="selectgroup-input" {{isset($mercadopagoInfo) && $mercadopagoInfo["sandbox_check"] == 1 ? 'checked' : ''}}>
                          <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="sandbox_check" value="0" class="selectgroup-input" {{!isset($mercadopagoInfo) || $mercadopagoInfo["sandbox_check"] == 0 ? 'checked' : ''}}>
                          <span class="selectgroup-button">Deactive</span>
                        </label>
                      </div>
                    </div>

                    <div class="form-group">
                        <label>Mercadopago Token</label>
                        <input class="form-control" name="token" value="{{isset($mercadopagoInfo) ? $mercadopagoInfo['token'] : null}}">
                        @if ($errors->has('token'))
                            <p class="mb-0 text-danger">{{$errors->first('token')}}</p>
                        @endif
                    </div>
            </div>

            <div class="card-footer">
                <div class="form">
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>
  </div>

@endsection
