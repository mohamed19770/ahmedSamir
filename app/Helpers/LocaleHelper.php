<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class LocaleHelper
{
    public static function supported(): array
    {
        return config('locales.supported', ['en', 'ar', 'hr']);
    }

    public static function default(): string
    {
        return config('locales.default', config('app.locale', 'en'));
    }

    public static function isRtl(?string $locale = null): bool
    {
        $locale ??= app()->getLocale();

        return in_array($locale, config('locales.rtl', []), true);
    }

    public static function pathWithoutLocale(?string $path = null): string
    {
        $path ??= request()->path();
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if ($segments !== [] && in_array($segments[0], self::supported(), true)) {
            array_shift($segments);
        }

        return implode('/', $segments);
    }

    public static function localizedUrl(string $locale, ?string $path = null): string
    {
        $suffix = self::pathWithoutLocale($path);

        return $suffix === '' ? url($locale) : url($locale.'/'.$suffix);
    }

    public static function hreflangUrls(?string $path = null): array
    {
        $urls = [];

        foreach (self::supported() as $locale) {
            $urls[$locale] = self::localizedUrl($locale, $path);
        }

        $urls['x-default'] = self::localizedUrl(self::default(), $path);

        return $urls;
    }

    public static function entityHreflangUrls(string $routeName, object $entity): array
    {
        $urls = [];

        foreach (self::supported() as $locale) {
            $slug = method_exists($entity, 'getTranslation')
                ? $entity->getTranslation('slug', $locale)
                : null;

            $urls[$locale] = $slug
                ? route($routeName, [$locale, $slug])
                : self::localizedUrl($locale);
        }

        $urls['x-default'] = $urls[self::default()] ?? reset($urls);

        return $urls;
    }

    public static function detectFromRequest(Request $request): string
    {
        if ($request->hasCookie('locale')) {
            $cookie = $request->cookie('locale');
            if (in_array($cookie, self::supported(), true)) {
                return $cookie;
            }
        }

        $preferred = $request->getPreferredLanguage(self::supported());

        return $preferred ?: self::default();
    }

    public static function ogLocale(string $locale): string
    {
        return match ($locale) {
            'ar' => 'ar_SA',
            'hr' => 'hr_HR',
            default => 'en_US',
        };
    }
}
