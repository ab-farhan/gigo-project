<?php

namespace App\Providers;

use App\Http\Helpers\UserPermissionHelper;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Social;
use App\Models\User;
use App\Models\User\BasicSetting;
use App\Models\User\CookieAlert;
use App\Models\User\FooterQuickLink;
use App\Models\User\FooterText;
use App\Models\User\HomePage\NewsletterSection;
use App\Models\User\HomePage\Section;
use App\Models\User\Journal\Blog;
use App\Models\User\Language as UserLanguage;
use App\Models\User\Menu as UserMenu;
use App\Models\User\SEO;
use App\Models\User\Social as UserSocialMedia;
use App\Models\User\UserContact;
use App\Models\User\UserPermission;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function changePreferences($userId) {
        $currentPackage = UserPermissionHelper::currentPackage($userId);

        $preference = UserPermission::where([
            ['user_id',$userId]
        ])->first();

        // if current package does not match with 'package_id' of 'user_permissions' table, then change 'package_id' in 'user_permissions'
        if (!empty($currentPackage) && ($currentPackage->id != $preference->package_id)) {
            $preference->package_id = $currentPackage->id;

            $features = !empty($currentPackage->features) ? json_decode($currentPackage->features, true) : [];
            $features[] = "Contact";
            $preference->permissions = json_encode($features);
            $preference->package_id = $currentPackage->id;
            $preference->save();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (!app()->runningInConsole()) {
            $socials = Social::orderBy('serial_number', 'ASC')->get();
            $langs = Language::all();
    
            View::composer('*', function ($view)
            {
                if (session()->has('lang')) {
                    $currentLang = Language::where('code', session()->get('lang'))->first();
                } else {
                    $currentLang = Language::where('is_default', 1)->first();
                }
    
                $bs = $currentLang->basic_setting;
                $be = $currentLang->basic_extended;
    
                if (Menu::where('language_id', $currentLang->id)->count() > 0) {
                    $menus = Menu::where('language_id', $currentLang->id)->first()->menus;
                } else {
                    $menus = json_encode([]);
                }
    
                if ($currentLang->rtl == 1) {
                    $rtl = 1;
                } else {
                    $rtl = 0;
                }
    
                $view->with('bs', $bs );
                $view->with('be', $be );
                $view->with('currentLang', $currentLang );
                $view->with('menus', $menus );
                $view->with('rtl', $rtl );
            });
    
            View::composer(['user.*'], function ($view)
            {
                if (Auth::check()) {
                    $userId = Auth::guard('web')->user()->id;
                    // change package_id in 'user_permissions' 
                    $this->changePreferences($userId);
                    $userBs = BasicSetting::query()
                        ->where('user_id', Auth::user()->id)
                        ->first();
                    $view->with('userBs', $userBs );
                }
            });
    
            View::composer(['user-front.*'], function ($view)
            {
                $user = getUser();
                // change package_id in 'user_permissions' 
                $this->changePreferences($user->id);
                
                if (session()->has('user_lang')) {
                    $userCurrentLang = UserLanguage::query()->where('code', session()->get('user_lang'))->where('user_id', $user->id)->first();
                    if (empty($userCurrentLang)) {
                        $userCurrentLang = UserLanguage::query()->where('is_default', 1)->where('user_id', $user->id)->first();
                        session()->put('user_lang', $userCurrentLang->code);
                    }
                } else {
                    $userCurrentLang = UserLanguage::query()->where('is_default', 1)->where('user_id', $user->id)->first();
                }
                $allLanguages = UserLanguage::query()->where('user_id', $user->id)->get();
                $socialMedias = UserSocialMedia::query()->where('user_id', $user->id)->get();
    
                $packagePermissions = UserPermissionHelper::packagePermission($user->id);
                $packagePermissions = json_decode($packagePermissions, true);
    
                $keywords = json_decode($userCurrentLang->keywords, true);
    
                if (UserMenu::query()->where('language_id', $userCurrentLang->id)->where('user_id', $user->id)->count() > 0) {
                    $userMenus = UserMenu::query()->where('language_id', $userCurrentLang->id)->where('user_id', $user->id)->first()->menus;
                } else {
                    $userMenus = json_encode([]);
                }
    
                $websiteInfo = BasicSetting::query()
                    ->where('user_id', $user->id)
                    ->select('favicon','website_title','logo','whatsapp_status','whatsapp_popup_status','whatsapp_number','whatsapp_header_title','whatsapp_popup_message')->first();
    
                // get the announcement popups
                $popups = $userCurrentLang->announcementPopup()->where('status', 1)->orderBy('serial_number', 'asc')->get();
    
                // get the cookie alert info
                $cookieAlert = CookieAlert::query()->where('user_id', $user->id)->where('language_id',$userCurrentLang->id)->first();
    
                // get footer section status (enable/disable) information
                $footerSectionStatus = Section::query()->where('user_id', $user->id)->pluck('footer_section_status')->first();
    
                $userBs = BasicSetting::query()->where('user_id', $user->id)->first();
    
                // get the footer info
                $footerData = FooterText::query()->where('user_id', $user->id)->where('language_id',$userCurrentLang->id)->first();
    
                if ($footerSectionStatus == 1) {
                    // get the footer info
    
                    // get the quick links of footer
                    $quickLinks = FooterQuickLink::query()
                        ->where('user_id', $user->id)
                        ->where('language_id',$userCurrentLang->id)
                        ->orderBy('serial_number', 'ASC')->get();
    
                    // get latest blogs
                    if ($userBs->theme_version != 3) {
                        $blogs = Blog::query()->join('user_blog_informations', 'user_blogs.id', '=', 'user_blog_informations.blog_id')
                            ->where('user_blog_informations.language_id', '=', $userCurrentLang->id)
                            ->where('user_blog_informations.user_id', '=', $user->id)
                            ->select('user_blogs.image', 'user_blogs.created_at', 'user_blog_informations.title', 'user_blog_informations.slug')
                            ->orderByDesc('user_blogs.created_at')
                            ->limit(3)
                            ->get();
                    }
    
                    // get newsletter title
                    if ($userBs->theme_version == 2) {
                        $newsletterTitle = NewsletterSection::query()->where('user_id', $user->id)->where('language_id',$userCurrentLang->id)->pluck('title')->first();
                    }
                }
                $view->with('footerSecStatus', $footerSectionStatus);
    
                if ($footerSectionStatus == 1) {
                    $view->with('quickLinkInfos', $quickLinks);
    
                    if ($userBs->theme_version != 3) {
                        $view->with('latestBlogInfos', $blogs);
                    }
    
                    if ($userBs->theme_version == 2) {
                        $view->with('newsletterTitle', $newsletterTitle);
                    }
                }
                $view->with('user', $user);
                $view->with('userBs', $userBs);
                $view->with('userMenus', $userMenus);
                $view->with('allLanguageInfos', $allLanguages);
                $view->with('socialMediaInfos', $socialMedias);
                $view->with('currentLanguageInfo', $userCurrentLang);
                $view->with('popupInfos', $popups);
                $view->with('cookieAlertInfo', $cookieAlert);
                $view->with('footerSecStatus', $footerSectionStatus);
                $view->with('keywords', $keywords);
                $view->with('packagePermissions', $packagePermissions);
                $view->with('websiteInfo', $websiteInfo);
                $view->with('footerInfo', $footerData);
            });
    
            View::share('langs', $langs);
            View::share('socials', $socials);
        }
    }
}
