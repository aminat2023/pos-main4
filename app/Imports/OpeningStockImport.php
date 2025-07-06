<?php

namespace App\Imports;

use App\Models\ProductTwo;
use App\Models\IncomingStock;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OpeningStockImport implements ToModel, WithHeadingRow
{
    /**
     * Convert each row into a Product and link to opening stock
     */
    public function model(array $row)
    {
        // Skip if mandatory fields are missing
        if (empty($row['product_name']) || empty($row['quantity'])) {
            return null;
        }

        // Generate a unique product code
        $code = strtoupper(Str::random(8));

        // 1️⃣ Create product
        $product = ProductTwo::create([
            'product_code'   => $code,
            'product_name'   => $row['product_name'],
            'section'        => $row['section'] ?? null,
            'category'       => $row['category'] ?? null,
            'cost_price'     => $row['cost_price'] ?? 0,
            'selling_price'  => $row['selling_price'] ?? 0,
        ]);

        // 2️⃣ Add stock entry linked to this product
        IncomingStock::create([
            'product_code'   => $code,
            'product_name'   => $product->product_name,
            'quantity'       => $row['quantity'],
            'cost_price'     => $row['cost_price'] ?? 0,
            'selling_price'  => $row['selling_price'] ?? 0,
            'total_stock'    => $row['quantity'],
            'batch_date'     => now(),
        ]);

        return $product;
    }
}
