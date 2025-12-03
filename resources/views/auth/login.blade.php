@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold">Zaloguj się</h2>
            <p class="mt-2 text-secondary">Lub <a href="{{ route('register') }}" class="text-accent hover:underline">utwórz nowe konto</a></p>
        </div>

        <!-- Google Login Button -->
        <div>
            <a href="{{ route('auth.google') }}" 
               class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Zaloguj się przez Google
            </a>
        </div>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-opacity-20" :class="{ 'border-light-border': !darkMode, 'border-dark-border': darkMode }"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 text-secondary" :class="{ 'bg-light-bg': !darkMode, 'bg-dark-bg': darkMode }">lub</span>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="liquid-glass border border-red-500 border-opacity-50 rounded-lg p-4">
                    <div class="text-red-400 text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium mb-2">Adres email</label>
                <input id="email" name="email" type="email" required 
                       value="{{ old('email') }}"
                       class="input-field w-full" 
                       placeholder="twoj@email.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-2">Hasło</label>
                <input id="password" name="password" type="password" required 
                       class="input-field w-full" 
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-4 w-4 text-accent focus:ring-accent border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-secondary">
                        Zapamiętaj mnie
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="text-accent hover:underline">
                        Zapomniałeś hasła?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-primary w-full">
                    Zaloguj się
                </button>
            </div>
        </form>
    </div>
</div>
@endsection