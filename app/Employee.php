<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
  use SoftDeletes;

    protected $fillable = [
        'name',
        'ic_no',
        'address',
        'gender',
        'birth_date',
        'phone'
    ];

    protected $dates = ['deleted_at'];

    public function bookings()
    {
      return $this->hasMany(Booking::class);
    }
    
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
