@extends('front.layout')

@section('pagename')
    - {{ __('Pricing') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->pricing_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : '')

@section('breadcrumb-title')
    {{ __('Pricing') }}
@endsection
@section('breadcrumb-link')
    {{ __('Pricing') }}
@endsection

@section('content')


    {{-- <!-- Pricing Start -->
    <section class="pricing-area pb-90 pt-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (count($terms) > 1)
                        <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                            <ul class="nav nav-tabs">
                                @foreach ($terms as $term)

                                    <li class="nav-item">
                                        <button class="nav-link {{$loop->first ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#{{__("$term")}}"
                                                type="button">{{__("$term")}}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="tab-content">
                        @foreach ($terms as $term)
                            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}} " id="{{__("$term")}}">
                                <div class="row">
                                    @php
                                        $packages = \App\Models\Package::where('status', '1')->where('featured', '1')->where('term', strtolower($term))->get();
                                    @endphp
                                    @foreach ($packages as $package)
                                        @php
                                            $pFeatures = json_decode($package->features);
                                        @endphp
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card mb-30 {{$package->recommended == '1' ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="100">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon blue"><i class="{{ $package->icon }}"></i></div>
                                                    <div class="label">
                                                        <h3>{{$package->title}}</h3>

                                                        @if ($package->recommended == '1')
                                                            <span>{{ __('Recommended') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="text"></p>
                                                <div class="d-flex align-items-center">

                                                    <span class="price">{{$package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''}}{{$package->price == 0 ? "Free" : $package->price}}{{$package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''}}</span>
                                                    <span class="period">/ {{__("$package->term")}}</span>


                                                </div>
                                                <h5>{{ __('Whats Included') }}</h5>
                                                <ul class="item-list list-unstyled p-0">
    
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->course_categories_limit === 999999 ? __('Unlimited') : $package->course_categories_limit.' '}}{{$package->course_categories_limit ===1 ? __('Course Category'):__('Course Categories')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->course_limit === 999999 ? __('Unlimited') : $package->course_limit.' '}}{{$package->course_limit=== 1 ? __('Course'):__('Courses')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->module_limit === 999999 ? __('Unlimited') : $package->module_limit.' '}}{{$package->module_limit===1 ? __('Module'): __('Modules')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->lesson_limit === 999999 ? __('Unlimited') : $package->lesson_limit.' '}}{{$package->lesson_limit ===1 ? __('Lesson'):__('Lessons')}}
                                                    </li>
                                                    <li>
                                                        <i class="fal fa-check"></i>
                                                        {{$package->featured_course_limit === 999999 ? __('Unlimited') : $package->featured_course_limit.' '}}{{$package->featured_course_limit === 1 ? __('Featured Course'):__('Featured Courses')}}
                                                    </li>
        
                                                    @foreach ($allPfeatures as $feature)
                                                        <li  class="{{is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled'}}">
                                                            <i class="{{is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times'}}"></i>
                                                            @if ($feature == 'Storage Limit')
                                                                @if ($package->storage_limit == 0 || $package->storage_limit == 999999)
                                                                    {{ __("$feature") }}
                                                                @elseif($package->storage_limit < 1024)
                                                                    {{ __("$feature"). ' ( '.$package->storage_limit .'MB )'}}
                                                                @else
                                                                    {{ __("$feature"). ' ( '. ceil($package->storage_limit/1024) .'GB )'}}
                                                                @endif
                                                            @else
                                                                {{__("$feature")}}
                                                            @endif
                                                        </li>
                                                    @endforeach

                                                </ul>
                                                <div class="d-flex align-items-center">
                                                    @if ($package->is_trial === '1' && $package->price != 0)
                                                        <a href="{{route('front.register.view',['status' => 'trial','id'=> $package->id])}}"
                                                           class="btn secondary-btn">{{__('Trial')}}</a>
                                                    @endif
                                                    @if ($package->price == 0)
                                                        <a href="{{route('front.register.view',['status' => 'regular','id'=> $package->id])}}"
                                                           class="btn primary-btn">{{__('Signup')}}</a>
                                                    @else
                                                        <a href="{{route('front.register.view',['status' => 'regular','id'=> $package->id])}}"
                                                           class="btn primary-btn">{{__('Purchase')}}</a>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-1.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-5.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-11.png')}}" alt="Shape">
        </div>
    </section>
    <!-- Pricing End --> --}}

    <!-- Pricing Start -->
    <section class="pricing-area pt-120 pb-90">
        <div class="container">
            @if (count($terms) > 1)
                <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                    <ul class="nav nav-tabs">
                        @foreach ($terms as $term)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#{{ __("$term") }}" type="button">{{ __("$term") }}</button>
                            </li>
                        @endforeach
                        {{-- <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#yearly"
                                type="button">Yearly</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lifeTime"
                                type="button">Lifetime</button>
                        </li> --}}
                    </ul>
                </div>
            @endif
            <div class="tab-content">
                @foreach ($terms as $term)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ __("$term") }}">
                        <div class="row justify-content-center">
                            @php
                                $packages = \App\Models\Package::where('status', '1')
                                    ->where('featured', '1')
                                    ->where('term', strtolower($term))
                                    ->get();
                            @endphp
                            @foreach ($packages as $package)
                                @php
                                    $pFeatures = json_decode($package->features);
                                @endphp
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="card mb-30 {{ $package->recommended == '1' ? 'active' : '' }}"
                                        data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-flex align-items-center">
                                            <div class="icon"><i class="{{ $package->icon }}"></i></div>
                                            <div class="label">
                                                <h4>{{ $package->title }}</h4>

                                                @if ($package->recommended == '1')
                                                    <span>{{ __('Recommended') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                            industry.</p>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="price">{{ $package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ $package->price == 0 ? 'Free' : $package->price }}{{ $package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                            <span class="period">/ {{ __("$package->term") }}</span>
                                        </div>
                                        <h5>{{ __('Whats Included') }}</h5>
                                        <ul class="pricing-list list-unstyled p-0">
                                            <li>
                                                <i class="fal fa-check"></i>
                                                {{ $package->course_categories_limit === 999999 ? __('Unlimited') : $package->course_categories_limit . ' ' }}{{ $package->course_categories_limit === 1 ? __('Course Category') : __('Course Categories') }}
                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                {{ $package->course_limit === 999999 ? __('Unlimited') : $package->course_limit . ' ' }}{{ $package->course_limit === 1 ? __('Course') : __('Courses') }}
                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                {{ $package->module_limit === 999999 ? __('Unlimited') : $package->module_limit . ' ' }}{{ $package->module_limit === 1 ? __('Module') : __('Modules') }}
                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                {{ $package->lesson_limit === 999999 ? __('Unlimited') : $package->lesson_limit . ' ' }}{{ $package->lesson_limit === 1 ? __('Lesson') : __('Lessons') }}
                                            </li>
                                            <li>
                                                <i class="fal fa-check"></i>
                                                {{ $package->featured_course_limit === 999999 ? __('Unlimited') : $package->featured_course_limit . ' ' }}{{ $package->featured_course_limit === 1 ? __('Featured Course') : __('Featured Courses') }}
                                            </li>

                                            @foreach ($allPfeatures as $feature)
                                                <li
                                                    class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled' }}">
                                                    <i
                                                        class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times' }}"></i>
                                                    @if ($feature == 'Storage Limit')
                                                        @if ($package->storage_limit == 0 || $package->storage_limit == 999999)
                                                            {{ __("$feature") }}
                                                        @elseif($package->storage_limit < 1024)
                                                            {{ __("$feature") . ' ( ' . $package->storage_limit . 'MB )' }}
                                                        @else
                                                            {{ __("$feature") . ' ( ' . ceil($package->storage_limit / 1024) . 'GB )' }}
                                                        @endif
                                                    @else
                                                        {{ __("$feature") }}
                                                    @endif
                                                </li>
                                            @endforeach

                                        </ul>
                                        <div class="btn-groups">
                                            {{-- <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                                title="Trial" target="_self">Trial</a>
                                            <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                                title="Purchase" target="_self">Purchase</a> --}}

                                            @if ($package->is_trial === '1' && $package->price != 0)
                                                <a href="{{ route('front.register.view', ['status' => 'trial', 'id' => $package->id]) }}"
                                                    itle="Trial" target="_self"
                                                    class="btn btn-lg btn-primary no-animation">{{ __('Trial') }}</a>
                                            @endif
                                            @if ($package->price == 0)
                                                <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                    class="btn btn-lg btn-primary no-animation">{{ __('Signup') }}</a>
                                            @else
                                                <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                    title="Purchase" target="_self"
                                                    class="btn btn-lg btn-outline no-animation">{{ __('Purchase') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="col-md-6 col-lg-4 item">
                                <div class="card mb-30 active" data-aos="fade-up" data-aos-delay="200">
                                    <div class="d-flex align-items-center">
                                        <div class="icon"><i class="ico-badge-check"></i></div>
                                        <div class="label">
                                            <h4>Freelancer Plan</h4>
                                            <span>Popular</span>
                                        </div>
                                    </div>
                                    <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                        industry.</p>
                                    <div class="d-flex align-items-center">
                                        <span class="price">$299</span>
                                        <span class="period">/ Monthly</span>
                                    </div>
                                    <h5>What's Included</h5>
                                    <ul class="pricing-list list-unstyled p-0">
                                        <li><i class="fal fa-check"></i>30 days consultancy</li>
                                        <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                        <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                        <li><i class="fal fa-check"></i>Unlimited Page Views</li>
                                        <li class="disabled"><i class="fal fa-times"></i>Mony back guarantee</li>
                                    </ul>
                                    <div class="btn-groups">
                                        <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                            title="Trial" target="_self">Trial</a>
                                        <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                            title="Purchase" target="_self">Purchase</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 item">
                                <div class="card mb-30" data-aos="fade-up" data-aos-delay="300">
                                    <div class="d-flex align-items-center">
                                        <div class="icon"><i class="ico-cube"></i></div>
                                        <div class="label">
                                            <h4>Entrepreneur Plan</h4>
                                        </div>
                                    </div>
                                    <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                        industry.</p>
                                    <div class="d-flex align-items-center">
                                        <span class="price">$399</span>
                                        <span class="period">/ Monthly</span>
                                    </div>
                                    <h5>What's Included</h5>
                                    <ul class="pricing-list list-unstyled p-0">
                                        <li><i class="fal fa-check"></i>30 days consultancy</li>
                                        <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                        <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                        <li><i class="fal fa-check"></i>Unlimited Page Views</li>
                                        <li><i class="fal fa-check"></i>Mony back guarantee</li>
                                    </ul>
                                    <div class="btn-groups">
                                        <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                            title="Trial" target="_self">Trial</a>
                                        <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                            title="Purchase" target="_self">Purchase</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
                {{-- <div class="tab-pane fade" id="yearly">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-4 item">
                            <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                <div class="d-flex align-items-center">
                                    <div class="icon"><i class="ico-layers"></i></div>
                                    <div class="label">
                                        <h4>Beginner Plan</h4>
                                    </div>
                                </div>
                                <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                    industry.</p>
                                <div class="d-flex align-items-center">
                                    <span class="price">$99</span>
                                    <span class="period">/ Monthly</span>
                                </div>
                                <h5>What's Included</h5>
                                <ul class="pricing-list list-unstyled p-0">
                                    <li><i class="fal fa-check"></i>30 days consultancy</li>
                                    <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                    <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                    <li class="disabled"><i class="fal fa-times"></i>Unlimited Page Views</li>
                                    <li class="disabled"><i class="fal fa-times"></i>Mony back guarantee</li>
                                </ul>
                                <div class="btn-groups">
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                        title="Trial" target="_self">Trial</a>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                        title="Purchase" target="_self">Purchase</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 item">
                            <div class="card mb-30 active" data-aos="fade-up" data-aos-delay="200">
                                <div class="d-flex align-items-center">
                                    <div class="icon"><i class="ico-badge-check"></i></div>
                                    <div class="label">
                                        <h4>Freelancer Plan</h4>
                                        <span>Popular</span>
                                    </div>
                                </div>
                                <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                    industry.</p>
                                <div class="d-flex align-items-center">
                                    <span class="price">$299</span>
                                    <span class="period">/ Monthly</span>
                                </div>
                                <h5>What's Included</h5>
                                <ul class="pricing-list list-unstyled p-0">
                                    <li><i class="fal fa-check"></i>30 days consultancy</li>
                                    <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                    <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                    <li><i class="fal fa-check"></i>Unlimited Page Views</li>
                                    <li class="disabled"><i class="fal fa-times"></i>Mony back guarantee</li>
                                </ul>
                                <div class="btn-groups">
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                        title="Trial" target="_self">Trial</a>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                        title="Purchase" target="_self">Purchase</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 item">
                            <div class="card mb-30" data-aos="fade-up" data-aos-delay="300">
                                <div class="d-flex align-items-center">
                                    <div class="icon"><i class="ico-cube"></i></div>
                                    <div class="label">
                                        <h4>Entrepreneur Plan</h4>
                                    </div>
                                </div>
                                <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                    industry.</p>
                                <div class="d-flex align-items-center">
                                    <span class="price">$399</span>
                                    <span class="period">/ Monthly</span>
                                </div>
                                <h5>What's Included</h5>
                                <ul class="pricing-list list-unstyled p-0">
                                    <li><i class="fal fa-check"></i>30 days consultancy</li>
                                    <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                    <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                    <li><i class="fal fa-check"></i>Unlimited Page Views</li>
                                    <li><i class="fal fa-check"></i>Mony back guarantee</li>
                                </ul>
                                <div class="btn-groups">
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                        title="Trial" target="_self">Trial</a>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                        title="Purchase" target="_self">Purchase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="lifeTime">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-4 item">
                            <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                <div class="d-flex align-items-center">
                                    <div class="icon"><i class="ico-layers"></i></div>
                                    <div class="label">
                                        <h4>Beginner Plan</h4>
                                    </div>
                                </div>
                                <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                    industry.</p>
                                <div class="d-flex align-items-center">
                                    <span class="price">$99</span>
                                    <span class="period">/ Monthly</span>
                                </div>
                                <h5>What's Included</h5>
                                <ul class="pricing-list list-unstyled p-0">
                                    <li><i class="fal fa-check"></i>30 days consultancy</li>
                                    <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                    <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                    <li class="disabled"><i class="fal fa-times"></i>Unlimited Page Views</li>
                                    <li class="disabled"><i class="fal fa-times"></i>Mony back guarantee</li>
                                </ul>
                                <div class="btn-groups">
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                        title="Trial" target="_self">Trial</a>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                        title="Purchase" target="_self">Purchase</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 item">
                            <div class="card mb-30 active" data-aos="fade-up" data-aos-delay="200">
                                <div class="d-flex align-items-center">
                                    <div class="icon"><i class="ico-badge-check"></i></div>
                                    <div class="label">
                                        <h4>Freelancer Plan</h4>
                                        <span>Popular</span>
                                    </div>
                                </div>
                                <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                    industry.</p>
                                <div class="d-flex align-items-center">
                                    <span class="price">$299</span>
                                    <span class="period">/ Monthly</span>
                                </div>
                                <h5>What's Included</h5>
                                <ul class="pricing-list list-unstyled p-0">
                                    <li><i class="fal fa-check"></i>30 days consultancy</li>
                                    <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                    <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                    <li><i class="fal fa-check"></i>Unlimited Page Views</li>
                                    <li class="disabled"><i class="fal fa-times"></i>Mony back guarantee</li>
                                </ul>
                                <div class="btn-groups">
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                        title="Trial" target="_self">Trial</a>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                        title="Purchase" target="_self">Purchase</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 item">
                            <div class="card mb-30" data-aos="fade-up" data-aos-delay="300">
                                <div class="d-flex align-items-center">
                                    <div class="icon"><i class="ico-cube"></i></div>
                                    <div class="label">
                                        <h4>Entrepreneur Plan</h4>
                                    </div>
                                </div>
                                <p class="text">Lorem Ipsum is simply dummy of the printing and typesetting
                                    industry.</p>
                                <div class="d-flex align-items-center">
                                    <span class="price">$399</span>
                                    <span class="period">/ Monthly</span>
                                </div>
                                <h5>What's Included</h5>
                                <ul class="pricing-list list-unstyled p-0">
                                    <li><i class="fal fa-check"></i>30 days consultancy</li>
                                    <li><i class="fal fa-check"></i>Up to 10 agents hire</li>
                                    <li><i class="fal fa-check"></i>24/7 Hours supper support</li>
                                    <li><i class="fal fa-check"></i>Unlimited Page Views</li>
                                    <li><i class="fal fa-check"></i>Mony back guarantee</li>
                                </ul>
                                <div class="btn-groups">
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-primary no-animation"
                                        title="Trial" target="_self">Trial</a>
                                    <a href="javaScript:void(0)" class="btn btn-lg btn-outline no-animation"
                                        title="Purchase" target="_self">Purchase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- Pricing End -->

@endsection
