<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transaction */
class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'bank_id' => $this->bank_id,
            'amount' => $this->amount,
            'type' => $this->type,
            'description' => $this->description,
            'timestamp' => $this->timestamp,
            'code' => $this->code,
            'link_type' => $this->link_type,
            'journal_entry' => $this->journal_entry?->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->link_type) {
            $data['link'] = $this->link;
        }

        return $data;
    }
}
