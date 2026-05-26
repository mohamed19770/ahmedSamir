<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'slug', 'description', 'short_description', 'icon', 'image',
        'is_active', 'sort_order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = ['title', 'slug', 'description', 'short_description', 'meta_title', 'meta_description'];

    public function scopeActive($query) { return $query->where('is_active', true); }
}
