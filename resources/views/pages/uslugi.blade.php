@extends('layouts.app')

@section('title', 'Usługi | Profesjonalne Wideo z Drona – Skyreel')
@section('description', 'Kompleksowe usługi wideofilmowania z drona: nieruchomości, eventy, marketing. Zespół Skyreel dostarcza bezpieczne, zgodne z przepisami produkcje lotnicze.')

@section('content')
<main class="container mx-auto px-4 py-12">
  <header class="mb-12">
    <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Usługi</h1>
    <p class="text-gray-300 max-w-3xl">Specjalizujemy się w profesjonalnych realizacjach wideo z drona. Każdy projekt realizujemy zgodnie z przepisami i najlepszymi praktykami bezpieczeństwa.</p>
  </header>

  <section aria-labelledby="jak-dzialamy" class="mb-16">
    <h2 id="jak-dzialamy" class="text-2xl font-bold text-accent mb-4">Jak działamy?</h2>
    <ol class="list-decimal list-inside space-y-2 text-gray-300">
      <li>Brief i cele – wspólnie definiujemy oczekiwany efekt oraz KPI.</li>
      <li>Planowanie ujęć – przygotowujemy bezpieczny plan lotów i ujęć.</li>
      <li>Realizacja – operujemy sprzętem klasy Pro, dbając o jakość i bezpieczeństwo.</li>
      <li>Postprodukcja – montaż, kolor, dźwięk, napisy i finalny eksport.</li>
    </ol>
  </section>

  <section aria-labelledby="dlaczego-my" class="mb-16">
    <h2 id="dlaczego-my" class="text-2xl font-bold text-accent mb-4">Dlaczego my?</h2>
    <ul class="list-disc list-inside space-y-2 text-gray-300">
      <li>Doświadczenie w produkcjach komercyjnych i eventowych.</li>
      <li>Licencjonowani piloci, ubezpieczenie OC i zgodność z przepisami.</li>
      <li>Sprzęt filmowy 4K/6K, stabilne ujęcia i profesjonalny montaż.</li>
      <li>Terminowość i czytelna komunikacja na każdym etapie projektu.</li>
    </ul>
  </section>

  <section aria-labelledby="nieruchomosci" class="mb-12">
    <h2 id="nieruchomosci" class="text-xl md:text-2xl font-bold text-white mb-2">Wideo dla Nieruchomości</h2>
    <p class="text-gray-300 max-w-3xl">Tworzymy filmy prezentujące inwestycje i oferty sprzedaży. Dynamiczne ujęcia z drona podkreślają skalę i lokalizację, a płynny montaż i muzyka wzmacniają przekaz. Idealne dla deweloperów, biur nieruchomości i właścicieli.</p>
  </section>

  <section aria-labelledby="eventy" class="mb-12">
    <h2 id="eventy" class="text-xl md:text-2xl font-bold text-white mb-2">Relacje z Eventów</h2>
    <p class="text-gray-300 max-w-3xl">Dokumentujemy wydarzenia z unikalnej perspektywy. Ujęcia tłumu, sceny i otoczenia pozwalają oddać atmosferę eventu. Działamy dyskretnie, dbając o bezpieczeństwo uczestników.</p>
  </section>

  <section aria-labelledby="marketing" class="mb-12">
    <h2 id="marketing" class="text-xl md:text-2xl font-bold text-white mb-2">Dynamiczne Ujęcia Marketingowe</h2>
    <p class="text-gray-300 max-w-3xl">Produkujemy spoty i klipy promocyjne dla marek. Łączymy ujęcia lotnicze z materiałami z ziemi, tworząc dynamiczne filmy, które angażują odbiorców w social media i kampaniach performance.</p>
  </section>

  <aside class="mt-16">
    <a href="{{ url('/portfolios') }}" class="btn-primary">Zobacz nasze realizacje</a>
  </aside>
</main>
@endsection