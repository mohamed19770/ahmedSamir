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
        $this->seedAdminUser();
        $this->seedSeoSettings();
    }

    private function seedAdminUser(): void
    {
        if (app()->environment('production') && ! env('ADMIN_SEED_PASSWORD')) {
            $this->command?->warn('Skipped admin user seed in production. Set ADMIN_SEED_PASSWORD to create one.');

            return;
        }

        $password = env('ADMIN_SEED_PASSWORD', 'password');

        if (app()->environment('production') && strlen($password) < 12) {
            $this->command?->error('ADMIN_SEED_PASSWORD must be at least 12 characters in production.');

            return;
        }

        User::firstOrCreate(
            ['email' => env('ADMIN_SEED_EMAIL', 'admin@designation2go.com')],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
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
