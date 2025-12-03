<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        // Try to get products from DB
        try {
            $products = Product::all();
        } catch (\Exception $e) {
            $products = collect([]);
        }

        // Fallback data if DB is empty or migration not run (simulating external dropshipping API)
        if ($products->isEmpty()) {
            $products = collect([
                [
                    'name' => 'DJI Mini 3 Pro',
                    'description' => 'Lekki, składany dron z kamerą 4K/60fps. Idealny dla początkujących i profesjonalistów.',
                    'price' => 3599.00,
                    'image_url' => 'https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=800&q=80',
                    'affiliate_link' => '#', // Placeholder
                    'category' => 'Drony'
                ],
                [
                    'name' => 'Zestaw filtrów ND do Mavica',
                    'description' => 'Profesjonalne filtry ND (ND4, ND8, ND16) dla lepszej kontroli ekspozycji.',
                    'price' => 249.00,
                    'image_url' => 'https://images.unsplash.com/photo-1581557991964-125469da3b8a?auto=format&fit=crop&w=800&q=80',
                    'affiliate_link' => '#',
                    'category' => 'Akcesoria'
                ],
                [
                    'name' => 'Lądowisko dla Drona 75cm',
                    'description' => 'Wodoodporne, składane lądowisko zapewniające bezpieczeństwo podczas startu i lądowania.',
                    'price' => 89.00,
                    'image_url' => 'https://images.unsplash.com/photo-1506947411487-a56738267384?auto=format&fit=crop&w=800&q=80',
                    'affiliate_link' => '#',
                    'category' => 'Akcesoria'
                ],
                [
                    'name' => 'FPV Goggles V2',
                    'description' => 'Gogle FPV zapewniające immersyjne wrażenia z lotu w wysokiej rozdzielczości.',
                    'price' => 2299.00,
                    'image_url' => 'https://images.unsplash.com/photo-1533511024508-251f930e1675?auto=format&fit=crop&w=800&q=80',
                    'affiliate_link' => '#',
                    'category' => 'FPV'
                ],
                [
                    'name' => 'Torba Transportowa Hard Case',
                    'description' => 'Wzmocniona walizka na drona i akcesoria. Odporna na wstrząsy i wilgoć.',
                    'price' => 199.00,
                    'image_url' => 'https://images.unsplash.com/photo-1521405924368-64c5b84bec60?auto=format&fit=crop&w=800&q=80',
                    'affiliate_link' => '#',
                    'category' => 'Akcesoria'
                ],
                [
                    'name' => 'Zestaw Śmigieł Low-Noise',
                    'description' => 'Zapasowe śmigła o obniżonym poziomie hałasu. Zestaw 8 sztuk.',
                    'price' => 59.00,
                    'image_url' => 'https://images.unsplash.com/photo-1504198453619-350711bc023c?auto=format&fit=crop&w=800&q=80',
                    'affiliate_link' => '#',
                    'category' => 'Części'
                ]
            ]);

            // Convert arrays to objects for consistent view handling
            $products = $products->map(function($item) {
                return (object) $item;
            });
        }

        return view('store.index', compact('products'));
    }
}
