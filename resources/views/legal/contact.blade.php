@extends('layouts.app')

@section('title', __('Contact'))

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass rounded-2xl p-8 mb-8">
            <h1 class="text-4xl font-bold text-white mb-6">{{ __('Contact') }}</h1>
            <p class="text-gray-300 text-lg">{{ __('Get in touch with the SkyReel team') }}</p>
        </div>

        <div class="liquid-glass rounded-2xl p-8 space-y-8">
            <!-- Contact Information -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-6">{{ __('Contact Information') }}</h2>
                
                <!-- Email -->
                <div class="mb-8">
                    <h3 class="text-xl font-medium text-blue-400 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('Email') }}
                    </h3>
                    <p class="text-gray-300 leading-relaxed">
                        {{ __('For general inquiries, support, and business matters:') }}
                    </p>
                    <a href="mailto:skyreel.art@gmail.com" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 text-lg font-medium">
                        skyreel.art@gmail.com
                    </a>
                </div>

                <!-- Phone -->
                <div class="mb-8">
                    <h3 class="text-xl font-medium text-blue-400 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ __('Phone') }}
                    </h3>
                    <p class="text-gray-300 leading-relaxed mb-2">
                        {{ __('For urgent matters (SMS preferred):') }}
                    </p>
                    <a href="tel:+48608892151" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 text-lg font-medium">
                        +48 608 892 151
                    </a>
                    <p class="text-yellow-400 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('SMS messages preferred') }}
                    </p>
                </div>

                <!-- Social Media -->
                <div class="mb-8">
                    <h3 class="text-xl font-medium text-blue-400 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                        </svg>
                        {{ __('Social Media') }}
                    </h3>
                    <p class="text-gray-300 leading-relaxed mb-4">
                        {{ __('Follow us on TikTok for the latest drone footage and updates:') }}
                    </p>
                    <a href="https://www.tiktok.com/@skyreel_art" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors duration-200 text-lg font-medium">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-.88-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                        </svg>
                        @skyreel_art
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </section>

            <!-- Response Time -->
            <section class="border-t border-gray-700 pt-8">
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('Response Time') }}</h2>
                <div class="bg-gray-800/50 rounded-lg p-6">
                    <p class="text-gray-300 leading-relaxed mb-4">
                        {{ __('We strive to respond to all inquiries as quickly as possible:') }}
                    </p>
                    <ul class="list-disc list-inside text-gray-300 space-y-2">
                        <li>{{ __('Email inquiries: Within 24-48 hours') }}</li>
                        <li>{{ __('SMS messages: Within a few hours during business hours') }}</li>
                        <li>{{ __('Social media messages: Within 24 hours') }}</li>
                    </ul>
                </div>
            </section>

            <!-- Business Hours -->
            <section class="border-t border-gray-700 pt-8">
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('Business Hours') }}</h2>
                <div class="bg-gray-800/50 rounded-lg p-6">
                    <p class="text-gray-300 leading-relaxed">
                        {{ __('Monday - Friday: 9:00 AM - 6:00 PM (CET)') }}<br>
                        {{ __('Saturday - Sunday: Limited availability') }}
                    </p>
                    <p class="text-yellow-400 text-sm mt-4">
                        {{ __('For urgent matters outside business hours, please send an SMS.') }}
                    </p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection