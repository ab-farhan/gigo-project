<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Models\User\SEO;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;

class BasicController extends Controller
{
    public function themeVersion()
    {
        $data = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->first();
        return view('user.settings.themes', ['data' => $data]);
    }

    public function updateThemeVersion(Request $request)
    {
        $rule = [
            'theme_version' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $data = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->first();
        $data->theme_version = $request->theme_version;
        $data->save();
        $request->session()->flash('success', 'Theme updated successfully!');
        return redirect()->back();
    }

    public function favicon(Request $request)
    {
        $data['basic_setting'] = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)->select('favicon')->first();
        return view('user.settings.favicon', $data);
    }

    public function updatefav(Request $request)
    {
        $bss = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('favicon')->first();

        $rules = [];
        if (!$request->filled('favicon') && is_null($bss->favicon)) {
            $rules['favicon'] = 'required';
        }
        if ($request->hasFile('favicon')) {
            $rules['favicon'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'favicon']);
        }

        if ($request->hasFile('favicon')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_FAVICON, $request->file('favicon'), $bss->favicon);
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['favicon' => $filename]
            );
        }
        Session::flash('success', 'Favicon update successfully.');
        return "success";
    }

    public function logo(Request $request)
    {
        $data['basic_setting'] = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)->select('logo')->first();
        return view('user.settings.logo', $data);
    }

    public function updatelogo(Request $request)
    {
        $rules = [];
        $bss = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('logo')->first();
        if (!$request->filled('logo') && is_null($bss->logo)) {
            $rules['logo'] = 'required';
        }
        if ($request->hasFile('logo')) {
            $rules['logo'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'logo']);
        }

        if ($request->hasFile('logo')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_LOGO, $request->file('logo'), $bss->logo);
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['logo' => $filename]
            );
        }
        Session::flash('success', 'Logo update successfully.');
        return "success";
    }

    public function breadcrumb(Request $request)
    {
        $data['basic_setting'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('breadcrumb')->first();
        return view('user.settings.breadcrumb', $data);
    }

    public function updateBreadcrumb(Request $request)
    {
        $bss = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('breadcrumb')->first();

        $rules = [];
        if (!$request->filled('breadcrumb') && is_null($bss->breadcrumb)) {
            $rules['breadcrumb'] = 'required';
        }
        if ($request->hasFile('breadcrumb')) {
            $rules['breadcrumb'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'breadcrumb']);
        }

        if ($request->hasFile('breadcrumb')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_BREADCRUMB, $request->file('breadcrumb'), $bss->breadcrumb);
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['breadcrumb' => $filename]
            );
        }
        Session::flash('success', 'Breadcrumb update successfully.');
        return "success";
    }

    public function footerLogo(Request $request)
    {
        $data['basic_setting'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('footer_logo')->first();
        return view('user.settings.footer-logo', $data);
    }

    public function updateFooterLogo(Request $request)
    {
        $bss = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('footer_logo')->first();

        $rules = [];
        if (!$request->filled('footer_logo') && is_null($bss->footer_logo)) {
            $rules['footer_logo'] = 'required';
        }
        if ($request->hasFile('footer_logo')) {
            $rules['logo'] = new ImageMimeTypeRule();
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'footer_logo']);
        }

        if ($request->hasFile('footer_logo')) {
            $filename = Uploader::update_picture(Constant::WEBSITE_FOOTER_LOGO, $request->file('footer_logo'), $bss->footer_logo);
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['footer_logo' => $filename]
            );
        }
        Session::flash('success', 'Footer logo update successfully.');
        return "success";
    }

    public function currency()
    {
        $data = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)
            ->select('base_currency_symbol', 'base_currency_symbol_position', 'base_currency_text', 'base_currency_text_position', 'base_currency_rate')
            ->first();

        return view('user.settings.currency', ['data' => $data]);
    }

    public function updateCurrency(Request $request)
    {
        $rules = [
            'base_currency_symbol' => 'required',
            'base_currency_symbol_position' => 'required',
            'base_currency_text' => 'required',
            'base_currency_text_position' => 'required',
            'base_currency_rate' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'footer_logo']);
        }

        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            [
                'base_currency_symbol' => $request->base_currency_symbol,
                'base_currency_symbol_position' => $request->base_currency_symbol_position,
                'base_currency_text' => $request->base_currency_text,
                'base_currency_text_position' => $request->base_currency_text_position,
                'base_currency_rate' => $request->base_currency_rate
            ]
        );
        $request->session()->flash('success', 'Currency updated successfully!');
        return "success";
    }
    public function appearance()
    {
        $data = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)
            ->select('primary_color', 'secondary_color', 'breadcrumb_overlay_color', 'breadcrumb_overlay_opacity')
            ->first();

        return view('user.settings.appearance', ['data' => $data]);
    }

    public function updateAppearance(Request $request)
    {
        $rules = [
            'primary_color' => 'required',
            'secondary_color' => 'required',
            'breadcrumb_overlay_color' => 'required',
            'breadcrumb_overlay_opacity' => 'required|numeric|min:0|max:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'footer_logo']);
        }

        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            [
                'primary_color' => $request->primary_color,
                'secondary_color' => $request->secondary_color,
                'breadcrumb_overlay_color' => $request->breadcrumb_overlay_color,
                'breadcrumb_overlay_opacity' => $request->breadcrumb_overlay_opacity
            ]
        );

        $request->session()->flash('success', 'Appearance updated successfully!');
        return "success";
    }

    public function seo(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->firstOrFail();
        $langId = $language->id;

        // then, get the seo info of that language from db
        $seo = SEO::where('language_id', $langId)->where('user_id', Auth::user()->id);

        if ($seo->count() == 0) {
            // if seo info of that language does not exist then create a new one
            SEO::create($request->except('language_id', 'user_id') + [
                'language_id' => $langId,
                'user_id' => Auth::user()->id
            ]);
        }

        $information['language'] = $language;

        // then, get the seo info of that language from db
        $information['data'] = $seo->first();

        // get all the languages from db
        $information['langs'] = Language::where('user_id', Auth::user()->id)->get();

        return view('user.settings.seo', $information);
    }

    public function updateSEO(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->userLanguage)->where('user_id', Auth::user()->id)->first();
        // then, get the seo info of that language from db
        SEO::query()->updateOrInsert(
            [
                'user_id' => Auth::guard('web')->user()->id,
                'language_id' => $language->id
            ],
            $request->except(['_token', 'userLanguage']) + [
                'language_id' =>  $language->id,
                'user_id' => Auth::guard('web')->user()->id
            ]
        );
        $request->session()->flash('success', 'SEO Informations updated successfully!');
        return redirect()->back();
    }

    public function information()
    {
        $data = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)
            ->select('website_title', 'email_address', 'contact_number', 'address', 'latitude', 'longitude')
            ->first();
        return view('user.settings.information', ['data' => $data]);
    }

    public function updateInfo(Request $request)
    {
        $request->validate(
            [
                'website_title' => 'required',
                'email_address' => 'required',
                'contact_number' => 'required',
                'address' => 'required',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'
            ]
        );
        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            $request->except(['_token', 'user_id'] + [
                'user_id' => Auth::guard('web')->user()->id
            ])
        );
        $request->session()->flash('success', 'Information updated successfully!');
        return redirect()->back();
    }

    public function plugins()
    {
        $data = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)
            ->select(
                'disqus_status',
                'disqus_short_name',
                'whatsapp_status',
                'whatsapp_number',
                'whatsapp_header_title',
                'whatsapp_popup_status',
                'whatsapp_popup_message',
                'aws_status',
                'aws_access_key_id',
                'aws_secret_access_key',
                'aws_default_region',
                'aws_bucket'
            )
            ->first();

        return view('user.settings.plugins', ['data' => $data]);
    }

    public function updateDisqus(Request $request)
    {
        $request->validate([
            'disqus_status' => 'required',
            'disqus_short_name' => 'required'
        ], [
            'disqus_status.required' => 'The disqus status field is required.',
            'disqus_short_name.required' => 'The disqus short name field is required.',
        ]);

        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            $request->except(['_token', 'user_id']) + [
                'user_id' => Auth::guard('web')->user()->id
            ]
        );
        $request->session()->flash('success', 'Disqus info updated successfully!');
        return redirect()->back();
    }

    public function updateWhatsApp(Request $request)
    {
        $request->validate([
            'whatsapp_status' => 'required',
            'whatsapp_number' => 'required',
            'whatsapp_header_title' => 'required',
            'whatsapp_popup_status' => 'required',
            'whatsapp_popup_message' => 'required'
        ], [
            'whatsapp_status.required' => 'The whatsapp status field is required.',
            'whatsapp_number.required' => 'The whatsapp number field is required.',
            'whatsapp_header_title.required' => 'The whatsapp header title field is required.',
            'whatsapp_popup_status.required' => 'The whatsapp popup status field is required.',
            'whatsapp_popup_message.required' => 'The whatsapp popup message field is required.',
        ]);

        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            $request->except(['_token', 'user_id']) + [
                'user_id' => Auth::guard('web')->user()->id
            ]
        );
        $request->session()->flash('success', 'WhatsApp info updated successfully!');
        return redirect()->back();
    }

    public function updateAWSCredentials(Request $request)
    {
        $request->validate([
            'aws_status' => 'required',
            'aws_access_key_id' => 'required',
            'aws_secret_access_key' => 'required',
            'aws_default_region' => 'required',
            'aws_bucket' => 'required',
        ], [
            'aws_status' => 'The aws status field is required.',
            'aws_access_key_id' => 'The access key id field is required.',
            'aws_secret_access_key' => 'The secret access key field is required.',
            'aws_default_region' => 'The aws default region field is required.',
            'aws_bucket' => 'The aws bucket field is required.',
        ]);
        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            $request->except(['_token', 'user_id']) + [
                'user_id' => Auth::guard('web')->user()->id
            ]
        );
        $request->session()->flash('success', 'AWS info updated successfully!');
        return redirect()->back();
    }


    public function maintenance()
    {
        $data = BasicSetting::query()->where('user_id', Auth::guard('web')->user()->id)
            ->select('maintenance_img', 'maintenance_status', 'maintenance_msg', 'bypass_token')
            ->first();
        return view('user.settings.maintenance', ['data' => $data]);
    }

    public function updateMaintenance(Request $request)
    {

        $data = BasicSetting::query()
            ->where('user_id', Auth::guard('web')->user()->id)
            ->select('maintenance_img')
            ->first();

        $rules = $messages = [];

        if (!$request->filled('maintenance_img') && is_null($data->maintenance_img)) {
            $rules['maintenance_img'] = 'required';
            $messages['maintenance_img.required'] = 'The maintenance image field is required.';
        }
        if ($request->hasFile('maintenance_img')) {
            $rules['maintenance_img'] = new ImageMimeTypeRule();
        }

        $rules['maintenance_status'] = 'required';
        $rules['maintenance_msg'] = 'required';

        $messages['maintenance_msg.required'] = 'The maintenance message field is required.';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'footer_logo']);
        }

        if ($request->hasFile('maintenance_img')) {
            $imageName = Uploader::update_picture(Constant::WEBSITE_MAINTENANCE_IMAGE, $request->file('maintenance_img'), $data->maintenance_img);
        }
        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            $request->except(['_token', 'user_id', 'maintenance_img', 'maintenance_msg']) + [
                'maintenance_img' => $request->hasFile('maintenance_img') ? $imageName : $data->maintenance_img,
                'maintenance_msg' => Purifier::clean($request->maintenance_msg),
                'user_id' => Auth::guard('web')->user()->id
            ]
        );

        $request->session()->flash('success', 'Maintenance Info updated successfully!');
        return "success";
    }
    public function advertiseSettings()
    {
        $data = BasicSetting::query()
            ->where('user_id', Auth::guard('web')->user()->id)
            ->select('google_adsense_publisher_id')
            ->first();
        return view('user.advertisement.settings', ['data' => $data]);
    }

    public function updateAdvertiseSettings(Request $request)
    {
        $rule = [
            'google_adsense_publisher_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        BasicSetting::query()->updateOrInsert(
            ['user_id' => Auth::guard('web')->user()->id],
            ['google_adsense_publisher_id' => $request->google_adsense_publisher_id]
        );
        $request->session()->flash('success', 'Advertise settings updated successfully!');
        return redirect()->back();
    }

    public function getMailInformation()
    {
        $data['info'] = \App\Models\User\BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('email', 'from_name')->first();
        return view('user.settings.email.mail-information', $data);
    }

    public function storeMailInformation(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'from_name' => 'required'
        ], [
            'email.required' => 'The email field is required',
            'from_name.required' => 'The from name field is required'
        ]);
        $info = \App\Models\User\BasicSetting::where('user_id', Auth::guard('web')->user()->id)->first();
        $info->email = $request->email;
        $info->from_name = $request->from_name;
        $info->save();
        Session::flash('success', 'Mail information saved successfully!');
        return back();
    }
}
