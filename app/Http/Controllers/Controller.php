<?php

namespace App\Http\Controllers;

use App\Models\BasicExtended;
use App\Models\User\Language;
use App\Models\User\BasicSetting;
use App\Models\User\PageHeading;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PDF;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserCurrentLanguage($userId)
    {
        // get the current locale of this system
        if (Session::has('user_lang')) {
            $locale = Session::get('user_lang');
        }
        if (empty($locale)) {
            $language = Language::query()->where('is_default', 1)->where('user_id', $userId)->firstOrFail();
        } else {
            $language = Language::query()->where('code', $locale)->where('user_id', $userId)->firstOrFail();
        }
        return $language;
    }

    public function getUserPageHeading($language, $userId)
    {
        if (URL::current() == Route::is('front.user.courses')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('courses_page_title')->first();
        } else if (URL::current() == Route::is('front.user.course.details')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('course_details_page_title')->first();
        } else if (URL::current() == Route::is('front.user.instructors')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('instructors_page_title')->first();
        } else if (URL::current() == Route::is('front.user.blogs')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('blog_page_title')->first();
        } else if (URL::current() == Route::is('front.user.blog_details')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('blog_details_page_title')->first();
        } else if (URL::current() == Route::is('front.user.faq')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('faq_page_title')->first();
        } else if (URL::current() == Route::is('front.user.contact')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('contact_page_title')->first();
        } else if (URL::current() == Route::is('customer.login')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('login_page_title')->first();
        } else if (URL::current() == Route::is('customer.forget_password')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('forget_password_page_title')->first();
        } else if (URL::current() == Route::is('customer.signup')) {
            $pageHeading = PageHeading::query()->where('language_id', $language->id)->where('user_id', $userId)->select('signup_page_title')->first();
        }

        return $pageHeading;
    }

    public function getUserCurrencyInfo($userId)
    {
        return BasicSetting::query()
            ->where('user_id', $userId)
            ->select(
                'base_currency_symbol',
                'base_currency_symbol_position',
                'base_currency_text',
                'base_currency_text_position',
                'base_currency_rate'
            )->first();

    }

    public function getUserBreadcrumb($userId)
    {
        return BasicSetting::query()->where('user_id', $userId)->select('breadcrumb')->first();
    }

    public function sendMailWithPhpMailer($request, $file_name, $be, $subject, $body, $email, $name)
    {
        $mail = new PHPMailer(true);
        if ($be->is_smtp == 1) {
            try {
                $mail->isSMTP();
                $mail->Host = $be->smtp_host;
                $mail->SMTPAuth = true;
                $mail->Username = $be->smtp_username;
                $mail->Password = $be->smtp_password;
                $mail->SMTPSecure = $be->encryption;
                $mail->Port = $be->smtp_port;
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($email, $name);
                if ($file_name) {
                    $mail->addAttachment(public_path('assets/front/invoices/' . $file_name));
                }
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->send();
                if ($file_name) {
                    @unlink(public_path('assets/front/invoices/' . $file_name));
                }
            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
                return back();
            }
        } else {
            try {
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($email, $name);
                if ($file_name) {
                    $mail->addAttachment(public_path('assets/front/invoices/' . $file_name));
                }
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->send();
                if ($file_name) {
                    @unlink(public_path('assets/front/invoices/' . $file_name));
                }
            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
                return back();
            }
        }
    }

    public function makeInvoice($request, $key, $member, $password, $amount, $payment_method, $phone, $base_currency_symbol_position, $base_currency_symbol, $base_currency_text, $order_id, $package_title, $membership)
    {
        $file_name = uniqid($key) . ".pdf";
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('pdf.membership', compact('request', 'member', 'password', 'amount', 'payment_method', 'phone', 'base_currency_symbol_position', 'base_currency_symbol', 'base_currency_text', 'order_id', 'package_title', 'membership'));
        $output = $pdf->output();
        @mkdir(public_path('assets/front/invoices/'), 0775, true);
        file_put_contents(public_path('assets/front/invoices/' . $file_name), $output);
        return $file_name;
    }

    public function resetPasswordMail($email, $name, $subject, $body)
    {
        $be = BasicExtended::first();

        $mail = new PHPMailer(true);
        if ($be->is_smtp == 1) {
            try {
                $mail->isSMTP();
                $mail->Host = $be->smtp_host;
                $mail->SMTPAuth = true;
                $mail->Username = $be->smtp_username;
                $mail->Password = $be->smtp_password;
                $mail->SMTPSecure = $be->encryption;
                $mail->Port = $be->smtp_port;
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($email, $name);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->send();
            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
                return back();
            }
        } else {
            try {
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($email, $name);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->send();
            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
                return back();
            }
        }
    }

}
