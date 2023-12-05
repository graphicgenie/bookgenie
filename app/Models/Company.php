<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'postcode',
        'city',
        'vat_number',
        'coc_number',
        'email',
        'type',
        'iban',
        'iban_name',
        'vat_liable',
    ];
}
