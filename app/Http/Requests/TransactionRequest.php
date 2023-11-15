<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bank_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'type' => ['required'],
            'description' => ['required'],
            'timestamp' => ['required', 'date'],
            'code' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
