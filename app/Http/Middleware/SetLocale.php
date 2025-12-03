<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if language is provided in URL parameter
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            
            // Validate locale
            if (in_array($locale, ['pl', 'en'])) {
                Session::put('locale', $locale);
                App::setLocale($locale);
            }
        } else {
            // Use session locale if available
            $locale = Session::get('locale', config('app.locale'));
            App::setLocale($locale);
        }

        return $next($request);
    }
}