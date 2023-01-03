<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use App\Models\BasicSetting as ModelsBasicSetting;
use App\Models\User\Advertisement;
use App\Models\User\BasicSetting;
use App\Models\User\CookieAlert;
use App\Models\User\Curriculum\Coupon;
use App\Models\User\Curriculum\CourseInformation;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\FooterQuickLink;
use App\Models\User\FooterText;
use App\Models\User\HomePage\AboutUsSection;
use App\Models\User\HomePage\ActionSection;
use App\Models\User\HomePage\Fact\CountInformation;
use App\Models\User\HomePage\Fact\FunFactSection;
use App\Models\User\HomePage\Feature;
use App\Models\User\HomePage\HeroSection;
use App\Models\User\HomePage\NewsletterSection;
use App\Models\User\HomePage\Section;
use App\Models\User\HomePage\SectionTitle;
use App\Models\User\HomePage\Testimonial;
use App\Models\User\HomePage\VideoSection;
use App\Models\User\Journal\Blog;
use App\Models\User\Journal\BlogCategory;
use App\Models\User\Language;
use App\Models\User\Menu;
use App\Models\User\PageHeading;
use App\Models\User\Popup;
use App\Models\User\Social;
use App\Models\User\SEO;
use App\Models\User\FAQ;
use App\Models\User\Subscriber;
use App\Models\User\CustomPage\Page;
use App\Models\User\MailTemplate;
use App\Models\User\Teacher\Instructor;
use App\Models\User\UserCustomDomain;
use App\Models\User\UserQrCode;
use App\Models\User\UserVcard;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'photo',
        'username',
        'password',
        'phone',
        'company_name',
        'city',
        'state',
        'address',
        'country',
        'status',
        'featured',
        'verification_link',
        'email_verified',
        'online_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_custom_domains() {
        return $this->hasMany('App\Models\User\UserCustomDomain','user_id');
    }

    public function page_heading(): HasOne
    {
        return $this->hasOne(PageHeading::class, 'user_id');
    }
    public function custom_domains(): HasMany
    {
        return $this->hasMany(UserCustomDomain::class);
    }
    public function mail_templates(): HasMany
    {
        return $this->hasMany(MailTemplate::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'user_id');
    }

    public function basic_setting(): HasOne
    {
        return $this->hasOne(BasicSetting::class, 'user_id');
    }

    public function qr_codes(): HasMany
    {
        return $this->hasMany(UserQrCode::class, 'user_id');
    }

    public function counterInformations(): HasMany
    {
        return $this->hasMany(CountInformation::class, 'user_id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(FAQ::class, 'user_id');
    }

    public function seos(): HasMany
    {
        return $this->hasMany(SEO::class, 'user_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'user_id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function blog_categories(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'user_id');
    }

    public function social_media(): HasMany
    {
        return $this->hasMany(Social::class, 'user_id');
    }

    public function languages()
    {
        return $this->hasMany(Language::class, 'user_id');
    }

    public function footer_quick_links()
    {
        return $this->hasMany(FooterQuickLink::class, 'user_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class, 'user_id');
    }

    public function footer_texts(): HasMany
    {
        return $this->hasMany(FooterText::class, 'user_id');
    }

    public function vcards(): HasMany
    {
        return $this->hasMany(UserVcard::class, 'user_id');
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'user_id');
    }

    public function home_section(): HasOne
    {
        return $this->hasOne(Section::class, 'user_id');
    }

    public function hero_sections(): HasMany
    {
        return $this->hasMany(HeroSection::class, 'user_id');
    }

    public function instructors(): HasMany
    {
        return $this->hasMany(Instructor::class,'user_id');
    }

    public function courseInformation(): HasMany
    {
        return $this->hasMany(CourseInformation::class,'user_id');
    }

    public function advertisements():HasMany
    {
        return $this->hasMany(Advertisement::class, 'user_id');
    }

    public function coupons():HasMany
    {
        return $this->hasMany(Coupon::class, 'user_id');
    }

    public function sectionTitle(): HasOne
    {
        return $this->hasOne(SectionTitle::class, 'user_id');
    }

    public function announcementPopup(): HasMany
    {
        return $this->hasMany(Popup::class,'user_id');
    }

    public function videoSection(): HasOne
    {
        return $this->hasOne(VideoSection::class, 'user_id');
    }

    public function customPageInfo(): HasMany
    {
        return $this->hasMany(PageContent::class,'user_id');
    }

    public function newsletterSection(): HasOne
    {
        return $this->hasOne(NewsletterSection::class, 'user_id');
    }

    public function cookieAlertInfo(): HasOne
    {
        return $this->hasOne(CookieAlert::class,'user_id');
    }

    public function about_us_section(): HasMany
    {
        return $this->hasMany(AboutUsSection::class, 'user_id');
    }

    public function fun_fact_sections(): HasMany
    {
        return $this->hasMany(FunFactSection::class, 'user_id');
    }
    public function features(): HasMany
    {
        return $this->hasMany(Feature::class, 'user_id');
    }
    public function online_gateways(): HasMany
    {
       return $this->hasMany(\App\Models\User\PaymentGateway::class, 'user_id');
    }
    public function offline_gateways(): HasMany
    {
        return $this->hasMany(\App\Models\User\OfflineGateway::class, 'user_id');
    }
    public function actionSection(): HasOne
    {
        return $this->hasOne(ActionSection::class, 'user_id');
    }
    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $username = User::query()->where('email', request()->email)->pluck('username')->first();
        $bs = ModelsBasicSetting::select('website_title')->first();
        $subject = 'Password Reset (' . $bs->website_title . ')';
        $body = "Please click the below link to reset your password.
            <br>
             <br>
             <a href='" . url('password/reset/' . $token . '/email/' . request()->email) . "'>" . url('password/reset/' . $token . '/email/' . request()->email) . "</a>
             <br>
             <br>
             Thank you.
             ";
        $controller = new Controller();
        $controller->resetPasswordMail(request()->email, $username, $subject, $body);
        session()->flash('success', "we sent you an email. Please check your inbox");
    }

}
