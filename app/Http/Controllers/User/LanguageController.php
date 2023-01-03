<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\Curriculum\Course;
use App\Models\User\Curriculum\CourseInformation;
use App\Models\User\Curriculum\Lesson;
use App\Models\User\Curriculum\Module;
use App\Models\User\CustomPage\Page;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\Journal\Blog;
use App\Models\User\Journal\BlogInformation;
use App\Models\User\Language;
use App\Models\User\PageHeading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class LanguageController extends Controller
{
    public function index($lang = false)
    {
        $data['languages'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        return view('user.language.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'code' => ['required',
                function ($attribute, $value, $fail) {
                    $language = Language::where([
                        ['code', $value],
                        ['user_id', Auth::guard('web')->user()->id]
                    ])->get();
                    if ($language->count() > 0) {
                        $fail(':attribute already taken');
                    }
                },
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $deLang = Language::first();

        $in['name'] = $request->name;
        $in['code'] = $request->code;
        $in['rtl'] = $request->direction;
        $in['keywords'] = $deLang->keywords;
        $in['user_id'] = Auth::guard('web')->user()->id;
        $defaultLang = Language::query()->where([
            ['is_default', 1],
            ['user_id', Auth::guard('web')->user()->id]
        ]);
        if ($defaultLang->count() > 0) {
            $in['is_default'] = 0;
        } else {
            $in['is_default'] = 1;
        }
        $pageHeading = PageHeading::query()->where('user_id', Auth::guard('web')->user()->id)->where('language_id', $defaultLang->first()->id)->first()->toArray();
        unset($pageHeading['id']);
        $language = Language::create($in);
        array_walk($pageHeading, function (&$value, $key) use ($language) {
            if($key == 'language_id'){
                $value = $language->id;
            }
        });
        PageHeading::create($pageHeading);

        $menu = new Menu;
        $menu->user_id = Auth::guard('web')->user()->id;
        $menu->language_id = $language->id;
        $menu->menus = '[{"text":"Home","href":"","icon":"empty","target":"_self","title":"","type":"home"},{"type":"courses","text":"Courses","href":"","target":"_self"},{"type":"instructors","text":"Instructors","href":"","target":"_self"},{"type":"faq","text":"FAQ","href":"","target":"_self"},{"type":"contact","text":"Contact","href":"","target":"_self"}]';
        $menu->save();

        Session::flash('success', 'Language added successfully!');
        return "success";
    }

    public function edit($id)
    {
        if ($id > 0) {
            $data['language'] = Language::where('user_id', Auth::guard('web')->user()->id)->where('id', $id)->firstOrFail();
        }
        $data['id'] = $id;
        return view('user.language.edit', $data);
    }


    public function update(Request $request)
    {
        $language = Language::query()
            ->where('user_id', Auth::guard('web')->user()->id)
            ->where('id', $request->language_id)
            ->firstOrFail();

        $rules = [
            'name' => 'required|max:255',
            'code' => [
                'required',
                'max:255',
                Rule::unique('user_languages')->ignore($language->id),
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = $request->direction;
        $language->user_id = Auth::guard('web')->user()->id;
        $language->save();

        Session::flash('success', 'Language updated successfully!');
        return "success";
    }

    public function editKeyword($id)
    {
        $data['la'] = Language::where('user_id', Auth::guard('web')->user()->id)->where('id', $id)->firstOrFail();
        $data['keywords'] = json_decode($data['la']->keywords, true);
        return view('user.language.edit-keyword', $data);
    }

    public function updateKeyword(Request $request, $id)
    {
        $lang = Language::query()->where('user_id', Auth::guard('web')->user()->id)->where('id', $id)->firstOrFail();
        $keywords = $request->except('_token');
        $lang->keywords = json_encode($keywords);
        $lang->save();
        return back()->with('success', 'Keywords Updated Successfully');
    }


    public function delete($id)
    {
        $language = Language::query()
            ->where('user_id', Auth::guard('web')->user()->id)
            ->where('id', $id)
            ->firstOrFail();
        $bss = BasicSetting::query()
            ->where('user_id',Auth::guard('web')->user()->id)
            ->select('aws_access_key_id','aws_secret_access_key','aws_default_region','aws_bucket')
            ->first();

        if ($language->is_default == 1) {
            return back()->with('warning', 'Default language cannot be deleted!');
        }
        if (session()->get('user_lang') == $language->code) {
            session()->forget('user_lang');
        }

        /**
         * delete 'about us section' info
         */
        $aboutUsSec = $language->aboutUsSection()->first();

        if (!empty($aboutUsSec)) {
            Uploader::remove(Constant::WEBSITE_ABOUT_US_SECTION_IMAGE,$aboutUsSec->image,$bss);
            $aboutUsSec->delete();
        }

        /**
         * delete 'action section' info
         */
        $actionSec = $language->actionSection()->first();

        if (!empty($actionSec)) {
            Uploader::remove(Constant::WEBSITE_ACTION_SECTION_IMAGE,$actionSec->background_image,$bss);
            Uploader::remove(Constant::WEBSITE_ACTION_SECTION_IMAGE,$actionSec->image,$bss);
            $actionSec->delete();
        }

        /**
         * delete 'blog infos'
         */
        $blogInfos = $language->blogInformation()->get();

        if (count($blogInfos) > 0) {
            foreach ($blogInfos as $blogData) {
                $blogInfo = $blogData;
                $blogData->delete();

                // delete the blog if, this blog does not contain any other blog information in any other language
                $otherBlogInfos = BlogInformation::query()
                    ->where('language_id', '<>', $language->id)
                    ->where('user_id','=', Auth::guard('web')->user()->id)
                    ->where('blog_id', '=', $blogInfo->blog_id)
                    ->get();

                if (count($otherBlogInfos) == 0) {
                    $blog = Blog::query()->where('user_id', Auth::guard('web')->user()->id)->find($blogInfo->blog_id);
                    Uploader::remove(Constant::WEBSITE_BLOG_IMAGE,$blog->image,$bss);
                    $blog->delete();
                }
            }
        }

        /**
         * delete 'blog categories' info
         */
        $blogCategories = $language->blogCategory()->get();

        if (count($blogCategories) > 0) {
            foreach ($blogCategories as $blogCategory) {
                $blogCategory->delete();
            }
        }

        /**
         * delete 'cookie alert' info
         */
        $cookieAlert = $language->cookieAlertInfo()->first();

        if (!empty($cookieAlert)) {
            $cookieAlert->delete();
        }

        /**
         * delete 'counter infos'
         */
        $counterInfos = $language->countInfo()->get();

        if (count($counterInfos) > 0) {
            foreach ($counterInfos as $counterInfo) {
                $counterInfo->delete();
            }
        }

        /**
         * delete 'course infos'
         */
        $courseInfos = $language->courseInformation()->where('user_id', Auth::guard('web')->user()->id)->get();

        if (count($courseInfos) > 0) {
            foreach ($courseInfos as $courseData) {
                $courseInfo = $courseData;

                // get all 'modules' of each course-info & delete them
                $modules = Module::query()
                    ->where('user_id', Auth::guard('web')->user()->id)
                    ->where('course_information_id',$courseInfo->id)
                    ->get();

                if (count($modules) > 0) {
                    foreach ($modules as $module) {
                        // get all 'lessons' of each module & delete them
                        $lessons = Lesson::query()
                            ->where('user_id', Auth::guard('web')->user()->id)
                            ->where('module_id',$module->id)
                            ->get();

                        if (count($lessons) > 0) {
                            foreach ($lessons as $lesson) {
                                // get all 'lesson contents' of each lesson & delete them by checking the 'type'
                                $lessonContents = $lesson->content()->get();
                                if (count($lessonContents) > 0) {
                                    foreach ($lessonContents as $lessonContent) {
                                        if ($lessonContent->type == 'video') {
                                            Uploader::remove(Constant::WEBSITE_LESSON_CONTENT_VIDEO,$lessonContent->video_unique_name,$bss);
                                        } else if ($lessonContent->type == 'file') {
                                            Uploader::remove(Constant::WEBSITE_LESSON_CONTENT_FILE,$lessonContent->file_unique_name,$bss);
                                        } else if ($lessonContent->type == 'quiz') {
                                            // get all 'lesson quizzes' of this lesson-content & delete them
                                            $lessonQuizzes = $lessonContent->quiz()->get();

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
                $courseFaqs = $language->courseFaq()->where('course_id', '=', $courseInfo->course_id)->get();

                if (count($courseFaqs) > 0) {
                    foreach ($courseFaqs as $courseFaq) {
                        $courseFaq->delete();
                    }
                }

                // delete the course if, this course does not contain any other course information in any other language
                $otherCourseInfos = CourseInformation::query()
                    ->where('user_id', Auth::guard('web')->user()->id)
                    ->where('language_id', '<>', $language->id)
                    ->where('course_id', '=', $courseInfo->course_id)
                    ->get();

                if (count($otherCourseInfos) == 0) {
                    $course = Course::query()
                        ->where('user_id', Auth::guard('web')->user()->id)
                        ->find($courseInfo->course_id);

                    // get all the 'course enrolments' of this course & delete them
                    $enrolments = $course->enrolment()->get();

                    if (count($enrolments) > 0) {
                        foreach ($enrolments as $enrolment) {
                            Uploader::remove(Constant::WEBSITE_ENROLLMENT_ATTACHMENT, $enrolment->attachment,$bss);
                            Uploader::remove(Constant::WEBSITE_ENROLLMENT_INVOICE, $enrolment->invoice,$bss);
                            $enrolment->delete();
                        }
                    }

                    // get all the 'reviews' of this course & delete them
                    $reviews = $course->review()->get();

                    if (count($reviews) > 0) {
                        foreach ($reviews as $review) {
                            $review->delete();
                        }
                    }

                    // get all the 'quiz scores' of this course & delete them
                    $quizScores = $course->quizScore()->get();

                    if (count($quizScores) > 0) {
                        foreach ($quizScores as $quizScore) {
                            $quizScore->delete();
                        }
                    }
                    Uploader::remove(Constant::WEBSITE_COURSE_THUMBNAIL_IMAGE,$course->thumbnail_image,$bss);
                    Uploader::remove(Constant::WEBSITE_COURSE_COVER_IMAGE,$course->cover_image,$bss);
                    // finally, delete the course
                    $course->delete();
                }
            }
        }

        /**
         * delete 'course categories' info
         */
        $courseCategories = $language->courseCategory()->get();

        if (count($courseCategories) > 0) {
            foreach ($courseCategories as $courseCategory) {
                $courseCategory->delete();
            }
        }

        /**
         * delete 'faqs' info
         */
        $faqs = $language->faqs()->get();

        if (count($faqs) > 0) {
            foreach ($faqs as $faq) {
                $faq->delete();
            }
        }

        /**
         * delete 'features' info
         */
        $features = $language->features()->get();

        if (count($features) > 0) {
            foreach ($features as $feature) {
                $feature->delete();
            }
        }

        /**
         * delete 'footer content' info
         */
        $footerContent = $language->footer_texts()->first();

        if (!empty($footerContent)) {
            $footerContent->delete();
        }

        /**
         * delete 'footer quick links' info
         */
        $footerQuickLinks = $language->quick_links()->get();

        if (count($footerQuickLinks) > 0) {
            foreach ($footerQuickLinks as $footerQuickLink){
                $footerQuickLink->delete();
            }
        }

        /**
         * delete 'fun fact section' info
         */
        $funFactSec = $language->funFactSection()->first();

        if (!empty($funFactSec)) {
            Uploader::remove(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE,$funFactSec->background_image,$bss);
            $funFactSec->delete();
        }

        /**
         * delete 'hero section' info
         */
        $heroSec = $language->heroSection()->first();

        if (!empty($heroSec)) {
            Uploader::remove(Constant::WEBSITE_HERO_SECTION_IMAGE, $heroSec->background_image,$bss);
            Uploader::remove(Constant::WEBSITE_HERO_SECTION_IMAGE, $heroSec->image,$bss);
            $heroSec->delete();
        }

        /**
         * delete 'instructors' info
         */
        $instructors = $language->instructor()->get();

        if (count($instructors) > 0) {
            foreach ($instructors as $instructor) {
                // delete all 'social links' of each instructor
                $socialLinks = $instructor->socialPlatform()->get();

                if (count($socialLinks) > 0) {
                    foreach ($socialLinks as $socialLink) {
                        $socialLink->delete();
                    }
                }
                Uploader::remove(Constant::WEBSITE_INSTRUCTOR_IMAGE, $instructor->image,$bss);
                $instructor->delete();
            }
        }

        /**
         * delete 'menu builders' info
         */
        $menuInfo = $language->menus()->first();
        if (!empty($menuInfo)) {
            $menuInfo->delete();
        }

        /**
         * delete 'newsletter section' info
         */
        $newsletterSec = $language->newsletterSection()->first();

        if (!empty($newsletterSec)) {
            Uploader::remove(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $newsletterSec->background_image,$bss);
            Uploader::remove(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $newsletterSec->image,$bss);
            $newsletterSec->delete();
        }

        /**
         * delete 'page contents'
         */
        $customPageInfos = $language->customPageInfo()->get();

        if (count($customPageInfos) > 0) {
            foreach ($customPageInfos as $customPageData) {
                $customPageInfo = $customPageData;
                $customPageData->delete();

                // delete the 'custom page' if, this page does not contain any other page content in any other language
                $otherPageContents = PageContent::query()
                    ->where('user_id', Auth::guard('web')->user()->id)
                    ->where('language_id', '<>', $language->id)
                    ->where('page_id', '=', $customPageInfo->page_id)
                    ->get();

                if (count($otherPageContents) == 0) {
                    $page = Page::query()->where('user_id', Auth::guard('web')->user()->id)->find($customPageInfo->page_id);
                    $page->delete();
                }
            }
        }

        /**
         * delete 'page heading' info
         */
        $pageHeadingInfo = $language->pageName()->first();
        if (!empty($pageHeadingInfo)) {
            $pageHeadingInfo->delete();
        }

        /**
         * delete 'popup' infos
         */
        $popups = $language->announcementPopup()->get();

        if (count($popups) > 0) {
            foreach ($popups as $popup) {
                Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE,$popup->image,$bss);
                $popup->delete();
            }
        }

        /**
         * delete 'section title' info
         */
        $sectionTitleInfo = $language->sectionTitle()->first();

        if (!empty($sectionTitleInfo)) {
            $sectionTitleInfo->delete();
        }

        /**
         * delete 'seo' info
         */
        $seoInfo = $language->seos()->first();

        if (!empty($seoInfo)) {
            $seoInfo->delete();
        }

        /**
         * delete 'testimonials'
         */
        $testimonials = $language->testimonials()->get();

        if (count($testimonials) > 0) {
            foreach ($testimonials as $testimonial) {
                Uploader::remove(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image,$bss);
                $testimonial->delete();
            }
        }

        /**
         * delete 'video section' info
         */
        $videoSec = $language->videoSection()->first();

        if (!empty($videoSec)) {
            Uploader::remove(Constant::WEBSITE_VIDEO_SECTION_IMAGE,$videoSec->image,$bss);
            $videoSec->delete();
        }

        // if the deletable language is the currently selected language in frontend then forget the selected language from session
        session()->forget('lang');
        $language->delete();
        return back()->with('success', 'Language Delete Successfully');
    }

    public function default(Request $request, $id)
    {
        Language::query()->where('is_default', 1)->where('user_id', Auth::guard('web')->user()->id)->update(['is_default' => 0]);
        $lang = Language::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
        $lang->is_default = 1;
        $lang->save();
        return back()->with('success', $lang->name . ' language is set as default.');
    }

    public function rtlcheck($langid)
    {
        if ($langid > 0) {
            $lang = Language::query()
                ->where('user_id', Auth::guard('web')->user()->id)
                ->where('id', $langid)
                ->firstOrFail();
        } else {
            return 0;
        }
        return $lang->rtl;
    }
}
