<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourismPackage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'destination_id', 'title', 'slug', 'description', 'short_description',
        'duration_days', 'duration_nights', 'price', 'sale_price', 'currency',
        'included', 'excluded', 'itinerary', 'image', 'gallery', 'max_guests',
        'min_guests', 'is_featured', 'is_active', 'difficulty_level', 'category',
        'meta_title', 'meta_description', 'meta_keywords', 'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'included' => 'array',
        'excluded' => 'array',
        'itinerary' => 'array',
        'gallery' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    protected array $translatable = ['title', 'slug', 'description', 'short_description', 'meta_title', 'meta_description', 'meta_keywords'];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'package_id');
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
