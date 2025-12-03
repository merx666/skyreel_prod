@extends('layouts.app')

@section('title', 'Edytuj Zlecenie')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('jobs.show', $job) }}" class="text-accent hover:text-accent/80 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-primary">Edytuj Zlecenie</h1>
                    <p class="text-secondary mt-2">Zaktualizuj szczegóły swojego projektu</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="liquid-glass rounded-liquid p-8">
            <form action="{{ route('jobs.update', $job) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-primary mb-2">
                        Tytuł zlecenia *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $job->title) }}"
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
                              required>{{ old('description', $job->description) }}</textarea>
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
                           value="{{ old('location', $job->location) }}"
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
                               value="{{ old('budget', $job->budget) }}"
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
                </div>

                <!-- Status (only if job has proposals) -->
                @if($job->proposals->count() > 0)
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-primary mb-2">
                            Status zlecenia
                        </label>
                        <select id="status" 
                                name="status" 
                                class="input-field @error('status') border-red-500 @enderror">
                            <option value="open" {{ old('status', $job->status) === 'open' ? 'selected' : '' }}>
                                Otwarte
                            </option>
                            <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>
                                Zamknięte
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-secondary text-sm mt-1">
                            Zamknięcie zlecenia uniemożliwi składanie nowych ofert.
                        </p>
                    </div>
                @endif

                <!-- Warning if job has proposals -->
                @if($job->proposals->count() > 0)
                    <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div class="text-sm">
                                <p class="text-yellow-400 font-medium mb-1">Uwaga!</p>
                                <p class="text-yellow-300">
                                    To zlecenie ma już {{ $job->proposals->count() }} {{ $job->proposals->count() == 1 ? 'ofertę' : 'ofert' }}. 
                                    Znaczące zmiany mogą wpłynąć na złożone propozycje.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="{{ route('jobs.show', $job) }}" class="btn-secondary flex-1 text-center">
                        Anuluj
                    </a>
                    <button type="submit" class="btn-primary flex-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </div>

        <!-- Proposals Summary -->
        @if($job->proposals->count() > 0)
            <div class="mt-8">
                <div class="liquid-glass rounded-liquid p-6">
                    <h3 class="text-lg font-semibold text-primary mb-4">
                        Aktualne oferty ({{ $job->proposals->count() }})
                    </h3>
                    <div class="space-y-3">
                        @foreach($job->proposals as $proposal)
                            <div class="flex items-center justify-between p-3 bg-surface/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-accent/20 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-primary font-medium">{{ $proposal->operator->name }}</p>
                                        <p class="text-secondary text-sm">{{ $proposal->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-accent font-bold">{{ number_format($proposal->proposed_fee, 0, ',', ' ') }} PLN</p>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $proposal->statusColor }}">
                                        {{ $proposal->statusLabel }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection