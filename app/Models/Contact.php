<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public const COMPANY = 'company';
    public const PRIVATE_USER = 'private_user';

    protected $fillable = [
        'company_name',
        'firstname',
        'lastname',
        'coc',
        'phone',
        'email',
        'invoice_email',
        'invoice_att',
        'address',
        'postcode',
        'city',
        'country',
        'type',
        'user_id'
    ];
}
