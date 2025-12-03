@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12">
    <h1 class="text-3xl font-bold mb-6">Wesprzyj SkyReel</h1>
    <p class="mb-6">Pomóż utrzymać serwer i rozwijać platformę. Wybierz kwotę lub wpisz własną.</p>

    <div class="grid grid-cols-2 gap-4 mb-8">
        @foreach ([10, 25, 50, 100] as $preset)
            <form method="POST" action="{{ route('support.checkout') }}">
                @csrf
                <input type="hidden" name="amount" value="{{ $preset }}">
                <button class="btn-primary w-full">Wpłać {{ $preset }} PLN</button>
            </form>
        @endforeach
    </div>

    <form method="POST" action="{{ route('support.checkout') }}" class="flex items-center gap-3">
        @csrf
        <label for="amount" class="sr-only">Własna kwota</label>
        <input id="amount" name="amount" type="number" min="5" step="1" placeholder="Własna kwota (PLN)" class="input w-40" required>
        <button class="btn-primary">Wpłać</button>
    </form>

    <div class="mt-8">
        <a href="https://buy.stripe.com/dRm4gy5Yd09P61w3dA4gg00" target="_blank" rel="noopener noreferrer" class="btn-secondary">Szybkie wsparcie (Stripe Payment Link)</a>
        <p class="text-sm text-secondary mt-2">Ten przycisk otwiera bezpośredni link do Stripe — działa natychmiast.</p>
    </div>

    @error('amount')
        <div class="mt-4 text-red-500 text-sm">{{ $message }}</div>
    @enderror
</div>
@endsection