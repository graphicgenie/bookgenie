<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company_name' => ['nullable'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'coc' => ['nullable'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email', 'max:254'],
            'invoice_email' => ['nullable', 'email', 'max:254'],
            'invoice_att' => ['nullable'],
            'address' => ['required'],
            'postcode' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
            'type' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
