<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TikTokViewController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DebugController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// TikTok-style portfolio view
Route::get('/discover', [TikTokViewController::class, 'index'])->name('portfolios.discover');

// Recommendations based on location
Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Health check endpoint
Route::get('/up', function () {
    return response()->json([
        'status' => 'ok',
        'app' => config('app.name'),
        'env' => app()->environment(),
        'time' => now()->toIso8601String(),
    ]);
})->name('health.up')->middleware('throttle:10,1');

// Quick donation redirect (Stripe Payment Link)
Route::get('/donate', function () {
    return redirect()->away('https://buy.stripe.com/dRm4gy5Yd09P61w3dA4gg00');
})->name('donate');

// Public support routes (Stripe Checkout)
Route::get('/support', [PaymentController::class, 'support'])->name('support');
Route::post('/support/checkout', [PaymentController::class, 'checkout'])->name('support.checkout');
Route::get('/support/success', [PaymentController::class, 'success'])->name('support.success');
Route::get('/support/cancel', [PaymentController::class, 'cancel'])->name('support.cancel');

// Legal pages
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('legal.privacy-policy');
Route::get('/terms-of-service', [LegalController::class, 'termsOfService'])->name('legal.terms-of-service');
Route::get('/contact', [LegalController::class, 'contact'])->name('legal.contact');

// Marketing pages (SEO-friendly static content)
Route::view('/uslugi', 'pages.uslugi')->name('pages.uslugi');
Route::view('/o-nas', 'pages.o-nas')->name('pages.o-nas');
Route::view('/kontakt', 'pages.kontakt')->name('pages.kontakt');

// Zmiana języka
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Public portfolio routes
Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');

// Map routes
Route::get('/map', [MapController::class, 'index'])->name('map.index');

// Public job routes
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Public store routes (Dropshipping)
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

// Checkout Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout/{product}', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

// Stripe Webhook
Route::post('/stripe/webhook', [App\Http\Controllers\WebhookController::class, 'handleWebhook'])->name('cashier.webhook');

// Public profile routes
Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
Route::get('/profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');
// Public user profile route by User model (SEO-friendly singular path)
Route::get('/profile/{user}', [ProfileController::class, 'showUserProfile'])->name('profile.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');

// Email verification routes
Route::get('/email/verify', function () {
    // You can customize this view later; for now, reuse a simple notice
    return view('auth.verify-notice');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard')->with('success', __('Adres email został zweryfikowany.'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return back()->with('success', __('Email jest już zweryfikowany.'));
    }
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', __('Link weryfikacyjny został wysłany na Twój adres email.'));
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Google OAuth routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Authenticated routes (logout only, accessible even if email not yet verified)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes requiring verified email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Settings route
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    
    // Portfolio routes (authenticated actions only)
    Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
    
    // Portfolio media management routes
    Route::post('/portfolios/{portfolio}/media', [PortfolioController::class, 'addMedia'])->name('portfolios.media.add');
    Route::delete('/portfolios/{portfolio}/media/{mediaItem}', [PortfolioController::class, 'removeMedia'])->name('portfolios.media.remove');

    // Job routes (authenticated actions only)
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit'); 
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');

    // Job proposal routes
    Route::post('jobs/{job}/proposals', [JobController::class, 'storeProposal'])->name('jobs.proposals.store');
    Route::patch('jobs/{job}/proposals/{proposal}/accept', [JobController::class, 'acceptProposal'])->name('jobs.proposals.accept');
    Route::patch('jobs/{job}/proposals/{proposal}/reject', [JobController::class, 'rejectProposal'])->name('jobs.proposals.reject');
    Route::patch('jobs/{job}/complete', [JobController::class, 'complete'])->name('jobs.complete');

    // Equipment routes
    Route::resource('equipment', EquipmentController::class);

    // Profile routes (authenticated actions only)
    Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('/profiles/{profile}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('/profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');

    // Payment routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/feature-profile', [PaymentController::class, 'showFeatureProfile'])->name('feature-profile');
        Route::post('/feature-profile', [PaymentController::class, 'processFeatureProfile'])->name('process-feature-profile');
        
        Route::get('/feature-job/{job}', [PaymentController::class, 'showFeatureJob'])->name('feature-job');
        Route::post('/feature-job', [PaymentController::class, 'processFeatureJob'])->name('process-feature-job');
        
        Route::get('/success', [PaymentController::class, 'success'])->name('success');
        Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
        Route::get('/history', [PaymentController::class, 'history'])->name('history');
    });

    // Message routes
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::post('/start', [MessageController::class, 'startConversation'])->name('start');
        Route::get('/conversation/{user}', [MessageController::class, 'getMessages'])->name('conversation');
        Route::post('/read/{user}', [MessageController::class, 'markAsRead'])->name('read');
    });

    // Conversation routes
    Route::prefix('conversations')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/create', [ConversationController::class, 'create'])->name('create');
        Route::post('/', [ConversationController::class, 'store'])->name('store');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
        Route::post('/{conversation}/messages', [ConversationController::class, 'storeMessage'])->name('messages.store');
        Route::post('/{conversation}/read', [ConversationController::class, 'markAsRead'])->name('read');
    });

    // Booking routes
    Route::resource('bookings', BookingController::class)->only(['index', 'store']);
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');

    // Availability routes
    Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability.index');
    Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
    Route::delete('/availability/{availability}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');

    // Review routes
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/create', [ReviewController::class, 'create'])->name('create');
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
        Route::get('/{review}/edit', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});

// Blog Routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Debug logging route: restricted to local environment or localhost requests
Route::get('/debug-log', [DebugController::class, 'log'])
    ->name('debug.log')
    ->middleware('throttle:5,1');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});
