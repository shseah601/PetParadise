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
    'description',
    'image',
    'duration',
    'capacity'
  ];

  protected $dates = ['deleted_at'];
}
