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
        'service_limit',
        'service_categories_limit',
        'service_subcategories_limit',
        'service_orders_limit',
        'user_limit',
        'product_limit',
        'product_orders_limit',
        'post_limit',
        'vCard_limit',
        'language_limit',
        'features',
        'meta_keywords',
        'meta_description',
    ];

    public function memberships()
    {
        return $this->hasMany('App\Models\Membership');
    }
}
