<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\BasicSetting;
use App\Models\User\UserQrCode;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index()
    {
        $data['qrcodes'] = UserQrCode::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('user.qr.index', $data);
    }

    public function qrCode()
    {
        $bs = BasicSetting::firstOrCreate([
            'user_id' => Auth::user()->id
        ]);

        if (!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            $s3 = Storage::disk('s3');
        }

        if (empty($bs->qr_image) || (!file_exists(public_path('assets/tenant/image/qr/' . $bs->qr_image)) && !empty($s3) && !$s3->exists('assets/tenant/image/qr/' . $bs->qr_image))) {
            $directory = public_path(Constant::WEBSITE_QRCODE_IMAGE) . '/';
            @mkdir($directory, 0775, true);
            $fileName = uniqid() . '.png';

            QrCode::size(250)->errorCorrection('H')
                ->color(0, 0, 0)
                ->format('png')
                ->style('square')
                ->eye('square')
                ->generate(url(Auth::user()->username), $directory . $fileName);

            $bs->qr_image = $fileName;
            $bs->qr_url = url(Auth::user()->username);
            $bs->save();
        }
        $data['abs'] = $bs;
        return view('user.qr.generate', $data);
    }

    public function generate(Request $request)
    {
        if (!$request->filled('url')) {
            return "url_empty";
        }
        $type = $request->type;
        $bs = BasicSetting::query()->where('user_id', Auth::user()->id)->first();
        $data = UserPermissionHelper::currentPackageFeatures(Auth::user()->id);
        // set default values for all params of qr image, if there is no value for a param
        $color = hex2rgb($request->color);

        $directory = public_path(Constant::WEBSITE_QRCODE_IMAGE) . '/';
        $awsDirectory = Constant::WEBSITE_QRCODE_IMAGE . '/';
        @mkdir($directory, 0775, true);
        $qrImage = uniqid() . '.png';

        // remove previous qr image
        Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_image);

        // new QR code init
        if ($type == 'image' && $request->hasFile('image')) {
            $mergedImage = Uploader::update_picture(Constant::WEBSITE_QRCODE_IMAGE, $request->file('image'), $bs->qr_inserted_image);
        }

        // generating & saving the qr code in folder
        if (in_array("Amazon AWS s3", $data) && $bs->aws_status == 1 && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            $qrcode = QrCode::size($request->size)
                ->errorCorrection('H')
                ->margin($request->margin)
                ->color($color['red'], $color['green'], $color['blue'])
                ->format('png')
                ->style($request->style)
                ->eye($request->eye_style)
                ->generate($request->url);
            Storage::disk('s3')->put(Constant::WEBSITE_QRCODE_IMAGE . '/' . $qrImage, $qrcode);
        } else {
            $qrcode = QrCode::size($request->size)
                ->errorCorrection('H')
                ->margin($request->margin)
                ->color($color['red'], $color['green'], $color['blue'])
                ->format('png')
                ->style($request->style)
                ->eye($request->eye_style);
            $qrcode->generate($request->url, $directory . $qrImage);
        }
        // calculate the inserted image size
        $qrSize = $request->size;
        if ($type == 'image') {
            $imageSize = $request->image_size;
            $insertedImgSize = ($qrSize * $imageSize) / 100;
            // inserting image using Image Intervention & saving the qr code in folder
            if ($request->hasFile('image')) {
                $qr = Image::make(!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($awsDirectory . $qrImage) ? Storage::disk('s3')->url($awsDirectory . $qrImage) : $directory . $qrImage);
                $logo = Image::make(!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($awsDirectory . $mergedImage) ? Storage::disk('s3')->url($awsDirectory . $mergedImage) : $directory . $mergedImage);
                $logo->resize(null, $insertedImgSize, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $logoWidth = $logo->width();
                $logoHeight = $logo->height();

                $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->image_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->image_y) / 100)));
                $qr->save($directory . $qrImage);
                if (in_array("Amazon AWS s3", $data) && $bs->aws_status == 1 && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                    Storage::disk('s3')->putFileAs($awsDirectory, new File($directory . $qrImage), $qrImage);
                    @unlink($directory . $qrImage);
                }
            } else {
                if (!empty($bs->qr_inserted_image)) {
                    $qr = Image::make(!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($awsDirectory . $qrImage) ? Storage::disk('s3')->url($awsDirectory . $qrImage) : $directory . $qrImage);
                    $logo = Image::make(!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($awsDirectory . $bs->qr_inserted_image) ? Storage::disk('s3')->url($awsDirectory . $bs->qr_inserted_image) : $directory . $bs->qr_inserted_image);
                    $logo->resize(null, $insertedImgSize, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $logoWidth = $logo->width();
                    $logoHeight = $logo->height();

                    $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->image_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->image_y) / 100)));
                    $qr->save($directory . $qrImage);
                    if (in_array("Amazon AWS s3", $data) && $bs->aws_status == 1 && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                        Storage::disk('s3')->putFileAs($awsDirectory, new File($directory . $qrImage), $qrImage);
                        @unlink($directory . $qrImage);
                    }
                }
            }
        }

        if ($type == 'text') {
            $imageSize = $request->text_size;
            $insertedImgSize = ($qrSize * $imageSize) / 100;

            $logo = Image::canvas($request->text_width, $insertedImgSize, "#ffffff")->text($request->text, 0, 0, function ($font) use ($request, $insertedImgSize) {
                $font->file(public_path('assets/front/fonts/Lato-Regular.ttf'));
                $font->size($insertedImgSize);
                $font->color('#' . $request->text_color);
                $font->align('left');
                $font->valign('top');
            });

            $logoWidth = $logo->width();
            $logoHeight = $logo->height();

            $qr = Image::make(!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($awsDirectory . $qrImage) ? Storage::disk('s3')->url($awsDirectory . $qrImage) : $directory . $qrImage);

            // use callback to define details
            $qr->insert($logo, 'top-left', (int) (((($qrSize - $logoWidth) * $request->text_x) / 100)), (int) (((($qrSize - $logoHeight) * $request->text_y) / 100)));
            $qr->save($directory . $qrImage);
            if (in_array("Amazon AWS s3", $data) && $bs->aws_status == 1 && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
                Storage::disk('s3')->putFileAs($awsDirectory, new File($directory . $qrImage), $qrImage);
                @unlink($directory . $qrImage);
            }
        }

        $bs->qr_color = $request->color;
        $bs->qr_size = $request->size;
        $bs->qr_style = $request->style;
        $bs->qr_eye_style = $request->eye_style;
        $bs->qr_image = $qrImage;
        $bs->qr_type = $type;

        if ($type == 'image') {
            if ($request->hasFile('image')) {
                $bs->qr_inserted_image = $mergedImage;
            }
            $bs->qr_inserted_image_size = $imageSize;
            $bs->qr_inserted_image_x = $request->image_x;
            $bs->qr_inserted_image_y = $request->image_y;
        }

        if ($type == 'text' && !empty($request->text)) {
            $bs->qr_text = $request->text;
            $bs->qr_text_color = $request->text_color;
            $bs->qr_text_size = $request->text_size;
            $bs->qr_text_x = $request->text_x;
            $bs->qr_text_y = $request->text_y;
        }

        $bs->qr_margin = $request->margin;
        $bs->qr_url = $request->url;
        $bs->save();
        return !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket) && Storage::disk('s3')->exists($awsDirectory . $qrImage) ? Storage::disk('s3')->url($awsDirectory . $qrImage) : asset(Constant::WEBSITE_QRCODE_IMAGE) . '/' . $qrImage;
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => 'required|max:255'
        ];

        $request->validate($rules);

        $bs = BasicSetting::query()->where('user_id', Auth::user()->id)->first();

        $qrcode = new UserQrCode;
        $qrcode->user_id = Auth::user()->id;
        $qrcode->name = $request->name;
        $qrcode->image = $bs->qr_image;
        $qrcode->url = $bs->qr_url;
        $qrcode->save();

        $this->clearFilters($bs);

        Session::flash('success', 'QR Code saved successfully!');
        return back();
    }

    public function clear()
    {
        $bs = BasicSetting::where('user_id', Auth::user()->id)->first();
        $this->clearFilters($bs, 'clear');

        Session::flash('success', 'Cleared all filters');
        return back();
    }

    public function clearFilters($bs, $type = NULL)
    {
        Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_inserted_image);
        if ($type == 'clear') {
            Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $bs->qr_image);
        }
        $bs->qr_image = NULL;
        $bs->qr_color = '000000';
        $bs->qr_size = 250;
        $bs->qr_style = 'square';
        $bs->qr_eye_style = 'square';
        $bs->qr_margin = 0;
        $bs->qr_text = NULL;
        $bs->qr_text_color = '000000';
        $bs->qr_text_size = 15;
        $bs->qr_text_x = 50;
        $bs->qr_text_y = 50;
        $bs->qr_inserted_image = NULL;
        $bs->qr_inserted_image_size = 20;
        $bs->qr_inserted_image_x = 50;
        $bs->qr_inserted_image_y = 50;
        $bs->qr_type = 'default';
        $bs->qr_url = NULL;
        $bs->save();
    }

    public function delete(Request $request)
    {
        $qrcode = UserQrCode::query()
            ->where('user_id', Auth::user()->id)
            ->where('id', $request->qrcode_id)
            ->firstOrFail();
        Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $qrcode->image);
        $qrcode->delete();
        Session::flash('success', 'QR Code deleted successfully!');
        return back();
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $qrcode = UserQrCode::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
            Uploader::remove(Constant::WEBSITE_QRCODE_IMAGE, $qrcode->image);
            $qrcode->delete();
        }
        Session::flash('success', 'QR Codes deleted successfully!');
        return "success";
    }

    public function download($name)
    {
        $bs = BasicSetting::query()->where('user_id', Auth::user()->id)
            ->select('aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $pathToFile = Constant::WEBSITE_QRCODE_IMAGE . '/' . $name;
        if (!is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            if (Storage::disk('s3')->exists($pathToFile)) {
                $headers = [
                    'Content-Type'        => 'image/png',
                    'Content-Disposition' => 'attachment; filename="' . $name . '.png' . '"',
                ];
                return \Response::make(Storage::disk('s3')->get($pathToFile), 200, $headers);
            } else {
                return response()->download(public_path($pathToFile), $name . '.png');
            }
        } else {
            return response()->download(public_path($pathToFile), $name . '.png');
        }
    }
}
