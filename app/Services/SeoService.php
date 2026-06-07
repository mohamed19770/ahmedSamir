<?php

namespace App\Services;

use App\Helpers\LocaleHelper;
use App\Models\SeoSetting;

class SeoService
{
    public function meta(string $pageIdentifier, array $overrides = [], ?object $entity = null): array
    {
        $locale = app()->getLocale();
        $setting = SeoSetting::getForPage($pageIdentifier);

        $meta = [
            'title' => config('site.name').' - '.config('site.tagline'),
            'description' => config('site.tagline'),
            'keywords' => $this->defaultKeywords($locale, $pageIdentifier),
            'canonical' => url()->current(),
            'og_title' => config('site.name'),
            'og_description' => config('site.tagline'),
            'og_image' => $this->resolveImage(config('site.og_image')),
            'og_type' => 'website',
            'robots' => 'index, follow',
        ];

        $this->applyTranslationDefaults($meta, $pageIdentifier);

        if ($setting) {
            $meta['title'] = $setting->getTranslation('meta_title', $locale) ?: $meta['title'];
            $meta['description'] = $setting->getTranslation('meta_description', $locale) ?: $meta['description'];
            $meta['og_title'] = $meta['title'];
            $meta['og_description'] = $meta['description'];

            if ($keywords = $setting->getTranslation('meta_keywords', $locale)) {
                $meta['keywords'] = $keywords;
            }

            if ($setting->og_image) {
                $meta['og_image'] = $this->resolveImage($setting->og_image);
            }

            if ($setting->canonical_url) {
                $meta['canonical'] = $setting->canonical_url;
            }
        }

        if ($entity && method_exists($entity, 'getTranslation')) {
            if ($title = $entity->getTranslation('meta_title', $locale)) {
                $meta['title'] = $title.' - '.config('site.name');
            } elseif ($name = $entity->getTranslation('title', $locale) ?? $entity->getTranslation('name', $locale)) {
                $meta['title'] = $name.' - '.config('site.name');
            }

            $meta['og_title'] = $meta['title'];
            $meta['description'] = $entity->getTranslation('meta_description', $locale)
                ?: $entity->getTranslation('short_description', $locale)
                ?: $entity->getTranslation('excerpt', $locale)
                ?: $meta['description'];
            $meta['og_description'] = $meta['description'];

            if ($entityKeywords = $entity->getTranslation('meta_keywords', $locale)) {
                $meta['keywords'] = $this->mergeKeywords($meta['keywords'], $entityKeywords);
            }

            if (! empty($entity->image)) {
                $meta['og_image'] = $this->resolveImage($entity->image);
            }
        }

        if (! empty($overrides['keywords']) && ! empty($meta['keywords'])) {
            $overrides['keywords'] = $this->mergeKeywords($meta['keywords'], $overrides['keywords']);
        }

        return array_merge($meta, $overrides);
    }

    public function shareToView(
        string $pageIdentifier,
        array $overrides = [],
        ?object $entity = null,
        ?array $hreflangUrls = null
    ): void {
        view()->share('seo', $this->meta($pageIdentifier, $overrides, $entity));
        view()->share('hreflangUrls', $hreflangUrls ?? LocaleHelper::hreflangUrls());
    }

    public function defaultKeywords(string $locale, ?string $pageIdentifier = null): string
    {
        $langKey = $pageIdentifier ? "seo.{$pageIdentifier}_keywords" : null;
        if ($langKey && __($langKey) !== $langKey) {
            return __($langKey);
        }

        if ($pageIdentifier && ($pageKeywords = config("seo.page_keywords.{$pageIdentifier}.{$locale}"))) {
            return $pageKeywords;
        }

        return config("seo.default_keywords.{$locale}", config('seo.default_keywords.en'));
    }

    public function resolveImage(?string $path): string
    {
        if (! $path) {
            return asset(config('site.og_image'));
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/'.$path);
    }

    protected function applyTranslationDefaults(array &$meta, string $pageIdentifier): void
    {
        $titleKey = "seo.{$pageIdentifier}_title";
        $descKey = "seo.{$pageIdentifier}_description";

        if (__($titleKey) !== $titleKey) {
            $meta['title'] = __($titleKey);
            $meta['og_title'] = $meta['title'];
        }

        if (__($descKey) !== $descKey) {
            $meta['description'] = __($descKey);
            $meta['og_description'] = $meta['description'];
        }
    }

    protected function mergeKeywords(string ...$parts): string
    {
        return collect($parts)
            ->flatMap(fn ($part) => array_map('trim', explode(',', $part)))
            ->filter()
            ->unique()
            ->implode(', ');
    }
}
