<!DOCTYPE html>
<html lang="en" @if ($rtl == 1) dir="rtl" @endif>

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('og-meta')
    <!--====== Title ======-->
    <title>{{ $bs->website_title }} @yield('pagename')</title>
    <link rel="icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}">
    {{-- <!-- Google Font CSS -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="//fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/all.min.css')}}">
    <!-- Kreativ Icon -->
    <link rel="stylesheet" href="{{asset('assets/front/css/font-gigo.css')}}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/magnific-popup.min.css')}}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{asset('assets/front/css/swiper-bundle.min.css')}}">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/aos.min.css')}}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/meanmenu.min.css')}}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{asset('assets/front/css/nice-select.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('assets/front/css/toastr.min.css')}}">
    <!-- Whatsapp -->
    <link rel="stylesheet" href="{{asset('assets/front/css/whatsapp.min.css')}}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/cookie-alert.css')}}"> --}}

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/front/fonts/fontawesome/css/all.min.css') }}">
    <!-- Kreativ Icon -->
    <link rel="stylesheet" href="{{ asset('/assets/front/fonts/icomoon/style.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/magnific-popup.min.css') }}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/swiper-bundle.min.css') }}">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/aos.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/nice-select.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/style.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/toastr.min.css') }}">
    <!-- Whatsapp -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/whatsapp.min.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/front/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/cookie-alert.css') }}">


    @if ($rtl == 1)
        <link rel="stylesheet" href="{{ asset('assets/front/css/rtl-style.css') }}">
    @endif
    <!-- base color change -->

    @yield('styles')

    @if ($bs->is_whatsapp == 1 || $bs->is_tawkto == 1)
        {{-- <style>
            .go-top {
                right: auto;
                left: 30px;
            }
        </style> --}}
    @endif

    <style>
        :root {
            --color-primary: #{{ $bs->base_color }};
            --color-primary-shade: #{{ $bs->base_color2 }};
            --bg-light: #{{ $bs->base_color2 }}14;
        }
    </style>

</head>

<body>


    @if ($bs->preloader_status == 1)
        <!--====== Start Preloader ======-->
        {{-- <div id="preLoader">
            <div class="loader">
                <img src="{{ asset('assets/front/img/' . $bs->preloader) }}" alt="">
            </div>
        </div> --}}

        <div id="preLoader">
            <div class="loader">
                <svg viewBox="0 0 80 80">
                    <rect x="8" y="8" width="64" height="64"></rect>
                </svg>
            </div>
        </div>
        <!--====== End Preloader ======-->
    @endif




    @include('front.partials.header')

    @if (!request()->routeIs('front.index'))
        <!--====== Start Breadcrumbs-section ======-->

        {{-- <div class="page-title-area">
            <div class="container">
                <div class="content text-center" data-aos="fade-up">
                    <h1>@yield('breadcrumb-title')</h1>
                    <ul class="list-unstyled">
                        <li class="d-inline"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                        <li class="d-inline">/</li>
                        <li class="d-inline active">@yield('breadcrumb-link')</li>
                    </ul>
                </div>
            </div>
        </div> --}}

        <div class="page-title-area bg-primary-light">
            <div class="container">
                <div class="content text-center">
                    <h2>@yield('breadcrumb-title')</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb-link')</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Bg Overlay -->
            <img class="lazyload bg-overlay-1" data-src="{{ asset('') }}/assets/front/images/shadow-1.png"
                alt="Bg">
            <img class="lazyload bg-overlay-2" data-src="{{ asset('') }}/assets/front/images/shadow-2.png"
                alt="Bg">

            <!-- Bg Shape -->
            <div class="shape">
                <img class="shape-1" src="{{ asset('') }}/assets/front/images/shape/shape-4.png" alt="Shape">
                <img class="shape-2" src="{{ asset('') }}/assets/front/images/shape/shape-5.png" alt="Shape">
                <img class="shape-3" src="{{ asset('') }}/assets/front/images/shape/shape-6.png" alt="Shape">
                <img class="shape-4" src="{{ asset('') }}/assets/front/images/shape/shape-7.png" alt="Shape">
                <img class="shape-5" src="{{ asset('') }}/assets/front/images/shape/shape-8.png" alt="Shape">
                <img class="shape-6" src="{{ asset('') }}/assets/front/images/shape/shape-9.png" alt="Shape">
            </div>
        </div>
        <!--====== End Breadcrumbs-section ======-->
    @endif

    @yield('content')

    {{-- footer section --}}
    @includeIf('front.partials.footer')

    <div class="go-top"><i class="fal fa-angle-double-up"></i></div>

    @if ($be->cookie_alert_status == 1)
        <div class="cookie">
            @include('cookie-consent::index')
        </div>
    @endif

    {{-- Popups start --}}
    {{-- @includeIf('front.partials.popups') --}}
    {{-- Popups end --}}

    <!-- Magic Cursor -->
    <div class="cursor"></div>
    <!-- Magic Cursor -->

    {{-- WhatsApp Chat Button --}}
    {{-- <div id="WAButton"></div> --}}

    {{-- <!-- Jquery JS -->
    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('assets/front/js/jquery.nice-select.min.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Swiper Slider JS -->
    <script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>
    <!-- Lazysizes -->
    <script src="{{ asset('assets/front/js/lazysizes.min.js') }}"></script>
    <!-- AOS JS -->
    <script src="{{ asset('assets/front/js/aos.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
    <!-- whatsapp JS -->
    <script src="{{ asset('assets/front/js/whatsapp.min.js') }}"></script>
    <!-- Main script JS -->
    <script src="{{ asset('assets/front/js/script.js') }}"></script> --}}

    <!-- Jquery JS -->
    <script src="{{ asset('/assets/front/js/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('/assets/front/js/bootstrap.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('/assets/front/js/jquery.nice-select.min.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('/assets/front/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Swiper Slider JS -->
    <script src="{{ asset('/assets/front/js/swiper-bundle.min.js') }}"></script>
    <!-- Lazysizes -->
    <script src="{{ asset('/assets/front/js/lazysizes.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
    <!-- whatsapp JS -->
    <script src="{{ asset('assets/front/js/whatsapp.min.js') }}"></script>
    <!-- AOS JS -->
    <script src="{{ asset('/assets/front/js/aos.min.js') }}"></script>
    <!-- Main script JS -->
    <script src="{{ asset('/assets/front/js/script.js') }}"></script>

    <script>
        "use strict";
        var rtl = {{ $rtl }};
    </script>

    @yield('scripts')

    @yield('vuescripts')


    @if (session()->has('success'))
        <script>
            "use strict";
            toastr['success']("{{ __(session('success')) }}");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            "use strict";
            toastr['error']("{{ __(session('error')) }}");
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            "use strict";
            toastr['warning']("{{ __(session('warning')) }}");
        </script>
    @endif
    <script>
        "use strict";

        function handleSelect(elm) {
            window.location.href = "{{ route('changeLanguage', '') }}" + "/" + elm.value;
        }
    </script>

    {{-- whatsapp init code --}}
    {{-- @if ($bs->is_whatsapp == 1)
        <script type="text/javascript">
            "use strict";
            var whatsapp_popup = {{ $bs->whatsapp_popup }};
            var whatsappImg = "{{ asset('assets/front/img/whatsapp.svg') }}";
            $(function() {
                $('#WAButton').floatingWhatsApp({
                    phone: "{{ $bs->whatsapp_number }}", //WhatsApp Business phone number
                    headerTitle: "{{ $bs->whatsapp_header_title }}", //Popup Title
                    popupMessage: `{!! !empty($bs->whatsapp_popup_message) ? nl2br($bs->whatsapp_popup_message) : '' !!}`, //Popup Message
                    showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
                    buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
                    position: "right" //Position: left | right

                });
            });
        </script>
    @endif --}}

    @if ($bs->is_tawkto == 1)
        @php
            $directLink = str_replace('tawk.to', 'embed.tawk.to', $bs->tawkto_chat_link);
            $directLink = str_replace('chat/', '', $directLink);
        @endphp
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            "use strict";
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ $directLink }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    @endif

</body>

</html>
