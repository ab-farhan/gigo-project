<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\BasicSetting;
use App\Models\User\FooterQuickLink;
use App\Models\User\FooterText;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FooterController extends Controller
{
    public function footerContent(Request $request)
    {
        // first, get the language info from db
        $lang = Language::where('user_id', Auth::guard('web')->user()->id)
            ->where('code', $request->language)
            ->first();
        $information['themeInfo'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)
            ->select('theme_version')
            ->first();
        // then, get the footer text info of that language from db
        $information['data'] = FooterText::where('language_id', $lang->id)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->first();
        return view('user.footer.text', $information);
    }

    public function updateFooterContent(Request $request, $language)
    {
        $rules = [
            'about_company' => 'required',
            'copyright_text' => 'required'
        ];
        $message = [
            'about_company.required' => 'The about company field is required',
            'copyright_text.required' => 'The copy right text field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $lang = Language::where('code', $language)->where('user_id', Auth::guard('web')->user()->id)->first();
        FooterText::query()->updateOrInsert(
            [
                'user_id' => Auth::guard('web')->user()->id,
                'language_id' => $lang->id
            ],
            [
                'language_id' => $lang->id,
                'footer_background_color' => $request->footer_background_color,
                'copyright_text' => clean($request->copyright_text),
                'about_company' => clean($request->about_company),
                'user_id' => Auth::guard('web')->user()->id
            ]
        );
        $request->session()->flash('success', 'Footer content has been updated successfully!');
        return 'success';
    }


    public function quickLinks(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->language)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->firstOrFail();

        // then, get the footer quick link info of that language from db
        $information['links'] = FooterQuickLink::where('language_id', $language->id)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->orderBy('id', 'desc')
            ->get();

        $information['userLanguages'] = Language::where('user_id', Auth::guard('web')->user()->id)->get();
        return view('user.footer.quick_links', $information);
    }

    public function storeQuickLink(Request $request)
    {
        $rules = [
            'title' => 'required',
            'url' => 'required',
            'serial_number' => 'required',
            'user_language_id' => 'required',
        ];
        $message = [
            'user_language_id.required' => 'The language field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        FooterQuickLink::create($request->except('language_id', 'user_id') + [
                'language_id' => $request->user_language_id,
                'user_id' => Auth::guard('web')->user()->id,
            ]);
        $request->session()->flash('success', 'New quick link added successfully!');
        return 'success';
    }

    public function updateQuickLink(Request $request)
    {
        $rules = [
            'title' => 'required',
            'url' => 'required',
            'serial_number' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        FooterQuickLink::where('user_id', Auth::user()->id)
            ->where('id', $request->link_id)
            ->firstOrFail()
            ->update($request->all());
        $request->session()->flash('success', 'Quick link updated successfully!');
        return 'success';
    }

    public function deleteQuickLink(Request $request)
    {
        FooterQuickLink::where('user_id', Auth::user()->id)->where('id', $request->link_id)->firstOrFail()->delete();
        $request->session()->flash('success', 'Quick link deleted successfully!');
        return redirect()->back();
    }
}
