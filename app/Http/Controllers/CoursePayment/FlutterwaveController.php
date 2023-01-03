<?php

namespace App\Http\Controllers\CoursePayment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\Curriculum\EnrolmentController;
use App\Models\User\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class FlutterwaveController extends Controller
{
    protected $key, $secret;
    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'flutterwave')
            ->where('user_id', $user->id)
            ->first();
        $flutterwaveData = json_decode($data->information, true);

        $this->key = $flutterwaveData['public_key'];
        $this->secret = $flutterwaveData['secret_key'];

        config([
            // in case you would like to overwrite values inside config/services.php
            'flutterwave.publicKey' => $this->key,
            'flutterwave.secretKey' => $this->secret,
            'flutterwave.secretHash' => '',
        ]);
    }

    public function enrolmentProcess(Request $request, $courseId, $userId)
    {
        $enrol = new EnrolmentController();

        // do calculation
        $calculatedData = $enrol->calculation($request, $courseId, $userId);

        $allowedCurrencies = array('BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'MZN', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD');

        $currencyInfo = $this->getUserCurrencyInfo($userId);

        // checking whether the base currency is allowed or not
        if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
            return redirect()->back()->with('error', 'Invalid currency for flutterwave payment.')->withInput();
        }

        $arrData = array(
            'courseId' => $courseId,
            'coursePrice' => $calculatedData['coursePrice'],
            'discount' => $calculatedData['discount'],
            'grandTotal' => $calculatedData['grandTotal'],
            'currencyText' => $currencyInfo->base_currency_text,
            'currencyTextPosition' => $currencyInfo->base_currency_text_position,
            'currencySymbol' => $currencyInfo->base_currency_symbol,
            'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
            'paymentMethod' => 'Flutterwave',
            'gatewayType' => 'online',
            'paymentStatus' => 'completed'
        );

        $title = 'Course Enrolment';
        $notifyURL = route('course_enrolment.flutterwave.notify', getParam());

        // generate a payment reference
        $reference = Flutterwave::generateReference();

        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $calculatedData['grandTotal'],
            'email' => Auth::guard('customer')->user()->email,
            'tx_ref' => $reference,
            'currency' => $currencyInfo->base_currency_text,
            'redirect_url' => $notifyURL,
            'customer' => [
                'email' => Auth::guard('customer')->user()->email,
                'phone_number' => Auth::guard('customer')->user()->contact_number,
                'name' => Auth::guard('customer')->user()->first_name . ' ' . Auth::guard('customer')->user()->last_name
            ],
            'customizations' => [
                'title' => $title,
                'description' => 'Course Enrolment via Flutterwave'
            ]
        ];

        $payment = Flutterwave::initializePayment($data);

        // put some data in session before redirect to flutterwave url
        $request->session()->put('courseId', $courseId);
        $request->session()->put('arrData', $arrData);
        $request->session()->put('userId', $userId);

        if ($payment['status'] === 'success') {
            return redirect($payment['data']['link']);
        } else {
            return redirect()->back()->with('error', 'Error: ' . $payment['message'])->withInput();
        }
    }

    public function notify(Request $request)
    {
        // get the information from session
        $courseId = $request->session()->get('courseId');
        $userId = $request->session()->get('userId');
        $arrData = $request->session()->get('arrData');

        $urlInfo = $request->all();

        if ($urlInfo['status'] == 'successful') {
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $transactionInfo = Flutterwave::verifyTransaction($transactionID);

            if ($transactionInfo['data']['status'] == 'successful') {
                $enrol = new EnrolmentController();

                // store the course enrolment information in database
                $enrolmentInfo = $enrol->storeData($arrData, $userId);

                // generate an invoice in pdf format
                $invoice = $enrol->generateInvoice($enrolmentInfo, $courseId, $userId);

                // then, update the invoice field info in database
                $enrolmentInfo->update(['invoice' => $invoice]);

                // send a mail to the customer with the invoice
                $enrol->sendMail($enrolmentInfo, $userId);

                // remove all session data
                $request->session()->forget('userId');
                $request->session()->forget('courseId');
                $request->session()->forget('arrData');

                return redirect()->route('front.user.course_enrolment.complete', [getParam(), 'id' => $courseId]);
            } else {
                // remove all session data
                $request->session()->forget('userId');
                $request->session()->forget('courseId');
                $request->session()->forget('arrData');

                return redirect()->route('front.user.course_enrolment.cancel', [getParam(), 'id' => $courseId]);
            }
        } else {
            // remove all session data
            $request->session()->forget('userId');
            $request->session()->forget('courseId');
            $request->session()->forget('arrData');

            return redirect()->route('front.user.course_enrolment.cancel', [getParam(), 'id' => $courseId]);
        }
    }
}
