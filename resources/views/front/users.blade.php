@extends('front.layout')

@section('pagename')
    - {{ __('Profile') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->profiles_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->profiles_meta_keywords : '')

@section('breadcrumb-title')
    {{ __('Profile') }}
@endsection
@section('breadcrumb-link')
    {{ __('Profile') }}
@endsection

@section('content')

    <!--====== Start saas-featured-users section ======-->

    {{-- <section class="user-profile-area ptb-120 pb-80">
        <div class="container">
            <div class="row">
                @if (count($users) == 0)
                    <div class="bg-light text-center py-5 d-block w-100">
                        <h3>NO PROFILE FOUND</h3>
                    </div>
                @else
                    @foreach ($users as $user)
                        <div class="col-lg-4 col-sm-6">
                            <div class="swiper-slide user-card mb-30">
                                <div class="card" data-aos="fade-up" data-aos-delay="100">
                                    <div class="icon">
                                        @if ($user->photo)
                                            <img class="lazy" src="{{ asset('assets/front/img/user/'.$user->photo) }}"
                                                 alt="user">
                                        @else
                                            <img class="lazy" src="{{ asset('assets/admin/img/propics/blank_user.jpg') }}"
                                                 alt="user">
                                        @endif
                                    </div>
                                    <div class="card-content green">
                                        <h3 class="card-title">{{$user->first_name." ".$user->last_name}}</h3>
                                        <div class="social-link">
                                            @foreach ($user->social_media as $social)
                                                <a href="{{$social->url}}" target="_blank"><i class="{{$social->icon}}"></i></a>
                                            @endforeach
                                        </div>
                                        <div class="cta-btns">
                                            @php
                                                if (!empty($user)) {
                                                    $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($user->id);
                                                    $preferences = App\Models\User\UserPermission::where([
                                                        ['user_id',$user->id],
                                                        ['package_id',$currentPackage->package_id]
                                                    ])->first();
                                                    $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                                }
                                            @endphp
                                            <a href="{{detailsUrl($user)}}" class="btn btn-sm secondary-btn">{{__('View Profile')}}</a>
                                            @guest
                                                @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))

                                                    <a href="{{route('user.follow',['id' => $user->id])}}" class="btn btn-sm primary-btn"><i class="fal fa-user-plus"></i>{{__('Follow')}}
                                                    </a>
                                                @endif
                                            @endguest
                                            @if (Auth::guard('web')->check() && Auth::guard('web')->user()->id != $user->id)
                                                @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))

                                                    @if (App\Models\User\Follower::where('follower_id', Auth::guard('web')->user()->id)->where('following_id', $user->id)->count() > 0)
                                                        <a href="{{route('user.unfollow', $user->id)}}" class="btn btn-sm primary-btn"><i class="fal fa-user-minus"></i>{{__('Unfollow')}}
                                                        </a>
                                                    @else
                                                        <a href="{{route('user.follow',['id' => $user->id])}}" class="btn btn-sm primary-btn"><i class="fal fa-user-plus"></i>{{__('Follow')}}
                                                            @endif
                                                        </a>

                                                    @endif
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="pagination mb-30 justify-content-center">
                {{$users->appends(['search' => request()->input('search'), 'designation' => request()->input('designation'), 'location' => request()->input('location')])->links()}}
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="bg-overlay" src="{{asset('assets/front/img/shadow-bg-2.png')}}" alt="Bg">
        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="{{asset('assets/front/img/shape/shape-10.png')}}" alt="Shape">
            <img class="shape-2" src="{{asset('assets/front/img/shape/shape-6.png')}}" alt="Shape">
            <img class="shape-3" src="{{asset('assets/front/img/shape/shape-7.png')}}" alt="Shape">
            <img class="shape-4" src="{{asset('assets/front/img/shape/shape-4.png')}}" alt="Shape">
            <img class="shape-5" src="{{asset('assets/front/img/shape/shape-3.png')}}" alt="Shape">
            <img class="shape-6" src="{{asset('assets/front/img/shape/shape-8.png')}}" alt="Shape">
        </div>
    </section> --}}

    <!--====== End saas-featured-users section ======-->
    <!-- User Profile Start -->
    <section class="user-profile-area ptb-120">
        <div class="container">
            <div class="row">
                @if (count($users) == 0)
                    <div class="bg-light text-center py-5 d-block w-100">
                        <h3>NO PROFILE FOUND</h3>
                    </div>
                @else
                    @foreach ($users as $user)
                        <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                            <div class="card mb-30">
                                <div class="icon">

                                    @if ($user->photo)
                                        <img class="lazy" src="{{ asset('assets/front/img/user/' . $user->photo) }}"
                                            alt="user">
                                    @else
                                        <img class="lazy" src="{{ asset('assets/admin/img/propics/blank_user.jpg') }}"
                                            alt="user">
                                    @endif
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">{{ $user->first_name . ' ' . $user->last_name }}</h4>
                                    <div class="social-link">
                                        @foreach ($user->social_media as $social)
                                            <a href="{{ $social->url }}" target="_blank"><i
                                                    class="{{ $social->icon }}"></i></a>
                                        @endforeach

                                    </div>
                                    <div class="btn-groups">
                                        @php
                                            if (!empty($user)) {
                                                $currentPackage = App\Http\Helpers\UserPermissionHelper::userPackage($user->id);
                                                $preferences = App\Models\User\UserPermission::where([['user_id', $user->id], ['package_id', $currentPackage->package_id]])->first();
                                                $permissions = isset($preferences) ? json_decode($preferences->permissions, true) : [];
                                            }
                                        @endphp
                                        <a href="{{ detailsUrl($user) }}" class="btn btn-sm btn-outline"
                                            title="View Profile" target="_self">{{ __('View Profile') }}</a>
                                        @guest
                                            @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))
                                                <a href="{{ route('user.follow', ['id' => $user->id]) }}"
                                                    class="btn btn-sm btn-primary " title="Follow Us" target="_self">
                                                    {{ __('Follow Us') }}
                                                </a>
                                            @endif
                                        @endguest
                                        @if (Auth::guard('web')->check() && Auth::guard('web')->user()->id != $user->id)
                                            @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))
                                                @if (App\Models\User\Follower::where('follower_id', Auth::guard('web')->user()->id)->where('following_id', $user->id)->count() > 0)
                                                    <a href="{{ route('user.unfollow', $user->id) }}"
                                                        class="btn btn-sm btn-primary"> {{ __('Unfollow') }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('user.follow', ['id' => $user->id]) }}"
                                                        class="btn btn-sm btn-primary"> {{ __('Follow Us') }}
                                                @endif
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
            <nav class="pagination-nav" data-aos="fade-up">
                <ul class="pagination justify-content-center mb-0">
                    {{ $users->appends(['search' => request()->input('search'), 'designation' => request()->input('designation'), 'location' => request()->input('location')])->links() }}
                    {{-- <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="far fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="far fa-angle-right"></i>
                        </a>
                    </li> --}}
                </ul>
            </nav>
        </div>
    </section>
    <!-- User Profile End -->
@endsection
