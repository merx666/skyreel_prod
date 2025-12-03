@extends('layouts.app')

@section('title', 'Edytuj Portfolio')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="{{ route('portfolios.show', $portfolio) }}" 
                       class="text-secondary hover:text-accent transition-colors mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-primary">Edytuj Portfolio</h1>
                </div>
                <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" 
                      onsubmit="return confirm('Czy na pewno chcesz usunąć to portfolio?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
            <p class="text-secondary">Edytuj informacje o portfolio i zarządzaj mediami</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Portfolio Info -->
            <div class="liquid-glass rounded-liquid p-6">
                <h2 class="text-xl font-semibold text-primary mb-6">Informacje o Portfolio</h2>
                
                <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-primary mb-2">
                            Tytuł Portfolio *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $portfolio->title) }}"
                               class="input-field w-full @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-primary mb-2">
                            Opis Portfolio *
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="input-field w-full @error('description') border-red-500 @enderror"
                                  required>{{ old('description', $portfolio->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Zaktualizuj Portfolio
                    </button>
                </form>
            </div>

            <!-- Add Media -->
            <div class="liquid-glass rounded-liquid p-6">
                <h2 class="text-xl font-semibold text-primary mb-6">Dodaj Media</h2>
                
                <form action="{{ route('portfolios.media.add', $portfolio) }}" method="POST" class="space-y-6" id="addMediaForm">
                    @csrf

                    <!-- Media Type -->
                    <div>
                        <label class="block text-sm font-medium text-primary mb-2">Typ Media *</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-3 border border-border rounded-lg cursor-pointer hover:bg-surface/50 transition-colors">
                                <input type="radio" name="type" value="video" class="mr-3" required>
                                <div>
                                    <div class="font-medium text-primary">Wideo</div>
                                    <div class="text-sm text-secondary">YouTube</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-border rounded-lg cursor-pointer hover:bg-surface/50 transition-colors">
                                <input type="radio" name="type" value="image" class="mr-3" required>
                                <div>
                                    <div class="font-medium text-primary">Zdjęcie</div>
                                    <div class="text-sm text-secondary">URL obrazu</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Source URL -->
                    <div>
                        <label for="source_url" class="block text-sm font-medium text-primary mb-2">
                            URL *
                        </label>
                        <input type="url" 
                               id="source_url" 
                               name="source_url" 
                               class="input-field w-full"
                               placeholder="https://www.youtube.com/watch?v=... lub https://example.com/image.jpg"
                               required>
                        <p class="text-sm text-secondary mt-1">
                            Dla wideo: link do YouTube. Dla zdjęć: bezpośredni link do obrazu.
                        </p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="media_title" class="block text-sm font-medium text-primary mb-2">
                            Tytuł (opcjonalny)
                        </label>
                        <input type="text" 
                               id="media_title" 
                               name="title" 
                               class="input-field w-full"
                               placeholder="Zostanie automatycznie pobrane dla YouTube">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="media_description" class="block text-sm font-medium text-primary mb-2">
                            Opis (opcjonalny)
                        </label>
                        <textarea id="media_description" 
                                  name="description" 
                                  rows="2"
                                  class="input-field w-full"
                                  placeholder="Krótki opis media"></textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Dodaj Media
                    </button>
                </form>
            </div>
        </div>

        <!-- Media Gallery -->
        @if($portfolio->mediaItems->count() > 0)
            <div class="mt-8">
                <div class="liquid-glass rounded-liquid p-6">
                    <h2 class="text-xl font-semibold text-primary mb-6">Media w Portfolio</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($portfolio->mediaItems as $media)
                            <div class="relative group">
                                <div class="aspect-video rounded-lg overflow-hidden bg-surface">
                                    @if($media->type === 'video')
                                        <img src="{{ $media->thumbnail_url }}" 
                                             alt="{{ $media->title }}"
                                             class="w-full h-full object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ $media->source_url }}" 
                                             alt="{{ $media->title }}"
                                             class="w-full h-full object-cover">
                                    @endif
                                </div>
                                
                                <!-- Media Info -->
                                <div class="mt-2">
                                    @if($media->title)
                                        <h4 class="font-medium text-primary text-sm truncate">{{ $media->title }}</h4>
                                    @endif
                                    @if($media->description)
                                        <p class="text-secondary text-xs mt-1 line-clamp-2">{{ $media->description }}</p>
                                    @endif
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('portfolios.media.remove', [$portfolio, $media]) }}" 
                                      method="POST" 
                                      class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                      onsubmit="return confirm('Czy na pewno chcesz usunąć to media?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection