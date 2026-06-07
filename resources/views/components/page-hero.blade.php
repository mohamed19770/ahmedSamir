@props(['title', 'subtitle' => null, 'badge' => null])

<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 via-primary-800 to-dark-900 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 {{ in_array(app()->getLocale(), config('locales.rtl', [])) ? 'left-0' : 'right-0' }} w-96 h-96 bg-primary-400 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 {{ in_array(app()->getLocale(), config('locales.rtl', [])) ? 'right-0' : 'left-0' }} w-80 h-80 bg-secondary-400 rounded-full blur-3xl"></div>
    </div>
    <div class="container-custom relative z-10">
        <div class="max-w-3xl">
            @if($badge)
                <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ $badge }}</span>
            @endif
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-xl text-white/70">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
