<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with this Google ID
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                Auth::login($user);
                return redirect()->intended('/dashboard');
            }
            
            // Check if user exists with this email
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // Link Google account to existing user
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                ]);
                
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            }
            
            // Create new user
            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'role' => 'client', // Default role
                'email_verified_at' => now(),
            ]);
            
            // Create profile for new user
            $newUser->profile()->create([
                'profile_picture_url' => $googleUser->getAvatar(),
            ]);
            
            Auth::login($newUser);
            
            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect('/login')->with('error', 'Wystąpił błąd podczas logowania przez Google: ' . $e->getMessage());
        }
    }

    /**
     * Show login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:operator,client',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Create profile for new user
        $user->profile()->create();

        Auth::login($user);

        // Send verification email and redirect to notice
        try {
            if (method_exists($user, 'sendEmailVerificationNotification')) {
                $user->sendEmailVerificationNotification();
            }
        } catch (\Throwable $e) {
            // Log but don't block registration
            Log::warning('Failed to send verification email: '.$e->getMessage());
        }

        return redirect()->route('verification.notice')
            ->with('success', __('Na Twój adres email został wysłany link weryfikacyjny. Sprawdź skrzynkę.'));
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Podane dane logowania są nieprawidłowe.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}