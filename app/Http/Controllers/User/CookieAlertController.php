<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\CookieAlert;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CookieAlertController extends Controller
{
    public function cookieAlert(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['data'] = CookieAlert::where('language_id', $information['language']->id)->where('user_id', Auth::guard('web')->user()->id)->first();
        return view('user.settings.cookie-alert', $information);
    }

    public function updateCookieAlert(Request $request)
    {
        $rules = [
            'cookie_alert_status' => 'required',
            'cookie_alert_btn_text' => 'required',
            'cookie_alert_text' => 'required'
        ];
        $message = [
            'cookie_alert_btn_text.required' => 'The cookie alert button text field is required.',
            'cookie_alert_text.required' => 'The cookie alert text field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        // first, get the language info from db
        $language = Language::where('code', $request->language)
                            ->where('user_id', Auth::guard('web')->user()->id)
                            ->first();
        CookieAlert::query()->updateOrInsert([
            'language_id' => $language->id,
            'user_id' => Auth::guard('web')->user()->id,
        ], $request->except(['_token', 'language', 'userLanguage', 'user_id', 'language_id']) + [
                'language_id' => $language->id,
                'user_id' => Auth::guard('web')->user()->id,
                'cookie_alert_text' => clean($request->cookie_alert_text)
        ]);
        $request->session()->flash('success', 'Cookie alert info updated successfully!');
        return 'success';
    }
}
