@extends('layouts.app')

@section('title', __('Wyróżnij Profil - SkyReel'))
@section('metaDescription', __('Zwiększ swoją widoczność jako operator drona i zdobądź więcej zleceń dzięki wyróżnieniu profilu na SkyReel. Wybierz pakiet dopasowany do Twoich potrzeb.'))
@section('robots', 'index, follow')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-900 to-gray-800 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass p-8 rounded-2xl backdrop-blur-xl border border-gray-700/30 shadow-2xl">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-4">{{ __('Wyróżnij Swój Profil') }}</h1>
                <p class="text-gray-300 text-lg">{{ __('Zwiększ swoją widoczność i zdobądź więcej klientów') }}</p>
                <div class="mt-4 w-24 h-1 bg-blue-500 mx-auto rounded-full"></div>
            </div>
            
            <!-- Schema.org structured data -->
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Product",
                "name": "{{ __('Wyróżnienie profilu operatora drona') }}",
                "description": "{{ __('Zwiększ swoją widoczność jako operator drona i zdobądź więcej zleceń dzięki wyróżnieniu profilu na SkyReel.') }}",
                "offers": [
                    {
                        "@type": "Offer",
                        "name": "{{ __('7 dni wyróżnienia') }}",
                        "price": "29.00",
                        "priceCurrency": "PLN",
                        "availability": "https://schema.org/InStock"
                    },
                    {
                        "@type": "Offer",
                        "name": "{{ __('30 dni wyróżnienia') }}",
                        "price": "99.00",
                        "priceCurrency": "PLN",
                        "availability": "https://schema.org/InStock"
                    },
                    {
                        "@type": "Offer",
                        "name": "{{ __('90 dni wyróżnienia') }}",
                        "price": "249.00",
                        "priceCurrency": "PLN",
                        "availability": "https://schema.org/InStock"
                    }
                ]
            }
            </script>
            
            <!-- FAQ Section -->
            <div class="mt-12 pt-8 border-t border-gray-700/50">
                <h3 class="text-2xl font-semibold text-white mb-6 text-center">{{ __('Często zadawane pytania') }}</h3>
                
                <div class="space-y-4">
                    <div x-data="{ open: false }" class="liquid-glass rounded-lg overflow-hidden">
                        <button @click="open = !open" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none">
                            <span class="text-white font-medium">{{ __('Jak długo trwa wyróżnienie profilu?') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="h-5 w-5 text-blue-400 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 pb-4 text-gray-300">
                            <p>{{ __('Wyróżnienie profilu trwa dokładnie tyle, ile wybierzesz w pakiecie - 7, 30 lub 90 dni. Po tym okresie Twój profil powróci do standardowego wyświetlania.') }}</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="liquid-glass rounded-lg overflow-hidden">
                        <button @click="open = !open" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none">
                            <span class="text-white font-medium">{{ __('Czy mogę anulować wyróżnienie?') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="h-5 w-5 text-blue-400 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 pb-4 text-gray-300">
                            <p>{{ __('Niestety, po dokonaniu płatności za wyróżnienie profilu, nie ma możliwości anulowania usługi ani otrzymania zwrotu pieniędzy. Wyróżnienie będzie aktywne przez cały wybrany okres.') }}</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="liquid-glass rounded-lg overflow-hidden">
                        <button @click="open = !open" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none">
                            <span class="text-white font-medium">{{ __('Czy wyróżnienie automatycznie się odnawia?') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="h-5 w-5 text-blue-400 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 pb-4 text-gray-300">
                            <p>{{ __('Nie, wyróżnienie nie odnawia się automatycznie. Po zakończeniu wybranego okresu, otrzymasz powiadomienie z możliwością przedłużenia wyróżnienia.') }}</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="liquid-glass rounded-lg overflow-hidden">
                        <button @click="open = !open" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none">
                            <span class="text-white font-medium">{{ __('Jak płatność jest przetwarzana?') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="h-5 w-5 text-blue-400 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 pb-4 text-gray-300">
                            <p>{{ __('Wszystkie płatności są przetwarzane bezpiecznie przez Stripe. Akceptujemy większość kart kredytowych i debetowych. Dane Twojej karty nie są przechowywane na naszych serwerach.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="pricing-card group" data-duration="7" data-price="29.00">
                    <div class="liquid-glass p-6 rounded-xl text-center cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <h3 class="text-xl font-semibold text-white mb-2">7 {{ __('dni') }}</h3>
                        <div class="text-3xl font-bold text-blue-400 mb-2">29 PLN</div>
                        <p class="text-gray-400 text-sm">{{ __('Idealne na start') }}</p>
                    </div>
                </div>
                
                <div class="pricing-card popular group" data-duration="30" data-price="99.00">
                    <div class="liquid-glass p-6 rounded-xl text-center cursor-pointer transition-all duration-300 hover:scale-105 border-2 border-blue-500 shadow-lg shadow-blue-500/20 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/10 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                        <div class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block relative z-10">{{ __('POPULARNE') }}</div>
                        <h3 class="text-xl font-semibold text-white mb-2 relative z-10">30 {{ __('dni') }}</h3>
                        <div class="text-3xl font-bold text-blue-400 mb-2 relative z-10">99 PLN</div>
                        <p class="text-gray-400 text-sm relative z-10">{{ __('Najlepsza wartość') }}</p>
                    </div>
                </div>
                
                <div class="pricing-card group" data-duration="90" data-price="249.00">
                    <div class="liquid-glass p-6 rounded-xl text-center cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <h3 class="text-xl font-semibold text-white mb-2">90 {{ __('dni') }}</h3>
                        <div class="text-3xl font-bold text-blue-400 mb-2">249 PLN</div>
                        <p class="text-gray-400 text-sm">{{ __('Maksymalna ekspozycja') }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <form id="payment-form" action="{{ route('payments.process-feature-profile') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="duration" id="selected-duration">
                <input type="hidden" name="payment_method_id" id="payment-method-id">
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4">{{ __('Szczegóły płatności') }}</h3>
                    <div id="card-element" class="p-4 bg-gray-800/70 backdrop-blur-md rounded-lg border border-gray-700/50 shadow-inner">
                        <!-- Stripe Elements will create form elements here -->
                    </div>
                    <div id="card-errors" role="alert" class="text-red-400 text-sm mt-2"></div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" id="back-btn" class="px-6 py-3 bg-gray-700/80 backdrop-blur-sm text-white rounded-lg hover:bg-gray-600 transition-all duration-300 shadow-md hover:shadow-lg">
                        {{ __('Wstecz') }}
                    </button>
                    <button type="submit" id="submit-payment" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-500 hover:to-blue-600 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-blue-500/30">
                        <span id="button-text">{{ __('Zapłać') }} <span id="payment-amount"></span> PLN</span>
                        <div id="spinner" class="hidden">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                        </div>
                    </button>
                </div>
            </form>

            <!-- Benefits -->
            <div class="mt-12 pt-8 border-t border-gray-700/50">
                <h3 class="text-2xl font-semibold text-white mb-6 text-center">{{ __('Co zyskujesz?') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start space-x-4 group">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 mt-1 group-hover:bg-blue-500/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium mb-1">{{ __('Wyróżnienie na stronie głównej') }}</h4>
                            <p class="text-gray-400 text-sm">{{ __('Twój profil będzie wyświetlany w sekcji wyróżnionych operatorów na stronie głównej.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4 group">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 mt-1 group-hover:bg-blue-500/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium mb-1">{{ __('Wyższa pozycja w wynikach') }}</h4>
                            <p class="text-gray-400 text-sm">{{ __('Twój profil będzie wyświetlany na początku wyników wyszukiwania.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4 group">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 mt-1 group-hover:bg-blue-500/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium mb-1">{{ __('Specjalna odznaka "Wyróżniony"') }}</h4>
                            <p class="text-gray-400 text-sm">{{ __('Twój profil będzie oznaczony specjalną odznaką, która przyciąga uwagę klientów.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4 group">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 mt-1 group-hover:bg-blue-500/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-medium mb-1">{{ __('Zwiększona widoczność portfolio') }}</h4>
                            <p class="text-gray-400 text-sm">{{ __('Twoje portfolio będzie wyświetlane częściej w sekcji polecanych prac.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stripe = Stripe('{{ config("cashier.key") }}');
    const elements = stripe.elements();
    
    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                color: '#ffffff',
                fontFamily: '"Inter", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#9ca3af'
                }
            },
            invalid: {
                color: '#ef4444',
                iconColor: '#ef4444'
            }
        }
    });
    
    cardElement.mount('#card-element');
    
    // Handle pricing card selection
    const pricingCards = document.querySelectorAll('.pricing-card');
    const paymentForm = document.getElementById('payment-form');
    const selectedDurationInput = document.getElementById('selected-duration');
    const paymentAmountSpan = document.getElementById('payment-amount');
    const backBtn = document.getElementById('back-btn');
    
    pricingCards.forEach(card => {
        card.addEventListener('click', function() {
            const duration = this.dataset.duration;
            const price = this.dataset.price;
            
            selectedDurationInput.value = duration;
            paymentAmountSpan.textContent = price;
            
            // Hide pricing cards and show payment form with animation
            const pricingGrid = document.querySelector('.grid');
            pricingGrid.classList.add('opacity-0', 'transform', 'scale-95');
            pricingGrid.style.transition = 'opacity 300ms ease-out, transform 300ms ease-out';
            
            setTimeout(() => {
                pricingGrid.style.display = 'none';
                paymentForm.classList.remove('hidden');
                paymentForm.classList.add('opacity-0', 'transform', 'scale-95');
                
                setTimeout(() => {
                    paymentForm.classList.remove('opacity-0', 'transform', 'scale-95');
                    paymentForm.classList.add('opacity-100', 'transform', 'scale-100');
                    paymentForm.style.transition = 'opacity 300ms ease-in, transform 300ms ease-in';
                }, 10);
            }, 300);
        });
    });
    
    backBtn.addEventListener('click', function() {
        // Show pricing cards and hide payment form with animation
        paymentForm.classList.add('opacity-0', 'transform', 'scale-95');
        paymentForm.style.transition = 'opacity 300ms ease-out, transform 300ms ease-out';
        
        setTimeout(() => {
            paymentForm.classList.add('hidden');
            const pricingGrid = document.querySelector('.grid');
            pricingGrid.style.display = 'grid';
            pricingGrid.classList.add('opacity-0', 'transform', 'scale-95');
            
            setTimeout(() => {
                pricingGrid.classList.remove('opacity-0', 'transform', 'scale-95');
                pricingGrid.classList.add('opacity-100', 'transform', 'scale-100');
            }, 10);
        }, 300);
    });
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-payment');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');
        
        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });
        
        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        } else {
            document.getElementById('payment-method-id').value = paymentMethod.id;
            form.submit();
        }
    });
    
    // Handle card errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
});
</script>
@endsection