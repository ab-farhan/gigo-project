<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $table = "packages";

    protected $fillable = [
        'title',
        'slug',
        'price',
        'term',
        'featured',
        'recommended',
        'icon',
        'is_trial',
        'trial_days',
        'status',
        'storage_limit',
        'course_categories_limit',
        'featured_course_limit',
        'course_limit',
        'module_limit',
        'lesson_limit',
        'features',
        'meta_keywords',
        'meta_description',
    ];

    public function memberships() {
        return $this->hasMany('App\Models\Membership');
    }
}
