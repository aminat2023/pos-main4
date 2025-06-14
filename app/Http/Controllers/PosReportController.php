<?php

// app/Http/Controllers/PosReportController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Transactions;
use Barryvdh\DomPDF\Facade as PDF;  // Ensure you have installed the PDF package

class PosReportController extends Controller
{


    public function index()
{
    $orders = Order::all();  // Get all orders (or use another query if necessary)
    
    return view('orders.index', [
        'orders' => $orders,  // Pass the orders to the view
    ]);
}


public function show($orderId)
{
    $order = Order::findOrFail($orderId);  // Fetch the specific order
    return view('orders.show', compact('order'));  // Pass the order to the view
}

    // Method to generate the POS report
    public function generate($orderId)
    {
        // Fetch the order along with related order details and transaction
        $order = Order::with(['orderDetails.product', 'transactions'])->findOrFail($orderId);
        $orderDetails = $order->orderDetails;  // All products in the order
        $totalAmount = $orderDetails->sum('amount');  // Total amount for the order
        $transaction = $order->transactions->first();  // Assuming one transaction per order

        // Pass data to the view for PDF generation
        $pdf = PDF::loadView('reports.pos_report', [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'totalAmount' => $totalAmount,
            'transaction' => $transaction
        ]);

        // Generate the PDF and return it as a download
        return $pdf->download('POS_Report_' . $orderId . '.pdf');
    }
}

