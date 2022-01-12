<?php

namespace Database\Seeders;

use App\Models\ParentIncome;
use Illuminate\Database\Seeder;

class ParentIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = [
            [
                'name' => 'More than Rp 3.000.000',
                'score' => 1,
            ],
            [
                'name' => 'Between Rp 2.000.000 and Rp 3.000.000',
                'score' => 3,
            ],
            [
                'name' => 'Between Rp 1.000.000 and Rp 2.000.000',
                'score' => 5,
            ],
            [
                'name' => 'Less than Rp 1.000.000',
                'score' => 7,
            ],
        ];

        foreach ($criterias as $criteria) {
            ParentIncome::create($criteria);
        }
    }
}
