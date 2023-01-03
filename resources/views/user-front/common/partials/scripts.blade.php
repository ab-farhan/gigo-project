<script>
  "use strict";
  const baseURL = "{{ url('/') }}";
  const vapid_public_key = "{!! env('VAPID_PUBLIC_KEY') !!}";
  const langDir = {{ $currentLanguageInfo->rtl }};
  const rtl = {{ $currentLanguageInfo->rtl }};
</script>

{{-- jQuery --}}
<script type="text/javascript" src="{{ asset('assets/front/js/vendor/jquery.min.js') }}"></script>

{{-- modernizr js --}}
<script type="text/javascript" src="{{ asset('assets/front/js/vendor/modernizr.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/front/js/popper.min.js') }}"></script>

{{-- bootstrap js --}}
<script type="text/javascript" src="{{ asset('assets/admin/js/core/bootstrap.min.js') }}"></script>

{{-- slick js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/slick.min.js') }}"></script>

{{-- isotope-pkgd js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/isotope-pkgd-3.0.6.min.js') }}"></script>

{{-- imagesloaded-pkgd js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/imagesloaded.pkgd.min.js') }}"></script>

{{-- magnific-popup js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/jquery.magnific-popup.min.js') }}"></script>

{{-- owl-carousel js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/owl-carousel.min.js') }}"></script>

{{-- nice-select js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/jquery.nice-select.min.js') }}"></script>

{{-- wow js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/wow.min.js') }}"></script>

{{-- jquery-counterup js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/jquery.counterup.min.js') }}"></script>

{{-- waypoints js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/waypoints.min.js') }}"></script>

{{-- toastr js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/toastr.min.js') }}"></script>

{{-- datatables js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/datatables-1.10.23.min.js') }}"></script>

{{-- datatables bootstrap js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/datatables.bootstrap4.min.js') }}"></script>

{{-- jQuery-ui js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/jquery-ui.min.js') }}"></script>

{{-- pluging js --}}
<script type="text/javascript" src="{{ asset('assets/front/js/plugin.min.js') }}"></script>

{{-- highlight js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/highlight.pack.js') }}"></script>

{{-- Highligh js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/jquery-syotimer.min.js') }}"></script>



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

@if (request()->routeIs('customer.my_course.curriculum'))
  {{-- video js --}}
  <script type="text/javascript" src="{{ asset('assets/tenant/js/video.min.js') }}"></script>
@endif

{{-- lazy load js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/lazyload.min.js') }}"></script>

{{-- new main js --}}
<script type="text/javascript" src="{{ asset('assets/tenant/js/front-main.js') }}"></script>

{{-- whatsapp init code --}}
@if ($websiteInfo->whatsapp_status == 1)
<script type="text/javascript">
    var whatsapp_popup = {{$websiteInfo->whatsapp_popup_status}};
    var whatsappImg = "{{asset('assets/front/img/whatsapp.svg')}}";
    $(function () {
        $('#WAButton').floatingWhatsApp({
            phone: "{{$websiteInfo->whatsapp_number}}", //WhatsApp Business phone number
            headerTitle: "{{$websiteInfo->whatsapp_header_title}}", //Popup Title
            popupMessage: `{!! nl2br($websiteInfo->whatsapp_popup_message) !!}`, //Popup Message
            showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
            buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
            position: "right" 
        });
    });
</script>
@endif