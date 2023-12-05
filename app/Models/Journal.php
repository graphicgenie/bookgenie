<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'journal_date'
    ];
}
