<!DOCTYPE html>
<html>
  <head>
    {{-- required meta tags --}}
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- csrf-token for ajax request --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- title --}}
    <title>404</title>

    {{-- fav icon --}}
    <link rel="shortcut icon" type="image/png" href="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_FAVICON,$userBs->favicon,$userBs)}}">

    {{-- bootstrap css --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">

    {{-- default css --}}
    <link rel="stylesheet" href="{{ asset('assets/tenant/css/default.min.css') }}">

    {{-- new main css --}}
    <link rel="stylesheet" href="{{ asset('assets/tenant/css/main.css') }}">

    {{-- responsive css --}}
    <link rel="stylesheet" href="{{ asset('assets/tenant/css/responsive.css') }}">

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
    <link rel="stylesheet" href="{{ asset("assets/front/css/website-color.php?primary_color=$primaryColor&secondary_color=$secondaryColor&footer_background_color=$footerBackgroundColor&copyright_background_color=$copyrightBackgroundColor&breadcrumb_overlay_color=$breadcrumbOverlayColor&breadcrumb_overlay_opacity=$breadcrumbOverlayOpacity") }}">

  </head>

  <body>
    
      <!--====== 404 PART START ======-->
      <section class="error-area d-flex align-items-center">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="error-content">
                <span>
                  {{ $keywords["404_page_not_found"] ?? __('404! Page Not Found') }}
                </span>
                <h2 class="title">{{ $keywords["oops_looks_like_you_are_lost_in_ocean"] ?? __('Oops! Looks Like You Are Lost in Ocean') }}</h2>
                <ul>
                  <li><a href="{{ route('front.user.detail.view', getParam()) }}">{{ $keywords["get_back_to_home"] ?? __('Get Back to Home') }}</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
    
        <div class="error-thumb">
          <img src="{{ asset('assets/tenant/image/error.png') }}" alt="error">
        </div>
      </section>
      <!--====== 404 PART ENDS ======-->
  </body>

</html>