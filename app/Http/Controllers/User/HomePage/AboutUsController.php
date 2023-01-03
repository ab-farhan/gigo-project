<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\HomePage\AboutUsSection;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['data'] = $information['language']->aboutUsSection()->first();
        return view('user.home-page.about-us-section', $information);
    }

    public function update(Request $request)
    {
        $language = Language::query()->where('user_id', Auth::guard('web')->user()->id)->where('code', $request->language)->first();
        $aboutUsInfo = $language->aboutUsSection()->first();
        $rules = [];

        if (empty($aboutUsInfo->image)) {
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
        // store data in db start
        if (empty($aboutUsInfo)) {
            $imageName = Uploader::upload_picture(Constant::WEBSITE_ABOUT_US_SECTION_IMAGE, $request->file('image'));
            AboutUsSection::create($request->except('language_id', 'image', 'user_id') + [
                    'language_id' => $language->id,
                    'image' => $imageName,
                    'user_id' => Auth::guard('web')->user()->id,
            ]);
            $request->session()->flash('success', 'Information added successfully!');
        } else {
            if ($request->hasFile('image')) {
                $imageName = Uploader::update_picture(Constant::WEBSITE_ABOUT_US_SECTION_IMAGE, $request->file('image'), $aboutUsInfo->image);
            }
            $aboutUsInfo->update($request->except('image') + [
                    'image' => $imageName ?? $aboutUsInfo->image
            ]);
            $request->session()->flash('success', 'Information updated successfully!');
        }
        return "success";
    }
}
