<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteHero extends Model
{
    protected $table = 'website_hero';

    protected $fillable = [
        'background_image',
        'heading',
        'paragraph',
        'button1_text',
        'button1_url',
        'button2_text',
        'button2_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
