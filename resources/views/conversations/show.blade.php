@extends('layouts.app')

@section('title', $conversation->title ?: $otherUsers->pluck('name')->join(', '))

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="liquid-glass border-b border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('conversations.index') }}" 
                       class="text-gray-400 hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <!-- Participants avatars -->
                        <div class="flex -space-x-2">
                            @foreach($otherUsers->take(3) as $user)
                                <img src="{{ $user->profile->profile_picture_url ?? 'https://ui-avatars.io/api/?name=' . urlencode($user->name) . '&color=7c3aed&background=1f2937' }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-10 h-10 rounded-full border-2 border-gray-700">
                            @endforeach
                        </div>
                        
                        <div>
                            <h1 class="text-xl font-bold text-white">
                                @if($conversation->title)
                                    {{ $conversation->title }}
                                @else
                                    {{ $otherUsers->pluck('name')->join(', ') }}
                                @endif
                            </h1>
                            <p class="text-gray-400 text-sm">
                                {{ $otherUsers->count() }} {{ $otherUsers->count() === 1 ? __('participant') : __('participants') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <button onclick="markAsRead()" 
                            class="text-gray-400 hover:text-gray-300 transition-colors p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex flex-col h-[calc(100vh-200px)]">
            <!-- Messages List -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4">
                @forelse($messages as $message)
                    <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md">
                            <!-- Message bubble -->
                            <div class="flex items-end space-x-2 {{ $message->user_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                <!-- Avatar -->
                                @if($message->user_id !== auth()->id())
                                    <img src="{{ $message->user->profile->profile_picture_url ?? 'https://ui-avatars.io/api/?name=' . urlencode($message->user->name) . '&color=7c3aed&background=1f2937' }}" 
                                         alt="{{ $message->user->name }}" 
                                         class="w-8 h-8 rounded-full">
                                @endif
                                
                                <!-- Message content -->
                                <div class="liquid-glass p-4 rounded-2xl {{ $message->user_id === auth()->id() ? 'bg-blue-600/20 border-blue-500/30' : 'border-gray-700/50' }}">
                                    @if($message->user_id !== auth()->id())
                                        <p class="text-xs text-gray-400 mb-1">{{ $message->user->name }}</p>
                                    @endif
                                    
                                    <p class="text-white text-sm leading-relaxed">{{ $message->message }}</p>
                                    
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-xs text-gray-500">
                                            {{ $message->created_at->format('H:i') }}
                                        </p>
                                        
                                        @if($message->user_id === auth()->id())
                                            <div class="flex items-center space-x-1">
                                                @if($message->read_at)
                                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-300">{{ __('No messages yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Start the conversation by sending a message below.') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="liquid-glass border-t border-gray-700/50 p-6">
                <form id="message-form" action="{{ route('conversations.messages.store', $conversation) }}" method="POST" class="flex space-x-4">
                    @csrf
                    <div class="flex-1">
                        <textarea name="message" id="message-input" 
                                  class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" 
                                  rows="1" 
                                  placeholder="{{ __('Type your message...') }}" 
                                  required></textarea>
                    </div>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span class="hidden sm:inline">{{ __('Send') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Auto-resize textarea
const messageInput = document.getElementById('message-input');
messageInput.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Handle Enter key (send message)
messageInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('message-form').submit();
    }
});

// Auto-scroll to bottom
function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

// Scroll to bottom on page load
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
});

// Mark conversation as read
function markAsRead() {
    fetch('{{ route("conversations.read", $conversation) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Conversation marked as read');
        }
    })
    .catch(error => {
        console.error('Error marking as read:', error);
    });
}

// Auto-mark as read when user scrolls to bottom
let isAtBottom = false;
const messagesContainer = document.getElementById('messages-container');

messagesContainer.addEventListener('scroll', function() {
    const threshold = 50;
    const position = this.scrollTop + this.offsetHeight;
    const height = this.scrollHeight;
    
    isAtBottom = position >= height - threshold;
    
    if (isAtBottom) {
        markAsRead();
    }
});

// Real-time updates (if Laravel Reverb is configured)
@if(config('broadcasting.default') === 'reverb')
if (typeof window.Echo !== 'undefined') {
    window.Echo.private('conversation.{{ $conversation->id }}')
        .listen('MessageSent', function(e) {
            const messagesContainer = document.getElementById('messages-container');
            const messageHtml = createMessageElement(e.message);
            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
            
            if (isAtBottom) {
                scrollToBottom();
            }
        });
    
    function createMessageElement(message) {
        const isOwn = message.user_id === {{ auth()->id() }};
        let avatarUrl = 'https://ui-avatars.io/api/?name=' + encodeURIComponent(message.user.name) + '&color=7c3aed&background=1f2937';
        if (message.user.profile && message.user.profile.profile_picture_url) {
            avatarUrl = message.user.profile.profile_picture_url;
        }
        
        const messageElement = document.createElement('div');
        messageElement.className = 'flex ' + (isOwn ? 'justify-end' : 'justify-start');
        
        messageElement.innerHTML = 
            '<div class="max-w-xs lg:max-w-md">' +
                '<div class="flex items-end space-x-2 ' + (isOwn ? 'flex-row-reverse space-x-reverse' : '') + '">' +
                    (!isOwn ? '<img src="' + avatarUrl + '" alt="' + message.user.name + '" class="w-8 h-8 rounded-full">' : '') +
                    '<div class="liquid-glass p-4 rounded-2xl ' + (isOwn ? 'bg-blue-600/20 border-blue-500/30' : 'border-gray-700/50') + '">' +
                        (!isOwn ? '<p class="text-xs text-gray-400 mb-1">' + message.user.name + '</p>' : '') +
                        '<p class="text-white text-sm leading-relaxed">' + message.message + '</p>' +
                        '<div class="flex items-center justify-between mt-2">' +
                            '<p class="text-xs text-gray-500">' + new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}) + '</p>' +
                            (isOwn ? '<div class="flex items-center space-x-1">' +
                                '<svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">' +
                                    '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>' +
                                '</svg>' +
                            '</div>' : '') +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        
        return messageElement.outerHTML;
    }
}
@endif
</script>
@endsection
@endsection