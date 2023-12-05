<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Company */
class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'vat_number' => $this->vat_number,
            'coc_number' => $this->coc_number,
            'email' => $this->email,
            'type' => $this->type,
            'iban' => $this->iban,
            'iban_name' => $this->iban_name,
            'vat_liable' => $this->vat_liable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
