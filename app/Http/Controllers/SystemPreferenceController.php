<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SystemPreference;

class SystemPreferenceController extends Controller
{
    public function index()
    {
        $defaults = [
            'business_name'     => '',
            'business_logo'     => '',
            'office_address'    => '',
            'currency_symbol'   => '₦',
            'receipt_header'    => 'Thanks for your purchase!',
            'receipt_footer'    => 'Come again!',
            'default_language'  => 'English',
            'dark_mode'         => '0',
            'banks'             => [],
        ];

        $saved = SystemPreference::pluck('value', 'key')->toArray();

        // Safely decode banks
        if (isset($saved['banks']) && is_string($saved['banks'])) {
            $decoded = json_decode($saved['banks'], true);
            $saved['banks'] = is_array($decoded) ? $decoded : [];
        }

        $preferences = array_merge($defaults, $saved);

        return view('preferences.index', compact('preferences'));
    }

    public function update(Request $request)
    {
        $data = $request->all();

        // Save business preferences
        getPreference('business_name', $data['business_name']);
        getPreference('office_address', $data['office_address']);
        getPreference('currency_symbol', $data['currency_symbol']);
        getPreference('receipt_header', $data['receipt_header']);
        getPreference('receipt_footer', $data['receipt_footer']);
        getPreference('dark_mode', $data['dark_mode']);

        // Save business logo
        if ($request->hasFile('business_logo')) {
            $logoPath = $request->file('business_logo')->store('logos', 'public');
            getPreference('business_logo', $logoPath);
        }

        // Save banks (filter out empty entries)
        $banks = array_filter($data['banks'] ?? []);
        getPreference('banks', $banks);

        // Save default language
        $language = $data['default_language'] ?? 'en';
        if (in_array($language, ['en', 'fr'])) {
            getPreference('default_language', $language);
        }

        // Return with success and set the cookie for language preference (1 year)
        return redirect()->back()
            ->with('success', 'Preferences saved successfully.')
            ->withCookie(cookie('app_locale', $language, 60 * 24 * 365)); // 1 year
    }



    
    
}
