<?php

namespace App\Models\User\HomePage\Fact;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountInformation extends Model
{
  use HasFactory;

  protected $table = 'user_count_informations';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['language_id','user_id', 'icon', 'color', 'title', 'amount', 'serial_number'];

  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id');
  }
}
