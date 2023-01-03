<?php

namespace App\Http\Controllers\User\HomePage;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionStatusRequest;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\Section;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
  public function index()
  {
    $sectionInfo = Section::query()->where('user_id', Auth::guard('web')->user()->id)->first();
    $themeInfo = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)->select('theme_version')->first();
    return view('user.home-page.section-customization', compact('sectionInfo', 'themeInfo'));
  }

  public function update(SectionStatusRequest $request)
  {
    Section::query()->updateOrInsert(['user_id' => Auth::guard('web')->user()->id],$request->except('_token','_method','user_id')+[
        'user_id' => Auth::guard('web')->user()->id
    ]);
    $request->session()->flash('success', 'Section status updated successfully!');
    return redirect()->back();
  }
}
