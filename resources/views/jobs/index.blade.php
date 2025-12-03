@extends('layouts.app')

@section('title', 'Przeglądaj Zlecenia')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary">Przeglądaj Zlecenia</h1>
                <p class="text-secondary mt-2">Znajdź idealne projekty dla swoich umiejętności</p>
            </div>
            
            @auth
                @if(auth()->user()->isClient())
                    <a href="{{ route('jobs.create') }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Dodaj Zlecenie
                    </a>
                @endif
            @endauth
        </div>

        <!-- Filters -->
        <div class="liquid-glass rounded-liquid p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-primary mb-2">Szukaj</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Tytuł lub opis..."
                           class="input-field">
                </div>
                
                <div>
                    <label for="location" class="block text-sm font-medium text-primary mb-2">Lokalizacja</label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ request('location') }}"
                           placeholder="Miasto, region..."
                           class="input-field">
                </div>
                
                <div>
                    <label for="budget_min" class="block text-sm font-medium text-primary mb-2">Budżet min.</label>
                    <input type="number" 
                           id="budget_min" 
                           name="budget_min" 
                           value="{{ request('budget_min') }}"
                           placeholder="0"
                           class="input-field">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Szukaj
                    </button>
                </div>
            </form>
        </div>

        @if($jobs->count() > 0)
            <!-- Jobs Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                @foreach($jobs as $job)
                    <div class="liquid-glass rounded-liquid p-6 hover-glow transition-all duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-primary mb-2">
                                    <a href="{{ route('jobs.show', $job) }}" class="hover:text-accent transition-colors">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center text-sm text-secondary mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $job->location }}
                                </div>
                                <div class="flex items-center text-sm text-secondary">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $job->client->name }}
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-2xl font-bold text-accent mb-1">
                                    {{ number_format($job->budget, 0, ',', ' ') }} zł
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $job->status_color }} bg-surface/50">
                                    {{ $job->status_label }}
                                </span>
                            </div>
                        </div>
                        
                        <p class="text-secondary mb-4 line-clamp-3">{{ $job->description }}</p>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-sm text-secondary">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $job->created_at->diffForHumans() }}
                            </div>
                            
                            <div class="flex items-center text-sm text-secondary">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ $job->proposals->count() }} {{ $job->proposals->count() === 1 ? 'oferta' : 'ofert' }}
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-border">
                            <a href="{{ route('jobs.show', $job) }}" class="btn-secondary w-full text-center">
                                Zobacz Szczegóły
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $jobs->withQueryString()->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="liquid-glass rounded-liquid p-8 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-secondary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-primary mb-2">Brak zleceń</h3>
                    <p class="text-secondary mb-6">
                        @if(request()->hasAny(['search', 'location', 'budget_min']))
                            Nie znaleziono zleceń spełniających kryteria wyszukiwania.
                        @else
                            Obecnie nie ma dostępnych zleceń.
                        @endif
                    </p>
                    
                    @if(request()->hasAny(['search', 'location', 'budget_min']))
                        <a href="{{ route('jobs.index') }}" class="btn-secondary">
                            Wyczyść Filtry
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection