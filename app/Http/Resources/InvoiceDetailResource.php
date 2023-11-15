<?php

namespace App\Http\Resources;

use App\Models\InvoiceDetail;
use App\Models\LedgerAccount;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin InvoiceDetail */
class InvoiceDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'tax_id' => TaxResource::make(Tax::where('id', $this->tax_id)->firstOrFail()),
            'amount' => $this->amount,
            'price' => $this->price,
            'invoice_id' => $this->invoice_id,
            'ledger_account_id' => LedgerAccountResource::make(
                LedgerAccount::where('id', $this->ledger_account_id)->firstOrFail()
            ),
            'totalInclVat' => $this->priceInclVat,
            'row_order' => $this->row_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
