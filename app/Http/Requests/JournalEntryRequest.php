<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ledger_account_id' => ['required', 'integer'],
            'invoice_id' => ['nullable', 'integer'],
            'amount' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
