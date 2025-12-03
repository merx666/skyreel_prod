@extends('layouts.app')

@section('title', 'Odkrywaj Portfolio - Styl TikTok')

@section('content')


<div class="tiktok-view h-screen w-full bg-black overflow-hidden relative" x-data="tiktokNavigation()">
    <div class="snap-y snap-mandatory h-full w-full overflow-y-scroll scroll-smooth" x-ref="container" @scroll.debounce.50ms="handleScroll">
        @foreach($mediaItems as $index => $item)
        <div class="snap-start h-screen w-full flex items-center justify-center relative video-container" data-index="{{ $index }}">
            @if($item->type === 'video')
                <div class="w-full h-full max-w-3xl mx-auto relative">
                    <iframe 
                        class="w-full h-full" 
                        src="{{ str_replace('watch?v=', 'embed/', $item->source_url) }}?autoplay=0&mute=0&loop=1&controls=1&rel=0" 
                        frameborder="0" 
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            @else
                <div class="w-full h-full max-w-3xl mx-auto relative">
                    <img 
                        src="{{ Str::startsWith($item->source_url, ['http://', 'https://']) ? $item->source_url : asset('storage/' . $item->source_url) }}" 
                        alt="{{ $item->title }}" 
                        class="w-full h-full object-contain"
                        loading="lazy"
                    >
                </div>
            @endif
            
            <!-- Informacje o portfolio -->
            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 bg-gradient-to-t from-black/90 via-black/50 to-transparent pointer-events-none">
                <div class="pointer-events-auto max-w-2xl mx-auto">
                    <div class="flex items-end justify-between">
                        <div class="flex-1 mr-4">
                            <div class="flex items-center mb-3">
                                <img 
                                    src="{{ $item->portfolio->user->profile->profile_picture_url ? (Str::startsWith($item->portfolio->user->profile->profile_picture_url, ['http://', 'https://']) ? $item->portfolio->user->profile->profile_picture_url : asset('storage/' . $item->portfolio->user->profile->profile_picture_url)) : asset('images/default-avatar.png') }}" 
                                    alt="{{ $item->portfolio->user->name }}" 
                                    class="w-12 h-12 rounded-full object-cover border-2 border-white/20 mr-3"
                                >
                                <div>
                                    <h3 class="text-white font-bold text-lg leading-tight">{{ $item->portfolio->user->name }}</h3>
                                    <p class="text-gray-300 text-xs flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $item->portfolio->user->profile->location ?? 'Lokalizacja nieznana' }}
                                    </p>
                                </div>
                            </div>
                            
                            <h2 class="text-xl font-bold text-white mb-2">{{ $item->title }}</h2>
                            <p class="text-gray-200 text-sm mb-4 line-clamp-2">{{ $item->description }}</p>
                        </div>
                        
                        <div class="flex flex-col items-center space-y-4 pb-2">
                            <a href="{{ route('portfolios.show', $item->portfolio) }}" class="flex flex-col items-center group">
                                <div class="w-10 h-10 rounded-full bg-gray-800/80 flex items-center justify-center group-hover:bg-amber-500 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                                <span class="text-white text-[10px] mt-1">Profil</span>
                            </a>
                            
                            @auth
                            <button class="flex flex-col items-center group">
                                <div class="w-10 h-10 rounded-full bg-gray-800/80 flex items-center justify-center group-hover:bg-red-500 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                                </div>
                                <span class="text-white text-[10px] mt-1">Lubię to</span>
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="flex flex-col items-center group">
                                <div class="w-10 h-10 rounded-full bg-gray-800/80 flex items-center justify-center group-hover:bg-red-500 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                                </div>
                                <span class="text-white text-[10px] mt-1">Lubię to</span>
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if(($index + 1) % 5 == 0)
        <!-- Ad Slide -->
        <div class="snap-start h-screen w-full flex items-center justify-center relative bg-black" data-index="ad-{{ $index }}">
            <div class="w-full max-w-3xl mx-auto flex flex-col items-center justify-center p-4">
                <p class="text-gray-500 text-sm mb-4">Reklama</p>
                <div class="bg-white/5 p-4 rounded-lg">
                    <div ta-ad-container=""></div>
                </div>
            </div>
        </div>
        @endif

        @endforeach
    </div>
    
    <!-- Przycisk powrotu -->
    <div class="fixed top-4 left-4 z-50">
        <a href="{{ route('home') }}" class="bg-black/40 backdrop-blur-md rounded-full p-3 flex items-center justify-center hover:bg-black/60 transition-colors text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Nawigacja boczna (Desktop) -->
    <div class="hidden md:flex fixed right-8 top-1/2 -translate-y-1/2 z-40 flex-col space-y-4">
        <button @click="prev()" class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center hover:bg-white/20 transition-colors text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
        </button>
        <button @click="next()" class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center hover:bg-white/20 transition-colors text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
    </div>
</div>

<style>
    .tiktok-view {
        position: fixed;
        top: 64px;
        left: 0;
        width: 100vw;
        height: calc(100vh - 64px);
        z-index: 50;
    }
    .snap-y {
        scroll-snap-type: y mandatory;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .snap-y::-webkit-scrollbar {
        display: none;
    }
    .snap-start {
        scroll-snap-align: start;
        scroll-snap-stop: always;
    }
</style>

<script>
    function tiktokNavigation() {
        return {
            currentIndex: 0,
            totalItems: {{ count($mediaItems) + floor(count($mediaItems) / 5) }},
            
            init() {
                // Obsługa klawiatury
                window.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowUp') this.prev();
                    if (e.key === 'ArrowDown') this.next();
                });
            },
            
            handleScroll(e) {
                const container = e.target;
                const index = Math.round(container.scrollTop / container.clientHeight);
                this.currentIndex = index;
            },
            
            next() {
                if (this.currentIndex < this.totalItems - 1) {
                    this.scrollTo(this.currentIndex + 1);
                }
            },
            
            prev() {
                if (this.currentIndex > 0) {
                    this.scrollTo(this.currentIndex - 1);
                }
            },
            
            scrollTo(index) {
                const container = this.$refs.container;
                container.scrollTo({
                    top: index * container.clientHeight,
                    behavior: 'smooth'
                });
            }
        }
    }
</script>
@endsection