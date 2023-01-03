<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHeading extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'language_id',
    'user_id',
    'blog_page_title',
    'blog_details_page_title',
    'contact_page_title',
    'courses_page_title',
    'course_details_page_title',
    'faq_page_title',
    'forget_password_page_title',
    'instructors_page_title',
    'login_page_title',
    'signup_page_title'
  ];

  public function headingLang()
  {
    return $this->belongsTo(Language::class,'language_id');
  }
}
