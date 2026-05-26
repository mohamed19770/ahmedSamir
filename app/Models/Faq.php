<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasTranslations;

    protected $fillable = ['question', 'answer', 'category', 'sort_order', 'is_active'];

    protected $casts = [
        'question' => 'array',
        'answer' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = ['question', 'answer'];

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeByCategory($query, $cat) { return $query->where('category', $cat); }
}
