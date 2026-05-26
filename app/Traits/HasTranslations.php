<?php

namespace App\Traits;

trait HasTranslations
{
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->getAttribute($field);

        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? $value[array_key_first($value)] ?? null;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded[$locale] ?? $decoded['en'] ?? $decoded[array_key_first($decoded)] ?? null;
            }
            return $value;
        }

        return $value;
    }

    public function setTranslation(string $field, string $locale, string $value): self
    {
        $current = $this->getAttribute($field) ?? [];
        if (is_string($current)) {
            $current = json_decode($current, true) ?? [];
        }
        $current[$locale] = $value;
        $this->setAttribute($field, $current);

        return $this;
    }

    public function getTranslations(string $field): array
    {
        $value = $this->getAttribute($field);
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return [];
    }

    public function scopeWhereTranslation($query, string $field, string $value, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $query->whereRaw("({$field}->>'{$locale}') = ?", [$value]);
    }

    public function scopeWhereTranslationLike($query, string $field, string $value, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $query->whereRaw("({$field}->>'{$locale}') ILIKE ?", ["%{$value}%"]);
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if ($field && in_array($field, $this->translatable ?? [])) {
            $locale = app()->getLocale();
            return $query->whereRaw("({$field}->>'{$locale}') = ?", [$value]);
        }

        if ($field === null && in_array('slug', $this->translatable ?? [])) {
            $locale = app()->getLocale();
            return $query->whereRaw("(slug->>'{$locale}') = ?", [$value]);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }
}
