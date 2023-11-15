<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Bank;
use App\Models\Contact;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\LedgerAccount;
use App\Models\purchase_invoice;
use App\Models\PurchaseInvoice;
use App\Models\SalesInvoice;
use App\Models\Tax;
use App\Models\Transaction;
use App\Policies\BankPolicy;
use App\Policies\ContactPolicy;
use App\Policies\JournalEntryPolicy;
use App\Policies\JournalPolicy;
use App\Policies\LedgerAccountPolicy;
use App\Policies\purchase_invoicePolicy;
use App\Policies\PurchaseInvoicePolicy;
use App\Policies\SalesInvoicePolicy;
use App\Policies\TaxPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        SalesInvoice::class => SalesInvoicePolicy::class,
        purchase_invoice::class => purchase_invoicePolicy::class,
        PurchaseInvoice::class => PurchaseInvoicePolicy::class,
        LedgerAccount::class => LedgerAccountPolicy::class,
        Tax::class => TaxPolicy::class,
        JournalEntry::class => JournalEntryPolicy::class,
        Contact::class => ContactPolicy::class,
        Journal::class => JournalPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Bank::class => BankPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
