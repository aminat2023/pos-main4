<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Import Request for handling incoming requests
use App\Models\SubCategory; // Import the SubCategory model
use App\Http\Controllers\ProductController; // Import the ProductController
use App\Http\Controllers\PaymentController;
use App\Models\Products;
use App\Http\Livewire\PaymentCounter;
use App\Http\Controllers\ProductTwoController;
use App\Http\Controllers\IncomingStockController;
use App\Http\Controllers\CounterSalesController;
use App\Http\Controllers\DailySalesController;
use App\Http\Controllers\ExpenseController;

Route::resource('products_two', ProductTwoController::class);


/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Home route after authentication
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/daily-sales', [DailySalesController::class, 'index'])->name('daily_sales.index');
Route::get('/daily-sales/{date}', [DailySalesController::class, 'show'])->name('daily_sales.show');

// Resource routes for various controllers
Route::resource('suppliers', App\Http\Controllers\SuppliersController::class);
Route::resource('order_details', App\Http\Controllers\OrderDetailsController::class);
Route::resource('orders', App\Http\Controllers\OrderController::class);
Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('companies', App\Http\Controllers\CompaniesController::class);
Route::resource('product', App\Http\Controllers\ProductsController::class);
Route::resource('sections', App\Http\Controllers\SectionController::class);
Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::resource('sub_categories', App\Http\Controllers\SubCategoryController::class);
Route::resource('section_twos', App\Http\Controllers\SectionTwoController::class);
Route::resource('sales', App\Http\Controllers\PaymentController::class,);
Route::resource('expenses', ExpenseController::class);


// Barcode generation route
Route::get('barcode', [App\Http\Controllers\ProductsController::class, 'GetProductBarcodes'])->name('products.barcode');

// Transaction history route
Route::get('/transactions/history', [App\Http\Controllers\TransactionsController::class, 'history'])->name('transactions.history');

// Add stock routes
Route::get('/products/add-stock', [App\Http\Controllers\ProductsController::class, 'showAddStockForm'])->name('products.addStockForm');
Route::post('/products/add-stock', [App\Http\Controllers\ProductsController::class, 'addStock'])->name('products.addStock');

// Fetch subcategories based on category ID
Route::get('/subcategories/{category}', function ($category) {
    return SubCategory::where('category_id', $category)->get();
});

// Fetch product name by ID
Route::get('/products/{id}', [App\Http\Controllers\ProductsController::class, 'fetchProductName'])->name('products.fetchName');

// Route for adding incoming products
Route::post('/incoming-products', [App\Http\Controllers\ProductsController::class, 'addIncomingProduct'])->name('incoming-products.add');
Route::get('/incoming-products', function () {
    $products = Products::all(); // Fetch all products from the database
    return view('incoming', compact('products')); // Pass the products to the view
})->name('incoming-products.form');




// Route for updating incoming products
Route::put('/incoming-product/{id}', [App\Http\Controllers\ProductsController::class, 'updateIncoming'])->name('incoming-product.update');

// Route for deleting incoming products
Route::delete('/incoming-product/{id}', [App\Http\Controllers\ProductsController::class, 'destroyIncoming'])->name('incoming-product.destroy');




Route::get('/payment-counter', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.counter',);
Route::get('/sales_details', [PaymentController::class, 'index'])->name('sales_details.index');
Route::get('/sales', [PaymentController::class, 'index'])->name('sales.index');
Route::post('/sales', [PaymentController::class, 'store'])->name('sales.store');



Route::resource('incoming_stock', IncomingStockController::class);
Route::get('incoming_stock/search', [IncomingStockController::class, 'search'])->name('incoming_stocks.search');



Route::resource('counter_sales', CounterSalesController::class);