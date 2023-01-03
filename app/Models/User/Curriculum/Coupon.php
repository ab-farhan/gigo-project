<?php

namespace App\Models\User\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
  use HasFactory;

  protected $table = 'user_coupons';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'name',
    'code',
    'type',
    'value',
    'start_date',
    'end_date',
    'courses'
  ];
}
