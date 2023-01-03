<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $information['data'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('course_categories_section_image')->first();
        return view('user.home-page.course-category-section', $information);
    }

    public function updateImage(Request $request)
    {
        $data = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('course_categories_section_image')->first();
        $rules = [];
        if (!$request->filled('image') && empty($data->course_categories_section_image)) {
            $rules['image'] = 'required';
        }
        if ($request->hasFile('image')) {
            $rules['image'] = new ImageMimeTypeRule();
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($request->hasFile('image')) {
            $imgName = Uploader::update_picture(Constant::WEBSITE_COURSE_CATEGORY_SECTION_IMAGE, $request->file('image'), $data->course_categories_section_image);
            // finally, store the image into db
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['course_categories_section_image' => $imgName]
            );
            $request->session()->flash('success', 'Image updated successfully!');
        }
        return "success";
    }
}
