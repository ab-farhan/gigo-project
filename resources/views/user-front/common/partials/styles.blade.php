{{-- animate css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/animate.min.css') }}">

{{-- fontawesome css --}}
<link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}">

{{-- flaticon css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/flaticon.css') }}">

{{-- bootstrap css --}}
<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">

{{-- magnific-popup css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/magnific-popup.css') }}">

{{-- owl-carousel css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/owl-carousel.min.css') }}">

{{-- nice-select css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/nice-select.css') }}">

{{-- slick css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/slick.css') }}">

{{-- toastr css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/toastr.min.css') }}">

{{-- datatables css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/datatables-1.10.23.min.css') }}">

{{-- whatsapp css --}}
<link rel="stylesheet" href="{{ asset('assets/front/css/whatsapp.min.css') }}">

{{-- jQuery-ui css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/jquery-ui.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/tenant/css/monokai-sublime.css') }}">

@if (request()->routeIs('customer.my_course.curriculum'))
  {{-- video css --}}
  <link rel="stylesheet" href="{{ asset('assets/tenant/css/video.min.css') }}">
@endif

{{-- default css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/default.min.css') }}">

{{-- new main css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/main.css') }}">

{{-- responsive css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/responsive.css') }}">

{{-- mega-menu css --}}
<link rel="stylesheet" href="{{ asset('assets/tenant/css/mega-menu.css') }}">


@if ($currentLanguageInfo->rtl == 1)
  {{-- right-to-left css --}}
  <link rel="stylesheet" href="{{ asset('assets/tenant/css/rtl.css') }}">

  {{-- right-to-left-responsive css --}}
  <link rel="stylesheet" href="{{ asset('assets/tenant/css/rtl-responsive.css') }}">
@endif

@php
  $primaryColor = '2079FF';

  if (!empty($userBs->primary_color)) {
    $primaryColor = $userBs->primary_color;
  }

  $secondaryColor = 'F16001';

  if (!empty($userBs->secondary_color)) {
    $secondaryColor = $userBs->secondary_color;
  }

  $footerBackgroundColor = '001B61';

  if (!empty($footerInfo->footer_background_color)) {
    $footerBackgroundColor = $footerInfo->footer_background_color;
  }

  $copyrightBackgroundColor = '003A91';

  if (!empty($footerInfo->copyright_background_color)) {
    $copyrightBackgroundColor = $footerInfo->copyright_background_color;
  }

  $breadcrumbOverlayColor = '001B61';

  if (!empty($userBs->breadcrumb_overlay_color)) {
    $breadcrumbOverlayColor = $userBs->breadcrumb_overlay_color;
  }

  $breadcrumbOverlayOpacity = 0.5;

  if (!empty($userBs->breadcrumb_overlay_opacity)) {
    $breadcrumbOverlayOpacity = $userBs->breadcrumb_overlay_opacity;
  }
@endphp

{{-- website-color css using a php file --}}
<link rel="stylesheet" href="{{ asset("assets/tenant/css/website-color.php?primary_color=$primaryColor&secondary_color=$secondaryColor&footer_background_color=$footerBackgroundColor&copyright_background_color=$copyrightBackgroundColor&breadcrumb_overlay_color=$breadcrumbOverlayColor&breadcrumb_overlay_opacity=$breadcrumbOverlayOpacity") }}">

@if ($websiteInfo->whatsapp_status == 1)
<style>
.back-to-top {
    left: 30px;
    right: auto;
}  
</style>
@endif