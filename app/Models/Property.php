<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'father_name',
        'contact_number',
        'email',
        'dob',
        'address',
        'property_type',
        'property_number',
        'khewat_number',
        'khasra_number',
        'plot_size',
        'ownership_type',
        'location',
        'landmark',
        'price',
        'sector_id',
        'category_id',
        'subcategory_id',
        'description',
        'status',
        'property_status',
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
