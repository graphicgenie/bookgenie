<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseInvoice extends Invoice
{
    use HasFactory;

    protected $table = 'invoices';
    protected $attributes = ['type' => 'purchase_invoice'];

    protected static function booted(): void
    {
        static::created(function (Invoice $invoice) {
//            Journal::create([
//                'invoice_id' => $invoice->id,
//                'ledger_account_id' => LedgerAccount::where('name', 'Kosten')->first()->id,
//                'price' => $invoice->price,
//            ]);
//
//            Journal::create([
//                'invoice_id' => $invoice->id,
//                'ledger_account_id' => LedgerAccount::where('name', 'Te ontvangen BTW')->first()->id,
//                'price' => $invoice->price / 100 * 21,
//            ]);
//
//            Journal::create([
//                'invoice_id' => $invoice->id,
//                'ledger_account_id' => LedgerAccount::where('name', 'Crediteuren')->first()->id,
//                'price' => $invoice->price * 1.21,
//            ]);
        });
    }
}
