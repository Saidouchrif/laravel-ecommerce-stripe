<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Locales autorisées
     */
    private const ALLOWED_LOCALES = ['fr', 'ar'];

    /**
     * Locale par défaut
     */
    private const DEFAULT_LOCALE = 'fr';

    /**
     * Gérer la locale de l'application
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Récupérer la locale depuis la session
        $locale = session('locale', self::DEFAULT_LOCALE);

        // Vérifier que la locale est autorisée
        if (!in_array($locale, self::ALLOWED_LOCALES)) {
            $locale = self::DEFAULT_LOCALE;
            session(['locale' => $locale]);
        }

        // Définir la locale de l'application
        App::setLocale($locale);

        return $next($request);
    }
}
