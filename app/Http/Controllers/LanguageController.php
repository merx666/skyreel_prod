<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Zmienia język aplikacji.
     *
     * @param  Request  $request
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLanguage(Request $request, $locale)
    {
        // Sprawdź czy język jest obsługiwany
        if (!in_array($locale, ['en', 'pl'])) {
            $locale = 'pl'; // Domyślny język
        }

        // Ustaw język w sesji
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Przekieruj z powrotem na poprzednią stronę
        return redirect()->back();
    }
}