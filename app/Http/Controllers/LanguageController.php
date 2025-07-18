<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
{
    if (in_array($locale, ['en', 'fr'])) {
        App::setLocale($locale);

        // Set cookie for 1 year
        return redirect()->back()->withCookie(cookie('app_locale', $locale, 60 * 24 * 365));
    }

    return redirect()->back();
}
}
