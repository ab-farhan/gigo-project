@extends('admin.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Package Features') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Packages Management') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Package Features') }}</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">{{ __('Package Features') }}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form id="permissionsForm" class="" action="{{ route('admin.package.features') }}"
                                method="post">
                                {{ csrf_field() }}
                                <div class="alert alert-warning">
                                    {{ __('Only these selected features will be visible in frontend Pricing Section') }}
                                </div>
                                <div class="form-group">

                                    <label class="form-label">{{ __('Package Features') }}</label>
                                    <div class="selectgroup selectgroup-pills">


                                        {{-- <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Domain"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Custom Domain', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Custom Domain') }}</span>
                                        </label>


                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Subdomain"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Subdomain', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Subdomain') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Course Completion Certificate"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Course Completion Certificate', $features)) checked @endif>
                                            <span
                                                class="selectgroup-button">{{ __('Course Completion Certificate') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Coupon"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Coupon', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Coupon') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Amazon AWS s3"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Amazon AWS s3', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Amazon AWS s3') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Storage Limit"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Storage Limit', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Storage Limit') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="vCard"
                                                class="selectgroup-input" @if (is_array($features) && in_array('vCard', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('vCard') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="QR Builder"
                                                class="selectgroup-input" @if (is_array($features) && in_array('QR Builder', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('QR Builder') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Follow/Unfollow"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Follow/Unfollow', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Follow/Unfollow') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Blog"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Blog', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Blog') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Advertisement"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Advertisement', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Advertisement') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Page"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Custom Page', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Custom Page') }}</span>
                                        </label> --}}

                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Domain"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Custom Domain', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Custom Domain') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Subdomain"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Subdomain', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Subdomain') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service Form Builder"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Service Form Builder', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Service Form Builder') }}</span>
                                        </label>
                                        {{-- <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Service', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Service') }}</span>
                                        </label>

                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service Categories"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Service Categories', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Service Categories') }}</span>
                                        </label>

                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service Subcategories "
                                                class="selectgroup-input" @if (is_array($features) && in_array('Service Subcategories', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Service Subcategories') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Service Orders"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Service Orders', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Service Orders') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Invoice"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Invoice', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Invoice') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="User"
                                                class="selectgroup-input" @if (is_array($features) && in_array('User', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('User') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Post"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Post', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Post') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Language"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Language', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Language') }}</span>
                                        </label> --}}
                                        <label class="selectgroup-item">
                                            <input type="checkbox" id="shopManagement" name="features[]"
                                                value="Shop Management" class="selectgroup-input"
                                                @if (is_array($features) && in_array('Shop Management', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Shop Management') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom Page"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Custom Page', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Custom Page') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Contact Form"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Contact Form', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Contact Form') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Support Tickets"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Support Tickets', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Support Tickets') }}</span>
                                        </label>

                                        <label class="selectgroup-item" id="vCard">
                                            <input type="checkbox" name="features[]" value="vCard"
                                                class="selectgroup-input" @if (is_array($features) && in_array('vCard', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('vCard') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="QR Builder"
                                                class="selectgroup-input" @if (is_array($features) && in_array('QR Builder', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('QR Builder') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Custom CSS"
                                                class="selectgroup-input" @if (is_array($features) && in_array('Custom CSS', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Custom CSS') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Analytics"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Google Analytics', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Google Analytics') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Facebook Pixel"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Facebook Pixel', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Facebook Pixel') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Disqus"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Disqus', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Disqus') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Recaptcha"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Google Recaptcha', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Google Recaptcha') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Whatsapp"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Whatsapp', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Whatsapp') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Google Login"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Google Login', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Google Login') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="features[]" value="Facebook Login"
                                                class="selectgroup-input"
                                                @if (is_array($features) && in_array('Facebook Login', $features)) checked @endif>
                                            <span class="selectgroup-button">{{ __('Facebook Login') }}</span>
                                        </label>


                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="permissionBtn"
                                    class="btn btn-success">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
