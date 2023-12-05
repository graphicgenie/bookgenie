<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesInvoice extends Invoice
{
    use HasFactory;

    protected $table = 'invoices';
    protected $attributes = ['type' => 'sales_invoice'];
    protected $casts = [
        'invoice_number' => 'integer'
    ];

    public function getFormattedInvoiceNumberAttribute(): string
    {
        return date('Y').substr("0000{$this->invoice_number}", -4);
    }

    public static function nextInvoiceNumber(): int
    {
        $last = SalesInvoice
            ::where('user_id', auth()->user()->id)
            ->where('type', \App\Enums\Invoice::SALES_INVOICE)
            ->whereYear('created_at', Carbon::now()->year)
            ->latest()
            ->first('invoice_number');

        if ($last === null) {
            return 1;
        }

        return $last->invoice_number + 1;
    }

    public static function formattedNextInvoiceNumber(): string
    {
        $n = self::nextInvoiceNumber();
        return date('Y').substr("0000{$n}", -4);
    }
}
