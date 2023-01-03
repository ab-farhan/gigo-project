<?php

namespace App\Models\User\HomePage;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    public $table = "user_features";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id',
        'user_id',
        'background_color',
        'icon',
        'title',
        'text',
        'serial_number'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
