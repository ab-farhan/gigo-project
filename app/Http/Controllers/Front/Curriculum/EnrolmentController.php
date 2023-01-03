<?php

namespace App\Http\Controllers\Front\Curriculum;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CoursePayment\AuthorizenetController;
use App\Http\Controllers\CoursePayment\FlutterWaveController;
use App\Http\Controllers\CoursePayment\InstamojoController;
use App\Http\Controllers\CoursePayment\MercadopagoController;
use App\Http\Controllers\CoursePayment\MollieController;
use App\Http\Controllers\CoursePayment\OfflineController;
use App\Http\Controllers\CoursePayment\PayPalController;
use App\Http\Controllers\CoursePayment\PaystackController;
use App\Http\Controllers\CoursePayment\PaytmController;
use App\Http\Controllers\CoursePayment\RazorpayController;
use App\Http\Controllers\CoursePayment\StripeController;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\BasicSetting;
use App\Models\EmailTemplate;
use App\Models\User\BasicSetting as UserBasicSetting;
use App\Models\User\Curriculum\Course;
use App\Models\User\Curriculum\CourseEnrolment;
use App\Models\User\Curriculum\CourseInformation;
use App\Models\User\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EnrolmentController extends Controller
{
    public function enrolment(Request $request, $domain, $id)
    {
        $user = getUser();
        // check whether user is logged in or not
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login', [getParam(), 'redirectPath' => 'course_details']);
        } else {
            // check for user's profile information
            $customer = Auth::guard('customer')->user();

            if ($customer->edit_profile_status == 0) {
                $request->session()->flash('profile_warning', 'Please complete your profile information');
                return redirect()->back()->withInput();
            }
        }
        // free course enrolment
        if ($request->filled('type') && $request['type'] == 'free') {
            $freeCourseEnrol = new FreeCourseEnrolController();
            return $freeCourseEnrol->enrolmentProcess($id, $user->id);
        }
        // premium course enrolment
        if (!session()->has('discountedPrice') && !$request->exists('gateway')) {
            $request->session()->flash('error', 'Please select a payment method.');
            return redirect()->back();
        }
        else if ((session()->has('discountedPrice') && session()->get('discountedPrice') > 0) && !$request->exists('gateway')) {
            $request->session()->flash('error', 'Please select a payment method.');
            return redirect()->back();
        } else if ($request['gateway'] == 'paypal') {
            $paypal = new PayPalController();
            return $paypal->enrolmentProcess($request, $id,$user->id);
        } else if ($request['gateway'] == 'instamojo') {
            $instamojo = new InstamojoController();
            return $instamojo->enrolmentProcess($request, $id,$user->id);
        } else if ($request['gateway'] == 'paystack') {
            $paystack = new PaystackController();
            return $paystack->enrolmentProcess($request, $id, $user->id);
        } else if ($request['gateway'] == 'flutterwave') {
            $flutterwave = new FlutterwaveController;
            return $flutterwave->enrolmentProcess($request, $id, $user->id);
        } else if ($request['gateway'] == 'razorpay') {
            $razorpay = new RazorpayController();
            return $razorpay->enrolmentProcess($request, $id,$user->id);
        } else if ($request['gateway'] == 'mercadopago') {
            $mercadopago = new MercadoPagoController();
            return $mercadopago->enrolmentProcess($request, $id,$user->id);
        } else if ($request['gateway'] == 'mollie') {
            $mollie = new MollieController();
            return $mollie->enrolmentProcess($request, $id,$user->id);
        } else if ($request['gateway'] == 'stripe') {
            $stripe = new StripeController();
            return $stripe->enrolmentProcess($request, $id,$user->id);
        } else if ($request['gateway'] == 'paytm') {
            $paytm = new PaytmController();
            return $paytm->enrolmentProcess($request, $id,$user->id);
        } else if($request['gateway'] == 'authorize.net'){
            $authorizeNet = new AuthorizenetController();
            return $authorizeNet->enrolmentProcess($request, $id,$user->id);
        } else {
            $offline = new OfflineController();
            return $offline->enrolmentProcess($request, $id,$user->id);
        }
    }

    public function calculation(Request $request, $courseId, $userId)
    {
        $course = Course::query()
            ->where('id', '=', $courseId)
            ->where('user_id', $userId)
            ->where('status', '=', 'published')
            ->firstOrFail();

        $course_price = floatval($course->current_price);

        if ($request->session()->has('discountedCourse')) {
            $_course_id = $request->session()->get('discountedCourse');

            if ($courseId == $_course_id) {
                if ($request->session()->has('discount')) {
                    $_discount = $request->session()->get('discount');
                }

                if ($request->session()->has('discountedPrice')) {
                    $_course_new_price = $request->session()->get('discountedPrice');
                }
            }
        }

        return [
            'coursePrice' => $course_price,
            'discount' => isset($_discount) ? floatval($_discount) : null,
            'grandTotal' => isset($_course_new_price) ? floatval($_course_new_price) : $course_price
        ];
    }

    public function storeData($info, $userId)
    {
        return CourseEnrolment::create([
            'user_id' => $userId,
            'customer_id' => Auth::guard('customer')->user()->id,
            'order_id' => time(),
            'billing_first_name' => Auth::guard('customer')->user()->first_name,
            'billing_last_name' => Auth::guard('customer')->user()->last_name,
            'billing_email' => Auth::guard('customer')->user()->email,
            'billing_contact_number' => Auth::guard('customer')->user()->contact_number,
            'billing_address' => Auth::guard('customer')->user()->address,
            'billing_city' => Auth::guard('customer')->user()->city,
            'billing_state' => Auth::guard('customer')->user()->state,
            'billing_country' => Auth::guard('customer')->user()->country,
            'course_id' => $info['courseId'],
            'course_price' => array_key_exists('coursePrice', $info) ? $info['coursePrice'] : null,
            'discount' => array_key_exists('discount', $info) ? $info['discount'] : null,
            'grand_total' => array_key_exists('grandTotal', $info) ? $info['grandTotal'] : null,
            'currency_text' => array_key_exists('currencyText', $info) ? $info['currencyText'] : null,
            'currency_text_position' => array_key_exists('currencyTextPosition', $info) ? $info['currencyTextPosition'] : null,
            'currency_symbol' => array_key_exists('currencySymbol', $info) ? $info['currencySymbol'] : null,
            'currency_symbol_position' => array_key_exists('currencySymbolPosition', $info) ? $info['currencySymbolPosition'] : null,
            'payment_method' => array_key_exists('paymentMethod', $info) ? $info['paymentMethod'] : null,
            'gateway_type' => array_key_exists('gatewayType', $info) ? $info['gatewayType'] : null,
            'payment_status' => array_key_exists('paymentStatus', $info) ? $info['paymentStatus'] : null,
            'attachment' => array_key_exists('attachmentFile', $info) ? $info['attachmentFile'] : null
        ]);
    }

    public function generateInvoice($enrolmentInfo, $courseId, $userId)
    {
        $fileName = $enrolmentInfo->order_id . '.pdf';
        $directory = Constant::WEBSITE_ENROLLMENT_INVOICE .'/';
        $path = Constant::WEBSITE_ENROLLMENT_INVOICE .'/'.$fileName;
        $bs = \App\Models\User\BasicSetting::query()->where('user_id', $userId)
            ->select('aws_status', 'aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket')
            ->first();
        $data = UserPermissionHelper::currentPackageFeatures($userId);
        // get course title
        $language = $this->getUserCurrentLanguage($userId);
        $course = Course::query()->where('user_id', $userId)->findOrFail($courseId);
        $courseInfo = CourseInformation::query()
            ->where('course_id', $course->id)
            ->where('user_id', $userId)
            ->where('language_id', $language->id)
            ->firstOrFail();
        $userBs = UserBasicSetting::query()->select('website_title', 'logo', 'favicon')->where('user_id', $userId)->first();

        $width = '50%';
        $float = 'left';
    
        $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadView('pdf.enrolment', compact('enrolmentInfo', 'courseInfo', 'userBs', 'width', 'float'));
        
        if (in_array("Amazon AWS s3", $data) && $bs->aws_status == 1 && !is_null($bs->aws_access_key_id) && !is_null($bs->aws_secret_access_key) && !is_null($bs->aws_default_region) && !is_null($bs->aws_bucket)) {
            setAwsCredentials($bs->aws_access_key_id, $bs->aws_secret_access_key, $bs->aws_default_region, $bs->aws_bucket);
            Storage::disk('s3')->put($path, $pdf->output());
        } else {
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    die('Failed to create folders...');
                }
            }
            $pdf->save($path);
        }
        return $fileName;
    }

    public function sendMail($enrolmentInfo, $userId)
    {
        // first get the mail template info from db
        $mailTemplate = MailTemplate::query()
            ->where('mail_type', 'course_enrolment')
            ->where('user_id', $userId)
            ->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        // second get the website title & mail's smtp info from db
        $be = DB::table('basic_extendeds')
            ->select('is_smtp', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();
            
        $userBs = \App\Models\User\BasicSetting::query()->where('user_id', $userId)
            ->select('aws_status', 'aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket', 'website_title', 'email', 'from_name')
            ->first();

        $customerName = $enrolmentInfo->billing_first_name . ' ' . $enrolmentInfo->billing_last_name;
        $orderId = $enrolmentInfo->order_id;

        $language = $this->getUserCurrentLanguage($userId);
        $course = Course::query()
            ->where('id', $enrolmentInfo->course_id)
            ->firstOrFail();
        $courseInfo = CourseInformation::query()
            ->where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('language_id', $language->id)
            ->firstOrFail();
        $courseTitle = $courseInfo->title;

        $websiteTitle = $userBs->website_title;

        $mailBody = str_replace('{customer_name}', $customerName, $mailBody);
        $mailBody = str_replace('{order_id}', $orderId, $mailBody);
        $mailBody = str_replace('{title}', $courseTitle, $mailBody);
        $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);

        // initialize a new mail
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // if smtp status == 1, then set some value for PHPMailer
        if ($be->is_smtp == 1) {
            $mail->isSMTP();
            $mail->Host = $be->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $be->smtp_username;
            $mail->Password = $be->smtp_password;
            if ($be->encryption == 'TLS') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            $mail->Port = $be->smtp_port;
        }

        // finally, add other informations and send the mail
        try {
            // Recipients
            $mail->setFrom($be->from_mail, $userBs->from_name);
            $mail->addReplyTo($userBs->email, $userBs->from_name);
            $mail->addAddress($enrolmentInfo->billing_email);
            $directory = Constant::WEBSITE_ENROLLMENT_INVOICE.'/';
            $path = Constant::WEBSITE_ENROLLMENT_INVOICE .'/' . $enrolmentInfo->invoice;
            // Attachments (Invoice)
            if(!is_null($userBs->aws_access_key_id) && !is_null($userBs->aws_secret_access_key) && !is_null($userBs->aws_default_region) && !is_null($userBs->aws_bucket)){
                setAwsCredentials($userBs->aws_access_key_id, $userBs->aws_secret_access_key, $userBs->aws_default_region, $userBs->aws_bucket);
                $s3 = Storage::disk('s3');
                if($s3->exists($path)){
                    if (!file_exists($directory)) {
                        if (!mkdir($directory, 0755, true)) {
                            die('Failed to create folders...');
                        }
                    }
                    touch($path);
                    copy($s3->url($path),$path);
                }
            }
            $mail->addAttachment($path);
            // Content
            $mail->isHTML(true);
            $mail->Subject = $mailSubject;
            $mail->Body = $mailBody;
            $mail->send();
            //remove copied aws file from local storage
            if(!is_null($userBs->aws_access_key_id) && !is_null($userBs->aws_secret_access_key) && !is_null($userBs->aws_default_region) && !is_null($userBs->aws_bucket)){
                setAwsCredentials($userBs->aws_access_key_id, $userBs->aws_secret_access_key, $userBs->aws_default_region, $userBs->aws_bucket);
                $s3 = Storage::disk('s3');
                if($s3->exists($path)){
                    @unlink($path);
                }
            }
            return;
        } catch (\Exception $e) {
            return session()->flash('error', 'Mail could not be sent! Mailer Error: ' . $e);
        }
    }

    public function complete(Request $request, $domain, $id, $via = null)
    {
        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);
        $queryResult['bgImg'] = $this->getUserBreadcrumb($user->id);
        $course = Course::query()->where('user_id', $user->id)->findOrFail($id);

        $queryResult['courseInfo'] = CourseInformation::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->firstOrFail();

        $queryResult['paidVia'] = $via;

        // forget all session data before proceed
        $request->session()->forget('discountedCourse');
        $request->session()->forget('discount');
        $request->session()->forget('discountedPrice');

        return view('user-front.common.customer.payment.success', $queryResult);
    }

    public function cancel(Request $request, $domain, $id)
    {
        $user = getUser();
        $language = $this->getUserCurrentLanguage($user->id);
        $course = Course::query()->where('user_id', $user->id)->findOrFail($id);

        $courseInfo = CourseInformation::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->where('language_id', $language->id)
            ->firstOrFail();

        $request->session()->flash('error', 'Sorry, an error has occurred!');

        // forget all session data before proceed
        $request->session()->forget('discountedCourse');
        $request->session()->forget('discount');
        $request->session()->forget('discountedPrice');

        return redirect()->route('front.user.course.details', [getParam(), 'slug' => $courseInfo->slug]);
    }
}
