<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'tax_id',
        'amount',
        'price',
        'invoice_id',
        'ledger_account_id',
        'row_order',
    ];

    protected static function booted(): void
    {
        static::created(function (InvoiceDetail $invoiceDetail) {
            $vat_percentage = Tax::where('id', $invoiceDetail->tax_id)->firstOrFail()->percentage;
            $vat = ($invoiceDetail->price / 100) * $vat_percentage;

            switch ($invoiceDetail->invoice->type) {
                case \App\Enums\Invoice::SALES_INVOICE:
                    JournalEntry::create([
                        'invoice_id' => $invoiceDetail->invoice->id,
                        'ledger_account_id' => $invoiceDetail->ledger_account_id,
                        'credit' => $invoiceDetail->price,
                    ]);

                    JournalEntry::create([
                        'invoice_id' => $invoiceDetail->invoice->id,
                        'ledger_account_id' => LedgerAccount::where('name', 'Te betalen BTW')->first()->id,
                        'debit' => -1 * abs($vat),
                    ]);

                    JournalEntry::create([
                        'invoice_id' => $invoiceDetail->invoice->id,
                        'ledger_account_id' => LedgerAccount::where('name', 'Debiteuren')->first()->id,
                        'debit' => $invoiceDetail->price + $vat,
                    ]);
                    break;
                case \App\Enums\Invoice::PURCHASE_INVOICE:
                    JournalEntry::create([
                        'invoice_id' => $invoiceDetail->invoice->id,
                        'ledger_account_id' => $invoiceDetail->ledger_account_id,
                        'credit' => $invoiceDetail->price,
                    ]);

                    JournalEntry::create([
                        'invoice_id' => $invoiceDetail->invoice->id,
                        'ledger_account_id' => LedgerAccount::where('name', 'Te ontvangen BTW')->first()->id,
                        'debit' => $vat,
                    ]);

                    JournalEntry::create([
                        'invoice_id' => $invoiceDetail->invoice->id,
                        'ledger_account_id' => LedgerAccount::where('name', 'Crediteuren')->first()->id,
                        'credit' => $invoiceDetail->price + $vat,
                    ]);
                    break;
            }
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function tax(): hasOne
    {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }

    public function getPriceInclVatAttribute(): float
    {
        return $this->price + ($this->price * ($this->tax->percentage / 100));
    }
}
