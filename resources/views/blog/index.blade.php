@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Blog & Resources</h1>
            <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">Latest news, tips, and resources for drone operators.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full hover:shadow-md transition-shadow duration-300">
                    @if($post->cover_image)
                        <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400 dark:text-gray-500">No Image</span>
                        </div>
                    @endif
                    
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            {{ $post->published_at->format('M d, Y') }} • {{ $post->user->name }}
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-amber-500 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow">
                            {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-amber-500 hover:text-amber-600 font-medium inline-flex items-center">
                                Read more
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
