@extends('front.layout')

@section('meta-description', !empty($seo) ? $seo->login_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->login_meta_keywords : '')

@section('pagename')
    - {{ __('Login') }}
@endsection
@section('breadcrumb-title')
    {{ __('Login') }}
@endsection
@section('breadcrumb-link')
    {{ __('Login') }}
@endsection

@section('content')
    <!--====== Start user-form-section ======-->

    {{-- <div class="authentication-area pt-90 pb-120">
        <div class="container">
            <div class="main-form">
                <form id="#authForm" action="{{route('user.login')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="title">
                        <h3>{{__('login')}}</h3>
                    </div>
                    <div class="form-group mb-30">
                        <input type="email" name="email" class="form-control" placeholder="{{ __('email')}}" value="{{old('email')}}" required>
                        @if (Session::has('err'))
                            <p class="text-danger mb-2 mt-2">{{Session::get('err')}}</p>
                        @endif
                        @error('email')
                        <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input type="password"  name="password" class="form-control" placeholder="{{ __('password') }}">
                        @error('password')
                        <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form_group">
                        @if ($bs->is_recaptcha == 1)
                            <div class="d-block mb-4">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    @php
                                        $errmsg = $errors->first('g-recaptcha-response');
                                    @endphp
                                    <p class="text-danger mb-0 mt-2">{{__("$errmsg")}}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4 col-xs-12">
                            <div class="link">
                                <a href="{{route('user.forgot.password.form')}}">{{__('Lost your password')}}?</a>
                            </div>
                        </div>
                        <div class="col-8 col-xs-12">
                            <div class="link go-signup">
                                {{__("Don't have an account?")}} <a href="{{route('front.pricing')}}">{{__("Click Here")}}</a> {{__("to Signup")}}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn primary-btn w-100"> {{__('LOG IN')}} </button>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="authentication-area bg-light">
        <div class="container">
            <div class="row min-vh-100 align-items-center">
                <div class="col-12">
                    <div class="wrapper">
                        <div class="row align-items-center">

                            <div class="col-lg-6 bg-primary-light">
                                <div class="content">
                                    <div class="logo mb-3">
                                        <a href="{{ route('front.index') }}"><img
                                                src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="Logo"></a>
                                    </div>
                                    <div class="svg-image">
                                        <svg class="mw-100" data-src="{{ asset('') }}/assets/front/images/login.svg"
                                            data-unique-ids="disabled" data-cache="disabled"></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="main-form">
                                    <a href="{{ route('front.index') }}" class="icon-link" title="Go back to home"><i
                                            class="fal fa-home"></i></a>
                                    <div class="title">
                                        <h3 class="mb-4">{{ __('Login to Gigo') }}</h3>
                                    </div>
                                    <form id="#authForm" action="{{ route('user.login') }}" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="email" class="mb-1"> {{ __('Email Address') }}</label>
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Enter your email" required>
                                            @if (Session::has('err'))
                                                <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                            @endif
                                            @error('email')
                                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password" class="mb-1">{{ __('Password') }}</label>
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="Enter password" required>
                                            @error('password')
                                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form_group mb-3">
                                            @if ($bs->is_recaptcha == 1)
                                                <div class="d-block mb-4">
                                                    {!! NoCaptcha::renderJs() !!}
                                                    {!! NoCaptcha::display() !!}
                                                    @if ($errors->has('g-recaptcha-response'))
                                                        @php
                                                            $errmsg = $errors->first('g-recaptcha-response');
                                                        @endphp
                                                        <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-sm-4 col-xs-12">
                                                <div class="link">
                                                    <a
                                                        href="{{ route('user.forgot.password.form') }}">{{ __('Forgot password?') }}</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-xs-12">
                                                <div class="link go-signup">
                                                    {{ __('Not a member?') }} <a
                                                        href="{{ route('front.pricing') }}">{{ __('Sign up now') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100">
                                                {{ __('Login') }} </button>
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

    <!--====== End user-form-section ======-->
@endsection
