<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User\SEO;
use App\Models\User\Teacher\Instructor;
use App\Models\User\Teacher\SocialLink;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
  public function instructors($domain)
  {
    $user = getUser();

    $language = $this->getUserCurrentLanguage($user->id);

    $queryResult['seoInfo'] = SEO::query()->where('user_id', $user->id)->select('instructors_meta_keywords', 'instructors_meta_description')->first();

    $queryResult['pageHeading'] = $this->getUserPageHeading($language, $user->id);

    $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);

    $instructors = Instructor::query()->where('user_id', $user->id)->where('language_id', $language->id)->get();

    $instructors->map(function ($instructor) use ($user) {
      $instructor['socials'] = SocialLink::query()->where('user_id', $user->id)
          ->where('instructor_id', $instructor->id)
          ->orderBy('serial_number', 'ASC')
          ->get();
    });

    $queryResult['instructors'] = $instructors;
    return view('user-front.common.instructors', $queryResult);
  }
}
