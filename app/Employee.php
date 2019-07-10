<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'ic_no',
        'address',
        'gender',
        'birth_date',
        'phone'
    ];
}
