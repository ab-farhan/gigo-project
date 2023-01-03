<?php

namespace App\Http\Controllers\Front;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\BasicExtended;
use App\Models\BasicExtended as BE;
use App\Models\BasicSetting as BS;
use App\Models\Bcategory;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Language;
use App\Models\OfflineGateway;
use App\Models\Package;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PaymentGateway;
use App\Models\Process;
use App\Models\Seo;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\User\BasicSetting;
use App\Models\User\Curriculum\Course;
use App\Models\User\Curriculum\CourseCategory;
use App\Models\User\Curriculum\CourseEnrolment;
use App\Models\User\HomePage\AboutUsSection;
use App\Models\User\HomePage\HeroSection;
use App\Models\User\HomePage\NewsletterSection;
use App\Models\User\HomePage\Section;
use App\Models\User\HomePage\SectionTitle;
use App\Models\User\Journal\Blog as UserBlog;
use App\Models\User\Journal\BlogInformation;
use App\Models\User\Language as UserLanguage;
use App\Models\User\Teacher\Instructor;
use App\Models\User\UserCustomDomain;
use App\Models\User\UserVcard;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use JeroenDesloovere\VCard\VCard;

class FrontendController extends Controller
{
    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);
        Config::set('mail.host', $be->smtp_host);
        Config::set('mail.port', $be->smtp_port);
        Config::set('mail.username', $be->smtp_username);
        Config::set('mail.password', $be->smtp_password);
        Config::set('mail.encryption', $be->encryption);
    }

    public function index()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $lang_id = $currentLang->id;
        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $data['processes'] = Process::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['features'] = Feature::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['featured_users'] = User::where([
            ['featured', 1],
            ['status', 1]
        ])
            ->whereHas('memberships', function ($q) {
                $q->where('status', '=', 1)
                    ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
                    ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'));
            })->get();
        $data['testimonials'] = Testimonial::where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $data['blogs'] = Blog::where('language_id', $lang_id)->orderBy('id', 'DESC')->take(3)->get();

        $data['packages'] = Package::query()->where('status', '1')->where('featured', '1')->get();
        $data['partners'] = Partner::where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['templates'] = User::where([
            ['preview_template', 1],
            ['status', 1],
            ['online_status', 1]
        ])
            ->whereHas('memberships', function ($q) {
                $q->where('status', '=', 1)
                    ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
                    ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'));
            })->orderBy('template_serial_number', 'ASC')->get();

        $data['seo'] = Seo::where('language_id', $lang_id)->first();

        $terms = [];
        if (Package::query()->where('status', '1')->where('featured', '1')->where('term', 'monthly')->count() > 0) {
            $terms[] = 'Monthly';
        }
        if (Package::query()->where('status', '1')->where('featured', '1')->where('term', 'yearly')->count() > 0) {
            $terms[] = 'Yearly';
        }
        if (Package::query()->where('status', '1')->where('featured', '1')->where('term', 'lifetime')->count() > 0) {
            $terms[] = 'Lifetime';
        }
        $data['terms'] = $terms;

        $be = BasicExtended::select('package_features')->firstOrFail();
        $allPfeatures = $be->package_features ? $be->package_features : "[]";
        $data['allPfeatures'] = json_decode($allPfeatures, true);
        return view('front.index', $data);
    }

    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:subscribers'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->save();

        return "success";
    }

    public function loginView()
    {
        return view('front.login');
    }

    public function checkUsername($username)
    {
        $count = User::where('username', $username)->count();
        $status = $count > 0;
        return response()->json($status);
    }

    public function step1($status, $id)
    {
        Session::forget('coupon');
        Session::forget('coupon_amount');

        if (Auth::check()) {
            return redirect()->route('user.plan.extend.index');
        }

        $data['status'] = $status;
        $data['id'] = $id;
        $package = Package::findOrFail($id);
        $data['package'] = $package;

        $hasSubdomain = false;
        $features = [];
        if (!empty($package->features)) {
            $features = json_decode($package->features, true);
        }
        if (is_array($features) && in_array('Subdomain', $features)) {
            $hasSubdomain = true;
        }

        $data['hasSubdomain'] = $hasSubdomain;

        return view('front.step', $data);
    }

    public function step2(Request $request)
    {


        $data = $request->session()->get('data');
        $data = $request->session()->get('data');
        if (session()->has('coupon_amount')) {
            $data['cAmount'] = session()->get('coupon_amount');
        } else {
            $data['cAmount'] = 0;
        }
        return view('front.checkout', $data);
    }

    public function checkout(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|alpha_num|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $seo = Seo::where('language_id', $currentLang->id)->first();
        $be = $currentLang->basic_extended;
        $data['bex'] = $be;
        $data['username'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        $data['status'] = $request->status;
        $data['id'] = $request->id;
        $online = PaymentGateway::query()->where('status', 1)->get();
        $offline = OfflineGateway::where('status', 1)->get();
        $data['offline'] = $offline;
        $data['payment_methods'] = $online->merge($offline);
        $data['package'] = Package::query()->findOrFail($request->id);
        $data['seo'] = $seo;
        $request->session()->put('data', $data);
        return redirect()->route('front.registration.step2');
    }


    // packages start
    public function pricing(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['seo'] = Seo::where('language_id', $currentLang->id)->first();

        $data['bex'] = BE::first();
        $data['abs'] = BS::first();

        $terms = [];
        if (Package::query()->where('status', '1')->where('term', 'monthly')->count() > 0) {
            $terms[] = 'Monthly';
        }
        if (Package::query()->where('status', '1')->where('term', 'yearly')->count() > 0) {
            $terms[] = 'Yearly';
        }
        if (Package::query()->where('status', '1')->where('term', 'lifetime')->count() > 0) {
            $terms[] = 'Lifetime';
        }
        $data['terms'] = $terms;

        $be = BasicExtended::select('package_features')->firstOrFail();
        $allPfeatures = $be->package_features ?? "[]";
        $data['allPfeatures'] = json_decode($allPfeatures, true);

        return view('front.pricing', $data);
    }

    // blog section start
    public function blogs(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['seo'] = Seo::where('language_id', $currentLang->id)->first();

        $data['currentLang'] = $currentLang;

        $lang_id = $currentLang->id;

        $category = $request->category;
        if (!empty($category)) {
            $data['category'] = Bcategory::findOrFail($category);
        }
        $term = $request->term;

        $data['bcats'] = Bcategory::where('language_id', $lang_id)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['blogs'] = Blog::when($category, function ($query, $category) {
            return $query->where('bcategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')
            ->paginate(6);
        return view('front.blogs', $data);
    }

    public function blogdetails($slug, $id)
    {


        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['blog'] = Blog::findOrFail($id);
        $data['bcats'] = Bcategory::where('status', 1)
            ->where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();


        $data['allBlogs'] = Blog::with('information')->where('language_id', $lang_id)->orderBy('id', 'DESC')->limit(5)->get();

        return view('front.blog-details', $data);
    }

    public function contactView()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['seo'] = Seo::where('language_id', $currentLang->id)->first();
        return view('front.contact', $data);
    }

    public function faqs()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['seo'] = Seo::where('language_id', $currentLang->id)->first();

        $lang_id = $currentLang->id;
        $data['faqs'] = Faq::where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        return view('front.faq', $data);
    }

    public function dynamicPage($slug)
    {
        $data['page'] = Page::where('slug', $slug)->firstOrFail();
        return view('front.dynamic', $data);
    }

    public function users(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['seo'] = Seo::where('language_id', $currentLang->id)->first();

        $userIds = [];
        $users = User::where('online_status', 1)
            ->whereHas('memberships', function ($q) {
                $q->where('status', '=', 1)
                    ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
                    ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'));
            })
            ->when($request->company, function ($q) use ($request) {
                return $q->where('company_name', 'like', '%' . $request->company . '%');
            })
            ->when($request->location, function ($q) use ($request) {
                return $q->where(function ($query) use ($request) {
                    $query->where('city', 'like', '%' . $request->location . '%')
                        ->orWhere('state', 'like', '%' . $request->location . '%')
                        ->orWhere('address', 'like', '%' . $request->location . '%')
                        ->orWhere('country', 'like', '%' . $request->location . '%');
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(9);

        $data['users'] = $users;
        return view('front.users', $data);
    }


    public function userDetailView($domain)
    {

        $user = getUser();
        $data['user'] = $user;

        if (Auth::check() && Auth::user()->id != $user->id && $user->online_status != 1) {
            return redirect()->route('front.index');
        } elseif (!Auth::check() && $user->online_status != 1) {
            return redirect()->route('front.index');
        }

        $package = UserPermissionHelper::userPackage($user->id);
        if (is_null($package)) {
            Session::flash('warning', 'User membership is expired');
            if (Auth::check()) {
                return redirect()->route('user-dashboard')->with('error', 'User membership is expired');
            } else {
                return redirect()->route('front.user.view');
            }
        }

        if (session()->has('user_lang')) {
            $userCurrentLang = UserLanguage::query()
                ->where('code', session()->get('user_lang'))
                ->where('user_id', $user->id)
                ->first();

            if (empty($userCurrentLang)) {
                $userCurrentLang = UserLanguage::query()
                    ->where('is_default', 1)
                    ->where('user_id', $user->id)
                    ->first();
                session()->put('user_lang', $userCurrentLang->code);
            }
        } else {
            $userCurrentLang = UserLanguage::query()
                ->where('is_default', 1)
                ->where('user_id', $user->id)
                ->first();
        }
        $userBs = BasicSetting::query()->where('user_id', $user->id)->first();

        $themeInfo = $userBs;

        $language = $userCurrentLang;

        $queryResult['seoInfo'] = User\SEO::query()->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->select('home_meta_keywords', 'home_meta_description')
            ->first();

        // get the sections of selected home version
        $sectionInfo = Section::query()
            ->where('user_id', $user->id)
            ->first();
        $queryResult['secInfo'] = $sectionInfo;
        $queryResult['heroInfo'] = HeroSection::query()
            ->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->first();
        $queryResult['secTitleInfo'] = SectionTitle::query()
            ->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->first();

        if ($sectionInfo->course_categories_section_status == 1) {
            $queryResult['courseCategoryData'] = $userBs;
        }

        $categories = CourseCategory::query()->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->when($themeInfo->theme_version == 3, function ($query) {
                return $query->where('is_featured', '=', 1);
            })
            ->get();

        if ($themeInfo->theme_version == 3) {
            $categories->map(function ($category) use ($language, $user) {
                $category['courses'] = Course::query()
                    ->join('user_course_informations', 'user_courses.id', '=', 'user_course_informations.course_id')
                    ->join('user_instructors', 'user_instructors.id', '=', 'user_course_informations.instructor_id')
                    ->where('user_courses.status', '=', 'published')
                    ->where('user_courses.user_id', '=', $user->id)
                    ->where('user_courses.is_featured', '=', 'yes')
                    ->where('user_course_informations.language_id', '=', $language->id)
                    ->where('user_course_informations.course_category_id', '=', $category->id)
                    ->select('user_courses.id', 'user_courses.thumbnail_image', 'user_courses.pricing_type', 'user_courses.previous_price', 'user_courses.current_price', 'user_courses.average_rating', 'user_course_informations.title', 'user_course_informations.slug', 'user_course_informations.description', 'user_instructors.name as instructorName')
                    ->orderByDesc('user_courses.id')
                    ->get();
            });
        }

        $queryResult['categories'] = $categories;

        if ($sectionInfo->call_to_action_section_status == 1) {
            $queryResult['callToActionInfo'] = User\HomePage\ActionSection::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->first();
        }

        if ($sectionInfo->featured_courses_section_status == 1 && $themeInfo->theme_version != 3) {
            $courses = Course::query()
                ->join('user_course_informations', 'user_courses.id', '=', 'user_course_informations.course_id')
                ->join('user_course_categories', 'user_course_categories.id', '=', 'user_course_informations.course_category_id')
                ->join('user_instructors', 'user_instructors.id', '=', 'user_course_informations.instructor_id')
                ->where('user_courses.status', '=', 'published')
                ->where('user_courses.user_id', '=', $user->id)
                ->where('user_courses.is_featured', '=', 'yes')
                ->where('user_course_informations.language_id', '=', $language->id)
                ->select('user_courses.id', 'user_courses.thumbnail_image', 'user_courses.pricing_type', 'user_courses.previous_price', 'user_courses.current_price', 'user_courses.average_rating', 'user_courses.duration', 'user_course_informations.title', 'user_course_informations.slug', 'user_course_categories.name as categoryName', 'user_instructors.image as instructorImage', 'user_instructors.name as instructorName')
                ->orderByDesc('user_courses.id')
                ->get();

            $courses->map(function ($course) use ($user) {
                $course['enrolmentCount'] = CourseEnrolment::query()
                    ->where('user_id', $user->id)
                    ->where('course_id', '=', $course->id)
                    ->where(function ($query) {
                        $query->where('payment_status', 'completed')
                            ->orWhere('payment_status', 'free');
                    })
                    ->count();
            });

            $queryResult['courses'] = $courses;
        }

        $queryResult['currencyInfo'] = BasicSetting::query()
            ->where('user_id', $user->id)
            ->select('base_currency_symbol', 'base_currency_symbol_position', 'base_currency_text', 'base_currency_text_position', 'base_currency_rate')
            ->first();

        if ($sectionInfo->features_section_status == 1) {
            $queryResult['featureData'] = $userBs;
            $queryResult['features'] = User\HomePage\Feature::query()->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->orderBy('serial_number', 'ASC')
                ->get();
        }

        if ($sectionInfo->video_section_status == 1) {
            $queryResult['videoData'] = User\HomePage\VideoSection::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->first();
        }

        if ($sectionInfo->fun_facts_section_status == 1) {
            $queryResult['factData'] = User\HomePage\Fact\FunFactSection::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->first();

            $queryResult['countInfos'] = User\HomePage\Fact\CountInformation::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->orderBy('serial_number', 'ASC')
                ->get();
        }

        if ($sectionInfo->testimonials_section_status == 1) {
            $queryResult['testimonialData'] = $userBs;
            $queryResult['testimonials'] = User\HomePage\Testimonial::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->orderBy('serial_number', 'ASC')
                ->get();
        }

        if ($sectionInfo->newsletter_section_status == 1) {
            $queryResult['newsletterData'] = NewsletterSection::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->first();
        }

        if ($sectionInfo->featured_instructors_section_status == 1) {
            $queryResult['instructors'] = Instructor::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->where('is_featured', '=', 1)
                ->get();
        }

        if ($sectionInfo->about_us_section_status == 1) {
            $queryResult['aboutUsInfo'] = AboutUsSection::query()
                ->where('user_id', $user->id)
                ->where('language_id', $language->id)
                ->first();
        }

        if ($sectionInfo->latest_blog_section_status == 1) {
            $queryResult['blogs'] = UserBlog::query()->join('user_blog_informations', 'user_blogs.id', '=', 'user_blog_informations.blog_id')
                ->join('user_blog_categories', 'user_blog_categories.id', '=', 'user_blog_informations.blog_category_id')
                ->where('user_blog_informations.language_id', '=', $language->id)
                ->where('user_blog_informations.user_id', '=', $user->id)
                ->select('user_blogs.image', 'user_blog_informations.author', 'user_blog_informations.title', 'user_blog_informations.slug', 'user_blog_categories.name AS categoryName', 'user_blog_categories.slug AS categorySlug')
                ->orderByDesc('user_blogs.created_at')
                ->limit(3)
                ->get();
        }

        if ($themeInfo->theme_version == 1) {
            return view('user-front.theme1.index', $queryResult);
        } else if ($themeInfo->theme_version == 2) {
            return view('user-front.theme2.index', $queryResult);
        } else {
            return view('user-front.theme3.index', $queryResult);
        }
    }

    public function paymentInstruction(Request $request)
    {
        $offline = OfflineGateway::where('name', $request->name)
            ->select('short_description', 'instructions', 'is_receipt')
            ->first();

        return response()->json([
            'description' => $offline->short_description,
            'instructions' => $offline->instructions, 'is_receipt' => $offline->is_receipt
        ]);
    }

    public function contactMessage(Request $request, $domain)
    {
        $rules = [
            'fullname' => 'required',
            'email' => 'required|email:rfc,dns',
            'subject' => 'required',
            'message' => 'required'
        ];

        $request->validate($rules);

        $toUser = getUser();
        $data['toMail'] = $toUser->email;
        $data['toName'] = $toUser->username;
        $data['subject'] = $request->subject;
        $data['body'] = "<div>$request->message</div><br>
                         <strong>For further contact with the enquirer please use the below information:</strong><br>
                         <strong>Enquirer Name:</strong> $request->fullname <br>
                         <strong>Enquirer Mail:</strong> $request->email <br>
                         ";
        $data['fullname'] = $request->fullname;
        $data['email'] = $request->email;
        $mailer = new MegaMailer();
        $mailer->mailContactMessage($data);
        Session::flash('success', 'Mail sent successfully');
        return back();
    }

    public function adminContactMessage(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'subject' => 'required',
            'message' => 'required'
        ];

        $bs = BS::select('is_recaptcha')->first();

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $request->validate($rules, $messages);

        $data['fromMail'] = $request->email;
        $data['fromName'] = $request->name;
        $data['subject'] = $request->subject;
        $data['body'] = $request->message;
        $mailer = new MegaMailer();
        $mailer->mailToAdmin($data);
        Session::flash('success', 'Message sent successfully');
        return back();
    }

    public function contact(Request $request, $domain)
    {
        $user = getUser();

        $language =  $this->getUserCurrentLanguage($user->id);

        $queryResult['seoInfo'] = \App\Models\User\SEO::query()->where('user_id', $user->id)->select('contact_meta_keywords', 'contact_meta_description')->first();

        $queryResult['pageHeading'] = $this->getUserPageHeading($language, $user->id);

        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

        $queryResult['info'] = BasicSetting::query()
            ->where('user_id', $user->id)
            ->select('email_address', 'contact_number', 'address', 'latitude', 'longitude')
            ->firstOrFail();
        return view('user-front.common.contact', $queryResult);
    }

    public function userFaqs($domain)
    {
        $user = getUser();

        $language = $this->getUserCurrentLanguage($user->id);

        $queryResult['seoInfo'] = \App\Models\User\SEO::query()->where('user_id', $user->id)->select('faqs_meta_keywords', 'faqs_meta_description')->first();

        $queryResult['pageHeading'] = $this->getUserPageHeading($language, $user->id);

        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

        $queryResult['faqs'] = User\FAQ::query()->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->orderBy('serial_number', 'ASC')
            ->get();

        return view('user-front.common.faqs', $queryResult);
    }

    public function vcard($domain, $id)
    {
        $user = getUser();

        $vcard = UserVcard::findOrFail($id);

        $count = $vcard->user->memberships()->where('status', '=', 1)
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'))
            ->count();

        // check if the vcard owner does not have membership
        if ($count == 0) {
            return view('errors.404');
        }

        $cFeatures = UserPermissionHelper::packagePermission($vcard->user_id);
        $cFeatures = json_decode($cFeatures, true);
        if (empty($cFeatures) || !is_array($cFeatures) || !in_array('vCard', $cFeatures)) {
            return view('errors.404');
        }

        $parsedUrl = parse_url(url()->current());
        $host = $parsedUrl['host'];
        // if the current host contains the website domain
        if (strpos($host, env('WEBSITE_HOST')) !== false) {
            $host = str_replace("www.", "", $host);
            // if the current URL is subdomain
            if ($host != env('WEBSITE_HOST')) {
                $hostArr = explode('.', $host);
                $username = $hostArr[0];
                if (strtolower($vcard->user->username) != strtolower($username) || !cPackageHasSubdomain($vcard->user)) {
                    return view('errors.404');
                }
            } else {
                $path = explode('/', $parsedUrl['path']);
                $username = $path[1];
                if (strtolower($vcard->user->username) != strtolower($username)) {
                    return view('errors.404');
                }
            }
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            // Always include 'www.' at the begining of host
            if (substr($host, 0, 4) == 'www.') {
                $host = $host;
            } else {
                $host = 'www.' . $host;
            }
            // if the current package doesn't have 'custom domain' feature || the custom domain is not connected
            $cdomain = UserCustomDomain::where('requested_domain', '=', $host)->orWhere('requested_domain', '=', str_replace("www.", "", $host))->where('status', 1)->firstOrFail();
            $username = $cdomain->user->username;
            if (!cPackageHasCdomain($vcard->user) || ($username != $vcard->user->username)) {
                return view('errors.404');
            }
        }

        $infos = json_decode($vcard->information, true);

        $prefs = [];
        if (!empty($vcard->preferences)) {
            $prefs = json_decode($vcard->preferences, true);
        }

        $keywords = json_decode($vcard->keywords, true);

        $data['vcard'] = $vcard;
        $data['infos'] = $infos;
        $data['prefs'] = $prefs;
        $data['keywords'] = $keywords;
        $data['userBs'] = BasicSetting::query()->where('user_id', $user->id)->first();
        if ($vcard->template == 1) {
            return view('vcard.index1', $data);
        } elseif ($vcard->template == 2) {
            return view('vcard.index2', $data);
        } elseif ($vcard->template == 3) {
            return view('vcard.index3', $data);
        } elseif ($vcard->template == 4) {
            return view('vcard.index4', $data);
        } elseif ($vcard->template == 5) {
            return view('vcard.index5', $data);
        } elseif ($vcard->template == 6) {
            return view('vcard.index6', $data);
        } elseif ($vcard->template == 7) {
            return view('vcard.index7', $data);
        } elseif ($vcard->template == 8) {
            return view('vcard.index8', $data);
        } elseif ($vcard->template == 9) {
            return view('vcard.index9', $data);
        } elseif ($vcard->template == 10) {
            return view('vcard.index10', $data);
        }
    }

    public function vcardImport($domain, $id)
    {
        $user = getUser();

        $vcard = UserVcard::findOrFail($id);

        // define vcard
        $vcardObj = new VCard();

        // add personal data
        if (!empty($vcard->name)) {
            $vcardObj->addName($vcard->name);
        }
        if (!empty($vcard->company)) {
            $vcardObj->addCompany($vcard->company);
        }
        if (!empty($vcard->occupation)) {
            $vcardObj->addJobtitle($vcard->occupation);
        }
        if (!empty($vcard->email)) {
            $vcardObj->addEmail($vcard->email);
        }
        if (!empty($vcard->phone)) {
            $vcardObj->addPhoneNumber($vcard->phone, 'WORK');
        }
        if (!empty($vcard->address)) {
            $vcardObj->addAddress($vcard->address);
            $vcardObj->addLabel($vcard->address);
        }
        if (!empty($vcard->website_url)) {
            $vcardObj->addURL($vcard->website_url);
        }
        $userBs = BasicSetting::query()->where('user_id', $user->id)->first();
        $vcardObj->addPhoto(Uploader::getImageUrl(Constant::WEBSITE_VCARD_IMAGE, $vcard->profile_image, $userBs));

        return \Response::make(
            $vcardObj->getOutput(),
            200,
            $vcardObj->getHeaders(true)
        );
    }

    public function changeLanguage($lang): \Illuminate\Http\RedirectResponse
    {
        session()->put('lang', $lang);
        app()->setLocale($lang);
        return redirect()->route('front.index');
    }

    public function changeUserLanguage(Request $request, $domain): \Illuminate\Http\RedirectResponse
    {
        session()->put('user_lang', $request->lang_code);
        return redirect()->route('front.user.detail.view', $domain);
    }

    public function removeMaintenance($domain, $token)
    {
        Session::put('user-bypass-token', $token);
        return redirect()->route('front.user.detail.view', getParam());
    }

    public function userCPage($domain, $slug)
    {
        $user = getUser();

        $language = $this->getUserCurrentLanguage($user->id);

        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

        $queryResult['pageInfo'] = User\CustomPage\Page::query()
            ->join('user_page_contents', 'user_pages.id', '=', 'user_page_contents.page_id')
            ->where('user_pages.status', '=', 1)
            ->where('user_page_contents.language_id', '=', $language->id)
            ->where('user_page_contents.slug', '=', $slug)
            ->firstOrFail();

        return view('user-front.common.custom-page', $queryResult);
    }

}
