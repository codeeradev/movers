<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientMatch extends Model
{
    protected $table = 'client_matches';

    protected $fillable = [
        'buyer_request_id',
        'seller_request_id',
        'matched_at',
        'meta',
    ];

    protected $casts = [
        'matched_at' => 'datetime',
        'meta' => 'array',
    ];

    // Relationship to buyer request
    public function buyer()
    {
        return $this->belongsTo(ClientRequest::class, 'buyer_request_id');
    }

    // Relationship to seller request
    public function seller()
    {
        return $this->belongsTo(ClientRequest::class, 'seller_request_id');
    }
}
