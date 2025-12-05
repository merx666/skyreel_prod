<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode, 'light': !darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', config('app.name') . ' - ' . __('Marketplace dla Operatorów Dronów'))</title>
    <meta name="description" content="{{ $metaDescription ?? __('Znajdź profesjonalnych operatorów dronów lub oferuj swoje usługi. SkyReel łączy klientów z najlepszymi pilotami dronów w Polsce.') }}">
    <meta name="keywords" content="drone, aerial photography, videography, hire drone operator">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? config('app.name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? __('Znajdź profesjonalnych operatorów dronów lub oferuj swoje usługi. SkyReel łączy klientów z najlepszymi pilotami dronów w Polsce.') }}">
    <meta property="og:image" content="{{ $metaImage ?? asset('images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $metaTitle ?? config('app.name') }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? __('Znajdź profesjonalnych operatorów dronów lub oferuj swoje usługi. SkyReel łączy klientów z najlepszymi pilotami dronów w Polsce.') }}">
    <meta property="twitter:image" content="{{ $metaImage ?? asset('images/og-image.jpg') }}">
    
    
    <!-- Google AdSense Verification -->
    <meta name="google-adsense-account" content="ca-pub-3530955836310219">
    
    <!-- ApiTiny Ads -->
    <script src="https://cdn.apitiny.net/scripts/v2.0/main.js" data-site-id="6920b4b1c2ab6e73884c890d" data-test-mode="false" async></script>
    <style>
        .banner-wrapper {
            padding: 1rem 0;
        }

        .card.card-inlined {
          max-width: 100%;
          min-width: 100%;
        }

        .card.card-inlined .card-image {
          max-height: 17px;
          margin-bottom: 0.5rem;
        }

        .dark-theme .card.card-inlined .card-image {
          max-height: 30px;
          padding: 4px;
          background: #ffffff44;
          border-radius: 5px;
        }

        .card.card-inlined .card-title {
          font-size: 1.1rem;
          margin-bottom: 0;
        }

        .card.card-inlined .card-button {
          max-width: 100%;
        }

        @media(min-width:768px) {
           .card.card-inlined .card-content {
              flex-direction: row;
              align-items: center;
              justify-content: space-between;
           }
        }

        @media(max-width:767.98px) {
           .card.card-inlined .card-button {
             overflow: hidden;
             white-space: nowrap;
             text-overflow: ellipsis;
           }
        }
    </style>

    
    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="author" content="@yield('author', 'SkyReel')">
    @if(View::hasSection('article_published_time'))
    <meta property="article:published_time" content="@yield('article_published_time')">
    @endif
    @if(View::hasSection('article_modified_time'))
    <meta property="article:modified_time" content="@yield('article_modified_time')">
    @endif

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Alternate Language Links -->
    <link rel="alternate" hreflang="pl" href="{{ url()->current() }}?lang=pl">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <!-- Code highlighting (Highlight.js) - load BEFORE app scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/styles/default.min.css">
    <script src="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/lib/common.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function() { if(window.hljs) hljs.highlightAll(); });</script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    
    
    <!-- Structured Data -->
    @stack('structured-data')
    
    <!-- Base Organization Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "description": "{{ __('Marketplace łączący operatorów dronów z klientami. Znajdź profesjonalnych pilotów dronów lub oferuj swoje usługi.') }}",
        "sameAs": [
            "https://www.facebook.com/skyreel",
            "https://www.instagram.com/skyreel",
            "https://www.linkedin.com/company/skyreel"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "customer service",
            "email": "kontakt@skyreel.art"
        }
    }
    </script>
    <!-- LocalBusiness Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Skyreel",
        "url": "{{ config('app.url') }}",
        "image": "{{ asset('images/logo.png') }}",
        "email": "kontakt@skyreel.art",
        "areaServed": {
            "@type": "AdministrativeArea",
            "name": "Polska"
        },
        "serviceType": ["Aerial Videography", "Drone Pilot"],
        "sameAs": [
            "https://www.facebook.com/skyreel",
            "https://www.instagram.com/skyreel",
            "https://www.linkedin.com/company/skyreel"
        ]
    }
    </script>
    
    <!-- Website Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ config('app.name') }}",
        "url": "{{ config('app.url') }}",
        "description": "{{ __('Marketplace łączący operatorów dronów z klientami. Znajdź profesjonalnych pilotów dronów lub oferuj swoje usługi.') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ route('search.index') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Google Analytics & AdSense: ładowane przez Cookie Consent z Consent Mode -->
</head>
<body class="antialiased bg-primary min-h-screen transition-colors duration-300">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 liquid-glass backdrop-blur-md border-b border-glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-accent">
                        SkyReel
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}" class="nav-link">Strona Główna</a>
                        <a href="{{ url('/portfolios') }}" class="nav-link">Portfolio</a>
                        <a href="{{ route('pages.uslugi') }}" class="nav-link">Usługi</a>
                        <a href="{{ route('pages.o-nas') }}" class="nav-link">O nas</a>
                        <a href="{{ route('pages.kontakt') }}" class="nav-link">Kontakt</a>
                        <a href="{{ route('portfolios.discover') }}" class="nav-link">Odkrywaj</a>
                         <a href="{{ route('recommendations.index') }}" class="nav-link">Rekomendacje</a>
                         <a href="{{ route('jobs.index') }}" class="nav-link">Zlecenia</a>
                        <a href="{{ route('store.index') }}" class="nav-link font-semibold text-accent hover:text-accent/80 transition-colors">Sklep</a>
                        <a href="{{ route('profiles.index') }}" class="nav-link">Operatorzy</a>
                        <a href="{{ route('search.index') }}" class="nav-link">Wyszukiwanie</a>
                        <a href="https://buy.stripe.com/dRm4gy5Yd09P61w3dA4gg00" class="btn-primary" target="_blank" rel="noopener noreferrer">Wesprzyj</a>
                        
                        <!-- Theme Toggle Button -->
                        <button 
                            @click="darkMode = !darkMode" 
                            class="relative flex items-center justify-center w-12 h-6 rounded-full transition-all duration-300 focus:outline-none liquid-glass backdrop-blur-md border border-opacity-20"
                            :class="darkMode ? 'border-blue-300 bg-opacity-20 bg-blue-900' : 'border-gray-300 bg-opacity-20 bg-white'"
                            aria-label="Przełącz motyw"
                        >
                            <span 
                                class="absolute left-1 top-1 w-4 h-4 rounded-full transition-transform duration-300 transform flex items-center justify-center"
                                :class="darkMode ? 'translate-x-6 bg-blue-400' : 'translate-x-0 bg-yellow-400'"
                            >
                                <svg x-show="darkMode" class="w-3 h-3 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                                <svg x-show="!darkMode" class="w-3 h-3 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button 
                        @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                        class="p-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors duration-200"
                    >
                        <svg x-show="darkMode" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg x-show="!darkMode" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    @auth
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 nav-link">
                                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="{{ auth()->user()->name }}">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 liquid-glass rounded-lg shadow-lg py-1">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">Dashboard</a>
                                <a href="{{ route('profile.show', auth()->user()) }}" class="block px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">Profil</a>
                                <a href="{{ route('conversations.index') }}" class="block px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">Wiadomości</a>
                                @if(auth()->user()->isOperator())
                                    <a href="{{ route('portfolios.create') }}" class="block px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">Dodaj Portfolio</a>
                                @endif
                                @if(auth()->user()->isClient())
                                    <a href="{{ route('jobs.create') }}" class="block px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">Dodaj Zlecenie</a>
                                @endif
                                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">Ustawienia</a>
                                <hr class="my-1 border-white border-opacity-10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-primary hover:bg-white hover:bg-opacity-10">
                                        Wyloguj
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Links -->
                        <a href="{{ route('login') }}" class="nav-link">Zaloguj</a>
                        <a href="{{ route('register') }}" class="btn-primary">Zarejestruj</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="p-2 rounded-lg hover:bg-white hover:bg-opacity-10" x-data="{ open: false }" @click="open = !open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16 min-h-screen">
        @yield('content')
    </main>



    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed bottom-4 right-4 z-50 liquid-glass p-4 rounded-lg max-w-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-primary">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false" class="text-secondary hover:text-primary">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed bottom-4 right-4 z-50 liquid-glass p-4 rounded-lg max-w-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-primary">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false" class="text-secondary hover:text-primary">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Cookie Consent -->
    @include('components.cookie-consent')

    <!-- Global Ad Unit -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center" style="min-height: 100px;">
        <!-- SkyReel Global Ad -->
        <!-- ApiTiny Global Ad -->
        <div ta-ad-container=""></div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <!-- AdSense Slots -->
    @stack('adsense-slots')
</body>
</html>