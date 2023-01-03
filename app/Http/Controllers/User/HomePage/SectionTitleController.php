<?php

namespace App\Http\Controllers\User\HomePage;

use App\Http\Controllers\Controller;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\SectionTitle;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionTitleController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
        $information['data'] = $information['language']->sectionTitle()->first();
        return view('user.home-page.section-titles', $information);
    }

    public function update(Request $request)
    {
        $language = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
        SectionTitle::query()->updateOrInsert([
            'language_id' => $language->id,
            'user_id' => Auth::guard('web')->user()->id
        ], $request->except(['_token','userLanguage','language', 'user_id'] + [
                'language_id' => $language->id,
                'user_id' => Auth::guard('web')->user()->id
            ]));
        $request->session()->flash('success', 'Section Title updated successfully!');
        return redirect()->back();
    }
}
