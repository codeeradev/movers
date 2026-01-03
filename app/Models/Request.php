<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'contact_number',
        'type',
        'sector_id',
        'category_id',
        'subcategory_id',
        'location',
        'status',
        'notes',
        'property_id',
    ];

    // Relationships
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    

    
}
