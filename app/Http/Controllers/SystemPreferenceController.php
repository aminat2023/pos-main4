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
        $data = $request->except('_token');

        // Handle business logo upload
        if ($request->hasFile('business_logo')) {
            $file = $request->file('business_logo');
            $path = $file->store('logos', 'public');
            SystemPreference::updateOrCreate(['key' => 'business_logo'], ['value' => $path]);
        }

        // Handle banks array
        if (isset($data['banks']) && is_array($data['banks'])) {
            $data['banks'] = json_encode(array_filter($data['banks']));
        }

        // Save other preferences
        foreach ($data as $key => $value) {
            SystemPreference::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }
}
