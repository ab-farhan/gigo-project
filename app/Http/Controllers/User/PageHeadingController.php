<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageHeadingRequest;
use App\Models\User\PageHeading;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageHeadingController extends Controller
{
    public function pageHeadings(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['data'] = PageHeading::where('language_id', $information['language']->id)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->first();
        return view('user.settings.page-headings', $information);
    }

    public function updatePageHeadings(PageHeadingRequest $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->userLanguage)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->first();
        // then, get the page heading info of that language from db
        PageHeading::query()->updateOrInsert([
            'language_id' => $language->id,
            'user_id' => Auth::guard('web')->user()->id,
        ], $request->except(['_token', 'language', 'userLanguage', 'user_id', 'language_id']) + [
                'language_id' => $language->id,
                'user_id' => Auth::guard('web')->user()->id
            ]);
        $request->session()->flash('success', 'Page headings updated successfully!');
        return redirect()->back();
    }
}
