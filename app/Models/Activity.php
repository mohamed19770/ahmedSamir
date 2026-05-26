<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'slug', 'description', 'short_description', 'image', 'gallery',
        'price', 'duration', 'category', 'location', 'is_featured', 'is_active',
        'meta_title', 'meta_description', 'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'gallery' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected array $translatable = ['title', 'slug', 'description', 'short_description', 'meta_title', 'meta_description'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
