@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('locales.rtl', []));
@endphp

<header x-data="navbar" :class="scrolled ? 'glass-navbar shadow-md' : 'bg-transparent'" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="container-custom">
        <nav class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('home', $locale) }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:shadow-primary-500/50 transition-shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-bold" :class="scrolled ? 'text-gray-900' : 'text-white'">Designation</span>
                    <span class="text-xl font-light" :class="scrolled ? 'text-primary-600' : 'text-primary-300'"> 2 Go</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => __('general.home')],
                        ['route' => 'about', 'label' => __('general.about')],
                        ['route' => 'packages.index', 'label' => __('general.packages')],
                        ['route' => 'activities.index', 'label' => __('general.activities')],
                        ['route' => 'hotels.index', 'label' => __('general.hotels')],
                        ['route' => 'blog.index', 'label' => __('general.blog')],
                        ['route' => 'contact.index', 'label' => __('general.contact')],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route'], $locale) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:bg-white/10"
                       :class="scrolled ? 'text-gray-700 hover:text-primary-600 hover:bg-primary-50' : 'text-white/90 hover:text-white'">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-3">
                <!-- Language Switcher -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all"
                            :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white/90 hover:bg-white/10'">
                        <span>{{ config('locales.flags.' . $locale) }}</span>
                        <span class="hidden sm:inline">{{ config('locales.names.' . $locale) }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         class="absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 glass rounded-xl shadow-xl overflow-hidden"
                         x-cloak>
                        @foreach(config('locales.supported') as $loc)
                            <a href="{{ url($loc . '/' . ltrim(str_replace(url($locale), '', url()->current()), '/')) }}"
                               class="flex items-center gap-3 px-4 py-3 hover:bg-primary-50 transition-colors {{ $loc === $locale ? 'bg-primary-50 text-primary-700' : 'text-gray-700' }}">
                                <span>{{ config('locales.flags.' . $loc) }}</span>
                                <span class="font-medium">{{ config('locales.names.' . $loc) }}</span>
                                @if($loc === $locale)
                                    <svg class="w-4 h-4 {{ $isRtl ? 'mr-auto' : 'ml-auto' }} text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="{{ route('packages.index', $locale) }}"
                   class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all duration-300">
                    {{ __('general.book_now') }}
                    <svg class="w-4 h-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg transition-colors"
                        :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden glass rounded-2xl mt-2 p-4 shadow-xl" x-cloak>
            <div class="space-y-1">
                @foreach($navItems as $item)
                    <a href="{{ route($item['route'], $locale) }}"
                       class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium transition-colors">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('packages.index', $locale) }}" class="btn-primary w-full text-center">
                    {{ __('general.book_now') }}
                </a>
            </div>
        </div>
    </div>
</header>
