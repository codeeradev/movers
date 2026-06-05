<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'phone',
        'email',
        'address',
        'payment_link',
        'footer_text',
        'google_map',
        'logo',
        'favicon',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_button_text',
        'hero_button_url',
        'hero_form_title',
        'hero_background_image',
        'home_choose_title',
        'home_choose_subtitle',
        'home_choose_items',
        'home_stats_title',
        'home_stats_subtitle',
        'home_stats_items',
    ];

    protected $casts = [
        'home_choose_items' => 'array',
        'home_stats_items' => 'array',
    ];
}
