<?php

namespace App\Http\Controllers\User\Curriculum;

use App\Http\Controllers\Controller;
use App\Http\Helpers\LimitCheckerHelper;
use App\Http\Requests\CourseCategoryRequest;
use App\Models\User\BasicSetting;
use App\Models\User\Curriculum\CourseCategory;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['categories'] = CourseCategory::where('language_id', $information['language']->id)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->orderByDesc('id')
            ->get();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)
            ->select('theme_version')
            ->first();
        return view('user.curriculum.category.index', $information);
    }

    public function store(CourseCategoryRequest $request)
    {
        $count = LimitCheckerHelper::currentCourseCategoryCount(Auth::guard('web')->user()->id, $request->user_language_id);//category added count of selected language
        $category_limit = LimitCheckerHelper::courseCategoriesLimit(Auth::guard('web')->user()->id);//category limit count of current package

        if ($count >= $category_limit) {
            Session::flash('warning', 'Course Category Limit Exceeded');
            return "success";
        }

        CourseCategory::create($request->except('language_id','slug') + [
            'language_id' => $request->user_language_id,
            'slug' => slug_create($request->name),
            'user_id' => Auth::guard('web')->user()->id
        ]);
        $request->session()->flash('success', 'New course category added successfully!');
        return "success";
    }

    public function updateFeatured(Request $request, $id)
    {
        $category = CourseCategory::where('user_id', Auth::guard('web')->user()->id)->find($id);
        if ($request['is_featured'] == '1') {
            $category->update(['is_featured' => 1]);
            $request->session()->flash('success', 'Category featured successfully!');
        } else {
            $category->update(['is_featured' => 0]);
            $request->session()->flash('success', 'Category unfeatured successfully!');
        }
        return redirect()->back();
    }

    public function update(CourseCategoryRequest $request)
    {
        $cc = CourseCategory::where('user_id', Auth::guard('web')->user()->id)
            ->find($request->id);

        $count = LimitCheckerHelper::currentCourseCategoryCount(Auth::guard('web')->user()->id, $cc->language_id);//category added count of selected language
        $category_limit = LimitCheckerHelper::courseCategoriesLimit(Auth::guard('web')->user()->id);//category limit count of current package

        if ($count > $category_limit) {
            Session::flash('warning', 'Please delete some categories to enable "Edit" feature');
            return "success";
        }

        $ins = $request->all();
        $ins['slug'] = slug_create($request->name);
        $cc->update($ins);
        $request->session()->flash('success', 'Course category updated successfully!');
        return "success";
    }

    public function destroy($id)
    {
        $category = CourseCategory::where('user_id', Auth::guard('web')->user()->id)->find($id);
        if ($category->courseInfoList()->where('user_id', Auth::guard('web')->user()->id)->count() > 0) {
            return redirect()->back()->with('warning', 'First delete all the course under to this category!');
        } else {
            $category->delete();
            return redirect()->back()->with('success', 'Course category deleted successfully!');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        $errorOccured = false;
        foreach ($ids as $id) {
            $category = CourseCategory::where('user_id', Auth::guard('web')->user()->id)->find($id);
            $courseCount = $category->courseInfoList()->where('user_id', Auth::guard('web')->user()->id)->count();
            if ($courseCount > 0) {
                $errorOccured = true;
                break;
            } else {
                $category->delete();
            }
        }
        if ($errorOccured == true) {
            $request->session()->flash('warning', 'First delete all the course under to this categories!');
        } else {
            $request->session()->flash('success', 'Course categories deleted successfully!');
        }

        return "success";
    }
}
