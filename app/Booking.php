<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
  use SoftDeletes;

    protected $fillable = [
      'start_time',
      'end_time',
      'status'
    ];

    protected $dates = ['deleted_at'];

    public function client()
    {
      return $this->belongsTo(Client::class);
    }

    public function pet()
    {
      return $this->belongsTo(Pet::class);
    }

    public function employee()
    {
      return $this->belongsTo(Employee::class);
    }

}
