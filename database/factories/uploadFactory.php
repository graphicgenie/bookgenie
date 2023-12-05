<?php

namespace Database\Factories;

use App\Models\upload;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class uploadFactory extends Factory
{
    protected $model = upload::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'file_name' => $this->faker->name(),
            'user_id' => $this->faker->randomNumber(),
            'model_id' => $this->faker->randomNumber(),
            'model_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
