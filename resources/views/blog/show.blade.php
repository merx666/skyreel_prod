@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <article class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            @if($post->cover_image)
                <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-64 md:h-96 object-cover">
            @endif

            <div class="p-6 md:p-10">
                <header class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>
                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                        <span class="mx-2">•</span>
                        <span>By {{ $post->user->name }}</span>
                    </div>
                </header>

                <div class="prose dark:prose-invert max-w-none">
                    {!! $post->content !!}
                </div>

                <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('blog.index') }}" class="text-amber-500 hover:text-amber-600 font-medium inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Blog
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
