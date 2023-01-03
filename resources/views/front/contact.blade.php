@extends('front.layout')

@section('meta-description', !empty($seo) ? $seo->contact_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->contact_meta_keywords : '')

@section('pagename')
    - {{ __('Contact') }}
@endsection
@section('breadcrumb-title')
    {{ __('Contact') }}
@endsection
@section('breadcrumb-link')
    {{ __('Contact') }}
@endsection

@section('content')

    <!--====== Start contacts-section ======-->
    {{-- <div class="contact-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="row justify-content-center">
                        @php
                            $phones = explode(',', $be->contact_numbers);
                        @endphp
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 blue" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon">
                                    <i class="fal fa-phone-plus"></i>
                                </div>
                                <div class="card-text">
                                    @foreach ($phones as $phone)
                                        <p><a href="tel:{{$phone}}">{{$phone}}</a></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php
                            $mails = explode(',', $be->contact_mails);
                        @endphp
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 green" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="card-text">
                                    @foreach ($mails as $mail)
                                        <p><a href="mailTo:{{$mail}}">{{$mail}}</a></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php
                            $addresses = explode(PHP_EOL, $be->contact_addresses);
                        @endphp
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-50 orange" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="card-text">
                                    @foreach ($addresses as $address)
                                        <p>{{$address}}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8 mb-30" data-aos="fade-up" data-aos-delay="100">
                            <form action="{{route('front.admin.contact.message')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="text" name="name" class="form-control" id="name" required
                                                   data-error="Enter your name" placeholder="{{__('Full Name')}} *" />
                                            @if ($errors->has('name'))
                                                <div class="help-block with-errors">{{$errors->first('name')}}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="email" name="email" class="form-control" id="email" required
                                                   data-error="Enter your email" placeholder="{{ __('Email Address') }}*" />
                                            @if ($errors->has('email'))
                                                <div class="help-block with-errors">{{$errors->first('email')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <input type="subject" name="subject" class="form-control" id="subject" required data-error="Enter your subject" placeholder="{{ __('Subject') }}*" />
                                            @if ($errors->has('subject'))
                                                <div class="help-block with-errors">{{$errors->first('subject')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <textarea name="message" id="message" class="form-control" cols="30"
                                                      rows="8" required data-error="Please enter your message"
                                                      placeholder="{{ __('Message') }}... *"></textarea>
                                            @if ($errors->has('message'))
                                                <div class="help-block with-errors">{{$errors->first('message')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn primary-btn primary-btn-5"
                                                title="Send message">{{ __('Send Message') }}</button>
                                        <div id="msgSubmit"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-9.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-7" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-8" src="{{asset('assets/front/img/shape/shape-9.png')}}" alt="Shape">
            <img class="shape-9" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-10" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
        </div>
    </div> --}}
    <!--====== End contacts-section ======-->
    <div class="contact-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col--lg-10">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 blue" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon">
                                    <i class="fal fa-phone-plus"></i>
                                </div>
                                <div class="card-text">
                                    @php
                                        $phones = explode(',', $be->contact_numbers);
                                    @endphp
                                    @foreach ($phones as $phone)
                                        <p><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 green" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="card-text">
                                    @php
                                        $mails = explode(',', $be->contact_mails);
                                    @endphp
                                    @foreach ($mails as $mail)
                                        <p><a href="mailTo:{{ $mail }}">{{ $mail }}</a></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-50 orange" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="card-text">
                                    @php
                                        $addresses = explode(PHP_EOL, $be->contact_addresses);
                                    @endphp
                                    @foreach ($addresses as $address)
                                        <p>{{ $address }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-30" data-aos="fade-up" data-aos-delay="100">
                            <form id="contactForm" action="{{ route('front.admin.contact.message') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="text" name="name" class="form-control" id="name"
                                                required data-error="Enter your name" placeholder="Your Name*" />
                                            @if ($errors->has('name'))
                                                <div class="help-block with-errors">{{ $errors->first('name') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="email" name="email" class="form-control" id="email"
                                                required data-error="Enter your email" placeholder="Your Email*" />
                                            @if ($errors->has('email'))
                                                <div class="help-block with-errors">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <textarea name="message" id="message" class="form-control" cols="30" rows="8" required
                                                data-error="Please enter your message" placeholder="Your Message..."></textarea>
                                            @if ($errors->has('message'))
                                                <div class="help-block with-errors">{{ $errors->first('message') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="checkbox mb-30">
                                            <input type="checkbox" id="checkboxInput" required>
                                            <label for="checkboxInput" id="checkbox">
                                                <svg viewBox="0 0 100 100">
                                                    <path class="box"
                                                        d="M82,89H18c-3.87,0-7-3.13-7-7V18c0-3.87,3.13-7,7-7h64c3.87,0,7,3.13,7,7v64C89,85.87,85.87,89,82,89z" />
                                                    <polyline class="check" points="25.5,53.5 39.5,67.5 72.5,34.5 " />
                                                </svg>
                                                <span>I agreed Gigo <a href="terms-and-conditions.html">Terms of
                                                        Services</a></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-primary" title="Send message">Send
                                            Message</button>
                                        <div id="msgSubmit"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 mb-30" data-aos="fade-up" data-aos-delay="200">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d57015.866600733796!2d-80.1461976445511!3d26.72868216144084!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWest%20Palm%20Beach%2C%204669%2C%20Travis!5e0!3m2!1sen!2sbd!4v1653371634659!5m2!1sen!2sbd"
                                style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== End contacts-section ======-->
@endsection
