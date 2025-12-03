@extends('layouts.app')

@section('title', 'Wyróżnij Zlecenie - SkyReel')

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass p-8 rounded-2xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-4">Wyróżnij Swoje Zlecenie</h1>
                <p class="text-gray-300">Znajdź najlepszych operatorów szybciej</p>
                
                <!-- Job Preview -->
                <div class="liquid-glass p-4 rounded-xl mt-6">
                    <h3 class="text-lg font-semibold text-white">{{ $job->title }}</h3>
                    <p class="text-gray-400 text-sm">{{ $job->location }} • {{ number_format($job->budget, 0, ',', ' ') }} PLN</p>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="pricing-card" data-duration="7" data-price="19.00">
                    <div class="liquid-glass p-6 rounded-xl text-center cursor-pointer transition-all duration-300 hover:scale-105">
                        <h3 class="text-xl font-semibold text-white mb-2">7 dni</h3>
                        <div class="text-3xl font-bold text-blue-400 mb-2">19 PLN</div>
                        <p class="text-gray-400 text-sm">Szybki boost</p>
                    </div>
                </div>
                
                <div class="pricing-card popular" data-duration="30" data-price="69.00">
                    <div class="liquid-glass p-6 rounded-xl text-center cursor-pointer transition-all duration-300 hover:scale-105 border-2 border-blue-500">
                        <div class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">POPULARNE</div>
                        <h3 class="text-xl font-semibold text-white mb-2">30 dni</h3>
                        <div class="text-3xl font-bold text-blue-400 mb-2">69 PLN</div>
                        <p class="text-gray-400 text-sm">Najlepsza wartość</p>
                    </div>
                </div>
                
                <div class="pricing-card" data-duration="90" data-price="179.00">
                    <div class="liquid-glass p-6 rounded-xl text-center cursor-pointer transition-all duration-300 hover:scale-105">
                        <h3 class="text-xl font-semibold text-white mb-2">90 dni</h3>
                        <div class="text-3xl font-bold text-blue-400 mb-2">179 PLN</div>
                        <p class="text-gray-400 text-sm">Długoterminowa ekspozycja</p>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <form id="payment-form" action="{{ route('payments.process-feature-job') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <input type="hidden" name="duration" id="selected-duration">
                <input type="hidden" name="payment_method_id" id="payment-method-id">
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Szczegóły płatności</h3>
                    <div id="card-element" class="p-4 bg-gray-800 rounded-lg border border-gray-700">
                        <!-- Stripe Elements will create form elements here -->
                    </div>
                    <div id="card-errors" role="alert" class="text-red-400 text-sm mt-2"></div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" id="back-btn" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Wstecz
                    </button>
                    <button type="submit" id="submit-payment" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <span id="button-text">Zapłać <span id="payment-amount"></span> PLN</span>
                        <div id="spinner" class="hidden">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                        </div>
                    </button>
                </div>
            </form>

            <!-- Benefits -->
            <div class="mt-8 pt-8 border-t border-gray-700">
                <h3 class="text-xl font-semibold text-white mb-4">Co zyskujesz?</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <span class="text-gray-300">Wyróżnienie na liście zleceń</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <span class="text-gray-300">Wyższa pozycja w wynikach wyszukiwania</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <span class="text-gray-300">Specjalna odznaka "Wyróżnione"</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <span class="text-gray-300">Więcej ofert od operatorów</span>
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
            
            // Hide pricing cards and show payment form
            document.querySelector('.grid').style.display = 'none';
            paymentForm.classList.remove('hidden');
        });
    });
    
    backBtn.addEventListener('click', function() {
        // Show pricing cards and hide payment form
        document.querySelector('.grid').style.display = 'grid';
        paymentForm.classList.add('hidden');
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