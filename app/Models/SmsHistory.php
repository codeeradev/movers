<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class SmsHistory extends Model
{
    protected $fillable = [
        'property_id',
        'mobile',
        'message',
        'template_id',
        'type',  
        'status',
        'api_response',
    ];

     public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
