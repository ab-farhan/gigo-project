<?php

namespace App\Models\User\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $table = 'instructor_social_links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instructor_id',
        'user_id',
        'icon',
        'url',
        'serial_number'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class,'instructor_id');
    }
}
