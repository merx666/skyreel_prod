@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="liquid-glass rounded-2xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    Witaj, {{ auth()->user()->name }}!
                </h1>
                <p class="text-secondary">
                    @if(auth()->user()->isOperator())
                        Zarządzaj swoim portfolio i znajdź nowe zlecenia
                    @else
                        Znajdź idealnego operatora drona dla swojego projektu
                    @endif
                </p>
            </div>
            <div class="text-right">
                <div class="text-sm text-secondary">Typ konta</div>
                <div class="text-lg font-semibold text-accent">
                    {{ auth()->user()->isOperator() ? 'Operator' : 'Klient' }}
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->isOperator())
        <!-- Operator Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Stats -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="liquid-glass rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold text-accent">{{ auth()->user()->portfolios->count() }}</div>
                        <div class="text-sm text-secondary">Portfolio</div>
                    </div>
                    <div class="liquid-glass rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold text-accent">{{ auth()->user()->jobProposals->count() }}</div>
                        <div class="text-sm text-secondary">Aktywne oferty</div>
                    </div>
                    <div class="liquid-glass rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold text-accent">{{ number_format(auth()->user()->getAverageRating(), 1) }}</div>
                        <div class="text-sm text-secondary">Średnia ocena</div>
                    </div>
                    <div class="liquid-glass rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold text-accent">{{ auth()->user()->getTotalReviewsCount() }}</div>
                        <div class="text-sm text-secondary">Opinie</div>
                    </div>
                </div>
            </div>

            <!-- Portfolio Management -->
            <div class="lg:col-span-2">
                <div class="liquid-glass rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">Twoje Portfolio</h2>
                        <a href="#" class="btn-primary">Dodaj Portfolio</a>
                    </div>
                    
                    @if(auth()->user()->portfolios->count() > 0)
                        <div class="space-y-4">
                            @foreach(auth()->user()->portfolios->take(3) as $portfolio)
                                <div class="flex items-center justify-between p-4 rounded-lg border border-opacity-10" 
                                     :class="{ 'border-light-border': !darkMode, 'border-dark-border': darkMode }">
                                    <div>
                                        <h3 class="font-medium">{{ $portfolio->title }}</h3>
                                        <p class="text-sm text-secondary">{{ $portfolio->mediaItems->count() }} materiałów</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="#" class="text-accent hover:underline text-sm">Edytuj</a>
                                        <a href="#" class="text-accent hover:underline text-sm">Zobacz</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(auth()->user()->portfolios->count() > 3)
                            <div class="mt-4 text-center">
                                <a href="#" class="text-accent hover:underline">Zobacz wszystkie ({{ auth()->user()->portfolios->count() }})</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="text-secondary mb-4">Nie masz jeszcze żadnego portfolio</div>
                            <a href="#" class="btn-primary">Stwórz pierwsze portfolio</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Job Proposals -->
            <div>
                <div class="liquid-glass rounded-2xl p-6">
                    <h2 class="text-xl font-semibold mb-6">Ostatnie oferty</h2>
                    
                    @if(auth()->user()->jobProposals->count() > 0)
                        <div class="space-y-4">
                            @foreach(auth()->user()->jobProposals->take(5) as $proposal)
                                <div class="p-3 rounded-lg border border-opacity-10" 
                                     :class="{ 'border-light-border': !darkMode, 'border-dark-border': darkMode }">
                                    <div class="text-sm font-medium">{{ $proposal->job->title }}</div>
                                    <div class="text-xs text-secondary">{{ $proposal->proposed_fee }} PLN</div>
                                    <div class="text-xs mt-1">
                                        <span class="px-2 py-1 rounded-full text-xs
                                            @if($proposal->status === 'pending') bg-yellow-500 bg-opacity-20 text-yellow-400
                                            @elseif($proposal->status === 'accepted') bg-green-500 bg-opacity-20 text-green-400
                                            @else bg-red-500 bg-opacity-20 text-red-400
                                            @endif">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-secondary text-sm">Brak aktywnych ofert</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    @else
        <!-- Client Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Stats -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="liquid-glass rounded-xl p-6 text-center">
                                <div class="text-2xl font-bold text-accent">{{ auth()->user()->jobs->count() }}</div>
                        <div class="text-sm text-secondary">Opublikowane zlecenia</div>
                    </div>
                    <div class="liquid-glass rounded-xl p-6 text-center">
                                <div class="text-2xl font-bold text-accent">{{ auth()->user()->jobs->where('status', 'completed')->count() }}</div>
                        <div class="text-sm text-secondary">Zakończone projekty</div>
                    </div>
                    <div class="liquid-glass rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold text-accent">{{ auth()->user()->reviewsGiven->count() }}</div>
                        <div class="text-sm text-secondary">Wystawione opinie</div>
                    </div>
                </div>
            </div>

            <!-- Job Listings Management -->
            <div class="lg:col-span-2">
                <div class="liquid-glass rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold">Twoje zlecenia</h2>
                        <a href="#" class="btn-primary">Dodaj zlecenie</a>
                    </div>
                    
                        @if(auth()->user()->jobs->count() > 0)
                        <div class="space-y-4">
                            @foreach(auth()->user()->jobs->take(3) as $job)
                                <div class="p-4 rounded-lg border border-opacity-10" 
                                     :class="{ 'border-light-border': !darkMode, 'border-dark-border': darkMode }">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium">{{ $job->title }}</h3>
                                            <p class="text-sm text-secondary">{{ $job->budget }} PLN • {{ $job->location }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs">
                                                <span class="px-2 py-1 rounded-full text-xs
                                                    @if($job->status === 'open') bg-green-500 bg-opacity-20 text-green-400
                                                    @elseif($job->status === 'in_progress') bg-blue-500 bg-opacity-20 text-blue-400
                                                    @elseif($job->status === 'completed') bg-gray-500 bg-opacity-20 text-gray-400
                                                    @else bg-red-500 bg-opacity-20 text-red-400
                                                    @endif">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-secondary mt-1">{{ $job->proposals->count() }} ofert</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(auth()->user()->jobs->count() > 3)
                            <div class="mt-4 text-center">
                                <a href="#" class="text-accent hover:underline">Zobacz wszystkie ({{ auth()->user()->jobs->count() }})</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="text-secondary mb-4">Nie masz jeszcze żadnych zleceń</div>
                            <a href="#" class="btn-primary">Opublikuj pierwsze zlecenie</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Browse Operators -->
            <div>
                <div class="liquid-glass rounded-2xl p-6">
                    <h2 class="text-xl font-semibold mb-6">Znajdź operatora</h2>
                    
                    <div class="space-y-4">
                        <a href="#" class="block p-3 rounded-lg hover:bg-opacity-10 hover:bg-white transition-colors">
                            <div class="text-sm font-medium">Przeglądaj portfolio</div>
                            <div class="text-xs text-secondary">Zobacz prace operatorów</div>
                        </a>
                        
                        <a href="#" class="block p-3 rounded-lg hover:bg-opacity-10 hover:bg-white transition-colors">
                            <div class="text-sm font-medium">Wyszukaj w okolicy</div>
                            <div class="text-xs text-secondary">Znajdź lokalnych operatorów</div>
                        </a>
                        
                        <a href="#" class="block p-3 rounded-lg hover:bg-opacity-10 hover:bg-white transition-colors">
                            <div class="text-sm font-medium">Najlepiej oceniani</div>
                            <div class="text-xs text-secondary">Sprawdź top operatorów</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection