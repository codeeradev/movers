<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarProcess extends Model
{
   // App\Models\CarProcess.php
protected $fillable = [
    'title',
    'description',
    'image',
    'sort_order',
    'status',
];

}
