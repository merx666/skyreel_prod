@extends('layouts.app')

@section('title', __('Edytuj recenzję'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">{{ __('Edytuj recenzję') }}</h1>
            <p class="text-gray-400">{{ __('Zaktualizuj swoją recenzję') }}</p>
        </div>

        <!-- Review Form -->
        <div class="liquid-glass p-8 rounded-2xl border border-white/10">
            <form action="{{ route('reviews.update', $review) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Job Info (Read-only) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Zlecenie') }}</label>
                    <div class="px-4 py-3 bg-gray-800/30 border border-gray-700 rounded-lg text-gray-400">
                        {{ $review->job->title }}
                    </div>
                </div>

                <!-- Reviewee Info (Read-only) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Recenzja dla') }}</label>
                    <div class="px-4 py-3 bg-gray-800/30 border border-gray-700 rounded-lg text-gray-400">
                        {{ $review->reviewee->name }}
                    </div>
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        {{ __('Ocena') }} <span class="text-red-400">*</span>
                    </label>
                    <div class="flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" 
                                       {{ $review->rating == $i ? 'checked' : '' }}
                                       class="sr-only">
                                <svg class="w-8 h-8 {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-600' }} hover:text-yellow-400 transition-colors duration-200" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
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
                              placeholder="{{ __('Podziel się doświadczeniem: co poszło dobrze oraz co można poprawić...') }}"
                              class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('reviews.show', $review) }}" 
                       class="px-6 py-3 text-gray-400 hover:text-white transition-colors duration-200">
                        {{ __('Anuluj') }}
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        {{ __('Zaktualizuj recenzję') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection