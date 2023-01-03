<?php

namespace App\Http\Controllers\Front;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UserPermissionHelper;
use App\Http\Requests\UserProfileRequest;
use App\Models\Customer;
use App\Models\EmailTemplate;
use App\Models\User\Curriculum\Course;
use App\Models\User\Curriculum\CourseInformation;
use App\Models\User\Curriculum\Lesson;
use App\Models\User\Curriculum\LessonContent;
use App\Models\User\Curriculum\LessonQuiz;
use App\Models\User\Curriculum\Module;
use App\Models\User\Curriculum\QuizScore;
use App\Models\User\Language;
use App\Models\User;
use App\Models\User\BasicSetting;
use App\Models\User\BookmarkPost;
use App\Models\User\Curriculum\CourseEnrolment;
use App\Models\User\LessonComplete;
use App\Models\User\LessonContentComplete;
use App\Models\User\MailTemplate;
use App\Models\User\SEO;
use Config;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CustomerController extends Controller
{

    public function login(Request $request, $domain)
    {
        $user = getUser();

        $language = $this->getUserCurrentLanguage($user->id);
        $queryResult['pageHeading'] = $this->getUserPageHeading($language, $user->id);
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

        $queryResult['seoInfo'] = SEO::query()
            ->where('user_id', $user->id)
            ->select('login_meta_keywords', 'login_meta_description')
            ->first();

        // when user have to redirect to check out page after login.
        if ($request->input('redirectPath') == 'course_details') {
            $url = url()->previous();
        }

        // when user have to redirect to course details page after login.
        if (isset($url)) {
            $request->session()->put('redirectTo', $url);
        }
        return view('user-front.common.customer.auth.login', $queryResult);
    }

    public function loginSubmit(Request $request, $domain)
    {
        // at first, get the url from session which will be redirected after login
        if ($request->session()->has('redirectTo')) {
            $redirectURL = $request->session()->get('redirectTo');
        } else {
            $redirectURL = null;
        }

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // get the email and password which has provided by the user
        $credentials = $request->only('email', 'password', 'user_id');

        // login attempt
        if (Auth::guard('customer')->attempt($credentials)) {
            $authUser = Auth::guard('customer')->user();

            // first, check whether the user's email address verified or not
            if ($authUser->email_verified_at == null) {
                $request->session()->flash('error', 'Please, verify your email address.');

                // logout auth user as condition not satisfied
                Auth::guard('customer')->logout();

                return redirect()->back();
            }

            // second, check whether the user's account is active or not
            if ($authUser->status == 0) {
                $request->session()->flash('error', 'Sorry, your account has been deactivated.');

                // logout auth user as condition not satisfied
                Auth::guard('customer')->logout();

                return redirect()->back();
            }

            // otherwise, redirect auth user to next url
            if ($redirectURL == null) {
                return redirect()->route('customer.dashboard', getParam());
            } else {
                // before, redirect to next url forget the session value
                $request->session()->forget('redirectTo');

                return redirect($redirectURL);
            }
        } else {
            $request->session()->flash('error', 'The provided credentials do not match our records!');

            return redirect()->back();
        }
    }

    public function forgetPassword($domain)
    {
        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);
        $queryResult['seoInfo'] = SEO::query()
            ->where('user_id', $user->id)
            ->select('forget_password_meta_keywords', 'forget_password_meta_description')
            ->first();
        $queryResult['pageHeading'] = $this->getUserPageHeading($language, $user->id);
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);
        return view('user-front.common.customer.auth.forget-password', $queryResult);
    }
    public function sendMail(Request $request)
    {
        $user = getUser();

        $rules = [
            'email' => [
                'required',
                'email:rfc,dns',
                function ($attribute, $value, $fail) use ($request, $user) {
                    if (Customer::where('email', $request->email)->where('user_id', $user->id)->count() == 0) {
                        $fail('No record found for ' . $request->email);
                    }
                }
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('email', $request->email)->where('user_id', $user->id)->first();

        // first, get the mail template information from db
        $mailTemplate = MailTemplate::where('mail_type', 'reset_password')->where('user_id', $user->id)->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        // second, send a password reset link to user via email
        $be = DB::table('basic_extendeds')
            ->select('is_smtp', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();
        $userBs = BasicSetting::where('user_id', $user->id)->select('website_title', 'email', 'from_name')->first();

        $name = $customer->first_name . ' ' . $customer->last_name;

        $link = '<a href=' . route('customer.reset_password', getParam()) . '>Click Here</a>';

        $mailBody = str_replace('{customer_name}', $name, $mailBody);
        $mailBody = str_replace('{password_reset_link}', $link, $mailBody);
        $mailBody = str_replace('{website_title}', $userBs->website_title, $mailBody);

        // initialize a new mail
        $mail = new PHPMailer(true);

        // if smtp status == 1, then set some value for PHPMailer
        if ($be->is_smtp == 1) {
            $mail->isSMTP();
            $mail->Host       = $be->smtp_host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $be->smtp_username;
            $mail->Password   = $be->smtp_password;

            if ($be->encryption == 'TLS') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->Port = $be->smtp_port;
        }

        // finally, add other information and send the mail
        try {
            $mail->setFrom($be->from_mail, $userBs->from_name);
            $mail->addReplyTo($userBs->email, $userBs->from_name);
            $mail->addAddress($request->email);

            $mail->isHTML(true);
            $mail->Subject = $mailSubject;
            $mail->Body = $mailBody;

            $mail->send();

            $request->session()->flash('success', 'A mail has been sent to your email address.');
        } catch (Exception $e) {
            $request->session()->flash('error', 'Mail could not be sent!');
        }

        // store user email in session to use it later
        $request->session()->put('userEmail', $customer->email);

        return redirect()->back();
    }


    public function resetPassword($domain)
    {
        $user = getUser();
        return view('user-front.common.customer.auth.reset-password', ['bgImg' => $this->getUserBreadcrumb($user->id)]);
    }

    public function resetPasswordSubmit(Request $request, $domain)
    {
        $author = getUser();
        // get the user email from session
        $emailAddress = $request->session()->get('userEmail');

        $rules = [
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ];

        $messages = [
            'new_password.confirmed' => 'Password confirmation failed.',
            'new_password_confirmation.required' => 'The confirm new password field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = Customer::where('email', $emailAddress)->where('user_id', $author->id)->first();

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        $request->session()->flash('success', 'Password updated successfully.');

        return redirect()->route('customer.login', getParam());
    }

    public function signup($domain)
    {
        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);
        $queryResult['pageHeading'] = $this->getUserPageHeading($language, $user->id);
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);
        $queryResult['seoInfo'] = SEO::query()
            ->where('user_id', $user->id)
            ->select('sign_up_meta_keywords', 'sign_up_meta_description')
            ->first();
        return view('user-front.common.customer.auth.signup', $queryResult);
    }

    public function signupSubmit(Request $request, $domain)
    {
        $user = getUser();

        $rules = [
            'username' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($user) {
                    if (Customer::where('username', $value)->where('user_id', $user->id)->count() > 0) {
                        $fail('Username has already been taken');
                    }
                }
            ],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) use ($user) {
                if (Customer::where('email', $value)->where('user_id', $user->id)->count() > 0) {
                    $fail('Email has already been taken');
                }
            }],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = new Customer;
        $customer->username = $request->username;
        $customer->email = $request->email;
        $customer->user_id = $user->id;
        $customer->password = Hash::make($request->password);

        // first, generate a random string
        $randStr = Str::random(20);

        // second, generate a token
        $token = md5($randStr . $request->username . $request->email);

        $customer->verification_token = $token;
        $customer->save();

        // send a mail to user for verify his/her email address
        $this->sendVerificationMail($request, $token);

        return redirect()
            ->back()
            ->with('sendmail', 'We need to verify your email address. We have sent an email to  ' . $request->email . ' to verify your email address. Please click link in that email to continue.');
    }

    public function sendVerificationMail(Request $request, $token)
    {
        $user = getUser();
        $userId = $user->id;

        // first get the mail template information from db
        $mailTemplate = MailTemplate::where('mail_type', 'verify_email')->where('user_id', $userId)->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        // second get the website title & mail's smtp information from db
        $be = DB::table('basic_extendeds')
            ->select('is_smtp', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();
        $userBs = DB::table('user_basic_settings')
            ->select('website_title', 'email', 'from_name')->where('user_id', $userId)
            ->first();

        $link = '<a href=' . route('customer.signup.verify', ['token' => $token, getParam()]) . '>Click Here</a>';

        // replace template's curly-brace string with actual data
        $mailBody = str_replace('{username}', $request->username, $mailBody);
        $mailBody = str_replace('{verification_link}', $link, $mailBody);
        $mailBody = str_replace('{website_title}', $userBs->website_title, $mailBody);


        // initialize a new mail
        $mail = new PHPMailer(true);

        // if smtp status == 1, then set some value for PHPMailer
        if ($be->is_smtp == 1) {
            $mail->isSMTP();
            $mail->Host       = $be->smtp_host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $be->smtp_username;
            $mail->Password   = $be->smtp_password;

            if ($be->encryption == 'TLS') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->Port = $be->smtp_port;
        }

        // finally, add other information and send the mail
        try {
            $mail->setFrom($be->from_mail, $userBs->from_name);
            $replyMail = $userBs->email ?? $user->email;
            $fromName = $userBs->from_name ?? $user->username;
            $mail->addReplyTo($replyMail, $fromName);
            $mail->addAddress($request->email);

            $mail->isHTML(true);
            $mail->Subject = $mailSubject;
            $mail->Body = $mailBody;

            $mail->send();

            $request->session()->flash('success', 'A verification mail has been sent to your email address.');
        } catch (Exception $e) {
            $request->session()->flash('error', 'Mail could not be sent!');
        }
    }

    public function signupVerify(Request $request, $domain, $token)
    {
        try {
            $user = Customer::where('verification_token', $token)->firstOrFail();
            // after verify user email, put "null" in the "verification token"
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s'),
                'status' => 1,
                'verification_token' => null
            ]);

            $request->session()->flash('success', 'Your email has verified.');

            // after email verification, authenticate this user
            Auth::guard('customer')->login($user);

            return redirect()->route('customer.dashboard', getParam());
        } catch (ModelNotFoundException $e) {
            $request->session()->flash('error', 'Could not verify your email!');
            return redirect()->route('customer.signup', getParam());
        }
    }

    public function redirectToDashboard($domain)
    {
        $author = getUser();

        $queryResult['bgImg'] = $this->getUserBreadcrumb($author->id);

        $user = Auth::guard('customer')->user();

        $queryResult['authUser'] = $user;

        return view('user-front.common.customer.dashboard', $queryResult);
    }

    public function editProfile($domain)
    {
        $user = getUser();
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);
        $queryResult['authUser'] = Auth::guard('customer')->user();
        return view('user-front.common.customer.edit-profile', $queryResult);
    }

    public function updateProfile(UserProfileRequest $request, $domain)
    {
        $user = getUser();
        $authUser = Auth::guard('customer')->user();
        $filename = $authUser->image;
        $directory = Constant::WEBSITE_TENANT_CUSTOMER_IMAGE . '/' . $user->id;
        if ($request->hasFile('image')) {
            $filename = Uploader::update_picture($directory, $request->file('image'), $authUser->image, $user->id);
        }
        $authUser->update($request->except('image', 'edit_profile_status') + [
            'image' => $filename,
            'edit_profile_status' => 1
        ]);
        $request->session()->flash('success', 'Your profile updated successfully.');
        return redirect()->back();
    }

    public function myCourses($domain)
    {
        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

        $customer = Auth::guard('customer')->user();

        $enrols = $customer->courseEnrolment()->where(function ($query) {
            $query->where('payment_status', 'completed')
                  ->orWhere('payment_status', 'free');
        })->where('user_id', $user->id)->orderByDesc('id')->get();

        $enrols->map(function ($enrol) use ($language, $user) {
            $course = $enrol->course()->where('user_id', $user->id)->first();
            $courseInfo = $course->courseInformation()->where('language_id', $language->id)->where('user_id', $user->id)->first();

            if (empty($courseInfo)) {
                $language = Language::where('is_default', 1)->where('user_id', $user->id)->first();
                $courseInfo = $course->courseInformation()->where('language_id', $language->id)->where('user_id', $user->id)->first();
            }

            $enrol['title'] = CourseInformation::query()->where('language_id', '=', $language->id)
                ->where('user_id', $user->id)
                ->where('course_id', '=', $course->id)
                ->pluck('title')
                ->first();

            $enrol['slug'] = CourseInformation::query()->where('language_id', '=', $language->id)
                ->where('user_id', $user->id)
                ->where('course_id', '=', $course->id)
                ->pluck('slug')
                ->first();

            $module = !empty($courseInfo) ? $courseInfo->module()->where('user_id', $user->id)->where('status', 'published')->first() : NULL;
            $lesson = !empty($module) ? $module->lesson()->where('user_id', $user->id)->where('status', 'published')->first() : NULL;
            $enrol['lesson_id'] = !empty($lesson) ? $lesson->id : NULL;
        });

        $queryResult['enrolments'] = $enrols;

        return view('user-front.common.customer.my-courses', $queryResult);
    }

    public function purchaseHistory()
    {
        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

        $customer = Auth::guard('customer')->user();

        $enrols = $customer->courseEnrolment()->orderByDesc('id')->get();

        $enrols->map(function ($enrol) use ($language) {
            $course = $enrol->course()->first();
            $courseInfo = $course->courseInformation()->where('language_id', $language->id)->first();

            if (empty($courseInfo)) {
                $language = Language::where('is_default', 1)->first();
                $courseInfo = $course->courseInformation()->where('language_id', $language->id)->first();
            }

            $enrol['title'] = $courseInfo->title;
            $enrol['slug'] = $courseInfo->slug;
        });

        $queryResult['allPurchase'] = $enrols;

        return view('user-front.common.customer.purchase-history', $queryResult);
    }

    public function curriculum(Request $request, $domain, $id)
    {
        if (!Auth::guard('customer')->check() && !Auth::guard('web')->check()) {
            return redirect()->route('customer.login', getParam());
        }

        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);

        if (Auth::guard('customer')->check()) {
            $enrolCount = CourseEnrolment::where('customer_id', Auth::guard('customer')->user()->id)->where('course_id', $id)->where('user_id', $user->id)->count();
            if ($enrolCount == 0) {
                return redirect()->route('customer.my_courses', getParam());
            }
        }

        $course = Course::find($id);
        $queryResult['certificateStatus'] = $course->certificate_status;

        $courseInfo = $course->courseInformation()->where('language_id', $language->id)->first();
        if (empty($courseInfo)) {
            $language = Language::where('is_default', 1)->first();
            $courseInfo = $course->courseInformation()->where('language_id', $language->id)->first();
        }
        $queryResult['courseTitle'] = $courseInfo->title;

        $modules = $courseInfo->module()->where('status', 'published')->orderBy('serial_number', 'asc')->get();

        $lessonId = $request['lesson_id'];

        // put lesson id into session to use it in middleware
        $request->session()->put('lessonId', $lessonId);

        $lesson = Lesson::find($lessonId);

        if (!empty($lesson)) {
            $queryResult['lessonTitle'] = $lesson->title;
            $queryResult['lessonContents'] = $lesson->content()->orderBy('order_no', 'asc')->get();

            $queryResult['quizzes'] = $lesson->quiz()->get();
        }

        // update lesson completion status
        $lessonCompleted = false;

        // when certificate system is enabled then execute this code
        if (!empty($lesson)) {
            if ($course->certificate_status == 1) {
                $totalVideo = $lesson->content()->where('type', 'video')->count();
                $totalQuiz = $lesson->content()->where('type', 'quiz')->count();

                if ($course->video_watching == 0 && ($totalVideo > 0 && $totalQuiz == 0)) {
                    // if video watching disabled and, lesson has only video then complete the lesson
                    $lessonCompleted = true;
                } else if ($course->quiz_completion == 0 && ($totalQuiz > 0 && $totalVideo == 0)) {
                    // if quiz completion disabled and, lesson has only quiz then complete the lesson
                    $lessonCompleted = true;
                } else if (($course->video_watching == 0 && $course->quiz_completion == 0) && ($totalVideo > 0 && $totalQuiz > 0)) {
                    // if both video watching & quiz completion disabled and, lesson has both video & quiz then complete the lesson
                    $lessonCompleted = true;
                } else if ($totalVideo == 0 && $totalQuiz == 0) {
                    // if lesson does not have both video & quiz then complete the lesson
                    $lessonCompleted = true;
                }
            } else {
                // when certificate system is disabled then execute this code
                $lessonCompleted = true;
            }

            if (Auth::guard('customer')->check() && $lessonCompleted == true) {
                $lcCount = LessonComplete::where('customer_id', Auth::guard('customer')->user()->id)->where('lesson_id', $lessonId)->count();
                if ($lcCount == 0) {
                    $lc = new LessonComplete();
                    $lc->user_id = $user->id;
                    $lc->customer_id = Auth::guard('customer')->user()->id;
                    $lc->lesson_id = $lessonId;
                    $lc->save();
                }
            }
        }

        $modules->map(function ($module) {
            $module['lessons'] = $module->lesson()->where('status', 'published')->orderBy('serial_number', 'asc')->get();
        });

        $queryResult['modules'] = $modules;

        return view('user-front.common.customer.course-curriculum', $queryResult);
    }
    public function downloadFile(Request $request, $domain, $id)
    {
        $user = getUser();
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->first();
        $content = LessonContent::query()
            ->where('user_id', $user->id)
            ->find($id);
        try {
            return Uploader::downloadFile(Constant::WEBSITE_LESSON_CONTENT_FILE, $content->file_unique_name, $content->file_original_name, $bs);
        } catch (FileNotFoundException $e) {
            $request->session()->flash('error', 'Sorry, this file does not exist anymore!');
            return redirect()->back();
        }
    }

    public function checkAns(Request $request, $domain)
    {
        $user = getUser();
        $id = $request['quizId'];
        $answers = $request['answers'];

        $quiz = LessonQuiz::query()
            ->where('user_id', $user->id)
            ->find($id);
        $qas = json_decode($quiz->answers);

        // find out how many right answer has been selected by admin
        $rightAnsCount = 0;

        foreach ($qas as $qa) {
            if ($qa->rightAnswer == 1) {
                $rightAnsCount++;
            }
        }

        // find out how many correct answer has been given by user
        $correctAnsCount = 0;

        foreach ($answers as $ans) {
            foreach ($qas as $qa) {
                if ($ans == $qa->option && $qa->rightAnswer == 1) {
                    $correctAnsCount++;
                }
            }
        }

        if (($rightAnsCount == $correctAnsCount) && (count($answers) == $rightAnsCount)) {
            return response()->json(['status' => 'Correct']);
        } else {
            return response()->json(['status' => 'Incorrect']);
        }
    }

    public function storeQuizScore(Request $request, $domain)
    {
        $user = getUser();
        $authUser = Auth::guard('customer')->user();
        $courseId = $request['courseId'];
        $lessonId = $request['lessonId'];

        QuizScore::updateOrCreate(
            [
                'user_id' => $user->id,
                'customer_id' => $authUser->id,
                'course_id' => $courseId,
                'lesson_id' => $lessonId
            ],
            ['score' => $request['score']]
        );

        return response()->json(['message' => 'Quiz score stored successfully.']);
    }

    public function contentCompletion(Request $request, $domain)
    {
        $user = getUser();
        $customer = Auth::guard('customer')->user();
        // update lesson-content completion status
        $id = $request['id'];

        $content = LessonContent::find($id);

        if ($content->type == 'video') {
            $lccCount1 = LessonContentComplete::where('customer_id', $customer->id)->where('lesson_id', $content->lesson_id)->where('lesson_content_id', $id)->where('type', 'video')->count();
            if ($lccCount1 == 0) {
                $lcc = new LessonContentComplete;
                $lcc->user_id = $user->id;
                $lcc->customer_id = $customer->id;
                $lcc->lesson_id = $content->lesson_id;
                $lcc->lesson_content_id = $id;
                $lcc->type = 'video';
                $lcc->save();
            }
        }

        // update lesson completion status
        $videoCompleted = false;
        $quizCompleted = false;
        $lessonCompleted = false;

        $courseId = (int)$request['courseId'];
        $course = Course::find($courseId);

        $lessonId = (int)$request['lessonId'];
        $lesson = Lesson::find($lessonId);

        // if video watching enabled then execute this code
        if ($course->video_watching == 1) {
            $totalVideo = $lesson->content()->where('type', 'video')->count();

            if ($totalVideo > 0) {
                $totalCompletedVideo = LessonContentComplete::where('lesson_id', $lessonId)->where('customer_id', $customer->id)->where('user_id', $user->id)->where('type', 'video')->count();

                if ($totalVideo <= $totalCompletedVideo) {
                    $videoCompleted = true;
                }
            } else {
                $videoCompleted = true;
            }
        }

        // if quiz completion enabled then execute this code
        if ($course->quiz_completion == 1) {
            $totalQuiz = $lesson->content()->where('type', 'quiz')->count();
            $quizScore = QuizScore::select('score')->where('course_id', $courseId)->where('lesson_id', $lessonId)->where('customer_id', $customer->id)->first();

            if ($totalQuiz > 0) {
                if (!empty($quizScore) && $quizScore->score >= $course->min_quiz_score) {
                    $quizCompleted = true;
                }
            } else {
                $quizCompleted = true;
            }

            if ($content->type == 'quiz' && $quizCompleted == true) {
                $lccCount2 = LessonContentComplete::where('customer_id', $customer->id)->where('lesson_id', $content->lesson_id)->where('lesson_content_id', $id)->where('type', 'quiz')->count();
                if ($lccCount2 == 0) {
                    $lcc  = new LessonContentComplete();
                    $lcc->user_id = $user->id;
                    $lcc->customer_id = $customer->id;
                    $lcc->lesson_id = $content->lesson_id;
                    $lcc->lesson_content_id = $id;
                    $lcc->type = 'quiz';
                    $lcc->save();
                }
            }
        }

        if (($course->video_watching == 1 && $course->quiz_completion == 0) && $videoCompleted == true) {
            // only video watching enabled, and watched all the videos
            $lessonCompleted = true;
        } else if (($course->video_watching == 0 && $course->quiz_completion == 1) && $quizCompleted == true) {
            // only quiz completion enabled, and passed the quizzes
            $lessonCompleted = true;
        } else if (($course->video_watching == 1 && $course->quiz_completion == 1) && ($videoCompleted == true && $quizCompleted == true)) {
            // both video watching & quiz completion enabled, and both is completed
            $lessonCompleted = true;
        } else if ($course->video_watching == 0 && $course->quiz_completion == 0) {
            // both video watching & quiz completion disabled
            $lessonCompleted = true;
        }

        if ($lessonCompleted == true) {
            $lcCount = LessonComplete::where('customer_id', $customer->id)->where('user_id', $user->id)->where('lesson_id', $lessonId)->count();
            if ($lcCount == 0) {
                $lc = new LessonComplete();
                $lc->user_id = $user->id;
                $lc->customer_id = $customer->id;
                $lc->lesson_id = $lessonId;
                $lc->save();
            }
        }

        return response()->json(['status' => 'Success', 'lessonCompleted' => $lessonCompleted, 'videoCompleted' => $videoCompleted], 200);
    }

    public function getCertificate($domain, $id)
    {
        $user = getUser();

        $courseCompleted = false;

        $language = $this->getUserCurrentLanguage($user->id);

        $course = Course::query()->where('user_id', $user->id)->find($id);
        $permissions = UserPermissionHelper::packagePermission($user->id);
        $permissions = json_decode($permissions, true);
        $queryResult['certificateStatus'] = $course->certificate_status;

        if ($course->certificate_status != 1 || (!empty($permissions) && !in_array('Course Completion Certificate', $permissions))) {
            return back();
        }

        $courseInfo = CourseInformation::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('language_id', $language->id)
            ->first();
        $modules = Module::query()
            ->where('course_information_id', $courseInfo->id)
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('serial_number', 'ASC')
            ->get();

        foreach ($modules as $module) {
            $lessons = Lesson::query()
                ->where('module_id', $module->id)
                ->where('status', 'published')
                ->orderBy('serial_number', 'ASC')
                ->get();

            foreach ($lessons as $lesson) {
                if ($lesson->lesson_complete()->where('customer_id', Auth::guard('customer')->user()->id)->count() > 0) {
                    $courseCompleted = true;
                } else {
                    $courseCompleted = false;
                    break 2;
                }
            }
        }

        if ($courseCompleted == true) {
            $queryResult['certificateTitle'] = $course->certificate_title;
            $certificateText = $course->certificate_text;

            // get student name
            $authUser = Auth::guard('customer')->user();
            $studentName = $authUser->first_name . ' ' . $authUser->last_name;

            // get course duration
            $duration = Carbon::parse($course->duration);
            $courseDuration = $duration->format('h') . ' hours';

            // get course title
            $courseTitle = $courseInfo->title;

            // get course completion date
            $date = Carbon::now();
            $completionDate = date_format($date, 'F d, Y');

            $certificateText = str_replace('{name}', $studentName, $certificateText);
            $certificateText = str_replace('{duration}', $courseDuration, $certificateText);
            $certificateText = str_replace('{title}', $courseTitle, $certificateText);
            $certificateText = str_replace('{date}', $completionDate, $certificateText);

            $queryResult['certificateText'] = $certificateText;

            $queryResult['instructorInfo'] = $courseInfo->instructorInfo()
                ->where('language_id', $language->id)
                ->where('user_id', $user->id)
                ->select('name', 'occupation')
                ->first();

            return view('user-front.common.customer.course-certificate', $queryResult);
        } else {
            return redirect()->back()->with('warning', 'You have to complete this course to get the certificate.');
        }
    }

    public function changePassword($domain)
    {
        return view('user-front.common.customer.change-password', ['bgImg' => $this->getUserBreadcrumb(getUser()->id)]);
    }

    public function updatePassword(Request $request, $domain)
    {
        $rules = [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('customer')->user()->password)) {
                        $fail('Your password was not updated, since the provided current password does not match.');
                    }
                }
            ],
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ];

        $messages = [
            'new_password.confirmed' => 'Password confirmation failed.',
            'new_password_confirmation.required' => 'The confirm new password field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = Auth::guard('customer')->user();

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        $request->session()->flash('success', 'Password updated successfully.');
        return redirect()->back();
    }

    public function logoutSubmit(Request $request, $domain)
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login', getParam());
    }
}
