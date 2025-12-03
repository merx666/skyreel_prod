@extends('layouts.app')

@section('title', __('Conversations'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">{{ __('Conversations') }}</h1>
            <a href="{{ route('conversations.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                {{ __('New Conversation') }}
            </a>
        </div>

        <!-- Conversations List -->
        <div class="space-y-4">
            @forelse($conversations as $conversation)
                <div class="liquid-glass p-6 rounded-xl border border-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <!-- Participants -->
                                <div class="flex -space-x-2">
                                    @foreach($conversation->users->take(3) as $user)
                                        @if($user->id !== auth()->id())
                                            <img src="{{ $user->profile->profile_picture_url ?? 'https://ui-avatars.io/api/?name=' . urlencode($user->name) . '&color=7c3aed&background=1f2937' }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="w-10 h-10 rounded-full border-2 border-gray-700">
                                        @endif
                                    @endforeach
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-white">
                                        @if($conversation->title)
                                            {{ $conversation->title }}
                                        @else
                                            @php
                                                $otherUsers = $conversation->users->where('id', '!=', auth()->id());
                                            @endphp
                                            {{ $otherUsers->pluck('name')->join(', ') }}
                                        @endif
                                    </h3>
                                    
                                    @if($conversation->latestMessage)
                                        <p class="text-gray-400 text-sm mt-1">
                                            <span class="font-medium">{{ $conversation->latestMessage->user->name }}:</span>
                                            {{ Str::limit($conversation->latestMessage->message, 50) }}
                                        </p>
                                        <p class="text-gray-500 text-xs mt-1">
                                            {{ $conversation->latestMessage->created_at->diffForHumans() }}
                                        </p>
                                    @else
                                        <p class="text-gray-500 text-sm mt-1">{{ __('No messages yet') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <!-- Unread count -->
                            @if($conversation->unread_count > 0)
                                <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $conversation->unread_count }}
                                </span>
                            @endif
                            
                            <!-- View conversation -->
                            <a href="{{ route('conversations.show', $conversation) }}" 
                               class="text-blue-400 hover:text-blue-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">{{ __('No conversations') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Start a new conversation to connect with other users.') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('conversations.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            {{ __('Start Conversation') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($conversations->hasPages())
            <div class="mt-8">
                {{ $conversations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection