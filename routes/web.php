<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LedgerAccountController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UploadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', function () {

//    $start = Carbon::parse('2023-11-20');
//    $end = Carbon::parse('2023-11-22');
//
//    dd(
//        LedgerAccount::where('type', 'current_assets')
//            ->dateBetween($start, $end)
//            ->where('id', 1)
//            ->first()
//    );

//    $parser = new Mt940();
//    foreach ($parser->parse(Storage::get('bank2.sta'), new Mt940\Engine\Bunq()) as $key => $statement) {
//        $transactions = $statement->getTransactions();
//        foreach ($transactions as $transaction) {
//            Transaction::create([
//                'user_id' => auth()->user()->id,
//                'bank_id' => 1,
//                'amount' => $transaction->getPrice(),
//                'type' => $transaction->getDebitCredit(),
//                'description' => $transaction->getDescription(),
//                'timestamp' => $transaction->getValueTimestamp(),
//                'code' => $transaction->getTransactionCode()
//            ]);
//        }
//    }
});

Route::get('/', function () {

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    Route::get('/balance_sheet', BalanceController::class)->name('balance-sheet');
    Route::get('/profit_loss', ProfitLossController::class)->name('profit-loss');
    Route::get('/settings', SettingsController::class)->name('settings');
    Route::get('/contact-search', [ContactController::class, 'search'])->name('contact.search');
    Route::get('/transaction-search', [TransactionController::class, 'search'])->name('transaction.search');
    Route::get('/download/{upload}', [UploadController::class, 'download'])->name('download');

    Route::resource('sales_invoices', SalesInvoiceController::class);
    Route::resource('purchase_invoices', PurchaseInvoiceController::class);
    Route::resource('ledger_accounts', LedgerAccountController::class);
    Route::resource('journal', JournalController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('company', CompanyController::class);

});