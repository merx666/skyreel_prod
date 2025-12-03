@extends('layouts.app')

@section('title', 'Skyreel | Profesjonalne Usługi Dronami i Wideo Lotnicze')
@section('description', 'Odkryj świat z powietrza. Skyreel specjalizuje się w zapierających dech w piersiach ujęciach z dronów dla nieruchomości, eventów i marketingu.')
@section('keywords', __('drony, operatorzy dronów, filmowanie dronem, fotografia dronem, usługi dronowe, inspekcje dronowe, fotografia z powietrza, filmowanie z powietrza, profesjonalni operatorzy dronów'))

@section('og_title', 'Skyreel | Profesjonalne Usługi Dronami i Wideo Lotnicze')
@section('og_description', 'Odkryj świat z powietrza. Skyreel specjalizuje się w zapierających dech w piersiach ujęciach z dronów dla nieruchomości, eventów i marketingu.')
@section('og_type', 'website')

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "SkyReel",
    "description": "{{ __('Marketplace łączący operatorów dronów z klientami') }}",
    "url": "{{ url('/') }}",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/search') }}?q={search_term_string}",
        "query-input": "required name=search_term_string"
    },
    "sameAs": [
        "https://www.facebook.com/skyreel",
        "https://www.instagram.com/skyreel",
        "https://www.linkedin.com/company/skyreel"
    ]
}
</script>
@endpush

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Video/Image -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900"></div>
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                Odkryj Świat z
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                    Powietrza
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Platforma łącząca profesjonalnych operatorów dronów z klientami. Znajdź idealnego pilota dla swojego projektu lub oferuj swoje usługi.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                    Dołącz jako Operator
                </a>
                <a href="{{ route('jobs.index') }}" class="btn-secondary text-lg px-8 py-4">
                    Znajdź Operatora
                </a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Dlaczego SkyReel Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#131314]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">
                    {{ __('Dlaczego SkyReel?') }}
                </h2>
                <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                    {{ __('Jesteśmy wiodącą platformą łączącą profesjonalnych operatorów dronów z klientami poszukującymi wysokiej jakości usług z powietrza.') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl transition hover:shadow-blue-500/20">
                    <div class="text-blue-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ __('Zweryfikowani Operatorzy') }}</h3>
                    <p class="text-gray-300">
                        {{ __('Wszyscy operatorzy na naszej platformie przechodzą proces weryfikacji, aby zapewnić najwyższą jakość usług. Sprawdzamy uprawnienia, doświadczenie i portfolio każdego operatora.') }}
                    </p>
                </div>
                
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl transition hover:shadow-blue-500/20">
                    <div class="text-blue-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ __('Bezpieczne Płatności') }}</h3>
                    <p class="text-gray-300">
                        {{ __('Nasza platforma zapewnia bezpieczne transakcje między klientami a operatorami. Płatność jest zwalniana dopiero po zatwierdzeniu wykonanej usługi, co gwarantuje zadowolenie obu stron.') }}
                    </p>
                </div>
                
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl transition hover:shadow-blue-500/20">
                    <div class="text-blue-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ __('System Ocen i Recenzji') }}</h3>
                    <p class="text-gray-300">
                        {{ __('Po każdym zleceniu klienci mogą ocenić operatora, co pomaga utrzymać wysoką jakość usług i ułatwia wybór odpowiedniego specjalisty do konkretnego projektu.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- O Nas Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#131314]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">
                    {{ __('O SkyReel') }}
                </h2>
                <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                    {{ __('Poznaj naszą misję i dowiedz się, jak zrewolucjonizowaliśmy rynek usług dronowych w Polsce.') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-semibold text-white mb-4">{{ __('Nasza Misja') }}</h3>
                    <p class="text-gray-300 mb-6">
                        {{ __('SkyReel powstało z pasji do fotografii i filmowania z powietrza. Naszą misją jest stworzenie profesjonalnej platformy, która łączy wykwalifikowanych operatorów dronów z klientami poszukującymi wysokiej jakości materiałów z lotu ptaka.') }}
                    </p>
                    <p class="text-gray-300 mb-6">
                        {{ __('Wierzymy, że perspektywa z powietrza otwiera zupełnie nowe możliwości w fotografii, filmowaniu, inspekcjach technicznych i wielu innych dziedzinach. Dlatego stworzyliśmy miejsce, gdzie profesjonaliści mogą prezentować swoje umiejętności, a klienci łatwo znajdą idealnego operatora do swojego projektu.') }}
                    </p>
                    <h3 class="text-2xl font-semibold text-white mb-4">{{ __('Nasze Wartości') }}</h3>
                    <ul class="list-disc pl-5 text-gray-300 mb-6">
                        <li class="mb-2">{{ __('Profesjonalizm - stawiamy na najwyższą jakość usług i materiałów') }}</li>
                        <li class="mb-2">{{ __('Bezpieczeństwo - wszyscy operatorzy posiadają niezbędne uprawnienia i ubezpieczenia') }}</li>
                        <li class="mb-2">{{ __('Innowacyjność - nieustannie rozwijamy platformę o nowe funkcje') }}</li>
                        <li>{{ __('Społeczność - budujemy aktywną społeczność pasjonatów dronów') }}</li>
                    </ul>
                </div>
                <div class="liquid-glass p-8 rounded-2xl border border-gray-700/40 shadow-2xl">
                    <h3 class="text-2xl font-semibold text-white mb-4">{{ __('Dlaczego warto korzystać z SkyReel?') }}</h3>
                    
                    <div class="mb-6">
                        <h4 class="text-xl font-medium text-white mb-2">{{ __('Dla Klientów:') }}</h4>
                        <ul class="list-disc pl-5 text-gray-300">
                            <li class="mb-2">{{ __('Dostęp do sprawdzonych, profesjonalnych operatorów dronów') }}</li>
                            <li class="mb-2">{{ __('Możliwość przeglądania portfolio i ocen poprzednich klientów') }}</li>
                            <li class="mb-2">{{ __('Bezpieczny system płatności i komunikacji') }}</li>
                            <li class="mb-2">{{ __('Gwarancja jakości wykonanej usługi') }}</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-xl font-medium text-white mb-2">{{ __('Dla Operatorów:') }}</h4>
                        <ul class="list-disc pl-5 text-gray-300">
                            <li class="mb-2">{{ __('Profesjonalny profil i portfolio dostępne dla potencjalnych klientów') }}</li>
                            <li class="mb-2">{{ __('Dostęp do zleceń od klientów z całej Polski') }}</li>
                            <li class="mb-2">{{ __('Możliwość wyróżnienia swojego profilu i portfolio') }}</li>
                            <li class="mb-2">{{ __('Budowanie reputacji poprzez system ocen i recenzji') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#131314]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">
                    {{ __('Jak to działa?') }}
                </h2>
                <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                    {{ __('Proces korzystania z SkyReel jest prosty i intuicyjny. Oto jak możesz zacząć:') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500/20 text-blue-400 ring-1 ring-blue-400/30 mb-4">
                        <span class="text-2xl font-bold">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ __('Zarejestruj się') }}</h3>
                    <p class="text-gray-300">
                        {{ __('Utwórz konto jako klient poszukujący usług lub jako operator drona oferujący swoje umiejętności.') }}
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500/20 text-blue-400 ring-1 ring-blue-400/30 mb-4">
                        <span class="text-2xl font-bold">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">
                        {{ __('Uzupełnij profil') }}
                    </h3>
                    <p class="text-gray-300">
                        {{ __('Dodaj informacje o sobie, swoim doświadczeniu i sprzęcie (operatorzy) lub o swoich potrzebach (klienci).') }}
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500/20 text-blue-400 ring-1 ring-blue-400/30 mb-4">
                        <span class="text-2xl font-bold">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">
                        {{ __('Przeglądaj i kontaktuj się') }}
                    </h3>
                    <p class="text-gray-300">
                        {{ __('Przeglądaj dostępne zlecenia lub portfolio operatorów. Nawiąż kontakt i omów szczegóły projektu.') }}
                    </p>
                </div>
                
                <!-- Step 4 -->
                <div class="liquid-glass p-6 rounded-2xl border border-gray-700/40 shadow-2xl text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500/20 text-blue-400 ring-1 ring-blue-400/30 mb-4">
                        <span class="text-2xl font-bold">4</span>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">
                        {{ __('Realizuj projekty') }}
                    </h3>
                    <p class="text-gray-300">
                        {{ __('Finalizuj zlecenia, dokonuj bezpiecznych płatności i wystawiaj oceny po zakończonej współpracy.') }}
                    </p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                    {{ __('Dołącz do SkyReel') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Jobs Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('Wyróżnione Portfolio') }}
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    {{ __('Odkryj najlepsze prace naszych operatorów dronów. Każde portfolio to unikalna historia opowiedziana z perspektywy ptaka.') }}
                </p>
            </div>

            @if($featuredPortfolios->count() > 0)
                <div class="max-w-4xl mx-auto">
                    <portfolio-tiktok-viewer 
                        :portfolios="{{ $featuredPortfolios->toJson() }}"
                    ></portfolio-tiktok-viewer>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('Brak wyróżnionych portfolio') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            {{ __('Aktualnie nie ma wyróżnionych portfolio. Operatorzy mogą wykupić wyróżnienie, aby ich prace były widoczne w tej sekcji.') }}
                        </p>
                            {{ __('Zostań pierwszym operatorem z wyróżnionym portfolio!') }}
                        </p>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent-dark transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Zostań operatorem') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-primary mb-4">Jak to działa?</h2>
                <p class="text-xl text-secondary max-w-2xl mx-auto">
                    Prosty proces w trzech krokach
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center liquid-glass p-8 rounded-2xl hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Zarejestruj się</h3>
                    <p class="text-secondary">
                        Stwórz konto jako operator drona lub klient szukający usług filmowych
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center liquid-glass p-8 rounded-2xl hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Znajdź lub Oferuj</h3>
                    <p class="text-secondary">
                        Przeglądaj portfolio operatorów lub publikuj swoje zlecenie
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center liquid-glass p-8 rounded-2xl hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Współpracuj</h3>
                    <p class="text-secondary">
                        Nawiąż kontakt, uzgodnij szczegóły i zrealizuj projekt
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 liquid-glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-accent mb-2" x-data="{ count: 0 }" x-init="setTimeout(() => { let target = {{ $stats['operators'] ?? 0 }}; let increment = target / 50; let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 20); }, 500)">
                        <span x-text="Math.floor(count)">0</span>
                    </div>
                    <div class="text-secondary">Operatorów</div>
                </div>
                <div class="hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-accent mb-2" x-data="{ count: 0 }" x-init="setTimeout(() => { let target = {{ $stats['portfolios'] ?? 0 }}; let increment = target / 50; let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 20); }, 700)">
                        <span x-text="Math.floor(count)">0</span>
                    </div>
                    <div class="text-secondary">Portfolio</div>
                </div>
                <div class="hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-accent mb-2" x-data="{ count: 0 }" x-init="setTimeout(() => { let target = {{ $stats['jobs'] ?? 0 }}; let increment = target / 50; let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 20); }, 900)">
                        <span x-text="Math.floor(count)">0</span>
                    </div>
                    <div class="text-secondary">Zleceń</div>
                </div>
                <div class="hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-accent mb-2" x-data="{ count: 0 }" x-init="setTimeout(() => { let target = {{ $stats['completed'] ?? 0 }}; let increment = target / 50; let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 20); }, 1100)">
                        <span x-text="Math.floor(count)">0</span>
                    </div>
                    <div class="text-secondary">Ukończonych</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-primary mb-4">Wyróżnione Zlecenia</h2>
                <p class="text-xl text-secondary max-w-2xl mx-auto">
                    Najlepsze możliwości współpracy
                </p>
            </div>
            
            @if($featuredJobs->isNotEmpty())
                <div class="h-screen rounded-2xl overflow-hidden">
                    <job-tiktok-viewer 
                        :jobs="{{ $featuredJobs->toJson() }}"
                        :user="{{ auth()->user() ? auth()->user()->toJson() : 'null' }}"
                        @view-job="window.location.href = '{{ url('/jobs') }}/' + $event.id"
                        @apply-job="window.location.href = '{{ url('/jobs') }}/' + $event.id + '#apply'"
                    ></job-tiktok-viewer>
                </div>
            @else
                <div class="text-center py-20">
                    <div class="text-6xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-primary mb-4">Brak wyróżnionych zleceń</h3>
                    <p class="text-secondary mb-8">Sprawdź najnowsze zlecenia poniżej lub dodaj swoje!</p>
                    @auth
                        @if(auth()->user()->role === 'client')
                            <a href="{{ route('jobs.create') }}" class="btn-primary">
                                Dodaj Zlecenie
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            Zaloguj się
                        </a>
                    @endauth
                </div>
            @endif

            <!-- Recent Jobs Section -->
            <div class="text-center mb-16">
                <h3 class="text-2xl font-bold text-primary mb-4">Najnowsze Zlecenia</h3>
                <p class="text-lg text-secondary max-w-2xl mx-auto">
                    Sprawdź najnowsze możliwości współpracy
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recentJobs as $job)
                    <div class="liquid-glass p-6 rounded-2xl hover:scale-105 transition-transform duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold text-primary">{{ $job->title }}</h3>
                            <span class="px-3 py-1 bg-accent text-white text-sm rounded-full">
                                {{ number_format($job->budget) }} PLN
                            </span>
                        </div>
                        <p class="text-secondary mb-4">{{ Str::limit($job->description, 100) }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-secondary">{{ $job->location }}</span>
                            <span class="text-sm text-secondary">{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                        @if($job->client && $job->client->profile)
                            <div class="flex items-center">
                                @if($job->client->profile->profile_picture_url)
                                    <img src="{{ $job->client->profile->profile_picture_url }}" 
                                         alt="{{ $job->client->name }}" 
                                         class="w-8 h-8 rounded-full mr-2">
                                @endif
                                <span class="text-sm text-secondary">{{ $job->client->name }}</span>
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('jobs.show', $job) }}" class="btn-primary w-full text-center">
                                Zobacz szczegóły
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-secondary mb-4">Brak aktywnych zleceń.</p>
                        <a href="{{ route('jobs.create') }}" class="btn-primary">
                            Dodaj pierwsze zlecenie
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 liquid-glass">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-primary mb-6">
                Gotowy na start?
            </h2>
            <p class="text-xl text-secondary mb-8">
                Dołącz do społeczności profesjonalistów i znajdź swój następny projekt
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4 hover:scale-105 transition-transform duration-300">
                    Rozpocznij teraz
                </a>
                <a href="{{ route('portfolios.index') }}" class="btn-secondary text-lg px-8 py-4 hover:scale-105 transition-transform duration-300">
                    Przeglądaj Portfolio
                </a>
            </div>
        </div>
    </section>
</div>
@endsection