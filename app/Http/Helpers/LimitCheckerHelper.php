<?php

namespace App\Http\Helpers;

use App\Models\Membership;
use App\Models\Package;
use App\Models\User\Curriculum\Course;
use App\Models\User\Curriculum\CourseCategory;
use App\Models\User\Curriculum\Lesson;
use App\Models\User\Curriculum\Module;
use Carbon\Carbon;

class LimitCheckerHelper
{
    public static function courseCategoriesLimit(int $user_id)
    {
        $id = Membership::query()->where([
            ['user_id', '=', $user_id],
            ['status','=',1],
            ['start_date','<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
        ->pluck('package_id')
        ->first();
        if (isset($id)) {
            $package = Package::query()->select('course_categories_limit')->findOrFail($id);
        }
        return isset($id) && isset($package) ? $package->course_categories_limit : 0;
    }

    public static function featuredCourseLimit(int $user_id)
    {
        $id =  Membership::query()->where([
            ['user_id', '=', $user_id],
            ['status','=',1],
            ['start_date','<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
        ->pluck('package_id')
        ->first();
        if (isset($id)) {
            $package = Package::query()->select('featured_course_limit')->find($id);
        }
        return isset($id) && isset($package) ? $package->featured_course_limit : 0;
    }

    public static function courseLimit(int $user_id)
    {
        $id = Membership::query()->where([
            ['user_id', '=', $user_id],
            ['status','=',1],
            ['start_date','<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
        ->pluck('package_id')
        ->first();
        if (isset($id)) {
            $package = Package::query()->select('course_limit')->findOrFail($id);
        }
        return isset($id) && isset($package) ? $package->course_limit : 0;
    }

    public static function moduleLimit(int $user_id)
    {
        $id = Membership::query()->where([
            ['user_id', '=', $user_id],
            ['status','=',1],
            ['start_date','<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
        ->pluck('package_id')
        ->first();
        if (isset($id)) {
            $package = Package::query()->select('module_limit')->findOrFail($id);
        }
        return isset($id) && isset($package) ? $package->module_limit : 0;
    }

    public static function lessonLimit(int $user_id)
    {
        $id = Membership::query()->where([
            ['user_id', '=', $user_id],
            ['status','=',1],
            ['start_date','<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
        ->pluck('package_id')
        ->first();
        if (isset($id)) {
            $package = Package::query()->select('lesson_limit')->findOrFail($id);
        }
        return isset($id) && isset($package) ? $package->lesson_limit : 0;

    }

    public static function currentCourseCategoryCount(int $user_id, int $langId): int
    {
        return CourseCategory::query()
            ->where('language_id', $langId)
            ->where('user_id', $user_id)
            ->count();
    }

    public static function currentCourseCount(int $user_id): int
    {
        return Course::query()
            ->where('user_id', $user_id)
            ->count();
    }

    public static function currentFeaturedCourseCount(int $user_id): int
    {
        return Course::query()
            ->where('user_id', $user_id)
            ->where('is_featured', 'yes')
            ->count();
    }

    public static function currentModulesCount(int $user_id, int $lang_id): int
    {
        return Module::query()
            ->where('user_id', $user_id)
            ->where('language_id', $lang_id)
            ->count();
    }

    public static function currentLessonsCount($user_id, $lang_id)
    {
        return Lesson::query()
            ->where('user_id', $user_id)
            ->where('language_id', $lang_id)
            ->count();
    }

    public static function storageLimit(int $user_id)
    {
        $id = Membership::query()->where([
            ['user_id', '=', $user_id],
            ['status','=',1],
            ['start_date','<=', Carbon::now()->format('Y-m-d')],
            ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
        ])
        ->pluck('package_id')
        ->first();

        if (isset($id)) {
            $package = Package::query()->select('storage_limit')->findOrFail($id);
        }
        return isset($id) && isset($package) ? $package->storage_limit : 0;
    }
}
