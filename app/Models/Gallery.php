<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'description', 'image', 'video_url', 'category',
        'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected array $translatable = ['title', 'description'];

    public function scopeFeatured($query) { return $query->where('is_featured', true); }
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeByCategory($query, $cat) { return $query->where('category', $cat); }
}
