<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name', 'email', 'avatar', 'rating', 'content', 'designation',
        'company', 'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'content' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    protected array $translatable = ['content'];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
