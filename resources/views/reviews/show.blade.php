@extends('layouts.app')

@section('title', __('Szczegóły recenzji'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('reviews.index') }}" 
               class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Wróć do recenzji') }}
            </a>
        </div>

        <!-- Review Card -->
        <div class="liquid-glass p-8 rounded-2xl border border-white/10">
            <!-- Review Header -->
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <img src="{{ $review->reviewer->profile?->profile_picture_url ?? '/images/default-avatar.png' }}" 
                         alt="{{ $review->reviewer->name }}"
                         class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $review->reviewer->name }}</h1>
                        <p class="text-gray-400">{{ $review->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}" 
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <span class="ml-2 text-lg font-semibold text-white">({{ $review->rating }}/5)</span>
                </div>
            </div>

            <!-- Review Content -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-white mb-3">{{ __('Recenzja') }}</h2>
                <div class="bg-gray-800/30 rounded-lg p-6">
                    <p class="text-gray-300 leading-relaxed text-lg">{{ $review->comment }}</p>
                </div>
            </div>

            <!-- Job Information -->
            @if($review->job)
                <div class="border-t border-white/10 pt-6 mb-6">
                    <h3 class="text-lg font-semibold text-white mb-3">{{ __('Powiązane zlecenie') }}</h3>
                    <div class="bg-gray-800/30 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-white mb-2">{{ $review->job->title }}</h4>
                                <p class="text-gray-400 text-sm mb-2">{{ Str::limit($review->job->description, 150) }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-400">
                                    <span>{{ __('Budżet') }}: {{ number_format($review->job->budget, 0, ',', ' ') }} PLN</span>
                                    <span>{{ __('Lokalizacja') }}: {{ $review->job->location }}</span>
                                </div>
                            </div>
                            <a href="{{ route('jobs.show', $review->job) }}" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors duration-200">
                                {{ __('Zobacz zlecenie') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reviewee Information -->
            <div class="border-t border-white/10 pt-6">
                <h3 class="text-lg font-semibold text-white mb-3">{{ __('Recenzja dla') }}</h3>
                <div class="bg-gray-800/30 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $review->reviewee->profile?->profile_picture_url ?? '/images/default-avatar.png' }}" 
                                 alt="{{ $review->reviewee->name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <h4 class="font-semibold text-white">{{ $review->reviewee->name }}</h4>
                                <p class="text-gray-400 text-sm">
                                    {{ $review->reviewee->role === 'operator' ? __('Operator drona') : __('Klient') }}
                                </p>
                                @if($review->reviewee->profile?->location)
                                    <p class="text-gray-500 text-xs">{{ $review->reviewee->profile->location }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('profile.show', $review->reviewee) }}" 
                           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition-colors duration-200">
                            {{ __('Zobacz profil') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if(auth()->id() === $review->reviewer_id)
                <div class="border-t border-white/10 pt-6 mt-6">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('reviews.edit', $review) }}" 
                           class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                            {{ __('Edytuj recenzję') }}
                        </a>
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline"
                              onsubmit="return confirm({{ json_encode(__('Czy na pewno chcesz usunąć tę recenzję?')) }})">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                                {{ __('Usuń recenzję') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection