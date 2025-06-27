<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalEntryTwoController extends Controller
{
    public function index()
    {
        $reference = 'AGJ-' . str_pad(JournalEntry::max('id') + 1, 6, '0', STR_PAD_LEFT);

        // Decode stored bank preferences
        $banksJson = DB::table('system_preferences')->where('key', 'banks')->value('value');
        $banks = json_decode($banksJson, true);
        if (!is_array($banks)) $banks = [];

        return view('journal_two.index', compact('reference', 'banks'));
    }
}
