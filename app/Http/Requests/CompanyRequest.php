<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'address' => ['required'],
            'postcode' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
            'vat_number' => ['nullable', 'integer'],
            'coc_number' => ['nullable', 'integer'],
            'email' => ['nullable', 'email', 'max:254'],
            'type' => ['required'],
            'iban' => ['required'],
            'iban_name' => ['required'],
            'vat_liable' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
