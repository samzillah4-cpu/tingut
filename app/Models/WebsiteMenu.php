<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteMenu extends Model
{
    protected $table = 'website_menus';

    protected $fillable = [
        'name',
        'url',
        'order',
        'is_active',
        'open_in_new_tab',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
