@extends('layouts.app')

@section('title', __('Napisz recenzję'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">{{ __('Napisz recenzję') }}</h1>
            <p class="text-gray-400">{{ __('Podziel się doświadczeniem z innymi użytkownikami') }}</p>
        </div>

        <!-- Review Form -->
        <div class="liquid-glass p-8 rounded-2xl border border-white/10">
            <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                @csrf

                <!-- Job Summary (readonly) -->
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Zlecenie') }}</label>
                    <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-semibold">{{ $job->title }}</h3>
                                <p class="text-gray-400 text-sm">{{ __('Opublikowano') }}: {{ $job->created_at->format('Y-m-d') }}</p>
                            </div>
                            <a href="{{ route('jobs.show', $job) }}" class="text-blue-400 hover:text-blue-300 text-sm">{{ __('Zobacz zlecenie') }}</a>
                        </div>
                    </div>
                    @error('job_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reviewee (readonly) -->
                <input type="hidden" name="reviewee_id" value="{{ $reviewee->id }}">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Oceniany użytkownik') }}</label>
                    <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4 flex items-center gap-3">
                        <img src="{{ $reviewee->profile?->profile_picture_url ?? '/images/default-avatar.png' }}" alt="{{ $reviewee->name }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="text-white font-semibold">{{ $reviewee->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $reviewee->role === 'operator' ? __('Operator drona') : __('Klient') }}</p>
                        </div>
                        <a href="{{ route('profile.show', $reviewee) }}" class="ml-auto text-blue-400 hover:text-blue-300 text-sm">{{ __('Zobacz profil') }}</a>
                    </div>
                    @error('reviewee_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        {{ __('Ocena') }} <span class="text-red-400">*</span>
                    </label>
                    <div class="flex items-center space-x-2" id="starGroup">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" aria-label="{{ __('Ocena') }} {{ $i }}" 
                                    class="star w-8 h-8 text-gray-600 hover:text-yellow-400 transition-colors duration-200"
                                    data-value="{{ $i }}">
                                <svg fill="currentColor" viewBox="0 0 20 20" class="w-full h-full">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                        <span class="ml-3 text-gray-400" id="ratingText">{{ __('Kliknij, aby ocenić') }}</span>
                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                    @error('rating')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Twoja recenzja') }} <span class="text-red-400">*</span>
                    </label>
                    <textarea name="comment" id="comment" rows="5" required
                              placeholder="{{ __('Opisz swoje doświadczenie: co poszło dobrze, co można poprawić...') }}"
                              class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('jobs.show', $job) }}" 
                       class="px-6 py-3 text-gray-400 hover:text-white transition-colors duration-200">
                        {{ __('Anuluj') }}
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        {{ __('Wyślij recenzję') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gwiazdki oceny
    const stars = document.querySelectorAll('#starGroup .star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const ratingLabels = {
        1: 'Słabo',
        2: 'Średnio', 
        3: 'Dobrze',
        4: 'Bardzo dobrze',
        5: 'Świetnie'
    };

    const setStars = (value) => {
        stars.forEach((btn) => {
            const starValue = parseInt(btn.getAttribute('data-value'));
            if (starValue <= value) {
                btn.classList.add('text-yellow-400');
                btn.classList.remove('text-gray-600');
            } else {
                btn.classList.add('text-gray-600');
                btn.classList.remove('text-yellow-400');
            }
        });
        ratingText.textContent = ratingLabels[value] || '{{ __('Kliknij, aby ocenić') }}';
    };

    stars.forEach((btn) => {
        btn.addEventListener('click', () => {
            const value = parseInt(btn.getAttribute('data-value'));
            ratingInput.value = value;
            setStars(value);
        });
        btn.addEventListener('mouseenter', () => {
            const value = parseInt(btn.getAttribute('data-value'));
            stars.forEach((s) => {
                const sv = parseInt(s.getAttribute('data-value'));
                if (sv <= value) {
                    s.classList.add('text-yellow-300');
                } else {
                    s.classList.remove('text-yellow-300');
                }
            });
        });
        btn.addEventListener('mouseleave', () => {
            stars.forEach((s) => s.classList.remove('text-yellow-300'));
        });
    });

    // Ustaw początkową ocenę jeśli istnieje
    const initial = parseInt(ratingInput.value || '0');
    if (initial > 0) {
        setStars(initial);
    }
});
</script>
@endsection