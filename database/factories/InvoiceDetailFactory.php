<?php

namespace Database\Factories;

use App\Models\InvoiceDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InvoiceDetailFactory extends Factory
{
    protected $model = InvoiceDetail::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'tax_id' => $this->faker->randomNumber(),
            'amount' => 1,
            'price' => $this->faker->randomFloat(2, 10, 250),
            'invoice_id' => $this->faker->randomNumber(),
            'ledger_account_id' => $this->faker->randomNumber(),
            'row_order' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
