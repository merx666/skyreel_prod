@extends('layouts.app')

@section('title', __('Wiadomości'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-2xl border border-gray-700/50 overflow-hidden h-[calc(100vh-8rem)]">
            <div class="flex h-full">
                <!-- Conversations Sidebar -->
                <div class="w-1/3 border-r border-gray-700/50 flex flex-col">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-700/50">
                        <h1 class="text-2xl font-bold text-white">{{ __('Wiadomości') }}</h1>
                    </div>

                    <!-- Conversations List -->
                    <div class="flex-1 overflow-y-auto">
                        @forelse($conversations as $conversation)
                            <a href="{{ route('messages.index', ['user_id' => $conversation->other_user_id]) }}" 
                               class="block p-4 border-b border-gray-700/30 hover:bg-gray-700/30 transition-colors {{ $selectedUser && $selectedUser->id == $conversation->other_user_id ? 'bg-blue-600/20 border-blue-500/50' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($conversation->user->profile && $conversation->user->profile->profile_picture_url)
                                            <img src="{{ $conversation->user->profile->profile_picture_url }}" 
                                                 alt="{{ $conversation->user->name }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-medium">{{ substr($conversation->user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-white truncate">
                                                {{ $conversation->user->name }}
                                            </p>
                                            @if($conversation->unread_count > 0)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full">
                                                    {{ $conversation->unread_count }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400">
                                            {{ \Carbon\Carbon::parse($conversation->last_message_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center">
                                <p class="text-gray-400">{{ __('Brak konwersacji') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="flex-1 flex flex-col">
                    @if($selectedUser)
                        <!-- Chat Header -->
                        <div class="p-6 border-b border-gray-700/50 flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if($selectedUser->profile && $selectedUser->profile->profile_picture_url)
                                    <img src="{{ $selectedUser->profile->profile_picture_url }}" 
                                         alt="{{ $selectedUser->name }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium">{{ substr($selectedUser->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-white">{{ $selectedUser->name }}</h2>
                                <p class="text-sm text-gray-400">
                                    @if($selectedUser->isOperator())
                                        {{ __('Operator') }}
                                    @else
                                        {{ __('Klient') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4">
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-xs lg:max-w-md">
                                        <div class="px-4 py-2 rounded-2xl {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white' }}">
                                            @if($message->job_id)
                                                <div class="text-xs opacity-75 mb-1">
                                                    {{ __('Dotyczące zlecenia:') }} {{ $message->job->title }}
                                                </div>
                                            @endif
                                            <p class="text-sm">{{ $message->message }}</p>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                                            {{ $message->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Message Input -->
                        <div class="p-6 border-t border-gray-700/50">
                            <form id="message-form" action="{{ route('messages.store') }}" method="POST" class="flex space-x-4">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                                @if(request('job_id'))
                                    <input type="hidden" name="job_id" value="{{ request('job_id') }}">
                                @endif
                                <div class="flex-1">
                                    <input type="text" 
                                           name="message" 
                                           id="message-input"
                                           placeholder="{{ __('Napisz wiadomość...') }}" 
                                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           required>
                                </div>
                                <button type="submit" 
                                        class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors">
                                    {{ __('Wyślij') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- No Conversation Selected -->
                        <div class="flex-1 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white mb-2">{{ __('Wybierz konwersację') }}</h3>
                                <p class="text-gray-400">{{ __('Wybierz konwersację z listy po lewej stronie, aby rozpocząć czat.') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($selectedUser)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const messagesContainer = document.getElementById('messages-container');

    // Scroll to bottom of messages
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Initial scroll to bottom
    scrollToBottom();

    // Handle form submission
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(messageForm);
        
        fetch(messageForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add message to UI
                const messageHtml = `
                    <div class="flex justify-end">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="px-4 py-2 rounded-2xl bg-blue-600 text-white">
                                ${data.message.job_id ? `<div class="text-xs opacity-75 mb-1">{{ __('Dotyczące zlecenia:') }} ${data.message.job.title}</div>` : ''}
                                <p class="text-sm">${data.message.message}</p>
                            </div>
                            <div class="text-xs text-gray-400 mt-1 text-right">
                                ${new Date().toLocaleTimeString('pl-PL', {hour: '2-digit', minute: '2-digit'})}
                            </div>
                        </div>
                    </div>
                `;
                
                messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                messageInput.value = '';
                scrollToBottom();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Real-time message listening (if Echo is available)
    if (typeof Echo !== 'undefined') {
        Echo.private(`user.{{ auth()->id() }}`)
            .listen('.message.sent', (e) => {
                if (e.sender_id == {{ $selectedUser->id }}) {
                    const messageHtml = `
                        <div class="flex justify-start">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="px-4 py-2 rounded-2xl bg-gray-700 text-white">
                                    ${e.job_id ? `<div class="text-xs opacity-75 mb-1">{{ __('Dotyczące zlecenia:') }} ${e.job_title || ''}</div>` : ''}
                                    <p class="text-sm">${e.message}</p>
                                </div>
                                <div class="text-xs text-gray-400 mt-1 text-left">
                                    ${new Date(e.created_at).toLocaleTimeString('pl-PL', {hour: '2-digit', minute: '2-digit'})}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                    scrollToBottom();
                }
            });
    }
});
</script>
@endif
@endsection