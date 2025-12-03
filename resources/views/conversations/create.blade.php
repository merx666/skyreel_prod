@extends('layouts.app')

@section('title', __('New Conversation'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">{{ __('New Conversation') }}</h1>
            <p class="text-gray-400 mt-2">{{ __('Start a conversation with another user') }}</p>
        </div>

        <!-- Form -->
        <div class="liquid-glass p-8 rounded-xl border border-gray-700/50">
            <form action="{{ route('conversations.store') }}" method="POST" id="conversationForm">
                @csrf
                
                <!-- Recipient Selection -->
                <div class="mb-6">
                    <label for="recipient_id" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Select Recipient') }}
                    </label>
                    <select name="recipient_id" id="recipient_id" 
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            required>
                        <option value="">{{ __('Choose a user...') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                                @if($user->profile && $user->profile->location)
                                    - {{ $user->profile->location }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('recipient_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Message') }}
                    </label>
                    <textarea name="message" id="message" rows="4" 
                              class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" 
                              placeholder="{{ __('Type your message here...') }}" 
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('conversations.index') }}" 
                       class="text-gray-400 hover:text-gray-300 transition-colors">
                        {{ __('Cancel') }}
                    </a>
                    
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        {{ __('Send Message') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-white mb-4">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Message from Job -->
                @if(request('job_id'))
                    @php
                        $job = \App\Models\Job::find(request('job_id'));
                    @endphp
                    @if($job)
                        <div class="liquid-glass p-4 rounded-lg border border-gray-700/50">
                            <h4 class="font-medium text-white mb-2">{{ __('About Job') }}</h4>
                            <p class="text-gray-400 text-sm">{{ $job->title }}</p>
                            <p class="text-gray-500 text-xs mt-1">{{ __('Budget') }}: ${{ number_format($job->budget) }}</p>
                        </div>
                    @endif
                @endif

                <!-- Message from Profile -->
                @if(request('user_id'))
                    @php
                        $targetUser = \App\Models\User::find(request('user_id'));
                    @endphp
                    @if($targetUser)
                        <div class="liquid-glass p-4 rounded-lg border border-gray-700/50">
                            <h4 class="font-medium text-white mb-2">{{ __('Contact') }}</h4>
                            <div class="flex items-center space-x-3">
                                <img src="{{ $targetUser->profile->profile_picture_url ?? 'https://ui-avatars.io/api/?name=' . urlencode($targetUser->name) . '&color=7c3aed&background=1f2937' }}" 
                                     alt="{{ $targetUser->name }}" 
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="text-white font-medium">{{ $targetUser->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ ucfirst($targetUser->role) }}</p>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('recipient_id').value = '{{ $targetUser->id }}';
                        </script>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Auto-focus message field when recipient is selected
document.getElementById('recipient_id').addEventListener('change', function() {
    if (this.value) {
        document.getElementById('message').focus();
    }
});

// Character counter for message
const messageTextarea = document.getElementById('message');
const maxLength = 1000;

messageTextarea.addEventListener('input', function() {
    const remaining = maxLength - this.value.length;
    
    // Create or update character counter
    let counter = document.getElementById('message-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'message-counter';
        counter.className = 'text-xs text-gray-500 mt-1 text-right';
        messageTextarea.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${this.value.length}/${maxLength}`;
    
    if (remaining < 50) {
        counter.className = 'text-xs text-yellow-400 mt-1 text-right';
    } else if (remaining < 0) {
        counter.className = 'text-xs text-red-400 mt-1 text-right';
    } else {
        counter.className = 'text-xs text-gray-500 mt-1 text-right';
    }
});
</script>
@endsection