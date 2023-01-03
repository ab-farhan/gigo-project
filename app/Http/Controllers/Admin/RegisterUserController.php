<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Constant;
use App\Http\Helpers\Uploader;
use App\Models\Customer;
use App\Models\User\BasicSetting;
use App\Models\User\Curriculum\Course;
use App\Models\User\Curriculum\CourseEnrolment;
use App\Models\User\Curriculum\CourseInformation;
use App\Models\User\Curriculum\Lesson;
use App\Models\User\Curriculum\LessonContent;
use App\Models\User\Curriculum\Module;
use App\Models\User\Curriculum\QuizScore;
use App\Models\User\CustomPage\Page;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\Journal\Blog;
use App\Models\User\Journal\BlogInformation;
use App\Models\User\Teacher\SocialLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\BasicExtended;
use App\Models\Membership;
use App\Models\OfflineGateway;
use App\Models\Package;
use App\Models\PaymentGateway;
use App\Models\User;
use App\Models\User\HomePage\Section;
use App\Models\User\Language;
use App\Models\User\Menu;
use App\Models\User\PageHeading;
use App\Models\User\UserPermission;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterUserController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->term;
        $users = User::when($term, function($query, $term) {
            $query->where('username', 'like', '%' . $term . '%')->orWhere('email', 'like', '%' . $term . '%');
        })->orderBy('id', 'DESC')->paginate(10);

        $online = PaymentGateway::query()->where('status', 1)->get();
        $offline = OfflineGateway::where('status', 1)->get();
        $gateways = $online->merge($offline);
        $packages = Package::query()->where('status', '1')->get();

        return view('admin.register_user.index',compact('users', 'gateways', 'packages'));
    }

    public function view($id)
    {
        $user = User::findOrFail($id);
        $packages = Package::query()->where('status', '1')->get();

        $online = PaymentGateway::query()->where('status', 1)->get();
        $offline = OfflineGateway::where('status', 1)->get();
        $gateways = $online->merge($offline);

        return view('admin.register_user.details',compact('user', 'packages', 'gateways'));
    }

    public function store(Request $request) {

        $rules = [
            'username' => 'required|alpha_num|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'package_id' => 'required',
            'payment_gateway' => 'required',
            'online_status' => 'required'
        ];

        $messages = [
            'package_id.required' => 'The package field is required',
            'online_status.required' => 'The publicly hidden field is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $user = User::where('username', $request['username']);
        if ($user->count() == 0) {
            $user = User::create([
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
                'online_status' => $request["online_status"],
                'status' => 1,
                'email_verified' => 1,
            ]);

            BasicSetting::create([
                'user_id' => $user->id,
            ]);

            $homeSection = new Section();
            $homeSection->user_id = $user->id;
            $homeSection->save();
        }
        
        if ($user) {
            $checkoutController = new CheckoutController;
            $checkoutController->insertMailTemplate($user);

            $deLang = Language::firstOrFail();
            $langCount = Language::where('user_id', $user->id)->where('is_default', 1)->count();
            if ($langCount == 0) {
                $lang = Language::create([
                    'name' => 'English',
                    'code' => 'en',
                    'is_default' => 1,
                    'rtl' => 0,
                    'user_id' => $user->id,
                    'keywords' => $deLang->keywords
                ]);

                PageHeading::create([
                    "language_id" => $lang->id,
                    "user_id" => $user->id,
                    "blog_page_title" => "Blog",
                    "blog_details_page_title" => "Blog Detail",
                    "contact_page_title" => "Contact",
                    "courses_page_title" => "Course",
                    "course_details_page_title" => "Course Detail",
                    "error_page_title" => "Error",
                    "faq_page_title" => "FAQ",
                    "forget_password_page_title" => "Forget Password",
                    "instructors_page_title" => "Instructor",
                    "login_page_title" => "Login",
                    "signup_page_title" => "Sign Up",
                    "created_at" => null,
                    "updated_at" => null
                ]);

                $umenu = new Menu();
                $umenu->language_id = $lang->id;
                $umenu->user_id = $user->id;
                $umenu->menus = '[{"text":"Home","href":"","icon":"empty","target":"_self","title":"","type":"home"},{"type":"courses","text":"Courses","href":"","target":"_self"},{"type":"instructors","text":"Instructors","href":"","target":"_self"},{"type":"faq","text":"FAQ","href":"","target":"_self"},{"type":"contact","text":"Contact","href":"","target":"_self"}]';
                $umenu->save();
            }

            $package = Package::find($request['package_id']);
            $be = BasicExtended::first();
            $bs = BasicSetting::select('website_title')->first();
            $transaction_id = UserPermissionHelper::uniqidReal(8);

            $startDate = Carbon::today()->format('Y-m-d');
            if ($package->term === "monthly") {
                $endDate = Carbon::today()->addMonth()->format('Y-m-d');
            } elseif ($package->term === "yearly") {
                $endDate = Carbon::today()->addYear()->format('Y-m-d');
            } elseif ($package->term === "lifetime") {
                $endDate = Carbon::maxValue()->format('d-m-Y');
            }

            $memb = Membership::create([
                'price' => $package->price,
                'currency' => $be->base_currency_text ? $be->base_currency_text : "USD",
                'currency_symbol' => $be->base_currency_symbol ? $be->base_currency_symbol : $be->base_currency_text,
                'payment_method' => $request["payment_gateway"],
                'transaction_id' => $transaction_id ? $transaction_id : 0,
                'status' => 1,
                'is_trial' => 0,
                'trial_days' => 0,
                'receipt' => $request["receipt_name"] ? $request["receipt_name"] : null,
                'transaction_details' => null,
                'settings' => json_encode($be),
                'package_id' => $request['package_id'],
                'user_id' => $user->id,
                'start_date' => Carbon::parse($startDate),
                'expire_date' => Carbon::parse($endDate),
            ]);
            $package = Package::findOrFail($request['package_id']);
            $features = json_decode($package->features, true);
            $features[] = "Contact";
            UserPermission::create([
                'package_id' => $request['package_id'],
                'user_id' => $user->id,
                'permissions' => json_encode($features)
            ]);


            $requestData = [
                'start_date' => $startDate,
                'expire_date' => $endDate,
                'payment_method' => $request['payment_gateway']
            ];
            $file_name = $this->makeInvoice($requestData,"membership",$user,null,$package->price,$request['payment_gateway'],null,$be->base_currency_symbol_position,$be->base_currency_symbol,$be->base_currency_text,$transaction_id,$package->title, $memb);

            $mailer = new MegaMailer();
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $data = [
                'toMail' => $user->email,
                'toName' => $user->fname,
                'username' => $user->username,
                'package_title' => $package->title,
                'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                'activation_date' => $startDate->toFormattedDateString(),
                'expire_date' => $endDate->toFormattedDateString(),
                'membership_invoice' => $file_name,
                'website_title' => $bs->website_title,
                'templateType' => 'registration_with_premium_package',
                'type' => 'registrationWithPremiumPackage'
            ];
            $mailer->mailFromAdmin($data);
        }

        Session::flash('success', 'User added successfully!');
        return "success";
    }


    public function userban(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $user->update([
            'status' => $request->status,
        ]);
        Session::flash('success', 'Status update successfully!');
        return back();

    }


    public function emailStatus(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'email_verified' => $request->email_verified,
        ]);
        Session::flash('success', 'Email status updated for ' . $user->username);
        return back();
    }

    public function userFeatured(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $user->featured = $request->featured;
        $user->save();
        Session::flash('success', 'User featured update successfully!');
        return back();
    }


    public function changePass($id) {
        $data['user'] = User::findOrFail($id);
        return view('admin.register_user.password', $data);
    }


    public function updatePassword(Request $request)
    {
        $messages = [
            'npass.required' => 'New password is required',
            'cfpass.required' => 'Confirm password is required',
        ];

        $request->validate([
            'npass' => 'required',
            'cfpass' => 'required',
        ], $messages);

        $user = User::findOrFail($request->user_id);
        if ($request->npass == $request->cfpass) {
            $input['password'] = Hash::make($request->npass);
        } else {
            return back()->with('warning', __('Confirm password does not match.'));
        }
        $user->update($input);
        Session::flash('success', 'Password update for ' . $user->username);
        return back();
    }

    public function delete(Request $request)
    {
        $user = User::query()->findOrFail($request->user_id);
        $bss = BasicSetting::query()
            ->where('user_id',$user->id)
            ->select('aws_access_key_id','aws_secret_access_key','aws_default_region','aws_bucket')
            ->first();
        /**
         * delete 'page heading' info
         */
        $page_heading = $user->page_heading()->first();
        if (!empty($page_heading)) {
            $page_heading->delete();
        }
        /**
         * delete 'custom domains' info
         */
        $custom_domains = $user->custom_domains()->get();
        if ($custom_domains->count() > 0) {
            foreach ($custom_domains as $custom_domain) {
                $custom_domain->delete();
            }
        }
        /**
         * delete 'memberships' info
         */
        $memberships = $user->memberships()->get();
        if ($memberships->count() > 0) {
            foreach ($memberships as $membership) {
                @unlink(public_path('assets/front/img/membership/receipt/' . $membership->receipt));
                $membership->delete();
            }
        }
        /**
         * delete 'QR Codes' info
         */
        if ($user->qr_codes()->count() > 0) {
            $qr_codes = $user->qr_codes()->get();
            foreach ($qr_codes as $qr) {
                Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $qr->image,$bss, $user->id);
                $qr->delete();
            }
        }
        /**
         * delete 'count information's' info
         */
        $count_informations = $user->counterInformations()->get();
        if ($count_informations->count() > 0) {
            foreach ($count_informations as $count_information) {
                $count_information->delete();
            }

        }
        /**
         * delete 'user faqs' info
         */
        $faqs = $user->faqs()->get();
        if ($faqs->count() > 0) {
            foreach ($faqs as $faq) {
                $faq->delete();
            }
        }
        /**
         * delete 'user seos' info
         */
        $seos = $user->seos()->get();
        if ($seos->count() > 0) {
            foreach ($seos as $seo) {
                $seo->delete();
            }
        }
        /**
         * delete 'blog categories' info
         */
        if ($user->blog_categories()->count() > 0) {
            $user->blog_categories()->delete();
        }
        /**
         * delete 'social medias' info
         */
        if ($user->social_media()->count() > 0) {
            $user->social_media()->delete();
        }
        /**
         * delete 'languages' info
         */
        if ($user->languages()->count() > 0) {
            $user->languages()->delete();
        }
        /**
         * delete 'footer quick links' info
         */
        if ($user->footer_quick_links()->count() > 0) {
            $user->footer_quick_links()->delete();
        }
        /**
         * delete 'subscribers' info
         */
        if ($user->subscribers()->count() > 0) {
            $user->subscribers()->delete();
        }
        /**
         * delete 'footer texts' info
         */
        if ($user->footer_texts()->count() > 0) {
            $user->footer_texts()->delete();
        }
        /**
         * delete 'user testimonials' info
         */
        if ($user->testimonials()->count() > 0) {
            $testimonials = $user->testimonials()->get();
            foreach ($testimonials as $testimonial) {
                Uploader::remove(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE, $testimonial->image,$bss, $user->id);
                $testimonial->delete();
            }
        }
        /**
         * delete 'home_section' info
         */
        $home_section = $user->home_section()->first();
        if (!empty($home_section)) {
            $home_section->delete();
        }
        /**
         * delete 'menus' info
         */
        if ($user->menus()->count() > 0) {
            $user->menus()->delete();
        }
        /**
         * delete 'hero_sections' info
         */
        if ($user->hero_sections()->count() > 0) {
            $hero_sections = $user->hero_sections()->get();
            foreach ($hero_sections as $hero_section) {
                Uploader::remove(Constant::WEBSITE_HERO_SECTION_IMAGE, $hero_section->background_image,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_HERO_SECTION_IMAGE, $hero_section->image,$bss, $user->id);
                $hero_section->delete();
            }
        }
        /**
         * delete 'advertisements' info
         */
        if ($user->advertisements()->count() > 0) {
            $advertisements = $user->advertisements()->get();
            foreach ($advertisements as $advertisement) {
                Uploader::remove(Constant::WEBSITE_ADVERTISEMENT_IMAGE, $advertisement->image,$bss, $user->id);
                $advertisement->delete();
            }
        }
        /**
         * delete 'popup' infos
         */
        $popups = $user->announcementPopup()->get();

        if (count($popups) > 0) {
            foreach ($popups as $popup) {
                Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE,$popup->image,$bss, $user->id);
                $popup->delete();
            }
        }
        /**
         * delete 'section title' info
         */
        $sectionTitleInfo = $user->sectionTitle()->first();

        if (!empty($sectionTitleInfo)) {
            $sectionTitleInfo->delete();
        }

        /**
         * delete 'action section' info
         */
        $actionSec = $user->actionSection()->first();

        if (!empty($actionSec)) {
            Uploader::remove(Constant::WEBSITE_ACTION_SECTION_IMAGE,$actionSec->background_image,$bss, $user->id);
            Uploader::remove(Constant::WEBSITE_ACTION_SECTION_IMAGE,$actionSec->image,$bss, $user->id);
            $actionSec->delete();
        }

        /**
         * delete 'coupons' info
         */
        if ($user->coupons()->count() > 0) {
            $user->coupons()->delete();
        }
        /**
         * delete 'section title' info
         */
        if ($user->sectionTitle()->count() > 0) {
            $user->sectionTitle()->delete();
        }
        /**
         * delete 'cookie alert' info
         */
        if ($user->cookieAlertInfo()->count() > 0) {
            $user->cookieAlertInfo()->delete();
        }
        /**
         * delete 'video section' info
         */
        $videoSec = $user->videoSection()->first();
        if (!empty($videoSec)) {
            Uploader::remove(Constant::WEBSITE_VIDEO_SECTION_IMAGE, $videoSec->image,$bss, $user->id);
            $videoSec->delete();
        }
        /**
         * delete 'user features' info
         */
        $features = $user->features()->get();
        if ($features->count() > 0) {
            foreach ($features as $feature) {
                $feature->delete();
            }
        }
        /**
         * delete 'blog infos'
         */
        $blogInfos = BlogInformation::query()->where('user_id', $user->id)->get();

        if (count($blogInfos) > 0) {
            foreach ($blogInfos as $blogData) {
                $blogInfo = $blogData;
                $blogData->delete();

                // delete the blog if, this blog does not contain any other blog information in any other language
                $otherBlogInfos = BlogInformation::query()
                    ->where('user_id', '=', $user->id)
                    ->where('blog_id', '=', $blogInfo->blog_id)
                    ->get();

                if (count($otherBlogInfos) == 0) {
                    $blog = Blog::query()
                        ->where('user_id', $user->id)
                        ->find($blogInfo->blog_id);
                    Uploader::remove(Constant::WEBSITE_BLOG_IMAGE, $blog->image,$bss, $user->id);
                    $blog->delete();
                }
            }
        }
        /**
         * delete 'instructors'
         */
        $instructors = $user->instructors()->get();
        if (count($instructors) > 0) {
            foreach ($instructors as $instructor) {
                // delete all 'social links' of each instructor
                $socialLinks = SocialLink::query()
                    ->where('instructor_id', $instructor->id)
                    ->where('user_id', $user->id)
                    ->get();
                if (count($socialLinks) > 0) {
                    foreach ($socialLinks as $socialLink) {
                        $socialLink->delete();
                    }
                }
                Uploader::remove(Constant::WEBSITE_INSTRUCTOR_IMAGE, $instructor->image,$bss, $user->id);
                $instructor->delete();
            }
        }
        /**
         * delete 'vcards'
         */
        if ($user->vcards()->count() > 0) {
            $vcards = $user->vcards()->get();
            foreach ($vcards as $key => $vcard) {
                Uploader::remove(Constant::WEBSITE_VCARD_IMAGE, $vcard->profile_image,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_VCARD_IMAGE, $vcard->cover_image,$bss, $user->id);
                if ($vcard->user_vcard_projects()->count() > 0) {
                    foreach ($vcard->user_vcard_projects as $project) {
                        Uploader::remove(Constant::WEBSITE_VCARD_PROJECT_IMAGE, $project->image,$bss, $user->id);
                        $project->delete();
                    }
                }
                if ($vcard->user_vcard_services()->count() > 0) {
                    foreach ($vcard->user_vcard_services as $service) {
                        Uploader::remove(Constant::WEBSITE_VCARD_SERVICE_IMAGE, $service->image,$bss, $user->id);
                        $service->delete();
                    }
                }
                if ($vcard->user_vcard_testimonials()->count() > 0) {
                    foreach ($vcard->user_vcard_testimonials as $testimonial) {
                        Uploader::remove(Constant::WEBSITE_VCARD_TESTIMONIAL_IMAGE, $testimonial->image,$bss, $user->id);
                        $testimonial->delete();
                    }
                }
                $vcard->delete();
            }
        }

        /**
         * delete 'course infos'
         */
        $courseInfos = $user->courseInformation()->get();

        if (count($courseInfos) > 0) {
            foreach ($courseInfos as $courseData) {
                $courseInfo = $courseData;
                // get all 'modules' of each course-info & delete them
                $modules = Module::query()
                    ->where('user_id', $user->id)
                    ->where('course_information_id', $courseInfo->id)
                    ->get();

                if (count($modules) > 0) {
                    foreach ($modules as $module) {
                        // get all 'lessons' of each module & delete them
                        $lessons = Lesson::query()
                            ->where('user_id', $user->id)
                            ->where('module_id', $module->id)
                            ->get();

                        if (count($lessons) > 0) {
                            foreach ($lessons as $lesson) {
                                // get all 'lesson contents' of each lesson & delete them by checking the 'type'
                                $lessonContents = LessonContent::query()
                                    ->where('lesson_id', $lesson->id)
                                    ->where('user_id', $user->id)
                                    ->get();
                                if (count($lessonContents) > 0) {
                                    foreach ($lessonContents as $lessonContent) {
                                        if ($lessonContent->type == 'video') {
                                            Uploader::remove(Constant::WEBSITE_LESSON_CONTENT_VIDEO, $lessonContent->video_unique_name,$bss, $user->id);
                                        } else if ($lessonContent->type == 'file') {
                                            Uploader::remove(Constant::WEBSITE_LESSON_CONTENT_FILE, $lessonContent->file_unique_name,$bss, $user->id);
                                        } else if ($lessonContent->type == 'quiz') {
                                            // get all 'lesson quizzes' of this lesson-content & delete them
                                            $lessonQuizzes = User\Curriculum\LessonQuiz::query()
                                                ->where('lesson_id', $lesson->id)
                                                ->where('user_id', $user->id)
                                                ->get();

                                            if (count($lessonQuizzes) > 0) {
                                                foreach ($lessonQuizzes as $lessonQuiz) {
                                                    $lessonQuiz->delete();
                                                }
                                            }
                                        }
                                        $lessonContent->delete();
                                    }
                                }
                                $lesson->delete();
                            }
                        }
                        $module->delete();
                    }
                }
                $courseData->delete();

                // get all the 'course faqs' of this language & delete them
                $courseFaqs = User\Curriculum\CourseFaq::query()
                    ->where('course_id', '=', $user->id)
                    ->where('user_id', '=', $courseInfo->course_id)
                    ->get();

                if (count($courseFaqs) > 0) {
                    foreach ($courseFaqs as $courseFaq) {
                        $courseFaq->delete();
                    }
                }

                $course = Course::query()
                    ->where('user_id', $user->id)
                    ->find($courseInfo->course_id);

                if(isset($course)){
                    // get all the 'course enrolments' of this course & delete them
                    $enrolments = CourseEnrolment::query()
                        ->where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->get();

                    if (count($enrolments) > 0) {
                        foreach ($enrolments as $enrolment) {
                            Uploader::remove(Constant::WEBSITE_ENROLLMENT_ATTACHMENT, $enrolment->attachment,$bss, $user->id);
                            Uploader::remove(Constant::WEBSITE_ENROLLMENT_INVOICE, $enrolment->invoice,$bss, $user->id);
                            $enrolment->delete();
                        }
                    }

                    // get all the 'reviews' of this course & delete them
                    $reviews = User\Curriculum\CourseReview::query()
                        ->where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->get();

                    if (count($reviews) > 0) {
                        foreach ($reviews as $review) {
                            $review->delete();
                        }
                    }

                    // get all the 'quiz scores' of this course & delete them
                    $quizScores = QuizScore::query()
                        ->where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->get();

                    if (count($quizScores) > 0) {
                        foreach ($quizScores as $quizScore) {
                            $quizScore->delete();
                        }
                    }
                    Uploader::remove(Constant::WEBSITE_COURSE_THUMBNAIL_IMAGE, $course->thumbnail_image,$bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_COURSE_COVER_IMAGE, $course->cover_image,$bss, $user->id);
                    // finally, delete the course
                    $course->delete();
                }

            }
        }
        /**
         * delete 'course categories' info
         */
        $courseCategories = User\Curriculum\CourseCategory::query()
            ->where('user_id', $user->id)
            ->get();

        if (count($courseCategories) > 0) {
            foreach ($courseCategories as $courseCategory) {
                $courseCategory->delete();
            }
        }
        /**
         * delete 'page contents'
         */
        $customPageInfos = $user->customPageInfo()->get();

        if (count($customPageInfos) > 0) {
            foreach ($customPageInfos as $customPageData) {
                $customPageInfo = $customPageData;
                $customPageData->delete();

                // delete the 'custom page' if, this page does not contain any other page content in any other language
                $otherPageContents = PageContent::query()
                    ->where('user_id', $user->id)
                    ->where('page_id', '=', $customPageInfo->page_id)
                    ->get();

                if (count($otherPageContents) == 0) {
                    $page = Page::query()
                        ->where('user_id', $user->id)
                        ->find($customPageInfo->page_id);
                    $page->delete();
                }
            }
        }

        /**
         * delete 'newsletter section' info
         */
        $newsletterSecs = $user->newsletterSection()->get();

        foreach ($newsletterSecs as $newsletterSec) {
            if (!empty($newsletterSec)) {
                Uploader::remove(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $newsletterSec->background_image,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $newsletterSec->image,$bss, $user->id);
                $newsletterSec->delete();
            }
        }
        /**
         * delete 'about us section' info
         */
        $about_us_sections = $user->about_us_section()->get();

        foreach ($about_us_sections as $about_us_section) {
            if (!empty($about_us_section)) {
                Uploader::remove(Constant::WEBSITE_ABOUT_US_SECTION_IMAGE, $about_us_section->image,$bss, $user->id);
                $about_us_section->delete();
            }
        }
        /**
         * delete 'fun fact section' info
         */
        $fun_fact_sections = $user->fun_fact_sections()->get();

        foreach ($fun_fact_sections as $fun_fact_section) {
            if (!empty($fun_fact_section)) {
                Uploader::remove(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE, $fun_fact_section->background_image,$bss, $user->id);
                $fun_fact_section->delete();
            }
        }
        /**
         * delete 'features section' info
         */
        $features = $user->features()->get();

        foreach ($features as $feature) {
            if (!empty($feature)) {
                Uploader::remove(Constant::WEBSITE_FEATURE_SECTION_IMAGE, $feature->features_section_image,$bss, $user->id);
                $feature->delete();
            }
        }
        /**
         * delete 'online gateways' info
         */
        $online_gateways = $user->online_gateways()->get();

        foreach ($online_gateways as $online_gateway) {
            if (!empty($online_gateway)) {
                $online_gateway->delete();
            }
        }
        /**
         * delete 'offline gateways' info
         */
        $offline_gateways = $user->offline_gateways()->get();

        foreach ($offline_gateways as $offline_gateway) {
            if (!empty($offline_gateway)) {
                $offline_gateway->delete();
            }
        }
        
        /**
         * delete 'mail templates' info
         */
        $mail_templates = $user->mail_templates()->get();

        if (!empty($mail_templates)) {
            foreach ($mail_templates as $mt) {
                if (!empty($mt)) {
                    $mt->delete();
                }
            }
        }

        /**
         * delete 'customer details' info
         */
        $customers = Customer::where('user_id', $user->id)->get();
        foreach ($customers as $customer){
            // delete course enrolment
            if ($customer->courseEnrolment()->count() > 0) {
                $customer->courseEnrolment()->delete();
            }

            if ($customer->quizScore()->count() > 0) {
                $customer->quizScore()->delete();
            }

            if ($customer->review()->count() > 0) {
                $customer->review()->delete();
            }

            // delete customer image
            Uploader::remove(Constant::WEBSITE_TENANT_CUSTOMER_IMAGE .'/'. $user->id, $customer->image,$bss, $user->id);
            $customer->delete();
        }
        /**
         * delete 'basic settings' info
         */
        $bs = $user->basic_setting()->first();
        if (!empty($bs)) {
            Uploader::remove(Constant::WEBSITE_BREADCRUMB, $bs->breadcrumb,$bss, $user->id);
            Uploader::remove(Constant::WEBSITE_LOGO, $bs->logo,$bss, $user->id);
            Uploader::remove(Constant::WEBSITE_FAVICON, $bs->favicon,$bss, $user->id);
            Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_image,$bss, $user->id);
            Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_inserted_image,$bss, $user->id);
            $bs->delete();
        }
        //user profile image
        @unlink(public_path('assets/front/img/user/' . $user->photo));
        $user->delete();
        Session::flash('success', 'User deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $user = User::query()->findOrFail($id);
            $bss = BasicSetting::query()
                ->where('user_id',$user->id)
                ->select('aws_access_key_id','aws_secret_access_key','aws_default_region','aws_bucket')
                ->first();
            /**
             * delete 'page heading' info
             */
            $page_heading = $user->page_heading()->first();
            if (!empty($page_heading)) {
                $page_heading->delete();
            }
            /**
             * delete 'custom domains' info
             */
            $custom_domains = $user->custom_domains()->get();
            if ($custom_domains->count() > 0) {
                foreach ($custom_domains as $custom_domain) {
                    $custom_domain->delete();
                }
            }
            /**
             * delete 'memberships' info
             */
            $memberships = $user->memberships()->get();
            if ($memberships->count() > 0) {
                foreach ($memberships as $membership) {
                    @unlink(public_path('assets/front/img/membership/receipt/' . $membership->receipt));
                    $membership->delete();
                }
            }
            /**
             * delete 'QR Codes' info
             */
            if ($user->qr_codes()->count() > 0) {
                $qr_codes = $user->qr_codes()->get();
                foreach ($qr_codes as $qr) {
                    Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $qr->image,$bss, $user->id);
                    $qr->delete();
                }
            }
            /**
             * delete 'count information's' info
             */
            $count_informations = $user->counterInformations()->get();
            if ($count_informations->count() > 0) {
                foreach ($count_informations as $count_information) {
                    $count_information->delete();
                }

            }
            /**
             * delete 'user faqs' info
             */
            $faqs = $user->faqs()->get();
            if ($faqs->count() > 0) {
                foreach ($faqs as $faq) {
                    $faq->delete();
                }
            }
            /**
             * delete 'user seos' info
             */
            $seos = $user->seos()->get();
            if ($seos->count() > 0) {
                foreach ($seos as $seo) {
                    $seo->delete();
                }
            }
            /**
             * delete 'blog categories' info
             */
            if ($user->blog_categories()->count() > 0) {
                $user->blog_categories()->delete();
            }
            /**
             * delete 'social medias' info
             */
            if ($user->social_media()->count() > 0) {
                $user->social_media()->delete();
            }
            /**
             * delete 'languages' info
             */
            if ($user->languages()->count() > 0) {
                $user->languages()->delete();
            }
            /**
             * delete 'footer quick links' info
             */
            if ($user->footer_quick_links()->count() > 0) {
                $user->footer_quick_links()->delete();
            }
            /**
             * delete 'subscribers' info
             */
            if ($user->subscribers()->count() > 0) {
                $user->subscribers()->delete();
            }
            /**
             * delete 'footer texts' info
             */
            if ($user->footer_texts()->count() > 0) {
                $user->footer_texts()->delete();
            }
            /**
             * delete 'user testimonials' info
             */
            if ($user->testimonials()->count() > 0) {
                $testimonials = $user->testimonials()->get();
                foreach ($testimonials as $testimonial) {
                    Uploader::remove(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE, $testimonial->image,$bss, $user->id);
                    $testimonial->delete();
                }
            }
            /**
             * delete 'home_section' info
             */
            $home_section = $user->home_section()->first();
            if (!empty($home_section)) {
                $home_section->delete();
            }
            /**
             * delete 'menus' info
             */
            if ($user->menus()->count() > 0) {
                $user->menus()->delete();
            }
            /**
             * delete 'hero_sections' info
             */
            if ($user->hero_sections()->count() > 0) {
                $hero_sections = $user->hero_sections()->get();
                foreach ($hero_sections as $hero_section) {
                    Uploader::remove(Constant::WEBSITE_HERO_SECTION_IMAGE, $hero_section->background_image,$bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_HERO_SECTION_IMAGE, $hero_section->image,$bss, $user->id);
                    $hero_section->delete();
                }
            }
            /**
             * delete 'advertisements' info
             */
            if ($user->advertisements()->count() > 0) {
                $advertisements = $user->advertisements()->get();
                foreach ($advertisements as $advertisement) {
                    Uploader::remove(Constant::WEBSITE_ADVERTISEMENT_IMAGE, $advertisement->image,$bss, $user->id);
                    $advertisement->delete();
                }
            }
            /**
             * delete 'popup' infos
             */
            $popups = $user->announcementPopup()->get();

            if (count($popups) > 0) {
                foreach ($popups as $popup) {
                    Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE,$popup->image,$bss, $user->id);
                    $popup->delete();
                }
            }
            /**
             * delete 'section title' info
             */
            $sectionTitleInfo = $user->sectionTitle()->first();

            if (!empty($sectionTitleInfo)) {
                $sectionTitleInfo->delete();
            }

            /**
             * delete 'action section' info
             */
            $actionSec = $user->actionSection()->first();

            if (!empty($actionSec)) {
                Uploader::remove(Constant::WEBSITE_ACTION_SECTION_IMAGE,$actionSec->background_image,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_ACTION_SECTION_IMAGE,$actionSec->image,$bss, $user->id);
                $actionSec->delete();
            }

            /**
             * delete 'coupons' info
             */
            if ($user->coupons()->count() > 0) {
                $user->coupons()->delete();
            }
            /**
             * delete 'section title' info
             */
            if ($user->sectionTitle()->count() > 0) {
                $user->sectionTitle()->delete();
            }
            /**
             * delete 'cookie alert' info
             */
            if ($user->cookieAlertInfo()->count() > 0) {
                $user->cookieAlertInfo()->delete();
            }
            /**
             * delete 'video section' info
             */
            $videoSec = $user->videoSection()->first();
            if (!empty($videoSec)) {
                Uploader::remove(Constant::WEBSITE_VIDEO_SECTION_IMAGE, $videoSec->image,$bss, $user->id);
                $videoSec->delete();
            }
            /**
             * delete 'user features' info
             */
            $features = $user->features()->get();
            if ($features->count() > 0) {
                foreach ($features as $feature) {
                    $feature->delete();
                }
            }
            /**
             * delete 'blog infos'
             */
            $blogInfos = BlogInformation::query()->where('user_id', $user->id)->get();

            if (count($blogInfos) > 0) {
                foreach ($blogInfos as $blogData) {
                    $blogInfo = $blogData;
                    $blogData->delete();

                    // delete the blog if, this blog does not contain any other blog information in any other language
                    $otherBlogInfos = BlogInformation::query()
                        ->where('user_id', '=', $user->id)
                        ->where('blog_id', '=', $blogInfo->blog_id)
                        ->get();

                    if (count($otherBlogInfos) == 0) {
                        $blog = Blog::query()
                            ->where('user_id', $user->id)
                            ->find($blogInfo->blog_id);
                        Uploader::remove(Constant::WEBSITE_BLOG_IMAGE, $blog->image,$bss, $user->id);
                        $blog->delete();
                    }
                }
            }
            /**
             * delete 'instructors'
             */
            $instructors = $user->instructors()->get();
            if (count($instructors) > 0) {
                foreach ($instructors as $instructor) {
                    // delete all 'social links' of each instructor
                    $socialLinks = SocialLink::query()
                        ->where('instructor_id', $instructor->id)
                        ->where('user_id', $user->id)
                        ->get();
                    if (count($socialLinks) > 0) {
                        foreach ($socialLinks as $socialLink) {
                            $socialLink->delete();
                        }
                    }
                    Uploader::remove(Constant::WEBSITE_INSTRUCTOR_IMAGE, $instructor->image,$bss, $user->id);
                    $instructor->delete();
                }
            }
            /**
             * delete 'vcards'
             */
            if ($user->vcards()->count() > 0) {
                $vcards = $user->vcards()->get();
                foreach ($vcards as $key => $vcard) {
                    Uploader::remove(Constant::WEBSITE_VCARD_IMAGE, $vcard->profile_image,$bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_VCARD_IMAGE, $vcard->cover_image,$bss, $user->id);
                    if ($vcard->user_vcard_projects()->count() > 0) {
                        foreach ($vcard->user_vcard_projects as $project) {
                            Uploader::remove(Constant::WEBSITE_VCARD_PROJECT_IMAGE, $project->image,$bss, $user->id);
                            $project->delete();
                        }
                    }
                    if ($vcard->user_vcard_services()->count() > 0) {
                        foreach ($vcard->user_vcard_services as $service) {
                            Uploader::remove(Constant::WEBSITE_VCARD_SERVICE_IMAGE, $service->image,$bss, $user->id);
                            $service->delete();
                        }
                    }
                    if ($vcard->user_vcard_testimonials()->count() > 0) {
                        foreach ($vcard->user_vcard_testimonials as $testimonial) {
                            Uploader::remove(Constant::WEBSITE_VCARD_TESTIMONIAL_IMAGE, $testimonial->image,$bss, $user->id);
                            $testimonial->delete();
                        }
                    }
                    $vcard->delete();
                }
            }

            /**
             * delete 'course infos'
             */
            $courseInfos = $user->courseInformation()->get();

            if (count($courseInfos) > 0) {
                foreach ($courseInfos as $courseData) {
                    $courseInfo = $courseData;
                    // get all 'modules' of each course-info & delete them
                    $modules = Module::query()
                        ->where('user_id', $user->id)
                        ->where('course_information_id', $courseInfo->id)
                        ->get();

                    if (count($modules) > 0) {
                        foreach ($modules as $module) {
                            // get all 'lessons' of each module & delete them
                            $lessons = Lesson::query()
                                ->where('user_id', $user->id)
                                ->where('module_id', $module->id)
                                ->get();

                            if (count($lessons) > 0) {
                                foreach ($lessons as $lesson) {
                                    // get all 'lesson contents' of each lesson & delete them by checking the 'type'
                                    $lessonContents = LessonContent::query()
                                        ->where('lesson_id', $lesson->id)
                                        ->where('user_id', $user->id)
                                        ->get();
                                    if (count($lessonContents) > 0) {
                                        foreach ($lessonContents as $lessonContent) {
                                            if ($lessonContent->type == 'video') {
                                                Uploader::remove(Constant::WEBSITE_LESSON_CONTENT_VIDEO, $lessonContent->video_unique_name,$bss, $user->id);
                                            } else if ($lessonContent->type == 'file') {
                                                Uploader::remove(Constant::WEBSITE_LESSON_CONTENT_FILE, $lessonContent->file_unique_name,$bss, $user->id);
                                            } else if ($lessonContent->type == 'quiz') {
                                                // get all 'lesson quizzes' of this lesson-content & delete them
                                                $lessonQuizzes = User\Curriculum\LessonQuiz::query()
                                                    ->where('lesson_id', $lesson->id)
                                                    ->where('user_id', $user->id)
                                                    ->get();

                                                if (count($lessonQuizzes) > 0) {
                                                    foreach ($lessonQuizzes as $lessonQuiz) {
                                                        $lessonQuiz->delete();
                                                    }
                                                }
                                            }
                                            $lessonContent->delete();
                                        }
                                    }
                                    $lesson->delete();
                                }
                            }
                            $module->delete();
                        }
                    }
                    $courseData->delete();

                    // get all the 'course faqs' of this language & delete them
                    $courseFaqs = User\Curriculum\CourseFaq::query()
                        ->where('course_id', '=', $user->id)
                        ->where('user_id', '=', $courseInfo->course_id)
                        ->get();

                    if (count($courseFaqs) > 0) {
                        foreach ($courseFaqs as $courseFaq) {
                            $courseFaq->delete();
                        }
                    }

                    $course = Course::query()
                        ->where('user_id', $user->id)
                        ->find($courseInfo->course_id);

                    if(isset($course)){
                        // get all the 'course enrolments' of this course & delete them
                        $enrolments = CourseEnrolment::query()
                            ->where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->get();

                        if (count($enrolments) > 0) {
                            foreach ($enrolments as $enrolment) {
                                Uploader::remove(Constant::WEBSITE_ENROLLMENT_ATTACHMENT, $enrolment->attachment,$bss, $user->id);
                                Uploader::remove(Constant::WEBSITE_ENROLLMENT_INVOICE, $enrolment->invoice,$bss, $user->id);
                                $enrolment->delete();
                            }
                        }

                        // get all the 'reviews' of this course & delete them
                        $reviews = User\Curriculum\CourseReview::query()
                            ->where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->get();

                        if (count($reviews) > 0) {
                            foreach ($reviews as $review) {
                                $review->delete();
                            }
                        }

                        // get all the 'quiz scores' of this course & delete them
                        $quizScores = QuizScore::query()
                            ->where('user_id', $user->id)
                            ->where('course_id', $course->id)
                            ->get();

                        if (count($quizScores) > 0) {
                            foreach ($quizScores as $quizScore) {
                                $quizScore->delete();
                            }
                        }
                        Uploader::remove(Constant::WEBSITE_COURSE_THUMBNAIL_IMAGE, $course->thumbnail_image,$bss, $user->id);
                        Uploader::remove(Constant::WEBSITE_COURSE_COVER_IMAGE, $course->cover_image,$bss, $user->id);
                        // finally, delete the course
                        $course->delete();
                    }

                }
            }
            /**
             * delete 'course categories' info
             */
            $courseCategories = User\Curriculum\CourseCategory::query()
                ->where('user_id', $user->id)
                ->get();

            if (count($courseCategories) > 0) {
                foreach ($courseCategories as $courseCategory) {
                    $courseCategory->delete();
                }
            }
            /**
             * delete 'page contents'
             */
            $customPageInfos = $user->customPageInfo()->get();

            if (count($customPageInfos) > 0) {
                foreach ($customPageInfos as $customPageData) {
                    $customPageInfo = $customPageData;
                    $customPageData->delete();

                    // delete the 'custom page' if, this page does not contain any other page content in any other language
                    $otherPageContents = PageContent::query()
                        ->where('user_id', $user->id)
                        ->where('page_id', '=', $customPageInfo->page_id)
                        ->get();

                    if (count($otherPageContents) == 0) {
                        $page = Page::query()
                            ->where('user_id', $user->id)
                            ->find($customPageInfo->page_id);
                        $page->delete();
                    }
                }
            }

            /**
             * delete 'newsletter section' info
             */
            $newsletterSecs = $user->newsletterSection()->get();

            foreach ($newsletterSecs as $newsletterSec) {
                if (!empty($newsletterSec)) {
                    Uploader::remove(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $newsletterSec->background_image,$bss, $user->id);
                    Uploader::remove(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $newsletterSec->image,$bss, $user->id);
                    $newsletterSec->delete();
                }
            }
            /**
             * delete 'about us section' info
             */
            $about_us_sections = $user->about_us_section()->get();

            foreach ($about_us_sections as $about_us_section) {
                if (!empty($about_us_section)) {
                    Uploader::remove(Constant::WEBSITE_ABOUT_US_SECTION_IMAGE, $about_us_section->image,$bss, $user->id);
                    $about_us_section->delete();
                }
            }
            /**
             * delete 'fun fact section' info
             */
            $fun_fact_sections = $user->fun_fact_sections()->get();

            foreach ($fun_fact_sections as $fun_fact_section) {
                if (!empty($fun_fact_section)) {
                    Uploader::remove(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE, $fun_fact_section->background_image,$bss, $user->id);
                    $fun_fact_section->delete();
                }
            }
            /**
             * delete 'features section' info
             */
            $features = $user->features()->get();

            foreach ($features as $feature) {
                if (!empty($feature)) {
                    Uploader::remove(Constant::WEBSITE_FEATURE_SECTION_IMAGE, $feature->features_section_image,$bss, $user->id);
                    $feature->delete();
                }
            }
            /**
             * delete 'online gateways' info
             */
            $online_gateways = $user->online_gateways()->get();

            foreach ($online_gateways as $online_gateway) {
                if (!empty($online_gateway)) {
                    $online_gateway->delete();
                }
            }
            /**
             * delete 'offline gateways' info
             */
            $offline_gateways = $user->offline_gateways()->get();

            foreach ($offline_gateways as $offline_gateway) {
                if (!empty($offline_gateway)) {
                    $offline_gateway->delete();
                }
            }
        
            /**
             * delete 'mail templates' info
             */
            $mail_templates = $user->mail_templates()->get();
    
            if (!empty($mail_templates)) {
                foreach ($mail_templates as $mt) {
                    if (!empty($mt)) {
                        $mt->delete();
                    }
                }
            }

            /**
             * delete 'customer details' info
             */
            $customers = Customer::where('user_id', $user->id)->get();
            foreach ($customers as $customer){
                // delete course enrolment
                if ($customer->courseEnrolment()->count() > 0) {
                    $customer->courseEnrolment()->delete();
                }

                if ($customer->quizScore()->count() > 0) {
                    $customer->quizScore()->delete();
                }

                if ($customer->review()->count() > 0) {
                    $customer->review()->delete();
                }

                // delete customer image
                Uploader::remove(Constant::WEBSITE_TENANT_CUSTOMER_IMAGE .'/'. $user->id, $customer->image,$bss, $user->id);
                $customer->delete();
            }
            /**
             * delete 'basic settings' info
             */
            $bs = $user->basic_setting()->first();
            if (!empty($bs)) {
                Uploader::remove(Constant::WEBSITE_BREADCRUMB, $bs->breadcrumb,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_LOGO, $bs->logo,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_FAVICON, $bs->favicon,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_image,$bss, $user->id);
                Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_inserted_image,$bss, $user->id);
                $bs->delete();
            }
            //user profile image
            @unlink(public_path('assets/front/img/user/' . $user->photo));
            $user->delete();
        }
        Session::flash('success', 'Users deleted successfully!');
        return "success";
    }

    public function removeCurrPackage(Request $request) {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $currMembership = UserPermissionHelper::currMembOrPending($userId);
        $currPackage = Package::select('title')->findOrFail($currMembership->package_id);
        $nextMembership = UserPermissionHelper::nextMembership($userId);
        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();

        $today = Carbon::now();

        // just expire the current package
        $currMembership->expire_date = $today->subDay();
        $currMembership->modified = 1;
        if ($currMembership->status == 0) {
            $currMembership->status = 2;
        }
        $currMembership->save();
            
        // if next package exists
        if (!empty($nextMembership)) {
            $nextPackage = Package::find($nextMembership->package_id);

            $nextMembership->start_date = Carbon::parse(Carbon::today()->format('d-m-Y'));
            if ($nextPackage->term == 'monthly') {
                $nextMembership->expire_date = Carbon::parse(Carbon::today()->addMonth()->format('d-m-Y'));
            } elseif ($nextPackage->term == 'yearly') {
                $nextMembership->expire_date = Carbon::parse(Carbon::today()->addYear()->format('d-m-Y'));
            } elseif ($nextPackage->term == 'lifetime') {
                $nextMembership->expire_date = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
            }
            $nextMembership->save();

            $features = json_decode($nextPackage->features, true);
            $features[] = "Contact";
            UserPermission::where('user_id', $user->id)->update([
                'package_id' => $nextPackage->id,
                'user_id' => $user->id,
                'permissions' => json_encode($features)
            ]);
        }

        $this->sendMail(NULL, NULL, $request->payment_method, $user, $bs, $be, 'admin_removed_current_package', NULL, $currPackage->title);

        Session::flash('success', 'Current Package removed successfully!');
        return back();
    }


    public function sendMail($memb, $package, $paymentMethod, $user, $bs, $be, $mailType, $replacedPackage = NULL, $removedPackage = NULL) {

        if ($mailType != 'admin_removed_current_package' && $mailType != 'admin_removed_next_package') {
            $transaction_id = UserPermissionHelper::uniqidReal(8);
            $activation = $memb->start_date;
            $expire = $memb->expire_date;
            $info['start_date'] = $activation->toFormattedDateString();
            $info['expire_date'] = $expire->toFormattedDateString();
            $info['payment_method'] = $paymentMethod;

            $file_name = $this->makeInvoice($info,"membership",$user,NULL,$package->price,"Stripe",$user->phone,$be->base_currency_symbol_position,$be->base_currency_symbol,$be->base_currency_text,$transaction_id,$package->title,$memb);
        }

        $mailer = new MegaMailer();
        $data = [
            'toMail' => $user->email,
            'toName' => $user->fname,
            'username' => $user->username,
            'website_title' => $bs->website_title,
            'templateType' => $mailType
        ];
        
        if ($mailType != 'admin_removed_current_package' && $mailType != 'admin_removed_next_package') {
            $data['package_title'] = $package->title;
            $data['package_price'] = ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : '');
            $data['activation_date'] = $activation->toFormattedDateString();
            $data['expire_date'] = Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString();
            $data['membership_invoice'] = $file_name;
        }
        if ($mailType != 'admin_removed_current_package' || $mailType != 'admin_removed_next_package') {
            $data['removed_package_title'] = $removedPackage;
        }

        if (!empty($replacedPackage)) {
            $data['replaced_package'] = $replacedPackage;
        }

        $mailer->mailFromAdmin($data);
    }


    public function changeCurrPackage(Request $request) {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $currMembership = UserPermissionHelper::currMembOrPending($userId);
        $nextMembership = UserPermissionHelper::nextMembership($userId);

        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();
        
        $selectedPackage = Package::find($request->package_id);
        
        // if the user has a next package to activate & selected package is 'lifetime' package
        if (!empty($nextMembership) && $selectedPackage->term == 'lifetime') {
            Session::flash('membership_warning', 'To add a Lifetime package as Current Package, You have to remove the next package');
            return back();
        }

        // expire the current package
        $currMembership->expire_date = Carbon::parse(Carbon::now()->subDay()->format('d-m-Y'));
        $currMembership->modified = 1;
        if ($currMembership->status == 0) {
            $currMembership->status = 2;
        }
        $currMembership->save();

        // calculate expire date for selected package
        if ($selectedPackage->term == 'monthly') {
            $exDate = Carbon::now()->addMonth()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'yearly') {
            $exDate = Carbon::now()->addYear()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'lifetime') {
            $exDate = Carbon::maxValue()->format('d-m-Y');
        }
        // store a new membership for selected package
        $selectedMemb = Membership::create([
            'price' => $selectedPackage->price,
            'currency' => $be->base_currency_text,
            'currency_symbol' => $be->base_currency_symbol,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid(),
            'status' => 1,
            'receipt' => NULL,
            'transaction_details' => NULL,
            'settings' => json_encode($be),
            'package_id' => $selectedPackage->id,
            'user_id' => $userId,
            'start_date' => Carbon::parse(Carbon::now()->format('d-m-Y')),
            'expire_date' => Carbon::parse($exDate),
            'is_trial' => 0,
            'trial_days' => 0,
        ]);
        
        $features = json_decode($selectedPackage->features, true);
        $features[] = "Contact";
        UserPermission::where('user_id', $user->id)->update([
            'package_id' => $request['package_id'],
            'user_id' => $user->id,
            'permissions' => json_encode($features)
        ]);

        // if the user has a next package to activate & selected package is not 'lifetime' package
        if (!empty($nextMembership) && $selectedPackage->term != 'lifetime') {
            $nextPackage = Package::find($nextMembership->package_id);

            // calculate & store next membership's start_date
            $nextMembership->start_date = Carbon::parse(Carbon::parse($exDate)->addDay()->format('d-m-Y'));

            // calculate & store expire date for next membership
            if ($nextPackage->term == 'monthly') {
                $exDate = Carbon::parse(Carbon::parse(Carbon::parse($exDate)->addDay()->format('d-m-Y'))->addMonth()->format('d-m-Y'));
            } elseif ($nextPackage->term == 'yearly') {
                $exDate = Carbon::parse(Carbon::parse(Carbon::parse($exDate)->addDay()->format('d-m-Y'))->addYear()->format('d-m-Y'));
            } else {
                $exDate = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
            }
            $nextMembership->expire_date = $exDate;
            $nextMembership->save();
        } 
        

        $currentPackage = Package::select('title')->findOrFail($currMembership->package_id);
        $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_changed_current_package', $currentPackage->title);


        Session::flash('success', 'Current Package changed successfully!');
        return back();
    }

    public function addCurrPackage(Request $request) {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();
        
        $selectedPackage = Package::find($request->package_id);

        // calculate expire date for selected package
        if ($selectedPackage->term == 'monthly') {
            $exDate = Carbon::now()->addMonth()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'yearly') {
            $exDate = Carbon::now()->addYear()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'lifetime') {
            $exDate = Carbon::maxValue()->format('d-m-Y');
        }
        // store a new membership for selected package
        $selectedMemb = Membership::create([
            'price' => $selectedPackage->price,
            'currency' => $be->base_currency_text,
            'currency_symbol' => $be->base_currency_symbol,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid(),
            'status' => 1,
            'receipt' => NULL,
            'transaction_details' => NULL,
            'settings' => json_encode($be),
            'package_id' => $selectedPackage->id,
            'user_id' => $userId,
            'start_date' => Carbon::parse(Carbon::now()->format('d-m-Y')),
            'expire_date' => Carbon::parse($exDate),
            'is_trial' => 0,
            'trial_days' => 0,
        ]);

        $features = json_decode($selectedPackage->features, true);
        $features[] = "Contact";
        UserPermission::where('user_id', $user->id)->update([
            'package_id' => $request['package_id'],
            'user_id' => $user->id,
            'permissions' => json_encode($features)
        ]);

        $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_added_current_package');

        Session::flash('success', 'Current Package has been added successfully!');
        return back();
    }

    public function removeNextPackage(Request $request) {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $be = BasicExtended::first();
        $bs = BasicSetting::select('website_title')->first();
        $nextMembership = UserPermissionHelper::nextMembership($userId);
        // set the start_date to unlimited
        $nextMembership->start_date = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
        $nextMembership->modified = 1;
        $nextMembership->save();

        $nextPackage = Package::select('title')->findOrFail($nextMembership->package_id);


        $this->sendMail(NULL, NULL, $request->payment_method, $user, $bs, $be, 'admin_removed_next_package', NULL, $nextPackage->title);

        Session::flash('success', 'Next Package removed successfully!');
        return back();
    }

    public function changeNextPackage(Request $request) {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        $bs = BasicSetting::select('website_title')->first();
        $be = BasicExtended::first();
        $nextMembership = UserPermissionHelper::nextMembership($userId);
        $nextPackage = Package::find($nextMembership->package_id);
        $selectedPackage = Package::find($request->package_id);
        
        $prevStartDate = $nextMembership->start_date;
        // set the start_date to unlimited
        $nextMembership->start_date = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
        $nextMembership->modified = 1;
        $nextMembership->save();

        // calculate expire date for selected package
        if ($selectedPackage->term == 'monthly') {
            $exDate = Carbon::parse($prevStartDate)->addMonth()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'yearly') {
            $exDate = Carbon::parse($prevStartDate)->addYear()->format('d-m-Y');
        } elseif ($selectedPackage->term == 'lifetime') {
            $exDate = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
        }

        // store a new membership for selected package
        $selectedMemb = Membership::create([
            'price' => $selectedPackage->price,
            'currency' => $be->base_currency_text,
            'currency_symbol' => $be->base_currency_symbol,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid(),
            'status' => 1,
            'receipt' => NULL,
            'transaction_details' => NULL,
            'settings' => json_encode($be),
            'package_id' => $selectedPackage->id,
            'user_id' => $userId,
            'start_date' => Carbon::parse($prevStartDate),
            'expire_date' => Carbon::parse($exDate),
            'is_trial' => 0,
            'trial_days' => 0,
        ]);

        $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_changed_next_package', $nextPackage->title);

        Session::flash('success', 'Next Package changed successfully!');
        return back();
    }

    public function addNextPackage(Request $request) {
        $userId = $request->user_id;

        $hasPendingMemb = UserPermissionHelper::hasPendingMembership($userId);
        if($hasPendingMemb) {
            Session::flash('membership_warning', 'This user already has a Pending Package. Please take an action (change / remove / approve / reject) for that package first.');
            return back();
        }

        $currMembership = UserPermissionHelper::userPackage($userId);
        $currPackage = Package::find($currMembership->package_id);
        $be = BasicExtended::first();
        $user = User::findOrFail($userId);
        $bs = BasicSetting::select('website_title')->first();
        
        $selectedPackage = Package::find($request->package_id);

        if ($currMembership->is_trial == 1) {
            Session::flash('membership_warning', 'If your current package is trial package, then you have to change / remove the current package first.');
            return back();
        }


        // if current package is not lifetime package
        if ($currPackage->term != 'lifetime') {
            // calculate expire date for selected package
            if ($selectedPackage->term == 'monthly') {
                $exDate = Carbon::parse($currMembership->expire_date)->addDay()->addMonth()->format('d-m-Y');
            } elseif ($selectedPackage->term == 'yearly') {
                $exDate = Carbon::parse($currMembership->expire_date)->addDay()->addYear()->format('d-m-Y');
            } elseif ($selectedPackage->term == 'lifetime') {
                $exDate = Carbon::parse(Carbon::maxValue()->format('d-m-Y'));
            }
            // store a new membership for selected package
            $selectedMemb = Membership::create([
                'price' => $selectedPackage->price,
                'currency' => $be->base_currency_text,
                'currency_symbol' => $be->base_currency_symbol,
                'payment_method' => $request->payment_method,
                'transaction_id' => uniqid(),
                'status' => 1,
                'receipt' => NULL,
                'transaction_details' => NULL,
                'settings' => json_encode($be),
                'package_id' => $selectedPackage->id,
                'user_id' => $userId,
                'start_date' => Carbon::parse(Carbon::parse($currMembership->expire_date)->addDay()->format('d-m-Y')),
                'expire_date' => Carbon::parse($exDate),
                'is_trial' => 0,
                'trial_days' => 0,
            ]);

            $this->sendMail($selectedMemb, $selectedPackage, $request->payment_method, $user, $bs, $be, 'admin_added_next_package');
        } else {
            Session::flash('membership_warning', 'If your current package is lifetime package, then you have to change / remove the current package first.');
            return back();
        }


        Session::flash('success', 'Next Package has been added successfully!');
        return back();
    }

    public function userTemplate(Request $request)
    {
        if ($request->template == 1) {
            $prevImg = $request->file('preview_image');
            $allowedExts = array('jpg', 'png', 'jpeg');

            $rules = [
                'serial_number' => 'required|integer',
                'preview_image' => [
                    'required',
                    function ($attribute, $value, $fail) use ($prevImg, $allowedExts) {
                        if (!empty($prevImg)) {
                            $ext = $prevImg->getClientOriginalExtension();
                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg image is allowed");
                            }
                        }
                    },
                ]
            ];


            $request->validate($rules);
        }

        $user = User::where('id', $request->user_id)->first();

        if ($request->template == 1) {
            if ($request->hasFile('preview_image')) {
                @unlink(public_path('assets/front/img/template-previews/' . $user->template_img));
                $filename = uniqid() . '.' . $prevImg->getClientOriginalExtension();
                $dir = public_path('assets/front/img/template-previews/');
                @mkdir($dir, 0775, true);
                $request->file('preview_image')->move($dir, $filename);
                $user->template_img = $filename;
            }
            $user->template_serial_number = $request->serial_number;
        } else {
            @unlink(public_path('assets/front/img/template-previews/' . $user->template_img));
            $user->template_img = NULL;
            $user->template_serial_number = 0;
        }
        $user->preview_template = $request->template;
        $user->save();
        Session::flash('success', 'Status updated successfully!');
        return back();
    }

    public function userUpdateTemplate(Request $request)
    {
        $prevImg = $request->file('preview_image');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'serial_number' => 'required|integer',
            'preview_image' => [
                function ($attribute, $value, $fail) use ($prevImg, $allowedExts) {
                    if (!empty($prevImg)) {
                        $ext = $prevImg->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ]
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $user = User::where('id', $request->user_id)->first();


        if ($request->hasFile('preview_image')) {
            @unlink(public_path('assets/front/img/template-previews/' . $user->template_img));
            $filename = uniqid() . '.' . $prevImg->getClientOriginalExtension();
            $dir = public_path('assets/front/img/template-previews/');
            @mkdir($dir, 0775, true);
            $request->file('preview_image')->move($dir, $filename);
            $user->template_img = $filename;
        }
        $user->template_serial_number = $request->serial_number;
        $user->save();


        Session::flash('success', 'Status updated successfully!');
        return "success";
    }
}
