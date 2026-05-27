@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('locales.rtl', []));
@endphp

<footer class="bg-gray-900 text-white pt-20 pb-8">
    <!-- Top Wave -->
    <div class="relative -mt-20">
        <svg class="w-full h-20 text-gray-900" viewBox="0 0 1440 80" fill="currentColor" preserveAspectRatio="none">
            <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,50 1440,40 L1440,80 L0,80 Z"/>
        </svg>
    </div>

    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Brand -->
            <div class="lg:col-span-1">
                <a href="{{ route('home', $locale) }}" class="inline-block mb-6">
                    <span class="text-xl font-bold text-white">Designation</span>
                    <span class="text-xl font-light text-primary-400"> 2 Go</span>
                </a>
                <p class="text-gray-400 mb-6 leading-relaxed">{{ __('general.tagline') }}</p>
                <div class="flex gap-3">
                    <a href="#" class="social-icon" aria-label="Facebook"><x-icon name="facebook" /></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><x-icon name="instagram" /></a>
                    <a href="#" class="social-icon" aria-label="Twitter"><x-icon name="twitter" /></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6">{{ __('general.packages') }}</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('packages.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.packages') }}</a></li>
                    <li><a href="{{ route('activities.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.activities') }}</a></li>
                    <li><a href="{{ route('hotels.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.hotels') }}</a></li>
                    <li><a href="{{ route('transport.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.transportation') }}</a></li>
                    <li><a href="{{ route('visa.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.visa') }}</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div>
                <h4 class="text-lg font-semibold mb-6">{{ __('general.about') }}</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('about', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.about') }}</a></li>
                    <li><a href="{{ route('blog.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.blog') }}</a></li>
                    <li><a href="{{ route('testimonials.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.testimonials') }}</a></li>
                    <li><a href="{{ route('careers.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.careers') }}</a></li>
                    <li><a href="{{ route('faq.index', $locale) }}" class="text-gray-400 hover:text-primary-400 transition-colors">{{ __('general.faq') }}</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-lg font-semibold mb-6">{{ __('general.contact') }}</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <x-icon name="map-pin" class="w-4 h-4 text-primary-400 shrink-0 icon-lift" />
                        <span class="text-gray-400">123 Travel Street, Tourism City</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icon name="envelope" class="w-4 h-4 text-primary-400 shrink-0 icon-lift" />
                        <a href="mailto:info@designation2go.com" class="text-gray-400 hover:text-primary-400 transition-colors">info@designation2go.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icon name="phone" class="w-4 h-4 text-primary-400 shrink-0 icon-lift" />
                        <a href="tel:+1234567890" class="text-gray-400 hover:text-primary-400 transition-colors">+1 (234) 567-890</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom -->
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-gray-500 text-sm">{{ __('general.copyright', ['year' => date('Y')]) }}</p>
            <div class="flex items-center gap-6">
                <a href="#" class="text-gray-500 hover:text-primary-400 text-sm transition-colors">{{ __('general.privacy_policy') }}</a>
                <a href="#" class="text-gray-500 hover:text-primary-400 text-sm transition-colors">{{ __('general.terms') }}</a>
            </div>
        </div>
    </div>
</footer>
