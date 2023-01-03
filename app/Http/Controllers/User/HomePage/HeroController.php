<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\HeroSection;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HeroController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['data'] = $information['language']->heroSection()->first();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        return view('user.home-page.hero-section', $information);
    }

    public function update(Request $request)
    {
        $language = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
        $heroInfo = $language->heroSection()->first();
        $themeInfo = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        $rules = [];
        if (empty($heroInfo)) {
            $rules['background_image'] = 'required';
        }
        if ($request->hasFile('background_image')) {
            $rules['background_image'] = new ImageMimeTypeRule();
        }

        if ($themeInfo->theme_version == 3 && $request->hasFile('image')) {
            $rules['image'] = new ImageMimeTypeRule();
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors()]);
        }
        // format video link
        $link = NULL;

        if ($request->filled('video_url')) {
            $link = $request->video_url;
            if (strpos($link, '&') != 0) {
                $link = substr($link, 0, strpos($link, '&'));
            }
        }
        // insert data into db
        if(empty($heroInfo)) {
            $backgroundImageName = Uploader::upload_picture(Constant::WEBSITE_HERO_SECTION_IMAGE, $request->file('background_image'));
            $imageName = NULL;
            if ($themeInfo->theme_version == 3 && $request->hasFile('image')) {
                $imageName = Uploader::upload_picture($this->directory, $request->file('image'));
            }
            HeroSection::create($request->except('language_id', 'background_image', 'image', 'video_url','user_id') + [
                    'language_id' => $language->id,
                    'user_id' => Auth::guard('web')->user()->id,
                    'background_image' => $backgroundImageName,
                    'image' => $imageName,
                    'video_url' => $link
                ]);
            $request->session()->flash('success', 'Information added successfully!');
        } else {
            $backgroundImageName = null;
            $imageName = null;
            if ($request->hasFile('background_image')) {
                $backgroundImageName = Uploader::update_picture(Constant::WEBSITE_HERO_SECTION_IMAGE, $request->file('background_image'), $heroInfo->background_image);
            }
            if ($themeInfo->theme_version == 3 && $request->hasFile('image')) {
                $imageName = Uploader::update_picture(Constant::WEBSITE_HERO_SECTION_IMAGE, $request->file('image'), $heroInfo->image);
            }
            $heroInfo->update($request->except('background_image', 'image', 'video_url') + [
                    'background_image' => $request->hasFile('background_image') ? $backgroundImageName : $heroInfo->background_image,
                    'image' => $request->hasFile('image') ? $imageName : $heroInfo->image,
                    'video_url' => $link
                ]);
            $request->session()->flash('success', 'Information updated successfully!');
        }
        return "success";
    }
}
