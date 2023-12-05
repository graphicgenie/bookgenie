<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'account_number',
        'ledger_account_id'
    ];

    public function ledgerAccount(): HasOne
    {
        return $this->HasOne(LedgerAccount::class, 'id', 'ledger_account_id');
    }

}
