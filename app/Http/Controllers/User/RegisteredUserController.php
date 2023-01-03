<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
  public function index(Request $request)
  {
    $searchKey = null;

    if ($request->filled('info')) {
      $searchKey = $request['info'];
    }

    $users = Customer::when($searchKey, function ($query, $searchKey) {
      return $query->where('username', 'like', '%' . $searchKey . '%')
        ->orWhere('email', 'like', '%' . $searchKey . '%');
    })
    ->where('user_id', Auth::guard('web')->user()->id)
    ->orderBy('id', 'desc')
    ->paginate(10);

    return view('user.registered-users.index', compact('users'));
  }

  public function updateAccountStatus(Request $request, $id)
  {
    $user = Customer::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

    if ($request['account_status'] == 1) {
      $user->update(['status' => 1]);
    } else {
      $user->update(['status' => 0]);
    }

    $request->session()->flash('success', 'Account status updated successfully!');

    return redirect()->back();
  }

  public function show($id)
  {
    $userInfo = Customer::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();
    $information['userInfo'] = $userInfo;
    return view('user.registered-users.details', $information);
  }

  public function changePassword($id)
  {
    $userInfo = Customer::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();
    return view('user.registered-users.change-password', compact('userInfo'));
  }

  public function updatePassword(Request $request, $id)
  {
    $rules = [
      'new_password' => 'required|confirmed',
      'new_password_confirmation' => 'required'
    ];

    $messages = [
      'new_password.confirmed' => 'Password confirmation does not match.',
      'new_password_confirmation.required' => 'The confirm new password field is required.'
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }

    $user = Customer::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

    $user->update([
      'password' => Hash::make($request->new_password)
    ]);

    $request->session()->flash('success', 'Password updated successfully!');
    return 'success';
  }

  public function destroy($id)
  {
    $user = Customer::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

    // delete course enrolment
    if ($user->courseEnrolment()->count() > 0) {
        $user->courseEnrolment()->delete();
    }

    if ($user->quizScore()->count() > 0) {
        $user->quizScore()->delete();
    }

    if ($user->review()->count() > 0) {
        $user->review()->delete();
    }

    // delete user image
    Uploader::remove(Constant::WEBSITE_TENANT_CUSTOMER_IMAGE .'/'. Auth::guard('web')->user()->id, $user->image);
    $user->delete();

    return redirect()->back()->with('success', 'User info deleted successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $user = Customer::where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();

        // delete course enrolment
        if ($user->courseEnrolment()->count() > 0) {
            $user->courseEnrolment()->delete();
        }

        if ($user->quizScore()->count() > 0) {
            $user->quizScore()->delete();
        }

        if ($user->review()->count() > 0) {
            $user->review()->delete();
        }

      // delete user image
      Uploader::remove(Constant::WEBSITE_TENANT_CUSTOMER_IMAGE.'/'.Auth::guard('web')->user()->id, $user->image);
      $user->delete();
    }

    $request->session()->flash('success', 'Users info deleted successfully!');

    return 'success';
  }


  public function emailStatus(Request $request)
  {
      $user = Customer::where('id', $request->user_id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();
      $user->update([
          'email_verified_at' => $request->email_verified == 1 ? Carbon::now() : NULL,
      ]);
      $request->session()->flash('success', 'Email status updated for ' . $user->username);
      return back();
  }
}
