<?php

namespace App\Models\User\HomePage;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = "user_hero_sections";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id',
        'user_id',
        'background_image',
        'first_title',
        'second_title',
        'first_button',
        'first_button_url',
        'second_button',
        'second_button_url',
        'video_url',
        'image'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
