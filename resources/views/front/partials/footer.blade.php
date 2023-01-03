{{-- <!-- Footer Area -->
<footer class="footer-area">
    @if ($bs->top_footer_section == 1)
        <div class="footer-top pt-120 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="100">
                    <div class="navbar-brand">
                        <a href="index.html">
                            <img src="{{asset('assets/front/img/' . $bs->footer_logo)}}" alt="Logo">
                        </a>
                    </div>
                    <p>{{$bs->footer_text}}</p>
                    <div class="social-link">


                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                    @php
                        $ulinks = App\Models\Ulink::where('language_id',$currentLang->id)->orderby('id','desc')->get();
                    @endphp
                    <h3>{{$bs->useful_links_title}}</h3>
                    <ul class="footer-links">
                        @foreach ($ulinks as $ulink)
                            <li><a href="{{$ulink->url}}">{{$ulink->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="400">
                    <h3> {{ $bs->contact_info_title }}</h3>

                    <ul class="info-list">
                        <li>
                            <i class="fal fa-map-marker-alt"></i>
                            <span>{{ $be->contact_addresses }}</span>
                        </li>
                        <li>
                            @php
                                $phones = explode(',', $be->contact_numbers);
                            @endphp
                            <i class="fal fa-phone"></i>
                            @foreach ($phones as $phone)
                                <a href="tel:{{$phone}}">{{ $phone }}</a>
                                @if (!$loop->last)
                                   , 
                                @endif
                            @endforeach
                        </li>
                        <li>
                            @php
                                $mails = explode(',', $be->contact_mails);
                            @endphp
                            <i class="fal fa-envelope"></i>
                            @foreach ($mails as $mail)
                                <a href="mailto:{{$mail}}">{{ $mail }}</a>
                                @if (!$loop->last)
                                   , 
                                @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="footer-widget" data-aos="fade-up" data-aos-delay="500">
                    <h3>{{$bs->newsletter_title}}</h3>
                    <p>{{$bs->newsletter_subtitle}}</p>
                    <form id="footerSubscriber" action="{{route('front.subscribe')}}" method="POST" class="subscribeForm">
                        @csrf
                        <div class="input-group">
                            <input name="email" class="form-control" placeholder="{{ __("Enter Your Email") }}" type="text" required="" autocomplete="off">
                            <button class="btn btn-sm primary-btn" type="submit">{{ __("Subscribe") }}</button>
                        </div>
                        <p id="erremail" class="text-danger mb-0 err-email"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    @endif
    @if ($bs->copyright_section == 1)
        <div class="copy-right-area">
            <div class="container">
                <div class="copy-right-content">
                    @if ($bs->copyright_section == 1)
                        <span>
                        {!! replaceBaseUrl($bs->copyright_text) !!}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</footer>
<!-- Footer Area --> --}}

<!-- Footer Area -->
<footer class="footer-area bg-primary-light bg-img" data-bg-image="{{ asset('/') }}assets/front/images/footer-bg.png">
    <div class="footer-top pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="100">
                        <div class="navbar-brand">
                            <a href="index.html">
                                <img src="{{ asset('/') }}assets/front/images/logo.png" alt="Logo">
                            </a>
                        </div>
                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        <div class="btn-groups">
                            <a href="error.html" class="btn btn-img radius-sm size-sm" title="App Store"
                                target="_blank">
                                <img class="blur-up ls-is-cached lazyloaded" src="{{ asset('/') }}assets/front/images/app-store.png"
                                    data-src="{{ asset('/') }}assets/front/images/app-store.png" alt="App Store">
                            </a>
                            <a href="error.html" class="btn btn-img radius-sm size-sm" title="Play Store"
                                target="_blank">
                                <img class="blur-up ls-is-cached lazyloaded" src="{{ asset('/') }}assets/front/images/play-store.png"
                                    data-src="{{ asset('/') }}assets/front/images/play-store.png" alt="App Store">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                        <h5>Useful Links</h5>
                        <ul class="footer-links">
                            <li>
                                <a href="javaScript:void(0)">About Us</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">Pricing</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">Services</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">Privacy</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                        <h5>Features</h5>
                        <ul class="footer-links">
                            <li>
                                <a href="javaScript:void(0)">Wp Themes</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">Html Template</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">UI Template</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">CMS Template</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                        <h5>Categories</h5>
                        <ul class="footer-links">
                            <li>
                                <a href="javaScript:void(0)">Wp Themes</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">Html Template</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">UI Template</a>
                            </li>
                            <li>
                                <a href="javaScript:void(0)">CMS Template</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="500">
                        <h5>Subscribe Us</h5>
                        <p class="lh-1 mb-20">Stay update with us and get offer!</p>
                        <div class="newsletter-form">
                            <form id="newsletterForm">
                                <div class="form-group">
                                    <input class="form-control radius-sm" placeholder="Enter email here..."
                                        type="text" name="EMAIL" required="" autocomplete="off">
                                    <button class="btn btn-md btn-primary radius-sm no-animation" type="submit"><i
                                            class="fal fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right-area border-top">
        <div class="container">
            <div class="copy-right-content">
                <div class="social-link justify-content-center mb-2">
                    <a href="https://www.instagram.com/" target="_blank" title="instagram"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.dribbble.com/" target="_blank" title="dribbble"><i
                            class="fab fa-dribbble"></i></a>
                    <a href="https://www.twitter.com/" target="_blank" title="twitter"><i
                            class="fab fa-twitter"></i></a>
                    <a href="https://www.youtube.com/" target="_blank" title="youtube"><i
                            class="fab fa-youtube"></i></a>
                </div>
                <span>
                    Copyright <i class="fal fa-copyright"></i><span id="footerDate"></span> <a href="index.html"
                        class="color-primary">Gigo</a>. All Rights Reserved
                </span>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area -->
