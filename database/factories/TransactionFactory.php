<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'bank_id' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomFloat(),
            'type' => $this->faker->word(),
            'description' => $this->faker->text(),
            'timestamp' => Carbon::now(),
            'code' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
