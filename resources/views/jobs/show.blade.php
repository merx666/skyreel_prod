@extends('layouts.app')

@section('title', $job->title . ' - ' . __('Zlecenie') . ' | SkyReel')
@section('description', Str::limit(strip_tags($job->description), 160) . ' ' . __('Lokalizacja:') . ' ' . $job->location . '. ' . __('Budżet:') . ' ' . $job->budget . ' PLN.')
@section('keywords', __('zlecenie dron, praca operator drona, filmowanie dronem, fotografia dronem') . ', ' . $job->location)

@section('og_title', $job->title . ' - ' . __('Zlecenie') . ' | SkyReel')
@section('og_description', Str::limit(strip_tags($job->description), 160))
@section('og_type', 'article')
@section('article_published_time', $job->created_at->toISOString())
@section('article_modified_time', $job->updated_at->toISOString())

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "JobPosting",
    "title": "{{ $job->title }}",
    "description": "{{ strip_tags($job->description) }}",
    "datePosted": "{{ $job->created_at->toISOString() }}",
    "validThrough": "{{ $job->created_at->addDays(30)->toISOString() }}",
    "employmentType": "CONTRACT",
    "hiringOrganization": {
        "@type": "Organization",
        "name": "SkyReel",
        "url": "{{ url('/') }}"
    },
    "jobLocation": {
        "@type": "Place",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "{{ $job->location }}"
        }
    },
    "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "PLN",
        "value": {
            "@type": "QuantitativeValue",
            "value": {{ $job->budget }},
            "unitText": "TOTAL"
        }
    },
    "industry": "{{ __('Usługi dronowe') }}",
    "occupationalCategory": "{{ __('Operator dronów') }}",
    "workHours": "{{ __('Elastyczne') }}",
    "url": "{{ route('jobs.show', $job) }}"
}
</script>
@endpush

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Powrót do zleceń
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Header -->
                <div class="liquid-glass rounded-liquid p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-primary mb-2">{{ $job->title }}</h1>
                            <div class="flex items-center gap-4 text-sm text-secondary">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $job->location }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $job->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $job->statusColor }}">
                                {{ $job->statusLabel }}
                            </span>
                            @if($job->is_featured)
                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium">
                                    Wyróżnione
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Budget -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between p-4 bg-accent/10 rounded-lg border border-accent/20">
                            <span class="text-primary font-medium">Budżet:</span>
                            <span class="text-2xl font-bold text-accent">{{ number_format($job->budget, 0, ',', ' ') }} PLN</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-primary mb-3">Opis projektu</h3>
                        <div class="prose prose-invert max-w-none">
                            <p class="text-secondary leading-relaxed whitespace-pre-line">{{ $job->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Client Info -->
                <div class="liquid-glass rounded-liquid p-6">
                    <h3 class="text-lg font-semibold text-primary mb-4">Klient</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-accent/20 rounded-full flex items-center justify-center">
                            @if($job->client->profile && $job->client->profile->profile_picture_url)
                                <img src="{{ $job->client->profile->profile_picture_url }}" 
                                     alt="{{ $job->client->name }}" 
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-medium text-primary">{{ $job->client->name }}</h4>
                            <p class="text-secondary text-sm">
                                Członek od {{ $job->client->created_at->format('M Y') }}
                            </p>
                            @if($job->client->getAverageRating() > 0)
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $job->client->getAverageRating() ? 'fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-secondary text-sm ml-2">
                                        ({{ $job->client->getTotalReviewsCount() }} {{ $job->client->getTotalReviewsCount() == 1 ? 'opinia' : 'opinii' }})
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Proposals Section -->
                @if($job->proposals->count() > 0)
                    <div class="liquid-glass rounded-liquid p-6">
                        <h3 class="text-lg font-semibold text-primary mb-4">
                            Oferty ({{ $job->proposals->count() }})
                        </h3>
                        <div class="space-y-4">
                            @foreach($job->proposals as $proposal)
                                <div class="border border-surface rounded-lg p-4 {{ $proposal->status === 'accepted' ? 'bg-green-500/10 border-green-500/30' : '' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-accent/20 rounded-full flex items-center justify-center">
                                                @if($proposal->operator->profile && $proposal->operator->profile->profile_picture_url)
                                                    <img src="{{ $proposal->operator->profile->profile_picture_url }}" 
                                                         alt="{{ $proposal->operator->name }}" 
                                                         class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-primary">{{ $proposal->operator->name }}</h4>
                                                <p class="text-secondary text-sm">{{ $proposal->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-accent">{{ number_format($proposal->proposed_fee, 0, ',', ' ') }} PLN</div>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $proposal->statusColor }}">
                                                {{ $proposal->statusLabel }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-secondary text-sm leading-relaxed">{{ $proposal->proposal_text }}</p>
                                    
                                    @can('acceptProposal', $job)
                                        @if($proposal->status === 'pending')
                                            <div class="flex gap-2 mt-4">
                                                <form action="{{ route('jobs.proposals.accept', [$job, $proposal]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn-primary text-sm">Akceptuj</button>
                                                </form>
                                                <form action="{{ route('jobs.proposals.reject', [$job, $proposal]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn-secondary text-sm">Odrzuć</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                @auth
                    @if(auth()->user()->isOperator() && $job->status === 'open')
                        @if(!$job->proposals->where('operator_id', auth()->id())->count())
                            <div class="liquid-glass rounded-liquid p-6">
                                <h3 class="text-lg font-semibold text-primary mb-4">Złóż ofertę</h3>
                                <form action="{{ route('jobs.proposals.store', $job) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="proposed_fee" class="block text-sm font-medium text-primary mb-2">
                                            Twoja cena (PLN)
                                        </label>
                                        <input type="number" 
                                               id="proposed_fee" 
                                               name="proposed_fee" 
                                               placeholder="1000"
                                               min="0"
                                               step="50"
                                               class="input-field"
                                               required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="proposal_text" class="block text-sm font-medium text-primary mb-2">
                                            Opis oferty
                                        </label>
                                        <textarea id="proposal_text" 
                                                  name="proposal_text" 
                                                  rows="4"
                                                  placeholder="Opisz jak zrealizujesz ten projekt..."
                                                  class="input-field"
                                                  required></textarea>
                                    </div>
                                    <button type="submit" class="btn-primary w-full">
                                        Wyślij ofertę
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="liquid-glass rounded-liquid p-6">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-primary mb-2">Oferta wysłana</h3>
                                    <p class="text-secondary text-sm">Twoja oferta została już wysłana. Poczekaj na odpowiedź klienta.</p>
                                </div>
                            </div>
                        @endif
                    @endif

                    @can('update', $job)
                        <div class="liquid-glass rounded-liquid p-6">
                            <h3 class="text-lg font-semibold text-primary mb-4">Zarządzaj zleceniem</h3>
                            <div class="space-y-3">
                                <a href="{{ route('jobs.edit', $job) }}" class="btn-secondary w-full text-center">
                                    Edytuj zlecenie
                                </a>
                                <a href="{{ route('payments.feature-job', $job) }}" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors w-full">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Wyróżnij Zlecenie
                                </a>
                                @if($job->status === 'in_progress')
                                    <form action="{{ route('jobs.complete', $job) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary w-full">
                                            Oznacz jako zakończone
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('jobs.destroy', $job) }}" method="POST" 
                                      onsubmit="return confirm('Czy na pewno chcesz usunąć to zlecenie?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger w-full">
                                        Usuń zlecenie
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                @else
                    <div class="liquid-glass rounded-liquid p-6">
                        <h3 class="text-lg font-semibold text-primary mb-4">Zainteresowany?</h3>
                        <p class="text-secondary text-sm mb-4">
                            Zaloguj się, aby złożyć ofertę na to zlecenie.
                        </p>
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                            Zaloguj się
                        </a>
                    </div>
                @endauth

                @auth
                    @php
                        $acceptedProposal = $job->getAcceptedProposal();
                        $canReview = $job->status === 'completed'
                            && $acceptedProposal
                            && (
                                auth()->id() === $job->client_id
                                || (auth()->user()->isOperator() && $acceptedProposal->operator_id === auth()->id())
                            );
                        $alreadyReviewed = $canReview
                            ? $job->reviews()->where('reviewer_id', auth()->id())->exists()
                            : false;
                        $myReview = $alreadyReviewed
                            ? $job->reviews()->where('reviewer_id', auth()->id())->first()
                            : null;
                    @endphp

                    @if($canReview)
                        <div class="liquid-glass rounded-liquid p-6">
                            <h3 class="text-lg font-semibold text-primary mb-4">Oceń współpracę</h3>
                            @if(!$alreadyReviewed)
                                <p class="text-secondary text-sm mb-4">
                                    Zlecenie zostało zakończone. Dodaj recenzję współpracy, aby pomóc innym użytkownikom.
                                </p>
                                <a href="{{ route('reviews.create') }}?job_id={{ $job->id }}" class="btn-primary w-full text-center">
                                    Napisz recenzję
                                </a>
                            @else
                                <div class="space-y-3">
                                    <p class="text-secondary text-sm">
                                        Dziękujemy! Twoja recenzja została już dodana.
                                    </p>
                                    @if($myReview)
                                        <a href="{{ route('reviews.show', $myReview) }}" class="btn-secondary w-full text-center">
                                            Zobacz swoją recenzję
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endauth

                <!-- Job Stats -->
                <div class="liquid-glass rounded-liquid p-6">
                    <h3 class="text-lg font-semibold text-primary mb-4">Statystyki</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-secondary">Oferty:</span>
                            <span class="text-primary font-medium">{{ $job->proposals->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-secondary">Średnia oferta:</span>
                            <span class="text-primary font-medium">
                                @if($job->proposals->count() > 0)
                                    {{ number_format($job->proposals->avg('proposed_fee'), 0, ',', ' ') }} PLN
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-secondary">Opublikowane:</span>
                            <span class="text-primary font-medium">{{ $job->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection