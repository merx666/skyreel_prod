@extends('layouts.app')

@section('title', 'Rekomendowani operatorzy dronów w ' . ($location ?? 'Twojej okolicy'))

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-primary">Rekomendowani operatorzy dronów</h1>
            @if($location)
                <p class="text-secondary mt-2">Lokalizacja: {{ $location }}</p>
            @endif
        </div>

        <!-- Wyszukiwarka lokalizacji -->
        <div class="liquid-glass rounded-liquid p-6 mb-8">
            <form action="{{ route('recommendations.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <label for="location" class="block text-sm font-medium text-secondary mb-1">Lokalizacja</label>
                    <input type="text" name="location" id="location" value="{{ $location }}" 
                           placeholder="Wpisz miasto, region lub kraj" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary h-10">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Szukaj
                    </button>
                </div>
            </form>
        </div>

        @if($operators->count() > 0)
            <!-- Siatka operatorów -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($operators as $operator)
                    <div class="liquid-glass rounded-liquid p-6 hover-glow transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <img src="{{ $operator->profile->profile_picture_url ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $operator->name }}" 
                                 class="w-16 h-16 rounded-full object-cover mr-4">
                            <div>
                                <h3 class="text-xl font-semibold text-primary">{{ $operator->name }}</h3>
                                <p class="text-secondary">{{ $operator->profile->location ?? 'Lokalizacja nieznana' }}</p>
                                
                                @if($operator->reviews_count > 0)
                                    <div class="flex items-center mt-1">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= round($operator->reviews_as_reviewee_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-secondary ml-1">({{ $operator->reviews_count }})</span>
                                    </div>
                                @endif
                            </div>
                            
                            @if($operator->profile->is_featured)
                                <span class="ml-auto px-2 py-1 bg-accent/20 text-accent text-xs rounded-full">
                                    Wyróżniony
                                </span>
                            @endif
                        </div>
                        
                        @if($operator->portfolios->isNotEmpty() && $operator->portfolios->first()->mediaItems->isNotEmpty())
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                @foreach($operator->portfolios->first()->mediaItems->take(3) as $mediaItem)
                                    <div class="aspect-w-16 aspect-h-9 rounded-md overflow-hidden">
                                        @if($mediaItem->type === 'image')
                                            <img src="{{ $mediaItem->thumbnail_url ?? $mediaItem->source_url }}" 
                                                 alt="{{ $mediaItem->title }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-black flex items-center justify-center">
                                                <img src="{{ $mediaItem->thumbnail_url }}" 
                                                     alt="{{ $mediaItem->title }}" 
                                                     class="w-full h-full object-cover">
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="flex justify-end">
                            <a href="{{ route('profiles.show', $operator->profile) }}" class="btn-primary-sm">
                                Zobacz profil
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Paginacja -->
            <div class="mt-8">
                {{ $operators->links() }}
            </div>
        @else
            <div class="liquid-glass rounded-liquid p-8 text-center">
                <svg class="w-16 h-16 text-secondary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-primary mb-2">Nie znaleziono operatorów</h3>
                <p class="text-secondary">
                    @if($location)
                        Nie znaleźliśmy operatorów dronów w lokalizacji "{{ $location }}". Spróbuj wyszukać inną lokalizację.
                    @else
                        Wpisz lokalizację, aby znaleźć operatorów dronów w Twojej okolicy.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection