<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\MediaItem;
use App\Models\Job;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample operators
        $operator1 = User::create([
            'name' => 'Michał Kowalski',
            'email' => 'michal.kowalski@example.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'email_verified_at' => now(),
        ]);

        $operator2 = User::create([
            'name' => 'Anna Nowak',
            'email' => 'anna.nowak@example.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'email_verified_at' => now(),
        ]);

        $operator3 = User::create([
            'name' => 'Piotr Wiśniewski',
            'email' => 'piotr.wisniewski@example.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'email_verified_at' => now(),
        ]);

        // Create sample clients
        $client1 = User::create([
            'name' => 'Firma ABC Sp. z o.o.',
            'email' => 'kontakt@firmabc.pl',
            'password' => Hash::make('password'),
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        $client2 = User::create([
            'name' => 'Event Studio',
            'email' => 'info@eventstudio.pl',
            'password' => Hash::make('password'),
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        // Create profiles for operators
        $profile1 = Profile::create([
            'user_id' => $operator1->id,
            'location' => 'Warszawa, Polska',
            'bio' => 'Profesjonalny operator dronów z 5-letnim doświadczeniem. Specjalizuję się w filmowaniu eventów, nieruchomości i krajobrazów. Posiadam wszystkie wymagane certyfikaty i ubezpieczenie.',
            'website_url' => 'https://michalkowalski-drones.pl',
            'is_featured' => true,
            'featured_until' => now()->addDays(30),
        ]);

        $profile2 = Profile::create([
            'user_id' => $operator2->id,
            'location' => 'Kraków, Polska',
            'bio' => 'Kreatywna filmowiec specjalizująca się w ujęciach ślubnych i reklamowych. Łączę tradycyjne techniki filmowe z nowoczesnymi możliwościami dronów.',
            'website_url' => 'https://annanowak-aerial.com',
            'is_featured' => false,
        ]);

        $profile3 = Profile::create([
            'user_id' => $operator3->id,
            'location' => 'Gdańsk, Polska',
            'bio' => 'Specjalista od ujęć przemysłowych i inspekcji. Oferuję usługi mapowania, monitoringu budów i inspekcji infrastruktury.',
            'website_url' => null,
            'is_featured' => false,
        ]);

        // Create portfolios for operators
        $portfolio1 = Portfolio::create([
            'user_id' => $operator1->id,
            'title' => 'Profesjonalne ujęcia z drona',
            'description' => 'Kolekcja moich najlepszych prac obejmująca eventy, nieruchomości i krajobrazy.',
            'slug' => 'michal-kowalski-portfolio',
        ]);

        $portfolio2 = Portfolio::create([
            'user_id' => $operator2->id,
            'title' => 'Filmowanie ślubne z powietrza',
            'description' => 'Magiczne momenty uchwycone z perspektywy ptaka. Specjalizacja w filmowaniu ślubów i eventów.',
            'slug' => 'anna-nowak-weddings',
        ]);

        $portfolio3 = Portfolio::create([
            'user_id' => $operator3->id,
            'title' => 'Inspekcje i mapowanie',
            'description' => 'Profesjonalne usługi inspekcyjne i mapowanie terenów z wykorzystaniem najnowszych technologii.',
            'slug' => 'piotr-wisniewski-industrial',
        ]);

        // Create media items for portfolios
        MediaItem::create([
            'portfolio_id' => $portfolio1->id,
            'type' => 'video',
            'source_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
            'title' => 'Event firmowy - ujęcia z drona',
            'description' => 'Profesjonalne filmowanie eventu firmowego z wykorzystaniem drona DJI Mavic 3.',
        ]);

        MediaItem::create([
            'portfolio_id' => $portfolio1->id,
            'type' => 'image',
            'source_url' => '/storage/portfolio/sample-real-estate.jpg',
            'thumbnail_url' => '/storage/portfolio/sample-real-estate-thumb.jpg',
            'title' => 'Nieruchomość - widok z lotu ptaka',
            'description' => 'Ujęcie nieruchomości prezentujące całą działkę i otoczenie.',
        ]);

        MediaItem::create([
            'portfolio_id' => $portfolio2->id,
            'type' => 'video',
            'source_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
            'thumbnail_url' => 'https://img.youtube.com/vi/jNQXAC9IVRw/maxresdefault.jpg',
            'title' => 'Ślub w plenerze - trailer',
            'description' => 'Romantyczny trailer ślubny z ujęciami z drona.',
        ]);

        MediaItem::create([
            'portfolio_id' => $portfolio3->id,
            'type' => 'image',
            'source_url' => '/storage/portfolio/industrial-inspection.jpg',
            'thumbnail_url' => '/storage/portfolio/industrial-inspection-thumb.jpg',
            'title' => 'Inspekcja mostu',
            'description' => 'Szczegółowa inspekcja konstrukcji mostowej z wykorzystaniem drona.',
        ]);

        // Create sample job listings
        Job::create([
            'client_id' => $client1->id,
            'title' => 'Filmowanie eventu firmowego',
            'description' => 'Poszukujemy operatora drona do sfilmowania eventu firmowego. Event odbędzie się w Warszawie, planowane ujęcia z powietrza podczas prezentacji produktu na świeżym powietrzu. Wymagane doświadczenie w filmowaniu eventów.',
            'location' => 'Warszawa',
            'budget' => 2500.00,
            'status' => 'open',
            'is_featured' => true,
            'featured_until' => now()->addDays(15),
        ]);

        Job::create([
            'client_id' => $client2->id,
            'title' => 'Ujęcia ślubne z drona',
            'description' => 'Szukamy doświadczonego operatora do sfilmowania ceremonii ślubnej w plenerze. Ślub odbędzie się w malowniczej lokalizacji pod Krakowem. Potrzebne ujęcia ceremonii oraz sesji plenerowej.',
            'location' => 'Kraków',
            'budget' => 1800.00,
            'status' => 'open',
            'is_featured' => false,
        ]);

        Job::create([
            'client_id' => $client1->id,
            'title' => 'Mapowanie terenu budowy',
            'description' => 'Potrzebujemy precyzyjnego mapowania terenu budowy oraz dokumentacji postępu prac. Teren o powierzchni około 5 hektarów, wymagane doświadczenie w mapowaniu i fotogrametrii.',
            'location' => 'Gdańsk',
            'budget' => 3200.00,
            'status' => 'open',
            'is_featured' => false,
        ]);
    }
}
