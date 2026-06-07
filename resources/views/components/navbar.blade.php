@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('locales.rtl', []));
    $overlayMode = request()->routeIs('home');

    $navItems = [
        ['route' => 'home', 'match' => 'home', 'label' => __('general.home')],
        ['route' => 'destinations.index', 'match' => 'destinations.*', 'label' => __('general.destinations')],
        ['route' => 'tours.index', 'match' => ['tours.*', 'packages.*'], 'label' => __('general.tours')],
        ['route' => 'about', 'match' => 'about', 'label' => __('general.about')],
        ['route' => 'activities.index', 'match' => 'activities.*', 'label' => __('general.activities')],
        ['route' => 'blog.index', 'match' => 'blog.*', 'label' => __('general.blog')],
        ['route' => 'contact.index', 'match' => 'contact.*', 'label' => __('general.contact')],
    ];

    $isNavActive = function (array $item): bool {
        $patterns = (array) ($item['match'] ?? $item['route']);

        foreach ($patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return true;
            }
        }

        return false;
    };
@endphp

<header
    x-data="navbar"
    data-overlay="{{ $overlayMode ? 'true' : 'false' }}"
    :class="isSolid() ? 'glass-navbar' : 'navbar-overlay'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="container-custom">
        <nav class="flex items-center justify-between h-20" aria-label="{{ __('general.menu') }}">
            <a href="{{ route('home', $locale) }}" class="group shrink-0">
                <span class="text-xl font-bold transition-colors" :class="isSolid() ? 'text-gray-900' : 'text-white'">Destination</span>
                <span class="text-xl font-light transition-colors" :class="isSolid() ? 'text-primary-600' : 'text-primary-300'">2Go</span>
            </a>

            <div class="hidden lg:flex items-center gap-1">
                @foreach($navItems as $item)
                    @php $active = $isNavActive($item); @endphp
                    <a
                        href="{{ route($item['route'], $locale) }}"
                        class="navbar-link"
                        :class="isSolid()
                            ? '{{ $active ? 'navbar-link-solid-active' : 'navbar-link-solid' }}'
                            : '{{ $active ? 'navbar-link-overlay-active' : 'navbar-link-overlay' }}'"
                        @if($active) aria-current="page" @endif
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <div x-data="{ open: false }" class="relative">
                    <button
                        type="button"
                        @click="open = !open"
                        @click.away="open = false"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all"
                        :class="isSolid() ? 'text-gray-700 hover:bg-gray-100' : 'text-white/90 hover:bg-white/10'"
                        aria-haspopup="true"
                        :aria-expanded="open"
                    >
                        <span>{{ config('locales.flags.' . $locale) }}</span>
                        <span class="hidden sm:inline">{{ config('locales.names.' . $locale) }}</span>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 transition-transform icon-lift" x-bind:class="open && 'rotate-180'" />
                    </button>
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden"
                        x-cloak
                    >
                        @foreach(config('locales.supported') as $loc)
                            <a
                                href="{{ \App\Helpers\LocaleHelper::localizedUrl($loc) }}"
                                class="flex items-center gap-3 px-4 py-3 hover:bg-primary-50 transition-colors {{ $loc === $locale ? 'bg-primary-50 text-primary-700' : 'text-gray-700' }}"
                            >
                                <span>{{ config('locales.flags.' . $loc) }}</span>
                                <span class="font-medium">{{ config('locales.names.' . $loc) }}</span>
                                @if($loc === $locale)
                                    <x-icon name="check" class="w-3.5 h-3.5 {{ $isRtl ? 'mr-auto' : 'ml-auto' }} text-primary-600" />
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <a
                    href="{{ route('tours.index', $locale) }}"
                    class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-primary-500/25 hover:from-primary-700 hover:to-primary-800 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300"
                >
                    {{ __('general.book_now') }}
                    <x-icon name="{{ $isRtl ? 'arrow-left' : 'arrow-right' }}" class="w-3.5 h-3.5" />
                </a>

                <button
                    type="button"
                    @click="mobileOpen = !mobileOpen"
                    class="lg:hidden p-2 rounded-lg transition-colors"
                    :class="isSolid() ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                    :aria-label="mobileOpen ? '{{ __('general.close') }}' : '{{ __('general.menu') }}'"
                >
                    <x-icon x-show="!mobileOpen" name="menu" class="w-5 h-5" />
                    <x-icon x-show="mobileOpen" name="x" class="w-5 h-5" x-cloak />
                </button>
            </div>
        </nav>

        <div
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="lg:hidden bg-white rounded-2xl mt-1 mb-3 p-4 shadow-xl border border-gray-100"
            x-cloak
        >
            <div class="space-y-1">
                @foreach($navItems as $item)
                    @php $active = $isNavActive($item); @endphp
                    <a
                        href="{{ route($item['route'], $locale) }}"
                        @click="mobileOpen = false"
                        class="block px-4 py-3 rounded-xl font-medium transition-colors {{ $active ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}"
                        @if($active) aria-current="page" @endif
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('tours.index', $locale) }}" class="btn-primary w-full text-center" @click="mobileOpen = false">
                    {{ __('general.book_now') }}
                </a>
            </div>
        </div>
    </div>
</header>
