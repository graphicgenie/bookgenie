<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'account_number' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
