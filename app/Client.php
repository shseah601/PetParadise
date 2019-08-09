<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
  use SoftDeletes;
  
    protected $fillable = [
      'name',
      'address',
      'phone'
    ];

    protected $dates = ['deleted_at'];

    public function pets()
    {
      return $this->hasMany(Pet::class);
    }

    public function pendingBookings()
    {
      return $this->hasMany(PendingBooking::class);
    }

    public function bookings()
    {
      return $this->hasMany(Booking::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
