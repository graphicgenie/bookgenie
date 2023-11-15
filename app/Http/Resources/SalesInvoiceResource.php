<?php

namespace App\Http\Resources;

use App\Models\Contact;
use App\Models\InvoiceDetail;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SalesInvoice */
class SalesInvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contact' => ContactResource::make(
                Contact::where('id', $this->contact_id)->firstOrFail()
            ),
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'invoice_number' => $this->invoice_number,
            'invoice_details' => InvoiceDetailResource::collection(
                InvoiceDetail::where('invoice_id', $this->id)->get()
            ),
            'total' => $this->priceInclVat,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}