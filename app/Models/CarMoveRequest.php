<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\CarType;

class CarMoveRequest extends Model
{
   protected $fillable = [
        'name',
        'email',
        'contact_no',
        'pickup_location',
        'drop_location',
        'pickup_state_id',
        'drop_state_id',
        'car_type_id',
        'price_range',
        'status',
    ];

    public function pickupState()
    {
        return $this->belongsTo(State::class, 'pickup_state_id');
    }

    public function dropState()
    {
        return $this->belongsTo(State::class, 'drop_state_id');
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

}
