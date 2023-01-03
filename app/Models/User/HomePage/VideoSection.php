<?php

namespace App\Models\User\HomePage;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
  use HasFactory;

  public $table = "user_video_sections";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'language_id',
      'user_id',
      'title',
      'image',
      'link'
  ];

  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id');
  }
}
