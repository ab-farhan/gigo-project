<?php

namespace App\Http\Middleware;

use App\Models\User\Curriculum\Course;
use Closure;
use Illuminate\Http\Request;

class EnsureCertificateIsEnable
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $user = getUser();

    $courseId = $request->route('id');

    $course = Course::query()->where('user_id', $user->id)->findOrFail($courseId);

    if ($course->certificate_status == 1) {
      return $next($request);
    } else {
      $lesson_id = $request->session()->get('lessonId');
      return redirect()->route('customer.my_course.curriculum', [getParam() ,'id' => $courseId, 'lesson_id' => $lesson_id]);
    }
  }
}
