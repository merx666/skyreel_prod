@extends('layouts.app')

@section('title', 'Polityka Prywatności')

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass rounded-2xl p-8 mb-8">
            <h1 class="text-4xl font-bold text-white mb-6">Polityka Prywatności</h1>
            <p class="text-gray-300 text-lg">Ostatnia aktualizacja: 3 listopada 2023</p>
        </div>

        <div class="liquid-glass rounded-2xl p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">1. Wprowadzenie</h2>
                <p class="text-gray-300 leading-relaxed">
                    SkyReel ("my", "nasze" lub "nas") obsługuje stronę internetową https://skyreel.art ("Usługa"). Ta strona informuje o naszych zasadach dotyczących zbierania, używania i ujawniania danych osobowych podczas korzystania z naszej Usługi oraz o wyborach, które masz w związku z tymi danymi.
                </p>
            </section>

            <!-- Information We Collect -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">2. Informacje, które zbieramy</h2>
                
                <h3 class="text-xl font-medium text-blue-400 mb-3">2.1 Dane osobowe</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Podczas rejestracji konta zbieramy:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2 mb-6">
                    <li>Imię i nazwisko oraz adres e-mail</li>
                    <li>Informacje profilowe (biografia, lokalizacja, strona internetowa)</li>
                    <li>Zawartość portfolio (zdjęcia, filmy, opisy)</li>
                    <li>Informacje o płatnościach (przetwarzane bezpiecznie przez Stripe)</li>
                </ul>

                <h3 class="text-xl font-medium text-blue-400 mb-3">2.2 Dane użytkowania</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Automatycznie zbieramy informacje o tym, jak korzystasz z naszej Usługi:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>Adres IP i informacje o przeglądarce</li>
                    <li>Odwiedzone strony i czas spędzony w naszej Usłudze</li>
                    <li>Informacje o urządzeniu i systemie operacyjnym</li>
                    <li>Źródła odsyłające</li>
                </ul>
            </section>

            <!-- Google Analytics -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">3. Google Analytics</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Używamy Google Analytics do analizy ruchu użytkowników na naszej stronie. Google Analytics zbiera informacje takie jak:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2 mb-6">
                    <li>Strony, które odwiedzasz i czas spędzony na każdej stronie</li>
                    <li>Twoje interakcje z treścią</li>
                    <li>Przybliżona lokalizacja geograficzna</li>
                    <li>Urządzenie i informacje o przeglądarce</li>
                </ul>
                <p class="text-gray-300 leading-relaxed">
                    Możesz zrezygnować z Google Analytics, wyłączając Google Analytics w ustawieniach przeglądarki lub korzystając z oficjalnego dodatku do przeglądarki Google Analytics Opt-out.
                </p>
            </section>

            <!-- Cookies -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('4. Cookies and Tracking Technologies') }}</h2>
                
                <h3 class="text-xl font-medium text-blue-400 mb-3">{{ __('4.1 Essential Cookies') }}</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    {{ __('These cookies are necessary for the Service to function properly:') }}
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2 mb-6">
                    <li>{{ __('Session cookies for user authentication') }}</li>
                    <li>{{ __('CSRF protection tokens') }}</li>
                    <li>{{ __('Language preferences') }}</li>
                </ul>

                <h3 class="text-xl font-medium text-blue-400 mb-3">4.2 Analityczne pliki cookie</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Z Twoją zgodą używamy plików cookie do analizy ruchu na stronie i poprawy naszej Usługi.
                </p>
                
                <h3 class="text-xl font-medium text-blue-400 mb-3">4.3 Zarządzanie plikami cookie</h3>
                <p class="text-gray-300 leading-relaxed">
                    Możesz zarządzać swoimi preferencjami dotyczącymi plików cookie za pomocą naszego banera zgody na pliki cookie lub ustawień przeglądarki.
                </p>
            </section>

            <!-- Data Security -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">5. Bezpieczeństwo danych</h2>
                <p class="text-gray-300 leading-relaxed">
                    Bezpieczeństwo Twoich danych jest dla nas priorytetem. Wdrażamy odpowiednie środki bezpieczeństwa, aby chronić Twoje dane osobowe przed nieautoryzowanym dostępem, zmianą, ujawnieniem lub zniszczeniem. Wszystkie dane przesyłane między Twoją przeglądarką a naszą Usługą są szyfrowane za pomocą protokołu SSL.
                </p>
            </section>

            <!-- Your Rights -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">6. Twoje prawa</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Zgodnie z przepisami o ochronie danych, masz prawo do:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>Dostępu do swoich danych osobowych</li>
                    <li>Poprawiania swoich danych osobowych</li>
                    <li>Usunięcia swoich danych osobowych</li>
                    <li>Ograniczenia przetwarzania swoich danych osobowych</li>
                    <li>Przenoszenia swoich danych osobowych</li>
                    <li>Sprzeciwu wobec przetwarzania swoich danych osobowych</li>
                </ul>
            </section>

            <!-- Contact Us -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">7. Kontakt</h2>
                <p class="text-gray-300 leading-relaxed">
                    Jeśli masz jakiekolwiek pytania dotyczące tej Polityki Prywatności, skontaktuj się z nami pod adresem: <a href="mailto:privacy@skyreel.art" class="text-blue-400 hover:underline">privacy@skyreel.art</a>
                </p>
            </section>

            <!-- Data Security -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('8. Data Security') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet is 100% secure.') }}
                </p>
            </section>

            <!-- Data Retention -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('9. Data Retention') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('We retain your personal data only for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required by law.') }}
                </p>
            </section>

            <!-- Children's Privacy -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('10. Children\'s Privacy') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('Our Service is not intended for children under 16 years of age. We do not knowingly collect personal data from children under 16.') }}
                </p>
            </section>

            <!-- Changes to Policy -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('11. Changes to This Privacy Policy') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.') }}
                </p>
            </section>

            <!-- Contact -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('12. Contact Us') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('If you have any questions about this Privacy Policy, please contact us at:') }}
                </p>
                <div class="mt-4 p-4 bg-gray-800 rounded-lg">
                    <p class="text-gray-300">
                        <strong>{{ __('Email:') }}</strong> skyreel.art@gmail.com<br>
                        <strong>{{ __('Website:') }}</strong> https://skyreel.art
                    </p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection