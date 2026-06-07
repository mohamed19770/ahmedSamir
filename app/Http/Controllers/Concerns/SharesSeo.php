<?php

namespace App\Http\Controllers\Concerns;

use App\Helpers\LocaleHelper;
use App\Services\SchemaService;
use App\Services\SeoService;

trait SharesSeo
{
    protected function shareSeo(
        string $pageIdentifier,
        array $overrides = [],
        ?object $entity = null,
        ?array $hreflangUrls = null
    ): void {
        app(SeoService::class)->shareToView($pageIdentifier, $overrides, $entity);

        if ($hreflangUrls !== null) {
            view()->share('hreflangUrls', $hreflangUrls);
        }
    }

    protected function shareEntitySeo(
        string $pageIdentifier,
        string $routeName,
        object $entity,
        array $overrides = [],
        array $schema = [],
        ?array $breadcrumbItems = null
    ): void {
        $locale = app()->getLocale();

        $this->shareSeo(
            $pageIdentifier,
            $overrides,
            $entity,
            LocaleHelper::entityHreflangUrls($routeName, $entity)
        );

        if ($breadcrumbItems) {
            view()->share('breadcrumbItems', $breadcrumbItems);
        }

        if ($schemas = array_values(array_filter($schema))) {
            $existing = view()->shared('pageSchemas', []);
            view()->share('pageSchemas', array_values(array_filter([...$existing, ...$schemas])));
        }
    }

    protected function shareSchemas(?array ...$schemas): void
    {
        $existing = view()->shared('pageSchemas', []);
        $incoming = array_values(array_filter($schemas));
        view()->share('pageSchemas', array_values(array_filter([...$existing, ...$incoming])));
    }

    protected function shareBreadcrumbs(array $items): void
    {
        $this->shareSchemas(app(SchemaService::class)->breadcrumbList($items));
        view()->share('breadcrumbItems', $items);
    }
}
