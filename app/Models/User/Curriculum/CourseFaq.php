<?php

namespace App\Models\User\Curriculum;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CourseFaq extends Model
{
  use HasFactory;

  protected $table = 'user_course_faqs';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'course_id',
      'language_id',
      'user_id',
      'question',
      'answer',
      'serial_number'
  ];

  public function course()
  {
    return $this->belongsTo(Course::class,'course_id');
  }

  public function language()
  {
    return $this->belongsTo(Language::class,'language_id');
  }
}
