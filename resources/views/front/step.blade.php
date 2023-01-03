@extends('front.layout')

@section('pagename')
    - {{$package->title}}
@endsection

@section('meta-description', !empty($package) ? $package->meta_keywords : '')
@section('meta-keywords', !empty($package) ? $package->meta_description : '')

@section('breadcrumb-title')
    {{$package->title}}
@endsection
@section('breadcrumb-link')
    {{$package->title}}
@endsection

@section('content')
    <!-- Authentication Start -->
    <div class="authentication-area pt-90 pb-120">
        <div class="container">
            <div class="main-form">
                <form id="#authForm" action="{{ route('front.checkout.view') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="title">
                        <h3>{{ __('Signup') }}</h3>
                    </div>
                    <div class="form-group mb-30">
                        <input type="text" class="form-control" name="username" placeholder="{{ __('Username') }}" value="{{ old('username') }}" required >
                        @if ($hasSubdomain)
                            <p class="mb-0">
                                {{ __('Your subdomain based website URL will be') }}:
                                <strong class="text-primary"><span id="username">{username}</span>.{{env('WEBSITE_HOST')}}</strong>
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
                        <input class="form-control" type="password" class="form_control" name="password" value="{{ old('password') }}"
                               placeholder="{{ __('Password') }}" required>
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
                    $.get("{{url('/')}}/check/" + username + '/username', function(data) {
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
