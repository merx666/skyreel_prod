<!-- Cookie Consent Banner -->
<div id="cookie-consent-banner" class="fixed bottom-0 left-0 right-0 z-50 p-4 transform translate-y-full transition-transform duration-300 ease-in-out" style="display: none;">
    <div class="max-w-6xl mx-auto">
        <div class="liquid-glass rounded-2xl p-6 shadow-2xl border border-white/10">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-white mb-2">
                        🍪 {{ __('We use cookies') }}
                    </h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        {{ __('We use essential cookies to make our site work. We\'d also like to set analytics cookies to help us improve our website. We won\'t set analytics cookies unless you accept them.') }}
                        <a href="{{ route('legal.privacy-policy') }}" class="text-blue-400 hover:text-blue-300 underline ml-1">
                            {{ __('Learn more in our Privacy Policy') }}
                        </a>
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 min-w-fit">
                    <button id="cookie-settings-btn" 
                            class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white border border-gray-600 hover:border-gray-500 rounded-lg transition-colors duration-200">
                        {{ __('Cookie Settings') }}
                    </button>
                    <button id="reject-cookies-btn" 
                            class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors duration-200">
                        {{ __('Reject All') }}
                    </button>
                    <button id="accept-cookies-btn" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                        {{ __('Accept All') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookie-settings-modal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    
    <!-- Modal -->
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="liquid-glass rounded-2xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">{{ __('Cookie Settings') }}</h2>
                <button id="close-cookie-modal" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-6">
                <!-- Essential Cookies -->
                <div class="border-b border-gray-700 pb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-white">{{ __('Essential Cookies') }}</h3>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-400 mr-3">{{ __('Always Active') }}</span>
                            <div class="w-12 h-6 bg-blue-600 rounded-full relative">
                                <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 right-0.5"></div>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm">
                        {{ __('These cookies are necessary for the website to function and cannot be switched off. They are usually only set in response to actions made by you such as setting your privacy preferences, logging in or filling in forms.') }}
                    </p>
                </div>

                <!-- Analytics Cookies -->
                <div class="border-b border-gray-700 pb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-white">{{ __('Analytics Cookies') }}</h3>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="analytics-cookies" class="sr-only peer">
                            <div class="w-12 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-6 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <p class="text-gray-300 text-sm">
                        {{ __('These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously. We use Google Analytics for this purpose.') }}
                    </p>
                </div>

                <!-- Marketing Cookies -->
                <div class="pb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-white">{{ __('Marketing Cookies') }}</h3>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="marketing-cookies" class="sr-only peer">
                            <div class="w-12 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-6 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <p class="text-gray-300 text-sm">
                        {{ __('These cookies are used to show you relevant advertisements based on your interests. They may be set by us or by third-party providers whose services we use on our pages.') }}
                    </p>
                </div>
            </div>

            <!-- Modal Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-700">
                <button id="save-cookie-preferences" 
                        class="flex-1 px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg font-medium transition-colors duration-200">
                    {{ __('Save Preferences') }}
                </button>
                <button id="accept-all-modal" 
                        class="flex-1 px-6 py-3 text-white bg-green-600 hover:bg-green-700 rounded-lg font-medium transition-colors duration-200">
                    {{ __('Accept All') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('cookie-consent-banner');
    const modal = document.getElementById('cookie-settings-modal');
    const analyticsCheckbox = document.getElementById('analytics-cookies');
    const marketingCheckbox = document.getElementById('marketing-cookies');

    // IDs z konfiguracji aplikacji wstrzyknięte jako stałe JS
    const GA_ID = "{{ config('services.google_analytics.id') }}";
    const ADSENSE_CLIENT = "{{ config('services.adsense.client') }}";

    // Initialize Consent Mode defaults (deny non-essential by default)
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('consent', 'default', {
        ad_storage: 'denied',
        analytics_storage: 'denied',
        functionality_storage: 'granted', // essential
        security_storage: 'granted'       // essential
    });

    // Check if user has already made a choice
    const cookieConsent = localStorage.getItem('cookie-consent');
    
    if (!cookieConsent) {
        // Show banner after a short delay
        setTimeout(() => {
            banner.style.display = 'block';
            setTimeout(() => {
                banner.classList.remove('translate-y-full');
            }, 100);
        }, 1000);
    } else {
        // Load existing preferences
        const preferences = JSON.parse(cookieConsent);
        if (preferences.analytics) {
            // Grant analytics storage and load GA
            gtag('consent', 'update', { analytics_storage: 'granted' });
            loadGoogleAnalytics();
        }
        if (preferences.marketing) {
            // Grant ad storage and load marketing scripts
            gtag('consent', 'update', { ad_storage: 'granted' });
            loadMarketingScripts();
        }
    }

    // Accept all cookies
    document.getElementById('accept-cookies-btn').addEventListener('click', function() {
        const preferences = {
            essential: true,
            analytics: true,
            marketing: true,
            timestamp: Date.now()
        };
        
        localStorage.setItem('cookie-consent', JSON.stringify(preferences));
        hideBanner();
        // Update consent mode and load scripts
        gtag('consent', 'update', { analytics_storage: 'granted' });
        gtag('consent', 'update', { ad_storage: 'granted' });
        loadGoogleAnalytics();
        loadMarketingScripts();
    });

    // Reject all cookies
    document.getElementById('reject-cookies-btn').addEventListener('click', function() {
        const preferences = {
            essential: true,
            analytics: false,
            marketing: false,
            timestamp: Date.now()
        };
        
        localStorage.setItem('cookie-consent', JSON.stringify(preferences));
        hideBanner();
    });

    // Show cookie settings modal
    document.getElementById('cookie-settings-btn').addEventListener('click', function() {
        modal.classList.remove('hidden');
        
        // Load current preferences if they exist
        if (cookieConsent) {
            const preferences = JSON.parse(cookieConsent);
            analyticsCheckbox.checked = preferences.analytics || false;
            marketingCheckbox.checked = preferences.marketing || false;
        }
    });

    // Close modal
    document.getElementById('close-cookie-modal').addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    // Accept all from modal
    document.getElementById('accept-all-modal').addEventListener('click', function() {
        analyticsCheckbox.checked = true;
        marketingCheckbox.checked = true;
        savePreferences();
    });

    // Save preferences
    document.getElementById('save-cookie-preferences').addEventListener('click', function() {
        savePreferences();
    });

    // Close modal when clicking backdrop
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    function savePreferences() {
        const preferences = {
            essential: true,
            analytics: analyticsCheckbox.checked,
            marketing: marketingCheckbox.checked,
            timestamp: Date.now()
        };
        
        localStorage.setItem('cookie-consent', JSON.stringify(preferences));
        modal.classList.add('hidden');
        hideBanner();
        
        // Update consent mode according to preferences
        gtag('consent', 'update', { analytics_storage: preferences.analytics ? 'granted' : 'denied' });
        gtag('consent', 'update', { ad_storage: preferences.marketing ? 'granted' : 'denied' });

        if (preferences.analytics) {
            loadGoogleAnalytics();
        }
        
        if (preferences.marketing) {
            loadMarketingScripts();
        }
    }

    function hideBanner() {
        banner.classList.add('translate-y-full');
        setTimeout(() => {
            banner.style.display = 'none';
        }, 300);
    }

    function loadGoogleAnalytics() {
        // Ładuj GA tylko raz i tylko jeśli mamy ID
        if (!window.__gaLoaded && GA_ID) {
            const gaScript = document.createElement('script');
            gaScript.async = true;
            gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
            gaScript.onload = function() {
                // Inicjalizacja GA po załadowaniu skryptu
                gtag('js', new Date());
                gtag('config', GA_ID, { anonymize_ip: true, cookie_flags: 'SameSite=None;Secure' });
            };
            document.head.appendChild(gaScript);
            window.__gaLoaded = true;
        }
    }

    function loadMarketingScripts() {
        // Ładuj AdSense wyłącznie po zgodzie marketingowej i jeśli mamy client ID
        if (!window.__adsenseLoaded && ADSENSE_CLIENT) {
            const adsScript = document.createElement('script');
            adsScript.async = true;
            adsScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' + ADSENSE_CLIENT;
            adsScript.setAttribute('crossorigin', 'anonymous');
            document.head.appendChild(adsScript);
            window.__adsenseLoaded = true;
        }
    }

    // Expose function to check consent status
    window.checkCookieConsent = function(type) {
        const consent = localStorage.getItem('cookie-consent');
        if (!consent) return false;
        
        const preferences = JSON.parse(consent);
        return preferences[type] || false;
    };
});
</script>