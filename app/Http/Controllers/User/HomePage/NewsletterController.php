<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\NewsletterSection;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{

  public function index(Request $request)
  {
      $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
      $information['language'] = $information['langs']->where('code', $request->language)->first();
      $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
      $information['data'] = $information['language']->newsletterSection()->first();
      return view('user.home-page.newsletter-section', $information);
  }

  public function update(Request $request)
  {
    $language = Language::query()
        ->where('user_id', Auth::guard('web')->user()->id)
        ->where('code', $request->language)
        ->first();
    $newsletterInfo = $language->newsletterSection()->first();
    $themeInfo = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
    $rules = [];

    if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 3) {
      if (empty($newsletterInfo->background_image)) {
        $rules['background_image'] = 'required';
      }
      if ($request->hasFile('background_image')) {
        $rules['background_image'] = new ImageMimeTypeRule();
      }
    }

    if ($themeInfo->theme_version == 1) {
      if (empty($newsletterInfo->image)) {
        $rules['image'] = 'required';
      }
      if ($request->hasFile('image')) {
        $rules['image'] = new ImageMimeTypeRule();
      }
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json(['errors' => $validator->errors()]);
    }

    // store data in db start
    if (empty($newsletterInfo)) {
      if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 3) {
        $backgroundImageName = Uploader::upload_picture(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $request->file('background_image'));
      }

      if ($themeInfo->theme_version == 1) {
        $imageName = Uploader::upload_picture(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $request->file('image'));
      }

      NewsletterSection::create($request->except('language_id', 'background_image', 'image','user_id') + [
        'language_id' => $language->id,
        'background_image' => $backgroundImageName ?? NULL,
        'image' => $imageName ?? NULL,
        'user_id' => Auth::guard('web')->user()->id
      ]);
      $request->session()->flash('success', 'Information added successfully!');
    } else {
      if ($themeInfo->theme_version == 1 || $themeInfo->theme_version == 3) {
        if ($request->hasFile('background_image')) {
          $backgroundImageName = Uploader::update_picture(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $request->file('background_image'), $newsletterInfo->background_image);
        }
      }

      if ($themeInfo->theme_version == 1) {
        if ($request->hasFile('image')) {
          $imageName = Uploader::update_picture(Constant::WEBSITE_NEWSLETTER_SECTION_IMAGE, $request->file('image'), $newsletterInfo->image);
        }
      }
      $newsletterInfo->update($request->except('background_image', 'image') + [
        'background_image' => $backgroundImageName ?? $newsletterInfo->background_image,
        'image' => $imageName ?? $newsletterInfo->image
      ]);
      $request->session()->flash('success', 'Information updated successfully!');
    }
      return "success";
  }
}
