<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display a listing of the suppliers
    public function index()
    {
        $suppliers = Supplier::all(); // Retrieve all suppliers
        return view('suppliers.index', compact('suppliers')); // Return view with suppliers
    }

    // Show the form for creating a new supplier
    public function create()
    {
        return view('suppliers.create'); // Return create view
    }

    // Store a newly created supplier in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:suppliers',
            'address' => 'nullable|string|max:255',
        ]);

        Supplier::create($request->all()); // Create new supplier

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    // Display the specified supplier
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier')); // Return view with supplier details
    }

    // Show the form for editing the specified supplier
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier')); // Return edit view
    }

    // Update the specified supplier in storage
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:suppliers,email,' . $supplier->id,
            'address' => 'nullable|string|max:255',
        ]);

        $supplier->update($request->all()); // Update supplier details

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    // Remove the specified supplier from storage
    public function destroy(Supplier $supplier)
    {
        $supplier->delete(); // Delete supplier

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
