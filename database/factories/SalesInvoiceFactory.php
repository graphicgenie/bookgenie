<?php

namespace Database\Factories;

use App\Models\LedgerAccount;
use App\Models\SalesInvoice;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SalesInvoiceFactory extends Factory
{
    protected $model = SalesInvoice::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'contact_id' => $this->faker->randomNumber(),
            'invoice_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays('14'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
