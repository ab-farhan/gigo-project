<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\Advertisement\StoreRequest;
use App\Http\Requests\Advertisement\UpdateRequest;
use App\Models\User\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    public function index()
    {
        $ads = Advertisement::query()->where('user_id', Auth::guard('web')->user()->id)->orderByDesc('id')->get();
        return view('user.advertisement.index', compact('ads'));
    }

    public function store(StoreRequest $request): string
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = Uploader::upload_picture(Constant::WEBSITE_ADVERTISEMENT_IMAGE, $request->file('image'));
        }
        Advertisement::create($request->except('image') + [
                'user_id' => Auth::guard('web')->user()->id,
                'image' => $request->hasFile('image') ? $imageName : null
        ]);

        $request->session()->flash('success', 'New advertisement added successfully!');
        return "success";
    }

    public function update(UpdateRequest $request): string
    {
        $ad = Advertisement::query()->where('user_id', Auth::guard('web')->user()->id)->find($request->id);
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = Uploader::update_picture(Constant::WEBSITE_ADVERTISEMENT_IMAGE, $request->file('image'), $ad->image);
        }
        if ($request->ad_type == 'adsense') {
            // if ad type change to google adsense then delete the image from local storage.
            Uploader::remove(Constant::WEBSITE_ADVERTISEMENT_IMAGE,$ad->image);
        }
        $ad->update($request->except('image') + [
                'image' => $request->hasFile('image') ? $imageName : $ad->image
            ]);
        $request->session()->flash('success', 'Advertisement updated successfully!');
        return "success";
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $ad = Advertisement::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
        if ($ad->ad_type == 'banner') Uploader::remove(Constant::WEBSITE_ADVERTISEMENT_IMAGE,$ad->image);
        $ad->delete();
        return redirect()->back()->with('success', 'Advertisement deleted successfully!');
    }

    public function bulkDestroy(Request $request): string
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $ad = Advertisement::query()->where('user_id', Auth::guard('web')->user()->id)->find($id);
            if ($ad->ad_type == 'banner') Uploader::remove(Constant::WEBSITE_ADVERTISEMENT_IMAGE,$ad->image);
            $ad->delete();
        }
        $request->session()->flash('success', 'Advertisements deleted successfully!');
        return "success";
    }
}
