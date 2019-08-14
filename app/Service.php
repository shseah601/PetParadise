<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'name',
    'type',
    'price_min',
    'price_max',
    'description',
    'image',
    'duration',
    'capacity'
  ];

  protected $dates = ['deleted_at'];

  public function pendingBookings()
  {
    return $this->hasMany(PendingBooking::class);
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class);
  }
}
