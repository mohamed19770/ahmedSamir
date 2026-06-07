<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@designation2go.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->seedSeoSettings();
    }

    private function seedSeoSettings(): void
    {
        $pages = ['home', 'about', 'packages', 'tours', 'destinations', 'activities', 'activity', 'hotels', 'blog', 'contact', 'gallery', 'faq', 'visa', 'transportation', 'testimonials', 'careers'];

        foreach ($pages as $page) {
            SeoSetting::firstOrCreate(
                ['page_identifier' => $page],
                [
                    'meta_title' => [
                        'en' => ucfirst($page).' - Destination2Go',
                        'ar' => ucfirst($page).' - Destination2Go',
                        'hr' => ucfirst($page).' - Destination2Go',
                    ],
                    'meta_description' => [
                        'en' => 'Destination2Go — premium travel and tourism services.',
                        'ar' => 'Destination2Go — خدمات سفر وسياحة متميزة.',
                        'hr' => 'Destination2Go — premium turističke usluge.',
                    ],
                    'meta_keywords' => [
                        'en' => config("seo.page_keywords.{$page}.en", config('seo.default_keywords.en')),
                        'ar' => config("seo.page_keywords.{$page}.ar", config('seo.default_keywords.ar')),
                        'hr' => config("seo.page_keywords.{$page}.hr", config('seo.default_keywords.hr')),
                    ],
                ]
            );
        }
    }
}
