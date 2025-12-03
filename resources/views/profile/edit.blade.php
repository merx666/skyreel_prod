@extends('layouts.app')

@section('title', __('Edit Profile'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass rounded-2xl p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">{{ __('Edit Profile') }}</h1>
                <p class="text-gray-300">{{ __('Update your profile information') }}</p>
            </div>

            <form action="{{ route('profiles.update', $profile) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Profile Picture') }}
                    </label>
                    <div class="flex items-center gap-6">
                        <div id="profile-preview" class="w-24 h-24 rounded-full overflow-hidden">
                            @if($profile->profile_picture_url)
                                <img src="{{ $profile->profile_picture_url }}" 
                                     alt="{{ $profile->user->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">{{ substr($profile->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewImage(this)">
                            <label for="profile_picture" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Change Photo') }}
                            </label>
                            <p class="text-sm text-gray-500 mt-1">{{ __('JPG, PNG up to 2MB') }}</p>
                        </div>
                    </div>
                    @error('profile_picture')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Location') }}
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $profile->location) }}"
                           placeholder="{{ __('e.g., Warsaw, Poland') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('location')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Bio') }}
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4"
                              placeholder="{{ __('Tell us about yourself, your experience, and what makes you unique...') }}"
                              class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website URL -->
                <div>
                    <label for="website_url" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Website URL') }} <span class="text-gray-500">({{ __('optional') }})</span>
                    </label>
                    <input type="url" 
                           id="website_url" 
                           name="website_url" 
                           value="{{ old('website_url', $profile->website_url) }}"
                           placeholder="{{ __('https://your-website.com') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('website_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TikTok Latest Video URL -->
                <div>
                    <label for="tiktok_latest_url" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('TikTok Latest Video URL') }} <span class="text-gray-500">({{ __('optional') }})</span>
                    </label>
                    <input type="url" 
                           id="tiktok_latest_url" 
                           name="tiktok_latest_url" 
                           value="{{ old('tiktok_latest_url', $profile->tiktok_latest_url) }}"
                           placeholder="{{ __('https://www.tiktok.com/@username/video/1234567890') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('tiktok_latest_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">{{ __('Paste the full URL to your latest TikTok video to display it on your profile.') }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        {{ __('Update Profile') }}
                    </button>
                    <a href="{{ route('profile.show', $profile->user) }}" 
                       class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                        {{ __('Cancel') }}
                    </a>
                </div>

                <!-- Delete Profile -->
                <div class="pt-6 border-t border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-white">{{ __('Delete Profile') }}</h3>
                            <p class="text-sm text-gray-400">{{ __('This will permanently delete your profile information.') }}</p>
                        </div>
                        <button type="button" 
                                onclick="confirmDelete()"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            {{ __('Delete') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Hidden Delete Form -->
            <form id="delete-form" action="{{ route('profiles.destroy', $profile) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('profile-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" class="w-full h-full object-cover">`;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDelete() {
    if (confirm('{{ __("Are you sure you want to delete your profile? This action cannot be undone.") }}')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection