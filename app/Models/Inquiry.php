<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'inquiries';

    protected $fillable = [
        'type',            // 1 = Buy, 2 = Sell
        'name',
        'phone',
        'email',
        'sector',
        'category_id',
        'subcategory_id',
        'property_type',
        'property_id',
        'message',
        'status',          // 1=Urgent,2=High,3=Medium,4=Low
    ];

    /*
     |--------------------------------------------------------------------------
     | RELATIONS (Optional but recommended)
     |--------------------------------------------------------------------------
     */

    public function sectorData()
    {
        return $this->belongsTo(\App\Models\Sector::class, 'sector');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(\App\Models\Subcategory::class, 'subcategory_id');
    }
}
