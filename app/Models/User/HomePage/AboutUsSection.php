<?php

namespace App\Models\User\HomePage;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsSection extends Model
{
  use HasFactory;

  public $table = "user_about_us_sections";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'language_id',
      'user_id',
      'image',
      'title',
      'subtitle',
      'text'
  ];

  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id');
  }
}
