@extends('layouts.app')

@section('title', $user->name . ' - ' . __('Profile'))
@section('description', __('Profil operatora drona') . ' ' . $user->name . '. ' . ($user->profile->bio ?? __('Profesjonalny operator dronów oferujący usługi filmowania i fotografii.')))
@section('keywords', __('operator drona, pilot drona, usługi dronowe, filmowanie dronem, fotografia dronem') . ', ' . $user->name)

@section('og_title', $user->name . ' - ' . __('Operator Dronów') . ' | SkyReel')
@section('og_description', __('Profil operatora drona') . ' ' . $user->name . '. ' . ($user->profile->bio ?? __('Profesjonalny operator dronów oferujący usługi filmowania i fotografii.')))
@section('og_type', 'profile')
@section('og_image', $user->profile->profile_picture_url ?? asset('images/og-default.jpg'))

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "{{ $user->name }}",
    "description": "{{ $user->profile->bio ?? __('Profesjonalny operator dronów oferujący usługi filmowania i fotografii.') }}"
    @if($user->profile && $user->profile->profile_picture_url)
    ,"image": "{{ $user->profile->profile_picture_url }}"
    @endif
    @if($user->profile && $user->profile->location)
    ,"address": {
        "@type": "PostalAddress",
        "addressLocality": "{{ $user->profile->location }}"
    }
    @endif
    @if($user->profile && $user->profile->website_url)
    ,"url": "{{ $user->profile->website_url }}"
    @endif
    ,"jobTitle": "{{ __('Operator Dronów') }}"
    ,"worksFor": {
        "@type": "Organization",
        "name": "SkyReel"
    }
    ,"sameAs": "{{ route('profile.show', $user) }}"
}
</script>
@endpush

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="liquid-glass rounded-2xl p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Profile Picture -->
                <div class="flex-shrink-0">
                    @if($user->profile && $user->profile->profile_picture_url)
                        <img src="{{ $user->profile->profile_picture_url }}" 
                             alt="{{ $user->name }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-blue-400/30"
                             loading="lazy">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                            <div class="flex items-center gap-4 text-gray-300 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $user->role === 'operator' ? 'bg-blue-500/20 text-blue-300' : 'bg-green-500/20 text-green-300' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                @if($user->profile && $user->profile->location)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $user->profile->location }}
                                    </span>
                                @endif
                            </div>
                            @if($user->profile && $user->profile->bio)
                                <p class="text-gray-300 max-w-2xl">{{ $user->profile->bio }}</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            @auth
                                @if(auth()->id() === $user->id)
                                    <a href="{{ route('profiles.edit', $user->profile) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        {{ __('Edit Profile') }}
                                    </a>
                                    <a href="{{ route('payments.feature-profile') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                        Wyróżnij Profil
                                    </a>
                                @else
                                    <button type="button"
                                            data-start-conversation
                                            data-user-id="{{ $user->id }}"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {{ __('Send Message') }}
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Portfolio Section -->
                @if($user->portfolios->count() > 0)
                    <div class="liquid-glass rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white">{{ __('Portfolio') }}</h2>
                            <a href="{{ route('portfolios.index', ['user' => $user->id]) }}" 
                               class="text-blue-400 hover:text-blue-300 text-sm">
                                {{ __('View All') }}
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->portfolios->take(4) as $portfolio)
                                <a href="{{ route('portfolios.show', $portfolio) }}" 
                                   class="group block bg-gray-800/50 rounded-lg overflow-hidden hover:bg-gray-800/70 transition-colors">
                                    @if($portfolio->mediaItems->first())
                                        @php $firstMedia = $portfolio->mediaItems->first(); @endphp
                                        @if($firstMedia->type === 'image')
                                            <img src="{{ $firstMedia->source_url }}" 
                                                 alt="{{ $portfolio->title }}"
                                                 class="w-full h-32 object-cover">
                                        @else
                                            <img src="{{ $firstMedia->thumbnail_url }}" 
                                                 alt="{{ $portfolio->title }}"
                                                 class="w-full h-32 object-cover">
                                        @endif
                                    @else
                                        <div class="w-full h-32 bg-gray-700 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h3 class="font-semibold text-white group-hover:text-blue-400 transition-colors">
                                            {{ $portfolio->title }}
                                        </h3>
                                        <p class="text-gray-400 text-sm mt-1 line-clamp-2">
                                            {{ Str::limit($portfolio->description, 80) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Equipment Section -->
                @if(($user->equipment?->count() ?? 0) > 0)
                    <div class="liquid-glass rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white">{{ __('Equipment') }}</h2>
                            @auth
                                @if(auth()->id() === $user->id)
                                    <a href="{{ route('equipment.create') }}" 
                                       class="text-blue-400 hover:text-blue-300 text-sm">
                                        {{ __('Add Equipment') }}
                                    </a>
                                @endif
                            @endauth
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->equipment->take(6) as $equipment)
                                <div class="bg-gray-800/50 rounded-lg p-4 hover:bg-gray-800/70 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <!-- Equipment Icon -->
                                        <div class="flex-shrink-0">
                                            @if($equipment->type === 'drone')
                                                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($equipment->type === 'camera')
                                                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586l-.707-.707A1 1 0 0013 4H7a1 1 0 00-.707.293L5.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @elseif($equipment->type === 'lens')
                                                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 bg-gray-500/20 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Equipment Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-white">
                                                {{ $equipment->brand }} {{ $equipment->model }}
                                            </h3>
                                            <p class="text-sm text-gray-400 capitalize">{{ $equipment->type }}</p>
                                            @if($equipment->description)
                                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                                    {{ Str::limit($equipment->description, 60) }}
                                                </p>
                                            @endif
                                        </div>
                                        
                                        @auth
                                            @if(auth()->id() === $user->id)
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('equipment.show', $equipment) }}" 
                                                       class="text-gray-400 hover:text-white">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(($user->equipment?->count() ?? 0) > 6)
                            <div class="mt-4 text-center">
                                <a href="{{ route('equipment.index', ['user' => $user->id]) }}" 
                                   class="text-blue-400 hover:text-blue-300 text-sm">
                                    {{ __('View All Equipment') }} ({{ $user->equipment->count() }})
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Equipment Section -->
                    <div class="liquid-glass p-6 rounded-2xl border border-white/10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-white">{{ __('Equipment') }}</h3>
                            @if(auth()->check() && auth()->id() === $user->id)
                                <a href="{{ route('equipment.create') }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors duration-200">
                                    {{ __('Add Equipment') }}
                                </a>
                            @endif
                        </div>
                        
                        @if($user->equipment->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->equipment as $equipment)
                                    <div class="bg-gray-800/30 rounded-lg p-4 border border-gray-700">
                                        <div class="flex items-start space-x-4">
                                            @if($equipment->image_url)
                                                <img src="{{ asset('storage/' . $equipment->image_url) }}" 
                                                     alt="{{ $equipment->brand }} {{ $equipment->model }}"
                                                     class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-1">
                                                    <span class="px-2 py-1 bg-blue-600/20 text-blue-400 text-xs rounded-full">
                                                        {{ $equipment->type_display }}
                                                    </span>
                                                </div>
                                                <h4 class="text-white font-medium">{{ $equipment->brand }} {{ $equipment->model }}</h4>
                                                @if($equipment->description)
                                                    <p class="text-gray-400 text-sm mt-1">{{ Str::limit($equipment->description, 100) }}</p>
                                                @endif
                                            </div>
                                            @if(auth()->check() && auth()->id() === $user->id)
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('equipment.edit', $equipment) }}" 
                                                       class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                                <p class="text-gray-400">{{ __('No equipment listed yet') }}</p>
                                @if(auth()->check() && auth()->id() === $user->id)
                                    <a href="{{ route('equipment.create') }}" 
                                       class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                        {{ __('Add Your First Equipment') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                @if(($user->receivedReviews?->count() ?? 0) > 0)
                    <div class="liquid-glass rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-white mb-6">{{ __('Reviews') }}</h2>
                        
                        <div class="space-y-4">
                            @foreach($user->receivedReviews->take(3) as $review)
                                <div class="bg-gray-800/50 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">
                                                    {{ substr($review->reviewer->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-white">{{ $review->reviewer->name }}</h4>
                                                <div class="flex items-center gap-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}" 
                                                             fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-gray-300">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                @if($user->id === 6)
                    <!-- Featured profile: Merx -->
                    <div class="liquid-glass rounded-2xl p-6 border border-blue-500/30">
                        <div class="flex items-center gap-3 mb-3">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-white">
                                Wyróżniony profil: Merx
                            </h3>
                        </div>
                        <p class="text-gray-300 mb-4">
                            Merx to dynamiczny twórca wideo i operator drona – kreatywny, szybki i niezwykle precyzyjny. Specjalizuje się w realizacjach komercyjnych, eventach i produkcjach social video, dostarczając materiały, które przyciągają uwagę i budzą emocje.
                        </p>
                        <!-- TikTok latest video embed (provide exact URL to wideo) -->
                        @if(optional($user->profile)->tiktok_latest_url)
                            @php
                                // Derive video ID from the TikTok URL for robustness
                                $tiktokUrl = $user->profile->tiktok_latest_url;
                                $videoId = \Illuminate\Support\Str::before(\Illuminate\Support\Str::after($tiktokUrl, '/video/'), '?');
                            @endphp
                            <div style="width:100%;max-width:100%;overflow:hidden;">
                                <blockquote class="tiktok-embed" cite="{{ $tiktokUrl }}" data-video-id="{{ $videoId }}" style="width:100%;max-width:100%;min-width:0;">
                                    <section>Odtwarzanie filmu TikTok</section>
                                </blockquote>
                            </div>
                            <script async src="https://www.tiktok.com/embed.js"></script>
                        @else
                            <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4 mb-4">
                                <p class="text-blue-300 text-sm">
                                    Dodaj adres URL do najnowszego filmu z TikToka w profilu (pole <code>tiktok_latest_url</code>), a osadzimy go automatycznie.
                                </p>
                            </div>
                        @endif
                        <div class="mt-2 space-y-1">
                            <p class="text-gray-200"><span class="text-gray-400">Email:</span> <a class="text-blue-400 hover:text-blue-300" href="mailto:fishexo@gmail.com">fishexo@gmail.com</a></p>
                            <p class="text-gray-200"><span class="text-gray-400">Telefon:</span> <a class="text-blue-400 hover:text-blue-300" href="tel:+48663665262">+48 663 665 262</a> <span class="text-gray-400">(preferuję kontakt SMS)</span></p>
                        </div>
                    </div>
                @endif
                <!-- Stats Card -->
                <div class="liquid-glass rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">{{ __('Statistics') }}</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('Portfolio Items') }}</span>
                            <span class="text-white font-semibold">{{ $user->portfolios?->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('Equipment') }}</span>
                            <span class="text-white font-semibold">{{ $user->equipment?->count() ?? 0 }}</span>
                        </div>
                        @if($user->role === 'operator')
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">{{ __('Jobs Completed') }}</span>
                                <span class="text-white font-semibold">{{ $user->completedJobs?->count() ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">{{ __('Average Rating') }}</span>
                                <span class="text-white font-semibold">
                                    @if(($user->receivedReviews?->count() ?? 0) > 0)
                                        {{ number_format(($user->receivedReviews?->avg('rating') ?? 0), 1) }}/5
                                        @else
                                            {{ __('No reviews yet') }}
                                        @endif
                                </span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('Member Since') }}</span>
                            <span class="text-white font-semibold">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                @if($user->profile && ($user->profile->website_url || $user->profile->location))
                    <div class="liquid-glass rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">{{ __('Contact Info') }}</h3>
                        <div class="space-y-3">
                            @if($user->profile->website_url)
                                <a href="{{ $user->profile->website_url }}" 
                                   target="_blank" 
                                   class="flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    {{ __('Website') }}
                                </a>
                            @endif
                            @if($user->profile->location)
                                <div class="flex items-center gap-3 text-gray-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $user->profile->location }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-start-conversation]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = parseInt(btn.dataset.userId, 10);
            if (!Number.isNaN(id)) {
                startConversation(id);
            }
        });
    });
});
function startConversation(userId) {
    fetch('{{ route("messages.start") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("messages.index") }}';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection