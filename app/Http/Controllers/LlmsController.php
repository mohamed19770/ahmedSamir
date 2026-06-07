<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Destination;
use App\Models\TourismPackage;
use Illuminate\Http\Response;

class LlmsController extends Controller
{
    public function index(): Response
    {
        $site = config('site');
        $locales = config('locales.supported');

        $content = "# {$site['name']}\n\n";
        $content .= "> {$site['tagline']}\n\n";
        $content .= "## About\n\n";
        $content .= "{$site['name']} is a premium travel agency specializing in Saudi Arabia tourism, ";
        $content .= "cultural experiences, luxury tours, and personalized travel services for international visitors.\n\n";
        $content .= "## Contact\n\n";
        $content .= "- Website: https://{$site['domain']}\n";
        $content .= "- Email: {$site['email']}\n";
        $content .= "- Phone: {$site['phone']}\n";
        $content .= "- WhatsApp: {$site['whatsapp']}\n\n";
        $content .= "## Languages\n\n";
        $content .= implode(', ', $locales)."\n\n";
        $content .= "## Key Pages\n\n";

        foreach ($locales as $locale) {
            $content .= "### ".strtoupper($locale)."\n\n";
            $content .= "- Homepage: https://{$site['domain']}/{$locale}\n";
            $content .= "- Destinations: https://{$site['domain']}/{$locale}/destinations\n";
            $content .= "- Tours: https://{$site['domain']}/{$locale}/tours\n";
            $content .= "- Blog: https://{$site['domain']}/{$locale}/blog\n";
            $content .= "- FAQ: https://{$site['domain']}/{$locale}/faq\n";
            $content .= "- Contact: https://{$site['domain']}/{$locale}/contact\n\n";
        }

        $content .= "## Destinations\n\n";
        foreach (Destination::active()->get() as $destination) {
            $content .= "- {$destination->getTranslation('name', 'en')}: ";
            $content .= "https://{$site['domain']}/en/destinations/{$destination->getTranslation('slug', 'en')}\n";
        }

        $content .= "\n## Featured Tours\n\n";
        foreach (TourismPackage::active()->featured()->get() as $package) {
            $content .= "- {$package->getTranslation('title', 'en')}: ";
            $content .= "https://{$site['domain']}/en/tours/{$package->getTranslation('slug', 'en')}\n";
        }

        $content .= "\n## Travel Blog\n\n";
        foreach (BlogPost::published()->take(10)->get() as $post) {
            $content .= "- {$post->getTranslation('title', 'en')}: ";
            $content .= "https://{$site['domain']}/en/blog/{$post->getTranslation('slug', 'en')}\n";
        }

        $content .= "\n## Topics\n\n";
        $content .= "Saudi Arabia tourism, Riyadh travel, Jeddah guide, AlUla heritage, Red Sea tourism, ";
        $content .= "Saudi culture, desert safari, visa information, events and festivals, luxury travel.\n\n";
        $content .= "## AI Sitemap\n\n";
        $content .= "https://{$site['domain']}/ai-sitemap.xml\n";

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
