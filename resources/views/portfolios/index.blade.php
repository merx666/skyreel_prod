@extends('layouts.app')

@section('title', 'Moje Portfolio')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary">Moje Portfolio</h1>
                <p class="text-secondary mt-2">Zarządzaj swoimi projektami i prezentacjami</p>
            </div>
            <a href="{{ route('portfolios.create') }}" 
               class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nowe Portfolio
            </a>
        </div>

        @if($portfolios->count() > 0)
            <!-- Portfolio Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portfolios as $portfolio)
                    <div class="liquid-glass rounded-liquid p-6 hover-glow transition-all duration-300">
                        <!-- Portfolio Header -->
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-primary truncate">
                                {{ $portfolio->title }}
                            </h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('portfolios.edit', $portfolio) }}" 
                                   class="text-secondary hover:text-accent transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('portfolios.show', $portfolio) }}" 
                                   class="text-secondary hover:text-accent transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Portfolio Description -->
                        <p class="text-secondary text-sm mb-4 line-clamp-3">
                            {{ $portfolio->description }}
                        </p>

                        <!-- Media Preview -->
                        @if($portfolio->mediaItems->count() > 0)
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                @foreach($portfolio->mediaItems->take(4) as $media)
                                    <div class="aspect-square rounded-lg overflow-hidden bg-surface">
                                        @if($media->type === 'video')
                                            <img src="{{ $media->thumbnail_url }}"
                                         alt="{{ $media->title }}"
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                        @else
                                            <img src="{{ $media->source_url }}"
                                                 alt="{{ $media->title }}"
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="aspect-video rounded-lg bg-surface flex items-center justify-center mb-4">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-secondary mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-secondary">Brak mediów</p>
                                </div>
                            </div>
                        @endif

                        <!-- Portfolio Stats -->
                        <div class="flex justify-between items-center text-sm text-secondary">
                            <span>{{ $portfolio->mediaItems->count() }} {{ $portfolio->mediaItems->count() === 1 ? 'element' : 'elementów' }}</span>
                            <span>{{ $portfolio->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $portfolios->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="liquid-glass rounded-liquid p-12 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-secondary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-primary mb-2">Brak portfolio</h3>
                    <p class="text-secondary mb-6">Stwórz swoje pierwsze portfolio, aby zaprezentować swoje prace.</p>
                    <a href="{{ route('portfolios.create') }}" class="btn-primary">
                        Stwórz Portfolio
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection