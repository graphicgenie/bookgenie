<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LedgerAccount extends Model
{
    use HasFactory;

    public const NON_CURRENT_ASSETS = 'non_current_assets';
    public const CURRENT_ASSETS = 'current_assets';
    public const EQUITY = 'equity';
    public const PROVISION = 'provision';
    public const NON_CURRENT_LIABILITIES = 'non_current_liabilities';
    public const CURRENT_LIABILITIES = 'current_liabilities';
    public const REVENUE = 'revenue';
    public const EXPENSES = 'expenses';
    public const DEBIT = 'debit';
    public const CREDIT = 'credit';

    protected $fillable = [
        'name',
        'type',
        'account_type',
        'parent_id',
        'user_id'
    ];

    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getTotalAttribute(): float
    {
        if ($this->account_type === LedgerAccount::DEBIT) {
            return $this->journalEntries()->sum('debit') - $this->journalEntries()->sum('credit');
        }

        return $this->journalEntries()->sum('credit') - $this->journalEntries()->sum('debit');
    }
}
