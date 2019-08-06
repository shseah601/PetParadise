<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
  use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'gender',
        'age'
    ];

    protected $dates = ['deleted_at'];

    public function pendingBookings()
    {
      return $this->hasMany(PnedingBooking::class);
    }
    
    public function bookings()
    {
      return $this->hasMany(Booking::class);
    }

    public function client()
    {
      return $this->belongsTo(Client::class);
    }
}
