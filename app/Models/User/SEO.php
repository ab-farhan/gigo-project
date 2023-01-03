<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    use HasFactory;

    protected $table = 'user_seos';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'language_id',
        'home_meta_keywords',
        'home_meta_description',
        'courses_meta_keywords',
        'courses_meta_description',
        'blogs_meta_keywords',
        'blogs_meta_description',
        'instructors_meta_keywords',
        'instructors_meta_description',
        'login_meta_keywords',
        'login_meta_description',
        'sign_up_meta_keywords',
        'sign_up_meta_description',
        'faqs_meta_keywords',
        'faqs_meta_description',
        'contact_meta_keywords',
        'contact_meta_description',
        'forget_password_meta_keywords',
        'forget_password_meta_description',
    ];

    public function language() {
        return $this->belongsTo(Language::class,'language_id');
    }
}
