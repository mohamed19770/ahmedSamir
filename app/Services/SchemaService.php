<?php

namespace App\Services;

use App\Helpers\LocaleHelper;
use Illuminate\Support\Collection;

class SchemaService
{
    public function organization(): array
    {
        $site = config('site');

        return [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'TravelAgency', 'LocalBusiness'],
            '@id' => url('/#organization'),
            'name' => $site['name'],
            'legalName' => $site['legal_name'],
            'url' => url('/'),
            'logo' => asset($site['logo']),
            'image' => asset($site['og_image']),
            'description' => $site['tagline'],
            'email' => $site['email'],
            'telephone' => $site['phone'],
            'foundingDate' => $site['founding_date'],
            'priceRange' => $site['price_range'],
            'openingHours' => $site['opening_hours'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $site['address']['street'],
                'addressLocality' => $site['address']['city'],
                'addressRegion' => $site['address']['region'],
                'postalCode' => $site['address']['postal_code'],
                'addressCountry' => $site['address']['country'],
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $site['geo']['latitude'],
                'longitude' => $site['geo']['longitude'],
            ],
            'sameAs' => array_values(array_filter($site['social'])),
            'areaServed' => collect(config('seo.gulf_countries', []))->map(fn ($names, $code) => [
                '@type' => 'Country',
                'name' => $names['en'] ?? $code,
            ])->values()->all(),
        ];
    }

    public function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'name' => config('site.name'),
            'url' => url('/'),
            'description' => config('site.tagline'),
            'inLanguage' => LocaleHelper::supported(),
            'publisher' => ['@id' => url('/#organization')],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('en/search?q={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function breadcrumbList(array $items): array
    {
        $list = [];

        foreach ($items as $index => $item) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list,
        ];
    }

    public function faqPage(Collection|array $faqs, string $locale): array
    {
        $entities = [];

        foreach ($faqs as $faq) {
            $entities[] = [
                '@type' => 'Question',
                'name' => $faq->getTranslation('question', $locale),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq->getTranslation('answer', $locale)),
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    public function article(object $post, string $locale): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->getTranslation('title', $locale),
            'description' => $post->getTranslation('excerpt', $locale),
            'image' => app(SeoService::class)->resolveImage($post->image ?? null),
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'dateModified' => optional($post->updated_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => config('site.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('site.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(config('site.logo')),
                ],
            ],
        ];
    }

    public function touristAttraction(object $destination, string $locale): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'TouristAttraction',
            'name' => $destination->getTranslation('name', $locale),
            'description' => strip_tags($destination->getTranslation('description', $locale)),
            'image' => $destination->image,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $destination->city,
                'addressCountry' => $destination->country,
            ],
            'geo' => $destination->latitude ? [
                '@type' => 'GeoCoordinates',
                'latitude' => $destination->latitude,
                'longitude' => $destination->longitude,
            ] : null,
        ];
    }

    public function touristTrip(object $package, string $locale): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'TouristTrip',
            'name' => $package->getTranslation('title', $locale),
            'description' => strip_tags($package->getTranslation('short_description', $locale)),
            'image' => $package->image,
            'touristType' => $package->category,
            'offers' => [
                '@type' => 'Offer',
                'price' => $package->sale_price ?? $package->price,
                'priceCurrency' => $package->currency ?? 'USD',
                'availability' => 'https://schema.org/InStock',
            ],
        ];
    }

    public function reviews(Collection|array $testimonials, string $locale): array
    {
        $items = [];

        foreach ($testimonials as $testimonial) {
            $items[] = [
                '@type' => 'Review',
                'author' => [
                    '@type' => 'Person',
                    'name' => $testimonial->name,
                ],
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => $testimonial->rating,
                    'bestRating' => 5,
                ],
                'reviewBody' => $testimonial->getTranslation('content', $locale),
            ];
        }

        return $items;
    }

    public function encode(array ...$graphs): string
    {
        $data = count($graphs) === 1 ? $graphs[0] : ['@context' => 'https://schema.org', '@graph' => $graphs];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
