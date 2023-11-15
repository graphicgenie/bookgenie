<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Contact */
class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'coc' => $this->coc,
            'phone' => $this->phone,
            'email' => $this->email,
            'invoice_email' => $this->invoice_email,
            'invoice_att' => $this->invoice_att,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'country' => $this->country,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
