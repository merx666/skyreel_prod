@extends('layouts.app')

@section('title', 'Historia Płatności - SkyReel')

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass p-8 rounded-2xl">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-white">Historia Płatności</h1>
                <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Powrót
                </a>
            </div>

            @if($payments->count() > 0)
                <div class="space-y-4">
                    @foreach($payments as $payment)
                        <div class="liquid-glass p-6 rounded-xl">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-white">
                                            @if($payment->payable_type === 'App\Models\Profile')
                                                Wyróżnienie Profilu
                                            @else
                                                Wyróżnienie Zlecenia
                                            @endif
                                        </h3>
                                        <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">
                                            Opłacone
                                        </span>
                                    </div>
                                    
                                    <div class="text-gray-400 text-sm space-y-1">
                                        <p>Data: {{ $payment->created_at->format('d.m.Y H:i') }}</p>
                                        <p>ID transakcji: {{ $payment->stripe_charge_id }}</p>
                                        @if($payment->payable_type === 'App\Models\Job' && $payment->payable)
                                            <p>Zlecenie: {{ $payment->payable->title }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-white">
                                        {{ number_format($payment->amount, 2, ',', ' ') }} {{ strtoupper($payment->currency) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                    <div class="mt-8">
                        {{ $payments->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Brak płatności</h3>
                    <p class="text-gray-400 mb-6">Nie masz jeszcze żadnych płatności w historii.</p>
                    
                    <div class="space-x-4">
                        <a href="{{ route('payments.feature-profile') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Wyróżnij Profil
                        </a>
                        @if(auth()->user()->role === 'client')
                            <a href="{{ route('jobs.index') }}" class="inline-block px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                Moje Zlecenia
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection