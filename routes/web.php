<?php

use App\Http\Middleware\UserMaintenance;

$domain = env('WEBSITE_HOST');

if (!app()->runningInConsole()) {
    if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
        $domain = 'www.' . env('WEBSITE_HOST');
    }
}

Route::fallback(function () {
    return view('errors.404');
});

Route::get('/forget/coupon', function () {
    request()->session()->forget('discountedCourse');
    request()->session()->forget('discount');
    request()->session()->forget('discountedPrice');
});

// cron job for sending expiry mail
Route::get('/subcheck', 'CronJobController@expired')->name('cron.expired');

Route::domain($domain)->group(function () {
    Route::get('/changelanguage/{lang}', 'Front\FrontendController@changeLanguage')->name('changeLanguage');
    // cron job for sending expiry mail
    Route::get('/expired', 'CronJobController@expired')->name('cron.expired');
    Route::get('/expiry-reminder', 'CronJobController@expired')->name('cron.expired');

    Route::group(['middleware' => 'setlang'], function () {
        Route::get('/', 'Front\FrontendController@index')->name('front.index');

        Route::post('/subscribe', 'Front\FrontendController@subscribe')->name('front.subscribe');
        Route::get('/profile', 'Front\FrontendController@users')->name('front.user.view');
        // Route::get('/listings', 'Front\FrontendController@users')->name('front.user.view');
        Route::get('/contact', 'Front\FrontendController@contactView')->name('front.contact');
        Route::get('/faqs', 'Front\FrontendController@faqs')->name('front.faq.view');
        Route::get('/blogs', 'Front\FrontendController@blogs')->name('front.blogs');
        Route::get('/pricing', 'Front\FrontendController@pricing')->name('front.pricing');
        Route::get('/blog-details/{slug}/{id}', 'Front\FrontendController@blogdetails')->name('front.blogdetails');
        Route::get('/registration/step-1/{status}/{id}', 'Front\FrontendController@step1')->name('front.register.view');
        Route::get('/check/{username}/username', 'Front\FrontendController@checkUsername')->name('front.username.check');
        Route::get('/p/{slug}', 'Front\FrontendController@dynamicPage')->name('front.dynamicPage');
        Route::view('/success', 'front.success')->name('success.page');
    });


    Route::group(['middleware' => ['web', 'guest', 'setlang']], function () {
        Route::get('/registration/final-step', 'Front\FrontendController@step2')->name('front.registration.step2');
        Route::post('/checkout', 'Front\FrontendController@checkout')->name('front.checkout.view');

        Route::get('/login', 'User\Auth\LoginController@showLoginForm')->name('user.login');
        Route::post('/login', 'User\Auth\LoginController@login')->name('user.login.submit');
        Route::get('/register', 'User\Auth\RegisterController@registerPage')->name('user-register');
        Route::post('/register/submit', 'User\Auth\RegisterController@register')->name('user-register-submit');
        Route::get('/register/mode/{mode}/verify/{token}', 'User\Auth\RegisterController@token')->name('user-register-token');

        Route::post('/password/email', 'User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.forgot.password.submit');
        Route::get('/password/reset', 'User\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.forgot.password.form');
        Route::post('/password/reset', 'User\Auth\ResetPasswordController@reset')->name('user.reset.password.submit');
        Route::get('/password/reset/{token}/email/{email}', 'User\Auth\ResetPasswordController@showResetForm')->name('user.reset.password.form');

        Route::get('/forgot', 'User\ForgotController@showforgotform')->name('user-forgot');
        Route::post('/forgot', 'User\ForgotController@forgot')->name('user-forgot-submit');
    });


    /*=======================================================
    ******************** User Routes **********************
    =======================================================*/

    Route::group(['prefix' => 'user', 'middleware' => ['auth:web', 'userstatus']], function () {
        // instructor route start
        Route::get('/instructors', 'User\Teacher\InstructorController@index')->name('user.instructors');

        Route::get('/create-instructor', 'User\Teacher\InstructorController@create')->name('user.create_instructor');

        Route::post('/store-instructor', 'User\Teacher\InstructorController@store')->name('user.store_instructor');

        Route::post('/instructor/{id}/update-featured', 'User\Teacher\InstructorController@updateFeatured')->name('user.instructor.update_featured');

        Route::get('/edit-instructor/{id}', 'User\Teacher\InstructorController@edit')->name('user.edit_instructor');

        Route::post('/update-instructor/{id}', 'User\Teacher\InstructorController@update')->name('user.update_instructor');

        Route::prefix('/instructor')->group(function () {

            Route::get('/{id}/social-links', 'User\Teacher\SocialLinkController@links')->name('user.instructor.social_links');

            Route::post('/{id}/store-social-link', 'User\Teacher\SocialLinkController@storeLink')->name('user.instructor.store_social_link');

            Route::get('/{instructor_id}/edit-social-link/{id}', 'User\Teacher\SocialLinkController@editLink')->name('user.instructor.edit_social_link');

            Route::post('/update-social-link/{id}', 'User\Teacher\SocialLinkController@updateLink')->name('user.instructor.update_social_link');

            Route::post('/delete-social-link/{id}', 'User\Teacher\SocialLinkController@destroyLink')->name('user.instructor.delete_social_link');
        });

        Route::post('/delete-instructor/{id}', 'User\Teacher\InstructorController@destroy')->name('user.delete_instructor');

        Route::post('/bulk-delete-instructor', 'User\Teacher\InstructorController@bulkDestroy')->name('user.bulk_delete_instructor');

        // instructor route end

        // course management route start
        Route::prefix('/course-management')->group(function () {

            Route::get('/categories', 'User\Curriculum\CategoryController@index')->name('user.course_management.categories');

            Route::post('/store-category', 'User\Curriculum\CategoryController@store')->name('user.course_management.store_category');

            Route::post('/category/{id}/update-featured', 'User\Curriculum\CategoryController@updateFeatured')->name('user.course_management.category.update_featured');

            Route::put('/update-category', 'User\Curriculum\CategoryController@update')->name('user.course_management.update_category');

            Route::post('/delete-category/{id}', 'User\Curriculum\CategoryController@destroy')->name('user.course_management.delete_category');

            Route::post('/bulk-delete-category', 'User\Curriculum\CategoryController@bulkDestroy')->name('user.course_management.bulk_delete_category');

            Route::get('/courses', 'User\Curriculum\CourseController@index')->name('user.course_management.courses');

            Route::get('/create-course', 'User\Curriculum\CourseController@create')->name('user.course_management.create_course');

            Route::post('/store-course', 'User\Curriculum\CourseController@store')->name('user.course_management.store_course');

            Route::post('/course/{id}/update-status', 'User\Curriculum\CourseController@updateStatus')->name('user.course_management.course.update_status');

            Route::post('/course/{id}/update-featured', 'User\Curriculum\CourseController@updateFeatured')->name('user.course_management.course.update_featured');

            Route::get('/edit-course/{id}', 'User\Curriculum\CourseController@edit')->name('user.course_management.edit_course');

            Route::post('/update-course/{id}', 'User\Curriculum\CourseController@update')->name('user.course_management.update_course');

            Route::prefix('/course')->group(function () {

                Route::get('/{id}/modules', 'User\Curriculum\ModuleController@index')->name('user.course_management.course.modules');

                Route::post('/{id}/store-module', 'User\Curriculum\ModuleController@store')->name('user.course_management.course.store_module');

                Route::post('/update-module', 'User\Curriculum\ModuleController@update')->name('user.course_management.course.update_module');

                Route::post('/delete-module/{id}', 'User\Curriculum\ModuleController@destroy')->name('user.course_management.course.delete_module');

                Route::post('/bulk-delete-module', 'User\Curriculum\ModuleController@bulkDestroy')->name('user.course_management.course.bulk_delete_module');
            });

            Route::prefix('/module')->group(function () {
                Route::post('/{id}/store-lesson', 'User\Curriculum\LessonController@store')->name('user.course_management.module.store_lesson');
                Route::post('/update-lesson', 'User\Curriculum\LessonController@update')->name('user.course_management.module.update_lesson');
            });

            Route::prefix('/lesson')->group(function () {

                Route::get('/{id}/contents', 'User\Curriculum\LessonContentController@contents')->name('user.course_management.lesson.contents');

                Route::post('/upload-video', 'User\Curriculum\LessonContentController@uploadVideo')->name('user.course_management.lesson.upload_video');

                Route::post('/video-preview', 'User\Curriculum\LessonContentController@videoPreview')->name('user.course_management.lesson.video_preview');

                Route::post('/remove-video', 'User\Curriculum\LessonContentController@removeVideo')->name('user.course_management.lesson.remove_video');

                Route::post('/{id}/store-video', 'User\Curriculum\LessonContentController@storeVideo')->name('user.course_management.lesson.store_video');

                Route::post('/upload-file', 'User\Curriculum\LessonContentController@uploadFile')->name('user.course_management.lesson.upload_file');

                Route::post('/remove-file', 'User\Curriculum\LessonContentController@removeFile')->name('user.course_management.lesson.remove_file');

                Route::post('/{id}/store-file', 'User\Curriculum\LessonContentController@storeFile')->name('user.course_management.lesson.store_file');

                Route::get('/download-file/{id}', 'User\Curriculum\LessonContentController@downloadFile')->name('user.course_management.lesson.download_file');

                Route::post('/{id}/store-text', 'User\Curriculum\LessonContentController@storeText')->name('user.course_management.lesson.store_text');

                Route::post('/update-text', 'User\Curriculum\LessonContentController@updateText')->name('user.course_management.lesson.update_text');

                Route::post('/{id}/store-code', 'User\Curriculum\LessonContentController@storeCode')->name('user.course_management.lesson.store_code');

                Route::post('/update-code', 'User\Curriculum\LessonContentController@updateCode')->name('user.course_management.lesson.update_code');

                Route::post('/delete-content/{id}', 'User\Curriculum\LessonContentController@destroyContent')->name('user.course_management.lesson.delete_content');

                Route::get('/{id}/create-quiz', 'User\Curriculum\LessonQuizController@create')->name('user.course_management.lesson.create_quiz');

                Route::post('/{id}/store-quiz', 'User\Curriculum\LessonQuizController@store')->name('user.course_management.lesson.store_quiz');

                Route::get('/{id}/manage-quiz', 'User\Curriculum\LessonQuizController@index')->name('user.course_management.lesson.manage_quiz');

                Route::get('/{lessonId}/edit-quiz/{quizId}', 'User\Curriculum\LessonQuizController@edit')->name('user.course_management.lesson.edit_quiz');

                Route::get('/get-ans/{id}', 'User\Curriculum\LessonQuizController@getAns')->name('user.course_management.lesson.get_ans');

                Route::post('/update-quiz/{id}', 'User\Curriculum\LessonQuizController@update')->name('user.course_management.lesson.update_quiz');

                Route::post('/delete-quiz/{id}', 'User\Curriculum\LessonQuizController@destroy')->name('user.course_management.lesson.delete_quiz');

                Route::post('/sort-contents', 'User\Curriculum\LessonContentController@sort')->name('user.course_management.lesson.sort_contents');
            });

            Route::post('/module/delete-lesson/{id}', 'User\Curriculum\LessonController@destroy')->name('user.course_management.module.delete_lesson');

            Route::prefix('/course')->group(function () {
                Route::get('/{id}/faqs', 'User\Curriculum\CourseFaqController@index')->name('user.course_management.course.faqs');
                Route::post('/{id}/store-faq', 'User\Curriculum\CourseFaqController@store')->name('user.course_management.course.store_faq');
                Route::post('/update-faq', 'User\Curriculum\CourseFaqController@update')->name('user.course_management.course.update_faq');
                Route::post('/delete-faq/{id}', 'User\Curriculum\CourseFaqController@destroy')->name('user.course_management.course.delete_faq');
                Route::post('/bulk-delete-faq', 'User\Curriculum\CourseFaqController@bulkDestroy')->name('user.course_management.course.bulk_delete_faq');
                Route::get('/{id}/thanks-page', 'User\Curriculum\CourseController@thanksPage')->name('user.course_management.course.thanks_page');
                Route::post('/{id}/update-thanks-page', 'User\Curriculum\CourseController@updateThanksPage')->name('user.course_management.course.update_thanks_page');
                Route::group(['middleware' => 'checkUserPermission:Course Completion Certificate'], function () {
                    Route::get('/{id}/certificate-settings', 'User\Curriculum\CourseController@certificateSettings')->name('user.course_management.course.certificate_settings');
                    Route::post('/{id}/update-certificate-settings', 'User\Curriculum\CourseController@updateCertificateSettings')->name('user.course_management.course.update_certificate_settings');
                });
            });

            Route::post('/delete-course/{id}', 'User\Curriculum\CourseController@destroy')->name('user.course_management.delete_course');
            Route::post('/bulk-delete-course', 'User\Curriculum\CourseController@bulkDestroy')->name('user.course_management.bulk_delete_course');
            Route::group(['middleware' => 'checkUserPermission:Coupon'], function () {
                Route::get('/coupons', 'User\Curriculum\CouponController@index')->name('user.course_management.coupons');
                Route::post('/store-coupon', 'User\Curriculum\CouponController@store')->name('user.course_management.store_coupon');
                Route::post('/update-coupon', 'User\Curriculum\CouponController@update')->name('user.course_management.update_coupon');
                Route::post('/delete-coupon/{id}', 'User\Curriculum\CouponController@destroy')->name('user.course_management.delete_coupon');
            });
        });
        // course management route end

        // home-page route start
        Route::prefix('/home-page')->group(function () {
            // hero section
            Route::get('/hero-section', 'User\HomePage\HeroController@index')->name('user.home_page.hero_section');
            Route::post('/update-hero-section', 'User\HomePage\HeroController@update')->name('user.home_page.update_hero_section');

            // section title
            Route::get('/section-titles', 'User\HomePage\SectionTitleController@index')->name('user.home_page.section_titles');
            Route::post('/update-section-titles', 'User\HomePage\SectionTitleController@update')->name('user.home_page.update_section_title');
            // call to action section
            Route::get('/action-section', 'User\HomePage\ActionController@index')->name('user.home_page.action_section');
            Route::post('/update-action-section', 'User\HomePage\ActionController@update')->name('user.home_page.update_action_section');
            // features section
            Route::get('/features-section', 'User\HomePage\FeatureController@index')->name('user.home_page.features_section');
            Route::post('/update-feature-section-image', 'User\HomePage\FeatureController@updateImage')->name('user.home_page.update_feature_section_image');
            Route::post('/store-feature', 'User\HomePage\FeatureController@store')->name('user.home_page.store_feature');
            Route::put('/update-feature', 'User\HomePage\FeatureController@update')->name('user.home_page.update_feature');
            Route::post('/delete-feature/{id}', 'User\HomePage\FeatureController@destroy')->name('user.home_page.delete_feature');
            Route::post('/bulk-delete-feature', 'User\HomePage\FeatureController@bulkDestroy')->name('user.home_page.bulk_delete_feature');
            // video section
            Route::get('/video-section', 'User\HomePage\VideoController@index')->name('user.home_page.video_section');
            Route::post('/update-video-section', 'User\HomePage\VideoController@update')->name('user.home_page.update_video_section');
            // fun facts section
            Route::get('/fun-facts-section', 'User\HomePage\FunFactController@index')->name('user.home_page.fun_facts_section');
            Route::post('/update-fun-facts-section', 'User\HomePage\FunFactController@updateSection')->name('user.home_page.update_fun_facts_section');
            Route::post('/store-counter-info', 'User\HomePage\FunFactController@store')->name('user.home_page.store_counter_info');
            Route::put('/update-counter-info', 'User\HomePage\FunFactController@update')->name('user.home_page.update_counter_info');
            Route::post('/delete-counter-info/{id}', 'User\HomePage\FunFactController@destroy')->name('user.home_page.delete_counter_info');
            Route::post('/bulk-delete-counter-info', 'User\HomePage\FunFactController@bulkDestroy')->name('user.home_page.bulk_delete_counter_info');
            // testimonials section
            Route::get('/testimonials-section', 'User\HomePage\TestimonialController@index')->name('user.home_page.testimonials_section');
            Route::post('/update-testimonial-section-image', 'User\HomePage\TestimonialController@updateImage')->name('user.home_page.update_testimonial_section_image');
            Route::post('/store-testimonial', 'User\HomePage\TestimonialController@store')->name('user.home_page.store_testimonial');
            Route::post('/update-testimonial', 'User\HomePage\TestimonialController@update')->name('user.home_page.update_testimonial');
            Route::post('/delete-testimonial/{id}', 'User\HomePage\TestimonialController@destroy')->name('user.home_page.delete_testimonial');
            Route::post('/bulk-delete-testimonial', 'User\HomePage\TestimonialController@bulkDestroy')->name('user.home_page.bulk_delete_testimonial');
            // newsletter section
            Route::get('/newsletter-section', 'User\HomePage\NewsletterController@index')->name('user.home_page.newsletter_section');
            Route::post('/update-newsletter-section', 'User\HomePage\NewsletterController@update')->name('user.home_page.update_newsletter_section');
            // about-us section
            Route::get('/about-us-section', 'User\HomePage\AboutUsController@index')->name('user.home_page.about_us_section');
            Route::post('/update-about-us-section', 'User\HomePage\AboutUsController@update')->name('user.home_page.update_about_us_section');
            // course-categories section
            Route::get('/course-categories-section', 'User\HomePage\CourseCategoryController@index')->name('user.home_page.course_categories_section');
            Route::post('/update-course-category-section-image', 'User\HomePage\CourseCategoryController@updateImage')->name('user.home_page.update_course_category_section_image');
            Route::post('/update-course-category-section-image', 'User\HomePage\CourseCategoryController@updateImage')->name('user.home_page.update_course_category_section_image');
            // section customization
            Route::get('/section-customization', 'User\HomePage\SectionController@index')->name('user.home_page.section_customization');
            Route::post('/update-section-status', 'User\HomePage\SectionController@update')->name('user.home_page.update_section_status');
        });
        // home-page route end

        // course enrolment route start
        Route::get('/course-enrolments', 'User\Curriculum\EnrolmentController@index')->name('user.course_enrolments');
        Route::prefix('/course-enrolment')->group(function () {
            Route::post('/{id}/update-payment-status', 'User\Curriculum\EnrolmentController@updatePaymentStatus')->name('user.course_enrolment.update_payment_status');
            Route::get('/{id}/details', 'User\Curriculum\EnrolmentController@show')->name('user.course_enrolment.details');
            Route::post('/{id}/delete', 'User\Curriculum\EnrolmentController@destroy')->name('user.course_enrolment.delete');
        });

        Route::get('/course-enrolments/report', 'User\Curriculum\EnrolmentController@report')->name('user.course_enrolments.report');
        Route::get('/course-enrolments/export', 'User\Curriculum\EnrolmentController@export')->name('user.course_enrolments.export');
        Route::post('/course-enrolments/bulk-delete', 'User\Curriculum\EnrolmentController@bulkDestroy')->name('user.course_enrolments.bulk_delete');
        // course enrolment route end

        // announcement-popup route start
        Route::prefix('/announcement-popups')->group(function () {
            Route::get('', 'User\PopupController@index')->name('user.announcement_popups');
            Route::get('/select-popup-type', 'User\PopupController@popupType')->name('user.announcement_popups.select_popup_type');
            Route::get('/create-popup/{type}', 'User\PopupController@create')->name('user.announcement_popups.create_popup');
            Route::post('/store-popup', 'User\PopupController@store')->name('user.announcement_popups.store_popup');
            Route::post('/popup/{id}/update-status', 'User\PopupController@updateStatus')->name('user.announcement_popups.update_popup_status');
            Route::get('/edit-popup/{id}', 'User\PopupController@edit')->name('user.announcement_popups.edit_popup');
            Route::post('/update-popup/{id}', 'User\PopupController@update')->name('user.announcement_popups.update_popup');
            Route::post('/delete-popup/{id}', 'User\PopupController@destroy')->name('user.announcement_popups.delete_popup');
            Route::post('/bulk-delete-popup', 'User\PopupController@bulkDestroy')->name('user.announcement_popups.bulk_delete_popup');
        });
        // announcement-popup route end


        // user management route start
        Route::middleware('checkPackage')->group(function () {

            Route::get('/registered-users', 'User\RegisteredUserController@index')->name('user.registered_users');

            Route::post('/user/{id}/update-account-status', 'User\RegisteredUserController@updateAccountStatus')->name('user.user.update_account_status');

            Route::post('register/users/email', 'User\RegisteredUserController@emailStatus')->name('user.email');

            Route::get('/user/{id}/details', 'User\RegisteredUserController@show')->name('user.user_details');

            Route::get('/user/{id}/change-password', 'User\RegisteredUserController@changePassword')->name('user.user.change_password');

            Route::post('/user/{id}/update-password', 'User\RegisteredUserController@updatePassword')->name('user.user.update_password');

            Route::post('/user/{id}/delete', 'User\RegisteredUserController@destroy')->name('user.user.delete');

            Route::post('/bulk-delete-user', 'User\RegisteredUserController@bulkDestroy')->name('user.bulk_delete_user');
        });

        // basic settings information route
        Route::get('/information', 'User\BasicController@information')->name('user.basic_settings.information');
        Route::post('/update-info', 'User\BasicController@updateInfo')->name('user.basic_settings.update_info');

        // basic settings page-headings route
        Route::get('/page-headings', 'User\PageHeadingController@pageHeadings')->name('user.page_headings');
        Route::post('/update-page-headings', 'User\PageHeadingController@updatePageHeadings')->name('user.update_page_headings');

        // user theme change
        Route::get('/change-theme', 'User\UserController@changeTheme')->name('user.theme.change');
        // RTL check
        Route::get('/rtlcheck/{langid}', 'User\LanguageController@rtlcheck')->name('user.rtlcheck');

        Route::get('/dashboard', 'User\UserController@index')->name('user-dashboard');
        Route::get('/reset', 'User\UserController@resetform')->name('user-reset');
        Route::post('/reset', 'User\UserController@reset')->name('user-reset-submit');
        Route::get('/profile', 'User\UserController@profile')->name('user-profile');
        Route::post('/profile', 'User\UserController@profileupdate')->name('user-profile-update');
        Route::get('/logout', 'User\Auth\LoginController@logout')->name('user-logout');
        Route::post('/change-status', 'User\UserController@status')->name('user-status');


        // Payment Log
        Route::get('/payment-log', 'User\PaymentLogController@index')->name('user.payment-log.index');

        // User Domains & URLs
        Route::group(['middleware' => 'checkUserPermission:Custom Domain'], function () {
            Route::get('/domains', 'User\DomainController@domains')->name('user-domains');
            Route::post('/request/domain', 'User\DomainController@domainrequest')->name('user-domain-request');
        });

        // User Subdomains & URLs
        Route::get('/subdomain', 'User\SubdomainController@subdomain')->name('user-subdomain');

        //user follow and following list
        Route::group(['middleware' => 'checkUserPermission:Follow/Unfollow'], function () {
            Route::get('/follower-list', 'User\FollowerController@follower')->name('user.follower.list');
            Route::get('/following-list', 'User\FollowerController@following')->name('user.following.list');
            Route::get('/follow/{id}', 'User\FollowerController@follow')->name('user.follow');
            Route::get('/unfollow/{id}', 'User\FollowerController@unfollow')->name('user.unfollow');
        });

        Route::get('/change-password', 'User\UserController@changePass')->name('user.changePass');
        Route::post('/profile/updatePassword', 'User\UserController@updatePassword')->name('user.updatePassword');

        //user language
        Route::get('/languages', 'User\LanguageController@index')->name('user.language.index');
        Route::get('/language/{id}/edit', 'User\LanguageController@edit')->name('user.language.edit');
        Route::get('/language/{id}/edit/keyword', 'User\LanguageController@editKeyword')->name('user.language.editKeyword');
        Route::post('/language/{id}/update/keyword', 'User\LanguageController@updateKeyword')->name('user.language.updateKeyword');
        Route::post('/language/store', 'User\LanguageController@store')->name('user.language.store');
        Route::post('/language/upload', 'User\LanguageController@upload')->name('user.language.upload');
        Route::post('/language/{id}/uploadUpdate', 'User\LanguageController@uploadUpdate')->name('user.language.uploadUpdate');
        Route::post('/language/{id}/default', 'User\LanguageController@default')->name('user.language.default');
        Route::post('/language/{id}/delete', 'User\LanguageController@delete')->name('user.language.delete');
        Route::post('/language/update', 'User\LanguageController@update')->name('user.language.update');

        //user theme routes
        Route::get('/theme/version', 'User\BasicController@themeVersion')->name('user.theme.version');
        Route::post('/theme/update_version', 'User\BasicController@updateThemeVersion')->name('user.theme.update');

        //user favicon routes
        Route::get('/favicon', 'User\BasicController@favicon')->name('user.favicon');
        Route::post('/favicon/post', 'User\BasicController@updatefav')->name('user.favicon.update');

        // user logo routes
        Route::get('/logo', 'User\BasicController@logo')->name('user.logo');
        Route::post('/logo/post', 'User\BasicController@updatelogo')->name('user.logo.update');

        // user breadcrumb route
        Route::get('/breadcrumb', 'User\BasicController@breadcrumb')->name('user.breadcrumb');
        Route::post('/update_breadcrumb', 'User\BasicController@updateBreadcrumb')->name('user.update_breadcrumb');

        // user logo routes
        Route::get('/footer-logo', 'User\BasicController@footerLogo')->name('user.footer.logo');
        Route::post('/update/footer-logo', 'User\BasicController@updateFooterLogo')->name('user.footer.logo.update');

        // basic settings currency route
        Route::get('/currency', 'User\BasicController@currency')->name('user.currency');
        Route::post('/update-currency', 'User\BasicController@updateCurrency')->name('user.update.currency');

        Route::get('/mail/information', 'User\BasicController@getMailInformation')->name('user.mail.info');
        Route::post('/mail/information', 'User\BasicController@storeMailInformation')->name('user.mail.info.update');


        Route::get('/mail-templates', 'User\MailTemplateController@index')->name('user.mail_templates');
        Route::get('/edit-mail-template/{id}', 'User\MailTemplateController@edit')->name('user.edit_mail_template');
        Route::post('/update-mail-template/{id}', 'User\MailTemplateController@update')->name('user.update_mail_template');


        // basic settings appearance route
        Route::get('/appearance', 'User\BasicController@appearance')->name('user.appearance');
        Route::post('/update-appearance', 'User\BasicController@updateAppearance')->name('user.update.appearance');

        // basic settings seo route
        Route::get('/basic_settings/seo', 'User\BasicController@seo')->name('user.basic_settings.seo');
        Route::post('/basic_settings/update_seo_informations', 'User\BasicController@updateSEO')->name('user.basic_settings.update_seo_informations');

        // basic settings plugins route start
        Route::get('/plugins', 'User\BasicController@plugins')->name('user.plugins');
        Route::post('/update-disqus', 'User\BasicController@updateDisqus')->name('user.update_disqus');
        Route::post('/update-whatsapp', 'User\BasicController@updateWhatsApp')->name('user.update_whatsapp');
        Route::post('/update-aws-credentials', 'User\BasicController@updateAWSCredentials')->name('user.update_aws_credentials');
        // basic settings plugins route end

        // basic settings maintenance-mode route
        Route::get('/maintenance-mode', 'User\BasicController@maintenance')->name('user.maintenance_mode');
        Route::post('/update-maintenance-mode', 'User\BasicController@updateMaintenance')->name('user.update_maintenance_mode');

        // basic settings cookie-alert route
        Route::get('/cookie-alert', 'User\CookieAlertController@cookieAlert')->name('user.cookie_alert');
        Route::post('/update-cookie-alert', 'User\CookieAlertController@updateCookieAlert')->name('user.update_cookie_alert');

        // start user menu builder
        Route::get('/menu-builder', 'User\MenuBuilderController@index')->name('user.menu_builder.index');
        Route::post('/menu-builder/update', 'User\MenuBuilderController@update')->name('user.menu_builder.update');
        // end user menu builder

        // user Social routes
        Route::get('/social', 'User\SocialController@index')->name('user.social.index');
        Route::post('/social/store', 'User\SocialController@store')->name('user.social.store');
        Route::get('/social/{id}/edit', 'User\SocialController@edit')->name('user.social.edit');
        Route::post('/social/update', 'User\SocialController@update')->name('user.social.update');
        Route::post('/social/delete', 'User\SocialController@delete')->name('user.social.delete');

        // faq route start
        Route::prefix('/faq-management')->group(function () {
            Route::get('', 'User\FaqController@index')->name('user.faq_management');
            Route::post('/store-faq', 'User\FaqController@store')->name('user.faq_management.store_faq');
            Route::post('/update-faq', 'User\FaqController@update')->name('user.faq_management.update_faq');
            Route::post('/delete-faq/{id}', 'User\FaqController@destroy')->name('user.faq_management.delete_faq');
            Route::post('/bulk-delete-faq', 'User\FaqController@bulkDestroy')->name('user.faq_management.bulk_delete_faq');
        });
        // faq route end

        // blog route start
        Route::prefix('/blog-management')->middleware('checkUserPermission:Blog')->group(function () {
            Route::get('/categories', 'User\Journal\CategoryController@index')->name('user.blog_management.categories');
            Route::post('/store-category', 'User\Journal\CategoryController@store')->name('user.blog_management.store_category');
            Route::put('/update-category', 'User\Journal\CategoryController@update')->name('user.blog_management.update_category');
            Route::post('/delete-category/{id}', 'User\Journal\CategoryController@destroy')->name('user.blog_management.delete_category');
            Route::post('/bulk-delete-category', 'User\Journal\CategoryController@bulkDestroy')->name('user.blog_management.bulk_delete_category');

            Route::get('/blogs', 'User\Journal\BlogController@index')->name('user.blog_management.blogs');
            Route::get('/create-blog', 'User\Journal\BlogController@create')->name('user.blog_management.create_blog');
            Route::post('/store-blog', 'User\Journal\BlogController@store')->name('user.blog_management.store_blog');
            Route::get('/edit-blog/{id}', 'User\Journal\BlogController@edit')->name('user.blog_management.edit_blog');
            Route::post('/update-blog/{id}', 'User\Journal\BlogController@update')->name('user.blog_management.update_blog');
            Route::post('/delete-blog/{id}', 'User\Journal\BlogController@destroy')->name('user.blog_management.delete_blog');
            Route::post('/bulk-delete-blog', 'User\Journal\BlogController@bulkDestroy')->name('user.blog_management.bulk_delete_blog');
        });
        // blog route end

        // custom-pages route start
        Route::prefix('/custom-pages')->middleware('checkUserPermission:Custom Page')->group(function () {
            Route::get('', 'User\CustomPageController@index')->name('user.custom_pages');
            Route::get('/create-page', 'User\CustomPageController@create')->name('user.custom_pages.create_page');
            Route::post('/store-page', 'User\CustomPageController@store')->name('user.custom_pages.store_page');
            Route::get('/edit-page/{id}', 'User\CustomPageController@edit')->name('user.custom_pages.edit_page');
            Route::post('/update-page/{id}', 'User\CustomPageController@update')->name('user.custom_pages.update_page');
            Route::post('/delete-page/{id}', 'User\CustomPageController@destroy')->name('user.custom_pages.delete_page');
            Route::post('/bulk-delete-page', 'User\CustomPageController@bulkDestroy')->name('user.custom_pages.bulk_delete_page');
        });
        // custom-pages route end

        // advertise route start
        Route::prefix('/advertisements')->middleware('checkUserPermission:Advertisement')->group(function () {
            Route::get('/settings', 'User\BasicController@advertiseSettings')->name('user.advertise.settings');
            Route::post('/update-settings', 'User\BasicController@updateAdvertiseSettings')->name('user.advertise.update_settings');
            Route::get('', 'User\AdvertisementController@index')->name('user.advertisements');
            Route::post('/store-advertisement', 'User\AdvertisementController@store')->name('user.advertise.store_advertisement');
            Route::post('/update-advertisement', 'User\AdvertisementController@update')->name('user.advertise.update_advertisement');
            Route::post('/delete-advertisement/{id}', 'User\AdvertisementController@destroy')->name('user.advertise.delete_advertisement');
            Route::post('/bulk-delete-advertisement', 'User\AdvertisementController@bulkDestroy')->name('user.advertise.bulk_delete_advertisement');
        });
        // advertise route end

        // Summernote image upload
        Route::post('/summernote/upload', 'Admin\SummernoteController@upload')->name('user.summernote.upload');

        //user package extend route

        Route::get('/package-list', 'User\BuyPlanController@index')->name('user.plan.extend.index');
        Route::get('/package/checkout/{package_id}', 'User\BuyPlanController@checkout')->name('user.plan.extend.checkout');
        Route::post('/package/checkout', 'User\UserCheckoutController@checkout')->name('user.plan.checkout');

        //user footer route

        Route::get('/footer/content', 'User\FooterController@footerContent')->name('user.footer.content');
        Route::post('/footer/update-content/{language}', 'User\FooterController@updateFooterContent')->name('user.footer.update_content');
        Route::get('/footer/quick_links', 'User\FooterController@quickLinks')->name('user.footer.quick_links');
        Route::post('/footer/store_quick_link', 'User\FooterController@storeQuickLink')->name('user.footer.store_quick_link');
        Route::post('/footer/update_quick_link', 'User\FooterController@updateQuickLink')->name('user.footer.update_quick_link');
        Route::post('/footer/delete_quick_link', 'User\FooterController@deleteQuickLink')->name('user.footer.delete_quick_link');

        //user subscriber routes
        Route::get('/subscribers', 'User\SubscriberController@index')->name('user.subscriber.index');
        Route::get('/mailsubscriber', 'User\SubscriberController@mailsubscriber')->name('user.mailsubscriber');
        Route::post('/subscribers/sendmail', 'User\SubscriberController@subscsendmail')->name('user.subscribers.sendmail');
        Route::post('/subscriber/delete', 'User\SubscriberController@delete')->name('user.subscriber.delete');
        Route::post('/subscriber/bulk-delete', 'User\SubscriberController@bulkDelete')->name('user.subscriber.bulk.delete');

        // User vCard routes
        Route::group(['middleware' => 'checkUserPermission:vCard'], function () {
            Route::get('/vcard', 'User\VcardController@vcard')->name('user.vcard');
            Route::get('/vcard/create', 'User\VcardController@create')->name('user.vcard.create');
            Route::post('/vcard/store', 'User\VcardController@store')->name('user.vcard.store');
            Route::get('/vcard/{id}/edit', 'User\VcardController@edit')->name('user.vcard.edit');
            Route::post('/vcard/update', 'User\VcardController@update')->name('user.vcard.update');
            Route::post('/vcard/delete', 'User\VcardController@delete')->name('user.vcard.delete');
            Route::post('/vcard/bulk/delete', 'User\VcardController@bulkDelete')->name('user.vcard.bulk.delete');
            Route::get('/vcard/{id}/information', 'User\VcardController@information')->name('user.vcard.information');

            Route::get('/vcard/{id}/services', 'User\VcardController@services')->name('user.vcard.services');
            Route::post('/vcard/service/store', 'User\VcardController@serviceStore')->name('user.vcard.serviceStore');
            Route::post('/vcard/service/update', 'User\VcardController@serviceUpdate')->name('user.vcard.serviceUpdate');
            Route::post('/vcard/service/delete', 'User\VcardController@serviceDelete')->name('user.vcard.serviceDelete');
            Route::post('/vcard/bulk/service/delete', 'User\VcardController@bulkServiceDelete')->name('user.vcard.bulkServiceDelete');

            Route::get('/vcard/{id}/projects', 'User\VcardController@projects')->name('user.vcard.projects');
            Route::post('/vcard/project/store', 'User\VcardController@projectStore')->name('user.vcard.projectStore');
            Route::post('/vcard/project/update', 'User\VcardController@projectUpdate')->name('user.vcard.projectUpdate');
            Route::post('/vcard/project/delete', 'User\VcardController@projectDelete')->name('user.vcard.projectDelete');
            Route::post('/vcard/bulk/project/delete', 'User\VcardController@bulkProjectDelete')->name('user.vcard.bulkProjectDelete');

            Route::get('/vcard/{id}/testimonials', 'User\VcardController@testimonials')->name('user.vcard.testimonials');
            Route::post('/vcard/testimonial/store', 'User\VcardController@testimonialStore')->name('user.vcard.testimonialStore');
            Route::post('/vcard/testimonial/update', 'User\VcardController@testimonialUpdate')->name('user.vcard.testimonialUpdate');
            Route::post('/vcard/testimonial/delete', 'User\VcardController@testimonialDelete')->name('user.vcard.testimonialDelete');
            Route::post('/vcard/bulk/testimonial/delete', 'User\VcardController@bulkTestimonialDelete')->name('user.vcard.bulkTestimonialDelete');

            Route::get('/vcard/{id}/about', 'User\VcardController@about')->name('user.vcard.about');
            Route::post('/vcard/aboutUpdate', 'User\VcardController@aboutUpdate')->name('user.vcard.aboutUpdate');

            Route::get('/vcard/{id}/preferences', 'User\VcardController@preferences')->name('user.vcard.preferences');
            Route::post('/vcard/{id}/prefUpdate', 'User\VcardController@prefUpdate')->name('user.vcard.prefUpdate');

            Route::get('/vcard/{id}/color', 'User\VcardController@color')->name('user.vcard.color');
            Route::post('/vcard/{id}/colorUpdate', 'User\VcardController@colorUpdate')->name('user.vcard.colorUpdate');

            Route::get('/vcard/{id}/keywords', 'User\VcardController@keywords')->name('user.vcard.keywords');
            Route::post('/vcard/{id}/keywordsUpdate', 'User\VcardController@keywordsUpdate')->name('user.vcard.keywordsUpdate');
        });
        // user QR Builder
        Route::group(['middleware' => 'checkUserPermission:QR Builder'], function () {
            Route::get('/saved/qrs', 'User\QrController@index')->name('user.qrcode.index');
            Route::post('/saved/qr/delete', 'User\QrController@delete')->name('user.qrcode.delete');
            Route::post('/saved/qr/bulk-delete', 'User\QrController@bulkDelete')->name('user.qrcode.bulk.delete');
            Route::get('/qr-code', 'User\QrController@qrCode')->name('user.qrcode');
            Route::post('/qr-code/generate', 'User\QrController@generate')->name('user.qrcode.generate');
            Route::get('/qr-code/clear', 'User\QrController@clear')->name('user.qrcode.clear');
            Route::post('/qr-code/save', 'User\QrController@save')->name('user.qrcode.save');
            Route::get('qr-code/download/{name?}', 'User\QrController@download')->name('user.qrcode.download');
        });
        // User Payment Gateways
        // User Online Gateways Routes
        Route::get('/gateways', 'User\GatewayController@index')->name('user.gateway.index');
        Route::post('/stripe/update', 'User\GatewayController@stripeUpdate')->name('user.stripe.update');
        Route::post('/anet/update', 'User\GatewayController@anetUpdate')->name('user.anet.update');
        Route::post('/paypal/update', 'User\GatewayController@paypalUpdate')->name('user.paypal.update');
        Route::post('/paystack/update', 'User\GatewayController@paystackUpdate')->name('user.paystack.update');
        Route::post('/paytm/update', 'User\GatewayController@paytmUpdate')->name('user.paytm.update');
        Route::post('/flutterwave/update', 'User\GatewayController@flutterwaveUpdate')->name('user.flutterwave.update');
        Route::post('/instamojo/update', 'User\GatewayController@instamojoUpdate')->name('user.instamojo.update');
        Route::post('/mollie/update', 'User\GatewayController@mollieUpdate')->name('user.mollie.update');
        Route::post('/razorpay/update', 'User\GatewayController@razorpayUpdate')->name('user.razorpay.update');
        Route::post('/mercadopago/update', 'User\GatewayController@mercadopagoUpdate')->name('user.mercadopago.update');

        // User Offline Gateway Routes
        Route::get('/offline/gateways', 'User\GatewayController@offline')->name('user.gateway.offline');
        Route::post('/offline/gateway/store', 'User\GatewayController@store')->name('user.gateway.offline.store');
        Route::post('/offline/gateway/update', 'User\GatewayController@update')->name('user.gateway.offline.update');
        Route::post('/offline/status', 'User\GatewayController@status')->name('user.offline.status');
        Route::post('/offline/gateway/delete', 'User\GatewayController@delete')->name('user.offline.gateway.delete');
    });


    /*=======================================================
    ******************** Admin Routes **********************
    =======================================================*/

    Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
        Route::get('/', 'Admin\LoginController@login')->name('admin.login');
        Route::post('/login', 'Admin\LoginController@authenticate')->name('admin.auth');

        Route::get('/mail-form', 'Admin\ForgetController@mailForm')->name('admin.forget.form');
        Route::post('/sendmail', 'Admin\ForgetController@sendmail')->name('admin.forget.mail');
    });


    Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'checkstatus']], function () {
        // RTL check
        Route::get('/rtlcheck/{langid}', 'Admin\LanguageController@rtlcheck')->name('admin.rtlcheck');
        // admin redirect to dashboard route
        Route::get('/change-theme', 'Admin\DashboardController@changeTheme')->name('admin.theme.change');
        // Summernote image upload
        Route::post('/summernote/upload', 'Admin\SummernoteController@upload')->name('admin.summernote.upload');
        // Admin logout Route
        Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');
        // Admin Dashboard Routes
        Route::group(['middleware' => 'checkpermission:Dashboard'], function () {
            Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard');
        });
        // Admin Profile Routes
        Route::get('/changePassword', 'Admin\ProfileController@changePass')->name('admin.changePass');
        Route::post('/profile/updatePassword', 'Admin\ProfileController@updatePassword')->name('admin.updatePassword');
        Route::get('/profile/edit', 'Admin\ProfileController@editProfile')->name('admin.editProfile');
        Route::post('/profile/update', 'Admin\ProfileController@updateProfile')->name('admin.updateProfile');

        Route::group(['middleware' => 'checkpermission:Settings'], function () {
            // Admin Favicon Routes
            Route::get('/favicon', 'Admin\BasicController@favicon')->name('admin.favicon');
            Route::post('/favicon/post', 'Admin\BasicController@updatefav')->name('admin.favicon.update');
            // Admin Logo Routes
            Route::get('/logo', 'Admin\BasicController@logo')->name('admin.logo');
            Route::post('/logo/post', 'Admin\BasicController@updatelogo')->name('admin.logo.update');
            // Admin Preloader Routes
            Route::get('/preloader', 'Admin\BasicController@preloader')->name('admin.preloader');
            Route::post('/preloader/post', 'Admin\BasicController@updatepreloader')->name('admin.preloader.update');
            // Admin Basic Information Routes
            Route::get('/basicinfo', 'Admin\BasicController@basicinfo')->name('admin.basicinfo');
            Route::post('/basicinfo/post', 'Admin\BasicController@updatebasicinfo')->name('admin.basicinfo.update');
            // Admin Email Settings Routes
            Route::get('/mail-from-admin', 'Admin\EmailController@mailFromAdmin')->name('admin.mailFromAdmin');
            Route::post('/mail-from-admin/update', 'Admin\EmailController@updateMailFromAdmin')->name('admin.mailfromadmin.update');
            Route::get('/mail-to-admin', 'Admin\EmailController@mailToAdmin')->name('admin.mailToAdmin');
            Route::post('/mail-to-admin/update', 'Admin\EmailController@updateMailToAdmin')->name('admin.mailtoadmin.update');

            Route::get('/mail_templates', 'Admin\MailTemplateController@mailTemplates')->name('admin.mail_templates');
            Route::get('/edit_mail_template/{id}', 'Admin\MailTemplateController@editMailTemplate')->name('admin.edit_mail_template');
            Route::post('/update_mail_template/{id}', 'Admin\MailTemplateController@updateMailTemplate')->name('admin.update_mail_template');
            // Admin Breadcrumb Routes
            Route::get('/breadcrumb', 'Admin\BasicController@breadcrumb')->name('admin.breadcrumb');
            Route::post('/breadcrumb/update', 'Admin\BasicController@updatebreadcrumb')->name('admin.breadcrumb.update');
            // Admin Scripts Routes
            Route::get('/script', 'Admin\BasicController@script')->name('admin.script');
            Route::post('/script/update', 'Admin\BasicController@updatescript')->name('admin.script.update');
            // Admin Social Routes
            Route::get('/social', 'Admin\SocialController@index')->name('admin.social.index');
            Route::post('/social/store', 'Admin\SocialController@store')->name('admin.social.store');
            Route::get('/social/{id}/edit', 'Admin\SocialController@edit')->name('admin.social.edit');
            Route::post('/social/update', 'Admin\SocialController@update')->name('admin.social.update');
            Route::post('/social/delete', 'Admin\SocialController@delete')->name('admin.social.delete');
            // Admin Maintenance Mode Routes
            Route::get('/maintainance', 'Admin\BasicController@maintainance')->name('admin.maintainance');
            Route::post('/maintainance/update', 'Admin\BasicController@updatemaintainance')->name('admin.maintainance.update');
            // Admin Section Customization Routes
            Route::get('/sections', 'Admin\BasicController@sections')->name('admin.sections.index');
            Route::post('/sections/update', 'Admin\BasicController@updatesections')->name('admin.sections.update');
            // Admin Cookie Alert Routes
            Route::get('/cookie-alert', 'Admin\BasicController@cookiealert')->name('admin.cookie.alert');
            Route::post('/cookie-alert/{langid}/update', 'Admin\BasicController@updatecookie')->name('admin.cookie.update');
            // basic settings seo route
            Route::get('/seo', 'Admin\BasicController@seo')->name('admin.seo');
            Route::post('/seo/update', 'Admin\BasicController@updateSEO')->name('admin.seo.update');
        });

        Route::group(['middleware' => 'checkpermission:Subscribers'], function () {
            // Admin Subscriber Routes
            Route::get('/subscribers', 'Admin\SubscriberController@index')->name('admin.subscriber.index');
            Route::get('/mailsubscriber', 'Admin\SubscriberController@mailsubscriber')->name('admin.mailsubscriber');
            Route::post('/subscribers/sendmail', 'Admin\SubscriberController@subscsendmail')->name('admin.subscribers.sendmail');
            Route::post('/subscriber/delete', 'Admin\SubscriberController@delete')->name('admin.subscriber.delete');
            Route::post('/subscriber/bulk-delete', 'Admin\SubscriberController@bulkDelete')->name('admin.subscriber.bulk.delete');
        });

        Route::group(['middleware' => 'checkpermission:Menu Builder'], function () {
            Route::get('/menu-builder', 'Admin\MenuBuilderController@index')->name('admin.menu_builder.index');
            Route::post('/menu-builder/update', 'Admin\MenuBuilderController@update')->name('admin.menu_builder.update');
        });

        Route::group(['middleware' => 'checkpermission:Home Page'], function () {

            // Admin Hero Section Image & Text Routes
            Route::get('/herosection/imgtext', 'Admin\HerosectionController@imgtext')->name('admin.herosection.imgtext');
            Route::post('/herosection/{langid}/update', 'Admin\HerosectionController@update')->name('admin.herosection.update');

            // Admin Feature Routes
            Route::get('/features', 'Admin\FeatureController@index')->name('admin.feature.index');
            Route::post('/feature/store', 'Admin\FeatureController@store')->name('admin.feature.store');
            Route::get('/feature/{id}/edit', 'Admin\FeatureController@edit')->name('admin.feature.edit');
            Route::post('/feature/update', 'Admin\FeatureController@update')->name('admin.feature.update');
            Route::post('/feature/delete', 'Admin\FeatureController@delete')->name('admin.feature.delete');

            // Admin Work Process Routes
            Route::get('/process', 'Admin\ProcessController@index')->name('admin.process.index');
            Route::post('/process/store', 'Admin\ProcessController@store')->name('admin.process.store');
            Route::get('/process/{id}/edit', 'Admin\ProcessController@edit')->name('admin.process.edit');
            Route::post('/process/update', 'Admin\ProcessController@update')->name('admin.process.update');
            Route::post('/process/delete', 'Admin\ProcessController@delete')->name('admin.process.delete');

            // Admin Intro Section Routes
            Route::get('/introsection', 'Admin\IntrosectionController@index')->name('admin.introsection.index');
            Route::post('/introsection/{langid}/update', 'Admin\IntrosectionController@update')->name('admin.introsection.update');
            Route::post('/introsection/remove/image', 'Admin\IntrosectionController@removeImage')->name('admin.introsection.img.rmv');

            // Admin Testimonial Routes
            Route::get('/testimonials', 'Admin\TestimonialController@index')->name('admin.testimonial.index');
            Route::get('/testimonial/create', 'Admin\TestimonialController@create')->name('admin.testimonial.create');
            Route::post('/testimonial/store', 'Admin\TestimonialController@store')->name('admin.testimonial.store');
            Route::post('/testimonial/sideImageStore', 'Admin\TestimonialController@sideImageStore')->name('admin.testimonial.sideImageStore');
            Route::get('/testimonial/{id}/edit', 'Admin\TestimonialController@edit')->name('admin.testimonial.edit');
            Route::post('/testimonial/update', 'Admin\TestimonialController@update')->name('admin.testimonial.update');
            Route::post('/testimonial/delete', 'Admin\TestimonialController@delete')->name('admin.testimonial.delete');
            Route::post('/testimonialtext/{langid}/update', 'Admin\TestimonialController@textupdate')->name('admin.testimonialtext.update');

            // Admin home page text routes
            Route::get('/home-page-text-section', 'Admin\HomePageTextController@index')->name('admin.home.page.text.index');
            Route::post('/home-page-text-section/{langid}/update', 'Admin\HomePageTextController@update')->name('admin.home.page.text.update');

            // Admin Partner Routes
            Route::get('/partners', 'Admin\PartnerController@index')->name('admin.partner.index');
            Route::post('/partner/store', 'Admin\PartnerController@store')->name('admin.partner.store');
            Route::post('/partner/upload', 'Admin\PartnerController@upload')->name('admin.partner.upload');
            Route::get('/partner/{id}/edit', 'Admin\PartnerController@edit')->name('admin.partner.edit');
            Route::post('/partner/update', 'Admin\PartnerController@update')->name('admin.partner.update');
            Route::post('/partner/{id}/uploadUpdate', 'Admin\PartnerController@uploadUpdate')->name('admin.partner.uploadUpdate');
            Route::post('/partner/delete', 'Admin\PartnerController@delete')->name('admin.partner.delete');
        });

        Route::group(['middleware' => 'checkpermission:Pages'], function () {
            // Menu Manager Routes
            Route::get('/pages', 'Admin\PageController@index')->name('admin.page.index');
            Route::get('/page/create', 'Admin\PageController@create')->name('admin.page.create');
            Route::post('/page/store', 'Admin\PageController@store')->name('admin.page.store');
            Route::get('/page/{menuID}/edit', 'Admin\PageController@edit')->name('admin.page.edit');
            Route::post('/page/update', 'Admin\PageController@update')->name('admin.page.update');
            Route::post('/page/delete', 'Admin\PageController@delete')->name('admin.page.delete');
            Route::post('/page/bulk-delete', 'Admin\PageController@bulkDelete')->name('admin.page.bulk.delete');
        });

        Route::group(['middleware' => 'checkpermission:Footer'], function () {
            // Admin Footer Logo Text Routes
            Route::get('/footers', 'Admin\FooterController@index')->name('admin.footer.index');
            Route::post('/footer/{langid}/update', 'Admin\FooterController@update')->name('admin.footer.update');
            Route::post('/footer/remove/image', 'Admin\FooterController@removeImage')->name('admin.footer.rmvimg');

            // Admin Useful link Routes
            Route::get('/ulinks', 'Admin\UlinkController@index')->name('admin.ulink.index');
            Route::get('/ulink/create', 'Admin\UlinkController@create')->name('admin.ulink.create');
            Route::post('/ulink/store', 'Admin\UlinkController@store')->name('admin.ulink.store');
            Route::get('/ulink/{id}/edit', 'Admin\UlinkController@edit')->name('admin.ulink.edit');
            Route::post('/ulink/update', 'Admin\UlinkController@update')->name('admin.ulink.update');
            Route::post('/ulink/delete', 'Admin\UlinkController@delete')->name('admin.ulink.delete');
        });

        // Announcement Popup Routes
        Route::group(['middleware' => 'checkpermission:Announcement Popup'], function () {
            Route::get('popups', 'Admin\PopupController@index')->name('admin.popup.index');
            Route::get('popup/types', 'Admin\PopupController@types')->name('admin.popup.types');
            Route::get('popup/{id}/edit', 'Admin\PopupController@edit')->name('admin.popup.edit');
            Route::get('popup/create', 'Admin\PopupController@create')->name('admin.popup.create');
            Route::post('popup/store', 'Admin\PopupController@store')->name('admin.popup.store');
            Route::post('popup/delete', 'Admin\PopupController@delete')->name('admin.popup.delete');
            Route::post('popup/bulk-delete', 'Admin\PopupController@bulkDelete')->name('admin.popup.bulk.delete');
            Route::post('popup/status', 'Admin\PopupController@status')->name('admin.popup.status');
            Route::post('popup/update', 'Admin\PopupController@update')->name('admin.popup.update');
        });

        Route::group(['middleware' => 'checkpermission:Registered Users'], function () {
            // Register User start
            Route::get('register/users', 'Admin\RegisterUserController@index')->name('admin.register.user');
            Route::post('register/user/store', 'Admin\RegisterUserController@store')->name('register.user.store');
            Route::post('register/users/ban', 'Admin\RegisterUserController@userban')->name('register.user.ban');
            Route::post('register/users/featured', 'Admin\RegisterUserController@userFeatured')->name('register.user.featured');
            Route::post('register/users/template', 'Admin\RegisterUserController@userTemplate')->name('register.user.template');
            Route::post('register/users/template/update', 'Admin\RegisterUserController@userUpdateTemplate')->name('register.user.updateTemplate');
            Route::post('register/users/email', 'Admin\RegisterUserController@emailStatus')->name('register.user.email');
            Route::get('register/user/details/{id}', 'Admin\RegisterUserController@view')->name('register.user.view');
            Route::post('/user/current-package/remove', 'Admin\RegisterUserController@removeCurrPackage')->name('user.currPackage.remove');
            Route::post('/user/current-package/change', 'Admin\RegisterUserController@changeCurrPackage')->name('user.currPackage.change');
            Route::post('/user/current-package/add', 'Admin\RegisterUserController@addCurrPackage')->name('user.currPackage.add');
            Route::post('/user/next-package/remove', 'Admin\RegisterUserController@removeNextPackage')->name('user.nextPackage.remove');
            Route::post('/user/next-package/change', 'Admin\RegisterUserController@changeNextPackage')->name('user.nextPackage.change');
            Route::post('/user/next-package/add', 'Admin\RegisterUserController@addNextPackage')->name('user.nextPackage.add');
            Route::post('register/user/delete', 'Admin\RegisterUserController@delete')->name('register.user.delete');
            Route::post('register/user/bulk-delete', 'Admin\RegisterUserController@bulkDelete')->name('register.user.bulk.delete');
            Route::get('register/user/{id}/changePassword', 'Admin\RegisterUserController@changePass')->name('register.user.changePass');
            Route::post('register/user/updatePassword', 'Admin\RegisterUserController@updatePassword')->name('register.user.updatePassword');
            //Register User end
        });

        Route::group(['middleware' => 'checkpermission:FAQ Management'], function () {
            // Admin FAQ Routes
            Route::get('/faqs', 'Admin\FaqController@index')->name('admin.faq.index');
            Route::get('/faq/create', 'Admin\FaqController@create')->name('admin.faq.create');
            Route::post('/faq/store', 'Admin\FaqController@store')->name('admin.faq.store');
            Route::post('/faq/update', 'Admin\FaqController@update')->name('admin.faq.update');
            Route::post('/faq/delete', 'Admin\FaqController@delete')->name('admin.faq.delete');
            Route::post('/faq/bulk-delete', 'Admin\FaqController@bulkDelete')->name('admin.faq.bulk.delete');
        });


        Route::group(['middleware' => 'checkpermission:Blogs'], function () {
            // Admin Blog Category Routes
            Route::get('/bcategorys', 'Admin\BcategoryController@index')->name('admin.bcategory.index');
            Route::post('/bcategory/store', 'Admin\BcategoryController@store')->name('admin.bcategory.store');
            Route::post('/bcategory/update', 'Admin\BcategoryController@update')->name('admin.bcategory.update');
            Route::post('/bcategory/delete', 'Admin\BcategoryController@delete')->name('admin.bcategory.delete');
            Route::post('/bcategory/bulk-delete', 'Admin\BcategoryController@bulkDelete')->name('admin.bcategory.bulk.delete');


            // Admin Blog Routes
            Route::get('/blogs', 'Admin\BlogController@index')->name('admin.blog.index');
            Route::post('/blog/upload', 'Admin\BlogController@upload')->name('admin.blog.upload');
            Route::post('/blog/store', 'Admin\BlogController@store')->name('admin.blog.store');
            Route::get('/blog/{id}/edit', 'Admin\BlogController@edit')->name('admin.blog.edit');
            Route::post('/blog/update', 'Admin\BlogController@update')->name('admin.blog.update');
            Route::post('/blog/{id}/uploadUpdate', 'Admin\BlogController@uploadUpdate')->name('admin.blog.uploadUpdate');
            Route::post('/blog/delete', 'Admin\BlogController@delete')->name('admin.blog.delete');
            Route::post('/blog/bulk-delete', 'Admin\BlogController@bulkDelete')->name('admin.blog.bulk.delete');
            Route::get('/blog/{langid}/getcats', 'Admin\BlogController@getcats')->name('admin.blog.getcats');
        });

        Route::group(['middleware' => 'checkpermission:Sitemap'], function () {
            Route::get('/sitemap', 'Admin\SitemapController@index')->name('admin.sitemap.index');
            Route::post('/sitemap/store', 'Admin\SitemapController@store')->name('admin.sitemap.store');
            Route::get('/sitemap/{id}/update', 'Admin\SitemapController@update')->name('admin.sitemap.update');
            Route::post('/sitemap/{id}/delete', 'Admin\SitemapController@delete')->name('admin.sitemap.delete');
            Route::post('/sitemap/download', 'Admin\SitemapController@download')->name('admin.sitemap.download');
        });

        Route::group(['middleware' => 'checkpermission:Contact Page'], function () {
            // Admin Contact Routes
            Route::get('/contact', 'Admin\ContactController@index')->name('admin.contact.index');
            Route::post('/contact/{langid}/post', 'Admin\ContactController@update')->name('admin.contact.update');
        });

        Route::group(['middleware' => 'checkpermission:Payment Gateways'], function () {
            // Admin Online Gateways Routes
            Route::get('/gateways', 'Admin\GatewayController@index')->name('admin.gateway.index');
            Route::post('/stripe/update', 'Admin\GatewayController@stripeUpdate')->name('admin.stripe.update');
            Route::post('/anet/update', 'Admin\GatewayController@anetUpdate')->name('admin.anet.update');
            Route::post('/paypal/update', 'Admin\GatewayController@paypalUpdate')->name('admin.paypal.update');
            Route::post('/paystack/update', 'Admin\GatewayController@paystackUpdate')->name('admin.paystack.update');
            Route::post('/paytm/update', 'Admin\GatewayController@paytmUpdate')->name('admin.paytm.update');
            Route::post('/flutterwave/update', 'Admin\GatewayController@flutterwaveUpdate')->name('admin.flutterwave.update');
            Route::post('/instamojo/update', 'Admin\GatewayController@instamojoUpdate')->name('admin.instamojo.update');
            Route::post('/mollie/update', 'Admin\GatewayController@mollieUpdate')->name('admin.mollie.update');
            Route::post('/razorpay/update', 'Admin\GatewayController@razorpayUpdate')->name('admin.razorpay.update');
            Route::post('/mercadopago/update', 'Admin\GatewayController@mercadopagoUpdate')->name('admin.mercadopago.update');

            // Admin Offline Gateway Routes
            Route::get('/offline/gateways', 'Admin\GatewayController@offline')->name('admin.gateway.offline');
            Route::post('/offline/gateway/store', 'Admin\GatewayController@store')->name('admin.gateway.offline.store');
            Route::post('/offline/gateway/update', 'Admin\GatewayController@update')->name('admin.gateway.offline.update');
            Route::post('/offline/status', 'Admin\GatewayController@status')->name('admin.offline.status');
            Route::post('/offline/gateway/delete', 'Admin\GatewayController@delete')->name('admin.offline.gateway.delete');
        });

        Route::group(['middleware' => 'checkpermission:Role Management'], function () {
            // Admin Roles Routes
            Route::get('/roles', 'Admin\RoleController@index')->name('admin.role.index');
            Route::post('/role/store', 'Admin\RoleController@store')->name('admin.role.store');
            Route::post('/role/update', 'Admin\RoleController@update')->name('admin.role.update');
            Route::post('/role/delete', 'Admin\RoleController@delete')->name('admin.role.delete');
            Route::get('role/{id}/permissions/manage', 'Admin\RoleController@managePermissions')->name('admin.role.permissions.manage');
            Route::post('role/permissions/update', 'Admin\RoleController@updatePermissions')->name('admin.role.permissions.update');
        });

        Route::group(['middleware' => 'checkpermission:Admins Management'], function () {
            // Admin Users Routes
            Route::get('/users', 'Admin\UserController@index')->name('admin.user.index');
            Route::post('/user/upload', 'Admin\UserController@upload')->name('admin.user.upload');
            Route::post('/user/store', 'Admin\UserController@store')->name('admin.user.store');
            Route::get('/user/{id}/edit', 'Admin\UserController@edit')->name('admin.user.edit');
            Route::post('/user/update', 'Admin\UserController@update')->name('admin.user.update');
            Route::post('/user/{id}/uploadUpdate', 'Admin\UserController@uploadUpdate')->name('admin.user.uploadUpdate');
            Route::post('/user/delete', 'Admin\UserController@delete')->name('admin.user.delete');
        });

        Route::group(['middleware' => 'checkpermission:Language Management'], function () {
            // Admin Language Routes
            Route::get('/languages', 'Admin\LanguageController@index')->name('admin.language.index');
            Route::get('/language/{id}/edit', 'Admin\LanguageController@edit')->name('admin.language.edit');
            Route::get('/language/{id}/edit/keyword', 'Admin\LanguageController@editKeyword')->name('admin.language.editKeyword');
            Route::post('/language/store', 'Admin\LanguageController@store')->name('admin.language.store');
            Route::post('/language/upload', 'Admin\LanguageController@upload')->name('admin.language.upload');
            Route::post('/language/{id}/uploadUpdate', 'Admin\LanguageController@uploadUpdate')->name('admin.language.uploadUpdate');
            Route::post('/language/{id}/default', 'Admin\LanguageController@default')->name('admin.language.default');
            Route::post('/language/{id}/delete', 'Admin\LanguageController@delete')->name('admin.language.delete');
            Route::post('/language/update', 'Admin\LanguageController@update')->name('admin.language.update');
            Route::post('/language/{id}/update/keyword', 'Admin\LanguageController@updateKeyword')->name('admin.language.updateKeyword');
        });

        // Admin Cache Clear Routes
        Route::get('/cache-clear', 'Admin\CacheController@clear')->name('admin.cache.clear');

        Route::group(['middleware' => 'checkpermission:Packages'], function () {
            // Package Settings routes
            Route::get('/package/settings', 'Admin\PackageController@settings')->name('admin.package.settings');
            Route::post('/package/settings', 'Admin\PackageController@updateSettings')->name('admin.package.settings');
            // Package Settings routes
            Route::get('/package/features', 'Admin\PackageController@features')->name('admin.package.features');
            Route::post('/package/features', 'Admin\PackageController@updateFeatures')->name('admin.package.features');
            // Package routes
            Route::get('packages', 'Admin\PackageController@index')->name('admin.package.index');
            Route::post('package/upload', 'Admin\PackageController@upload')->name('admin.package.upload');
            Route::post('package/store', 'Admin\PackageController@store')->name('admin.package.store');
            Route::get('package/{id}/edit', 'Admin\PackageController@edit')->name('admin.package.edit');
            Route::post('package/update', 'Admin\PackageController@update')->name('admin.package.update');
            Route::post('package/{id}/uploadUpdate', 'Admin\PackageController@uploadUpdate')->name('admin.package.uploadUpdate');
            Route::post('package/delete', 'Admin\PackageController@delete')->name('admin.package.delete');
            Route::post('package/bulk-delete', 'Admin\PackageController@bulkDelete')->name('admin.package.bulk.delete');

            // Admin Coupon Routes
            Route::get('/coupon', 'Admin\CouponController@index')->name('admin.coupon.index');
            Route::post('/coupon/store', 'Admin\CouponController@store')->name('admin.coupon.store');
            Route::get('/coupon/{id}/edit', 'Admin\CouponController@edit')->name('admin.coupon.edit');
            Route::post('/coupon/update', 'Admin\CouponController@update')->name('admin.coupon.update');
            Route::post('/coupon/delete', 'Admin\CouponController@delete')->name('admin.coupon.delete');
            // Admin Coupon Routes End
        });

        Route::group(['middleware' => 'checkpermission:Payment Log'], function () {
            // Payment Log
            Route::get('/payment-log', 'Admin\PaymentLogController@index')->name('admin.payment-log.index');
            Route::post('/payment-log/update', 'Admin\PaymentLogController@update')->name('admin.payment-log.update');
        });

        // Custom Domains
        Route::group(['middleware' => 'checkpermission:Custom Domains'], function () {
            Route::get('/domains', 'Admin\CustomDomainController@index')->name('admin.custom-domain.index');
            Route::get('/domain/texts', 'Admin\CustomDomainController@texts')->name('admin.custom-domain.texts');
            Route::post('/domain/texts', 'Admin\CustomDomainController@updateTexts')->name('admin.custom-domain.texts');
            Route::post('/domain/status', 'Admin\CustomDomainController@status')->name('admin.custom-domain.status');
            Route::post('/domain/mail', 'Admin\CustomDomainController@mail')->name('admin.custom-domain.mail');
            Route::post('/domain/delete', 'Admin\CustomDomainController@delete')->name('admin.custom-domain.delete');
            Route::post('/domain/bulk-delete', 'Admin\CustomDomainController@bulkDelete')->name('admin.custom-domain.bulk.delete');
        });

        // Subdomains
        Route::group(['middleware' => 'checkpermission:Subdomains'], function () {
            Route::get('/subdomains', 'Admin\SubdomainController@index')->name('admin.subdomain.index');
            Route::post('/subdomain/status', 'Admin\SubdomainController@status')->name('admin.subdomain.status');
            Route::post('/subdomain/mail', 'Admin\SubdomainController@mail')->name('admin.subdomain.mail');
        });
    });

    Route::group(['middleware' => ['web']], function () {
        Route::post('/coupon', 'Front\CheckoutController@coupon')->name('front.membership.coupon');
        Route::post('/membership/checkout', 'Front\CheckoutController@checkout')->name('front.membership.checkout');
        Route::post('/payment/instructions', 'Front\FrontendController@paymentInstruction')->name('front.payment.instructions');
        Route::post('/contact/message', 'Front\FrontendController@contactMessage')->name('front.contact.message');
        Route::post('/admin/contact-msg', 'Front\FrontendController@adminContactMessage')->name('front.admin.contact.message');

        //checkout payment gateway routes
        Route::prefix('membership')->middleware('setlang')->group(function () {
            Route::get('paypal/success', "Payment\PaypalController@successPayment")->name('membership.paypal.success');
            Route::get('paypal/cancel', "Payment\PaypalController@cancelPayment")->name('membership.paypal.cancel');
            Route::get('stripe/cancel', "Payment\StripeController@cancelPayment")->name('membership.stripe.cancel');
            Route::post('paytm/payment-status', "Payment\PaytmController@paymentStatus")->name('membership.paytm.status');
            Route::get('paystack/success', 'Payment\PaystackController@successPayment')->name('membership.paystack.success');
            Route::post('mercadopago/cancel', 'Payment\paymenMercadopagoController@cancelPayment')->name('membership.mercadopago.cancel');
            Route::post('mercadopago/success', 'Payment\MercadopagoController@successPayment')->name('membership.mercadopago.success');
            Route::post('razorpay/success', 'Payment\RazorpayController@successPayment')->name('membership.razorpay.success');
            Route::post('razorpay/cancel', 'Payment\RazorpayController@cancelPayment')->name('membership.razorpay.cancel');
            Route::get('instamojo/success', 'Payment\InstamojoController@successPayment')->name('membership.instamojo.success');
            Route::post('instamojo/cancel', 'Payment\InstamojoController@cancelPayment')->name('membership.instamojo.cancel');
            Route::post('flutterwave/success', 'Payment\FlutterWaveController@successPayment')->name('membership.flutterwave.success');
            Route::post('flutterwave/cancel', 'Payment\FlutterWaveController@cancelPayment')->name('membership.flutterwave.cancel');
            Route::get('/mollie/success', 'Payment\MollieController@successPayment')->name('membership.mollie.success');
            Route::post('mollie/cancel', 'Payment\MollieController@cancelPayment')->name('membership.mollie.cancel');
            Route::get('anet/cancel', 'Payment\AuthorizenetController@cancelPayment')->name('membership.anet.cancel');
            Route::get('/offline/success', 'Front\CheckoutController@offlineSuccess')->name('membership.offline.success');
            Route::get('/trial/success', 'Front\CheckoutController@trialSuccess')->name('membership.trial.success');
        });
    });
});

$parsedUrl = parse_url(url()->current());

$host = str_replace("www.", "", $parsedUrl['host']);
if (array_key_exists('host', $parsedUrl)) {
    // if it is a path based URL
    if ($host == env('WEBSITE_HOST')) {
        $domain = $domain;
        $prefix = '/{username}';
    }
    // if it is a subdomain / custom domain
    else {
        if (!app()->runningInConsole()) {
            if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
                $domain = 'www.{domain}';
            } else {
                $domain = '{domain}';
            }
        }
        $prefix = '';
    }
}

Route::group(['domain' => $domain, 'prefix' => $prefix, 'middleware' => 'userMaintenance'], function () {
    Route::get('/', 'Front\FrontendController@userDetailView')->name('front.user.detail.view');

    Route::get('/courses', 'Front\Curriculum\CourseController@courses')->name('front.user.courses');
    Route::get('/course/{slug}', 'Front\Curriculum\CourseController@details')->name('front.user.course.details');
    Route::post('/course-enrolment/apply-coupon', 'Front\Curriculum\CourseController@applyCoupon')
        ->middleware('routeAccess:Coupon')
        ->name('front.user.course.enrolment.apply.coupon');
    Route::post('/course-enrolment/{id}', 'Front\Curriculum\EnrolmentController@enrolment')->name('front.user.course.enrolment');
    Route::get('/instructors', 'Front\InstructorController@instructors')->name('front.user.instructors');


    Route::group(['middleware' => ['routeAccess:Blog']], function () {
        Route::get('/blog', 'Front\BlogController@blogs')->name('front.user.blogs');
        Route::get('/blog/{slug}', 'Front\BlogController@details')->name('front.user.blog_details');
    });

    Route::post('/subscribe', 'User\SubscriberController@store')->name('front.user.subscriber');
    Route::get('/contact', 'Front\FrontendController@contact')->name('front.user.contact');
    Route::post('/contact/message', 'Front\FrontendController@contactMessage')->name('front.contact.message');
    Route::get('/faqs', 'Front\FrontendController@userFaqs')->name('front.user.faq');

    Route::group(['middleware' => ['routeAccess:vCard']], function () {
        Route::get('/vcard/{id}', 'Front\FrontendController@vcard')->name('front.user.vcard');
        Route::get('/vcard-import/{id}', 'Front\FrontendController@vcardImport')->name('front.user.vcardImport');
    });

    Route::get('/user/changelanguage', 'Front\FrontendController@changeUserLanguage')->name('changeUserLanguage');

    Route::get('apply/{token}', 'Front\FrontendController@removeMaintenance')->name('front.user.remove')->withoutMiddleware(UserMaintenance::class);

    Route::group(['middleware' => ['routeAccess:Custom Page']], function () {
        Route::get('/{slug}', 'Front\FrontendController@userCPage')->name('front.user.cpage');
    });



    // customers route

    Route::get('/course-enrolment/{id}/complete/{via?}', 'Front\Curriculum\EnrolmentController@complete')->name('front.user.course_enrolment.complete');
    Route::get('/course-enrolment/{id}/cancel', 'Front\Curriculum\EnrolmentController@cancel')->name('front.user.course_enrolment.cancel');
    Route::post('/course/{id}/store-feedback', 'Front\Curriculum\CourseController@storeFeedback')->name('front.user.course.store_feedback');

    Route::prefix('/user')->middleware(['guest:customer'])->group(function () {
        // user redirect to login page route
        Route::get('/login',  'Front\CustomerController@login')->name('customer.login');
        // user login submit route
        Route::post('/login-submit', 'Front\CustomerController@loginSubmit')->name('customer.login_submit');
        // user forget password route
        Route::get('/forget-password', 'Front\CustomerController@forgetPassword')->name('customer.forget_password');
        // send mail to user for forget password route
        Route::post('/send-forget-password-mail', 'Front\CustomerController@sendMail')->name('customer.send_forget_password_mail');
        // reset password route
        Route::get('/reset-password', 'Front\CustomerController@resetPassword')->name('customer.reset_password');
        // user reset password submit route
        Route::post('/reset-password-submit', 'Front\CustomerController@resetPasswordSubmit')->name('customer.reset_password_submit');
        // user redirect to signup page route
        Route::get('/signup', 'Front\CustomerController@signup')->name('customer.signup');
        // user signup submit route
        Route::post('/signup-submit', 'Front\CustomerController@signupSubmit')->name('customer.signup.submit');
        // signup verify route
        Route::get('/signup-verify/{token}', 'Front\CustomerController@signupVerify')->name('customer.signup.verify');
    });

    Route::prefix('/user')->middleware(['accountStatus', 'checkWebsiteOwner'])->group(function () {
        // course curriculum route
        Route::get('/my-course/{id}/curriculum', 'Front\CustomerController@curriculum')->name('customer.my_course.curriculum');
    });

    Route::prefix('/user')->middleware(['auth:customer', 'accountStatus', 'checkWebsiteOwner'])->group(function () {
        // user redirect to dashboard route
        Route::get('/dashboard', 'Front\CustomerController@redirectToDashboard')->name('customer.dashboard');
        // edit profile route
        Route::get('/edit-profile', 'Front\CustomerController@editProfile')->name('customer.edit_profile');
        // update profile route
        Route::post('/update-profile', 'Front\CustomerController@updateProfile')->name('customer.update_profile');
        // change password route
        Route::get('/change-password',  'Front\CustomerController@changePassword')->name('customer.change_password');
        // update password route
        Route::post('/update-password',  'Front\CustomerController@updatePassword')->name('customer.update_password');
        // user logout attempt route
        Route::get('/logout',  'Front\CustomerController@logoutSubmit')->name('customer.logout');
        // all enrolment courses route
        Route::get('/my-courses', 'Front\CustomerController@myCourses')->name('customer.my_courses');

        // download lesson file route
        Route::post('/my-course/curriculum/{id}/download-file', 'Front\CustomerController@downloadFile')->name('customer.my_course.curriculum.download_file')->withoutMiddleware('change.lang');
        // check quiz's answer route
        Route::get('/my-course/curriculum/check-answer', 'Front\CustomerController@checkAns')->name('customer.my_course.curriculum.check_ans')->withoutMiddleware('change.lang');
        // store quiz's score route
        Route::post('/my-course/curriculum/store-quiz-score', 'Front\CustomerController@storeQuizScore')->name('customer.my_course.curriculum.store_quiz_score')->withoutMiddleware('change.lang');
        // lesson-content completion route
        Route::post('/my-course/curriculum/content-completion', 'Front\CustomerController@contentCompletion')->name('customer.my_course.curriculum.content_completion')->withoutMiddleware('change.lang');
        // get course certificate route
        Route::get('/my-course/{id}/get-certificate', 'Front\CustomerController@getCertificate')
            ->name('customer.my_course.get_certificate')
            ->middleware(['certificate.status', 'routeAccess:Course Completion Certificate']);
        // purchase history route
        Route::get('/purchase-history', 'Front\CustomerController@purchaseHistory')->name('customer.purchase_history');
    });
    //user payment gateways
    Route::get('/course-enrolment/paypal/notify', 'CoursePayment\PayPalController@notify')->name('course_enrolment.paypal.notify');

    Route::get('/course-enrolment/instamojo/notify', 'CoursePayment\InstamojoController@notify')->name('course_enrolment.instamojo.notify');

    Route::get('/course-enrolment/paystack/notify', 'CoursePayment\PaystackController@notify')->name('course_enrolment.paystack.notify');

    Route::post('/course-enrolment/flutterwave/notify', 'CoursePayment\FlutterwaveController@notify')->name('course_enrolment.flutterwave.notify');

    Route::post('/course-enrolment/razorpay/notify', 'CoursePayment\RazorpayController@notify')->name('course_enrolment.razorpay.notify');

    Route::post('/course-enrolment/mercadopago/notify', 'CoursePayment\MercadoPagoController@notify')->name('course_enrolment.mercadopago.notify');

    Route::get('/course-enrolment/mollie/notify', 'CoursePayment\MollieController@notify')->name('course_enrolment.mollie.notify');

    Route::post('/course-enrolment/paytm/notify', 'CoursePayment\PaytmController@notify')->name('course_enrolment.paytm.notify');
});
