<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Process;
use Validator;
use Session;

class ProcessController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['processes'] = Process::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;
        return view('admin.home.process.index', $data);
    }

    public function edit($id)
    {
        $data['process'] = Process::findOrFail($id);

        return view('admin.home.process.edit', $data);
    }

    public function store(Request $request)
    {

        $img = $request->file('image');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'icon' => 'required',
            'title' => 'required|max:100',
            'text' => 'required|max:255',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $process = new Process;
        $process->icon = $request->icon;
        $process->language_id = $request->language_id;
        $process->title = $request->title;
        $process->text = $request->text;
        $process->serial_number = $request->serial_number;
        $process->save();

        Session::flash('success', 'Process added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'icon' => 'required',
            'serial_number' => 'required|integer',

        ];

        $request->validate($rules);

        $process = Process::findOrFail($request->process_id);


        $process->title = $request->title;
        $process->icon = $request->icon;
        $process->text = $request->text;
        $process->serial_number = $request->serial_number;
        $process->save();

        Session::flash('success', 'Process updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {

        $process = Process::findOrFail($request->process_id);
        $process->delete();

        Session::flash('success', 'Process deleted successfully!');
        return back();
    }

    public function removeImage(Request $request) {
        $type = $request->type;
        $featId = $request->process_id;

        $process = Process::findOrFail($featId);

        if ($type == "process") {
            @unlink(public_path("assets/front/img/process/" . $process->image));
            $process->image = NULL;
            $process->save();
        }

        $request->session()->flash('success', 'Image removed successfully!');
        return "success";
    }
}
