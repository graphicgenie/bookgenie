<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }

    public function uploads(): HasMany
    {
        return $this->hasMany(Upload::class, 'model_id', 'id')
            ->where('model_type', \App\Enums\Invoice::PURCHASE_INVOICE);
    }

    public function transactions(): hasMany
    {
        return $this->hasMany(Transaction::class, 'link_id', 'id')
            ->whereIn('link_type', \App\Enums\Invoice::cases());
    }

    public function getPriceInclVatAttribute(): float
    {
        $total = 0.00;

        foreach ($this->invoiceDetails as $detail) {
            $total += $detail->priceInclVat;
        }

        return $total;
    }
}
