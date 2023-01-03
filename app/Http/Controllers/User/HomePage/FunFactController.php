<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\CountInformationRequest;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\Fact\CountInformation;
use App\Models\User\HomePage\Fact\FunFactSection;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FunFactController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        $information['data'] = $information['language']->funFactSection()->first();
        $information['countInfos'] = $information['language']->countInfo()->orderByDesc('id')->get();
        return view('user.home-page.fun-fact-section.index', $information);
    }

  public function updateSection(Request $request)
  {
    $language = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
    $factInfo = $language->funFactSection()->first();
    $themeInfo = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
    $rules = [];
    if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 2) {
      if (empty($factInfo->background_image)) {
        $rules['background_image'] = 'required';
      }
      if ($request->hasFile('background_image')) {
        $rules['background_image'] = new ImageMimeTypeRule();
      }
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json(['errors' => $validator->errors()]);
    }

    // store data in db start
    if (empty($factInfo)) {
      if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 2) {
        $backgroundImageName = Uploader::upload_picture(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE, $request->file('background_image'));
      }
      FunFactSection::create($request->except('language_id', 'background_image','user_id') + [
        'language_id' => $language->id,
        'user_id' => Auth::guard('web')->user()->id,
        'background_image' => $backgroundImageName ?? NULL
      ]);

      $request->session()->flash('success', 'Information added successfully!');

    } else {
      if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 2) {
        if ($request->hasFile('background_image')) {
          $backgroundImageName = Uploader::update_picture(Constant::WEBSITE_FUN_FACT_SECTION_IMAGE, $request->file('background_image'), $factInfo->background_image);
        }
      }

      $factInfo->update($request->except('background_image') + [
        'background_image' => $backgroundImageName ?? $factInfo->background_image
      ]);
      $request->session()->flash('success', 'Information updated successfully!');
    }
      return "success";
  }


  public function store(CountInformationRequest $request)
  {
    CountInformation::create($request->except('user_id','language_id')+[
        'user_id' => Auth::guard('web')->user()->id,
        'language_id' => $request->user_language_id
        ]);
    $request->session()->flash('success', 'New information added successfully!');
    return "success";
  }

  public function update(CountInformationRequest $request)
  {
    CountInformation::where('user_id', Auth::guard('web')->user()->id)->find($request->id)->update($request->all());
    $request->session()->flash('success', 'Information updated successfully!');
    return "success";
  }

  public function destroy($id)
  {
    CountInformation::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
    return redirect()->back()->with('success', 'Information deleted successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;
    foreach ($ids as $id) {
      CountInformation::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
    }
    $request->session()->flash('success', 'Informations deleted successfully!');
    return "success";
  }
}
