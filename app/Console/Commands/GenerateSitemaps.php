<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSitemaps extends Command
{
    protected $signature = 'sitemap:generate {--static : Write static XML files to public/ (optional for CDN caching)}';

    protected $description = 'Sitemaps are served dynamically at /sitemap.xml. Use --static only when APP_URL is set to production.';

    public function handle(): int
    {
        if (! $this->option('static')) {
            $this->info('Sitemaps are dynamic. Visit /sitemap.xml when the app is running.');
            $this->line('Run with --static to export files to public/ (ensure APP_URL is correct).');

            return self::SUCCESS;
        }

        $controller = app(\App\Http\Controllers\SitemapController::class);
        $public = public_path();

        file_put_contents($public.'/sitemap.xml', $controller->index()->getContent());

        foreach (['en', 'ar', 'hr'] as $locale) {
            file_put_contents(
                $public."/sitemap-{$locale}.xml",
                $controller->locale($locale)->getContent()
            );
        }

        file_put_contents($public.'/ai-sitemap.xml', $controller->ai()->getContent());

        $this->info('Static sitemaps written to public/ using APP_URL='.config('app.url'));

        return self::SUCCESS;
    }
}
