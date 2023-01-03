<?php

namespace App\Models\User\HomePage\Fact;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunFactSection extends Model
{
  use HasFactory;

  public $table = "user_fun_fact_sections";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['language_id','user_id', 'background_image', 'title'];

  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id');
  }
}
