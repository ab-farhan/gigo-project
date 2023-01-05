@extends('front.layout')

@section('pagename')
    - {{ $package->title }}
@endsection

@section('meta-description', !empty($package) ? $package->meta_keywords : '')
@section('meta-keywords', !empty($package) ? $package->meta_description : '')

@section('breadcrumb-title')
    {{ $package->title }}
@endsection
@section('breadcrumb-link')
    {{ $package->title }}
@endsection

@section('content')
    <!-- Authentication Start -->
    {{-- <div class="authentication-area pt-90 pb-120">
        <div class="container">
            <div class="main-form">
                <form id="#authForm" action="{{ route('front.checkout.view') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="title">
                        <h3>{{ __('Signup') }}</h3>
                    </div>
                    <div class="form-group mb-30">
                        <input type="text" class="form-control" name="username" placeholder="{{ __('Username') }}"
                            value="{{ old('username') }}" required>
                        @if ($hasSubdomain)
                            <p class="mb-0">
                                {{ __('Your subdomain based website URL will be') }}:
                                <strong class="text-primary"><span
                                        id="username">{username}</span>.{{ env('WEBSITE_HOST') }}</strong>
                            </p>
                        @endif
                        <p class="text-danger mb-0" id="usernameAvailable"></p>
                        @error('username')
                            <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}"
                            placeholder="{{ __('Email address') }}" required>
                        @error('email')
                            <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input class="form-control" type="password" class="form_control" name="password"
                            value="{{ old('password') }}" placeholder="{{ __('Password') }}" required>
                        @error('password')
                            <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input class="form-control" id="password-confirm" type="password" class="form_control"
                            placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required
                            autocomplete="new-password">
                        @error('password')
                            <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="id" value="{{ $id }}">
                    </div>
                    <button type="submit" class="btn primary-btn w-100"> {{ __('Continue') }} </button>
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
                                        <svg class="mw-100" data-src="assets/images/login.svg" data-unique-ids="disabled"
                                            data-cache="disabled"></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="main-form">
                                    <a href="index.html" class="icon-link" title="Go back to home"><i
                                            class="fal fa-home"></i></a>
                                    <div class="title">
                                        <h3 class="mb-4">{{ __('Signup to Gigo') }}</h3>
                                    </div>
                                    <form id="#authForm" action="{{ route('front.checkout.view') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="name" class="mb-1">{{ __('Username') }}</label>
                                            <input type="text" id="name" class="form-control" name="username"
                                                value="{{ old('username') }}" placeholder="{{ __('username') }}" required>
                                            @if ($hasSubdomain)
                                                <p class="mb-0">
                                                    {{ __('Your subdomain based website URL will be') }}:
                                                    <strong class="text-primary"><span
                                                            id="username">{username}</span>.{{ env('WEBSITE_HOST') }}</strong>
                                                </p>
                                            @endif
                                            <p class="text-danger mb-0" id="usernameAvailable"></p>
                                            @error('username')
                                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="email" class="mb-1"> {{ __('Email Address') }}</label>
                                            <input type="email" id="email" class="form-control" name="email"
                                                value="{{ old('email') }}" placeholder="{{ __('Enter your email') }}"
                                                required>
                                            @error('email')
                                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password" class="mb-1">{{ __('Password') }}</label>
                                            <input type="password" id="password" class="form-control" name="password"
                                                value="{{ old('password') }}" placeholder="{{ __('Password') }}"
                                                placeholder="Enter password" required>
                                            @error('password')
                                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-30">
                                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                            <input class="form-control" id="password-confirm" type="password"
                                                class="form_control" placeholder="{{ __('Confirm Password') }}"
                                                name="password_confirmation" required autocomplete="new-password">
                                            @error('password')
                                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <input type="hidden" name="status" value="{{ $status }}">
                                            <input type="hidden" name="id" value="{{ $id }}">
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="checkbox mb-3">
                                                <input type="checkbox" id="checkboxInput">
                                                <label for="checkboxInput" id="checkbox">
                                                    <svg viewBox="0 0 100 100">
                                                        <path class="box"
                                                            d="M82,89H18c-3.87,0-7-3.13-7-7V18c0-3.87,3.13-7,7-7h64c3.87,0,7,3.13,7,7v64C89,85.87,85.87,89,82,89z" />
                                                        <polyline class="check" points="25.5,53.5 39.5,67.5 72.5,34.5 " />
                                                    </svg>
                                                    <span>I agreed to Gigo's <a
                                                            href="{{ url('p/terms-&-conditions') }}">Terms of
                                                            Services</a></span>
                                                </label>
                                            </div>
                                            <div class="link go-signup">
                                                Already a member? <a href="{{ route('user.login') }}">Login now</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100"> Signup </button>
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
    <!-- Authentication End -->
@endsection



@section('scripts')
    @if ($hasSubdomain)
        <script>
            "use strict";
            $(document).ready(function() {
                $("input[name='username']").on('input', function() {
                    let username = $(this).val();
                    if (username.length > 0) {
                        $("#username").text(username);
                    } else {
                        $("#username").text("{username}");
                    }
                });
            });
        </script>
    @endif
    <script>
        "use strict";
        $(document).ready(function() {
            $("input[name='username']").on('change', function() {
                let username = $(this).val();
                if (username.length > 0) {
                    $.get("{{ url('/') }}/check/" + username + '/username', function(data) {
                        if (data == true) {
                            $("#usernameAvailable").text('This username is already taken.');
                        } else {
                            $("#usernameAvailable").text('');
                        }
                    });
                } else {
                    $("#usernameAvailable").text('');
                }
            });
        });
    </script>
@endsection
