@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">Sklep dla Operatorów</h1>
        <p class="text-xl text-gray-300">Najlepszy sprzęt i akcesoria do Twoich lotów. Wyselekcjonowane oferty.</p>
    </div>

    <!-- Dropshipping Partner Banner -->
    <div class="mb-12 rounded-xl overflow-hidden relative shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-900 to-blue-900 opacity-90"></div>
        <div class="relative p-8 md:p-12 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 md:mr-8 text-left">
                <h2 class="text-2xl font-bold text-white mb-2">Chcesz zacząć własny biznes dronowy?</h2>
                <p class="text-gray-200">
                    Nasz system rekomenduje platformę <span class="font-bold text-yellow-400">AutoDS</span> do dropshippingu części i akcesoriów dronowych.
                    Automatyzuj zamówienia i zarabiaj na swojej pasji.
                </p>
            </div>
            <a href="#" class="btn-primary whitespace-nowrap px-8 py-3 text-lg">
                Dowiedz się więcej
            </a>
        </div>
    </div>

    <!-- Filter/Categories (Visual only for now) -->
    <div class="flex overflow-x-auto space-x-4 mb-8 pb-2 scrollbar-hide">
        <button class="px-6 py-2 rounded-full bg-accent text-white font-medium shadow-lg shadow-accent/50">Wszystkie</button>
        <button class="px-6 py-2 rounded-full liquid-glass text-gray-300 hover:text-white hover:bg-white/10 transition">Drony</button>
        <button class="px-6 py-2 rounded-full liquid-glass text-gray-300 hover:text-white hover:bg-white/10 transition">Akcesoria</button>
        <button class="px-6 py-2 rounded-full liquid-glass text-gray-300 hover:text-white hover:bg-white/10 transition">FPV</button>
        <button class="px-6 py-2 rounded-full liquid-glass text-gray-300 hover:text-white hover:bg-white/10 transition">Części</button>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="group liquid-glass rounded-xl overflow-hidden hover:scale-[1.02] transition-all duration-300 border border-white/10 hover:border-accent/50">
            <!-- Image -->
            <div class="aspect-w-4 aspect-h-3 bg-gray-800 relative overflow-hidden">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-2 right-2">
                    <span class="px-2 py-1 text-xs font-bold rounded bg-black/60 text-white backdrop-blur-sm">
                        {{ $product->category }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-5">
                <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $product->name }}</h3>
                <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-xl font-bold text-white">{{ number_format($product->price, 2) }} zł</span>
                    @auth
                        <form action="{{ route('checkout', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary text-sm py-2 px-4 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Kup teraz
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary text-sm py-2 px-4 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Kup teraz
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
