<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
  use HasFactory;

  protected $fillable = ['qty', 'total', 'delivered_at', 'user_id', 'coupon_id'];

  public function products() {
    $this->belongsToMany(Product::class);
  }
  public function user() {
    $this->belongsTo(User::class);
  }
  public function coupon() {
    $this->belongsTo(Coupon::class);
  }

  public function getCreatedAtAttribute($value) {
    return Carbon::parse($value)->diffForHumans();
  }

  public function getDeliveredAtAttribute($value) {
    if ($value) {
      return Carbon::parse($value)->diffForHumans();
    } else {
      return null;
    }
  }
}
