@extends('layouts.app')

@section('title', 'Kontakt | Skyreel – Zapytania i Wyceny')
@section('description', 'Skontaktuj się ze Skyreel. Zapytaj o dostępność, wycenę i możliwości produkcyjne. Odpowiadamy szybko i konkretnie.')

@section('content')
<main class="container mx-auto px-4 py-12">
  <header class="mb-10">
    <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Kontakt</h1>
    <p class="text-gray-300 max-w-3xl">Napisz do nas, aby omówić projekt. Podaj cel, lokalizację i preferowany termin – przygotujemy propozycję.</p>
  </header>

  <section aria-labelledby="formularz" class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="liquid-glass p-6 rounded-xl">
      <h2 id="formularz" class="text-2xl font-bold text-accent mb-4">Formularz kontaktowy</h2>
      <form action="#" method="POST" class="space-y-4">
        @csrf
        <div>
          <label for="name" class="block text-gray-300 mb-1">Imię i nazwisko</label>
          <input id="name" name="name" type="text" class="input" required />
        </div>
        <div>
          <label for="email" class="block text-gray-300 mb-1">Email</label>
          <input id="email" name="email" type="email" class="input" required />
        </div>
        <div>
          <label for="message" class="block text-gray-300 mb-1">Wiadomość</label>
          <textarea id="message" name="message" rows="5" class="input" required></textarea>
        </div>
        <button type="submit" class="btn-primary">Wyślij</button>
      </form>
    </div>
    <div>
      <h2 class="text-2xl font-bold text-accent mb-4">Lokalizacja</h2>
      <div class="liquid-glass p-6 rounded-xl text-gray-300">
        <p>Skyreel, Polska</p>
        <p>Email: kontakt@skyreel.art</p>
        <p>Godziny: Pon–Pt 9:00–17:00</p>
      </div>
    </div>
  </section>

  <aside class="mt-12">
    <a href="{{ url('/portfolios') }}" class="btn-secondary">Zobacz portfolio</a>
  </aside>
</main>
@endsection