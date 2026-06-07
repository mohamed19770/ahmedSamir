<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Destination;
use App\Models\TourismPackage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private array $locales = ['en', 'ar', 'hr'];

    public function index(): Response
    {
        $sitemaps = collect($this->locales)
            ->map(fn ($locale) => $this->sitemapEntry(url("sitemap-{$locale}.xml"), now()))
            ->push($this->sitemapEntry(url('ai-sitemap.xml'), now()))
            ->implode('');

        return $this->xmlResponse(
            '<?xml version="1.0" encoding="UTF-8"?>'
            .'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            .$sitemaps
            .'</sitemapindex>'
        );
    }

    public function locale(string $locale): Response
    {
        abort_unless(in_array($locale, $this->locales, true), 404);

        $urls = array_merge(
            $this->staticPages($locale),
            $this->destinationUrls($locale),
            $this->tourUrls($locale),
            $this->activityUrls($locale),
            $this->blogUrls($locale),
        );

        return $this->xmlResponse(
            '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '
            .'xmlns:xhtml="http://www.w3.org/1999/xhtml">'
            .implode('', $urls)
            .'</urlset>'
        );
    }

    public function ai(): Response
    {
        $entries = [];

        foreach ($this->locales as $locale) {
            $entries[] = ['url' => url("{$locale}"), 'type' => 'homepage', 'priority' => '1.0'];
            $entries[] = ['url' => url("{$locale}/destinations"), 'type' => 'destinations', 'priority' => '0.9'];
            $entries[] = ['url' => url("{$locale}/tours"), 'type' => 'tours', 'priority' => '0.9'];
            $entries[] = ['url' => url("{$locale}/blog"), 'type' => 'blog', 'priority' => '0.8'];
            $entries[] = ['url' => url("{$locale}/faq"), 'type' => 'faq', 'priority' => '0.7'];
        }

        foreach (Destination::active()->get() as $destination) {
            foreach ($this->locales as $locale) {
                $slug = $destination->getTranslation('slug', $locale);
                if ($slug) {
                    $entries[] = [
                        'url' => url("{$locale}/destinations/{$slug}"),
                        'type' => 'destination',
                        'name' => $destination->getTranslation('name', $locale),
                        'priority' => '0.8',
                    ];
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?><ai-sitemap>';
        foreach ($entries as $entry) {
            $xml .= '<url>';
            $xml .= '<loc>'.e($entry['url']).'</loc>';
            $xml .= '<type>'.e($entry['type']).'</type>';
            $xml .= '<priority>'.e($entry['priority']).'</priority>';
            if (! empty($entry['name'])) {
                $xml .= '<title>'.e($entry['name']).'</title>';
            }
            $xml .= '</url>';
        }
        $xml .= '</ai-sitemap>';

        return $this->xmlResponse($xml);
    }

    private function staticPages(string $locale): array
    {
        $pages = [
            '' => ['priority' => '1.0', 'changefreq' => 'daily'],
            'about' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'destinations' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'tours' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'activities' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'hotels' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'visa-services' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'transportation' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'blog' => ['priority' => '0.8', 'changefreq' => 'daily'],
            'contact' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'faq' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'testimonials' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'gallery' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'careers' => ['priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        $urls = [];
        foreach ($pages as $path => $meta) {
            $hreflangPaths = $this->staticHreflangPaths($path);
            $urls[] = $this->urlEntry(
                url(trim("{$locale}/{$path}", '/')),
                $meta['priority'],
                $meta['changefreq'],
                now(),
                $hreflangPaths
            );
        }

        return $urls;
    }

    private function staticHreflangPaths(string $path): array
    {
        $paths = [];

        foreach ($this->locales as $loc) {
            $paths[$loc] = trim("{$loc}/{$path}", '/');
        }

        return $paths;
    }

    private function destinationUrls(string $locale): array
    {
        return Destination::active()->get()->map(function ($destination) use ($locale) {
            $slug = $destination->getTranslation('slug', $locale);
            if (! $slug) {
                return '';
            }

            return $this->urlEntry(
                url("{$locale}/destinations/{$slug}"),
                '0.8',
                'weekly',
                $destination->updated_at,
                $this->entityHreflangPaths($destination, 'destinations')
            );
        })->filter()->all();
    }

    private function tourUrls(string $locale): array
    {
        return TourismPackage::active()->get()->map(function ($package) use ($locale) {
            $slug = $package->getTranslation('slug', $locale);
            if (! $slug) {
                return [];
            }

            return $this->urlEntry(
                url("{$locale}/tours/{$slug}"),
                '0.8',
                'weekly',
                $package->updated_at,
                $this->entityHreflangPaths($package, 'tours')
            );
        })->filter()->all();
    }

    private function activityUrls(string $locale): array
    {
        return Activity::active()->get()->map(function ($activity) use ($locale) {
            $slug = $activity->getTranslation('slug', $locale);
            if (! $slug) {
                return '';
            }

            return $this->urlEntry(
                url("{$locale}/activities/{$slug}"),
                '0.7',
                'weekly',
                $activity->updated_at,
                $this->entityHreflangPaths($activity, 'activities')
            );
        })->filter()->all();
    }

    private function blogUrls(string $locale): array
    {
        return BlogPost::published()->get()->map(function ($post) use ($locale) {
            $slug = $post->getTranslation('slug', $locale);
            if (! $slug) {
                return '';
            }

            return $this->urlEntry(
                url("{$locale}/blog/{$slug}"),
                '0.7',
                'monthly',
                $post->updated_at,
                $this->entityHreflangPaths($post, 'blog')
            );
        })->filter()->all();
    }

    private function entityHreflangPaths(object $entity, string $segment): array
    {
        $paths = [];

        foreach ($this->locales as $loc) {
            $slug = method_exists($entity, 'getTranslation')
                ? $entity->getTranslation('slug', $loc)
                : null;

            if ($slug) {
                $paths[$loc] = "{$loc}/{$segment}/{$slug}";
            }
        }

        return $paths;
    }

    private function urlEntry(
        string $loc,
        string $priority,
        string $changefreq,
        $lastmod,
        array $hreflangPaths = []
    ): string {
        $xml = '<url>'
            .'<loc>'.e($loc).'</loc>'
            .'<lastmod>'.optional($lastmod)->toAtomString().'</lastmod>'
            .'<changefreq>'.$changefreq.'</changefreq>'
            .'<priority>'.$priority.'</priority>';

        foreach ($hreflangPaths as $lang => $path) {
            $xml .= '<xhtml:link rel="alternate" hreflang="'.e($lang).'" href="'.e(url($path)).'"/>';
        }

        if ($hreflangPaths !== []) {
            $defaultPath = $hreflangPaths['en'] ?? reset($hreflangPaths);
            $xml .= '<xhtml:link rel="alternate" hreflang="x-default" href="'.e(url($defaultPath)).'"/>';
        }

        return $xml.'</url>';
    }

    private function sitemapEntry(string $loc, $lastmod): string
    {
        return '<sitemap>'
            .'<loc>'.e($loc).'</loc>'
            .'<lastmod>'.optional($lastmod)->toAtomString().'</lastmod>'
            .'</sitemap>';
    }

    private function xmlResponse(string $content): Response
    {
        return response($content, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
