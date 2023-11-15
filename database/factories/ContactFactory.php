<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->name(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'coc' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'invoice_email' => $this->faker->unique()->safeEmail(),
            'invoice_att' => $this->faker->word(),
            'address' => $this->faker->address(),
            'postcode' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'type' => Contact::COMPANY,
            'user_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
