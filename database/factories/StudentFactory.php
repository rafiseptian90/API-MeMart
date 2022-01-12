<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\OtherCriteria;
use App\Models\ParentCompletness;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'classroom_id' => $this->faker->randomElement(Classroom::pluck('id')->all()),
            'profile_id' => $this->faker->randomElement(Profile::pluck('id')->all()),
            'parent_completness_id' => $this->faker->randomElement(ParentCompletness::pluck('id')->all()),
            'parent_income_id' => $this->faker->randomElement(ParentCompletness::pluck('id')->all()),
            'other_criteria_id' => $this->faker->randomElement(OtherCriteria::pluck('id')->all()),
            'nisn' => rand(1000000000, 5000000000),
            'is_reseller' => rand(0, 1)
        ];
    }
}
