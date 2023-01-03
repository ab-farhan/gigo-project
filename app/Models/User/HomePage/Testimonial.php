<?php

namespace App\Models\User\HomePage;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
  use HasFactory;

  protected $table = 'user_testimonials';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'language_id',
      'user_id',
      'image',
      'name',
      'occupation',
      'comment',
      'serial_number'
  ];

  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id');
  }
}
