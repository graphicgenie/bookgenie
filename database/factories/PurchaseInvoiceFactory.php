<?php

namespace Database\Factories;

use App\Models\PurchaseInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PurchaseInvoiceFactory extends Factory
{
    protected $model = PurchaseInvoice::class;

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
