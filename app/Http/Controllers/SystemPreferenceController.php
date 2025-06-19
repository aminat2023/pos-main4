<?php

// app/Http/Controllers/SystemPreferenceController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemPreference;

class SystemPreferenceController extends Controller
{
    public function index()
    {
        $defaults = [
            'business_name' => '',
            'business_logo' => '',
            'currency_symbol' => '₦',
            'receipt_header' => '',
            'receipt_footer' => '',
            'tax_enabled' => '0',
            'tax_percentage' => '0',
            'default_language' => 'English',
            'receipt_format' => '',
            'datetime_format' => 'd/m/Y H:i',
            'auto_logout_time' => '15',
            'allow_discount' => '1',
            'barcode_type' => 'EAN-13',
            'dark_mode' => '0',
        ];
    
        $saved = SystemPreference::pluck('value', 'key')->toArray();
        $preferences = array_merge($defaults, $saved);
    
        return view('preferences.index', compact('preferences'));
    }



    public function update(Request $request)
{
    $data = $request->except('_token');

    if ($request->hasFile('business_logo')) {
        $path = $request->file('business_logo')->store('logos', 'public');
        $data['business_logo'] = $path;
    }

    foreach ($data as $key => $value) {
        SystemPreference::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    return redirect()->back()->with('success', 'Preferences updated successfully.');
}

}
