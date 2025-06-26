<?php

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
            'tax_enabled' => '0',
            'tax_percentage' => '0',
            'default_language' => 'English',
            'receipt_format' => 'Standard',
            'datetime_format' => 'd/m/Y H:i',
            'auto_logout_time' => '15',
            'allow_discount' => '1',
            'barcode_type' => 'Code128',
            'banks' => [], // Initialize banks as an empty array
        ];

        // Retrieve saved preferences from the database
        $saved = SystemPreference::pluck('value', 'key')->toArray();
        $preferences = array_merge($defaults, $saved);

        return view('preferences.index', compact('preferences'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        // Handle banks array
        if (isset($data['banks']) && is_array($data['banks'])) {
            $banks = $data['banks']; // Directly use the banks array from the request

            // Check if new bank details are provided
            if ($request->new_bank_name && $request->new_account_number && $request->new_account_holder_name) {
                $banks[] = [
                    'bank_name' => $request->new_bank_name,
                    'account_number' => $request->new_account_number,
                    'account_holder_name' => $request->new_account_holder_name,
                ];
            }
            $data['banks'] = $banks; // Update the data with the modified banks array
        }

        // Update or create preferences in the database
        foreach ($data as $key => $value) {
            SystemPreference::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }
}
