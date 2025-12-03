@extends('layouts.app')

@section('title', __('Wyszukiwanie'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-6">{{ __('Wyszukiwanie') }}</h1>
            
            <!-- Search Form -->
            <div class="liquid-glass p-6 rounded-2xl">
                <form method="GET" action="{{ route('search.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search Query -->
                        <div>
                            <label for="q" class="block text-sm font-medium text-gray-300 mb-2">{{ __('Szukaj') }}</label>
                            <input type="text" 
                                   name="q" 
                                   id="q"
                                   value="{{ $query }}" 
                                   placeholder="{{ __('Wpisz słowa kluczowe...') }}"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-300 mb-2">{{ __('Typ') }}</label>
                            <select name="type" 
                                    id="type"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="all" {{ $type === 'all' ? 'selected' : '' }}>{{ __('Wszystko') }}</option>
                                <option value="operators" {{ $type === 'operators' ? 'selected' : '' }}>{{ __('Operatorzy') }}</option>
                                <option value="jobs" {{ $type === 'jobs' ? 'selected' : '' }}>{{ __('Zlecenia') }}</option>
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-300 mb-2">{{ __('Lokalizacja') }}</label>
                            <input type="text" 
                                   name="location" 
                                   id="location"
                                   value="{{ $location }}" 
                                   placeholder="{{ __('Miasto, region...') }}"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Search Button -->
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors">
                                {{ __('Szukaj') }}
                            </button>
                        </div>
                    </div>

                    <!-- Budget Filters (for jobs) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="document.getElementById('type').value === 'jobs' || document.getElementById('type').value === 'all'">
                        <div>
                            <label for="budget_min" class="block text-sm font-medium text-gray-300 mb-2">{{ __('Budżet od (PLN)') }}</label>
                            <input type="number" 
                                   name="budget_min" 
                                   id="budget_min"
                                   value="{{ $budget_min }}" 
                                   placeholder="0"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="budget_max" class="block text-sm font-medium text-gray-300 mb-2">{{ __('Budżet do (PLN)') }}</label>
                            <input type="number" 
                                   name="budget_max" 
                                   id="budget_max"
                                   value="{{ $budget_max }}" 
                                   placeholder="10000"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        @if($query || $location || $budget_min || $budget_max)
            <div class="space-y-8">
                <!-- Operators Results -->
                @if($operators->isNotEmpty() && ($type === 'all' || $type === 'operators'))
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-6">
                            {{ __('Operatorzy') }} ({{ $operators->count() }})
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($operators as $operator)
                                <div class="liquid-glass p-6 rounded-2xl hover:bg-gray-700/40 transition-colors">
                                    <div class="flex items-center space-x-4 mb-4">
                                        @if($operator->profile && $operator->profile->profile_picture_url)
                                            <img src="{{ $operator->profile->profile_picture_url }}" 
                                                 alt="{{ $operator->name }}" 
                                                 class="w-16 h-16 rounded-full object-cover">
                                        @else
                                            <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-medium text-xl">{{ substr($operator->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">{{ $operator->name }}</h3>
                                            @if($operator->profile && $operator->profile->location)
                                                <p class="text-gray-400 text-sm">{{ $operator->profile->location }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($operator->profile && $operator->profile->bio)
                                        <p class="text-gray-300 text-sm mb-4 line-clamp-3">{{ $operator->profile->bio }}</p>
                                    @endif
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $operator->getAverageRating() ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-gray-400 text-sm">({{ $operator->getTotalReviewsCount() }})</span>
                                        </div>
                                        <a href="{{ route('profile.show', $operator) }}" 
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            {{ __('Zobacz profil') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Jobs Results -->
                @if($jobs->isNotEmpty() && ($type === 'all' || $type === 'jobs'))
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-6">
                            {{ __('Zlecenia') }} ({{ $jobs->count() }})
                        </h2>
                        <div class="space-y-4">
                            @foreach($jobs as $job)
                                <div class="liquid-glass p-6 rounded-2xl hover:bg-gray-700/40 transition-colors">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-semibold text-white mb-2">{{ $job->title }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-400 mb-3">
                                                <span>{{ __('Klient:') }} {{ $job->client->name }}</span>
                                                <span>{{ __('Lokalizacja:') }} {{ $job->location }}</span>
                                                <span>{{ __('Budżet:') }} {{ number_format($job->budget, 0, ',', ' ') }} PLN</span>
                                            </div>
                                            <p class="text-gray-300 line-clamp-3">{{ $job->description }}</p>
                                        </div>
                                        <div class="ml-6 flex flex-col items-end space-y-2">
                                            <span class="px-3 py-1 bg-green-600 text-white rounded-full text-xs">
                                                {{ __('Otwarte') }}
                                            </span>
                                            <a href="{{ route('jobs.show', $job->id) }}" 
                                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                                {{ __('Zobacz zlecenie') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ __('Opublikowane:') }} {{ $job->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- No Results -->
                @if($operators->isEmpty() && $jobs->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">{{ __('Brak wyników') }}</h3>
                        <p class="text-gray-400">{{ __('Spróbuj zmienić kryteria wyszukiwania lub użyć innych słów kluczowych.') }}</p>
                    </div>
                @endif
            </div>
        @else
            <!-- Initial State -->
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">{{ __('Zacznij wyszukiwanie') }}</h3>
                <p class="text-gray-400">{{ __('Użyj formularza powyżej, aby znaleźć operatorów dronów lub zlecenia.') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection