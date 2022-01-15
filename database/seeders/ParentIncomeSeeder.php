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
                'amount' => 'More than Rp 3.000.000',
                'score' => 3,
            ],
            [
                'amount' => 'Between Rp 2.000.000 and Rp 3.000.000',
                'score' => 5,
            ],
            [
                'amount' => 'Between Rp 1.000.000 and Rp 2.000.000',
                'score' => 7,
            ],
            [
                'amount' => 'Less than Rp 1.000.000',
                'score' => 10,
            ],
        ];

        foreach ($criterias as $criteria) {
            ParentIncome::create($criteria);
        }
    }
}
