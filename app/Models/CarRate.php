<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_state_id',
        'drop_state_id',
        'car_type_id',
        'price',
        'status',
    ];

    public function pickupState() {
        return $this->belongsTo(State::class, 'pickup_state_id');
    }

    public function dropState() {
        return $this->belongsTo(State::class, 'drop_state_id');
    }

    public function carType() {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

}
