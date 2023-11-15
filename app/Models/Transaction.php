<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',
        'amount',
        'type',
        'description',
        'timestamp',
        'code',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];
}
