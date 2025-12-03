@extends('layouts.app')

@section('title', __('Zweryfikuj swój adres email'))
@section('description', __('Aby uzyskać pełny dostęp do funkcji SkyReel, zweryfikuj proszę swój adres email.'))

@section('content')
<div class="container mx-auto max-w-3xl py-12 px-4">
    <div class="bg-secondary rounded-lg p-6 shadow">
        <h1 class="text-2xl font-bold mb-4">{{ __('Zweryfikuj swój adres email') }}</h1>
        <p class="text-sm text-gray-300 mb-6">
            {{ __('Zanim uzyskasz pełny dostęp do konta, kliknij w link weryfikacyjny wysłany na Twój adres email. Jeśli wiadomość nie dotarła, możesz wysłać ponownie.') }}
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="flex items-center gap-3">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Wyślij ponownie link weryfikacyjny') }}
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('Przejdź do panelu') }}</a>
        </form>
    </div>
    <div class="mt-8 text-sm text-gray-400">
        <p>{{ __('Jeśli podałeś nieprawidłowy email, zaktualizuj go w ustawieniach profilu po zalogowaniu.') }}</p>
    </div>
@endsection