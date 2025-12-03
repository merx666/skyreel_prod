<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Profile;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Manual authentication check instead of middleware
    }

    /**
     * Public support page (donation) using Stripe Checkout.
     * Accessible to guests.
     */
    public function support()
    {
        return view('support');
    }

    /**
     * Create Stripe Checkout Session for support payment.
     * Amount in PLN provided by user (min 5 PLN, max 5000 PLN).
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:5', 'max:5000'],
        ]);

        $amountPln = (int) $validated['amount'];

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'automatic_payment_methods' => ['enabled' => true],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pln',
                    'product_data' => [
                        'name' => 'Wsparcie SkyReel',
                        'description' => 'Jednorazowe wsparcie działania serwera i rozwoju platformy SkyReel.',
                    ],
                    'unit_amount' => $amountPln * 100,
                ],
                'quantity' => 1,
            ]],
            'success_url' => url('/support/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/support/cancel'),
            'locale' => 'pl',
            'billing_address_collection' => 'auto',
            'allow_promotion_codes' => false,
        ]);

        return redirect()->away($session->url);
    }

    /**
     * Show the payment form for featuring a profile
     */
    public function showFeatureProfile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('error', 'Musisz najpierw utworzyć profil.');
        }

        return view('payments.feature-profile', compact('profile'));
    }

    /**
     * Show the payment form for featuring a job
     */
    public function showFeatureJob(Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($job->client_id !== $user->id) {
            abort(403, 'Nie masz uprawnień do wyróżnienia tego zlecenia.');
        }

        return view('payments.feature-job', compact('job'));
    }

    /**
     * Process payment for featuring a profile
     */
    public function processFeatureProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'duration' => 'required|integer|in:7,30,90', // 7, 30, or 90 days
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('error', 'Musisz najpierw utworzyć profil.');
        }

        // Calculate price based on duration (amounts in cents)
        $prices = [
            7 => 2900,   // 29.00 PLN for 7 days
            30 => 9900,  // 99.00 PLN for 30 days
            90 => 24900, // 249.00 PLN for 90 days
        ];

        $duration = $request->duration;
        $amount = $prices[$duration];
        try {
            $stripe = new StripeClient(config('services.stripe.secret'));

            // Tworzymy Stripe Checkout Session; aktualizacja stanu profilu nastąpi po sukcesie płatności (w metodzie success)
            $session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'automatic_payment_methods' => ['enabled' => true],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pln',
                        'product_data' => [
                            'name' => 'Wyróżnienie profilu',
                            'description' => "Wyróżnienie profilu na {$duration} dni",
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]],
                'success_url' => url('/payments/success?session_id={CHECKOUT_SESSION_ID}&type=feature_profile'),
                'cancel_url' => url('/payments/cancel'),
                'locale' => 'pl',
                'billing_address_collection' => 'auto',
                'allow_promotion_codes' => false,
                'metadata' => [
                    'type' => 'feature_profile',
                    'profile_id' => (string) $profile->id,
                    'duration' => (string) $duration,
                    'user_id' => (string) $user->id,
                ],
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas tworzenia płatności: ' . $e->getMessage());
        }
    }

    /**
     * Process payment for featuring a job
     */
    public function processFeatureJob(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($job->client_id !== $user->id) {
            abort(403, 'Nie masz uprawnień do wyróżnienia tego zlecenia.');
        }

        $request->validate([
            'duration' => 'required|integer|in:7,30,90', // 7, 30, or 90 days
        ]);

        // Calculate price based on duration (amounts in cents)
        $prices = [
            7 => 1900,   // 19.00 PLN for 7 days
            30 => 6900,  // 69.00 PLN for 30 days
            90 => 16900, // 169.00 PLN for 90 days
        ];

        $duration = $request->duration;
        $amount = $prices[$duration];

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));

            // Tworzymy Stripe Checkout Session; aktualizacja stanu zlecenia nastąpi po sukcesie płatności (w metodzie success)
            $session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'automatic_payment_methods' => ['enabled' => true],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pln',
                        'product_data' => [
                            'name' => 'Wyróżnienie zlecenia',
                            'description' => "Wyróżnienie zlecenia na {$duration} dni",
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]],
                'success_url' => url('/payments/success?session_id={CHECKOUT_SESSION_ID}&type=feature_job'),
                'cancel_url' => url('/payments/cancel'),
                'locale' => 'pl',
                'billing_address_collection' => 'auto',
                'allow_promotion_codes' => false,
                'metadata' => [
                    'type' => 'feature_job',
                    'job_id' => (string) $job->id,
                    'duration' => (string) $duration,
                    'user_id' => (string) $user->id,
                ],
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas tworzenia płatności: ' . $e->getMessage());
        }
    }

    /**
     * Payment success page
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $type = $request->query('type');

        if ($sessionId) {
            try {
                $stripe = new StripeClient(config('services.stripe.secret'));
                $session = $stripe->checkout->sessions->retrieve($sessionId);

                if ($session && $session->payment_status === 'paid') {
                    $meta = (array) ($session->metadata ?? []);

                    if ($type === 'feature_profile' && !empty($meta['profile_id']) && !empty($meta['duration']) && !empty($meta['user_id'])) {
                        DB::beginTransaction();
                        try {
                            $profileId = (int) $meta['profile_id'];
                            $duration = (int) $meta['duration'];
                            $userId = (int) $meta['user_id'];

                            $profile = Profile::find($profileId);
                            if ($profile) {
                                $featuredUntil = $profile->featured_until
                                    ? Carbon::parse($profile->featured_until)->addDays($duration)
                                    : Carbon::now()->addDays($duration);

                                $profile->update([
                                    'is_featured' => true,
                                    'featured_until' => $featuredUntil,
                                ]);

                                // Zapisz płatność (amount w PLN)
                                Payment::create([
                                    'user_id' => $userId,
                                    'payable_id' => $profile->id,
                                    'payable_type' => Profile::class,
                                    'stripe_charge_id' => (string) ($session->payment_intent ?? ''),
                                    'amount' => isset($session->amount_total) ? ($session->amount_total / 100) : null,
                                    'currency' => $session->currency ?? 'pln',
                                ]);
                            }
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                        }
                    }

                    if ($type === 'feature_job' && !empty($meta['job_id']) && !empty($meta['duration']) && !empty($meta['user_id'])) {
                        DB::beginTransaction();
                        try {
                            $jobId = (int) $meta['job_id'];
                            $duration = (int) $meta['duration'];
                            $userId = (int) $meta['user_id'];

                            $job = Job::find($jobId);
                            if ($job) {
                                $featuredUntil = $job->featured_until
                                    ? Carbon::parse($job->featured_until)->addDays($duration)
                                    : Carbon::now()->addDays($duration);

                                $job->update([
                                    'is_featured' => true,
                                    'featured_until' => $featuredUntil,
                                ]);

                                // Zapisz płatność (amount w PLN)
                                Payment::create([
                                    'user_id' => $userId,
                                    'payable_id' => $job->id,
                                    'payable_type' => Job::class,
                                    'stripe_charge_id' => (string) ($session->payment_intent ?? ''),
                                    'amount' => isset($session->amount_total) ? ($session->amount_total / 100) : null,
                                    'currency' => $session->currency ?? 'pln',
                                ]);
                            }
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                        }
                    }
                }
            } catch (\Exception $e) {
                // Opcjonalnie logowanie błędu
            }
        }

        return view('payments.success', ['sessionId' => $sessionId]);
    }

    /**
     * Payment cancel page
     */
    public function cancel()
    {
        return view('payments.cancel');
    }

    /**
     * Show user's payment history
     */
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $payments = Payment::where('user_id', $user->id)
            ->with('payable')
            ->latest()
            ->paginate(10);

        return view('payments.history', compact('payments'));
    }

    private function calculatePrice($duration)
    {
        // Calculate price based on duration (amounts in cents)
        $prices = [
            7 => 2900,   // 29.00 PLN for 7 days
            30 => 9900,  // 99.00 PLN for 30 days
            90 => 24900, // 249.00 PLN for 90 days
        ];

        return $prices[$duration] ?? $prices[30];
    }
}
