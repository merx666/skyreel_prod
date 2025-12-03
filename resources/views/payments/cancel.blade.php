@extends('layouts.app')

@section('title', 'Płatność Anulowana - SkyReel')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass p-8 rounded-2xl text-center">
            <!-- Cancel Icon -->
            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-white mb-4">Płatność Anulowana</h1>
            <p class="text-gray-300 mb-8">Płatność została anulowana. Możesz spróbować ponownie w każdej chwili.</p>
            
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="block w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Powrót do strony głównej
                </a>
                
                <a href="{{ route('payments.feature-profile') }}" class="block w-full px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Spróbuj ponownie
                </a>
            </div>
        </div>
    </div>
</div>
@endsection