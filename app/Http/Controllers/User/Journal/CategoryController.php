<?php

namespace App\Http\Controllers\User\Journal;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\User\Journal\BlogCategory;
use App\Models\User\Journal\BlogInformation;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['categories'] = BlogCategory::where('language_id', $information['language']->id)->orderByDesc('id')->get();
        return view('user.journal.category.index', $information);
    }

    public function store(BlogCategoryRequest $request)
    {
        BlogCategory::create($request->except('user_language_id', 'user_id') + [
            'language_id' => $request->user_language_id,
            'user_id' => Auth::guard('web')->user()->id,
            'slug' => slug_create($request->name)
        ]);
        $request->session()->flash('success', 'New blog category added successfully!');
        return "success";
    }

    public function update(BlogCategoryRequest $request)
    {
        BlogCategory::query()->where('user_id', Auth::guard('web')->user()->id)->find($request->id)->update($request->all() + [
            'slug' => slug_create($request->name)
        ]);
        $request->session()->flash('success', 'Blog category updated successfully!');
        return "success";
    }

    public function destroy($id)
    {
        $category = BlogCategory::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
        if (BlogInformation::where('user_id', Auth::guard('web')->user()->id)->where('blog_category_id', $category->id)->count() > 0) {
            return redirect()->back()->with('warning', 'First delete all the blog related to this category!');
        } else {
            $category->delete();
            return redirect()->back()->with('success', 'Blog category deleted successfully!');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $category = BlogCategory::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
            if (BlogInformation::where('user_id', Auth::guard('web')->user()->id)->where('blog_category_id', $category->id)->count() > 0) {
                $request->session()->flash('warning', 'First delete all the blog related to this categories!');
                break;
            } else {
                $category->delete();
                $request->session()->flash('success', 'Blog categories deleted successfully!');
            }
        }
        return "success";
    }
}
