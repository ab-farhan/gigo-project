<?php

namespace App\Http\Controllers\User\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User\Language;
use App\Models\User\Teacher\Instructor;
use App\Models\User\Teacher\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SocialLinkController extends Controller
{
    public function links($id)
    {
        $information['defaultLang'] = Language::where('user_id',Auth::guard('web')->user()->id)->where('is_default',1)->first();
        $information['instructor'] = Instructor::where('user_id',Auth::guard('web')->user()->id)->find($id);
        $information['socialLinks'] = SocialLink::where('instructor_id', $id)
            ->where('user_id', Auth::guard('web')->user()->id)
            ->orderByDesc('id')
            ->get();

        return view('user.instructor.social-links.index', $information);
    }

    public function storeLink($id, Request $request)
    {
        $rules = [
            'icon' => 'required',
            'url' => 'required|url',
            'serial_number' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        SocialLink::create($request->except('instructor_id','user_id') + [
                'instructor_id' => $id,
                'user_id' => Auth::guard('web')->user()->id
            ]);

        $request->session()->flash('success', 'New social link added successfully!');

        return "success";
    }

    public function editLink($instructor_id, $id)
    {
        $information['instructor'] = Instructor::where('user_id', Auth::guard('web')->user()->id)->where('id', $instructor_id)->first();
        $information['socialLink'] = SocialLink::where('user_id', Auth::guard('web')->user()->id)->find($id);
        return view('user.instructor.social-links.edit', $information);
    }

    public function updateLink(Request $request, $id)
    {
        $rules = [
            'url' => 'required|url',
            'serial_number' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        SocialLink::where('user_id', Auth::guard('web')->user()->id)->find($id)->update($request->all());
        $request->session()->flash('success', 'Social link updated successfully!');
        return "success";
    }

    public function destroyLink($id)
    {
        SocialLink::where('user_id', Auth::guard('web')->user()->id)->find($id)->delete();
        return redirect()->back()->with('success', 'Social link deleted successfully!');
    }
}
