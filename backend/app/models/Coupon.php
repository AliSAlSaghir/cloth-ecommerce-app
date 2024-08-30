<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model {
  use HasFactory;

  protected $fillable = ['name', 'discount', 'valid_until'];

  public function setNameAttribute($value) {
    $this->attributes['name'] = Str::upper($value);
  }

  public function checkIfValid() {
    if ($this->valid_until > Carbon::now()) return true;
    return false;
  }
}
