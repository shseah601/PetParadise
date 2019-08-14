<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingBooking extends Model
{
  protected $fillable = [
    'start_time',
    'end_time',
    'status'
  ];

  public function client()
  {
    return $this->belongsTo(Client::class);
  }

  public function pet()
  {
    return $this->belongsTo(Pet::class);
  }
  
  public function service()
  {
    return $this->belongsTo(Service::class);
  }
  
}
