<footer class="bg-gray-900 py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo i opis -->
            <div>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-400">SkyReel</span>
                </div>
                <p class="mt-2 text-sm text-gray-400">
                    {{ __('Marketplace łączący operatorów dronów z klientami') }}
                </p>
            </div>
            
            <!-- Linki -->
            <div>
                <h3 class="text-sm font-semibold text-white tracking-wider uppercase">
                    {{ __('Linki') }}
                </h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white">
                            {{ __('Strona główna') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('portfolios.index') }}" class="text-gray-400 hover:text-white">
                            {{ __('Portfolio') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jobs.index') }}" class="text-gray-400 hover:text-white">
                            {{ __('Zlecenia') }}
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Dokumenty prawne i język -->
            <div>
                <h3 class="text-sm font-semibold text-white tracking-wider uppercase">
                    {{ __('Informacje prawne') }}
                </h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('legal.privacy-policy') }}" class="text-gray-400 hover:text-white">
                            {{ __('Polityka prywatności') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legal.terms-of-service') }}" class="text-gray-400 hover:text-white">
                            {{ __('Regulamin serwisu') }}
                        </a>
                    </li>
                </ul>
                
                <!-- Przełącznik języka -->
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">
                        {{ __('Język') }}
                    </h3>
                    <div class="mt-2 flex space-x-4">
                        <a href="{{ route('language.switch', ['locale' => 'pl']) }}" class="text-gray-400 hover:text-white {{ app()->getLocale() === 'pl' ? 'font-bold text-white' : '' }}">
                            PL
                        </a>
                        <a href="{{ route('language.switch', ['locale' => 'en']) }}" class="text-gray-400 hover:text-white {{ app()->getLocale() === 'en' ? 'font-bold text-white' : '' }}">
                            EN
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 border-t border-gray-800 pt-6">
            <p class="text-sm text-gray-400 text-center">
                &copy; {{ date('Y') }} SkyReel. {{ __('Wszelkie prawa zastrzeżone.') }}
            </p>
        </div>
    </div>
</footer>