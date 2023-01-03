<?php

namespace App\Models\User;

use App\Constants\Constant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BasicSetting extends Model
{
    public $table = "user_basic_settings";

    protected $fillable = [
        'favicon',
        'logo',
        'cv',
        'breadcrumb',
        'footer_logo',
        'base_color',
        'theme_version',
        'user_id',
        'aws_status',
        'aws_access_key_id',
        'aws_secret_access_key',
        'aws_default_region',
        'aws_bucket',
        'whatsapp_status',
        'whatsapp_number',
        'whatsapp_header_title',
        'whatsapp_popup_status',
        'whatsapp_popup_message',
        'disqus_status',
        'disqus_short_name',
        'storage_usage',
        'maintenance_img',
        'maintenance_msg',
        'maintenance_status',
        'bypass_token'
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Language::class,'user_id');
    }
}
