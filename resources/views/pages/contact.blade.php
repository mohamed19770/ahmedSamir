@extends('layouts.app')

@section('meta_title', __('general.contact') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/90 to-dark-900/95"></div>
    <div class="container-custom relative z-10">
        <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.contact') }}</span>
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">{{ __('general.contact') }}</h1>
        <p class="text-xl text-white/70 max-w-2xl">We'd love to hear from you. Get in touch with our team.</p>
    </div>
</section>

<!-- Contact Content -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div class="card-glass p-6">
                    <x-icon-box name="map-pin" size="md" variant="glass" class="mb-4" />
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Visit Us</h3>
                    <p class="text-gray-500">123 Travel Street, Tourism City, TC 12345</p>
                </div>

                <div class="card-glass p-6">
                    <x-icon-box name="envelope" size="md" variant="glass" class="mb-4" />
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Email Us</h3>
                    <a href="mailto:info@designation2go.com" class="text-primary-600 hover:text-primary-700">info@designation2go.com</a>
                </div>

                <div class="card-glass p-6">
                    <x-icon-box name="phone" size="md" variant="glass" class="mb-4" />
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Call Us</h3>
                    <a href="tel:+1234567890" class="text-primary-600 hover:text-primary-700">+1 (234) 567-890</a>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="card-glass p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.send_message') }}</h2>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store', $locale) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Name *</label>
                                <input type="text" name="name" required value="{{ old('name') }}" class="input-luxury">
                                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" required value="{{ old('email') }}" class="input-luxury">
                                @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="input-luxury">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                                <select name="type" class="input-luxury">
                                    <option value="general">General Inquiry</option>
                                    <option value="booking">Booking</option>
                                    <option value="visa">Visa Services</option>
                                    <option value="transport">Transportation</option>
                                    <option value="custom">Custom Package</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="input-luxury">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                            <textarea name="message" rows="5" required class="input-luxury resize-none">{{ old('message') }}</textarea>
                            @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn-primary text-lg px-10 py-4">
                            {{ __('general.send_message') }}
                            <x-icon name="send" class="w-4 h-4 {{ $isRtl ? 'mr-1.5' : 'ml-1.5' }}" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
