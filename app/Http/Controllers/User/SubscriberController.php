<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\User\Subscriber;
use App\Models\BasicSetting;
use App\Models\BasicExtended;
use App\Mail\ContactMail;
use Mail;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->term;
        $data['subscs'] = Subscriber::where('user_id', Auth::guard('web')->user()->id)
            ->when($term, function ($query, $term) {
                return $query->where('email', 'LIKE', '%' . $term . '%');
            })->orderBy('id', 'DESC')->paginate(10);
        return view('user.subscribers.index', $data);
    }

    public function store(Request $request, $domain)
    {
        $user = getUser();
        $request->validate([
            'email' => ['required',
                function ($attribute, $value, $fail) use ($user) {
                    $subscriber = Subscriber::where([
                        ['email', $value],
                        ['user_id', $user->id]
                    ])->get();
                    if ($subscriber->count() > 0) {
                        Session::flash('error', 'This email is already subscribed');
                        $fail(':attribute already subscribed for this user');
                    }
                },
            ],
        ]);
        $request['user_id'] = $user->id;
        Subscriber::create($request->all());
        return Response::json([
            'success' => 'You have successfully subscribed to our newsletter.'
        ]);
    }

    public function mailsubscriber()
    {
        return view('user.subscribers.mail');
    }

    public function subscsendmail(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        $sub = $request->subject;
        $msg = $request->message;

        $subscs = Subscriber::where('user_id', Auth::guard('web')->user()->id)->get();
        $info = \App\Models\User\BasicSetting::where('user_id', Auth::guard('web')->user()->id)->select('email', 'from_name')->first();
        $email = $info->email ?? Auth::user()->email;
        $name = $info->from_name ?? Auth::user()->company_name;
        $settings = BasicSetting::first();
        $from = $settings->contact_mail;

        $be = BasicExtended::first();

        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = $be->smtp_username;                     // SMTP username
                $mail->Password = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->addReplyTo($email);

                //Recipients
                $mail->setFrom($be->from_mail, $name);

                foreach ($subscs as $key => $subsc) {
                    $mail->addBCC($subsc->email);
                }
            } catch (Exception $e) {

            }
        } else {
            try {
                //Recipients
                $mail->setFrom($be->from_mail, $name);
                $mail->addReplyTo($email);
                foreach ($subscs as $key => $subsc) {
                    $mail->addBCC($subsc->email);
                }
            } catch (Exception $e) {

            }
        }
        // Content
        $mail->isHTML(true);   // Set email format to HTML
        $mail->Subject = $sub;
        $mail->Body = $msg;

        $mail->send();

        Session::flash('success', 'Mail sent successfully!');
        return back();
    }


    public function delete(Request $request)
    {
        Subscriber::findOrFail($request->subscriber_id)->delete();
        Session::flash('success', 'Subscriber deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            Subscriber::findOrFail($id)->delete();
        }
        Session::flash('success', 'Subscribers deleted successfully!');
        return "success";
    }
}
