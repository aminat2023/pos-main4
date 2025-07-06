<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CounterSalesController;
use App\Http\Controllers\DailySalesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\IncomingStockController;
use App\Http\Controllers\IncomingStockReportController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\MoneyBoxController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductTwoController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\ProfitReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TillWithdrawalController;
use App\Http\Controllers\VaultTransactionController;
use App\Http\Controllers\LoanController;
use App\Models\Products;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoanRepaymentController;



Route::prefix('profit-report')->group(function () {
    Route::get('/', [ProfitReportController::class, 'index'])->name('profit.report.index');
    Route::get('/print', [ProfitReportController::class, 'print'])->name('profit.report.print');
});

Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');


// Home
Route::get('/', fn() => view('welcome'));
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('login', [LoginController::class, 'login']);

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

    Route::get('/unzip-stock', [\App\Http\Controllers\ZipImportController::class, 'unzipFile']);


    Route::get('opening-stock/import', [IncomingStockController::class, 'showImportForm'])->name('opening_stock.import_form');
    Route::post('opening-stock/import', [IncomingStockController::class, 'importOpeningStock'])->name('opening_stock.import');
    Route::get('/opening-stock/manual', [IncomingStockController::class, 'showManualForm'])->name('opening_stock.manual_form');
    Route::post('/opening-stock/manual', [IncomingStockController::class, 'storeManual'])->name('opening_stock.manual.store');
    Route::get('opening-stock/import', [IncomingStockController::class, 'showImportForm'])->name('opening_stock.import_form');
    Route::post('opening-stock/import', [IncomingStockController::class, 'importOpeningStock'])->name('opening_stock.import');
    Route::post('opening-stock/manual', [IncomingStockController::class, 'storeManual'])->name('opening_stock.manual.store');

  

    
    // Public loan application (no login required)
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    
    // Routes only for admins (login and admin middleware required)
    Route::middleware(['auth', 'admin'])->group(function () {
        // View approved loans
        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    
        // View specific loan
        Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    
        // Approve loan
        Route::post('/loans/{id}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    
        // Printable receipt
        Route::get('/loans/{loan}/print', [LoanController::class, 'print'])->name('loans.print');
    
        // Loan repayment form & submission (admin side)
        Route::get('/loans/{loan}/repay', [LoanRepaymentController::class, 'create'])->name('repayments.create');
        Route::post('/loans/{loan}/repay', [LoanRepaymentController::class, 'store'])->name('repayments.store');
    });
    
    
    // Incoming Stock Batch Actions
    Route::post('/incoming-stock/batch-from-supply', [IncomingStockController::class, 'importFromSupplies'])->name('incoming_stock.batch_import');
    Route::get('/incoming-stock/batch-review', [IncomingStockController::class, 'reviewBatch'])->name('incoming_stock.review_batch');
    Route::post('/incoming-stock/batch-submit', [IncomingStockController::class, 'submitBatch'])->name('incoming_stock.submit_batch');
    Route::get('opening-stock/import', [IncomingStockController::class, 'showImportForm'])->name('opening_stock.import_form');
    Route::post('opening-stock/import', [IncomingStockController::class, 'importOpeningStock'])->name('opening_stock.import');
    // For importing supplies into stock
    Route::get('incoming-stock/import-from-supplies', [IncomingStockController::class, 'importFromSupplies'])->name('incoming_stock.import_from_supplies');



   



       // System Preferences (includes language)
       Route::get('/preferences', [App\Http\Controllers\SystemPreferenceController::class, 'index'])->name('preferences.index');
       Route::post('/preferences', [App\Http\Controllers\SystemPreferenceController::class, 'update'])->name('preferences.update');
       Route::post('/preferences/language', [App\Http\Controllers\SystemPreferenceController::class, 'setLanguage'])->name('preferences.language');
   

    // Add stock
    Route::get('/products/add-stock', [App\Http\Controllers\ProductsController::class, 'showAddStockForm'])->name('products.addStockForm');
    Route::post('/products/add-stock', [App\Http\Controllers\ProductsController::class, 'addStock'])->name('products.addStock');

    // Incoming Products
    Route::post('/incoming-products', [App\Http\Controllers\ProductsController::class, 'addIncomingProduct'])->name('incoming-products.add');
    Route::get('/incoming-products', fn() => view('incoming', ['products' => Products::all()]))->name('incoming-products.form');
    Route::put('/incoming-product/{id}', [App\Http\Controllers\ProductsController::class, 'updateIncoming'])->name('incoming-product.update');

    Route::get('/product/search', [IncomingStockController::class, 'search'])->name('product.search');
    Route::delete('/incoming-product/{id}', [App\Http\Controllers\ProductsController::class, 'destroyIncoming'])->name('incoming-product.destroy');
    Route::resource('orders', App\Http\Controllers\OrderController::class);
    // Barcode
    Route::get('barcode', [App\Http\Controllers\ProductsController::class, 'GetProductBarcodes'])->name('products.barcode');

    // routes/web.php
    Route::get('/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->middleware('auth');
    Route::get('/user-activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])
        ->middleware('auth')
        ->name('user.activity.logs');

    // Supplies
    Route::get('/supplies/create', [SupplyController::class, 'create'])->name('supplies.create');
    Route::post('/supplies', [SupplyController::class, 'store'])->name('supplies.store');
    Route::get('/supplies', [SupplyController::class, 'index'])->name('supplies.index');

    // Daily Sales
    Route::get('/daily-sales', [DailySalesController::class, 'index'])->name('daily_sales.index');
    Route::get('/daily-sales/{date}', [DailySalesController::class, 'show'])->name('daily_sales.show');
    Route::get('/preferences', [App\Http\Controllers\SystemPreferenceController::class, 'index'])->name('preferences.index');
    Route::post('/preferences', [App\Http\Controllers\SystemPreferenceController::class, 'update'])->name('preferences.update');

    // Show withdrawal form
    Route::get('/till/withdraw', [TillWithdrawalController::class, 'create'])->name('till.withdraw.create');

    // Handle withdrawal submission
    Route::post('/till/withdraw', [TillWithdrawalController::class, 'store'])->name('till.withdraw.store');

    // View all withdrawals
    Route::get('/till/withdrawals', [TillWithdrawalController::class, 'index'])->name('till.withdraw.index');
    // routes/web.php

    Route::get('/sales-reports', [SalesReportController::class, 'index'])->name('sales.reports');
    Route::get('/reports/sales-by-cashier', [SalesReportController::class, 'index'])->name('reports.sales_by_cashier');
    Route::get('/sales-report/export', [ReportController::class, 'export'])->name('sales.report.export');
    Route::get('/sales-report/print', [SalesReportController::class, 'print'])->name('sales.report.print');
    Route::middleware(['auth'])->group(function () {
        Route::get('/reports/counter-sales', [ReportController::class, 'counterSalesReport'])->name('reports.counter_sales');

        Route::get('/reports/counter-sales/export', [ReportController::class, 'export'])->name('reports.counter_sales.export');
    });

    Route::get('/expense-report', [ExpenseReportController::class, 'index'])->name('expense.report');
    Route::get('/expense-repor/print', [ExpenseReportController::class, 'print'])->name('expense.report.print');
    Route::get('/expense-report/export', [ExpenseReportController::class, 'export'])->name('expense.report.export');
    Route::get('/reports/profit-loss', [ProfitLossController::class, 'index'])->name('reports.profit_loss');

    Route::get('/profit-loss', [ProfitLossController::class, 'index'])->name('profit_loss.index');
    Route::get('/profit-loss/receipt', [ProfitLossController::class, 'receipt'])->name('profit_loss.receipt');
    Route::get('/profit-loss/export/pdf', [ProfitLossController::class, 'exportPdf'])->name('profit_loss.pdf');
    Route::get('/profit-loss/export/excel', [ProfitLossController::class, 'exportExcel'])->name('profit_loss.excel');

    Route::get('/profit-loss/report', [ProfitLossController::class, 'print'])->name('profit_loss.print');
    Route::get('/profit-loss/print', [ProfitLossController::class, 'print'])->name('profit_loss.print');
    Route::get('/profit-loss/generate', [ProfitLossController::class, 'generate'])->name('profit_loss.generate');
    Route::get('/profit-loss/export/pdf', [ProfitLossController::class, 'exportPdf'])->name('profit_loss.pdf');
    Route::get('/profit-loss/export/excel', [ProfitLossController::class, 'exportExcel'])->name('profit_loss.excel');

    Route::get('/profit-loss/export/pdf', [ProfitLossController::class, 'exportPdf'])->name('profit_loss.exportPdf');
    Route::get('/profit-loss/export/excel', [ProfitLossController::class, 'exportExcel'])->name('profit_loss.exportExcel');

    Route::get('reports/profit', [ProfitReportController::class, 'index'])->name('profit.index');
    Route::get('reports/profit/print', [ProfitReportController::class, 'print'])->name('profit.print');
    Route::get('reports/profit/pdf', [ProfitReportController::class, 'exportPdf'])->name('profit.exportPdf');
    Route::get('reports/profit/excel', [ProfitReportController::class, 'exportExcel'])->name('profit.exportExcel');

    Route::get('/reports/profit', [ProfitReportController::class, 'index'])->name('profit.report.index');
    Route::get('/reports/profit/print', [ProfitReportController::class, 'print'])->name('profit.report.print');

    Route::get('/incoming-stock-report', [IncomingStockReportController::class, 'index'])->name('incoming_stock.report.index');
    Route::get('/incoming-stock-report/print', [IncomingStockReportController::class, 'print'])->name('incoming_stock.report.print');
});
Route::get('reports/incoming-stock', [IncomingStockReportController::class, 'index'])->name('incoming_stock.report.index');
Route::get('reports/incoming-stock/print', [IncomingStockReportController::class, 'print'])->name('incoming_stock.report.print');
Route::get('reports/incoming-stock/pdf', [IncomingStockReportController::class, 'exportPdf'])->name('incoming_stock.report.pdf');
Route::get('reports/incoming-stock/excel', [IncomingStockReportController::class, 'exportExcel'])->name('incoming_stock.report.excel');

Route::prefix('supplier-payments')->name('supplier_payments.')->group(function () {
    Route::get('create', [SupplierPaymentController::class, 'create'])->name('create');
    Route::post('store', [SupplierPaymentController::class, 'store'])->name('store');
    Route::get('invoice/{id}', [SupplierPaymentController::class, 'showInvoice'])->name('invoice');
});

// Route::get('/supplier-payments/create', [SupplierPaymentController::class, 'create'])->name('supplier_payments.create');
// Route::get('/supplier-payments/create', [SupplierPaymentController::class, 'create'])->name('supplier_payments.create');
Route::post('/supplier-payments/store', [SupplierPaymentController::class, 'store'])->name('supplier_payments.store');
Route::get('/supplier-payments/invoice/{supply_id}', [SupplierPaymentController::class, 'invoice'])->name('supplier_payments.invoice');

Route::get('/supplier-payments/create/{supply_id}', [SupplierPaymentController::class, 'create'])->name('supplier_payments.create');

Route::middleware(['auth'])->prefix('vault')->group(function () {
    Route::get('in', [VaultTransactionController::class, 'showVaultInForm'])->name('vault.in');
    Route::get('out', [VaultTransactionController::class, 'showVaultOutForm'])->name('vault.out');
    Route::post('store', [VaultTransactionController::class, 'store'])->name('vault.store');
});
Route::get('/vault/report', [VaultTransactionController::class, 'report'])->name('vault.report');

Route::middleware(['auth'])->group(function () {
    Route::get('/journal', [JournalEntryController::class, 'index'])->name('journal.index');
    Route::get('/journal/create', [JournalEntryController::class, 'create'])->name('journal.create');
    Route::post('/journal/store', [JournalEntryController::class, 'store'])->name('journal.store');
});
Route::get('/reports/ledger', [JournalEntryController::class, 'ledger'])->name('journal.ledger');
Route::get('/reports/journal', [JournalEntryController::class, 'report'])->name('journal.report');
Route::get('/reports/trial-balance', [JournalEntryController::class, 'trialBalance'])->name('journal.trial_balance');
Route::get('/journal-two', [\App\Http\Controllers\JournalEntryTwoController::class, 'index'])->name('journal-two.index');

Route::get('/moneybox', [MoneyBoxController::class, 'index'])->name('moneybox.index');
Route::post('/moneybox/deposit', [MoneyBoxController::class, 'deposit'])->name('moneybox.deposit');
Route::post('/moneybox/withdraw', [MoneyBoxController::class, 'withdraw'])->name('moneybox.withdraw');

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
