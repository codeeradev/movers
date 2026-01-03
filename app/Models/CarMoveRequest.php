<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarMoveRequest extends Model
{
   protected $fillable = [
        'name',
        'email',
        'contact_no',
        'pickup_location',
        'drop_location',
        'status',
    ];

}
