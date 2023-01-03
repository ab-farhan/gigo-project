<?php

namespace App\Models\User;

use App\Models\User\Curriculum\CourseCategory;
use App\Models\User\Curriculum\CourseFaq;
use App\Models\User\Curriculum\CourseInformation;
use App\Models\User\CustomPage\Page;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\HomePage\AboutUsSection;
use App\Models\User\HomePage\ActionSection;
use App\Models\User\HomePage\Fact\CountInformation;
use App\Models\User\HomePage\Fact\FunFactSection;
use App\Models\User\HomePage\Feature;
use App\Models\User\HomePage\HeroSection;
use App\Models\User\HomePage\NewsletterSection;
use App\Models\User\HomePage\SectionTitle;
use App\Models\User\HomePage\Testimonial;
use App\Models\User\HomePage\VideoSection;
use App\Models\User\Journal\BlogCategory;
use App\Models\User\Journal\BlogInformation;
use App\Models\User\Teacher\Instructor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Language extends Model
{
    public $table = "user_languages";

    protected $fillable = [
        'id',
        'name',
        'is_default',
        'code',
        'rtl',
        'user_id',
        'keywords'
    ];

    public function pageName(): HasOne
    {
        return $this->hasOne(PageHeading::class,'language_id');
    }

    public function quick_links(): HasMany
    {
        return $this->hasMany(FooterQuickLink::class, 'language_id');
    }

    public function footer_texts(): HasOne
    {
        return $this->hasOne(FooterText::class, 'language_id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(FAQ::class, 'language_id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class,'user_id');
    }

    public function page_contents(): HasMany
    {
        return $this->hasMany(PageContent::class,'user_id');
    }

    public function menus(): HasOne
    {
        return $this->hasOne(Menu::class,'language_id');
    }

    public function seos(): HasMany
    {
        return $this->hasMany(SEO::class, 'language_id');
    }

    public function courseInformation(): HasMany
    {
        return $this->hasMany(CourseInformation::class, 'language_id');
    }

    public function heroSection(): HasOne
    {
        return $this->hasOne(HeroSection::class, 'language_id');
    }

    public function sectionTitle(): HasOne
    {
        return $this->hasOne(SectionTitle::class, 'language_id');
    }

    public function actionSection(): HasOne
    {
        return $this->hasOne(ActionSection::class, 'language_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class, 'language_id');
    }

    public function videoSection(): HasOne
    {
        return $this->hasOne(VideoSection::class, 'language_id');
    }

    public function funFactSection(): HasOne
    {
        return $this->hasOne(FunFactSection::class, 'language_id');
    }

    public function countInfo(): HasMany
    {
        return $this->hasMany(CountInformation::class, 'language_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'language_id');
    }

    public function newsletterSection(): HasOne
    {
        return $this->hasOne(NewsletterSection::class, 'language_id');
    }

    public function aboutUsSection(): HasOne
    {
        return $this->hasOne(AboutUsSection::class, 'language_id');
    }

    public function blogCategory(): HasMany
    {
        return $this->hasMany(BlogCategory::class);
    }

    public function blogInformation(): HasMany
    {
        return $this->hasMany(BlogInformation::class);
    }

    public function customPageInfo(): HasMany
    {
        return $this->hasMany(PageContent::class,'language_id');
    }

    public function cookieAlertInfo(): HasOne
    {
        return $this->hasOne(CookieAlert::class,'language_id');
    }

    public function courseCategory(): HasMany
    {
        return $this->hasMany(CourseCategory::class,'language_id');
    }

    public function courseFaq(): HasMany
    {
        return $this->hasMany(CourseFaq::class,'language_id');
    }

    public function instructor(): HasMany
    {
        return $this->hasMany(Instructor::class,'language_id');
    }

    public function announcementPopup(): HasMany
    {
        return $this->hasMany(Popup::class,'language_id');
    }
}
