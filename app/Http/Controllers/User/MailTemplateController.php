<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailTemplateController extends Controller
{
    public function index()
    {
      $templates = MailTemplate::where('user_id', Auth::guard('web')->user()->id)->get();
  
      return view('user.settings.email.templates', compact('templates'));
    }

    public function edit($id)
    {
      $templateInfo = MailTemplate::where('user_id', Auth::guard('web')->user()->id)->findOrFail($id);
  
      return view('user.settings.email.edit-template', compact('templateInfo'));
    }
  
    public function update(Request $request, $id)
    {
      $rules = [
        'mail_subject' => 'required',
        'mail_body' => 'required'
      ];
  
      $validator = Validator::make($request->all(), $rules);
  
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
      }
  
      MailTemplate::where('user_id', Auth::guard('web')->user()->id)->findOrFail($id)->update($request->except('mail_type', 'mail_body') + [
        'mail_body' => Purifier::clean($request->mail_body)
      ]);
  
      $request->session()->flash('success', 'Mail template updated successfully!');
  
      return redirect()->back();
    }
}
