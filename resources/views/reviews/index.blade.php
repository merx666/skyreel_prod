@extends('layouts.app')

@section('title', __('Recenzje'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <!-- Hero Section -->
    <div class="relative py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4">
                    {{ __('Recenzje i oceny') }}
                </h1>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    {{ __('Zobacz, co klienci i operatorzy mówią o współpracy na SkyReel') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @if($reviews->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($reviews as $review)
                    <div class="liquid-glass p-6 rounded-2xl border border-white/10">
                        <!-- Review Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $review->reviewer->profile?->profile_picture_url ?? '/images/default-avatar.png' }}" 
                                     alt="{{ $review->reviewer->name }}"
                                     class="w-12 h-12 rounded-full object-cover">
                                <div>
                                    <h3 class="font-semibold text-white">{{ $review->reviewer->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm text-gray-400">({{ $review->rating }}/5)</span>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <div class="mb-4">
                            <p class="text-gray-300 leading-relaxed">{{ $review->comment }}</p>
                        </div>

                        <!-- Job Info -->
                        @if($review->job)
                            <div class="border-t border-white/10 pt-4">
                                <p class="text-sm text-gray-400 mb-1">{{ __('Zlecenie') }}:</p>
                                <a href="{{ route('jobs.show', $review->job) }}" 
                                   class="text-blue-400 hover:text-blue-300 font-medium text-sm">
                                    {{ $review->job->title }}
                                </a>
                            </div>
                        @endif

                        <!-- Reviewee Info -->
                        <div class="border-t border-white/10 pt-4 mt-4">
                            <p class="text-sm text-gray-400 mb-2">{{ __('Recenzja dla') }}:</p>
                            <div class="flex items-center space-x-2">
                                <img src="{{ $review->reviewee->profile?->profile_picture_url ?? '/images/default-avatar.png' }}" 
                                     alt="{{ $review->reviewee->name }}"
                                     class="w-8 h-8 rounded-full object-cover">
                                <a href="{{ route('profile.show', $review->reviewee) }}" 
                                   class="text-blue-400 hover:text-blue-300 font-medium text-sm">
                                    {{ $review->reviewee->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $reviews->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="liquid-glass p-12 rounded-2xl border border-white/10 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ __('Brak recenzji') }}</h3>
                    <p class="text-gray-400">{{ __('Recenzje pojawią się tutaj po zakończeniu zleceń i wystawieniu ocen.') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection