<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 'country', 'city',
        'image', 'gallery', 'latitude', 'longitude', 'is_featured', 'is_active',
        'meta_title', 'meta_description', 'meta_keywords', 'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'slug' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'gallery' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected array $translatable = ['name', 'slug', 'description', 'short_description', 'meta_title', 'meta_description', 'meta_keywords'];

    public function packages(): HasMany
    {
        return $this->hasMany(TourismPackage::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
