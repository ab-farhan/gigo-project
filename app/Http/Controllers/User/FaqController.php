<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\FAQ;
use App\Models\User\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();

        // then, get the faqs of that language from db
        $information['faqs'] = FAQ::where('language_id', $information['language']->id)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->orderByDesc('id')
            ->get();

        return view('user.faq.index', $information);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_language_id' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'serial_number' => 'required'
        ];

        $message = [
            'user_language_id.required' => 'The language field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        FAQ::create($request->except('user_language_id', 'user_id') + [
                'language_id' => $request->user_language_id,
                'user_id' => Auth::guard('web')->user()->id
        ]);

        $request->session()->flash('success', 'New faq added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'question' => 'required',
            'answer' => 'required',
            'serial_number' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        FAQ::where('user_id', Auth::guard('web')->user()->id)->find($request->id)->update($request->all());
        $request->session()->flash('success', 'FAQ updated successfully!');
        return "success";
    }

    public function destroy($id)
    {
        FAQ::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            FAQ::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
        }
        $request->session()->flash('success', 'FAQs deleted successfully!');
        return "success";
    }
}
