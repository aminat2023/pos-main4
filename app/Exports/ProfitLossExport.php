<?php

namespace App\Exports;

use App\Http\Controllers\ProfitLossController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class ProfitLossExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $report = ProfitLossController::generateReport($this->from, $this->to);
        return collect($report);
    }

    // Define the header row
    public function headings(): array
    {
        return [
            'Date',
            'Description',
            'Type',
            'Amount (₦)',
        ];
    }

    // Format each row for the export
    public function map($row): array
    {
        return [
            $row['date'],
            $row['description'],
            $row['type'],
            number_format($row['amount'], 2),
        ];
    }
}

