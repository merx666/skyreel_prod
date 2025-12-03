@extends('layouts.app')

@section('title', 'Dodaj Nowe Zlecenie')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-primary">Dodaj Nowe Zlecenie</h1>
            <p class="text-secondary mt-2">Opisz swój projekt i znajdź idealnego operatora drona</p>
        </div>

        <!-- Form -->
        <div class="liquid-glass rounded-liquid p-8">
            <form action="{{ route('jobs.store') }}" method="POST">
                @csrf
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-primary mb-2">
                        Tytuł zlecenia *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           placeholder="np. Nagranie z lotu ptaka na wesele"
                           class="input-field @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-primary mb-2">
                        Opis projektu *
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="6"
                              placeholder="Opisz szczegółowo czego potrzebujesz: rodzaj nagrania, lokalizacja, data, specjalne wymagania..."
                              class="input-field @error('description') border-red-500 @enderror"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-primary mb-2">
                        Lokalizacja *
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location') }}"
                           placeholder="np. Warszawa, Kraków, lub konkretny adres"
                           class="input-field @error('location') border-red-500 @enderror"
                           required>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div class="mb-6">
                    <label for="budget" class="block text-sm font-medium text-primary mb-2">
                        Budżet (PLN) *
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="budget" 
                               name="budget" 
                               value="{{ old('budget') }}"
                               placeholder="1000"
                               min="0"
                               step="50"
                               class="input-field pr-12 @error('budget') border-red-500 @enderror"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-secondary text-sm">PLN</span>
                        </div>
                    </div>
                    @error('budget')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-secondary text-sm mt-1">
                        Podaj orientacyjny budżet. Operatorzy będą mogli złożyć swoje oferty.
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-accent/10 border border-accent/20 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-accent mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm">
                            <p class="text-primary font-medium mb-1">Wskazówki dla lepszego zlecenia:</p>
                            <ul class="text-secondary space-y-1">
                                <li>• Opisz dokładnie czego potrzebujesz</li>
                                <li>• Podaj preferowaną datę realizacji</li>
                                <li>• Wspomniej o specjalnych wymaganiach (pozwolenia, ubezpieczenie)</li>
                                <li>• Załącz referencyjne zdjęcia lub filmy jeśli masz</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="{{ route('dashboard') }}" class="btn-secondary flex-1 text-center">
                        Anuluj
                    </a>
                    <button type="submit" class="btn-primary flex-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Opublikuj Zlecenie
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-secondary text-sm">
                Po opublikowaniu zlecenia, operatorzy będą mogli składać swoje oferty. 
                Otrzymasz powiadomienia o nowych propozycjach.
            </p>
        </div>
    </div>
</div>
@endsection