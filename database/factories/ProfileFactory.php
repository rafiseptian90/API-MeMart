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
            'user_id' => $this->faker->unique()->numberBetween(1, User::count()),
            'name' => $this->faker->name,
            'gender' => ['male', 'female'][rand(0, 1)],
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber
        ];
    }
}
