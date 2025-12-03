@extends('layouts.app')

@section('title', 'O nas | Skyreel – Zespół, Sprzęt, Misja')
@section('description', 'Poznaj Skyreel: kim jesteśmy, jak pracujemy i jakim sprzętem latamy. Nasza misja to odpowiedzialne i kreatywne historie z powietrza.')

@section('content')
<main class="container mx-auto px-4 py-12">
  <header class="mb-12">
    <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">O Skyreel</h1>
    <p class="text-gray-300 max-w-3xl">Jesteśmy zespołem licencjonowanych pilotów i filmowców. Łączymy rzemiosło filmowe z nowoczesną technologią lotniczą.</p>
  </header>

  <section aria-labelledby="misja" class="mb-12">
    <h2 id="misja" class="text-2xl font-bold text-accent mb-4">Misja</h2>
    <p class="text-gray-300 max-w-3xl">Tworzyć bezpieczne i efektowne ujęcia lotnicze, które opowiadają historie marek, miejsc i wydarzeń. Dbamy o etykę pracy, bezpieczeństwo i jakość finalnego materiału.</p>
  </section>

  <section aria-labelledby="zespol" class="mb-12">
    <h2 id="zespol" class="text-2xl font-bold text-accent mb-4">Zespół</h2>
    <ul class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <li class="liquid-glass p-6 rounded-xl">
        <h3 class="text-white font-semibold mb-2">Pilot / Operator</h3>
        <p class="text-gray-300">Licencjonowany pilot, odpowiada za planowanie lotów i realizację ujęć zgodnie z przepisami.</p>
      </li>
      <li class="liquid-glass p-6 rounded-xl">
        <h3 class="text-white font-semibold mb-2">Reżyser / Montażysta</h3>
        <p class="text-gray-300">Tworzy narrację wizualną i dba o spójność projektu na etapie postprodukcji.</p>
      </li>
    </ul>
  </section>

  <section aria-labelledby="sprzet" class="mb-12">
    <h2 id="sprzet" class="text-2xl font-bold text-accent mb-4">Sprzęt</h2>
    <ul class="list-disc list-inside space-y-2 text-gray-300">
      <li>Drony filmowe 4K/6K ze stabilizacją gimbala.</li>
      <li>Filtry ND/PL, monitor podglądu, kontrola ekspozycji.</li>
      <li>Systemy bezpieczeństwa i procedury checklist.</li>
    </ul>
  </section>

  <aside class="mt-16">
    <a href="{{ route('pages.kontakt') }}" class="btn-primary">Skontaktuj się z nami</a>
  </aside>
</main>
@endsection