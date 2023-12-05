<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',
        'link_id',
        'link_type',
        'amount',
        'type',
        'description',
        'timestamp',
        'code',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updated(function (Transaction $transaction) {
            switch ($transaction->link_type) {
                case 'sales_invoice':
                    JournalEntry::create([
                        'ledger_account_id' => $transaction->bank->ledger_account_id,
                        'transaction_id' => $transaction->id,
                        'debit' => $transaction->amount
                    ]);

                    JournalEntry::create([
                        'ledger_account_id' => LedgerAccount::where('name', 'Debiteuren')->firstOrFail()->id,
                        'transaction_id' => $transaction->id,
                        'credit' => $transaction->amount

                    ]);
                    break;
                case 'purchase_invoice':
                    JournalEntry::create([
                        'ledger_account_id' => $transaction->bank->ledger_account_id,
                        'transaction_id' => $transaction->id,
                        'credit' => $transaction->amount
                    ]);

                    JournalEntry::create([
                        'ledger_account_id' => LedgerAccount::where('name', 'Crediteuren')->firstOrFail()->id,
                        'transaction_id' => $transaction->id,
                        'debit' => $transaction->amount
                    ]);
                    break;
                case 'equity':
                    JournalEntry::create([
                        'ledger_account_id' => $transaction->bank->ledger_account_id,
                        'transaction_id' => $transaction->id,
                        'credit' => $transaction->amount
                    ]);

                    JournalEntry::create([
                        'ledger_account_id' => $transaction->link_id,
                        'transaction_id' => $transaction->id,
                        'debit' => $transaction->amount
                    ]);
                    break;
            }
        });
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function journal_entry(): HasOne
    {
        return $this->hasOne(JournalEntry::class,);
    }

    public function link(): bool|HasOne
    {
        switch ($this->link_type) {
            case 'sales_invoice':
            case 'purchase_invoice':
                return $this->hasOne(Invoice::class, 'id', 'link_id')->with('contact');
            case 'equity':
                return $this->hasOne(LedgerAccount::class, 'id', 'link_id');
        }

        return false;
    }
}
