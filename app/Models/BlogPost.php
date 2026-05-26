<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasTranslations;

    protected $fillable = [
        'author_id', 'title', 'slug', 'content', 'excerpt', 'image', 'category',
        'tags', 'is_published', 'published_at', 'views_count', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'content' => 'array',
        'excerpt' => 'array',
        'tags' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected array $translatable = ['title', 'slug', 'content', 'excerpt', 'meta_title', 'meta_description'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
