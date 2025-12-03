@extends('layouts.app')

@section('title', $portfolio->title . ' - ' . __('Portfolio') . ' | SkyReel')
@section('description', Str::limit(strip_tags($portfolio->description), 160) . ' ' . __('Portfolio operatora drona') . ' ' . $portfolio->user->name . '.')
@section('keywords', __('portfolio dron, operator drona, filmowanie dronem, fotografia dronem') . ', ' . $portfolio->user->name)

@section('og_title', $portfolio->title . ' - ' . __('Portfolio') . ' | SkyReel')
@section('og_description', Str::limit(strip_tags($portfolio->description), 160))
@section('og_type', 'article')
@if($portfolio->mediaItems->where('type', 'image')->first())
@section('og_image', asset('storage/' . $portfolio->mediaItems->where('type', 'image')->first()->source_url))
@endif
@section('article_published_time', $portfolio->created_at->toISOString())
@section('article_modified_time', $portfolio->updated_at->toISOString())

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CreativeWork",
    "name": "{{ $portfolio->title }}",
    "description": "{{ strip_tags($portfolio->description) }}",
    "creator": {
        "@type": "Person",
        "name": "{{ $portfolio->user->name }}",
        "url": "{{ route('profile.show', $portfolio->user) }}"
    },
    "dateCreated": "{{ $portfolio->created_at->toISOString() }}",
    "dateModified": "{{ $portfolio->updated_at->toISOString() }}",
    "url": "{{ route('portfolios.show', $portfolio) }}",
    "genre": "{{ __('Usługi dronowe') }}",
    "keywords": "{{ __('portfolio dron, operator drona, filmowanie dronem, fotografia dronem') }}"
    @if($portfolio->mediaItems->where('type', 'image')->first())
    ,
    "image": "{{ asset('storage/' . $portfolio->mediaItems->where('type', 'image')->first()->source_url) }}"
    @endif
}
</script>
@endpush

@push('structured-data')
@foreach($portfolio->mediaItems->where('type', 'video') as $video)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoObject",
  "name": "{{ $video->title ?: $portfolio->title }}",
  "description": "{{ strip_tags($video->description ?: $portfolio->description) }}",
  "thumbnailUrl": [
    @if($portfolio->mediaItems->where('type', 'image')->first())
    "{{ asset('storage/' . $portfolio->mediaItems->where('type', 'image')->first()->source_url) }}"
    @else
    "{{ asset('images/logo.png') }}"
    @endif
  ],
  "uploadDate": "{{ $portfolio->created_at->toISOString() }}",
  "contentUrl": "{{ $video->source_url }}",
  "embedUrl": "{{ $video->source_url }}",
  "publisher": {
    "@type": "Organization",
    "name": "Skyreel"
  }
}
</script>
@endforeach
@endpush

@section('content')
<div class="min-h-screen">
    <!-- Portfolio Header -->
    <div class="py-8 border-b border-border">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-4">
                        <img src="{{ $portfolio->user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($portfolio->user->name) }}" 
                             alt="{{ $portfolio->user->name }}"
                             class="w-12 h-12 rounded-full object-cover mr-4"
                             loading="lazy">
                        <div>
                            <h2 class="text-lg font-semibold text-primary">{{ $portfolio->user->name }}</h2>
                            <p class="text-secondary text-sm">{{ $portfolio->user->profile->location ?? 'Lokalizacja nie podana' }}</p>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-primary mb-4">{{ $portfolio->title }}</h1>
                    <p class="text-secondary text-lg leading-relaxed">{{ $portfolio->description }}</p>
                    
                    @if($portfolio->user->profile->bio)
                        <div class="mt-6 p-4 bg-surface/50 rounded-lg">
                            <h3 class="font-medium text-primary mb-2">O operatorze</h3>
                            <p class="text-secondary">{{ $portfolio->user->profile->bio }}</p>
                        </div>
                    @endif
                </div>
                
                @auth
                    @if(auth()->id() === $portfolio->user_id)
                        <div class="ml-6">
                            <a href="{{ route('portfolios.edit', $portfolio) }}" 
                               class="btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edytuj
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    @if($portfolio->mediaItems->count() > 0)
        <!-- Media Gallery - TikTok Style -->
        <div class="snap-container" x-data="{ currentIndex: 0 }">
            @foreach($portfolio->mediaItems as $index => $media)
                <div class="snap-item min-h-screen flex items-center justify-center relative" 
                     x-show="currentIndex === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    
                    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        @if($media->type === 'video')
                            <!-- YouTube Video -->
                            <div class="aspect-video rounded-liquid overflow-hidden liquid-glass">
                                <iframe src="{{ $media->source_url }}" 
                                        class="w-full h-full"
                                        frameborder="0" 
                                        allowfullscreen></iframe>
                            </div>
                        @else
                            <!-- Image -->
                            <div class="flex justify-center">
                                <img src="{{ $media->source_url }}" 
                                     alt="{{ $media->title }}"
                                     class="max-w-full max-h-[70vh] object-contain rounded-liquid"
                                     loading="lazy">
                            </div>
                        @endif
                        
                        <!-- Media Info -->
                        @if($media->title || $media->description)
                            <div class="mt-6 text-center">
                                @if($media->title)
                                    <h3 class="text-xl font-semibold text-primary mb-2">{{ $media->title }}</h3>
                                @endif
                                @if($media->description)
                                    <p class="text-secondary">{{ $media->description }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Arrows -->
                    @if($portfolio->mediaItems->count() > 1)
                        <div class="absolute inset-y-0 left-4 flex items-center">
                            <button @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : {{ $portfolio->mediaItems->count() - 1 }}"
                                    class="w-12 h-12 bg-black/20 hover:bg-black/40 text-white rounded-full flex items-center justify-center transition-colors backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="absolute inset-y-0 right-4 flex items-center">
                            <button @click="currentIndex = currentIndex < {{ $portfolio->mediaItems->count() - 1 }} ? currentIndex + 1 : 0"
                                    class="w-12 h-12 bg-black/20 hover:bg-black/40 text-white rounded-full flex items-center justify-center transition-colors backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Dots Indicator -->
            @if($portfolio->mediaItems->count() > 1)
                <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-10">
                    <div class="flex space-x-2 bg-black/20 backdrop-blur-sm rounded-full px-4 py-2">
                        @foreach($portfolio->mediaItems as $index => $media)
                            <button @click="currentIndex = {{ $index }}"
                                    class="w-2 h-2 rounded-full transition-colors"
                                    :class="currentIndex === {{ $index }} ? 'bg-white' : 'bg-white/50'"></button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Keyboard Navigation -->
            <div x-init="
                $el.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        currentIndex = currentIndex > 0 ? currentIndex - 1 : {{ $portfolio->mediaItems->count() - 1 }};
                    } else if (e.key === 'ArrowRight') {
                        currentIndex = currentIndex < {{ $portfolio->mediaItems->count() - 1 }} ? currentIndex + 1 : 0;
                    }
                });
                $el.focus();
            " tabindex="0" class="outline-none"></div>
        </div>
    @else
        <!-- Empty State -->
        <div class="py-16">
            <div class="max-w-md mx-auto text-center">
                <div class="liquid-glass rounded-liquid p-8">
                    <svg class="w-16 h-16 text-secondary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-primary mb-2">Brak mediów</h3>
                    <p class="text-secondary">To portfolio nie zawiera jeszcze żadnych zdjęć ani filmów.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Contact Section -->
    @auth
        @if(auth()->id() !== $portfolio->user_id && auth()->user()->isClient())
            <div class="border-t border-border py-8">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h3 class="text-xl font-semibold text-primary mb-4">Zainteresowany współpracą?</h3>
                    <p class="text-secondary mb-6">Skontaktuj się z {{ $portfolio->user->name }}, aby omówić szczegóły projektu.</p>
                    <a href="#" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Wyślij Wiadomość
                    </a>
                </div>
            </div>
        @endif
    @else
        <div class="border-t border-border py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-xl font-semibold text-primary mb-4">Zainteresowany współpracą?</h3>
                <p class="text-secondary mb-6">Zaloguj się, aby skontaktować się z operatorem.</p>
                <a href="{{ route('login') }}" class="btn-primary">
                    Zaloguj się
                </a>
            </div>
        </div>
    @endauth
</div>
@endsection