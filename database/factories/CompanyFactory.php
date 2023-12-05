<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'postcode' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'vat_number' => $this->faker->randomNumber(),
            'coc_number' => $this->faker->randomNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'type' => $this->faker->word(),
            'iban' => $this->faker->word(),
            'iban_name' => $this->faker->name(),
            'vat_liable' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
