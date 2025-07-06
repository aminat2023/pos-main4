<?php



namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\App;


class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Try to get the locale from cookie
        $locale = $request->cookie('app_locale', config('app.locale'));

        // Make sure it's a valid locale
        if (in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}