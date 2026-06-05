<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'scope',
        'service_id',
        'sort_order',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
