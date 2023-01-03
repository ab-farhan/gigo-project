<!DOCTYPE html>
<html lang="{{ $currentLanguageInfo->code }}" @if ($currentLanguageInfo->rtl == 1) dir="rtl" @endif>
  <head>
    {{-- required meta tags --}}
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- csrf-token for ajax request --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- title --}}
    @if(isset($websiteInfo) && isset($websiteInfo->website_title))
      <title>{{ $websiteInfo->website_title }} - @yield('pageHeading') </title>
    @else
      <title> {{ config('app.name') }} - @yield('pageHeading')</title>
    @endif

    <meta name="keywords" content="@yield('metaKeywords')">
    <meta name="description" content="@yield('metaDescription')">

    {{-- fav icon --}}
    <link rel="shortcut icon" type="image/png" href="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_FAVICON,$websiteInfo->favicon,$userBs,'assets/front/img/'.$bs->favicon)}}">

    {{-- include styles --}}
    @include('user-front.common.partials.styles')

    {{-- additional style --}}
    @yield('style')
  </head>

  <body>
    {{-- preloader start --}}
    <div id="preloader">
      <div id="status">
        <div class="spinner">
          <div class="rect1"></div>
          <div class="rect2"></div>
          <div class="rect3"></div>
          <div class="rect4"></div>
          <div class="rect5"></div>
        </div>
      </div>
    </div>
    {{-- preloader end --}}

    {{-- header start --}}
    @if (!request()->routeIs('customer.my_course.curriculum'))
      @if ($userBs->theme_version == 1)
        <header class="header-area header-area-one">
         {{--include header-top --}}
          @includeIf('user-front.common.partials.header.header-top-v1')

          {{--include header-nav --}}
          @includeIf('user-front.common.partials.header.header-nav-v1')
        </header>
      @elseif ($userBs->theme_version == 2)
        <header class="header-area header-area-two">
          {{--include header-nav --}}
          @includeIf('user-front.common.partials.header.header-nav-v2')
        </header>
      @else
        <header class="header-area header-area-three">
          {{--include header-top --}}
          @includeIf('user-front.common.partials.header.header-top-v3')

          {{--include header-nav --}}
          @includeIf('user-front.common.partials.header.header-nav-v3')
        </header>
      @endif
    @endif
    {{-- header end --}}

    @yield('content')

    {{-- back to top start --}}
    <div class="back-to-top">
      <a href="#">
        <i class="fal fa-chevron-double-up"></i>
      </a>
    </div>
    {{-- back to top end --}}

    {{-- announcement popup --}}
    @includeIf('user-front.common.partials.popups')

    {{--cookie alert--}}
    @php
        $cookieStatus = (!empty($cookieAlertInfo) && $cookieAlertInfo->cookie_alert_status == 1) ? true : false;
        $cookieName = str_replace(" ","_",$userBs->website_title . "_" . $user->username);
        $cookieName = strtolower($cookieName) . "_cookie";

        \Config::set('cookie-consent.enabled', $cookieStatus);
        \Config::set('cookie-consent.cookie_name', $cookieName);
    @endphp
    {{-- cookie alert --}}
    <div class="cookie">
        @include('cookie-consent::index')
    </div>

    {{-- WhatsApp Chat Button --}}
    <div id="WAButton"></div>

    {{--include footer--}}
    @if (!request()->routeIs('customer.my_course.curriculum'))
      @if ($userBs->theme_version == 1 || $userBs->theme_version == 3)
        @includeIf('user-front.common.partials.footer.footer')
      @else
        @includeIf('user-front.common.partials.footer.footer-v2')
      @endif
    @endif

    {{-- include scripts --}}
    @includeIf('user-front.common.partials.scripts')

    {{-- additional script --}}
    @yield('script')
  </body>
</html>
