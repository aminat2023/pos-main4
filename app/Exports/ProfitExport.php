<?php

namespace App\Exports;

use App\Models\CounterSalesDetail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProfitExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;
    protected $cashierId;

    public function __construct($from, $to, $cashierId = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->cashierId = $cashierId;
    }

    public function collection()
    {
        $query = CounterSalesDetail::with('user')
            ->whereBetween('created_at', [$this->from . ' 00:00:00', $this->to . ' 23:59:59']);

        if ($this->cashierId) {
            $query->where('user_id', $this->cashierId);
        }

        return $query->orderBy('created_at')->get();
    }

    public function headings(): array
    {
        return ['Date', 'Product', 'Cashier', 'Quantity', 'Profit (₦)'];
    }

    public function map($sale): array
    {
        $profit = $sale->profit ?? (($sale->selling_price - $sale->cost_price) * $sale->quantity);

        return [
            $sale->created_at->format('Y-m-d'),
            $sale->product_name,
            $sale->user->name ?? 'N/A',
            $sale->quantity,
            number_format($profit, 2),
        ];
    }
}
