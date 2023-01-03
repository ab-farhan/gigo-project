<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
  use HasFactory;

  public $table = "user_advertisements";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'ad_type',
    'user_id',
    'resolution_type',
    'image',
    'url',
    'slot',
    'views'
  ];
}
