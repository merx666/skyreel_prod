@extends('layouts.app')

@section('title', __('Operators'))

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-blue-900/20 to-purple-900/20">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    {{ __('Discover Talented') }}
                    <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        {{ __('Drone Operators') }}
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
                    {{ __('Connect with professional drone operators and aerial photographers from around the world') }}
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('profiles.index') }}" method="GET" class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="{{ __('Search by name, location, or specialization...') }}"
                               class="w-full px-6 py-4 pr-16 bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="liquid-glass rounded-2xl p-6 mb-8">
            <form action="{{ route('profiles.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
                <input type="hidden" name="search" value="{{ request('search') }}">
                
                <!-- Location Filter -->
                <div class="flex-1 min-w-48">
                    <select name="location" 
                            class="w-full px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('All Locations') }}</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Featured Filter -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="featured" 
                           name="featured" 
                           value="1" 
                           {{ request('featured') ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500">
                    <label for="featured" class="ml-2 text-sm text-gray-300">
                        {{ __('Featured Only') }}
                    </label>
                </div>

                <!-- Sort -->
                <div class="flex-1 min-w-48">
                    <select name="sort" 
                            class="w-full px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>{{ __('Name A-Z') }}</option>
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>{{ __('Featured First') }}</option>
                    </select>
                </div>

                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    {{ __('Apply Filters') }}
                </button>
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-400">
                {{ __('Showing :count operators', ['count' => $profiles->total()]) }}
                @if(request('search'))
                    {{ __('for ":search"', ['search' => request('search')]) }}
                @endif
            </p>
        </div>

        <!-- Profiles Grid -->
        @if($profiles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($profiles as $profile)
                    <div class="liquid-glass rounded-2xl p-6 hover:scale-105 transition-transform duration-300 group">
                        <!-- Featured Badge -->
                        @if($profile->is_featured && $profile->featured_until && $profile->featured_until->isFuture())
                            <div class="absolute -top-2 -right-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                {{ __('FEATURED') }}
                            </div>
                        @endif

                        <!-- Profile Header -->
                        <div class="text-center mb-4">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                @if($profile->profile_picture_url)
                                    <img src="{{ $profile->profile_picture_url }}" 
                             alt="{{ $profile->user->name }}" 
                             class="w-full h-full object-cover"
                             loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                        <span class="text-2xl font-bold text-white">{{ substr($profile->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-bold text-white mb-1">{{ $profile->user->name }}</h3>
                            
                            @if($profile->location)
                                <p class="text-gray-400 flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $profile->location }}
                                </p>
                            @endif
                        </div>

                        <!-- Bio -->
                        @if($profile->bio)
                            <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                                {{ Str::limit($profile->bio, 120) }}
                            </p>
                        @endif

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                            <div>
                                <div class="text-lg font-bold text-white">{{ $profile->portfolios_count ?? 0 }}</div>
                                <div class="text-xs text-gray-400">{{ __('Portfolio') }}</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-white">{{ $profile->equipment_count ?? 0 }}</div>
                                <div class="text-xs text-gray-400">{{ __('Equipment') }}</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-white">{{ number_format($profile->avg_rating ?? 0, 1) }}</div>
                                <div class="text-xs text-gray-400">{{ __('Rating') }}</div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('profile.show', $profile->user) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg transition-colors group-hover:bg-blue-500">
                            {{ __('View Profile') }}
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $profiles->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">{{ __('No operators found') }}</h3>
                <p class="text-gray-400 mb-6">
                    @if(request('search'))
                        {{ __('Try adjusting your search criteria or browse all operators.') }}
                    @else
                        {{ __('Be the first to create a profile and showcase your drone skills!') }}
                    @endif
                </p>
                
                @if(request('search'))
                    <a href="{{ route('profiles.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        {{ __('View All Operators') }}
                    </a>
                @else
                    @auth
                        @if(!auth()->user()->profile)
                            <a href="{{ route('profiles.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                {{ __('Create Your Profile') }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            {{ __('Join SkyReel') }}
                        </a>
                    @endauth
                @endif
            </div>
        @endif
    </div>
</div>
@endsection