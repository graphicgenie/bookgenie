<?php

namespace App\Models;

use App\Http\Resources\InvoiceDetailResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    protected $guarded = [];

    public const SALES_INVOICE = 'sales_invoice';
    public const PURCHASE_INVOICE = 'purchase_invoice';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
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
