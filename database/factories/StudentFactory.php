<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\OtherCriteria;
use App\Models\ParentCompletness;
use App\Models\ParentIncome;
use App\Models\Profile;
use App\Models\Student;
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
            'profile_id' => $this->faker->unique()->randomElement(Profile::pluck('id')->all()),
            'parent_completness_id' => $this->faker->randomElement(ParentCompletness::pluck('id')->all()),
            'parent_income_id' => $this->faker->randomElement(ParentIncome::pluck('id')->all()),
            'other_criteria_id' => $this->faker->randomElement(OtherCriteria::pluck('id')->all()),
            'is_reseller' => Student::IS_NOT_A_RESELLER
        ];
    }
}
