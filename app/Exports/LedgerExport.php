<?php
namespace App\Exports;

use App\Models\JournalEntry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LedgerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return JournalEntry::select('date', 'account', 'bank_name', 'description', 'debit', 'credit')
            ->orderBy('date')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return ['Date', 'Account', 'Bank Name', 'Description', 'Debit', 'Credit'];
    }
}
