<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->randomElement(User::pluck('id')->all()),
            'name' => $this->faker->name,
            'gender' => ['M', 'F'][rand(0, 1)],
            'address' => $this->faker->address,
            'card_number' => rand(1000000000, 3000000000),
            'card_type' => 'nisn',
            'phone_number' => $this->faker->phoneNumber
        ];
    }
}
