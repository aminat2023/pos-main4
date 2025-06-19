<?php

use App\Http\Controllers\CounterSalesController;
use App\Http\Controllers\DailySalesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomingStockController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductTwoController;
use App\Http\Controllers\SupplyController;
use App\Models\Products;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', fn() => view('welcome'));
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes Only
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
    Route::resource('companies', App\Http\Controllers\CompaniesController::class);
    Route::resource('product', App\Http\Controllers\ProductsController::class);
    Route::resource('products_two', ProductTwoController::class);
    Route::resource('sections', App\Http\Controllers\SectionController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('sub_categories', App\Http\Controllers\SubCategoryController::class);
    Route::resource('section_twos', App\Http\Controllers\SectionTwoController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('incoming_stock', IncomingStockController::class);
    // Route::resource('counter_sales', CounterSalesController::class);
    Route::get('/transactions/history', [App\Http\Controllers\TransactionsController::class, 'history'])->name('transactions.history');

    // Add stock
    Route::get('/products/add-stock', [App\Http\Controllers\ProductsController::class, 'showAddStockForm'])->name('products.addStockForm');
    Route::post('/products/add-stock', [App\Http\Controllers\ProductsController::class, 'addStock'])->name('products.addStock');

    // Incoming Products
    Route::post('/incoming-products', [App\Http\Controllers\ProductsController::class, 'addIncomingProduct'])->name('incoming-products.add');
    Route::get('/incoming-products', fn() => view('incoming', ['products' => Products::all()]))->name('incoming-products.form');
    Route::put('/incoming-product/{id}', [App\Http\Controllers\ProductsController::class, 'updateIncoming'])->name('incoming-product.update');
    Route::delete('/incoming-product/{id}', [App\Http\Controllers\ProductsController::class, 'destroyIncoming'])->name('incoming-product.destroy');
    Route::resource('orders', App\Http\Controllers\OrderController::class);
    // Barcode
    Route::get('barcode', [App\Http\Controllers\ProductsController::class, 'GetProductBarcodes'])->name('products.barcode');

    // Supplies
    Route::get('/supplies/create', [SupplyController::class, 'create'])->name('supplies.create');
    Route::post('/supplies', [SupplyController::class, 'store'])->name('supplies.store');
    Route::get('/supplies', [SupplyController::class, 'index'])->name('supplies.index');

    // Daily Sales
    Route::get('/daily-sales', [DailySalesController::class, 'index'])->name('daily_sales.index');
    Route::get('/daily-sales/{date}', [DailySalesController::class, 'show'])->name('daily_sales.show');
    Route::get('/preferences', [App\Http\Controllers\SystemPreferenceController::class, 'index'])->name('preferences.index');
    Route::post('/preferences', [App\Http\Controllers\SystemPreferenceController::class, 'update'])->name('preferences.update');
});

// Cashier Routes Only
Route::middleware(['auth', 'cashier'])->group(function () {
    Route::resource('counter_sales', CounterSalesController::class);
});
// Both Admin & Cashier
Route::middleware(['auth'])->group(function () {
    Route::resource('order_details', App\Http\Controllers\OrderDetailsController::class);
    Route::resource('sales', PaymentController::class);

    Route::get('/sales_details', [PaymentController::class, 'index'])->name('sales_details.index');
    Route::get('/sales', [PaymentController::class, 'index'])->name('sales.index');
    Route::post('/sales', [PaymentController::class, 'store'])->name('sales.store');

    // Subcategory API
    Route::get('/subcategories/{category}', function ($category) {
        return SubCategory::where('category_id', $category)->get();

    });

    // Fetch Product Name
    Route::get('/products/{id}', [App\Http\Controllers\ProductsController::class, 'fetchProductName'])->name('products.fetchName');

    // Incoming Stock Search
    Route::resource('counter_sales', CounterSalesController::class);
    Route::get('incoming_stock/search', [IncomingStockController::class, 'search'])->name('incoming_stocks.search');
});
