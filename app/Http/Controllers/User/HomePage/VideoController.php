<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\HomePage\VideoSection;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        $information['data'] = $information['language']->videoSection()->first();
        return view('user.home-page.video-section', $information);
    }

    public function update(Request $request)
    {
        $language = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
        $videoInfo = $language->videoSection()->first();
        $rules = [];
        if (empty($videoInfo)) {
            $rules['image'] = 'required';
        }
        if ($request->hasFile('image')) {
            $rules['image'] = new ImageMimeTypeRule();
        }
        $rules['link'] = 'required|url';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors()]);
        }
        // store data in db start
        $link = $request->link;
        if (strpos($link, '&') != 0) {
            $link = substr($link, 0, strpos($link, '&'));
        }

        if (empty($videoInfo)) {
            $imageName = Uploader::upload_picture(Constant::WEBSITE_VIDEO_SECTION_IMAGE, $request->file('image'));
            VideoSection::create($request->except('language_id', 'image', 'link','user_id') + [
                    'language_id' => $language->id,
                    'image' => $imageName,
                    'link' => $link,
                    'user_id' => Auth::guard('web')->user()->id
            ]);
            $request->session()->flash('success', 'Video information added successfully!');
        } else {
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = Uploader::update_picture(Constant::WEBSITE_VIDEO_SECTION_IMAGE, $request->file('image'), $videoInfo->image);
            }
            $videoInfo->update($request->except('image', 'link') + [
                    'image' => $request->hasFile('image') ? $imageName : $videoInfo->image,
                    'link' => $link
                ]);
            $request->session()->flash('success', 'Video information updated successfully!');
        }
        return "success";
    }
}
