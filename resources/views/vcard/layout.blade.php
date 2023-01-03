<!DOCTYPE html>
<html lang="en" @yield('rtl')>
    <head>
        <!--====== Required meta tags ======-->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        {{-- og meta tags --}}
        <meta property="og:image" itemprop="image" content="@yield('og-image')">
        <meta property="og:image:type" content="image/jpg">
        <meta property="og:image:width" content="1024">
        <meta property="og:image:height" content="1024">
        <meta property="og:type" content="website" />
        <meta property="og:title" content="@yield('og-title')" />
        <meta property="og:description" content="@yield('og-description')" />

        <!--====== Title ======-->
        <title>{{$vcard->name}}</title>
        <link rel="shortcut icon" href="{{\App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_VCARD_IMAGE,$vcard->profile_image,$userBs)}}" type="image/x-icon">
        <!--====== Bootstrap css ======-->
        <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
        <!--====== FontAwesoem css ======-->
        <link rel="stylesheet" href="{{asset('assets/front/css/all.min.css')}}">
        <!--====== Magnific Popup css ======-->
        <link rel="stylesheet" href="{{asset('assets/tenant/css/magnific-popup.css')}}">
        <!--====== Slick css ======-->
        <link rel="stylesheet" href="{{asset('assets/tenant/css/slick.css')}}">
        @if ($vcard->template <= 4)
        <!--====== Style css ======-->
        <link rel="stylesheet" href="{{asset('assets/tenant/css/vcard/template1234/vcard.css')}}">
        @else
        <link rel="stylesheet" href="{{asset('assets/tenant/css/vcard/template5-10/vcard.css')}}">
        @endif
        <!--====== CSS ======-->
        @yield('styles')
        <!--====== RTL css ======-->
        @yield('rtl-css')
        <!--====== Base color ======-->
        @yield('base-color')
    </head>
    <body class="@yield('body')">

        @yield('content')

        <div id="snackbar"></div>

        <!--====== Jquery js ======-->
        <script src="{{asset('assets/admin/js/core/jquery-3.4.1.min.js')}}"></script>
        <!--====== Popper js ======-->
        <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
        <!--====== Bootstrap js ======-->
        <script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>
        <!--====== magnific popup js ======-->
        <script src="{{asset('assets/tenant/js/jquery.magnific-popup.min.js')}}"></script>
        <!--====== slick js ======-->
        <script src="{{asset('assets/tenant/js/slick.min.js')}}"></script>
        <!--====== lazyload js ======-->
        <script src="{{asset('assets/tenant/js/lazyload.min.js')}}"></script>
        <script>
            "use strict";
            var dir = {{$vcard->direction}};
        </script>
        <!--====== vcard js ======-->
        @if ($vcard->template <= 4)
        <script src="{{asset('assets/tenant/js/vcard/template1234/vcard.js')}}"></script>
        @else
        <script src="{{asset('assets/tenant/js/vcard/template5-10/vcard.js')}}"></script>
        @endif
        @if (session()->has('success'))
        <script>
            "use strict";
            showSnackbar("Mail sent successfully!");
        </script>
        @endif
    </body>
</html>
