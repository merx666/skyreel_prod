@extends('layouts.app')

@section('title', 'Nowe Portfolio')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ url('/portfolios') }}" 
                   class="text-secondary hover:text-accent transition-colors mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-primary">Nowe Portfolio</h1>
            </div>
            <p class="text-secondary">Stwórz nowe portfolio, aby zaprezentować swoje prace</p>
        </div>

        <!-- Form -->
        <div class="liquid-glass rounded-liquid p-8">
            <form action="{{ route('portfolios.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-primary mb-2">
                        Tytuł Portfolio *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="input-field w-full @error('title') border-red-500 @enderror"
                           placeholder="np. Fotografia ślubna, Filmy reklamowe..."
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
                              placeholder="Opisz swoje portfolio, specjalizację i doświadczenie..."
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-accent/10 border border-accent/20 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-accent mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-primary mb-1">Co dalej?</h4>
                            <p class="text-sm text-secondary">
                                Po utworzeniu portfolio będziesz mógł dodać zdjęcia, filmy YouTube i inne materiały prezentujące Twoje prace.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ url('/portfolios') }}" 
                       class="btn-secondary">
                        Anuluj
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Stwórz Portfolio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection