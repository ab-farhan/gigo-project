<?php

namespace App\Http\Controllers\User\HomePage;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\Testimonial\StoreRequest;
use App\Http\Requests\Testimonial\UpdateRequest;
use App\Models\User\BasicSetting;
use App\Models\User\HomePage\Testimonial;
use App\Models\User\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();
        $information['data'] = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('testimonials_section_image', 'theme_version')->first();
        $information['testimonials'] = $information['language']->testimonials()->orderByDesc('id')->get();
        return view('user.home-page.testimonial-section.index', $information);
    }

    public function updateImage(Request $request)
    {
        $data = BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('testimonials_section_image')->first();
        $rules = [];
        if (!$request->filled('image') && empty($data->testimonials_section_image)) {
            $rules['image'] = 'required';
        }
        if ($request->hasFile('image')) {
            $rules['image'] = new ImageMimeTypeRule();
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($request->hasFile('image')) {
            $imgName = Uploader::update_picture(Constant::WEBSITE_TESTIMONIAL_SECTION_IMAGE, $request->file('image'), $data->testimonials_section_image);
            // finally, store the image into db
            BasicSetting::query()->updateOrInsert(
                ['user_id' => Auth::guard('web')->user()->id],
                ['testimonials_section_image' => $imgName]
            );
            $request->session()->flash('success', 'Image updated successfully!');
        }
        return "success";
    }


    public function store(StoreRequest $request): string
    {
        $imageName = Uploader::upload_picture(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE, $request->file('image'));
        Testimonial::create($request->except('image', 'user_id','language_id') + [
                'image' => $imageName,
                'user_id' => Auth::guard('web')->user()->id,
                'language_id' => $request->user_language_id
        ]);
        $request->session()->flash('success', 'New testimonial added successfully!');
        return "success";
    }

    public function update(UpdateRequest $request): string
    {
        $imageName = null;
        $testimonial = Testimonial::query()->where('user_id', Auth::guard('web')->user()->id)->find($request->id);
        if ($request->hasFile('image')) {
            $imageName = Uploader::update_picture(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE, $request->file('image'), $testimonial->image);
        }
        $testimonial->update($request->except('image') + [
                'image' => $request->hasFile('image') ? $imageName : $testimonial->image
            ]);
        $request->session()->flash('success', 'Testimonial updated successfully!');
        return "success";
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $testimonial = Testimonial::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
        Uploader::remove(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image);
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimonial deleted successfully!');
    }

    public function bulkDestroy(Request $request): string
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $testimonial = Testimonial::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
            Uploader::remove(Constant::WEBSITE_TESTIMONIAL_CLIENT_IMAGE,$testimonial->image);
            $testimonial->delete();
        }
        $request->session()->flash('success', 'Testimonials deleted successfully!');
        return "success";
    }
}
