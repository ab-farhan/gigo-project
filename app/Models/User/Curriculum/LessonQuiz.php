<?php

namespace App\Models\User\Curriculum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LessonQuiz extends Model
{
  use HasFactory;

    protected $table = 'user_lesson_quizzes';


    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id','lesson_id', 'question', 'answers'];

  public function lesson()
  {
    return $this->belongsTo(Lesson::class,'lesson_id');
  }

  public function content()
  {
    return $this->belongsTo(LessonContent::class, 'lesson_content_id', 'id');
  }
}
