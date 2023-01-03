<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\FeatureRequest;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\Feature;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $settings = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version', 'features_section_image')->first();
        $information['themeInfo'] = $information['data'] = $settings;
        $information['features'] = $information['language']->features()->orderByDesc('id')->get();
        return view('user.home-page.feature-section.index', $information);
    }

    public function updateImage(Request $request)
    {
        $data = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('features_section_image')->first();
        $rules = [];
        if (!$request->filled('features_section_image') && empty($data->features_section_image)) {
            $rules['features_section_image'] = 'required';
        }
        if ($request->hasFile('features_section_image')) {
            $rules['features_section_image'] = new ImageMimeTypeRule();
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($request->hasFile('features_section_image')) {
            $imgName = Uploader::update_picture(Constant::WEBSITE_FEATURE_SECTION_IMAGE, $request->file('features_section_image'), $data->features_section_image);
            // finally, store the image into db
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['features_section_image' => $imgName]
            );
            $request->session()->flash('success', 'Image updated successfully!');
        }
        return "success";
    }

    public function store(FeatureRequest $request)
    {
        Feature::create($request->except(['user_id','user_language_id'])+[
            'user_id' => Auth::guard('web')->user()->id,
            'language_id' => $request->user_language_id
        ]);
        $request->session()->flash('success', 'New feature added successfully!');
        return "success";
    }

    public function update(FeatureRequest $request)
    {
        Feature::where('user_id', Auth::guard('web')->user()->id)->find($request->id)->update($request->all());
        $request->session()->flash('success', 'Feature updated successfully!');
        return "success";
    }

    public function destroy($id)
    {
        Feature::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
        return redirect()->back()->with('success', 'Feature deleted successfully!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            Feature::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
        }
        $request->session()->flash('success', 'Features deleted successfully!');
        return "success";
    }
}
