<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'video_url',
        'button_text', 'button_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'description' => 'array',
        'button_text' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = ['title', 'subtitle', 'description', 'button_text'];

    public function scopeActive($query) { return $query->where('is_active', true); }
}
