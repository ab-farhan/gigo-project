<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\ActionSection;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        $information['data'] = $information['language']->actionSection()->first();
        return view('user.home-page.action-section', $information);
    }

    public function update(Request $request)
    {
        $language = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
        $actionInfo = $language->actionSection()->first();
        $themeInfo = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        $rules = [];
        if (empty($actionInfo)) {
            $rules['background_image'] = 'required';
        }
        if ($request->hasFile('background_image')) {
            $rules['background_image'] = new ImageMimeTypeRule();
        }

        if ($themeInfo->theme_version == 2 && $request->hasFile('image')) {
            $rules['image'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors()]);
        }

        // store data in db
        if (empty($actionInfo)) {
            $backgroundImageName = Uploader::upload_picture(Constant::WEBSITE_ACTION_SECTION_IMAGE, $request->file('background_image'));
            $imageName = NULL;
            if ($themeInfo->theme_version == 2 && $request->hasFile('image')) {
                $imageName = Uploader::upload_picture(Constant::WEBSITE_ACTION_SECTION_IMAGE, $request->file('image'));
            }
            ActionSection::create($request->except('language_id', 'background_image', 'image') + [
                    'language_id' => $language->id,
                    'background_image' => $backgroundImageName,
                    'image' => $imageName,
                    'user_id' => Auth::guard('web')->user()->id
                ]);
            $request->session()->flash('success', 'Information added successfully!');
        } else {
            $backgroundImageName = null;
            $imageName = null;
            if ($request->hasFile('background_image')) {
                $backgroundImageName = Uploader::update_picture(Constant::WEBSITE_ACTION_SECTION_IMAGE, $request->file('background_image'), $actionInfo->background_image);
            }
            if ($themeInfo->theme_version == 2 && $request->hasFile('image')) {
                $imageName = Uploader::update_picture(Constant::WEBSITE_ACTION_SECTION_IMAGE, $request->file('image'), $actionInfo->image);
            }
            $actionInfo->update($request->except('background_image', 'image') + [
                    'background_image' => $request->hasFile('background_image') ? $backgroundImageName : $actionInfo->background_image,
                    'image' => $request->hasFile('image') ? $imageName : $actionInfo->image
                ]);
            $request->session()->flash('success', 'Information updated successfully!');
        }
        return "success";
    }
}
