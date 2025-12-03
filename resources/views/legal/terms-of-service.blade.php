@extends('layouts.app')

@section('title', 'Regulamin Serwisu')

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass rounded-2xl p-8 mb-8">
            <h1 class="text-4xl font-bold text-white mb-6">Regulamin Serwisu</h1>
            <p class="text-gray-300 text-lg">Ostatnia aktualizacja: 3 listopada 2023</p>
        </div>

        <div class="liquid-glass rounded-2xl p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">1. Akceptacja Warunków</h2>
                <p class="text-gray-300 leading-relaxed">
                    Korzystając z serwisu SkyReel ("Serwis"), prowadzonego przez SkyReel ("my", "nas" lub "nasz"), akceptujesz i zgadzasz się przestrzegać warunków niniejszej umowy. Jeśli nie zgadzasz się z powyższymi warunkami, prosimy o niekorzystanie z tego serwisu.
                </p>
            </section>

            <!-- Service Description -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">2. Opis Usługi</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    SkyReel to platforma marketplace łącząca operatorów dronów z klientami poszukującymi usług fotografii i wideografii lotniczej. Nasza Usługa obejmuje:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>Tworzenie i zarządzanie portfolio dla operatorów dronów</li>
                    <li>System publikowania ofert pracy i składania propozycji</li>
                    <li>Bezpieczne przetwarzanie płatności</li>
                    <li>Narzędzia komunikacji między klientami a operatorami</li>
                    <li>System recenzji i ocen</li>
                </ul>
            </section>

            <!-- User Accounts -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">3. Konta Użytkowników</h2>
                
                <h3 class="text-xl font-medium text-blue-400 mb-3">3.1 Rejestracja Konta</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Aby korzystać z niektórych funkcji naszego Serwisu, musisz zarejestrować konto. Zgadzasz się:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2 mb-6">
                    <li>Podać dokładne i kompletne informacje</li>
                    <li>Dbać o bezpieczeństwo danych dostępowych do konta</li>
                    <li>Aktualizować swoje dane w razie potrzeby</li>
                    <li>Ponosić odpowiedzialność za wszystkie działania wykonywane na Twoim koncie</li>
                </ul>

                <h3 class="text-xl font-medium text-blue-400 mb-3">3.2 Typy Kont</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Oferujemy dwa rodzaje kont:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li><strong>Konta Operatorów:</strong> Dla operatorów dronów oferujących usługi</li>
                    <li><strong>Konta Klientów:</strong> Dla osób prywatnych lub firm poszukujących usług dronowych</li>
                </ul>
            </section>

            <!-- User Conduct -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">4. Zasady Korzystania</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Zobowiązujesz się nie używać Serwisu do:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>Naruszania obowiązujących przepisów prawa</li>
                    <li>Naruszania praw własności intelektualnej</li>
                    <li>Publikowania fałszywych, wprowadzających w błąd lub oszukańczych treści</li>
                    <li>Nękania, obrażania lub krzywdzenia innych użytkowników</li>
                    <li>Spamowania lub wysyłania niechcianych wiadomości</li>
                    <li>Prób uzyskania nieautoryzowanego dostępu do naszych systemów</li>
                    <li>Używania zautomatyzowanych narzędzi do dostępu do Serwisu</li>
                </ul>
            </section>

            <!-- Operator Responsibilities -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">5. Obowiązki Operatora Drona</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Jako operator drona, zobowiązujesz się do:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>Posiadania wszystkich niezbędnych licencji i certyfikatów</li>
                    <li>Przestrzegania wszystkich przepisów lotniczych</li>
                    <li>Utrzymywania odpowiedniego ubezpieczenia</li>
                    <li>Dostarczania dokładnych informacji o swoich usługach i sprzęcie</li>
                    <li>Świadczenia usług zgodnie z ustaleniami z klientami</li>
                    <li>Poszanowania prywatności i praw własności</li>
                </ul>
            </section>

            <!-- Client Responsibilities -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">6. Obowiązki Klienta</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Jako klient, zobowiązujesz się do:
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>{{ __('Provide accurate job descriptions and requirements') }}</li>
                    <li>{{ __('Obtain necessary permissions for filming locations') }}</li>
                    <li>{{ __('Pay agreed-upon fees in a timely manner') }}</li>
                    <li>{{ __('Communicate clearly with operators') }}</li>
                    <li>{{ __('Respect intellectual property rights of delivered content') }}</li>
                </ul>
            </section>

            <!-- Payments and Fees -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('7. Payments and Fees') }}</h2>
                
                <h3 class="text-xl font-medium text-blue-400 mb-3">{{ __('7.1 Service Fees') }}</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    {{ __('SkyReel charges fees for certain services:') }}
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2 mb-6">
                    <li>{{ __('Featured portfolio listings') }}</li>
                    <li>{{ __('Featured job postings') }}</li>
                    <li>{{ __('Transaction processing fees') }}</li>
                </ul>

                <h3 class="text-xl font-medium text-blue-400 mb-3">{{ __('7.2 Payment Processing') }}</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    {{ __('Payments are processed securely through Stripe. By using our payment services, you agree to Stripe\'s terms of service.') }}
                </p>

                <h3 class="text-xl font-medium text-blue-400 mb-3">{{ __('7.3 Refunds') }}</h3>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('Refunds are handled on a case-by-case basis. Service fees are generally non-refundable unless required by law.') }}
                </p>
            </section>

            <!-- Intellectual Property -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('8. Intellectual Property') }}</h2>
                
                <h3 class="text-xl font-medium text-blue-400 mb-3">{{ __('8.1 User Content') }}</h3>
                <p class="text-gray-300 leading-relaxed mb-4">
                    {{ __('You retain ownership of content you upload to the Service. By uploading content, you grant us a non-exclusive license to display, distribute, and promote your content on our platform.') }}
                </p>

                <h3 class="text-xl font-medium text-blue-400 mb-3">{{ __('8.2 Platform Rights') }}</h3>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('The SkyReel platform, including its design, functionality, and code, is owned by us and protected by intellectual property laws.') }}
                </p>
            </section>

            <!-- Privacy -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('9. Privacy') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the Service, to understand our practices.') }}
                </p>
            </section>

            <!-- Disclaimers -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('10. Disclaimers') }}</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    {{ __('The Service is provided "as is" without warranties of any kind. We disclaim all warranties, express or implied, including:') }}
                </p>
                <ul class="list-disc list-inside text-gray-300 space-y-2">
                    <li>{{ __('Merchantability and fitness for a particular purpose') }}</li>
                    <li>{{ __('Accuracy, reliability, or completeness of content') }}</li>
                    <li>{{ __('Uninterrupted or error-free operation') }}</li>
                    <li>{{ __('Security of data transmission') }}</li>
                </ul>
            </section>

            <!-- Limitation of Liability -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('11. Limitation of Liability') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('To the maximum extent permitted by law, SkyReel shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including loss of profits, data, or use, arising from your use of the Service.') }}
                </p>
            </section>

            <!-- Indemnification -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('12. Indemnification') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('You agree to indemnify and hold harmless SkyReel from any claims, damages, or expenses arising from your use of the Service, violation of these terms, or infringement of any rights of another party.') }}
                </p>
            </section>

            <!-- Termination -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('13. Termination') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('We may terminate or suspend your account and access to the Service at our sole discretion, without prior notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties.') }}
                </p>
            </section>

            <!-- Governing Law -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('14. Governing Law') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('These Terms shall be governed by and construed in accordance with the laws of Poland, without regard to its conflict of law provisions.') }}
                </p>
            </section>

            <!-- Changes to Terms -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('15. Changes to Terms') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('We reserve the right to modify these Terms at any time. We will notify users of significant changes by posting a notice on our website or sending an email notification.') }}
                </p>
            </section>

            <!-- Contact -->
            <section>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('16. Contact Information') }}</h2>
                <p class="text-gray-300 leading-relaxed">
                    {{ __('If you have any questions about these Terms of Service, please contact us at:') }}
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