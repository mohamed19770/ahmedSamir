<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasTranslations;

    protected $fillable = [
        'page_identifier', 'meta_title', 'meta_description', 'meta_keywords', 'og_image', 'schema_markup', 'canonical_url',
    ];

    protected $casts = [
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
        'schema_markup' => 'array',
    ];

    protected array $translatable = ['meta_title', 'meta_description', 'meta_keywords'];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->firstOrFail();
    }

    public static function getForPage(string $identifier): ?self
    {
        return static::where('page_identifier', $identifier)->first();
    }
}
