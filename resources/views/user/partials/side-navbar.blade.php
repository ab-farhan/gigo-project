@php
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use Illuminate\Support\Facades\Auth;
$default = Language::where('is_default', 1)->where('user_id', Auth::user()->id)->first();
$user = Auth::guard('web')->user();
$package = UserPermissionHelper::currentPackage($user->id);
if (!empty($user)) {
$permissions = UserPermissionHelper::packagePermission($user->id);
$permissions = json_decode($permissions, true);
$userBs = BasicSetting::where('user_id', $user->id)->first();
}
@endphp
<div class="sidebar sidebar-style-2"
@if(request()->cookie('user-theme') == 'dark') data-background-color="dark2" @endif>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <div class="user">
            <div class="avatar-sm float-left mr-2">
                @if (!empty(Auth::user()->photo))
                <img src="{{asset('assets/front/img/user/'.Auth::user()->photo)}}" alt="..."
                    class="avatar-img rounded">
                @else
                <img src="{{asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..."
                    class="avatar-img rounded">
                @endif
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                <span>
                {{auth()->user()->first_name.' '.auth()->user()->last_name}}
                <span class="user-level">{{auth()->user()->username}}</span>
                <span class="caret"></span>
                </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse in" id="collapseExample">
                    <ul class="nav">
                        @if(!is_null($package))
                        <li>
                            <a href="{{route('user-profile-update')}}">
                            <span class="link-collapse">{{__('Edit Profile')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('user.changePass')}}">
                            <span class="link-collapse">{{__('Change Password')}}</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{route('user-logout')}}">
                            <span class="link-collapse">{{__('Logout')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav nav-primary">
            <div class="row mb-2">
                <div class="col-12">
                    <form action="">
                        <div class="form-group py-0">
                            <input name="term" type="text" class="form-control sidebar-search ltr" value=""
                                placeholder="{{__('Search Menu Here')}}...">
                        </div>
                    </form>
                </div>
            </div>
            <li class="nav-item
            @if(request()->path() == "user/dashboard") active
            @endif">
            <a href="{{route('user-dashboard')}}">
                <i class="la flaticon-paint-palette"></i>
                <p>{{__('Dashboard')}}</p>
            </a>
            </li>

            @if(!is_null($package))
            {{-- Menu Builder--}}
            <li class="nav-item
                @if(request()->path() == 'user/menu-builder') active @endif">
                <a href="{{route('user.menu_builder.index') . '?language=' . $default->code}}">
                    <i class="fas fa-bars"></i>
                    <p>{{__('Menu Builder')}}</p>
                </a>
            </li>
            @endif

            @if(!is_null($package))
            {{-- Start Instructor --}}
            <li class="nav-item @if (request()->routeIs('user.instructors')) active
                @elseif (request()->routeIs('user.create_instructor')) active
                @elseif (request()->routeIs('user.edit_instructor')) active
                @elseif (request()->routeIs('user.instructor.social_links')) active
                @elseif (request()->routeIs('user.instructor.edit_social_link')) active @endif"
                >
                <a href="{{ route('user.instructors', ['language' => $default->code]) }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <p>{{ __('Instructors') }}</p>
                </a>
            </li>
            {{--End Instructor --}}
            {{-- Start Course Management --}}
            <li class="nav-item @if (request()->routeIs('user.course_management.settings')) active
                @elseif (request()->routeIs('user.course_management.categories')) active
                @elseif (request()->routeIs('user.course_management.courses')) active
                @elseif (request()->routeIs('user.course_management.create_course')) active
                @elseif (request()->routeIs('user.course_management.edit_course')) active
                @elseif (request()->routeIs('user.course_management.course.faqs')) active
                @elseif (request()->routeIs('user.course_management.course.thanks_page')) active
                @elseif (request()->routeIs('user.course_management.course.certificate_settings')) active
                @elseif (request()->routeIs('user.course_management.course.modules')) active
                @elseif (request()->routeIs('user.course_management.lesson.contents')) active
                @elseif (request()->routeIs('user.course_management.lesson.create_quiz')) active
                @elseif (request()->routeIs('user.course_management.lesson.manage_quiz')) active
                @elseif (request()->routeIs('user.course_management.lesson.edit_quiz')) active
                @elseif (request()->routeIs('user.course_management.coupons')) active @endif"
                >
                <a data-toggle="collapse" href="#course">
                    <i class="fas fa-book"></i>
                    <p>{{ __('Course Management') }}</p>
                    <span class="caret"></span>
                </a>
                <div id="course" class="collapse
                    @if (request()->routeIs('user.course_management.settings')) show
                    @elseif (request()->routeIs('user.course_management.categories')) show
                    @elseif (request()->routeIs('user.course_management.courses')) show
                    @elseif (request()->routeIs('user.course_management.create_course')) show
                    @elseif (request()->routeIs('user.course_management.edit_course')) show
                    @elseif (request()->routeIs('user.course_management.course.faqs')) show
                    @elseif (request()->routeIs('user.course_management.course.thanks_page')) show
                    @elseif (request()->routeIs('user.course_management.course.certificate_settings')) show
                    @elseif (request()->routeIs('user.course_management.course.modules')) show
                    @elseif (request()->routeIs('user.course_management.lesson.contents')) show
                    @elseif (request()->routeIs('user.course_management.lesson.create_quiz')) show
                    @elseif (request()->routeIs('user.course_management.lesson.manage_quiz')) show
                    @elseif (request()->routeIs('user.course_management.lesson.edit_quiz')) show
                    @elseif (request()->routeIs('user.course_management.coupons')) show @endif"
                    >
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('user.course_management.categories') ? 'active' : '' }}">
                            <a href="{{ route('user.course_management.categories', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Categories') }}</span>
                            </a>
                        </li>
                        <li class="@if(request()->routeIs('user.course_management.courses')) active
                            @elseif (request()->routeIs('user.course_management.create_course')) active
                            @elseif (request()->routeIs('user.course_management.edit_course')) active
                            @elseif (request()->routeIs('user.course_management.course.faqs')) active
                            @elseif (request()->routeIs('user.course_management.course.thanks_page')) active
                            @elseif (request()->routeIs('user.course_management.course.certificate_settings')) active
                            @elseif (request()->routeIs('user.course_management.course.modules')) active
                            @elseif (request()->routeIs('user.course_management.lesson.contents')) active
                            @elseif (request()->routeIs('user.course_management.lesson.create_quiz')) active
                            @elseif (request()->routeIs('user.course_management.lesson.manage_quiz')) active
                            @elseif (request()->routeIs('user.course_management.lesson.edit_quiz')) active @endif"
                            >
                            <a href="{{ route('user.course_management.courses', ['language' => $default->code]) }}">
                                <span class="sub-item">{{ __('Courses') }}</span>
                            </a>
                        </li>
                        @if(!empty($permissions) && in_array('Coupon',$permissions))
                        <li class="{{ request()->routeIs('user.course_management.coupons') ? 'active' : '' }}">
                            <a href="{{ route('user.course_management.coupons') }}">
                                <span class="sub-item">{{ __('Coupons') }}</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            {{-- End Course Management --}}

            {{-- course enrolments --}}
            <li class="nav-item
                @if (request()->routeIs('user.course_enrolments')) active
                @elseif (request()->routeIs('user.course_enrolment.details')) active
                @elseif (request()->routeIs('user.course_enrolments.report')) active @endif"
                >
                <a data-toggle="collapse" href="#enrolment">
                    <i class="far fa-users-class"></i>
                    <p>{{ __('Course Enrolments') }}</p>
                    <span class="caret"></span>
                </a>
                <div id="enrolment" class="collapse
                    @if (request()->routeIs('user.course_enrolments')) show
                    @elseif (request()->routeIs('user.course_enrolment.details')) show
                    @elseif (request()->routeIs('user.course_enrolments.report')) show @endif"
                    >
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('user.course_enrolments') && empty(request()->input('status')) ? 'active' : '' }}">
                            <a href="{{ route('user.course_enrolments') }}">
                            <span class="sub-item">{{ __('All Enrolments') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.course_enrolments') && request()->input('status') == 'completed' ? 'active' : '' }}">
                            <a href="{{ route('user.course_enrolments', ['status' => 'completed']) }}">
                            <span class="sub-item">{{ __('Completed Enrolments') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.course_enrolments') && request()->input('status') == 'pending' ? 'active' : '' }}">
                            <a href="{{ route('user.course_enrolments', ['status' => 'pending']) }}">
                            <span class="sub-item">{{ __('Pending Enrolments') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.course_enrolments') && request()->input('status') == 'rejected' ? 'active' : '' }}">
                            <a href="{{ route('user.course_enrolments', ['status' => 'rejected']) }}">
                            <span class="sub-item">{{ __('Rejected Enrolments') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.course_enrolments.report') ? 'active' : '' }}">
                            <a href="{{ route('user.course_enrolments.report') }}">
                            <span class="sub-item">{{ __('Report') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{--Registered Users--}}
            <li class="nav-item
            @if(request()->path() == "user/registered-users") active
            @elseif(request()->routeIs('user.user_details')) active
            @elseif(request()->routeIs('user.user.change_password')) active
            @endif">
                <a href="{{route('user.registered_users')}}">
                    <i class="fas fa-poll-people"></i>
                    <p>{{__('Registered Users')}}</p>
                </a>
            </li>

            {{-- home page --}}
            <li class="nav-item @if (request()->routeIs('user.home_page.hero_section')) active
                @elseif (request()->routeIs('user.home_page.section_titles')) active
                @elseif (request()->routeIs('user.home_page.action_section')) active
                @elseif (request()->routeIs('user.home_page.features_section')) active
                @elseif (request()->routeIs('user.home_page.video_section')) active
                @elseif (request()->routeIs('user.home_page.fun_facts_section')) active
                @elseif (request()->routeIs('user.home_page.testimonials_section')) active
                @elseif (request()->routeIs('user.home_page.newsletter_section')) active
                @elseif (request()->routeIs('user.home_page.about_us_section')) active
                @elseif (request()->routeIs('user.home_page.course_categories_section')) active
                @elseif (request()->routeIs('user.home_page.section_customization')) active @endif"
                >
                <a data-toggle="collapse" href="#home_page">
                    <i class="fas fa-layer-group"></i>
                    <p>{{ __('Home Page') }}</p>
                    <span class="caret"></span>
                </a>
                <div id="home_page" class="collapse
                    @if (request()->routeIs('user.home_page.hero_section')) show
                    @elseif (request()->routeIs('user.home_page.section_titles')) show
                    @elseif (request()->routeIs('user.home_page.action_section')) show
                    @elseif (request()->routeIs('user.home_page.features_section')) show
                    @elseif (request()->routeIs('user.home_page.video_section')) show
                    @elseif (request()->routeIs('user.home_page.fun_facts_section')) show
                    @elseif (request()->routeIs('user.home_page.testimonials_section')) show
                    @elseif (request()->routeIs('user.home_page.newsletter_section')) show
                    @elseif (request()->routeIs('user.home_page.about_us_section')) show
                    @elseif (request()->routeIs('user.home_page.course_categories_section')) show
                    @elseif (request()->routeIs('user.home_page.section_customization')) show @endif"
                    >
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('user.home_page.hero_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.hero_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Hero Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.section_titles') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.section_titles', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Section Titles') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.action_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.action_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Call To Action Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.features_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.features_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Features Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.video_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.video_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Video Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.fun_facts_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.fun_facts_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Fun Facts Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.testimonials_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.testimonials_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Testimonials Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.newsletter_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.newsletter_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Newsletter Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.about_us_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.about_us_section', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('About Us Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.course_categories_section') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.course_categories_section') }}">
                            <span class="sub-item">{{ __('Course Categories Section') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.home_page.section_customization') ? 'active' : '' }}">
                            <a href="{{ route('user.home_page.section_customization') }}">
                            <span class="sub-item">{{ __('Section Customization') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- footer --}}
            <li class="nav-item
                @if (request()->routeIs('user.footer.content')) active
                @elseif (request()->routeIs('user.footer.quick_links')) active
                @endif">
                <a data-toggle="collapse" href="#footer">
                    <i class="far fa-shoe-prints"></i>
                    <p>{{ __('Footer') }}</p>
                    <span class="caret"></span>
                </a>
                <div id="footer" class="collapse
                    @if (request()->routeIs('user.footer.content')) show
                    @elseif (request()->routeIs('user.footer.quick_links')) show
                    @endif"
                    >
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('user.footer.content') ? 'active' : '' }}">
                            <a href="{{ route('user.footer.content') . '?language=' . $default->code }}">
                            <span class="sub-item">{{ __('Footer Content') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.footer.quick_links') ? 'active' : '' }}">
                            <a href="{{ route('user.footer.quick_links') . '?language=' . $default->code }}">
                            <span class="sub-item">{{__('Quick Links')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- Custom Page --}}
            @if (!empty($permissions) && in_array('Custom Page', $permissions))
            <li class="nav-item @if (request()->routeIs('user.custom_pages')) active
                @elseif (request()->routeIs('user.custom_pages.create_page')) active
                @elseif (request()->routeIs('user.custom_pages.edit_page')) active @endif"
                >
                <a href="{{ route('user.custom_pages', ['language' => $default->code]) }}">
                    <i class="la flaticon-file"></i>
                    <p>{{ __('Custom Pages') }}</p>
                </a>
            </li>
            @endif

            {{-- blog --}}
            @if (!empty($permissions) && in_array('Blog', $permissions))
            <li class="nav-item @if (request()->routeIs('user.blog_management.categories')) active
                @elseif (request()->routeIs('user.blog_management.blogs')) active
                @elseif (request()->routeIs('user.blog_management.create_blog')) active
                @elseif (request()->routeIs('user.blog_management.edit_blog')) active @endif"
                >
                <a data-toggle="collapse" href="#blog">
                    <i class="fas fa-blog"></i>
                    <p>{{ __('Blog Management') }}</p>
                    <span class="caret"></span>
                </a>
                <div id="blog" class="collapse
                    @if (request()->routeIs('user.blog_management.categories')) show
                    @elseif (request()->routeIs('user.blog_management.blogs')) show
                    @elseif (request()->routeIs('user.blog_management.create_blog')) show
                    @elseif (request()->routeIs('user.blog_management.edit_blog')) show @endif"
                    >
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('user.blog_management.categories') ? 'active' : '' }}">
                            <a href="{{ route('user.blog_management.categories', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Categories') }}</span>
                            </a>
                        </li>
                        <li class="@if (request()->routeIs('user.blog_management.blogs')) active
                            @elseif (request()->routeIs('user.blog_management.create_blog')) active
                            @elseif (request()->routeIs('user.blog_management.edit_blog')) active @endif"
                            >
                            <a href="{{ route('user.blog_management.blogs', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Blog') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(!is_null($package))
            {{-- faq --}}
            <li class="nav-item {{ request()->routeIs('user.faq_management') ? 'active' : '' }}">
                <a href="{{ route('user.faq_management', ['language' => $default->code]) }}">
                    <i class="la flaticon-round"></i>
                    <p>{{ __('FAQ Management') }}</p>
                </a>
            </li>
            @endif

            {{-- QR Builder --}}
            @if (!empty($permissions) && in_array('QR Builder', $permissions))
            <li class="nav-item
                @if(request()->routeIs('user.qrcode')) active
                @elseif(request()->routeIs('user.qrcode.index')) active
                @endif">
                <a data-toggle="collapse" href="#qrcode">
                    <i class="fas fa-qrcode"></i>
                    <p>{{__('QR Codes')}}</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                    @if(request()->routeIs('user.qrcode')) show
                    @elseif(request()->routeIs('user.qrcode.index')) show
                    @endif" id="qrcode">
                    <ul class="nav nav-collapse">
                        <li class="@if(request()->routeIs('user.qrcode')) active
                            @endif">
                            <a href="{{route('user.qrcode')}}">
                            <span class="sub-item">{{__('Generate QR Code')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->routeIs('user.qrcode.index')) active @endif">
                            <a href="{{route('user.qrcode.index')}}">
                            <span class="sub-item">{{__('Saved QR Codes')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif


            @if (!empty($permissions) && in_array('vCard', $permissions))
            <li class="nav-item
                @if(request()->path() == 'user/vcard') active
                @elseif(request()->path() == 'user/vcard/create') active
                @elseif(request()->is('user/vcard/*/edit')) active
                @elseif(request()->routeIs('user.vcard.services')) active
                @elseif(request()->routeIs('user.vcard.projects')) active
                @elseif(request()->routeIs('user.vcard.testimonials')) active
                @elseif(request()->routeIs('user.vcard.about')) active
                @elseif(request()->routeIs('user.vcard.preferences')) active
                @elseif(request()->routeIs('user.vcard.color')) active
                @elseif(request()->routeIs('user.vcard.keywords')) active
                @endif">
                <a data-toggle="collapse" href="#vcard">
                    <i class="far fa-address-card"></i>
                    <p>{{__('vCards Management')}}</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                    @if(request()->path() == 'user/vcard') show
                    @elseif(request()->path() == 'user/vcard/create') show
                    @elseif(request()->is('user/vcard/*/edit')) show
                    @elseif(request()->routeIs('user.vcard.services')) show
                    @elseif(request()->routeIs('user.vcard.projects')) show
                    @elseif(request()->routeIs('user.vcard.testimonials')) show
                    @elseif(request()->routeIs('user.vcard.about')) show
                    @elseif(request()->routeIs('user.vcard.preferences')) show
                    @elseif(request()->routeIs('user.vcard.color')) show
                    @elseif(request()->routeIs('user.vcard.keywords')) show
                    @endif" id="vcard">
                    <ul class="nav nav-collapse">
                        <li class="@if(request()->path() == 'user/vcard') active
                            @elseif(request()->is('user/vcard/*/edit')) active
                            @elseif(request()->routeIs('user.vcard.services')) active
                            @elseif(request()->routeIs('user.vcard.projects')) active
                            @elseif(request()->routeIs('user.vcard.testimonials')) active
                            @elseif(request()->routeIs('user.vcard.about')) active
                            @elseif(request()->routeIs('user.vcard.preferences')) active
                            @elseif(request()->routeIs('user.vcard.color')) active
                            @elseif(request()->routeIs('user.vcard.keywords')) active
                            @endif">
                            <a href="{{route('user.vcard')}}">
                            <span class="sub-item">{{__('vCards')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/vcard/create') active @endif">
                            <a href="{{route('user.vcard.create')}}">
                            <span class="sub-item">{{__('Add vCard')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (!empty($permissions) && in_array('Follow/Unfollow', $permissions))
                <li class="nav-item
                    @if(request()->path() == 'user/follower-list') active
                    @elseif(request()->path() == 'user/following-list') active
                    @endif">
                    <a data-toggle="collapse" href="#follow">
                        <i class="fas fa-user-friends"></i>
                        <p>{{__('Follower/Following')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse
                        @if(request()->path() == 'user/follower-list') show
                        @elseif(request()->path() == 'user/following-list') show
                        @endif" id="follow">
                        <ul class="nav nav-collapse">
                            <li class="@if(request()->path() == 'user/follower-list') active @endif">
                                <a href="{{route('user.follower.list')}}">
                                <span class="sub-item">{{__('Follower')}}</span>
                                </a>
                            </li>
                            <li class="
                                @if(request()->path() == 'user/following-list') active
                                @elseif(request()->is('user/following-list')) active
                                @endif">
                                <a href="{{route('user.following.list')}}">
                                <span class="sub-item">{{__('Following')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if(!is_null($package))
            {{-- Subscribers --}}
            <li class="nav-item
                @if(request()->path() == 'user/subscribers') active
                @elseif(request()->path() == 'user/mailsubscriber') active
                @endif">
                <a data-toggle="collapse" href="#subscribers">
                    <i class="la flaticon-envelope"></i>
                    <p>{{__('Subscribers')}}</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                    @if(request()->path() == 'user/subscribers') show
                    @elseif(request()->path() == 'user/mailsubscriber') show
                    @endif" id="subscribers">
                    <ul class="nav nav-collapse">
                        <li class="@if(request()->path() == 'user/subscribers') active @endif">
                            <a href="{{route('user.subscriber.index')}}">
                            <span class="sub-item">{{__('Subscribers')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/mailsubscriber') active @endif">
                            <a href="{{route('user.mailsubscriber')}}">
                            <span class="sub-item">{{__('Mail to Subscribers')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </li>
            @endif

            {{-- advertise --}}
            @if (!empty($permissions) && in_array('Advertisement', $permissions))
            <li class="nav-item
                @if (request()->routeIs('user.advertise.settings')) active
                @elseif (request()->routeIs('user.advertisements')) active
                @endif">
                <a data-toggle="collapse" href="#ad">
                    <i class="fab fa-buysellads"></i>
                    <p>{{ __('Advertisements') }}</p>
                    <span class="caret"></span>
                </a>
                <div id="ad" class="collapse
                    @if (request()->routeIs('user.advertise.settings')) show
                    @elseif (request()->routeIs('user.advertisements')) show @endif"
                    >
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('user.advertise.settings') ? 'active' : '' }}">
                            <a href="{{ route('user.advertise.settings') }}">
                            <span class="sub-item">{{ __('Settings') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.advertisements') ? 'active' : '' }}">
                            <a href="{{ route('user.advertisements') }}">
                            <span class="sub-item">{{ __('Advertisements') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(!is_null($package))
            {{-- announcement popup --}}
            <li class="nav-item @if (request()->routeIs('user.announcement_popups')) active
                @elseif (request()->routeIs('user.announcement_popups.select_popup_type')) active
                @elseif (request()->routeIs('user.announcement_popups.create_popup')) active
                @elseif (request()->routeIs('user.announcement_popups.edit_popup')) active @endif"
                >
                <a href="{{ route('user.announcement_popups', ['language' => $default->code]) }}">
                    <i class="fas fa-bullhorn"></i>
                    <p>{{ __('Announcement Popups') }}</p>
                </a>
            </li>
            @endif

            @if(!is_null($package))
            {{-- Payment Gateways --}}
            <li class="nav-item
                @if(request()->path() == 'user/gateways') active
                @elseif(request()->path() == 'user/offline/gateways') active
                @endif">
                <a data-toggle="collapse" href="#gateways">
                    <i class="la flaticon-paypal"></i>
                    <p>{{__('Payment Gateways')}}</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                    @if(request()->path() == 'user/gateways') show
                    @elseif(request()->path() == 'user/offline/gateways') show
                    @endif" id="gateways">
                    <ul class="nav nav-collapse">
                        <li class="@if(request()->path() == 'user/gateways') active @endif">
                            <a href="{{route('user.gateway.index')}}">
                            <span class="sub-item">{{__('Online Gateways')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/offline/gateways') active @endif">
                            <a href="{{route('user.gateway.offline') . '?language=' . $default->code}}">
                            <span class="sub-item">{{__('Offline Gateways')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item
                @if(request()->path() == 'user/favicon') active
                @elseif(request()->path() == 'user/theme/version') active
                @elseif(request()->path() == 'user/logo') active
                @elseif(request()->path() == 'user/footer-logo') active
                @elseif(request()->path() == 'user/currency') active
                @elseif(request()->path() == 'user/appearance') active
                @elseif(request()->path() == 'user/social') active
                @elseif(request()->is('user/social/*')) active
                @elseif(request()->path() == 'user/basic_settings/seo') active
                @elseif(request()->is('user/breadcrumb')) active
                @elseif(request()->is('user/information')) active
                @elseif(request()->is('user/page-headings')) active
                @elseif(request()->is('user/plugins')) active
                @elseif(request()->is('user/maintenance-mode')) active
                @elseif(request()->is('user/cookie-alert')) active
                @elseif (request()->routeIs('user.mail_templates')) active
                @elseif (request()->routeIs('user.edit_mail_template')) active
                @elseif (request()->routeIs('user.mail.info')) active
                @endif">
                <a data-toggle="collapse" href="#basic">
                    <i class="la flaticon-settings"></i>
                    <p>{{__('Basic Settings')}}</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse
                    @if(request()->path() == 'user/favicon') show
                    @elseif(request()->path() == 'user/theme/version') show
                    @elseif(request()->path() == 'user/logo') show
                    @elseif(request()->path() == 'user/footer-logo') show
                    @elseif(request()->path() == 'user/currency') show
                    @elseif(request()->path() == 'user/appearance') show
                    @elseif(request()->path() == 'user/social') show
                    @elseif(request()->is('user/social/*')) show
                    @elseif(request()->path() == 'user/basic_settings/seo') show
                    @elseif(request()->is('user/breadcrumb')) show
                    @elseif(request()->is('user/information')) show
                    @elseif(request()->is('user/page-headings')) show
                    @elseif(request()->is('user/plugins')) show
                    @elseif(request()->is('user/maintenance-mode')) show
                    @elseif(request()->is('user/cookie-alert')) show
                    @elseif (request()->routeIs('user.mail_templates')) show
                    @elseif (request()->routeIs('user.edit_mail_template')) show
                    @elseif (request()->routeIs('user.mail.info')) show
                    @endif" id="basic">
                    <ul class="nav nav-collapse">
                        <li class="@if(request()->path() == 'user/favicon') active @endif">
                            <a href="{{route('user.favicon')}}">
                            <span class="sub-item">{{__('Favicon')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/logo') active @endif">
                            <a href="{{route('user.logo')}}">
                            <span class="sub-item">{{__('Logo')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/information') active @endif">
                            <a href="{{route('user.basic_settings.information')}}">
                            <span class="sub-item">{{__('Information')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/theme/version') active @endif">
                            <a href="{{route('user.theme.version')}}">
                            <span class="sub-item">{{__('Theme & Home')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/currency') active @endif">
                            <a href="{{route('user.currency')}}">
                            <span class="sub-item">{{__('Currency')}}</span>
                            </a>
                        </li>
                        <li class="submenu
                            @if (request()->routeIs('user.mail_templates')) selected
                            @elseif (request()->routeIs('user.edit_mail_template')) selected
                            @elseif (request()->routeIs('user.mail.info')) selected
                            @endif">
                            <a data-toggle="collapse" href="#mail_settings">
                                <span class="sub-item">{{ __('Email Settings') }}</span>
                                <span class="caret"></span>
                            </a>
                            <div id="mail_settings" class="collapse
                                @if (request()->routeIs('user.mail_templates')) show
                                @elseif (request()->routeIs('user.mail.info')) show
                                @elseif (request()->routeIs('user.edit_mail_template')) show @endif"
                                >
                                <ul class="nav nav-collapse subnav">
                                    <li class="@if (request()->routeIs('user.mail.info')) active @endif">
                                        <a href="{{route('user.mail.info')}}">
                                        <span class="sub-item">{{__('Mail Information')}}</span>
                                        </a>
                                    </li>
                                    <li class="@if (request()->routeIs('user.mail_templates')) active
                                        @elseif (request()->routeIs('user.edit_mail_template')) active @endif"
                                        >
                                        <a href="{{ route('user.mail_templates') }}">
                                        <span class="sub-item">{{ __('Mail Templates') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="@if(request()->path() == 'user/appearance') active @endif">
                            <a href="{{route('user.appearance')}}">
                            <span class="sub-item">{{__('Website Appearance')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/breadcrumb') active @endif">
                            <a href="{{route('user.breadcrumb')}}">
                            <span class="sub-item">{{__('Breadcrumb')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.page_headings') ? 'active' : '' }}">
                            <a href="{{ route('user.page_headings', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Page Headings') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.plugins') ? 'active' : '' }}">
                            <a href="{{ route('user.plugins') }}">
                            <span class="sub-item">{{ __('Plugins') }}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/basic_settings/seo') active @endif">
                            <a href="{{route('user.basic_settings.seo', ['language' => $default->code])}}">
                            <span class="sub-item">{{__('SEO Information')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.maintenance_mode') ? 'active' : '' }}">
                            <a href="{{ route('user.maintenance_mode') }}">
                            <span class="sub-item">{{ __('Maintenance Mode') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.cookie_alert') ? 'active' : '' }}">
                            <a href="{{ route('user.cookie_alert', ['language' => $default->code]) }}">
                            <span class="sub-item">{{ __('Cookie Alert') }}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/footer-logo') active @endif">
                            <a href="{{route('user.footer.logo')}}">
                            <span class="sub-item">{{__('Footer Logo')}}</span>
                            </a>
                        </li>
                        <li class="@if(request()->path() == 'user/social') active
                            @elseif(request()->is('user/social/*')) active @endif">
                            <a href="{{route('user.social.index')}}">
                            <span class="sub-item">{{__('Social Medias')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

        @if(!is_null($package))
        <li class="nav-item
            @if(request()->path() == "user/domains") active
            @elseif(request()->path() == 'user/subdomain') active
            @endif">
            <a data-toggle="collapse" href="#domains">
                <i class="fas fa-link"></i>
                <p>{{__('Domains & URLs')}}</p>
                <span class="caret"></span>
            </a>
            <div class="collapse
                @if(request()->path() == "user/domains") show
                @elseif(request()->path() == 'user/subdomain') show
                @endif" id="domains">
                <ul class="nav nav-collapse">
                    @if (!empty($permissions) && in_array('Custom Domain', $permissions))
                    <li class="
                        @if(request()->path() == 'user/domains') active
                        @endif">
                        <a href="{{route('user-domains')}}">
                        <span class="sub-item">{{__('Custom Domain')}}</span>
                        </a>
                    </li>
                    @endif
                    @if (!empty($permissions) && in_array('Subdomain', $permissions))
                    <li class="
                        @if(request()->path() == 'user/subdomain') active
                        @endif">
                        <a href="{{route('user-subdomain')}}">
                        <span class="sub-item">{{__('Subdomain & Path URL')}}</span>
                        </a>
                    </li>
                    @else
                    <li class="
                        @if(request()->path() == 'user/subdomain') active
                        @endif">
                        <a href="{{route('user-subdomain')}}">
                        <span class="sub-item">{{__('Path Based URL')}}</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>

        {{-- Language Management Page --}}
        <li class="nav-item
            @if(request()->path() == 'user/languages') active
            @elseif(request()->is('user/language/*/edit')) active
            @elseif(request()->is('user/language/*/edit/keyword')) active
            @endif">
            <a href="{{route('user.language.index')}}">
                <i class="fas fa-language"></i>
                <p>{{__('Language Management')}}</p>
            </a>
        </li>
        @endif

    <li class="nav-item
        @if(request()->path() == 'user/package-list') active
        @elseif(request()->is('user/package/checkout/*')) active
        @endif">
        <a href="{{route('user.plan.extend.index')}}">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>{{__('Buy Plan')}}</p>
        </a>
    </li>

    <li class="nav-item
        @if(request()->path() == 'user/payment-log') active
        @endif">
        <a href="{{route('user.payment-log.index')}}">
            <i class="fas fa-list-ol"></i>
            <p>{{__('Payment Logs')}}</p>
        </a>
    </li>

        @if(!is_null($package))
            <li class="nav-item
            @if(request()->path() == "user/profile") active
            @endif">
                <a href="{{route('user-profile')}}">
                    <i class="far fa-user-circle"></i>
                    <p>{{__('Edit Profile')}}</p>
                </a>
            </li>

            <li class="nav-item @if(request()->path() == 'user/change-password') active @endif">
                <a href="{{route('user.changePass')}}">
                    <i class="fas fa-key"></i>
                    <p>{{__('Change Password')}}</p>
                </a>
            </li>
        @endif
    </ul>
</div>
</div>
</div>
