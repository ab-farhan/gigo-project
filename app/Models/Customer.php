<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use App\Models\User\Curriculum\CourseEnrolment;
use App\Models\User\Curriculum\CourseReview;
use App\Models\User\Curriculum\QuizScore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    public $table = "customers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'image',
        'username',
        'email',
        'email_verified_at',
        'password',
        'contact_number',
        'address',
        'city',
        'state',
        'country',
        'status',
        'verification_token',
        'edit_profile_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courseEnrolment()
    {
        return $this->hasMany(CourseEnrolment::class, 'customer_id', 'id');
    }

    public function review()
    {
        return $this->hasMany(CourseReview::class, 'customer_id', 'id');
    }

    public function quizScore()
    {
        return $this->hasMany(QuizScore::class, 'customer_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $username = Customer::query()->where('email',request()->email)->pluck('username')->first();
        $subject = 'You are receiving this email because we received a password reset request for your account.';
        $body = "Recently you tried forget password for your account.Click below to reset your account password.
             <br>
             <a href='".url('password/reset/'.$token .'/email/'.request()->email)."'><button type='button' class='btn btn-primary'>Reset Password</button></a>
             <br>
             Thank you.
             ";
        $controller = new Controller();
        $controller->resetPasswordMail(request()->email,$username,$subject,$body);
        session()->flash('success', "we sent you an email. Please check your inbox");
    }
}
