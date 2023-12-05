<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class uploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'file_name' => ['required'],
            'user_id' => ['required', 'integer'],
            'model_id' => ['required', 'integer'],
            'model_type' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
